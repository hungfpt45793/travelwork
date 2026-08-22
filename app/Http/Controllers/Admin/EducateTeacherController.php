<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Educate_teacher;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EducateTeacherController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if (!User::isCreater($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'educate');
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $educate_teacher = new Educate_teacher();
        $educate_teacher = $educate_teacher->select('*')->orderBy('edu_tea_id','desc');
        $total = $educate_teacher->count();
        $educate_teacher = $educate_teacher->paginate(20);
        $educate_teacher->appends(request()->query());
        return view('admin.education.educate_teacher.list', compact('educate_teacher', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.education.educate_teacher.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $edu_tea_slug = Ultility::createSlug($request->input('edu_tea_name'));

            $edu_teacher = new Educate_teacher();
            $edu_tea_id = $edu_teacher->insertGetId([
                'edu_tea_name' => $request->input('edu_tea_name'),
                'edu_tea_slug' => $edu_tea_slug,
                'edu_tea_email' => $request->input('edu_tea_email'),
                'edu_tea_phone' => $request->input('edu_tea_phone'),
                'edu_tea_image' => $request->input('edu_tea_image'),
                'edu_tea_content' => $request->input('edu_tea_content'),
                'user_id' => Auth::user()->id,
                'created_at' => new \DateTime(),
            ]);

            $postWithSlug = $edu_teacher->where('edu_tea_slug', $edu_tea_slug)->first();
            if (empty($postWithSlug)) {
                $edu_teacher->where('edu_tea_id', '=', $edu_tea_id)
                    ->update([
                        'edu_tea_slug' => $edu_tea_slug
                    ]);
            } else {
                $edu_teacher->where('edu_tea_id', '=', $edu_tea_id)
                    ->update([
                        'edu_tea_slug' => $edu_tea_slug.'-'.$edu_tea_id
                    ]);
            }
            return redirect('admin/educate_teacher')->with('success','Thêm thành công');
        }catch (\Exception $e)
        {
            return redirect('admin/educate_teacher')->with('error','Thêm thất bại');
        }

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
        $educate_teacher = new Educate_teacher();
        $educate_teacher = $educate_teacher->where('edu_tea_id',$id)->first();
        return view('admin.education.educate_teacher.edit', compact('educate_teacher'));
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
            $edu_tea_slug = Ultility::createSlug($request->input('edu_tea_name'));

            $edu_teacher = new Educate_teacher();
            $edu_tea_id = $edu_teacher->where('edu_tea_id',$id)->update([
                'edu_tea_name' => $request->input('edu_tea_name'),
                'edu_tea_slug' => $edu_tea_slug,
                'edu_tea_email' => $request->input('edu_tea_email'),
                'edu_tea_phone' => $request->input('edu_tea_phone'),
                'edu_tea_image' => $request->input('edu_tea_image'),
                'edu_tea_content' => $request->input('edu_tea_content'),
                'user_id' => Auth::user()->id,
                'updated_at' => new \DateTime(),
            ]);

            $postWithSlug = $edu_teacher->where('edu_tea_slug', $edu_tea_slug)->first();
            if (empty($postWithSlug)) {
                $edu_teacher->where('edu_tea_id', '=', $edu_tea_id)
                    ->update([
                        'edu_tea_slug' => $edu_tea_slug
                    ]);
            } else {
                $edu_teacher->where('edu_tea_id', '=', $edu_tea_id)
                    ->update([
                        'edu_tea_slug' => $edu_tea_slug.'-'.$edu_tea_id
                    ]);
            }
            return redirect('admin/educate_teacher')->with('success','Thêm thành công');
        }catch (\Exception $e)
        {
            return redirect('admin/educate_teacher')->with('error','Thêm thất bại');
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
        $edu_teacher = new Educate_teacher();
        $edu_teacher = $edu_teacher->where('edu_tea_id',$id)->delete();
        return redirect('admin/educate_teacher');
    }
}
