<?php

namespace App\Http\Controllers\Staff;
use App\Course\Category_course;
use App\Course\Courses;
use App\Course\Course_employee;
use App\Course\Course_chapters;
use App\Course\Course_chapter_contents;
use App\Course\Course_content_voucher;
use App\Course\Course_content_voucher_answer;
use App\Course\Course_tag;
use App\Course\Course_feedback;
use App\Course\Course_join_formality;
use Illuminate\Http\Request;
use App\Http\Controllers\Staff\SiteStaffController;

class CourseFeedbackController extends SiteStaffController
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
        $list_feedback = Course_feedback::join('employees', 'course_feedback.employee_id', 'employees.employee_id')
        ->join('courses', 'course_feedback.course_id', 'courses.course_id')->orderBy('course_feedback_id','desc');
        $list_feedback = $list_feedback->paginate($num);
        $list_feedback->appends(request()->query());
        return view('staff_admin.course_feedback.list', compact('list_feedback'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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
        $course_feedback = Course_feedback::join('employees', 'course_feedback.employee_id', 'employees.employee_id')
        ->join('courses', 'course_feedback.course_id', 'courses.course_id')
        ->where('course_feedback_id', $id)->first();
        return view('staff_admin.course_feedback.edit', compact('course_feedback'));
    }


    public function update(Request $request, $id)
    {

        $update = Course_feedback::where('course_feedback_id', $id)->update([
            'course_feedback_descript' => $request->input('course_feedback_descript'),
            'course_feedback_status' => $request->input('course_feedback_status'),
            'updated_at' => new \DateTime(),
        ]);
        return redirect(route('courseFeedback.index'))->with('success', 'Cập nhật phản hồi thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function courseFeedbackDestroy($id)
    {
        try {
            Course_feedback::where('course_feedback_id', $id)->delete();
            return redirect(route('courseFeedback.index'))->with('success', 'Xóa phản hồi thành công');
        } catch (\Exception $exception) {
            return redirect(route('courseFeedback.index'))->with('error', 'Xóa phản hồi thất bại');
        }
    }
}
