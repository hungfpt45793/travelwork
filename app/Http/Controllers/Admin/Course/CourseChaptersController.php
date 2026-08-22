<?php

namespace App\Http\Controllers\Admin\Course;

use App\Course\Category_course;
use App\Course\Course_chapter_contents;
use App\Course\Course_chapters;
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

class CourseChaptersController extends AdminController
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

    public function store_course_chapter(Request $request)
    {
        $course_chapter = new Course_chapters();
        $insert = $course_chapter->insertGetId([
            'course_id' => $request->input('course_id'),
            'course_chapter_name' => $request->input('course_chapter_name'),
            'course_chapter_status' => $request->input('course_chapter_status'),
            'course_chapter_descript' => $request->input('course_chapter_descript'),
            'course_chapter_content' => $request->input('course_chapter_content'),
            'created_at' => new \DateTime(),
        ]);
        return redirect()->back()->with('success', 'Thêm mới chương thành công');
    }

    public function update_course_chapter(Request $request)
    {
        $course_chapter = new Course_chapters();
        $course_chapter_id = $request->input('course_chapter_id');
        $update = $course_chapter->where('course_chapter_id',$course_chapter_id)
            ->update([
            'course_chapter_name' => $request->input('course_chapter_name'),
            'course_chapter_status' => $request->input('course_chapter_status'),
            'course_chapter_descript' => $request->input('course_chapter_descript'),
            'course_chapter_content' => $request->input('course_chapter_content'),
            'updated_at' => new \DateTime(),
        ]);
        return redirect()->back()->with('success', 'Cập nhật chương thành công');
    }

    public function delete_course_chapter(Request $request,$course_chapter_id)
    {
        $course_chapter = new Course_chapters();
        $update = $course_chapter->where('course_chapter_id',$course_chapter_id)
            ->delete();
        return redirect()->back()->with('success', 'Xóa chương thành công');
    }
    public function list_chapters(Request $request,$course_chapter_id)
    {
        $course_chapter = new Course_chapters();
        $course_chapter = $course_chapter->select('course_id','course_chapter_name','course_chapter_id')->where('course_chapter_id',$course_chapter_id)->first();
        $course_chapter_content = new Course_chapter_contents();
        $list_chapter_content = $course_chapter_content->select('*')->where('course_chapter_id',$course_chapter_id)->get();
        $total_chapter_content = $course_chapter_content->select('*')->where('course_chapter_id',$course_chapter_id)->count();

        $course_title = Courses::where('course_id',$course_chapter->course_id)->value('course_title');

        return view('admin.course.course_chapter.list', compact('course_chapter','list_chapter_content','total_chapter_content','course_title'));
//        return redirect()->back()->with('success', 'Cập nhật chương thành công');
    }


}
