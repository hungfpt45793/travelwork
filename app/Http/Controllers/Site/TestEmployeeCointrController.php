<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Course\Course;
use App\Course\Course_order;
use App\Course\Course_sale_statistical;
use App\Course\Course_statistical_employee;
use App\Course\Courses;
use App\Entity\Employee;
use App\Entity\Employee_coins;
use App\Entity\Employee_experience;
use App\Entity\Employee_specialize;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Employees_save_job_facebook;
use App\Entity\Employer;
use App\Entity\EmployerIntership;
use App\Entity\HistoryWork;
use App\Entity\Job;
use App\Entity\Job_sale_money;
use App\Entity\Job_sale_statistical;
use App\Entity\JobFacebook;
use App\Entity\JobFacebookWarning;
use App\Entity\JobGroup;
use App\Entity\Order;
use App\Entity\Post;
use App\Entity\Post_sale_money;
use App\Entity\Post_sale_statistical;
use App\Entity\Salary;
use App\Entity\SettingGetfly;
use App\Entity\Statistical_employees;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_job_group;
use App\Entity\Teacher_save_job_facebook;
use App\Entity\Teacher_specialize;
use App\Entity\User;
use App\Entity\District;
use App\Entity\Voucher;
use App\Entity\Voucher_sale_statistical;
use App\Entity\Workplace;
use App\Exam\Questions;
use App\Exam\Result_job_exam;
use App\Transaction\List_product;
use App\Transaction\Money_month_pay;
use App\Transaction\Transaction_history_bank;
use App\Transaction\Transaction_history_card;
use App\Transaction\Transaction_history_product;
use App\Ultility\CallApi;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Prophecy\Call\Call;
use App\Rules\Invateemails;
use Illuminate\Support\Facades\Validator;
use App\Mail\Resetpassword;
use Illuminate\Support\Facades\URL;
use function Sodium\compare;


class EmployeeCointsController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!Auth::check()) {
                return redirect(route('list_job_face'))->with('error_login_money', 'Vui lòng dăng nhập để sử dụng chức năng này !');
            }
            $this->id_user = Auth::user()->id;
            $ckeditor = new CkedittorController();
            $session_image = $ckeditor->checkImage();
            return $next($request);
        });
    }

//check quyền ung vien
    private function checkRoleUserEmployee()
    {
        $role = Auth::user()->role;
        if ($role == 1) {
            return true;
        } else {
            return false;
        }
    }

