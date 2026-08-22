<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Employee;
use App\Entity\Employee_coins;
use App\Entity\Employee_intro_employer;
use App\Entity\Information_money;
use App\Entity\Job_sale_statistical;
use App\Entity\Post_sale_statistical;
use App\Entity\TypeInformation;
use App\Entity\TypeInformation_money;
use App\Entity\User;
use App\Transaction\List_product;
use App\Transaction\Transaction_history_card;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EmployeeCointsController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if (!User::isCreater($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'transaction');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $employee = new Employee();
        $employee_coins_model = new Employee_coins();
        $employee_coins = $employee_coins_model->select('coins_id',
            'employee_coins.coins_id',
            'employee_coins.employee_id',
            'employee_coins.total_sale',
            'employee_coins.total_view',
            'employee_coins.total_money',
            'employee_coins.total_change_crad',
            'employee_coins.total_change_bank',
            'employee_coins.total_change_product',
            'employee_coins.money',
            'employee_coins.coints_status',
            'employees.employee_id',
            'employees.employee_name',
            'employees.phone',
            'employees.my_facebook',
            'employees.province',
            'employees.email',
            'employees.district',
            'employees.address'
        )
            ->leftJoin('employees', 'employees.employee_id', '=', 'employee_coins.employee_id');

        if (!empty($request->input('employee_name'))) {
            $employee_name = $request->input('employee_name');
            $employee_coins = $employee_coins->where('employees.employee_name', 'like', '%' . $employee_name . '%');
        }
        if (!empty($request->input('employee_email'))) {
            $employee_email = $request->input('employee_email');
            $employee_coins = $employee_coins->where('employees.email', $employee_email);
        }
        if (!empty($request->input('employee_id'))) {
            $employee_id = $request->input('employee_id');
            $employee_coins = $employee_coins->where('employees.employee_id', $employee_id);
        }
        if (!empty($request->input('myfacebook'))) {
            $myfacebook = $request->input('myfacebook');
            if ($myfacebook == 1) {
                $employee_coins = $employee_coins->whereNotNull('employees.my_facebook');
            }
            if ($myfacebook == 2) {
                $employee_coins = $employee_coins->whereNull('employees.my_facebook');
            }
        }
        if ($request->has('coints_status')) {
            $coints_status = $request->input('coints_status');
            $employee_coins = $employee_coins->where('employee_coins.coints_status', $coints_status);
        }
        $employee_coins = $employee_coins->orderBy('employee_coins.total_view', 'desc');
        $employee_coins = $employee_coins->orderBy('employee_coins.total_sale', 'desc');
        $total = $employee_coins->count();
        $employee_coins = $employee_coins->paginate(20);
        $employee_coins->appends(request()->query());
        return view('admin.transaction.employee.list', compact('employee_coins', 'total'));
    }

    public function detail_employee_coints($employee_id, Request $request)
    {
        //thông tin ứng viên
        $employee_coints = new Employee_coins();
        $employee_coints = $employee_coints->select('employee_coins.*', 'employees.employee_id', 'employees.employee_name', 'employees.email', 'employees.phone')
            ->join('employees', 'employees.employee_id', 'employee_coins.employee_id')
            ->where('employee_coins.employee_id', $employee_id)
            ->first();
        //thống kê chia sẻ bài viết
        $post_sale_statistical_model = new Post_sale_statistical();
        $list_post_sale = $post_sale_statistical_model->select('post_sale_statistical.*', 'employees.employee_id', 'employees.employee_name', 'employees.email', 'employees.phone', 'posts.post_id', 'posts.title', 'posts.slug')
            ->join('posts', 'posts.post_id', 'post_sale_statistical.post_id')
            ->join('employees', 'employees.employee_id', 'post_sale_statistical.employee_id');
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $list_post_sale = $list_post_sale->where('posts.title', 'like', '%' . $title . '%');
        }
        $list_post_sale = $list_post_sale->where('employees.employee_id', $employee_id);
        $list_post_sale = $list_post_sale->orderBy('post_sale_statistical.total_view_sale', 'desc');
        $total = $list_post_sale->count();
        $list_post_sale = $list_post_sale->paginate(20);
        $list_post_sale->appends(request()->query());
//        echo '<pre>';
//        print_r($list_post_sale);die();
        return view('admin.transaction.employee.detail_sale_post', compact('list_post_sale', 'total', 'employee_coints'));

    }

    public function detail_employee_coints_job($employee_id, Request $request)
    {
        //thông tin ứng viên
        $employee_coints = new Employee_coins();
        $employee_coints = $employee_coints->select('employee_coins.*', 'employees.employee_id', 'employees.employee_name', 'employees.email', 'employees.phone')
            ->join('employees', 'employees.employee_id', 'employee_coins.employee_id')
            ->where('employee_coins.employee_id', $employee_id)
            ->first();

        //thống kê chia sẻ bài viết
        $post_sale_statistical_model = new Job_sale_statistical();
        $list_post_sale = $post_sale_statistical_model->select('job_sale_statistical.*', 'employees.employee_id', 'employees.employee_name', 'employees.email', 'employees.phone', 'jobs.job_id', 'jobs.title', 'jobs.slug')
            ->join('jobs', 'jobs.job_id', 'job_sale_statistical.job_id')
            ->join('employees', 'employees.employee_id', 'job_sale_statistical.employee_id');
        $list_post_sale = $list_post_sale->where('employees.employee_id', $employee_id);
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $list_post_sale = $list_post_sale->where('jobs.title', 'like', '%' . $title . '%');
        }
        $list_post_sale = $list_post_sale->orderBy('job_sale_statistical.total_view_sale', 'desc');

        $total = $list_post_sale->count();
        $list_post_sale = $list_post_sale->paginate(20);
        $list_post_sale->appends(request()->query());
