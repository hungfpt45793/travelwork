<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Employee;
use App\Entity\Employee_coins;
use App\Entity\User;
use App\Transaction\List_product;
use App\Transaction\Transaction_history_product;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class Transaction_history_productController extends AdminController
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
        $transaction_product_model = new Transaction_history_product();
        $transaction_product =  $transaction_product_model->select('transaction_history_product.*','employees.employee_id','employees.employee_name','employees.email');
        $transaction_product =  $transaction_product->leftJoin('employees','employees.employee_id','=','transaction_history_product.transaction_employee_id');
        if($request->has('transaction_status'))
        {
            $transaction_status = $request->input('transaction_status');
            $transaction_product = $transaction_product->where('transaction_history_product.transaction_status',$transaction_status);
        }
        if(!empty($request->input('employee_name')))
        {
            $employee_name = $request->input('employee_name');
            $transaction_product = $transaction_product->where('employees.employee_name','like','%'.$employee_name.'%');
        }
        if(!empty($request->input('employee_email')))
        {
            $employee_email = $request->input('employee_email');
            $transaction_product = $transaction_product->where('employees.email',$employee_email);
        }
        if(!empty($request->input('employee_id')))
        {
            $employee_id = $request->input('employee_id');
            $transaction_product = $transaction_product->where('employees.employee_id',$employee_id);
        }
        $transaction_product = $transaction_product->orderBy('transaction_history_product.transaction_status','asc');
        $transaction_product = $transaction_product->orderBy('transaction_history_product.transaction_product_id','desc');
        $transaction_product = $transaction_product->paginate(15);

        return view('admin.transaction.product.list',compact('transaction_product'));
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
        $transaction_product_model = new Transaction_history_product();
        $transaction_product =  $transaction_product_model->select('*')
            ->where('transaction_id',$id)
            ->first();
        $employee = $this->getEmployee($transaction_product->transaction_employee_id);
        return view('admin.transaction.product.edit',compact('transaction_product','employee'));
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
            $transaction_product_model = new Transaction_history_product();
            $transaction_id = $request->input('transaction_id');
            $employee_id = $request->input('employee_id');
            $transaction_admin_reply = $request->input('transaction_admin_reply');
            $transaction_product_price = str_replace(".","",$request->input('transaction_product_price'));

            $transaction_status = $request->input('transaction_status');

            $employee_coins_model = new Employee_coins()    ;
            $employee_coins = $employee_coins_model->select('*')
                ->where('employee_id',$employee_id)
                ->first();

            $check_transaction_product = $transaction_product_model->where('transaction_id',$transaction_id)->first();
            if($check_transaction_product->transaction_status != 1)
            {
                if($transaction_status == 1 && !empty($employee_coins))
                {
                    $total_change_product = $employee_coins->total_change_product - $transaction_product_price;
                    $money = $employee_coins->money + $transaction_product_price;
                    $update_employee_coins = $employee_coins_model->where('employee_id',$employee_id)
                        ->update([
                            'total_change_product' => $total_change_product,
                            'money' => $money,
                            'updated_at' => new \DateTime(),
                        ]);
                }
            }
            else
            {
                if($transaction_status != 1 && $check_transaction_product->transaction_status == 1)
                {
                    $total_change_product = $employee_coins->total_change_product + $transaction_product_price;
                    $money = $employee_coins->money - $transaction_product_price;
                    $update_employee_coins = $employee_coins_model->where('employee_id',$employee_id)
                        ->update([
                            'total_change_product' => $total_change_product,
                            'money' => $money,
                            'updated_at' => new \DateTime(),
                        ]);
                }
            }

            //Chưa giao dich
            $update = $transaction_product_model->where('transaction_id',$transaction_id)
                ->update([
                    'transaction_status' => $transaction_status,
                    'transaction_admin_reply' => $transaction_admin_reply,
                    'transaction_admin_id' => $user_admin->id,
                    'updated_at' => new \DateTime(),
                ]);
            //trường hợp hủy giao dich thì cộng lại tiền cho ứng viên


            DB::commit();
            return redirect(route('transaction_product.index'))->with('success','Cập nhật giao dịch đổi phần mềm thành công');
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect(route('transaction_product.index'))->with('error','Cập nhật giao dịch đổi phần mềm thành công');
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
