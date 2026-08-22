<?php

namespace App\Http\Controllers\Admin\Course;

use App\Course\Category_course;
use App\Course\Course_chapters;
use App\Course\Course_tag;
use App\Course\Courses;
use App\Entity\Teacher;
use App\Entity\User;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CourseTagController extends AdminController
{
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
    public function index(Request $request)
    {
        //
        $list_tag = Course_tag::select('*')->orderBy('tag_id','desc')->get();
        return view('admin.course.course_tag.list', compact('list_tag'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.course.course_tag.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */



    public function store(Request $request)
    {

//        try {
        $tag_id = Course_tag::insertGetId([
            'tag_title' => $request->input('tag_title'),
            'created_at' => new \DateTime(),
        ]);
        $tag_slug = Ultility::createSlug($request->input('tag_title'));
        $postWithSlug = Course_tag::where('tag_id', $tag_id)->first();
        if (empty($postWithSlug)) {
            Course_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug
                ]);
        } else {
            Course_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug . '-' . $tag_id
                ]);
        }
        return redirect('admin/course_tag')->with('success', 'Thêm mới từ khóa thành công');
//        } catch (\Exception $exception) {
//            return redirect('admin/category_course')->with('error', 'Thên danh mục thất bại');
//        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tag_id)
    {
        $course_tag = Course_tag::where('tag_id', '=', $tag_id)
            ->first();
        return view('admin.course.course_tag.edit', compact('course_tag'));
    }


    public function update(Request $request, $tag_id)
    {

        $update = Course_tag::where('tag_id', $tag_id)->update([
            'tag_title' => $request->input('tag_title'),
            'updated_at' => new \DateTime(),
        ]);

        $tag_slug = Ultility::createSlug($request->input('tag_title'));
        $postWithSlug = Course_tag::where('tag_id', $tag_id)->first();
        if (empty($postWithSlug)) {
            Course_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug
                ]);
        } else {
            Course_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug . '-' . $tag_id
                ]);
        }
        return redirect('admin/course_tag')->with('success', 'Cập nhật từ khóa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tag_id)
    {
        try {
            Course_tag::where('tag_id', '=', $tag_id)->delete();
            return redirect('admin/course_tag')->with('success', 'Xóa từ khóa thành công');
        } catch (\Exception $exception) {
            return redirect('admin/course_tag')->with('error', 'Xóa từ khóa thất bại');
        }
    }
}
