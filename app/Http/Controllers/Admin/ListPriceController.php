<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Entity\Service_price;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ListPriceController extends AdminController
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
        $list_prices = Service_price::get();
        return view('admin.list_price.index',compact('list_prices'));
    }

    public function create()
    {
        return view('admin.list_price.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'service_price_title' => 'required',
            'service_price_type' => 'required',
            'feature' => 'required',
            'image' => 'required',
        ],[
            'service_price_title.required' => 'Tên gói chưa nhập',
            'service_price_type.required' => 'Chưa chọn loại dịch vụ',
            'feature.required' => 'Dịch vụ chưa nhập',
            'image.required' => 'Chưa chọn ảnh',
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_price = new Service_price();
        $service_price_id = $service_price->insertGetId([
            'service_price_title' => $request->service_price_title,
            'service_price_type' => $request->service_price_type,
            'feature' => $request->feature,
            'image' => $request->image,
        ]);
        $slug = str_slug($request->service_price_title);
        $service_priceWithSlug = $service_price->where('service_price_slug', $slug)->first();
        if (empty($service_priceWithSlug)) {
            $service_price->where('service_price_id', '=', $service_price_id)
                ->update([
                    'service_price_slug' => $slug
                ]);
        } else {
            $service_price->where('service_price_id', '=', $service_price_id)
                ->update([
                    'service_price_slug' => $slug.'-'.$service_price_id
                ]);
        }
        return redirect()->route('list_price.index')->with('success','Tạo thành công gói dịch vụ');
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $list_price = Service_price::findOrFail($id);
        return view('admin.list_price.edit',compact('list_price'));
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
            'service_price_title' => 'required',
            'service_price_type' => 'required',
            'image' => 'required',
            'feature' => 'required',
        ],[
            'service_price_title.required' => 'Tên gói chưa nhập',
            'service_price_type.required' => 'Chưa chọn loại dịch vụ',
            'feature.required' => 'Dịch vụ chưa nhập',
            'image.required' => 'Chưa chọn ảnh',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // $list_price = Service_price::findOrFail($id);
        $data = [];
        $data['service_price_title'] = $request->service_price_title;
        
        $data['service_price_type'] = $request->service_price_type;
        $data['feature'] = $request->feature;
        $data['image'] = $request->image;

//        $slug=str_slug($request->service_price_title);
//
//        $service_price_slug = Service_price::where('service_price_slug', $slug)->first();
//        if(!empty($service_price_slug)){
//            $slug = $slug.'-'.$id;
//        }
//        $data['service_price_slug'] = $slug;
        Service_price::where('service_price_id', $id)->update($data);

        return redirect()->route('list_price.index')->with('success','Sửa thành công gói dịch vụ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service_price::findOrFail($id)->delete();   
        return redirect()->route('list_price.index')->with('success','Xóa thành công gói dịch vụ');
    }
}
