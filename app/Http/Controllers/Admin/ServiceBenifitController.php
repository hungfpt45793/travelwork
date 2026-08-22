<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Service_benifit;
use App\Entity\Service_table_price;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceBenifitController extends AdminController
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
        $service_benifits = Service_benifit::get();
        return view('admin.service_benifit.index',compact('service_benifits'));
    }

    public function create()
    {
        return view('admin.service_benifit.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'service_benifit_name' => 'required',
        ],[
            'service_benifit_name.required' => 'Tên quyền lợi chưa nhập',
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_benifit = new Service_benifit();
        $service_benifit->service_benifit_name = $request->service_benifit_name;
        $service_benifit->save();
        return redirect()->route('service_benifit.index')->with('success','Tạo thành công benifit');
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $service_benifit = Service_benifit::findOrFail($id);
        return view('admin.service_benifit.edit',compact('service_benifit'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'service_benifit_name' => 'required',
        ],[
            'service_benifit_name.required' => 'Tên quyền lợi chưa nhập',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_benifit = Service_benifit::findOrFail($id);
        $data = [];
        $data['service_benifit_name'] = $request->service_benifit_name;
        $service_benifit->update($data);
        return redirect()->route('service_benifit.index')->with('success','Sửa thành công benifit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service_benifit::findOrFail($id)->delete();   
        return redirect()->route('service_benifit.index')->with('success','Xóa thành công benifit');
    }
  
}
