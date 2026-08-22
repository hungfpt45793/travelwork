<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use App\Transaction\Money_month_pay;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MoneyMonthPayController extends AdminController
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $money_month_pay_model = new Money_month_pay();
        $money_month_pay = $money_month_pay_model->select('*')->get();
        return view('admin.money_month_pay.list',compact('money_month_pay'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.money_month_pay.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'total_money_month' => 'required',
            'money_month_year' => 'unique:money_month_pay',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'money_month_year.unique' => 'Tháng năm đã tồn tại , Vui lòng chọn lại',
            'total_money_month.required' => 'Không được để trống',

        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        try
        {
        $date = date_create($request->input('money_month_year'));
//        print_r($date);die();
            $money_month_pay_model = new Money_month_pay();
            $insert = $money_month_pay_model->insertGetId([
                'total_money_month' =>str_replace(".","",$request->input('total_money_month')),
                'money_surplus' =>str_replace(".","",$request->input('total_money_month')),
                'money_month_year' => date_format($date,"Y/m/d")
            ]);
            return redirect(route('money_month.index'))->with('success','thêm thành công');
        }catch (\Exception $ex)
        {
            return redirect(route('money_month.index'))->with('error','thêm thất bại');
        }

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
    public function edit($money_id)
    {
        //
        $money_month_pay_model = new Money_month_pay();
        $money_month_pay = $money_month_pay_model->select('*')->where('money_id',$money_id)->first();
        return view('admin.money_month_pay.edit',compact('money_month_pay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $money_id)
    {
        $validation = Validator::make($request->all(), [
            'total_money_month' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'total_money_month.required' => 'Tháng năm đã tồn tại , Vui lòng chọn lại',
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        //
        try
        {
            $date = date_create($request->input('money_month_year'));
//        print_r($date);die();
            $money_month_pay_model = new Money_month_pay();
            $insert = $money_month_pay_model->where('money_id',$money_id)->update([
                'total_money_month' =>str_replace(".","",$request->input('total_money_month')),
                'money_surplus' =>str_replace(".","",$request->input('money_surplus')),
                'money_month_year' => date_format($date,"Y/m/d")
            ]);
            return redirect(route('money_month.index'))->with('success','sửa thành công');
        }catch (\Exception $ex)
        {
            return redirect(route('money_month.index'))->with('error','sửa thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($money_id)
    {
        $money_month_pay_model = new Money_month_pay();
        $delete = $money_month_pay_model->where('money_id',$money_id)->delete();
        return redirect(route('money_month.index'))->with('success','xóa thành công');

    }
}
