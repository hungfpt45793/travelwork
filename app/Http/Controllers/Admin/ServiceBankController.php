<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Service_bank;
use App\Entity\Service_table_price;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceBankController extends AdminController
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
            view()->share('menuTop', 'list_price');
            return $next($request);
        });


    }
    public function index()
    {
        $service_banks = Service_bank::get();
        return view('admin.service_bank.index',compact('service_banks'));
    }

    public function create()
    {
        return view('admin.service_bank.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'service_bank_name' => 'required',
            'service_bank_number' => 'required',
        ],[
            'service_bank_name.required' => 'Tên ngân hàng chưa nhập',
            'service_bank_number.required' => 'Số tài khoản chhuwa nhập',
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_bank = new Service_bank();
        $service_bank->service_bank_name = $request->service_bank_name;
        $service_bank->service_bank_number = $request->service_bank_number;
        $service_bank->service_bank_image = $request->service_bank_image;
        $service_bank->service_bank_own = $request->service_bank_own;
        $service_bank->service_bank_branch = $request->service_bank_branch;
        $service_bank->service_bank_content = $request->service_bank_content;
        $service_bank->save();
        return redirect()->route('service_bank.index')->with('success','Tạo thành công bank');
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $service_bank = Service_bank::findOrFail($id);
        return view('admin.service_bank.edit',compact('service_bank'));
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
        $validator = Validator::make($request->all(),[
            'service_bank_name' => 'required',
            'service_bank_number' => 'required',
        ],[
            'service_bank_name.required' => 'Tên ngân hàng chưa nhập',
            'service_bank_number.required' => 'Số tài khoản chhuwa nhập',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_bank = Service_bank::findOrFail($id);
        $data = [];
        $data['service_bank_name'] = $request->service_bank_name;
        $data['service_bank_content'] = $request->service_bank_content;
        $data['service_bank_image'] = $request->service_bank_image;
        $data['service_bank_own'] = $request->service_bank_own;
        $data['service_bank_branch'] = $request->service_bank_branch;
        $data['service_bank_content'] = $request->service_bank_content;
        $data['service_bank_number'] = $request->service_bank_number;
        $service_bank->update($data);
        return redirect()->route('service_bank.index')->with('success','Sửa thành công bank');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service_bank::findOrFail($id)->delete();   
        return redirect()->route('service_bank.index')->with('success','Xóa thành công bank');
    }
  
}
