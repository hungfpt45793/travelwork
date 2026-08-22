<?php

namespace App\Http\Controllers\Staff;
use App\Course\Category_course;
use App\Course\Course_chapters;
use App\Course\Course_order;
use App\Course\Course_questions;
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
use App\Http\Controllers\Staff\SiteStaffController;
use Illuminate\Support\Facades\Validator;

class CourseQuestionsController extends SiteStaffController
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
    public function index(Request $request)
    {
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        $course_questions = Course_questions::join('users', 'course_questions.user_id', 'users.id')
        ->join('courses', 'course_questions.course_id', 'courses.course_id')
        ->orderBy('course_comments_id','desc');
        $course_questions = $course_questions->paginate($num);
        $course_questions->appends(request()->query());
        return view('staff_admin.course_questions.list', compact('course_questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function store(Request $request)
    {

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
        $course_questions = Course_questions::join('users', 'course_questions.user_id', 'users.id')
        ->join('courses', 'course_questions.course_id', 'courses.course_id')
        ->where('course_comments_id', $id)->first();
        return view('staff_admin.course_questions.edit', compact('course_questions'));
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
        $update = Course_questions::where('course_comments_id', $id)->update([
            'course_comments_content' => $request->input('course_comments_content'),
            'course_comments_status' => $request->input('course_comments_status'),
            'updated_at' => new \DateTime(),
        ]);
        return redirect(route('courseQuestions.index'))->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function courseQuestionsDestroy($id)
    {
        try {
            $courses_model = new Course_questions();
            $delete_id = $courses_model->where('course_comments_id', $id)->delete();
            return redirect(route('courseQuestions.index'))->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect(route('courseQuestions.index'))->with('error', 'Xóa thất bại');
        }
    }
}
