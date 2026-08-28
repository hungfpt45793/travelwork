<?php

namespace App\Http\Controllers\Admin\Course;

use App\Course\Category_course;
use App\Entity\User;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CategoryCourseController extends AdminController
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
    public function index()
    {
        //
        $category_course = new Category_course();
        $list_category_course = $category_course->select('*');
        $list_category_course = $list_category_course->paginate(20);
        return view('admin.course.category_course.list', compact('list_category_course'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.course.category_course.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $category_course = new Category_course();
            $category_course_id = $category_course->insertGetId([
                'category_course_title' => $request->input('category_course_title'),
                'category_course_desc' => $request->input('category_course_desc'),
                'category_course_content' => $request->input('category_course_content'),
                'created_at' => new \DateTime()
            ]);
            $category_course_slug = Ultility::createSlug($request->input('category_course_title'));
            $postWithSlug = $category_course->where('category_course_slug', $category_course_slug)->first();
            if (empty($postWithSlug)) {
                $category_course->where('category_course_id', '=', $category_course_id)
                    ->update([
                        'category_course_slug' => $category_course_slug
                    ]);
            } else {
                $category_course->where('category_course_id', '=', $category_course_id)
                    ->update([
                        'category_course_slug' => $category_course_slug . '-' . $category_course_id
                    ]);
            }
            return redirect('admin/category_course')->with('success', 'Thêm danh mục thành công');
        } catch (\Exception $exception) {
            return redirect('admin/category_course')->with('error', 'Thên danh mục thất bại');
        }

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
    public function edit($id)
    {
        $category_course = new Category_course();
        $category_course = $category_course->select('*')->where('category_course_id', $id)->first();
        return view('admin.course.category_course.edit', compact('category_course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category_course_id)
    {
        //
        try {
            $category_course = new Category_course();
            $category_course_slug = Ultility::createSlug($request->input('category_course_title'));
            $category_course->where('category_course_id', $category_course_id)->update([
                'category_course_title' => $request->input('category_course_title'),
                'category_course_desc' => $request->input('category_course_desc'),
                'category_course_content' => $request->input('category_course_content'),
                'updated_at' => new \DateTime()
            ]);
            $postWithSlug = $category_course->where('category_course_slug', $category_course_slug)->first();
            if (empty($postWithSlug)) {
                $category_course->where('category_course_id', '=', $category_course_id)
                    ->update([
                        'category_course_slug' => $category_course_slug
                    ]);
            } else {
                $category_course->where('category_course_id', '=', $category_course_id)
                    ->update([
                        'category_course_slug' => $category_course_slug . '-' . $category_course_id
                    ]);
            }
            return redirect('admin/category_course')->with('success', 'Cập nhật danh mục thành công');
        } catch (\Exception $exception) {
            return redirect('admin/category_course')->with('error', 'Cập nhật danh mục thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($category_course_id)
    {
        try {
            $category_course = new Category_course();
            $delete_id = $category_course->where('category_course_id', $category_course_id)->delete();
            return redirect('admin/category_course')->with('success', 'Xóa danh mục thành công');
        } catch (\Exception $exception) {
            return redirect('admin/category_course')->with('error', 'Xóa danh mục thất bại');
        }
    }
}
