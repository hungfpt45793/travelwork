<?php

namespace App\Http\Controllers\Site;

use App\Entity\Employer;
use App\Entity\Forum_notification;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course\Course_order;
use App\Course\Course_sale_statistical;
use App\Course\Course_statistical_employee;
use App\Course\Courses;
use App\Entity\Employee;
use App\Entity\Employee_coins;
use App\Entity\Employer_sale_statistical;
use App\Entity\Job;
use App\Entity\Job_sale_statistical;
use App\Entity\Post;
use App\Entity\Post_sale_statistical;
use App\Entity\Voucher;
use App\Entity\Voucher_sale_statistical;
use App\Transaction\List_product;
use App\Transaction\Money_month_pay;
use App\Transaction\Transaction_history_bank;
use App\Transaction\Transaction_history_card;
use App\Transaction\Transaction_history_product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Rules\Invateemails;
use App\Mail\Resetpassword;

class EmployeeCointController extends SiteController
{
    public function redeem_rewards()
    {
        if(!Auth::check())
        {
            return redirect(route('employee_register'))->with('mesage_modal','Vui lòng đăng ký thành thành viên để sử dụng chức năng này');
        }
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            if(empty($employee_coints))
            {
                $this->create_employee_coin($employee->employee_id);
                $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            }
            $list_product_model = new List_product();
            $list_products = $list_product_model->select('*')->orderBy('product_id', 'desc')->paginate(12);

            return view('site.money_site.redeem_rewards', compact('employee_coints','list_products'));

        } else {
            return redirect()->back()->with('error', 'Chức năng này chỉ dành cho ứng viên chia sẻ bài viết');
        }
    }

    //lịch sử giao dịch
    public function transaction_history()
    {
        if(!Auth::check())
        {
            return redirect(route('employee_register'))->with('mesage_modal','Vui lòng đăng ký thành thành viên để sử dụng chức năng này');
        }
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            //lish sử giao dich thẻ dt
            $transaction_history_card_model = new Transaction_history_card();
            $transaction_history_card = $transaction_history_card_model->select('*')->where('transaction_employee_id', $employee->employee_id)
                ->orderBy('transaction_card_id', 'desc')
                ->get();
            //lịch sử chuyển khoản
            $transaction_history_bank_model = new Transaction_history_bank();
            $transaction_history_bank = $transaction_history_bank_model->select('*')->where('transaction_employee_id', $employee->employee_id)
                ->orderBy('transaction_bank_id', 'desc')
                ->get();

            $transaction_history_product_model = new Transaction_history_product();
            $transaction_history_product = $transaction_history_product_model->select('*')
                ->where('transaction_employee_id', $employee->employee_id)
                ->orderBy('transaction_id', 'desc')
                ->get();


            return view('site.money_site.transaction_history', compact(  'transaction_history_card', 'transaction_history_bank','transaction_history_product'));
        }
    }
    public function create_employee_coin($employee_id)
    {
        $insert = Employee_coins::insertGetId([
            'employee_id' => $employee_id,
            'coints_status' => 1,
            'created_at' => new \DateTime()
        ]);
        return $insert;
    }

