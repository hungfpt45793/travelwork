<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Service_icon;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceIconController extends AdminController
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
        $service_icons = Service_icon::leftJoin('service_price','service_price.service_price_id','service_icon.service_price_id')
        ->select('service_icon.*','service_price.service_price_title')
        ->get();
        return view('admin.service_icon.index',compact('service_icons'));
    }

    public function create()
    {
        return view('admin.service_icon.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'service_icon_name' => 'required',
            'service_icon_time' => 'required',
            'service_icon_image' => 'required',
            'service_icon_price' => 'required',
            'service_icon_vat' => 'required',
            'service_price_id' => 'required',
        ],[
            'service_icon_name.required' => 'Tên icon chưa nhập',
            'service_icon_time.required' => 'Thời gian sống icon chưa nhập',
            'service_icon_image.required' => 'Chưa chọn logo',
            'service_icon_price.required' => 'Chưa nhập giá',
            'service_icon_vat.required' => 'Chưa nhập giá vat',
            'service_price_id.required' => 'Chưa chọn gói dịch vụ',
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_icon = new Service_icon();
        $service_icon->service_icon_name = $request->service_icon_name;
        $service_icon->service_icon_time = $request->service_icon_time;
        $service_icon->service_icon_image = $request->service_icon_image;
        $service_icon->service_icon_price = $request->service_icon_price;
        $service_icon->service_icon_vat = $request->service_icon_vat;
        $service_icon->service_icon_info = $request->service_icon_info;
        $service_icon->service_price_id = $request->service_price_id;
        $service_icon->save();
        if(isset($request->optradio)){
            return redirect()->back()->with('success','Tạo thành công icon');
        }
        return redirect()->route('service_icon.index')->with('success','Tạo thành công icon');
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $service_icon = Service_icon::findOrFail($id);
        return view('admin.service_icon.edit',compact('service_icon'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'service_icon_name' => 'required',
            'service_icon_time' => 'required',
            'service_icon_image' => 'required',
            'service_icon_price' => 'required',
            'service_icon_vat' => 'required',
            'service_price_id' => 'required',
        ],[
            'service_icon_name.required' => 'Tên icon chưa nhập',
            'service_icon_time.required' => 'Thời gian sống icon chưa nhập',
            'service_icon_image.required' => 'Chưa chọn logo',
            'service_icon_price.required' => 'Chưa nhập giá',
            'service_icon_vat.required' => 'Chưa nhập giá vat',
            'service_price_id.required' => 'Chưa chọn gói dịch vụ',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_icon = Service_icon::findOrFail($id);
        $data = [];
        $data['service_icon_name'] = $request->service_icon_name;
        $data['service_icon_time'] = $request->service_icon_time;
        $data['service_icon_image'] = $request->service_icon_image;
        $data['service_icon_price'] = $request->service_icon_price;
        $data['service_icon_vat'] = $request->service_icon_vat;
        $data['service_icon_info'] = $request->service_icon_info;
        $data['service_price_id'] = $request->service_price_id;
        $service_icon->update($data);
        return redirect()->route('service_icon.index')->with('success','Sửa thành công icon');
    }


    public function destroy($id)
    {
        Service_icon::findOrFail($id)->delete();   
        return redirect()->route('service_icon.index')->with('success','Xóa thành công icon');
    }
}