//    thống kê chia sẻ bài viết
    public function post_sale_employee(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $day_date = new \DateTime();
            $post_sale_model = new Post_sale_money();
            $view_sale_day = $post_sale_model->select('*')
                ->where('employee_id', $employee->employee_id)
                ->whereDay('date_sale', date_format($day_date, "d"))
                ->count();
            $view_sale_month = $post_sale_model->select('*');
            $view_sale_month = $view_sale_month->where('employee_id', $employee->employee_id);

            $view_sale_month = $view_sale_month->whereMonth('date_sale', date_format($day_date, "m"));
            $view_sale_month = $view_sale_month->whereYear('date_sale', date_format($day_date, "Y"));

            $view_sale_month = $view_sale_month->count();

            $post_sale_statistical_model = new Post_sale_statistical();
            $list_statical = $post_sale_statistical_model->select('*')
                ->where('employee_id', $employee->employee_id)
                ->orderBy('total_view_sale', 'desc')
                ->limit(10)
                ->get();
//            echo '<pre>';
//            print_r($list_statical);die();
            if (!empty($request->input('start_month_year'))) {
                $start_month_year = $request->input('start_month_year');
            }
            $list_staticals = $post_sale_statistical_model->select('*');
            $list_staticals = $list_staticals->where('employee_id', $employee->employee_id);
            $list_staticals = $list_staticals->orderBy('total_view_sale', 'desc');
            $list_staticals = $list_staticals->paginate(20);
//            print_R($list_statical);die();
            $employee_coins_model = new Employee_coins();
            $employee_coints = $employee_coins_model->select('*')
                ->where('employee_id', $employee->employee_id)
                ->first();
//            print_r($employee_coints);die();
            //tông số xu của ứng viênpost_sale_employee
            return view('site.employee.statistical_sale', compact('view_sale_day', 'view_sale_month', 'list_statical', 'list_staticals', 'employee_coints'));
        } else {
            return redirect()->back()->with('error', 'Chức năng này chỉ dành cho ứng viên chia sẻ bài viết');
        }

    }

    //    thống kê chia sẻ khoa học
    public function course_sale_employee(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $list_course = Course_sale_statistical::select(
                'course_sale_statistical.employee_id',
                'course_sale_statistical.course_id',
                'course_sale_statistical.total_share',
                'course_sale_statistical.total_view_sale',
                'course_sale_statistical.total_money_view',
                'courses.course_title',
                'courses.course_code',
                'courses.course_slug'
            )->join('courses', 'courses.course_id', 'course_sale_statistical.course_id')
                ->where('course_sale_statistical.employee_id', $employee->employee_id)
                ->paginate(20);
            $employee_coint = Employee_coins::select('*')
                ->where('employee_id', $employee->employee_id)
                ->first();
            return view('site.employee.statistical_sale_course', compact('list_course','employee_coint'));
        } else {
            return redirect()->back()->with('error', 'Chức năng này chỉ dành cho ứng viên chia sẻ bài viết');
        }

    }
    //đơn hàng khóa học đã giới thiệu
    public function list_course_order(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();
            $employee_coint = Employee_coins::select('*')
                ->where('employee_id', $employee->employee_id)
                ->first();

            $list_course = Course_order::select(
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
                ->paginate(20);

            $sum_total = Course_statistical_employee::where('employee_id',$employee->employee_id)->sum('course_money_order');
            $total_order = Course_statistical_employee::where('employee_id',$employee->employee_id)->count();
            return view('site.employee.list_course_order', compact('list_course','employee_coint','sum_total','total_order'));
        } else {
            return redirect()->back()->with('error', 'Chức năng này chỉ dành cho ứng viên chia sẻ bài viết');
        }
    }
    //    thống kê chia sẻ tài liệu
    public function voucher_sale_employee(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $list_voucher = Voucher_sale_statistical::select(
                'voucher_sale_statistical.employee_id',
                'voucher_sale_statistical.voucher_id',
                'voucher_sale_statistical.total_share',
                'voucher_sale_statistical.total_view_sale',
                'voucher_sale_statistical.total_money_view',
                'voucher.name_voucher',
                'voucher.slug_voucher',
                'voucher.id_voucher'
            )->join('voucher', 'voucher.id_voucher', 'voucher_sale_statistical.voucher_id')
                ->where('voucher_sale_statistical.employee_id', $employee->employee_id)
                ->where('voucher.sale_money', 1)
                ->paginate(20);
            $employee_coint = Employee_coins::select('*')
                ->where('employee_id', $employee->employee_id)
                ->first();
            return view('site.employee.statistical_sale_voucher', compact('list_voucher','employee_coint'));
        } else {
            return redirect()->back()->with('error', 'Chức năng này chỉ dành cho ứng viên chia sẻ bài viết');
        }

    }

    //    thống kê chia sẻ tin tuyển dụng
    public function job_sale_employee(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $day_date = new \DateTime();
            $post_sale_model = new Job_sale_money();
            $view_sale_day = $post_sale_model->select('*')
                ->where('employee_id', $employee->employee_id)
                ->whereDay('date_sale', date_format($day_date, "d"))
                ->count();
            $view_sale_month = $post_sale_model->select('*');
            $view_sale_month = $view_sale_month->where('employee_id', $employee->employee_id);

            $view_sale_month = $view_sale_month->whereMonth('date_sale', date_format($day_date, "m"));
            $view_sale_month = $view_sale_month->whereYear('date_sale', date_format($day_date, "Y"));

            $view_sale_month = $view_sale_month->count();

            $post_sale_statistical_model = new Job_sale_statistical();
            $list_statical = $post_sale_statistical_model->select('*')
                ->where('employee_id', $employee->employee_id)
                ->orderBy('total_view_sale', 'desc')
                ->limit(10)
                ->get();
//            echo '<pre>';
//            print_r($list_statical);die();
            if (!empty($request->input('start_month_year'))) {
                $start_month_year = $request->input('start_month_year');
            }
            $list_staticals = $post_sale_statistical_model->select('*');
            $list_staticals = $list_staticals->where('employee_id', $employee->employee_id);
            $list_staticals = $list_staticals->orderBy('total_view_sale', 'desc');
            $list_staticals = $list_staticals->paginate(20);
//            print_R($list_statical);die();
            $employee_coins_model = new Employee_coins();
            $employee_coints = $employee_coins_model->select('*')
                ->where('employee_id', $employee->employee_id)
                ->first();
//            echo '<pre>';
//            print_r($list_staticals);die();
            //tông số xu của ứng viênpost_sale_employee
            return view('site.employee.statistical_sale_job', compact('view_sale_day', 'view_sale_month', 'list_statical', 'list_staticals', 'employee_coints'));
        } else {
            return redirect()->back()->with('error', 'Chức năng này chỉ dành cho ứng viên chia sẻ bài viết');
        }

    }

    public function redeem_rewards()
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();

            return view('site.employee.redeem_rewards', compact('employee', 'employee_coints'));

        } else {
            return redirect()->back()->with('error', 'Chức năng này chỉ dành cho ứng viên chia sẻ bài viết');
        }
    }

    //lịch sử giao dịch
    public function transaction_history()
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();

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
            //lich sử đổi phần mềm
            $transaction_history_product_model = new Transaction_history_product();
            $transaction_history_product = $transaction_history_product_model->select('*')->where('transaction_employee_id', $employee->employee_id)
                ->orderBy('transaction_id', 'desc')
                ->get();
            return view('site.employee.transaction_history', compact('employee', 'employee_coints', 'transaction_history_card', 'transaction_history_bank', 'transaction_history_product'));
        }
    }

