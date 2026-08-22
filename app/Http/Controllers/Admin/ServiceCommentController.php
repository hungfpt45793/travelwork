<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Service_comment;
use App\Entity\Service_table_price;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class ServiceCommentController extends AdminController
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
        $service_comments = Service_comment::leftJoin('service_table_price','service_table_price.service_table_price_id','service_comment.service_table_price_id')
        ->leftJoin('service_price','service_price.service_price_id','service_comment.service_price_id')
        ->select('service_comment.*','service_table_price.package_name','service_price.service_price_title')
        ->get();
        return view('admin.service_comment.index',compact('service_comments'));
    }

    public function create()
    {
        return view('admin.service_comment.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'service_comment_content' => 'required',
            'service_comment_image' => 'required',
            'service_table_price_id' => 'required',
            'service_price_id' => 'required',
        ],[
            'service_comment_content.required' => 'Nội dung comment chưa nhập',
            'service_comment_image.required' => 'Chưa chọn ảnh',
            'service_table_price_id.required' => 'Chưa chọn gói dịch vụ',
            'service_price_id.required' => 'Chưa chọn dịch vụ',
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_comment = new Service_comment();
        $service_comment->service_comment_name = $request->service_comment_name;
        $service_comment->service_comment_content = $request->service_comment_content;
        $service_comment->service_comment_image = $request->service_comment_image;
        $service_comment->service_table_price_id = $request->service_table_price_id;
        $service_comment->service_price_id = $request->service_price_id;
        $service_comment->save();
        return redirect()->route('service_comment.index')->with('success','Tạo thành công comment');
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $service_comment = Service_comment::findOrFail($id);
        return view('admin.service_comment.edit',compact('service_comment'));
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
            'service_comment_content' => 'required',
            'service_comment_image' => 'required',
            'service_table_price_id' => 'required',
            'service_price_id' => 'required',
        ],[
            'service_comment_content.required' => 'Nội dung comment chưa nhập',
            'service_comment_image.required' => 'Chưa chọn ảnh',
            'service_table_price_id.required' => 'Chưa chọn gói dịch vụ',
            'service_price_id.required' => 'Chưa chọn dịch vụ',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    //    dd($request->service_comment_image);
        // $service_comment = Service_comment::find($id);
        $data = [];
        $data['service_comment_name'] = $request->service_comment_name;
        $data['service_comment_content'] = $request->service_comment_content;
        $data['service_comment_image'] = $request->service_comment_image;
        $data['service_table_price_id'] = $request->service_table_price_id;
        $data['service_price_id'] = $request->service_price_id;
    //     echo $request->service_comment_image;
    //    dd($data);
        Service_comment::where('service_comment_id',$id)->update($data);
        // dd($service_comment);
        return redirect()->route('service_comment.index')->with('success','Sửa thành công comment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service_comment::findOrFail($id)->delete();   
        return redirect()->route('service_comment.index')->with('success','Xóa thành công comment');
    }
    public function ajaxServiceTable(Request $request)
    {
       
        $services_table_price = Service_table_price::where('service_price_id',$request->service_price_id)->get();
        return $services_table_price;   
    }
}
