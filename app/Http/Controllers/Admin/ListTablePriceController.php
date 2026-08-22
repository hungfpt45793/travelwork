<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Entity\Service_price;
use App\Entity\Service_table_price;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ListTablePriceController extends AdminController
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
        $table_prices = Service_table_price::leftJoin('service_price','service_price.service_price_id','service_table_price.service_price_id')
        ->select('service_price.service_price_id','service_price.service_price_title',
        'service_table_price.package_name','service_table_price.package_price','service_table_price.service_table_price_id',
        'service_table_price.benifit','service_table_price.endow',
        'service_table_price.package_discount','service_table_price.package_vat')->get();
        // $table_prices->appends(request()->query());
        return view('admin.list_table_price.index',compact('table_prices'));
    }

    public function create()
    {
        return view('admin.list_table_price.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'service_price_id' => 'required',
            'package_name' => 'required',
            'package_price' => 'required',
            'package_discount' => 'required',
            'package_vat' => 'required',
        ],[
            'service_price_id.required' => 'Tên dịch vụ chưa chọn',
            'package_name.required' => 'Tên gói chưa nhập',
            'package_price.required' => 'Giá chưa nhập',
            'package_discount.required' => 'Chiết khấu chưa nhập',
            'package_vat.required' => 'Giá gồm VAT chưa nhập',
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_table_price = new Service_table_price();
        $service_table_price->service_price_id = $request->service_price_id;
        $service_table_price->package_name = $request->package_name;
        $service_table_price->package_price = $request->package_price;
        $service_table_price->package_discount = $request->package_discount;
        $service_table_price->package_vat = $request->package_vat;
        $service_table_price->benifit = $request->benifit;
        $service_table_price->endow = $request->endow;
        $service_table_price->save();
        return redirect()->route('list_table_price.index')->with('success','Tạo thành công gói giá gói');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $table_price = Service_table_price::findOrFail($id);
        return view('admin.list_table_price.edit',compact('table_price'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'service_price_id' => 'required',
            'package_name' => 'required',
            'package_price' => 'required',
            'package_discount' => 'required',
            'package_vat' => 'required',
        ],[
            'service_price_id.required' => 'Tên dịch vụ chưa chọn',
            'package_name.required' => 'Tên gói chưa nhập',
            'package_price.required' => 'Giá chưa nhập',
            'package_discount.required' => 'Chiết khấu chưa nhập',
            'package_vat.required' => 'Giá gồm VAT chưa nhập',
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $table_list = Service_table_price::findOrFail($id);
        $data = [];
        $data['service_price_id'] = $request->service_price_id;
        $data['package_name'] = $request->package_name;
        $data['package_price'] = $request->package_price;
        $data['package_discount'] = $request->package_discount;
        $data['package_vat'] = $request->package_vat;
        $data['benifit'] = $request->benifit;
        $data['endow'] = $request->endow;
        $table_list->update($data);
        return redirect()->route('list_table_price.index')->with('success','Sửa thành công giá dịch vụ');
    }

    
    public function destroy($id)
    {
        Service_table_price::findOrFail($id)->delete();
        return redirect()->route('list_table_price.index')->with('success','Xóa thành công giá dịch vụ');
    }
    public function anyDatatable(){
        $table_prices = Service_table_price::leftJoin('service_price','service_price.service_price_id','service_table_price.service_price_id')
        ->select('service_price.service_price_id','service_price.service_price_title',
        'service_table_price.package_name','service_table_price.package_price','service_table_price.service_table_price_id',
        'service_table_price.benifit','service_table_price.endow',
        'service_table_price.package_discount','service_table_price.package_vat')->get();



        return Datatables::of($table_prices)
            ->addColumn('action', function ($table_prices){
                $string  = '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                $string .= '<a href="' . route('list_table_price.edit',['list_table_price' => $table_price->service_table_price_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('list_table_price.destroy', ['list_table_price' => $table_price->service_table_price_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                $string .=  '</div>' ;         
                return $string;
            })
            ->orderColumn('service_price.service_price_id','service_price.service_price_id desc')
            ->make(true);
    }
}
