<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Hunter_time;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HunterTimeController extends AdminController
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
        $hunters_time = Hunter_time::get();
        return view('admin.hunter_time.index',compact('hunters_time'));
    }

    public function create()
    {
        return view('admin.hunter_time.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'hunter_time_name' => 'required',
            'hunter_time_name_small' => 'required',
        ],[
            'hunter_time_name.required' => 'Thời gian tuyển dụng chưa nhập',
            'hunter_time_name_small.required' => 'Thời gian tuyển dụng chưa nhập',
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $hunter_time = new Hunter_time();
        $hunter_time->hunter_time_name = $request->hunter_time_name;
        $hunter_time->hunter_time_name_small = $request->hunter_time_name_small;
        $hunter_time->save();
        return redirect()->route('hunter_time.index')->with('success','Tạo thành công');
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $hunter_time = Hunter_time::findOrFail($id);
        return view('admin.hunter_time.edit',compact('hunter_time'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'hunter_time_name' => 'required',
            'hunter_time_name_small' => 'required',
        ],[
            'hunter_time_name.required' => 'Thời gian tuyển dụng chưa nhập',
            'hunter_time_name_small.required' => 'Thời gian tuyển dụng chưa nhập',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $hunter_time = Hunter_time::findOrFail($id);
        $data = [];
        $data['hunter_time_name'] = $request->hunter_time_name;
        $data['hunter_time_name_small'] = $request->hunter_time_name_small;
        $hunter_time->update($data);
        return redirect()->route('hunter_time.index')->with('success','Sửa thành công ');
    }


    public function destroy($id)
    {
        Hunter_time::findOrFail($id)->delete();   
        return redirect()->route('hunter_time.index')->with('success','Xóa thành công ');
    }
}