//        echo '<pre>';
//        print_r($list_post_sale);die();
        return view('admin.transaction.employee.detail_sale_job', compact('list_post_sale', 'total', 'employee_coints'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_status_employee_coints(Request $request)
    {
        $employee_coints = new Employee_coins();
        $coins_id = $request->input('coins_id');
        $coints_status = $request->input('coints_status');
        $employee_coints = $employee_coints->where('coins_id', $coins_id)->update([
            'coints_status' => $coints_status,
            'updated_at' => new \DateTime()
        ]);
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');
    }

    public function list_employee_intro(Request $request)
    {
        $employee = new Employee();
        $employee_coins_model = new Employee_coins();
        $employee_coins = $employee_coins_model->select('coins_id',
            'employee_coins.coins_id',
            'employee_coins.employee_id',
            'employee_coins.total_sale',
            'employee_coins.total_view',
            'employee_coins.total_money',
            'employee_coins.total_change_crad',
            'employee_coins.total_change_bank',
            'employee_coins.total_change_product',
            'employee_coins.money',
            'employee_coins.coints_status',
            'employees.employee_id',
            'employees.employee_name',
            'employees.phone',
            'employees.my_facebook',
            'employees.province',
            'employees.email',
            'employees.district',
            'employees.address',
            'employee_intro_employer.*',
            'employer.email as employer_email',
            'employer.phone as employer_phone',
            'employer.enterprise_name',
            'employer.slug'
        )
            ->join('employees', 'employees.employee_id', '=', 'employee_coins.employee_id')
            ->join('employee_intro_employer', 'employee_intro_employer.user_id', '=', 'employees.user_id')
            ->join('employer', 'employer.employer_id', '=', 'employee_intro_employer.employer_id');

        if (!empty($request->input('employee_name'))) {
            $employee_name = $request->input('employee_name');
            $employee_coins = $employee_coins->where('employees.employee_name', 'like', '%' . $employee_name . '%');
        }
        if (!empty($request->input('employee_email'))) {
            $employee_email = $request->input('employee_email');
            $employee_coins = $employee_coins->where('employees.email', $employee_email);
        }
        if (!empty($request->input('employee_id'))) {
            $employee_id = $request->input('employee_id');
            $employee_coins = $employee_coins->where('employees.employee_id', $employee_id);
        }
        if (!empty($request->input('myfacebook'))) {
            $myfacebook = $request->input('myfacebook');
            if ($myfacebook == 1) {
                $employee_coins = $employee_coins->whereNotNull('employees.my_facebook');
            }
            if ($myfacebook == 2) {
                $employee_coins = $employee_coins->whereNull('employees.my_facebook');
            }
        }
        if ($request->has('status_intro')) {
            $status_intro = $request->input('status_intro');
            $employee_coins = $employee_coins->where('employee_intro_employer.status_intro', $status_intro);
        }
        $employee_coins = $employee_coins->orderBy('employee_intro_employer.intro_id', 'desc');
        $employee_coins = $employee_coins->orderBy('employee_intro_employer.status_intro', 'asc');
        $total = $employee_coins->count();
        $employee_coins = $employee_coins->paginate(20);
        $employee_coins->appends(request()->query());


        return view('admin.transaction.employee.list_intro', compact('employee_coins', 'total'));
    }

    public function update_status_employee_intro(Request $request, $intro_id)
    {
        try{

            $typeInformations_money = TypeInformation_money::orderBy('type_infor_id')
                ->get();
            // get information
            $informations_money = Information_money::get();
            $informationShow_money = array();
            foreach($typeInformations_money as $id => $typeInformation_money) {
                $typeInformations_money[$id]['information'] = '';
                foreach ($informations_money as $information_money) {
                    if ($information_money->slug_type_input == $typeInformation_money->slug) {
                        $informationShow_money[$typeInformation_money->slug] = $information_money->content;
                        break;
                    }
                }
            }
            //show ra thông tin của uv giới thiệu
            $employee_intro_employer = new Employee_intro_employer();
            $employee_intro_employer = $employee_intro_employer->select('*')->where('intro_id',$intro_id)->first();

            if(!empty($employee_intro_employer->status_intro))
            {
                return redirect()->back()->with('success','Ứng viên này đã cộng tiên');
            }
            DB::beginTransaction();
            $money_intro = $informationShow_money['so-tien-nhan-duoc-khi-gioi-thieu-nha-tuyen-dung'];
            $update_mployee_intro =  $employee_intro_employer->where('intro_id',$intro_id)->update([
                'status_intro' => 1,
                'money_status' => $money_intro,
                'updated_at' => new \DateTime()
            ]);
            //cộng tienf cào tai khoản ung vien
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id','user_id')->where('user_id',$employee_intro_employer->user_id)->first();
            $employee_coins_model = new Employee_coins();
            $employee_coins_fr = $employee_coins_model->where('employee_id',$employee->employee_id)->first();
            $employee_coins = $employee_coins_model->where('employee_id',$employee->employee_id)->update([
                'total_money' => $employee_coins_fr->total_money + $money_intro,
                'money' => $employee_coins_fr->money + $money_intro
            ]);
            DB::commit();
            return redirect()->back()->with('success','Cộng tiền cho ứng viên thành công');
        }catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Có lỗi xảy ra vui lòng thử lại');
        }

    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaction_card_model = new Transaction_history_card();
        $transaction_card = $transaction_card_model->select('*')
            ->where('transaction_card_id', $id)
            ->first();
        $employee = $this->getEmployee($id);
        $employee = new Employee();
        $employee_coins_model = new Employee_coins();
        $employee = $employee_coins_model->select('coins_id',
            'employee_coins.coins_id',
            'employee_coins.employee_id',
            'employee_coins.total_sale',
            'employee_coins.total_view',
            'employee_coins.total_money',
            'employee_coins.total_change_crad',
            'employee_coins.total_change_bank',
            'employee_coins.total_change_product',
            'employee_coins.money',
            'employees.employee_id',
            'employees.employee_name',
            'employees.phone',
            'employees.province',
            'employees.email',
            'employees.district',
            'employees.address'
        )
            ->leftJoin('employees', 'employees.employee_id', '=', 'employee_coins.employee_id')
            ->orderBy('employee_coins.total_view', 'desc')
            ->orderBy('employee_coins.total_sale', 'desc')
            ->where('employee_coins.coins_id', $id)
            ->first();


        return view('admin.transaction.employee.edit', compact('employee'));
    }

    public function getEmployee($employee_id)
    {
        $employee_model = new Employee();
        $employee = $employee_model->select(
            'employees.employee_id',
            'employees.employee_name',
            'employees.employee_image',
            'employees.phone',
            'employees.email',
            'employees.province',
            'employees.district',
            'employee_coins.employee_id',
            'employee_coins.total_sale',
            'employee_coins.total_view',
            'employee_coins.total_money',
            'employee_coins.total_change_crad',
            'employee_coins.total_change_bank',
            'employee_coins.total_change_product',
            'employee_coins.money'
        )
            ->join('employee_coins', 'employee_coins.employee_id', '=', 'employees.employee_id')
            ->where('employees.employee_id', $employee_id)
            ->first();
        return $employee;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            DB::beginTransaction();
            $user_admin = Auth::user();
            $transaction_card_model = new Transaction_history_card();
            $transaction_card_id = $request->input('transaction_card_id');
            $employee_id = $request->input('employee_id');
            $transaction_admin_reply = $request->input('transaction_admin_reply');
            $transaction_card_price = str_replace(".", "", $request->input('transaction_card_price'));

            $transaction_status = $request->input('transaction_status');

            $employee_coins_model = new Employee_coins();
            $employee_coins = $employee_coins_model->select('*')
                ->where('employee_id', $employee_id)
                ->first();
            $check_transaction_card = $transaction_card_model->where('transaction_card_id', $transaction_card_id)->first();
            if ($check_transaction_card->transaction_status != 1) {
                if ($transaction_status == 1 && !empty($employee_coins)) {
                    $total_change_crad = $employee_coins->total_change_crad - $transaction_card_price;
                    $money = $employee_coins->money + $transaction_card_price;
                    $update_employee_coins = $employee_coins_model->where('employee_id', $employee_id)
                        ->update([
                            'total_change_crad' => $total_change_crad,
                            'money' => $money,
                            'updated_at' => new \DateTime(),
                        ]);
                }
            } else {
                if ($transaction_status != 1 && $check_transaction_card->transaction_status == 1) {
                    $total_change_crad = $employee_coins->total_change_crad + $transaction_card_price;
                    $money = $employee_coins->money - $transaction_card_price;
                    $update_employee_coins = $employee_coins_model->where('employee_id', $employee_id)
                        ->update([
                            'total_change_crad' => $total_change_crad,
                            'money' => $money,
                            'updated_at' => new \DateTime(),
                        ]);
                }
            }


            //Chưa giao dich
            $update = $transaction_card_model->where('transaction_card_id', $transaction_card_id)
                ->update([
                    'transaction_status' => $transaction_status,
                    'transaction_admin_reply' => $transaction_admin_reply,
                    'transaction_admin_id' => $user_admin->id,
                    'updated_at' => new \DateTime(),
                ]);
            //trường hợp hủy giao dich thì cộng lại tiền cho ứng viên


            DB::commit();
            return redirect(route('transaction_card.index'))->with('success', 'Cập nhật giao dịch thành công');
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect(route('transaction_card.index'))->with('error', 'Cập nhật giao dịch thất bại');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
