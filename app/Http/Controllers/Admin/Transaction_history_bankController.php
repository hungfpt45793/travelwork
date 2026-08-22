<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Employee;
use App\Entity\Employee_coins;
use App\Entity\User;
use App\Transaction\List_product;
use App\Transaction\Transaction_history_bank;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class Transaction_history_bankController extends AdminController
{
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
        //
        $transaction_bank_model = new Transaction_history_bank();
        $transaction_bank =  $transaction_bank_model->select('transaction_history_bank.*','employees.employee_id','employees.employee_name','employees.email');
        $transaction_bank =  $transaction_bank->leftJoin('employees','employees.employee_id','=','transaction_history_bank.transaction_employee_id');
        $transaction_bank =  $transaction_bank->leftJoin('employee_coins','employee_coins.employee_id','=','employees.employee_id');
//        $a = new Employee_coins()
        if($request->has('transaction_status'))
        {
            $transaction_status = $request->input('transaction_status');
            $transaction_bank = $transaction_bank->where('transaction_history_bank.transaction_status',$transaction_status);
        }
        if(!empty($request->input('employee_name')))
        {
            $employee_name = $request->input('employee_name');
            $transaction_bank = $transaction_bank->where('employees.employee_name','like','%'.$employee_name.'%');
        }
        if(!empty($request->input('employee_email')))
        {
            $employee_email = $request->input('employee_email');
            $transaction_bank = $transaction_bank->where('employees.email',$employee_email);
        }
        if(!empty($request->input('employee_id')))
        {
            $employee_id = $request->input('employee_id');
            $transaction_bank = $transaction_bank->where('employees.employee_id',$employee_id);
        }
        if(!empty($request->input('transaction_total_coin')))
        {
            $transaction_total_coin = $request->input('transaction_total_coin');
            $transaction_bank = $transaction_bank->where('transaction_history_bank.transaction_total_coin','>',0);
        }
        $transaction_bank = $transaction_bank->where('employee_coins.bank_status',0);
        $transaction_bank = $transaction_bank->orderBy('transaction_history_bank.transaction_bank_id','desc');
        $transaction_bank = $transaction_bank->orderBy('transaction_history_bank.transaction_status','asc');

        $total = $transaction_bank->count();
        $transaction_bank = $transaction_bank->paginate(20);
        $transaction_bank->appends(request()->query());
        return view('admin.transaction.bank.list',compact('transaction_bank','total'));
    }

    public function stop_list_bank(Request $request)
    {
        //
        $transaction_bank_model = new Transaction_history_bank();
        $transaction_bank =  $transaction_bank_model->select('transaction_history_bank.*','employees.employee_id','employees.employee_name','employees.email');
        $transaction_bank =  $transaction_bank->leftJoin('employees','employees.employee_id','=','transaction_history_bank.transaction_employee_id');
        $transaction_bank =  $transaction_bank->leftJoin('employee_coins','employee_coins.employee_id','=','employees.employee_id');
//        $a = new Employee_coins()
        if($request->has('transaction_status'))
        {
            $transaction_status = $request->input('transaction_status');
            $transaction_bank = $transaction_bank->where('transaction_history_bank.transaction_status',$transaction_status);
        }
        if(!empty($request->input('employee_name')))
        {
            $employee_name = $request->input('employee_name');
            $transaction_bank = $transaction_bank->where('employees.employee_name','like','%'.$employee_name.'%');
        }
        if(!empty($request->input('employee_email')))
        {
            $employee_email = $request->input('employee_email');
            $transaction_bank = $transaction_bank->where('employees.email',$employee_email);
        }
        if(!empty($request->input('employee_id')))
        {
            $employee_id = $request->input('employee_id');
            $transaction_bank = $transaction_bank->where('employees.employee_id',$employee_id);
        }
        $transaction_bank = $transaction_bank->where('employee_coins.bank_status',1);

        $transaction_bank = $transaction_bank->orderBy('transaction_history_bank.transaction_status','asc');
        $transaction_bank = $transaction_bank->orderBy('transaction_history_bank.transaction_bank_id','desc');
        $total = $transaction_bank->count();
        $transaction_bank = $transaction_bank->paginate(20);
        $transaction_bank->appends(request()->query());
        return view('admin.transaction.bank.stop_list_bank',compact('transaction_bank','total'));
    }
    //tạm dừng chuyển khoản
    public function stop_trannsaction_bank($employee_id)
    {

        $employee_coint = new Employee_coins();
        $employee_coint = $employee_coint->where('employee_id',$employee_id)->update([
            'bank_status' => 1
        ]);
        return redirect()->back()->with('success','Tạm dừng chuyển khoản thành công');
    }
    //khôi phục chuyển khoản
    public function restore_trannsaction_bank($employee_id)
    {
        $employee_coint = new Employee_coins();
        $employee_coint = $employee_coint->where('employee_id',$employee_id)->update([
            'bank_status' => 0
        ]);
        return redirect()->back()->with('success','Khôi phục trạng thái chuyển khoản');
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
        $transaction_bank_model = new Transaction_history_bank();
        $transaction_bank =  $transaction_bank_model->select('*')
            ->where('transaction_bank_id',$id)
            ->first();
        $employee = $this->getEmployee($transaction_bank->transaction_employee_id);
        return view('admin.transaction.bank.edit',compact('transaction_bank','employee'));
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
            'employees.user_id'
        )
            ->join('employee_coins','employee_coins.employee_id','=','employees.employee_id')
            ->where('employees.employee_id',$employee_id)
            ->first();
        return $employee;

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
        try{
            DB::beginTransaction();
            $user_admin = Auth::user();
            $transaction_bank_model = new Transaction_history_bank();
            $transaction_bank_id = $request->input('transaction_bank_id');
            $employee_id = $request->input('employee_id');
            $transaction_admin_reply = $request->input('transaction_admin_reply');
            $transaction_bank_price = str_replace(".","",$request->input('transaction_bank_price'));

            $transaction_status = $request->input('transaction_status');


            $check_transaction_bank = $transaction_bank_model->where('transaction_bank_id',$transaction_bank_id)->first();
            if($check_transaction_bank->transaction_status != 1)
            {
                if($transaction_status == 1)
                {
                    $user_id = Employee::where('employee_id',$employee_id)->value('user_id');
                    $transaction_total_coin = $check_transaction_bank->transaction_total_coin;
//                    cộng xu cho usser
                    $user_coin = User::where('id',$user_id)->first();
                    $update = User::where('id',$user_id)->update([
                        'user_coin' =>  $user_coin->user_coin + $transaction_total_coin
                    ]);
                    //tạo thông báo cho
                    $noti_title = 'Admin đã hủy giao dịch yêu cầu chuyển khoản  của bạn + ' .$transaction_total_coin. ' xu  trên sanketoan.vn';
                    $forum_noti = Forum_notification::insert([
                        'noti_title' => $noti_title,
                        'for_post_id'=>0, //mã bài viết
                        'for_comment_id'=>0,
                        'user_id' =>$user_coin->id, //user id nhận thông báo
                        'user_id_comment'=>0, //user người bình luận
                        'noti_type'=>'user_pro', //kiểu thông báo comment=>là thông báo bình luận về bài viết , post_coin=>là thông báo về bài viết mất 1 xu ,comment_coin=>là thông báo về bình luận tặng xu,  user_pro=>tặng xu khi đăng ký tài khoản pro,
                        'noti_status' => 0, //trạng thái thông báo 0 là chưa xem 1 đã xem
                        'created_at' => new \DateTime()
                    ]);
                }
            }
            else
            {
                if($transaction_status != 1 && $check_transaction_bank->transaction_status == 1)
                {
                    //tạo thông báo cho
                    $user_id = Employee::where('employee_id',$employee_id)->value('user_id');
                    $transaction_total_coin = $check_transaction_bank->transaction_total_coin;
//                    cộng xu cho usser
                    $user_coin = User::where('id',$user_id)->first();
                    $noti_title = 'Admin đã giao dịch chuyển khoản của bạn thành công trên sanketoan.vn';
                    $forum_noti = Forum_notification::insert([
                        'noti_title' => $noti_title,
                        'for_post_id'=>0, //mã bài viết
                        'for_comment_id'=>0,
                        'user_id' =>$user_coin->id, //user id nhận thông báo
                        'user_id_comment'=>0, //user người bình luận
                        'noti_type'=>'user_pro', //kiểu thông báo comment=>là thông báo bình luận về bài viết , post_coin=>là thông báo về bài viết mất 1 xu ,comment_coin=>là thông báo về bình luận tặng xu,  user_pro=>tặng xu khi đăng ký tài khoản pro,
                        'noti_status' => 0, //trạng thái thông báo 0 là chưa xem 1 đã xem
                        'created_at' => new \DateTime()
                    ]);
                }
            }


            //Chưa giao dich
            $update = $transaction_bank_model->where('transaction_bank_id',$transaction_bank_id)
                ->update([
                    'transaction_status' => $transaction_status,
                    'transaction_admin_reply' => $transaction_admin_reply,
                    'transaction_admin_id' => $user_admin->id,
                    'updated_at' => new \DateTime(),
                ]);
            //trường hợp hủy giao dich thì cộng lại tiền cho ứng viên


            DB::commit();
            return redirect(route('transaction_bank.index'))->with('success','Cập nhật giao dịch thành công');
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect(route('transaction_bank.index'))->with('error','Cập nhật giao dịch thất bại');
        }
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
