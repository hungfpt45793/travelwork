<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Hunter_price;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HunterPriceController extends AdminController
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
        $hunters_price = Hunter_price::leftJoin('hunter_pos','hunter_pos.hunter_pos_id','hunter_price.hunter_pos_id')
        ->leftJoin('hunter_time','hunter_time.hunter_time_id','hunter_price.hunter_time_id')
        ->get();
        return view('admin.hunter_price.index',compact('hunters_price'));
    }

    public function create()
    {
        return view('admin.hunter_price.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'hunter_price_name' => 'required',
            'hunter_pos_id' => 'required',
            'hunter_time_id' => 'required',
            'hunter_price' => 'required'
        ],[
            'hunter_price_name.required' => 'Thời gian tuyển dụng chưa nhập',
            'hunter_pos_id.required' => 'Chưa chọn vị trí cần tuyển dụng',
            'hunter_time_id.required' => 'Chưa chọn thời gian tuyển dụng',
            'hunter_price.required' => 'Chưa nhập giá'
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $hunter_price = new Hunter_price();
        $hunter_price->hunter_price_name = $request->hunter_price_name;
        $hunter_price->hunter_price = $request->hunter_price;
        $hunter_price->hunter_pos_id = $request->hunter_pos_id;
        $hunter_price->hunter_time_id = $request->hunter_time_id;
        $hunter_price->save();
        return redirect()->route('hunter_price.index')->with('success','Tạo thành công');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $hunter_price = Hunter_price::findOrFail($id);
        return view('admin.hunter_price.edit',compact('hunter_price'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'hunter_price_name' => 'required',
            'hunter_price' => 'required',
            'hunter_pos_id' => 'required',
            'hunter_time_id' => 'required',
        ],[
            'hunter_price.required' => 'Chưa nhập giá',
            'hunter_price_name.required' => 'Thời gian tuyển dụng chưa nhập',
            'hunter_pos_id.required' => 'Chưa chọn vị trí cần tuyển dụng',
            'hunter_time_id.required' => 'Chưa chọn thời gian tuyển dụng'
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $hunter_price = Hunter_price::findOrFail($id);
        $data = [];
        $data['hunter_price_name'] = $request->hunter_price_name;
        $data['hunter_price'] = $request->hunter_price;
        $data['hunter_pos_id'] = $request->hunter_pos_id;
        $data['hunter_time_id'] = $request->hunter_time_id;
        $hunter_price->update($data);
        return redirect()->route('hunter_price.index')->with('success','Sửa thành công ');
    }


    public function destroy($id)
    {
        Hunter_price::findOrFail($id)->delete();
        return redirect()->route('hunter_price.index')->with('success','Xóa thành công ');
    }
}
