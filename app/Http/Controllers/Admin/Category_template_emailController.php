<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category_template_email;
use App\Entity\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Category_template_emailController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'template_email');

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category_template_email_model = new Category_template_email();
        $list_cate = $category_template_email_model->orderBy('id_cate_tem','desc')->paginate(50);
        return view('admin.template_email.category.list',compact('list_cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.template_email.category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        $validation = Validator::make($request->all(), [
//            'email' => 'required|unique:users',
//            'password' => 'required|min:8',
//            'employee_name' => 'required',
//        ], [
////            'enterprise_id.unique' => 'Email đã tồn tại.',
//            'password.required' => 'Bạn chưa nhập mật khẩu.',
//            'email.required' => 'Bạn chưa nhập email.',
//            'email.unique' => 'Email đã tồn tại.',
//            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
//            'employee_name.required' => 'Tên công ty không được bỏ trống',
//
//        ]);
//        try
//        {
            $category_template_email_model = new Category_template_email();
            $slug = \App\Ultility\Ultility::createSlug($request->input('name_cate_tem'));
            $insert = $category_template_email_model->insertGetId([
                'name_cate_tem' => $request->input('name_cate_tem'),
                'slug_cate_tem' => $slug,
                'note_tem_var' => $request->input('note_tem_var'),
                'created_at' => new \DateTime()
            ]);
            return redirect(route('category_template_email.index'))->with('success','Thêm thành công');
//        }
//        catch (\Exception $e)
//        {
//            return redirect(route('category_template_email.index'))->with('error','Thêm thất bại');
//        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_template_email_model = new Category_template_email();
        $cate = $category_template_email_model->select('*')->where('id_cate_tem',$id)->first();
        return view('admin.template_email.category.edit',compact('cate'));
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
        try
        {
            $category_template_email_model = new Category_template_email();
            $slug = \App\Ultility\Ultility::createSlug($request->input('name_cate_tem'));
            $update = $category_template_email_model->where('id_cate_tem',$id)->update([
                'name_cate_tem' => $request->input('name_cate_tem'),
                'slug_cate_tem' => $slug,
                'note_tem_var' => $request->input('note_tem_var'),
                'updated_at' => new \DateTime()
            ]);
            return redirect(route('category_template_email.index'))->with('success','Cập nhật thành công');
        }
        catch (\Exception $e)
        {
            $e->getMessage();
            return redirect(route('category_template_email.index'))->with('error','Cập nhật thất bại');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
