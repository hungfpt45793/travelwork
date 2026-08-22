<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Employee;
use App\Entity\Employee_coins;
use App\Entity\Forum_notification;
use App\Entity\User;
use App\Transaction\List_product;
use App\Transaction\Transaction_history_card;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class Transaction_history_cardController extends AdminController
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
        //
        $transaction_card_model = new Transaction_history_card();
        $transaction_card =  $transaction_card_model->select('transaction_history_card.*','employees.employee_id','employees.employee_name','employees.email');
        $transaction_card =  $transaction_card->leftJoin('employees','employees.employee_id','=','transaction_history_card.transaction_employee_id');
        if($request->has('transaction_status'))
        {
            $transaction_status = $request->input('transaction_status');
            $transaction_card = $transaction_card->where('transaction_history_card.transaction_status',$transaction_status);
        }
        if(!empty($request->input('employee_name')))
        {
            $employee_name = $request->input('employee_name');
            $transaction_card = $transaction_card->where('employees.employee_name','like','%'.$employee_name.'%');
        }
        if(!empty($request->input('employee_email')))
        {
            $employee_email = $request->input('employee_email');
            $transaction_card = $transaction_card->where('employees.email',$employee_email);
        }
        if(!empty($request->input('employee_id')))
        {
            $employee_id = $request->input('employee_id');
            $transaction_card = $transaction_card->where('employees.employee_id',$employee_id);
        }
        $transaction_card = $transaction_card->orderBy('transaction_history_card.transaction_status','asc');
        $transaction_card = $transaction_card->orderBy('transaction_history_card.transaction_card_id','desc');
        $transaction_card = $transaction_card->paginate(15);

        return view('admin.transaction.card.list',compact('transaction_card'));
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
        $transaction_card_model = new Transaction_history_card();
        $transaction_card =  $transaction_card_model->select('*')
            ->where('transaction_card_id',$id)
            ->first();
        $employee = $this->getEmployee($transaction_card->transaction_employee_id);
        $user_coin = User::where('id',$employee->user_id)->first();
        return view('admin.transaction.card.edit',compact('transaction_card','employee','user_coin'));
    }

    public function getEmployee($employee_id)
    {
        $employee_model = new Employee();
        $employee = $employee_model->select(
            'employees.employee_id',
            'employees.employee_name',
            'employees.employee_image',
            'employees.user_id',
            'employees.phone',
            'employees.email',
            'employees.province',
            'employees.district'
            )
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
            $transaction_card_model = new Transaction_history_card();
            $transaction_card_id = $request->input('transaction_card_id');
            $employee_id = $request->input('employee_id');
            $transaction_admin_reply = $request->input('transaction_admin_reply');
            $transaction_card_price = str_replace(".","",$request->input('transaction_card_price'));

            $transaction_status = $request->input('transaction_status');

            $check_transaction_card = $transaction_card_model->where('transaction_card_id',$transaction_card_id)->first();
            if($check_transaction_card->transaction_status != 1)
            {
                if($transaction_status == 1)
                {
                    //hhủy giao dịch
//                    cộng lại xu cho ung vien
                    $user_id = Employee::where('employee_id',$employee_id)->value('user_id');
                    $transaction_total_coin = $check_transaction_card->transaction_total_coin;
//                    cộng xu cho usser
                    $user_coin = User::where('id',$user_id)->first();
                    $update = User::where('id',$user_id)->update([
                       'user_coin' =>  $user_coin->user_coin + $transaction_total_coin
                    ]);
                    //tạo thông báo cho
                    $noti_title = 'Admin đã hủy giao dịch đổi thẻ cào của bạn + ' .$transaction_total_coin. ' xu  trên sanketoan.vn';
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
                if($transaction_status != 1 && $check_transaction_card->transaction_status == 1)
                {
                    //tạo thông báo cho
                    $user_id = Employee::where('employee_id',$employee_id)->value('user_id');
                    $transaction_total_coin = $check_transaction_card->transaction_total_coin;
//                    cộng xu cho usser
                    $user_coin = User::where('id',$user_id)->first();
                    $noti_title = 'Admin đã giao dịch đổi thẻ cào của bạn thành công trên sanketoan.vn';
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
            $update = $transaction_card_model->where('transaction_card_id',$transaction_card_id)
                ->update([
                    'transaction_status' => $transaction_status,
                    'transaction_admin_reply' => $transaction_admin_reply,
                    'transaction_admin_id' => $user_admin->id,
                    'updated_at' => new \DateTime(),
                ]);
            //trường hợp hủy giao dich thì cộng lại tiền cho ứng viên
            DB::commit();
             return redirect(route('transaction_card.index'))->with('success','Cập nhật giao dịch thành công');
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect(route('transaction_card.index'))->with('error','Cập nhật giao dịch thất bại');
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
