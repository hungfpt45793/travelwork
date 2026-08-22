<?php

namespace App\Http\Controllers\Staff;

use App\Course\Course_order;
use App\Course\Courses;
use App\Entity\Employee;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Job;
use App\Entity\JobFacebook;
use Illuminate\Http\Request;
use App\Http\Controllers\Staff\SiteStaffController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'baocao');
            return $next($request);
        });
    }


    public function candidates_register_course(Request $request)
    {
        $num = 30;
        $khac0 = Course_order::groupBy('course_id')->pluck('course_id')->toArray();
        $courses = new Courses();
        $list_courses = $courses->orderBy('courses.course_id', 'desc');

        if (!empty($request->input('course_id'))) {
            $list_courses = $list_courses->where('courses.course_id', $request->course_id);
        }

        if (!empty($request->input('all'))) {
            $list_courses = $list_courses->whereIn('courses.course_id', $khac0);
        }

        if (!empty($request->input('num'))) {
            $num = $request->input('num');
            $list_courses = $list_courses->paginate($num);
        } else {
            $list_courses = $list_courses->paginate($num);
        }

        $list_courses->appends(request()->query());
        return view('staff_admin.courses.candidates_register_course', compact('list_courses'));
    }

    public function candidates_apply_for_jobs(Request $request)
    {
        $num = 20;
        if($request->num) {
            $num = $request->num;
        }

        $jobs = new Job();
        $jobs = $jobs->select(
            'jobs.*',
            'employer.employer_id as employers_id ',
            'employer.enterprise_name',
            'employer.phone'
        );


        $jobs = $jobs->leftJoin('employer', 'employer.employer_id','jobs.employer_id');

        if (!empty($request->input('phone'))) {
            $title = $request->input('phone');
            $jobs = $jobs->where('employer.phone', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('enterprise_name'))) {
            $title = $request->input('enterprise_name');
            $jobs = $jobs->where('employer.enterprise_name', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title', 'like', '%' . $title . '%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('job_code'))) {
            $jobs = $jobs->where('jobs.job_code', $request->input('job_code'));
        }

        $jobs = $jobs->orderBy('jobs.job_id', 'desc');

        $jobs = $jobs->paginate($num);
        $jobs->appends(request()->query());
        return view('staff_admin.job.job_ntd.candidates_apply_for_jobs', compact('jobs'));
    }

    public function candidates_apply_for_jobs_fb(Request $request)
    {
        $num = 20;
        if($request->num) {
            $num = $request->num;
        }

        $job_facebook = new JobFacebook();
        $job_facebook = $job_facebook->select(
            'job_facebook.*',
            'employer.employer_id as employers_id ',
            'employer.enterprise_name',
            'employer.phone'
        );
        $job_facebook = $job_facebook->leftJoin('employer', 'employer.employer_id','job_facebook.employer_id');

        if (!empty($request->input('phone'))) {
            $title = $request->input('phone');
            $job_facebook = $job_facebook->where('employer.phone', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('enterprise_name'))) {
            $title = $request->input('enterprise_name');
            $job_facebook = $job_facebook->where('employer.enterprise_name', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $job_facebook = $job_facebook->where('job_facebook.title', 'like', '%' . $title . '%');
        }
        if (!empty($request->has('vip'))) {
            $job_facebook = $job_facebook->where('job_facebook.vip', $request->input('vip'));
        }
        if (!empty($request->input('job_facebook_code'))) {
            $job_facebook = $job_facebook->where('job_facebook.job_facebook_code', $request->input('job_facebook_code'));
        }

        $job_facebook = $job_facebook->orderBy('job_facebook.job_facebook_id', 'desc');

        $job_facebook = $job_facebook->paginate($num);
        $job_facebook->appends(request()->query());
        return view('staff_admin.job.job_facebook.candidates_apply_for_jobs_fb', compact('job_facebook'));
    }

    public function staff_employee_submit_job(Request $request){
        $num = 30;
        if(!empty($request->num)){
            $num = $request->num;
        }

        // $employees_submit = Employee_submit_job_faacebook::select(
        //     'employees.employee_id',
        //     'employees.employee_name',
        //     'jobs.job_id',
        //     'jobs.title',
        //     'jobs.slug',
        //     'employee_submit_job_facebook.*'
        // )
        // ->leftJoin('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
        // ->leftJoin('jobs', 'jobs.job_id', 'employee_submit_job_facebook.id_job_fb')
        // ->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc');

        $employees_submit = new Employee();
        $employees_submit = $employees_submit->join('employee_submit_job_facebook', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
                                            ->orderBy('employees.employee_id', 'desc')
                                            ->groupBy('employee_submit_job_facebook.employee_id');

        if(!empty($request->date_search_start)){
            $employees_submit = $employees_submit->whereDate('employee_submit_job_facebook.created_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $employees_submit = $employees_submit->whereDate('employee_submit_job_facebook.created_at', '<=', $request->date_search_end);
        }

        //        tìm tên ứng viên
        if (!empty($request->employee_name)) {
            $employees_submit = $employees_submit->where('employees.employee_name', 'like', '%' . $request->employee_name . '%');
        }

        if (!empty($request->email)) {
            $employees_submit = $employees_submit->where('employees.email', 'like', '%' . $request->email . '%');
        }

        $employees_submit = $employees_submit->paginate($num);
        return view('staff_admin.employee.employees_submit_job', compact('employees_submit'));
    }


    public function list_staff_employee_submit_job($employee_id)
    {

        $employee_model = new Employee();
        $employee = $employee_model->select('*')->where('employee_id',$employee_id)->first();

        $employees_submit = Employee_submit_job_faacebook::select(
            'employees.employee_id',
            'employees.employee_name',
            'jobs.job_id',
            'jobs.title',
            'jobs.slug',
            'employee_submit_job_facebook.*'
        )
        ->join('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
        ->join('jobs', 'jobs.job_id', 'employee_submit_job_facebook.id_job_fb')
        ->where('employee_submit_job_facebook.employee_id', $employee_id)
        ->where('employee_submit_job_facebook.status_job', 1)
        ->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc')->paginate(20);
        $total = $employees_submit->count();

        $employees_submit_fb = Employee_submit_job_faacebook::select(
            'employees.employee_id',
            'employees.employee_name',
            'job_facebook.job_facebook_id',
            'job_facebook.title',
            'job_facebook.slug',
            'employee_submit_job_facebook.*'
        )
        ->join('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
        ->join('job_facebook', 'job_facebook.job_facebook_id', 'employee_submit_job_facebook.id_job_fb')
        ->where('employee_submit_job_facebook.employee_id', $employee_id)
        ->where('employee_submit_job_facebook.status_job', 0)
        ->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc')->paginate(20);
        $total_fb = $employees_submit_fb->count();
        return view('staff_admin.employee.employees_submit_job_list', compact('employees_submit', 'employees_submit_fb', 'employee', 'total', 'total_fb'));
    }

    public function application_details_ntd(Request $request)
    {
        $num = 30;
        if(!empty($request->num)){
            $num = $request->num;
        }

        $employees_submit_ntd = Employee_submit_job_faacebook::select(
            'employees.employee_id',
            'employees.employee_name',
            'jobs.job_id',
            'jobs.title',
            'jobs.slug',
            'employee_submit_job_facebook.*'
        )
        ->join('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
        ->join('jobs', 'jobs.job_id', 'employee_submit_job_facebook.id_job_fb')
        ->where('employee_submit_job_facebook.status_job', 1)
        ->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc');
        if (!empty($request->employee_name)) {
            $employees_submit_ntd = $employees_submit_ntd->where('employees.employee_name', 'like', '%'.$request->employee_name.'%');
        }
        if (!empty($request->title)) {
            $employees_submit_ntd = $employees_submit_ntd->where('jobs.title', 'like', '%'.$request->title.'%');
        }
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $employees_submit_ntd = $employees_submit_ntd->whereDate('employee_submit_job_facebook.day_submit_job', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $employees_submit_ntd = $employees_submit_ntd->whereDate('employee_submit_job_facebook.day_submit_job', '<=', $request->date_search_end);
        }

        $employees_submit_ntd = $employees_submit_ntd->paginate($num);
        $employees_submit_ntd->appends(request()->query());

        return view('staff_admin.employee.application_details_ntd', compact('employees_submit_ntd'));

    }
    public function application_details_fb(Request $request)
    {
        $num = 30;
        if(!empty($request->num)){
            $num = $request->num;
        }

        $employees_submit_fb = Employee_submit_job_faacebook::select(
            'employees.employee_id',
            'employees.employee_name',
            'job_facebook.job_facebook_id',
            'job_facebook.title',
            'job_facebook.slug',
            'employee_submit_job_facebook.*'
        )
        ->join('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
        ->join('job_facebook', 'job_facebook.job_facebook_id', 'employee_submit_job_facebook.id_job_fb')
        ->where('employee_submit_job_facebook.status_job', 0)
        ->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc');

        if (!empty($request->employee_name)) {
            $employees_submit_fb = $employees_submit_fb->where('employees.employee_name', 'like', '%'.$request->employee_name.'%');
        }
        if (!empty($request->title)) {
            $employees_submit_fb = $employees_submit_fb->where('jobs.title', 'like', '%'.$request->title.'%');
        }
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $employees_submit_fb = $employees_submit_fb->whereDate('employee_submit_job_facebook.day_submit_job', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $employees_submit_fb = $employees_submit_fb->whereDate('employee_submit_job_facebook.day_submit_job', '<=', $request->date_search_end);
        }

        $employees_submit_fb = $employees_submit_fb->paginate($num);
        $employees_submit_fb->appends(request()->query());

        return view('staff_admin.employee.application_details_fb', compact('employees_submit_fb'));

    }

    public function dashboard_report()
    {
        $sub10day = Carbon::now('Asia/Ho_Chi_Minh')->subDays(10)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        $data10dayntd = Employee_submit_job_faacebook::select(DB::raw("COUNT(*) as count"))
        ->whereDate('day_submit_job','>=', $sub10day)
        ->whereDate('day_submit_job','<=', $now)
        ->where('status_job', 1)
        ->groupBy(DB::raw("Day(day_submit_job)"))
        ->pluck('count');

        $data10dayfb = Employee_submit_job_faacebook::select(DB::raw("COUNT(*) as count"))
        ->whereDate('day_submit_job','>=', $sub10day)
        ->whereDate('day_submit_job','<=', $now)
        ->where('status_job', 0)
        ->groupBy(DB::raw("Day(day_submit_job)"))
        ->pluck('count');

        $date10day = Employee_submit_job_faacebook::select('day_submit_job')
        ->whereDate('day_submit_job','>=', $sub10day)
        ->whereDate('day_submit_job','<=', $now)
        ->groupBy(DB::raw("Day(day_submit_job)"))
        ->pluck('day_submit_job');

        $date = [];
        foreach ($date10day as $value) {
            $date[] = date("d-m-Y", strtotime($value));
        }

        return view('staff_admin.dashboard.dashboard_report', compact('data10dayntd', 'data10dayfb', 'date'));
    }

    public function loc_ngay(Request $request)
    {
        $data10dayntd = Employee_submit_job_faacebook::select(DB::raw("COUNT(*) as count"))
        ->whereDate('day_submit_job','>=', $request->begin)
        ->whereDate('day_submit_job','<=', $request->end)
        ->where('status_job', 1)
        ->groupBy(DB::raw("Day(day_submit_job)"))
        ->pluck('count');

        $data10dayfb = Employee_submit_job_faacebook::select(DB::raw("COUNT(*) as count"))
        ->whereDate('day_submit_job','>=', $request->begin)
        ->whereDate('day_submit_job','<=', $request->end)
        ->where('status_job', 0)
        ->groupBy(DB::raw("Day(day_submit_job)"))
        ->pluck('count');

        $date10day = Employee_submit_job_faacebook::select('day_submit_job')
        ->whereDate('day_submit_job','>=', $request->begin)
        ->whereDate('day_submit_job','<=', $request->end)
        ->groupBy(DB::raw("Day(day_submit_job)"))
        ->pluck('day_submit_job');
        $date = [];
        foreach ($date10day as $value) {
            $date[] = date("d-m-Y", strtotime($value));
        }

        return response()->json([
            'data10dayntd' => $data10dayntd,
            'data10dayfb' => $data10dayfb,
            'date' => $date
        ]);
    }
}
