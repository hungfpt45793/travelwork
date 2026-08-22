<?php

namespace App\Http\Controllers\Staff;
use App\Course\Category_course;
use App\Course\Courses;
use App\Course\Course_chapters;
use App\Course\Course_chapter_contents;
use App\Course\Course_content_voucher;
use App\Course\Course_content_voucher_answer;
use App\Course\Course_join_formality;
use Illuminate\Http\Request;
use App\Http\Controllers\Staff\SiteStaffController;

class CategoryCourseController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'khoahoc');
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
        $category_course = new Category_course();
        $list_category_course = $category_course->select('*');
        $list_category_course = $list_category_course->paginate(20);
        return view('staff_admin.courses.list_cate', compact('list_category_course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff_admin.courses.add_cate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category_course = new Category_course();
        $category_course_id = $category_course->insertGetId([
            'category_course_title' => $request->input('category_course_title'),
            'category_course_desc' => $request->input('category_course_desc'),
            'category_course_content' => $request->input('category_course_content'),
            'created_at' => new \DateTime()
        ]);
        $postWithSlug = $category_course->where('category_course_slug', $request->category_course_slug)->first();
        if (empty($postWithSlug)) {
            $category_course->where('category_course_id', '=', $category_course_id)
                ->update([
                    'category_course_slug' => $request->category_course_slug
                ]);
        } else {
            $category_course->where('category_course_id', '=', $category_course_id)
                ->update([
                    'category_course_slug' => $request->category_course_slug . '-' . $category_course_id
                ]);
        }
        return redirect(route('categoryCourse.index'))->with('success', 'Thêm danh mục thành công');
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
        return view('staff_admin.courses.edit_cate', compact('category_course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category_course = new Category_course();
        $category_course_id = $category_course->where('category_course_id', $id)->update([
            'category_course_title' => $request->input('category_course_title'),
            'category_course_desc' => $request->input('category_course_desc'),
            'category_course_content' => $request->input('category_course_content'),
            'updated_at' => new \DateTime()
        ]);
        $postWithSlug = $category_course->where('category_course_slug', $request->category_course_slug)->where('category_course_id', '!=', $id)->first();
        if (empty($postWithSlug)) {
            $category_course->where('category_course_id', '=', $id)
                ->update([
                    'category_course_slug' => $request->category_course_slug
                ]);
        } else {
            $category_course->where('category_course_id', '=', $id)
                ->update([
                    'category_course_slug' => $request->category_course_slug . '-' . $id
                ]);
        }
        return redirect(route('categoryCourse.index'))->with('success', 'Cập nhật danh mục thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function categoryCourseDestroy($id)
    {
        $category_course = new Category_course();
        $delete_id = $category_course->where('category_course_id', $id)->delete();
        return redirect(route('categoryCourse.index'))->with('success', 'Xóa danh mục thành công');
    }

}
