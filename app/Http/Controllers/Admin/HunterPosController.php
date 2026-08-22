<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Hunter_pos;
use App\Entity\Hunter_price;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HunterPosController extends AdminController
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
        $hunters_pos = Hunter_pos::get();
        return view('admin.hunter_pos.index',compact('hunters_pos'));
    }

    public function create()
    {
        return view('admin.hunter_pos.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'hunter_pos_name' => 'required',
        ],[
            'hunter_pos_name.required' => 'Tên vị trí tuyển dụng chưa nhập',
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $hunter_pos = new Hunter_pos();
        $hunter_pos->hunter_pos_name = $request->hunter_pos_name;
        $hunter_pos->save();
        return redirect()->route('hunter_pos.index')->with('success','Tạo thành công');
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $hunter_pos = Hunter_pos::findOrFail($id);
        return view('admin.hunter_pos.edit',compact('hunter_pos'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'hunter_pos_name' => 'required',
        ],[
            'hunter_pos_name.required' => 'Tên vị trí tuyển dụng chưa nhập',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $hunter_pos = Hunter_pos::findOrFail($id);
        $data = [];
        $data['hunter_pos_name'] = $request->hunter_pos_name;
        $hunter_pos->update($data);
        return redirect()->route('hunter_pos.index')->with('success','Sửa thành công ');
    }


    public function destroy($id)
    {
        Hunter_pos::findOrFail($id)->delete();   
        Hunter_price::where('hunter_pos_id', $id)->delete();   
        return redirect()->route('hunter_pos.index')->with('success','Xóa thành công ');
    }
}
