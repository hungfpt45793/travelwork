<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Service_hunter;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceHunterController extends AdminController

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
        $service_hunters = Service_hunter::leftJoin('service_price','service_price.service_price_id','service_hunter.service_price_id')
        ->select('service_hunter.*','service_price.service_price_title')
        ->get();
        return view('admin.service_hunter.index',compact('service_hunters'));
    }

    public function create()
    {
        return view('admin.service_hunter.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'service_hunter_name' => 'required',
            'service_hunter_info' => 'required',
            'service_price_id' => 'required',
        ],[
            'service_hunter_name.required' => 'Tên chưa nhập',
            'service_hunter_info.required' => 'Thông tin chưa nhập',
            'service_price_id.required' => 'Chưa chọn dịch vụ',
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_hunter = new Service_hunter();
        $service_hunter->service_hunter_name = $request->service_hunter_name;
        $service_hunter->service_hunter_info = $request->service_hunter_info;
        $service_hunter->service_hunter_image = $request->service_hunter_image;
        $service_hunter->service_hunter_pay = $request->service_hunter_pay;
        $service_hunter->service_hunter_fee = $request->service_hunter_fee;
        $service_hunter->service_hunter_contact = $request->service_hunter_contact;
        $service_hunter->service_price_id = $request->service_price_id;
        $service_hunter->save();
        return redirect()->route('service_hunter.index')->with('success','Tạo thành công');
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $service_hunter = Service_hunter::findOrFail($id);
        return view('admin.service_hunter.edit',compact('service_hunter'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'service_hunter_name' => 'required',
            'service_hunter_info' => 'required',
        ],[
            'service_hunter_name.required' => 'Tên chưa nhập',
            'service_hunter_info.required' => 'Thông tin chưa nhập',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_hunter = Service_hunter::findOrFail($id);
        $data = [];
        $data['service_hunter_name'] = $request->service_hunter_name;
        $data['service_hunter_info'] = $request->service_hunter_info;
        $data['service_hunter_image'] = $request->service_hunter_image;
        $data['service_hunter_pay'] = $request->service_hunter_pay;
        $data['service_hunter_fee'] = $request->service_hunter_fee;
        $data['service_hunter_contact'] = $request->service_hunter_contact;
        $data['service_price_id'] = $request->service_price_id;
        $service_hunter->update($data);
        return redirect()->route('service_hunter.index')->with('success','Sửa thành công ');
    }


    public function destroy($id)
    {
        Service_hunter::findOrFail($id)->delete();   
        return redirect()->route('service_hunter.index')->with('success','Xóa thành công ');
    }
}
