<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Service_name_benifit;
use App\Entity\Service_table_price;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceNameBenifitController extends AdminController
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
        $service_name_benifits = Service_name_benifit::get();
        return view('admin.service_name_benifit.index',compact('service_name_benifits'));
    }

    public function create()
    {
        return view('admin.service_name_benifit.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'service_benifit_id' => 'required',
            'service_name_benifit_title' => 'required',
        ],[
            'service_name_benifit_title.required' => 'Tên quyền lợi chưa nhập',
            'service_benifit_id.required' => 'Chưa chọn tên quyền lợi',
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_name_benifit = new Service_name_benifit();
        $service_name_benifit->service_name_benifit_title= $request->service_name_benifit_title;
        $service_name_benifit->service_benifit_id= $request->service_benifit_id;
        $service_name_benifit->save();
        return redirect()->route('service_name_benifit.index')->with('success','Tạo thành công nội dung quyền lợi');
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $service_name_benifit = Service_name_benifit::findOrFail($id);
    
        return view('admin.service_name_benifit.edit',compact('service_name_benifit'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'service_benifit_id' => 'required',
            'service_name_benifit_title' => 'required',
        ],[
            'service_name_benifit_title.required' => 'Tên quyền lợi chưa nhập',
            'service_benifit_id.required' => 'Chưa chọn tên quyền lợi',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_name_benifit = Service_name_benifit::findOrFail($id);
        $data = [];
        $data['service_name_benifit_title'] = $request->service_name_benifit_title;
        $data['service_benifit_id'] = $request->service_benifit_id;
        $service_name_benifit->update($data);
        return redirect()->route('service_name_benifit.index')->with('success','Sửa thành công nội dung quyền lợi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service_name_benifit::findOrFail($id)->delete();   
        return redirect()->route('service_name_benifit.index')->with('success','Xóa thành công nội dung quyền lợi');
    }
  
}
