<?php

namespace App\Http\Controllers\Admin;

use App\Entity\EmployerTransaction;
use App\Entity\Job;
use App\Entity\NoteOrders;
use App\Entity\User;
use App\Entity\Employer;
use App\Entity\Employee;
use App\Entity\Order;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use Yajra\DataTables\DataTables;

class OrderController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'orders');

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orders.order.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employers = Employer::get();
        $employees = Employee::get();
        $users = User::where('role', 3)->get();
        return view('orders.order.add', compact('employers', 'employees', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'total_price' => 'numeric',
            'paid' => 'numeric',
            'employer_id' => 'numeric | min:1',
            'employee_id' => 'numeric | min:1',
            'user_id' => 'numeric | min:1',
            'job_id' => 'numeric | min:1'
        ],[
            'total_price.numeric' => 'Bạn nhập vào giá phải là một số.',
            'paid.numeric' => 'Bạn phải nhập vào thanh toán phải là một số.',
            'employer_id.min' => 'Bạn phải chọn nhà tuyển dụng.',
            'employee_id.min' => 'Bạn phải chọn ứng viên.',
            'job_id.min' => 'Bạn phải chọn công việc.',
            'user_id.min' => 'Bạn phải chọn nhân viên.'
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            $orderId = Order::insertGetId([
                'employer_id' => $request->input('employer_id'),
                'employee_id' => $request->input('employee_id'),
                'user_id' => $request->input('user_id'),
                'date_order' => $request->input('date_order'),
                'total_price' => $request->input('total_price'),
                'job_id' => $request->input('job_id'),
                'paid' => $request->input('paid'),
                'status' => $request->input('status'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);

            if($request->has('idOrder')){
                NoteOrders::where('note_order_id', $request->input('idOrder'))
                    ->update([
                       'order_id' => $orderId
                    ]);
            }

            if ($request->input('status') == 4){
                $employee = Employee::where('employee_id',$request->input('employee_id'))->first();
                $job = Job::where('job_id', $request->input('job_id'))->first();
                EmployerTransaction::insert([
                    'employer_id' => $request->input('employer_id'),
                    'money' => -$request->input('total_price'),
                    'reason' => 'Tuyển dụng thành công ',
                    'employee_id' => $employee->employee_id,
                    'job_id' => $job->job_id,
                    'created_at' => new \DateTime()
                ]);

                $employer = Employer::where('employer_id', $request->input('employer_id'))->first();
                $employer->update([
                    'total_money' => $employer->total_money - $request->input('total_price')
                ]);
            }
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
        } finally {
            return redirect(route('order.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $employers = Employer::get();
        $employees = Employee::get();
        $users = User::where('role', 3)->get();
        return view('orders.order.edit', compact('order', 'employers', 'employees', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(),[
            'total_price' => 'numeric',
            'paid' => 'numeric',
            'employer_id.min' => 'Bạn phải chọn nhà tuyển dụng.',
            'employee_id.min' => 'Bạn phải chọn ứng viên.',
            'job_id.min' => 'Bạn phải chọn công việc.',
            'user_id.min' => 'Bạn phải chọn nhân viên.'
        ],[
            'total_price.numeric' => 'Bạn nhập vào giá phải là một số.',
            'paid.numeric' => 'Bạn phải nhập vào thanh toán phải là một số.',
            'employer_id.min' => 'Bạn phải chọn nhà tuyển dụng.',
            'employee_id.min' => 'Bạn phải chọn ứng viên.',
            'job_id.min' => 'Bạn phải chọn công việc.',
            'user_id.min' => 'Bạn phải chọn nhân viên.'
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            if($order->status != 4){
                if ($request->input('status') == 4){
                    $employee = Employee::where('employee_id',$request->input('employee_id'))->first();
                    $job = Job::where('job_id', $request->input('job_id'))->first();
                    EmployerTransaction::insert([
                        'employer_id' => $request->input('employer_id'),
                        'money' => -$request->input('total_price'),
                        'reason' => 'Tuyển dụng thành công ',
                        'employee_id' => $employee->employee_id,
                        'job_id' => $job->job_id,
                        'created_at' => new \DateTime()
                    ]);

                    $employer = Employer::where('employer_id', $request->input('employer_id'))->first();
                    $employer->update([
                        'total_money' => $employer->total_money - $request->input('total_price')
                    ]);
                }
            }else if ($order->total_price != $request->input('total_price')){
                EmployerTransaction::where('employer_id', $request->input('employer_id'))
                    ->where('employee_id', $request->input('employee_id'))
                    ->where('job_id', $request->input('job_id'))
                    ->update([
                        'money' => -$request->input('total_price')
                    ]);
                $price = $order->total_price - $request->input('total_price');
                $employer = Employer::where('employer_id', $request->input('employer_id'))->first();
                $employer->update([
                    'total_money' => $employer->total_money - $price
                ]);
            }
            $order->update([
                'employer_id' => $request->input('employer_id'),
                'employee_id' => $request->input('employee_id'),
                'user_id' => $request->input('user_id'),
                'date_order' => $request->input('date_order'),
                'total_price' => $request->input('total_price'),
                'job_id' => $request->input('job_id'),
                'paid' => $request->input('paid'),
                'status' => $request->input('status'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);

            if($request->has('idOrder')){
                NoteOrders::where('note_order_id', $request->input('idOrder'))
                    ->update([
                        'order_id' => $order->order_id
                    ]);
            }

            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage("Không thể cập nhật dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu.");
            DB::rollBack();
        } finally {
            return redirect(route('order.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();
            $order->delete();
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage("Không thể xóa dữ liệu. Đã có lỗi xảy ra");
            DB::rollBack();
        } finally {
            return redirect(route('order.index'));
        }
    }

    public function duplicate() {
        return view('orders.duplicate');
    }

    public function affiliate() {
        return view('orders.affiliate');
    }

    public function deleted() {
        return view('orders.deleted');
    }

    public function complain() {
        return view('orders.complain');
    }

    public function anyDatatable(){
        $orders = Order::leftJoin('employees', 'employees.employee_id','=','orders.employee_id')
            ->join('employer', 'employer.employer_id','=','orders.employer_id')
            ->join('users', 'users.id','=','orders.user_id')
            ->leftJoin('jobs','jobs.job_id','=','orders.job_id')
        ->select(
            'orders.order_id',
            'employer.enterprise_name',
            'employees.employee_name',
            'users.name',
            'jobs.title',
            'orders.status',
            'orders.history',
            'orders.total_price',
            'orders.paid',
            'orders.note_admin'
        );

        return Datatables::of($orders)
            ->addColumn('action', function ($order){
                $string = '<a href="' . route('order.edit',['order_id' => $order->order_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('order.destroy', ['order_id' => $order->order_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('orders.order_id','orders.order_id desc')
            ->make(true);
    }

    public function note(Request $request){
        $idOrder = NoteOrders::insertGetId([
           'note'=> $request->input('content'),
           'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        $string = '<p>- ' . $request->input('content') .'.</p>
                    <input type="hidden" name="idOrder" value="' . $idOrder .'">';
        echo $string;
    }
}