//    danh sách bài viết chia sẻ kiếm tiền
    public function list_post()
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();

            $post_model = new Post();
            $list_post_new = $post_model->select('posts.post_id', 'posts.title', 'posts.slug', 'posts.content', 'posts.image', 'posts.updated_at', 'posts.sale_money', 'posts.updated_at', 'posts.meta_description')
                ->where('sale_money', 1)
                ->orderBy('post_id', 'desc')
                ->paginate(10);

            $list_post = $post_model->select('posts.post_id', 'posts.title', 'posts.slug', 'posts.content', 'posts.image', 'posts.updated_at', 'posts.sale_money', 'posts.updated_at', 'posts.meta_description')
                ->where('sale_money', 1)
                ->orderBy('post_id', 'asc')
                ->limit(18)->get();

            return view('site.employee.list_post', compact('employee', 'employee_coints', 'list_post_new', 'list_post'));
        }
    }
    //    danh sách khóa học chia se kiếm tiền
    public function list_course()
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();

            $list_course = Courses::select( 'course_title',
                'course_code',
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
                ->orderBy('course_id','desc')
                ->paginate(20);

            return view('site.employee.list_course', compact('employee', 'employee_coints', 'list_course'));
        }
    }
    public function list_voucher()
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();

            $list_voucher = Voucher::select(
                'name_voucher',
                'slug_voucher',
                'des_voucher',
                'image_voucher',
                'content_voucher',
                'sale_money',
                'created_at',
                'updated_at')
                ->orderBy('id_voucher','desc')
                ->where('sale_money',1)
                ->paginate(20);

            return view('site.employee.list_voucher', compact('employee', 'employee_coints', 'list_voucher'));
        }
    }

    public function list_job()
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id')
                ->where('user_id', $user->id)
                ->first();

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();


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
            $list_jobs = $list_jobs->paginate(20);
