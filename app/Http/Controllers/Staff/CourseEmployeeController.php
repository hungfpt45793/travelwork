<?php

namespace App\Http\Controllers\Staff;
use App\Course\Category_course;
use App\Course\Courses;
use App\Course\Course_employee;
use App\Course\Course_chapters;
use App\Course\Course_chapter_contents;
use App\Course\Course_content_voucher;
use App\Course\Course_content_voucher_answer;
use App\Course\Course_join_formality;
use Illuminate\Http\Request;
use App\Http\Controllers\Staff\SiteStaffController;

class CourseEmployeeController extends SiteStaffController
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
        $course_employee_model = new Course_employee();
        $list_employee = $course_employee_model->select('course_employee.*', 'courses.course_code', 'courses.course_title', 'employees.employee_name', 'employees.phone', 'employees.email')
            ->join('employees', 'employees.employee_id', '=', 'course_employee.employee_id')
            ->join('courses', 'courses.course_id', '=', 'course_employee.course_id');
        if (!empty($request->input('activation_code'))) {
            $list_employee = $list_employee->where('course_employee.activation_code', $request->input('activation_code'));
        }
        if (!empty($request->input('course_code'))) {
            $list_employee = $list_employee->where('courses.course_code', $request->input('course_code'));
        }
        if (!empty($request->input('course_title'))) {
            $list_employee = $list_employee->where('courses.course_title', 'like', '%' . $request->input('course_title') . '%');
        }
        if (!empty($request->input('employee_name'))) {
            $list_employee = $list_employee->where('employees.employee_name', 'like', '%' . $request->input('employee_name') . '%');
        }
        if (!empty($request->input('email'))) {
            $list_employee = $list_employee->where('employees.email', 'like', '%' . $request->input('email') . '%');
        }
        if (!empty($request->input('phone'))) {
            $list_employee = $list_employee->where('employees.phone', 'like', '%' . $request->input('phone') . '%');
        }
        $list_employee = $list_employee->orderBy('course_employee.course_employee_id', 'desc')
            ->paginate(20);
        $list_employee->appends(request()->query());
        return view('staff_admin.course_employee.list', compact('list_employee'));
    }
}