//    danh sách bài viết chia sẻ kiếm tiền
    public function list_post()
    {
        if(!Auth::check())
        {
            return redirect(route('employee_register'))->with('mesage_modal','Vui lòng đăng ký thành thành viên để sử dụng chức năng này');
        }
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();
            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            if(empty($employee_coints))
            {
                $this->create_employee_coin($employee->employee_id);
                $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            }
            $post_model = new Post();
            $list_post = $post_model->select('posts.post_id', 'posts.title', 'posts.slug', 'posts.content', 'posts.image', 'posts.updated_at', 'posts.sale_money', 'posts.updated_at', 'posts.meta_description')
                ->where('sale_money', 1)
                ->where('post_type', 'post')
                ->orderBy('post_id', 'desc')
                ->paginate(20, ['*'], 'page_1s');


            $post_sale_statistical_model = new Post_sale_statistical();
            $list_staticals = $post_sale_statistical_model->select('*');
            $list_staticals = $list_staticals->where('employee_id', $employee_coints->employee_id);
            $list_staticals = $list_staticals->orderBy('total_view_sale', 'desc');
            $list_staticals = $list_staticals->paginate(20, ['*'], 'page_2s');

            return view('site.money_site.list_post', compact('employee_coints', 'list_post','list_staticals'));
        }
    }
    public function list_course()
    {
        if(!Auth::check())
        {
            return redirect(route('employee_register'))->with('mesage_modal','Vui lòng đăng ký thành thành viên để sử dụng chức năng này');
        }
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            if(empty($employee_coints))
            {
                $this->create_employee_coin($employee->employee_id);
                $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            }
            $list_course = Courses::select( 'course_title',
                'course_code',
                'course_id',
                'course_slug',
                'course_image',
                'course_descript',
                'course_content',
                'course_benefit', //Lợi ích khóa học
                'activation_code', // mã kích hoạt khóa học mặc định
                'course_price',
                'course_discount',
                'course_views',
                'created_at',
                'updated_at')
                ->where('course_status',1)
                ->orderBy('course_id','desc')
                ->paginate(20, ['*'], 'page_1s');

            $list_course_static = Course_sale_statistical::select(
                'course_sale_statistical.employee_id',
                'course_sale_statistical.course_id',
                'course_sale_statistical.total_share',
                'course_sale_statistical.total_view_sale',
                'course_sale_statistical.total_money_view',
                'course_sale_statistical.total_coin',
                'courses.course_title',
                'courses.course_code',
                'courses.course_slug'
            )->join('courses', 'courses.course_id', 'course_sale_statistical.course_id')
                ->where('course_sale_statistical.employee_id', $employee_coints->employee_id)
                ->paginate(20, ['*'], 'page_2s');


            $list_course_order = Course_order::select(
                'course_order.course_cost',  //giá của khóa học
                'course_order.course_order_status', //trạng thái thanh toán của khóa hoc: 0 là chưa, 1 đã thanh toán
                'course_order.admin_id',
                'course_order.employee_id', //ung vien chia se bai viet
                'course_order.admin_messager',
                'course_order.activation_code',  //mã kích hoạt
                'course_order.activation_code_status', //trạng thái mã kích hoạt 0 là chưa 1 là đã sử dụng
                'course_order.course_name',
                'course_order.course_phone',
                'course_order.course_email',
                'courses.course_title',
                'courses.course_code',
                'courses.course_slug'
            )->join('courses', 'courses.course_id', 'course_order.course_id')
                ->where('course_order.employee_id', $employee->employee_id)
                ->paginate(20, ['*'], 'page_3s');

            $sum_total = Course_statistical_employee::where('employee_id',$employee->employee_id)->sum('course_money_order');
            $total_order = Course_statistical_employee::where('employee_id',$employee->employee_id)->count();

//            echo '<pre>';
//            print_r($list_course);die;
            return view('site.money_site.list_course', compact('employee_coints', 'list_course','list_course_static','list_course_order','sum_total','total_order'));
        }
    }
    public function list_voucher()
    {
        if(!Auth::check())
        {
            return redirect(route('employee_register'))->with('mesage_modal','Vui lòng đăng ký thành thành viên để sử dụng chức năng này');
        }
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            if(empty($employee_coints))
            {
                $this->create_employee_coin($employee->employee_id);
                $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            }

            $list_voucher = Voucher::select(
                'name_voucher',
                'id_voucher',
                'slug_voucher',
                'des_voucher',
                'image_voucher',
                'content_voucher',
                'sale_money',
                'created_at',
                'updated_at')
                ->orderBy('id_voucher','desc')
                ->where('sale_money',1)
                ->paginate(20, ['*'], 'page_1s');

            $list_voucher_static = Voucher_sale_statistical::select(
                'voucher_sale_statistical.employee_id',
                'voucher_sale_statistical.voucher_id',
                'voucher_sale_statistical.total_share',
                'voucher_sale_statistical.total_view_sale',
                'voucher_sale_statistical.total_money_view',
                'voucher_sale_statistical.total_coin',
                'voucher.name_voucher',
                'voucher.slug_voucher',
                'voucher.id_voucher'
            )->join('voucher', 'voucher.id_voucher', 'voucher_sale_statistical.voucher_id')
                ->where('voucher_sale_statistical.employee_id', $employee_coints->employee_id)
                ->where('voucher.sale_money', 1)
                ->paginate(20, ['*'], 'page_2s');
            return view('site.money_site.list_voucher', compact('employee', 'employee_coints', 'list_voucher','list_voucher_static'));
        }
    }
    public function list_job()
    {
        if(!Auth::check())
        {
            return redirect(route('employee_register'))->with('mesage_modal','Vui lòng đăng ký thành thành viên để sử dụng chức năng này');
        }
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            if(empty($employee_coints))
            {
                $this->create_employee_coin($employee->employee_id);
                $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            }

            $jobModel = new Job();
            $list_jobs = $jobModel
                ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->select(
                    'jobs.title', 'jobs.sale_money', 'jobs.job_id', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                    'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province', 'jobs.active_job'
                );
            $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
            $list_jobs = $list_jobs->where('jobs.active_job', 1);
            $list_jobs = $list_jobs->where('jobs.sale_money', 1);
            $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
            $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
            //tong so bai viet
            $total_jobs = $list_jobs->count();
            $list_jobs = $list_jobs->paginate(20, ['*'], 'page_1s');
//        luu url khi phan trang
            $list_jobs->appends(request()->query());

            $post_sale_statistical_model = new Job_sale_statistical();
            $list_staticals = $post_sale_statistical_model->select('*');
            $list_staticals = $list_staticals->where('employee_id', $employee_coints->employee_id);
            $list_staticals = $list_staticals->orderBy('total_view_sale', 'desc');
            $list_staticals = $list_staticals->paginate(20, ['*'], 'page_2s');

            return view('site.money_site.list_job', compact( 'employee_coints', 'list_jobs','list_staticals'));
        }
    }
    public function list_intership()
    {
        if(!Auth::check())
        {
            return redirect(route('employee_register'))->with('mesage_modal','Vui lòng đăng ký thành thành viên để sử dụng chức năng này');
        }
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            if(empty($employee_coints))
            {
                $this->create_employee_coin($employee->employee_id);
                $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            }

            $employer = new Employer();

            $employers = $employer->select('employer_id', 'email', 'phone', 'view', 'status_allowance', 'image', 'province', 'district', 'enterprise_name', 'status_intership', 'slug', 'banner_intership', 'type_of_business_id', 'business', 'website','created_at',
                'updated_at');
            $employers = $employers->where('status_intership', 1);
            $employers = $employers->orderBy('employer_id', 'desc');
            $list_employers = $employers->paginate(20, ['*'], 'page_1s');


            $post_sale_statistical_model = new Employer_sale_statistical();
            $list_staticals = $post_sale_statistical_model->select('employer_sale_statistical.statis_id',
                'employer_sale_statistical.employee_id',
                'employer_sale_statistical.employer_id',
                'employer_sale_statistical.total_share',
                'employer_sale_statistical.total_view_sale',
                'employer_sale_statistical.total_money_view',
                'employer_sale_statistical.total_coin',
                'employer_sale_statistical.created_at');
            $list_staticals = $list_staticals->where('employee_id', $employee_coints->employee_id);
            $list_staticals = $list_staticals->orderBy('total_view_sale', 'desc');
            $list_staticals = $list_staticals->paginate(20, ['*'], 'page_2s');

//            echo '<pre>';
//            print_r($list_employers);die;

            return view('site.money_site.list_intership', compact( 'employee_coints', 'list_employers','list_staticals'));
        }
    }