//        luu url khi phan trang
            $list_jobs->appends(request()->query());

            $list_jobs_new = $jobModel
                ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->select(
                    'jobs.title', 'jobs.sale_money', 'jobs.job_id', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                    'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province', 'jobs.active_job'
                );
            $list_jobs_new = $list_jobs_new->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
            $list_jobs_new = $list_jobs_new->where('jobs.active_job', 1);
            $list_jobs_new = $list_jobs_new->where('jobs.sale_money', 1);
            $list_jobs_new = $list_jobs_new->orderBy('jobs.job_id', 'desc');
            //tong so bai viet
            $list_jobs_new = $list_jobs_new->limit(10)->get();

            return view('site.employee.list_job', compact('employee', 'employee_coints', 'list_jobs', 'list_jobs_new'));
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

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();


            $transaction_history_card_model = new Transaction_history_card();
            $transaction_history_card = $transaction_history_card_model->select('*')->where('transaction_employee_id', $employee->employee_id)->orderBy('transaction_card_id', 'desc')->get();

            $transaction_card = $transaction_history_card_model->select('*')->where('transaction_employee_id', $employee->employee_id)->orderBy('transaction_card_id', 'desc')->limit(1)->first();

            if (empty($employee_coints->money)) {
                return redirect()->back()->with('error', 'Tài khoản của bạn không còn tiền');
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

            $employee_coints_model = new Employee_coins();
            $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();


            $transaction_history_bank_model = new Transaction_history_bank();
            $transaction_history_bank = $transaction_history_bank_model->select('*')->where('transaction_employee_id', $employee->employee_id)->orderBy('transaction_bank_id', 'desc')->get();

            $transaction_bank = $transaction_history_bank_model->select('*')->where('transaction_employee_id', $employee->employee_id)->orderBy('transaction_bank_id', 'desc')->limit(1)->first();
            if (empty($employee_coints->money)) {
                return redirect()->back()->with('error', 'Tài khoản của bạn không còn tiền');
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


            $list_product_model = new List_product();
            $product = $list_product_model->select('*')->where('product_slug', $slug)->first();

            $transaction_history_product_model = new Transaction_history_product();
            $transaction_history_product = $transaction_history_product_model->select('*')->where('transaction_employee_id', $employee->employee_id)->orderBy('transaction_id', 'desc')->get();

            if (empty($employee_coints->money)) {
                return redirect()->back()->with('error', 'Tài khoản của bạn không còn tiền');
            }

            return view('site.employee.change_software_slug', compact('employee', 'employee_coints', 'product', 'transaction_history_product'));

        } else {
            return redirect()->back()->with('error', 'Chức năng này chỉ dành cho ứng viên chia sẻ bài viết');
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
                $employee_coints_model = new Employee_coins();
                $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();

                $card = $request->input('transaction_card_price');
                if ($employee_coints->money > $card) {
                    DB::beginTransaction();
                    $transaction_history_card_model = new Transaction_history_card();
                    $insert_id = $transaction_history_card_model->insertGetId([
                        'transaction_employee_id' => $employee->employee_id,
                        'transaction_card_name' => $request->input('transaction_card_name'),
                        'transaction_card_price' => $request->input('transaction_card_price'),
                        'transaction_card_phone' => $request->input('transaction_card_phone'),
                        'transaction_content' => $request->input('transaction_content'),
                        'transaction_status' => 0,
                        'created_at' => new \DateTime(),
                    ]);
                    $money = $employee_coints->money - $request->input('transaction_card_price');
                    $total_change_crad = $employee_coints->total_change_crad + $request->input('transaction_card_price');

                    $update = $employee_coints_model->where('employee_id', $employee->employee_id)->update([
                        'money' => $money,
                        'total_change_crad' => $total_change_crad,
                        'updated_at' => new \DateTime(),
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
                        return redirect()->back()->with('Lượng tiền còn lại trong tháng đã hết');
                    }

                }
                return redirect()->back()->with('status_card', 'Bạn đã gửi yêu cầu đổi thẻ thành công ! Vui lòng chờ quản trị xét duyệt');
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

                $employee_coints_model = new Employee_coins();
                $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();

                $card_number = $request->input('transaction_bank_price');
                $card_number = str_replace(".", "", $card_number);
//                echo $card_number;die();
                if ($employee_coints->money > $card_number) {
                    DB::beginTransaction();
                    $transaction_history_bank_model = new Transaction_history_bank();
                    $insert_id = $transaction_history_bank_model->insertGetId([
                        'transaction_employee_id' => $employee->employee_id,
                        'transaction_bank_name' => $request->input('transaction_bank_name'),
                        'transaction_bank_price' => $card_number,
                        'transaction_bank_number' => $request->input('transaction_bank_number'),
                        'transaction_home_name' => $request->input('transaction_home_name'),
                        'transaction_content' => $request->input('transaction_content'),
                        'transaction_status' => 0,
                        'created_at' => new \DateTime(),
                    ]);
                    $money = $employee_coints->money - $card_number;
                    $total_change_bank = $employee_coints->total_change_bank + $card_number;
                    $update = $employee_coints_model->where('employee_id', $employee->employee_id)->update([
                        'money' => $money,
                        'total_change_bank' => $total_change_bank,
                        'updated_at' => new \DateTime(),
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
                        return redirect()->back()->with('Lượng tiền còn lại trong tháng đã hết');
                    }
                }
                return redirect()->back()->with('status_card', 'Bạn đã gửi yêu cầu rút tiền thành công ! Vui lòng chờ quản trị xét duyệt');
            }

        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('status_card', 'Bạn đã gửi yêu cầu rút tiền thất bại ! Vui lòng thử lại');
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

                $employee_coints_model = new Employee_coins();
                $employee_coints = $employee_coints_model->select('*')->where('employee_id', $employee->employee_id)->first();


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
                if ($employee_coints->money > $price) {
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
                    $money = $employee_coints->money - $price;
                    $total_change_product = $employee_coints->total_change_product + $price;

                    $update = $employee_coints_model->where('employee_id', $employee->employee_id)->update([
                        'money' => $money,
                        'total_change_product' => $total_change_product,
                        'updated_at' => new \DateTime(),
                    ]);
                    DB::commit();
                }
                return redirect()->back()->with('status_card', 'Bạn đã gửi yêu cầu đổi phần mềm thành công ! Vui lòng chờ quản trị xét duyệt');
            }

        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('status_card', 'Bạn đã gửi yêu cầu phần mềm thất bại ! Vui lòng thử lại');
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

    //copy tai khaon chia se bai viet kiem tien sang ketoanthue
    public function copy_employee_to_sanketoan()
    {
        echo 1;
        die();
    }
}