//    hiển thị giao diện đổi thẻ cào
    public function change_card(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();
            if ($this->check_change_card_bank($employee->employee_id) == false) {
                return redirect()->back()->with('error', 'Số lần đổi thẻ cào của bạn trong tháng đã hết vui lòng đổi vào tháng sau !');
            }
            $transaction_history_card_model = new Transaction_history_card();
            $transaction_history_card = $transaction_history_card_model->select('*')
                ->where('transaction_employee_id', $employee->employee_id)
                ->orderBy('transaction_card_id', 'desc')
                ->get();

            $transaction_card = $transaction_history_card_model->select('*')
                ->where('transaction_employee_id', $employee->employee_id)
                ->orderBy('transaction_card_id', 'desc')
                ->limit(1)
                ->first();

            if (empty($user->user_coin)) {
                return redirect()->back()->with('error', 'Tài khoản của bạn không còn xu');
            }
            return view('site.employee.chang_card', compact('employee', 'employee_coints', 'transaction_history_card', 'transaction_card'));


        } else {
            return redirect()->back()->with('error', 'Chức năng này chỉ dành cho ứng viên chia sẻ bài viết');
        }
    }
    //    hiển thị giao diện đổi chuyển tiền
    public function change_account(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();
            if ($this->check_change_card_bank($employee->employee_id) == false) {
                return redirect()->back()->with('error', 'Số lần chuyển khoản của bạn trong tháng đã hết vui lòng chuyển khoản vào tháng sau !');
            }


            $transaction_history_bank_model = new Transaction_history_bank();
            $transaction_history_bank = $transaction_history_bank_model->select('*')->where('transaction_employee_id', $employee->employee_id)->orderBy('transaction_bank_id', 'desc')->get();

            $transaction_bank = $transaction_history_bank_model->select('*')->where('transaction_employee_id', $employee->employee_id)->orderBy('transaction_bank_id', 'desc')->limit(1)->first();
            if (empty($user->user_coin)) {
                return redirect()->back()->with('error', 'Tài khoản của bạn không còn xu');
            }
            return view('site.employee.change_account', compact('employee', 'employee_coints', 'transaction_history_bank', 'transaction_bank'));

        } else {
            return redirect()->back()->with('error', 'Chức năng này chỉ dành cho ứng viên chia sẻ bài viết');
        }
    }

    //    hiển thị giao diện đổi sản phẩm phần mềm kế toán
    public function change_software()
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            if(empty($employee_coints))
            {
                $this->create_employee_coin($employee->employee_id);
                $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            }
            $list_product_model = new List_product();
            $list_products = $list_product_model->select('*')->orderBy('product_id', 'desc')->paginate(12);

            $transaction_history_product_model = new Transaction_history_product();
            $transaction_history_product = $transaction_history_product_model->select('*')
                ->where('transaction_employee_id', $employee->employee_id)
                ->get();
            return view('site.employee.change_software', compact('employee', 'employee_coints', 'list_products', 'transaction_history_product'));

        } else {
            return redirect()->back()->with('error', 'Chức năng này chỉ dành cho ứng viên chia sẻ bài viết');
        }
    }

    //hiển thị trang chi tiết đổi sản phẩm phần mềm
    public function change_software_slug($slug)
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            if(empty($employee_coints))
            {
                $this->create_employee_coin($employee->employee_id);
                $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();
            }


            $list_product_model = new List_product();
            $product = $list_product_model->select('*')->where('product_slug', $slug)->first();

            $transaction_history_product_model = new Transaction_history_product();
            $transaction_history_product = $transaction_history_product_model->select('*')->where('transaction_employee_id', $employee_coints->employee_id)->orderBy('transaction_id', 'desc')->get();

            if (empty($employee_coints->money)) {
                return redirect()->back()->with('error', 'Tài khoản của bạn không còn tiền');
            }
            return redirect()->back()->with('success', 'Yêu cầu của bạn đã được gửi đến quản trị viên, Vui lòng chờ xét duyệt');
        } else {
            return redirect()->back()->with('error', 'Yêu cầu đổi thưởng của bạn thất bại , Vùi lòng thử lại sau');
        }

    }

    //tiến hành đổi thẻ cào
    public function update_change_card(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->role == 1) {
                $employee_model = new Employee();
                $employee = $employee_model->select('employee_id', 'user_id')
                    ->where('user_id', $user->id)
                    ->first();

                $card = $request->input('transaction_card_price');
                $card_coin = $card / 1000;
                if ($user->user_coin > $card_coin) {
                    DB::beginTransaction();
                    $transaction_history_card_model = new Transaction_history_card();
                    $insert_id = $transaction_history_card_model->insertGetId([
                        'transaction_employee_id' => $employee->employee_id,
                        'transaction_card_name' => $request->input('transaction_card_name'),
                        'transaction_card_price' => $request->input('transaction_card_price'),
                        'transaction_card_phone' => $request->input('transaction_card_phone'),
                        'transaction_content' => $request->input('transaction_content'),
                        'transaction_total_coin' => $card_coin,
                        'transaction_status' => 0,
                        'created_at' => new \DateTime(),
                    ]);
                    //tiến hành trừ xu trong tài khoản
                    $update_coin = User::where('id',$user->id)->update([
                        'user_coin' => $user->user_coin - $card_coin
                    ]);

                    $noti_title = 'Bạn đã đổi ' .$card_coin. ' xu bằng cách đổi thẻ cào trên sanketoan.vn';
                    $forum_noti = Forum_notification::insert([
                        'noti_title' => $noti_title,
                        'for_post_id'=>0, //mã bài viết
                        'for_comment_id'=>0,
                        'user_id' =>$user->id, //user id nhận thông báo
                        'user_id_comment'=>0, //user người bình luận
                        'noti_type'=>'user_pro', //kiểu thông báo comment=>là thông báo bình luận về bài viết , post_coin=>là thông báo về bài viết mất 1 xu ,comment_coin=>là thông báo về bình luận tặng xu,  user_pro=>tặng xu khi đăng ký tài khoản pro,
                        'noti_status' => 0, //trạng thái thông báo 0 là chưa xem 1 đã xem
                        'created_at' => new \DateTime()
                    ]);



                    $money_month_pay_model = new Money_month_pay();
                    $money_month_pay = $money_month_pay_model->select('*')
                        ->whereMonth('money_month_year', date('m'))
                        ->whereYear('money_month_year', date('Y'))
                        ->first();

                    if (!empty($money_month_pay->money_surplus) && $money_month_pay->money_surplus > $request->input('transaction_card_price')) {
                        $money_surplus = $money_month_pay->money_surplus - $request->input('transaction_card_price');
                        $update_month_pay = $money_month_pay_model->whereMonth('money_month_year', date('m'))
                            ->whereYear('money_month_year', date('Y'))
                            ->update([
                                'money_surplus' => $money_surplus,
                                'updated_at' => new \DateTime(),
                            ]);
                        DB::commit();
                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('error','Lượng tiền còn lại trong tháng đã hết');
                    }
                }
                return redirect()->back()->with('success', 'Bạn đã gửi yêu cầu đổi thẻ thành công ! Vui lòng chờ quản trị xét duyệt');
            }

        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('status_card', 'Bạn đã gửi yêu cầu đổi thẻ thất bại ! Vui lòng thử lại');
        }

    }

    //tiến hành chuyển khoản
    public function update_change_account(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->role == 1) {
                $employee_model = new Employee();
                $employee = $employee_model->select('employee_id', 'user_id')
                    ->where('user_id', $user->id)
                    ->first();
                $card_number = $request->input('transaction_bank_price');
                $card_number = str_replace(".", "", $card_number);
                $card_number_coin = $card_number / 1000;
//                echo $card_number;die();
                if ($user->user_coin > $card_number_coin) {
                    DB::beginTransaction();
                    $transaction_history_bank_model = new Transaction_history_bank();
                    $insert_id = $transaction_history_bank_model->insertGetId([
                        'transaction_employee_id' => $employee->employee_id,
                        'transaction_bank_name' => $request->input('transaction_bank_name'),
                        'transaction_bank_price' => $card_number,
                        'transaction_bank_number' => $request->input('transaction_bank_number'),
                        'transaction_home_name' => $request->input('transaction_home_name'),
                        'transaction_content' => $request->input('transaction_content'),
                        'transaction_total_coin' => $card_number_coin,
                        'transaction_status' => 0,
                        'created_at' => new \DateTime(),
                    ]);

                    $update_coin = User::where('id',$user->id)->update([
                        'user_coin' => $user->user_coin - $card_number_coin
                    ]);
                    $noti_title = 'Bạn đã đổi ' .$card_number_coin. ' xu bằng cách chuyển khoản trên sanketoan.vn';
                    $forum_noti = Forum_notification::insert([
                        'noti_title' => $noti_title,
                        'for_post_id'=>0, //mã bài viết
                        'for_comment_id'=>0,
                        'user_id' =>$user->id, //user id nhận thông báo
                        'user_id_comment'=>0, //user người bình luận
                        'noti_type'=>'user_pro', //kiểu thông báo comment=>là thông báo bình luận về bài viết , post_coin=>là thông báo về bài viết mất 1 xu ,comment_coin=>là thông báo về bình luận tặng xu,  user_pro=>tặng xu khi đăng ký tài khoản pro,
                        'noti_status' => 0, //trạng thái thông báo 0 là chưa xem 1 đã xem
                        'created_at' => new \DateTime()
                    ]);

                    $money_month_pay_model = new Money_month_pay();
                    $money_month_pay = $money_month_pay_model->select('*')
                        ->whereMonth('money_month_year', date('m'))
                        ->whereYear('money_month_year', date('Y'))
                        ->first();

                    if (!empty($money_month_pay->money_surplus) && $money_month_pay->money_surplus > $card_number) {
                        $money_surplus = $money_month_pay->money_surplus - $card_number;
                        $update_month_pay = $money_month_pay_model->whereMonth('money_month_year', date('m'))
                            ->whereYear('money_month_year', date('Y'))
                            ->update([
                                'money_surplus' => $money_surplus,
                                'updated_at' => new \DateTime(),
                            ]);
                        DB::commit();
                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('error','Lượng tiền còn lại trong tháng đã hết');
                    }
                }
                return redirect()->back()->with('success', 'Bạn đã gửi yêu cầu rút tiền thành công ! Vui lòng chờ quản trị xét duyệt');
            }

        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Bạn đã gửi yêu cầu rút tiền thất bại ! Vui lòng thử lại');
        }

    }

    //tiến hành đổi phần mềm
    public function update_change_software(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->role == 1) {
                $employee_model = new Employee();
                $employee = $employee_model->select('employee_id', 'user_id')
                    ->where('user_id', $user->id)
                    ->first();


                $list_product_model = new List_product();
                $product = $list_product_model->select('*')->where('product_id', $request->input('product_id'))->first();
                if (empty($product)) {
                    return redirect()->back()->with('status_card', 'Bạn đã gửi yêu cầu phần mềm thất bại ! Vui lòng thử lại');
                }
//                echo $card_number;die();
                $price = 0;
                if (!empty($product->product_discount)) {
                    $price = $product->product_discount;
                } else {
                    $price = $product->product_price;
                }
                $price_coin = $product->product_price/1000;

                if($user->user_coin < $price_coin)
                {
                    return redirect()->back()->with('error', 'Số dư của của bạn không đủ đổi '.$product->product_name);
                }
                if ($user->user_coin > $price_coin) {
                    DB::beginTransaction();
                    $transaction_history_product_model = new Transaction_history_product();
                    $insert_id = $transaction_history_product_model->insertGetId([
                        'transaction_employee_id' => $employee->employee_id,
                        'transaction_product_name' => $product->product_name,
                        'transaction_product_price' => $price,
                        'transaction_product_id' => $product->product_id,
                        'transaction_content' => $request->input('transaction_content'),
                        'transaction_status' => 0,
                        'created_at' => new \DateTime(),
                    ]);

                    $update_coin = User::where('id',$user->id)->update([
                        'user_coin' => $user->user_coin - $price_coin
                    ]);
                    $noti_title = 'Bạn đã đổi ' .$price_coin. ' xu bằng cách đổi qua phần mềm trên sanketoan.vn';
                    $forum_noti = Forum_notification::insert([
                        'noti_title' => $noti_title,
                        'for_post_id'=>0, //mã bài viết
                        'for_comment_id'=>0,
                        'user_id' =>$user->id, //user id nhận thông báo
                        'user_id_comment'=>0, //user người bình luận
                        'noti_type'=>'user_pro', //kiểu thông báo comment=>là thông báo bình luận về bài viết , post_coin=>là thông báo về bài viết mất 1 xu ,comment_coin=>là thông báo về bình luận tặng xu,  user_pro=>tặng xu khi đăng ký tài khoản pro,
                        'noti_status' => 0, //trạng thái thông báo 0 là chưa xem 1 đã xem
                        'created_at' => new \DateTime()
                    ]);


                    DB::commit();
                }
                return redirect()->back()->with('success', 'Bạn đã gửi yêu cầu đổi phần mềm thành công ! Vui lòng chờ quản trị xét duyệt');
            }

        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Bạn đã gửi yêu cầu phần mềm thất bại ! Vui lòng thử lại');
        }

    }

    //kiểm tra xem trong tháng ứng viên đã đổi chưa nếu đổi rồi thì không được đổi nữa
    private function check_change_card_bank($employee_id)
    {
        $month = date('m');
        $year = date('Y');
        $transaction_history_card_model = new Transaction_history_card();
        $transaction_history_card = $transaction_history_card_model->select('transaction_card_id', 'created_at')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->whereYear('transaction_employee_id', $employee_id)
            ->count();
        $transaction_history_bank_model = new Transaction_history_bank();
        $transaction_history_bank = $transaction_history_bank_model->select('transaction_bank_id', 'created_at')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->whereYear('transaction_employee_id', $employee_id)
            ->count();
        $total = 0;
        $total = $transaction_history_card + $transaction_history_bank;
        if ($total > 3) {
            return false;
        }
        return true;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
