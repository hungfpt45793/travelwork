<?php

namespace App\Http\Controllers\Staff;

use App\Support\SpreadsheetFile;

use App\Entity\Employee_move_teacher;
use App\Entity\Teacher;
use App\Http\Controllers\Site\Upload_FileController;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Entity\Staff;
use App\Entity\Employee_profile;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_specialize;
use App\Http\Controllers\Staff\SiteStaffController;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Entity\Employee;
use App\Entity\Employee_upload_cv;
use App\Entity\Statistical_employees;
use App\Entity\Employee_experience;
use App\Entity\Employee_handling;
use App\Entity\Employee_specialize;
use App\Entity\Interactive_history_employee;
use Illuminate\Support\Facades\Auth;
use App\Entity\Software;
use App\Entity\Career;
use App\Entity\Salary;
use App\Entity\Task;
use App\Entity\Task_detail;
use App\Entity\Task_completed;
use App\Entity\Staff_follow;
use App\Entity\Cv_employee;
use App\Entity\Job;
use App\Entity\User;
use Illuminate\Support\Facades\DB;
use App\Ultility\Error;
use Illuminate\Support\Facades\Validator;
use App\Entity\District;
use App\Entity\Province;
use App\Entity\Employee_delete_request;
use App\Entity\MailConfig;
use App\Entity\Template_email;
use App\Entity\Literacy;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Category_template_email;
use App\Entity\Employee_career_categories;
use App\Entity\Employee_district;
use PDF;
use PDFMerger;
use Illuminate\Support\Facades\File;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;
use NcJoes\PopplerPhp\PdfInfo;
use NcJoes\PopplerPhp\Config;
use NcJoes\PopplerPhp\PdfToCairo;
use NcJoes\PopplerPhp\PdfToHtml;
use NcJoes\PopplerPhp\Constants as C;

class EmployeeController extends SiteStaffController
{
    function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'employee');
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $num = 20;
        if($request->num) {
            $num = $request->num;
        }
        $emplooyee = new Employee();
        $employees = $emplooyee->select(
            'employees.employee_id',
            'employees.phone',
            'employees.created_at',
            'employees.updated_at',
            'employees.employee_name',
            'employees.employee_image',
            'employees.email',
            'employees.user_id',
            'employees.status',
            'employees.profile',
            'employees.birthday',
            'employees.status_employee',
            // 'employees.user_id_handling',
            // 'employees.day_handling',
            // 'u1.status_email_account',
            // 'u2.name',
            // 'interactive_history_employee.interactive_day',
            'employee_upload_cv.employee_cv_status'
        )
        // ->join('users as u1', 'u1.id', 'employees.user_id')
        // ->leftJoin('users as u2', 'employees.user_id_handling', '=', 'u2.id')

        ->leftJoin('employee_upload_cv', 'employees.employee_id','employee_upload_cv.employee_id')
        // ->groupBy('employees.employee_id')
        ->orderBy('employees.updated_at', 'desc');
        // tìm theo id uv
        if (!empty($request->employee_id)) {
            $employees = $employees->where('employees.employee_id', $request->employee_id);
        }
        //tìm theo cv mong muốn
        // if (!empty($request->input('career_category_id'))) {
        //     $array_carrer = $request->input('career_category_id');
        //     if(!empty($array_carrer[0]))
        //     {
        //         $employees = $employees->join('employee_career_categories', 'employee_career_categories.employee_id', '=', 'employees.employee_id');
        //         $employees = $employees->join('career_categories', 'career_categories.career_category_id', '=', 'employee_career_categories.career_category_id');
        //         $career_category_id = $request->input('career_category_id');
        //         $employees = $employees->whereIn('employees.career_category_id', $career_category_id);
        //     }
        // }
        //tìm theo kinh nghiệm
        // if (!empty($request->input('business_id'))) {
        //         $employees = $employees->join('employee_business_type', 'employee_business_type.employee_id', '=', 'employees.employee_id');
        //         $employees = $employees->join('business_type', 'business_type.business_type_id', '=', 'employee_business_type.business_type_id');
        //         $employee_business_type = $request->input('business_id');
        //         $employees = $employees->whereIn('employee_business_type.business_type_id', $employee_business_type);
        // }
        //tìm theo tỉnh thành
        // if (!empty($request->input('province'))) {
        //     $employees = $employees->where('employees.province', $request->input('province'));
        // }
        //tìm quận của uv
        // if (!empty($request->input('district_id'))) {
        //     //join với quận huyện
        //     $employees = $employees->join('employee_district', 'employee_district.employee_id', '=', 'employees.employee_id');
        //     $employees = $employees->join('district', 'district.district_id', '=', 'employee_district.district_id');
        //     $district_id = $request->input('district_id');
        //     $employees = $employees->whereIn('employee_district.district_id', $district_id);
        // }
        //tìm theo quận huyện của 63 tỉnh
        // if (!empty($request->district)) {
        //     $employees = $employees->where('employees.district', $request->district);
        // }
        // tìm theo mức lương
        // if (!empty($request->salary_id)) {
        //     $employees = $employees->where('employees.salary_id', $request->salary_id);
        // }
        //tìm theo trạng thái
        if ($request->status_employee != null && $request->status_employee != "") {
            $employees = $employees->where('employees.status_employee', $request->status_employee);
        }
        //tìm theo trạng thái đi làm
        if ($request->status != null && $request->status != "") {
            $employees = $employees->where('employees.status', $request->status);
        }
        // tìm theo năm sinh
        if (!empty($request->birthday)) {
            $employees = $employees->whereYear('employees.birthday', $request->birthday);
        }
        // tìm theo tên uv
        if (!empty($request->employee_name)) {
            $employees = $employees->where('employees.employee_name', 'like', '%'.$request->employee_name.'%');
        }
        // tìm theo email uv
        if (!empty($request->email)) {
            $employees = $employees->where('employees.email', 'like', '%'.$request->email.'%');
        }
        // tìm theo ngày from
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '<=', $request->date_search_end);
        }
        if (!empty($request->course_id)) {
            $employees = $employees->join('course_order','employees.user_id' ,'course_order.user_id')->where('course_order.course_id', $request->course_id);
        }
        if (!empty($request->job_id)) {
            $employees = $employees->join('employee_submit_job_facebook','employees.employee_id' ,'employee_submit_job_facebook.employee_id')->where('employee_submit_job_facebook.id_job_fb', $request->job_id)->where('status_job', 1);
        }
        if (!empty($request->job_facebook_id)) {
            $employees = $employees->join('employee_submit_job_facebook','employees.employee_id' ,'employee_submit_job_facebook.employee_id')->where('employee_submit_job_facebook.id_job_fb', $request->job_facebook_id)->where('status_job', 0);
        }
        switch (url()->current()) {
            case route('list_employee_approved'):
                $employees = $employees->where('status_employee', 1);
                break;
            case route('list_employee_no_approved'):
                $employees = $employees->where('status_employee', 0)
                ->leftJoin('interactive_history_employee','employees.employee_id', 'interactive_history_employee.employee_id');
                // 5 button trong báo cáo uv chưa duyệt
                if (!empty($request->employee0to20)) {
                    $employees = $employees->where('profile', '<=', 20);
                }
                if (!empty($request->employee20to40)) {
                    $employees = $employees->whereBetween('profile', [20, 40]);
                }
                if (!empty($request->employee40to60)) {
                    $employees = $employees->whereBetween('profile', [40, 60]);
                }
                if (!empty($request->employee60toMax)) {
                    $employees = $employees->where('profile', '>=', 60);
                }
                if (!empty($request->interacted)) {
                    $employees = $employees->where('interactive_history_employee.interactive_day', '!=', null)
                    ->groupBy('interactive_history_employee.employee_id');
                }
                break;
            case route('employee0To20'):
                $employees = $employees->where('employees.profile','<=', 20);
                break;
            case route('employee20To40'):
                $employees = $employees->whereBetween('profile', [20, 40]);
                break;
            case route('employee40To60'):
                $employees = $employees->whereBetween('profile', [40, 60]);
                break;
            case route('employee60ToMax'):
                $employees = $employees->where('employees.profile','>=', 60);
                break;
            case route('list_employee_follow'):
                $user_id = Auth::id();
                $staff_id = Staff::where('user_id',$user_id)->value('staff_id');
                $employees = $employees->leftJoin('staff_follow','staff_follow.user_id','employees.user_id')
                                        ->where('staff_follow.status_follow',1)
                                        ->where('staff_follow.staff_id', $staff_id);
                break;
        }
        $employees = $employees->paginate($num);
        $employees->appends(request()->query());
        return view('staff_admin.employee.list', compact('employees'));
    }

    public function show($employee_id)
    {

        $employee = Employee::findOrFail($employee_id);

        $cv_upload = Employee_upload_cv::where('employee_id', $employee_id)->where('employee_cv_status', 1)->first();
        $check_employee_cv = Cv_employee::where('employee_id', $employee_id)->value('cv_id');
        $staff = Staff::select('staff_id')->where('user_id', Auth::id())->first();
        $employee = Employee::select(
            'employees.*',
            'users.status_email_account',
            'salary.description as salary'
        )
        ->join('users', 'users.id', 'employees.user_id')
        ->leftJoin('salary', 'salary.salary_id', 'employees.salary_id')
        ->where('employees.employee_id', $employee_id)->first();


        //lấy các công việc mong muốn của ứng viên
        $careers_array = Employee_career_categories::where('employee_career_categories.employee_id', $employee_id)
        ->join('career_categories', 'career_categories.career_category_id', 'employee_career_categories.career_category_id')
        ->pluck('career_categories.career_category_name')->toArray();

        $careers = implode(" | ", $careers_array);
        $employee->careers = $careers;

        //Lấy danh sách khu vực uv cần tìm việc
        $district_array = Employee_district::where('employee_district.employee_id', $employee_id)
        ->join('district', 'district.district_id', 'employee_district.district_id')->pluck('district_name')->toArray();
        $districts = implode(', ', $district_array);
        $province_name = Province::where('province_id', $employee->province)->value('province_name');
        $areas = $province_name . ' - ' .$districts;
        $employee->areas = $areas;


        $staff_follow = Staff_follow::where('staff_id', $staff->staff_id)
        ->where('user_id', $employee->user_id)->first();
        $employee_profile = Employee_profile::select(
            'profile_info',
            'profile_cv',
            'profile_course',
            'profile_avg',
            'profile_staff'
        )->where('employee_id', $employee_id)->first();
        if($cv_upload){
            $link_cv_upload = str_replace('/public', '',$cv_upload->employee_link_cv);
            $link_cv_upload = asset($link_cv_upload);
        }
        else{
            $link_cv_upload = null;
        }
        if(isset($cv_upload)){
            $link_cv = $link_cv_upload;
        }
        else {
            if(isset($check_employee_cv)){
                $link_cv = route('exportpdf_cv_user_id', $employee->user_id);
            }
            else{
                $link_cv = 0;
            }
        }
        return view('staff_admin.employee.show', compact('link_cv', 'employee', 'employee_profile', 'staff_follow'));
    }

    public function assignment_list(Request $request)
    {
        $num = 20;
        if($request->num) {
            $num = $request->num;
        }

        //ddax thaay ddooir
        $assignment_list_has_changed = Task_detail::select(
            'task_detail.task_detail_id',
            'task_detail.giver_day',
            'employees.employee_name',
            'staff1.staff_name as giver_name',
            'staff2.staff_name as recipient_name',
            'task_detail.profile as profile_td',
            'task_detail.approved',
            //keets quar
            'employees.profile as profile_result',
            'employees.status_employee',
            'task_completed.removed'
        )
        ->join('employees', 'task_detail.employee_id', 'employees.employee_id')
        ->join('staff as staff1', 'task_detail.giver_id', 'staff1.staff_id')
        ->join('staff as staff2', 'task_detail.recipient_id', 'staff2.staff_id')
        ->leftJoin('task_completed', 'task_detail.task_detail_id', 'task_completed.task_detail_id')
        ->whereColumn('task_detail.profile', '!=', 'employees.profile')
        ->orWhere('task_completed.removed', 1)
        ->orderBy('task_detail.giver_day', 'desc');

        $arrTask = $assignment_list_has_changed->pluck('task_detail.task_detail_id')->toArray();


        // tìm theo ten uv
        if (!empty($request->employee_name)) {
            $assignment_list_has_changed = $assignment_list_has_changed->where('employees.employee_name', 'like', '%'.$request->employee_name.'%');
        }
        // tìm theo nguoi giao
        if (!empty($request->giver_name)) {
            $assignment_list_has_changed = $assignment_list_has_changed->where('staff1.staff_name', 'like', '%'.$request->giver_name.'%');
        }
        // tìm theo nguoi nhan
        if (!empty($request->recipient_name)) {
            $assignment_list_has_changed = $assignment_list_has_changed->where('staff2.staff_name', 'like', '%'.$request->recipient_name.'%');
        }
        // tìm theo ngày from
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $assignment_list_has_changed = $assignment_list_has_changed->whereDate('task_detail.giver_day', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $assignment_list_has_changed = $assignment_list_has_changed->whereDate('task_detail.giver_day', '<=', $request->date_search_end);
        }

        //chuaw thaay ddooir
        $assignment_list_has_not_changed = Task_detail::select(
            'task_detail.task_detail_id',
            'task_detail.giver_day',
            'employees.employee_name',
            'staff1.staff_name as giver_name',
            'staff2.staff_name as recipient_name',
            'task_detail.profile as profile_td',
            'task_detail.approved',
            //keets quar
            'employees.profile as profile_result',
            'employees.status_employee',
            'task_completed.removed'
        )
        ->join('employees', 'task_detail.employee_id', 'employees.employee_id')
        ->join('staff as staff1', 'task_detail.giver_id', 'staff1.staff_id')
        ->join('staff as staff2', 'task_detail.recipient_id', 'staff2.staff_id')
        ->leftJoin('task_completed', 'task_detail.task_detail_id', 'task_completed.task_detail_id')
        ->whereNotIn('task_detail.task_detail_id', $arrTask)
        ->orderBy('task_detail.giver_day', 'desc');

        // tìm theo ten uv
        if (!empty($request->employee_name)) {
            $assignment_list_has_not_changed = $assignment_list_has_not_changed->where('employees.employee_name', 'like', '%'.$request->employee_name.'%');
        }
        // tìm theo nguoi giao
        if (!empty($request->giver_name)) {
            $assignment_list_has_not_changed = $assignment_list_has_not_changed->where('staff1.staff_name', 'like', '%'.$request->giver_name.'%');
        }
        // tìm theo nguoi nhan
        if (!empty($request->recipient_name)) {
            $assignment_list_has_not_changed = $assignment_list_has_not_changed->where('staff2.staff_name', 'like', '%'.$request->recipient_name.'%');
        }
        // tìm theo ngày from
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $assignment_list_has_not_changed = $assignment_list_has_not_changed->whereDate('task_detail.giver_day', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $assignment_list_has_not_changed = $assignment_list_has_not_changed->whereDate('task_detail.giver_day', '<=', $request->date_search_end);
        }


        $assignment_list_has_not_changed = $assignment_list_has_not_changed->paginate($num);
        $assignment_list_has_not_changed->appends(request()->query());

        $assignment_list_has_changed = $assignment_list_has_changed->paginate($num);
        $assignment_list_has_changed->appends(request()->query());

        return view('staff_admin.employee.assignment_list', compact('assignment_list_has_not_changed', 'assignment_list_has_changed'));
    }
    public function daily_task_list(Request $request)
    {
        $num = 20;
        if($request->num) {
            $num = $request->num;
        }

        //ddax thaay ddooir
        $arrDateHasChanged = Task_detail::select(
            'task_detail.task_detail_id',
            'task_detail.giver_day',
            'task_detail.recipient_id',
            'staff.staff_name',
            'task_completed.removed'
        )
        ->join('employees', 'task_detail.employee_id', 'employees.employee_id')
        ->join('staff', 'task_detail.recipient_id', 'staff.staff_id')
        ->leftJoin('task_completed', 'task_detail.task_detail_id', 'task_completed.task_detail_id')
        ->whereColumn('task_detail.profile', '!=', 'employees.profile')
        ->orWhere('task_completed.removed', 1)
        ->orderBy('task_detail.giver_day', 'desc');

        $arrTask = $arrDateHasChanged->pluck('task_detail.task_detail_id')->toArray();

        if(!empty($request->recipient_id)){
            $arrDateHasChanged = $arrDateHasChanged->where('recipient_id', $request->recipient_id);
        }
        // tìm theo ngày giao nhiem vu
        if(!empty($request->giver_day_start) ){
            $date_start = date_create($request->giver_day_start);
            $giver_day_start = date_format($date_start,"Y/m/d");
            $arrDateHasChanged = $arrDateHasChanged->whereDate('giver_day', '>=', $request->giver_day_start);
        }
        if(!empty($request->giver_day_end)){
            $date_end=date_create($request->giver_day_end);
            $giver_day_end = date_format($date_end,"Y/m/d");
            $arrDateHasChanged = $arrDateHasChanged->whereDate('giver_day', '<=', $request->giver_day_end);
        }

        $arrDateHasChanged = $arrDateHasChanged->get()->groupBy(function($item) {
            return $item->giver_day->format('Y-m-d');
        });

        // chuaw thaay ddooir
        $arrDateHasNotChanged = Task_detail::select(
            'task_detail.task_detail_id',
            'task_detail.giver_day',
            'task_detail.recipient_id',
            'staff.staff_name',
            'task_completed.removed'
        )
        ->join('employees', 'task_detail.employee_id', 'employees.employee_id')
        ->join('staff', 'task_detail.recipient_id', 'staff.staff_id')
        ->leftJoin('task_completed', 'task_detail.task_detail_id', 'task_completed.task_detail_id')
        ->whereNotIn('task_detail.task_detail_id', $arrTask)
        ->orderBy('task_detail.giver_day', 'desc');

        if(!empty($request->recipient_id)){
            $arrDateHasNotChanged = $arrDateHasNotChanged->where('recipient_id', $request->recipient_id);
        }
        // tìm theo ngày giao nhiem vu
        if(!empty($request->giver_day_start) ){
            $date_start = date_create($request->giver_day_start);
            $giver_day_start = date_format($date_start,"Y/m/d");
            $arrDateHasNotChanged = $arrDateHasNotChanged->whereDate('giver_day', '>=', $request->giver_day_start);
        }
        if(!empty($request->giver_day_end)){
            $date_end=date_create($request->giver_day_end);
            $giver_day_end = date_format($date_end,"Y/m/d");
            $arrDateHasNotChanged = $arrDateHasNotChanged->whereDate('giver_day', '<=', $request->giver_day_end);
        }

        $arrDateHasNotChanged = $arrDateHasNotChanged->get()->groupBy(function($item) {
            return $item->giver_day->format('Y-m-d');
        });

        $arrDateHasNotChanged = $this->paginate($arrDateHasNotChanged, $num);
        $arrDateHasNotChanged->withPath(route('daily_task_list'));
        $arrDateHasNotChanged->appends(request()->query());

        $arrDateHasChanged = $this->paginate($arrDateHasChanged, $num);
        $arrDateHasChanged->withPath(route('daily_task_list'));
        $arrDateHasChanged->appends(request()->query());

        return view('staff_admin.employee.daily_task_list', compact('arrDateHasChanged', 'arrDateHasNotChanged'));
    }

    public function assignment_results(Request $request)
    {
        $num = 20;
        if($request->num) {
            $num = $request->num;
        }

        $results = Task_detail::select(
            'task_detail.task_detail_id',
            'task_detail.giver_day',
            'task_detail.recipient_id',
            'staff.staff_name',
            'task_completed.removed',
            'employees.status_employee',
            'task_detail.profile as hs_td',
            'employees.profile as hs_e'
        )
        ->join('employees', 'task_detail.employee_id', 'employees.employee_id')
        ->join('staff', 'task_detail.recipient_id', 'staff.staff_id')
        ->leftJoin('task_completed', 'task_detail.task_detail_id', 'task_completed.task_detail_id')
        ->orderBy('task_detail.giver_day', 'desc');

        //tim theo nguoi nhan
        if (!empty($request->recipient_name)) {
            $results = $results->where('staff.staff_name', 'like', '%'.$request->recipient_name.'%');
        }

        // tìm theo ngày giao nhiem vu
        if(!empty($request->mon_yea) ){
            $month = date_create($request->mon_yea);
            $format_month = date_format($month,"m");
            $year = date_create($request->mon_yea);
            $format_year = date_format($year,"Y");
            $results = $results->whereMonth('giver_day', $format_month)->whereYear('giver_day', $format_year);
        }

        $results = $results->get()->groupBy(function($item) {
            return $item->giver_day->format('Y-m-d');
        });

        $results = $this->paginate($results, $num);
        $results->withPath(route('assignment_results'));
        $results->appends(request()->query());
        // dd($results);
        return view('staff_admin.employee.assignment_results', compact('results'));
    }

    public function employee_assigned(Request $request)
    {
        $num = 20;
        if($request->num) {
            $num = $request->num;
        }
        $staff_id = Staff::where('user_id',Auth::id())->value('staff_id');
        $employee = new Employee();
        $employees = $employee->select(
            'employees.employee_id',
            'employees.updated_at',
            'employees.employee_name',
            'employees.profile',
            'employees.status',
            'employees.status_employee',
            'task_detail.giver_day',
            'task_detail.note',
            'task_detail.finish_day',
            'task_detail.created_at',
            'task_completed.task_completed_id',
            'task_completed.removed',
            'task_detail.task_detail_id'
        )
        ->join('task_detail','task_detail.employee_id','employees.employee_id')
        ->leftJoin('task_completed','task_completed.task_detail_id','task_detail.task_detail_id')
        ->where('recipient_id', $staff_id)
        ->orderBy('task_detail.created_at', 'desc');
        // ->groupBy('employees.employee_id');
        // tìm theo id uv
        if (!empty($request->employee_id)) {
            $employees = $employees->where('employees.employee_id', $request->employee_id);
        }
        //tìm theo trạng thái
        if ($request->status_employee != null && $request->status_employee != "") {
            $employees = $employees->where('employees.status_employee', $request->status_employee);
        }
        // tìm theo tên uv
        if (!empty($request->employee_name)) {
            $employees = $employees->where('employees.employee_name', 'like', '%'.$request->employee_name.'%');
        }
        // tìm theo email uv
        if (!empty($request->email)) {
            $employees = $employees->where('employees.email', 'like', '%'.$request->email.'%');
        }
        // tìm theo ngày from
        if(!empty($request->date_search_start) ){
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '<=', $request->date_search_end);
        }
        // tìm theo ngày giao nhiem vu
        if(!empty($request->giver_day_start) ){
            $date_start = date_create($request->giver_day_start);
            $giver_day_start = date_format($date_start,"Y/m/d");
            $employees = $employees->whereDate('task_detail.giver_day', '>=', $request->giver_day_start);
        }
        if(!empty($request->giver_day_end)){
            $date_end=date_create($request->giver_day_end);
            $giver_day_end = date_format($date_end,"Y/m/d");
            $employees = $employees->whereDate('task_detail.giver_day', '<=', $request->giver_day_end);
        }
        // tìm theo ngày han hoan thanh
        if(!empty($request->finish_day_start) ){
            $date_start = date_create($request->finish_day_start);
            $finish_day_start = date_format($date_start,"Y/m/d");
            $employees = $employees->whereDate('task_detail.finish_day', '>=', $request->finish_day_start);
        }
        if(!empty($request->finish_day_finish)){
            $date_end=date_create($request->finish_day_finish);
            $finish_day_finish = date_format($date_end,"Y/m/d");
            $employees = $employees->whereDate('task_detail.finish_day', '<=', $request->finish_day_finish);
        }
        $employees = $employees->paginate($num);
        $employees->appends(request()->query());
        return view('staff_admin.employee.list_assinged', compact('employees'));
    }
    public function approved_employee(Request $request)
    {
        $employee_id = $request->employee_id;
        $status_employee = $request->status_employee;
        //chua duyet
        if($status_employee == 1)
        {
            Employee::find($employee_id)->update([
                'status_employee' => 1,
                'user_id_handling' => Auth::id(),
                'day_handling' => new \Datetime()
            ]);

            // neu la cv upload
            $cv_upload = Employee_upload_cv::where('employee_id', $employee_id)->where('employee_cv_status', 1)->first();
            if(!empty($cv_upload))
            {
                 // tu dong cong 40 diem cho profie_cv
                $employee_profile = Employee_profile::where('employee_id', $employee_id)->first();
                $employee = Employee::findOrFail($employee_id);
                // $old_profile_cv = $employee_profile->profile_cv;
                // $employee->update([
                //     'profile' => $employee->profile - $old_profile_cv + 40
                // ]);
                $employee_profile->update([
                    'profile_cv' => 40,
                    'created_at' => new \Datetime()
                ]);
                $profile = $employee_profile->profile_cv + $employee_profile->profile_info + $employee_profile->profile_staff + $employee_profile->profile_course + $employee_profile->profile_avg;
                $employee->update([
                    'profile' => $profile
                ]);
                return response()->json([
                    'mess' => 'Duyệt thành công.',
                    'status' => 1,
                    'profile_cv' => $employee_profile->profile_cv,
                    'profile' => $employee->profile
                ]);
            }

            return response()->json([
                'mess' => 'Duyệt thành công.',
                'status' => 1
            ]);
        }

        // bo duyet
        else{
            Employee::find($employee_id)->update([
                'status_employee' => 0,
                'user_id_handling' => Auth::id(),
                'day_handling' => new \Datetime()
            ]);

            return response()->json([
                'mess' => 'Bỏ duyệt thành công.',
                'status' => 0
            ]);
        }
    }

    public function approved_all_employee(Request $request)
    {
        $ids = $request->Ids;
        $update = Employee::whereIn('employee_id', $ids)->update([
            'status_employee' => 1
        ]);
        for ($i = 0; $i < count($ids); $i++) {
            $create = Employee_handling::insert([
                'employee_id' => $ids[$i],
                'user_id_handling' => Auth::user()->id,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        $request->session()->flash('success', 'Duyệt thành công!');
        return redirect()->back();
    }
    public function un_approved_all_employee(Request $request)
    {
        $ids = $request->Ids;
        $update = Employee::whereIn('employee_id', $ids)->update([
            'status_employee' => 0
        ]);
        for ($i = 0; $i < count($ids); $i++) {
            $create = Employee_handling::insert([
                'employee_id' => $ids[$i],
                'user_id_handling' => Auth::user()->id,
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        $request->session()->flash('success', 'Bỏ duyệt thành công!');
        return redirect()->back();
    }

    public function Create_Interactive_Employee(Request $request, $id)
    {
        // dd($id);
        // try {
            // $check = Interactive_history_employee::orderby('id','desc')->first();
            $create = Interactive_history_employee::insert([
                // 'id'          => $check != null? $check->id + 1:1,
                'employee_id' => $id,
                'interactive_day' => $request->input('interactive_day'),
                'user_id' => Auth::user()->id,
                'content' => $request->input('content'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $request->session()->flash('success', 'Tạo tương tác thành công!');
            return redirect()->back();
        // } catch (\Exception $e) {
        //     $request->session()->flash('error', 'Tạo tương tác không thành công!');
        //     return redirect()->back();
        // }
    }

    public function Detail($id)
    {
        $staff = \App\Entity\Staff::where('user_id', Auth::id())->first();
        // dd($id);
        $employee = Employee::where('employee_id', $id)->first();
        $specialize = new Employee_specialize();
        $specialize = $specialize->select('*')->where('employee_id', $id)->orderBy('specialize_id', 'asc')->get();
        //            Kinh nghiệm làm việc
        $experience = new Employee_experience();
        $experience = $experience->select('*')->where('employee_id', $id)->orderBy('experience_id', 'asc')->get();
        $interactives = Interactive_history_employee::select('interactive_history_employee.*', 'u.name as user_name')
            ->leftjoin('users as u', 'u.id', 'interactive_history_employee.user_id')
            ->where('employee_id', $id)
            ->orderby('interactive_history_employee.id', 'desc')->limit(3)->get();
        // $check trang thai de nghi xoa,1 la de nghi xoa
        $check = 0;
        $check_d = Employee_delete_request::where('employee_id', $id)->first();
        if ($check_d != null) {
            $check = 1;
        }
        // $follow trang thai theo doi ung vien cua nhan vien, 1 la da theo doi, 2 la khong theo doi
        $follow = Staff_follow::where('staff_id', $staff->staff_id)->where('user_id', $employee->user_id)->value('status_follow');
        $history = Employee_handling::select('employee_handling.*', 'u.name as user_name')
            ->leftjoin('users as u', 'u.id', 'employee_handling.user_id_handling')
            ->where('employee_handling.employee_id', $id)
            ->orderby('employee_handling.employee_id', 'desc')->paginate(5);
        // lấy cv
        $cv_upload = Employee_upload_cv::where('employee_id', $id)->first();
        $info_contact_cv_employee = Cv_employee::select(
            'cv_email',
            'cv_phone',
            'cv_facebook'
        )->where('employee_id',$employee->employee_id)->first();
        $check_employee_cv = Cv_employee::where('employee_id',$employee->employee_id)->value('cv_id');
        return view('staff_admin.employee.interactive', compact('check_employee_cv','interactives', 'employee', 'specialize', 'experience', 'check', 'history', 'cv_upload', 'info_contact_cv_employee','follow'));
    }

    public function staff_look_spec_employee(Request $request)
    {
        $specialize = new Employee_specialize();
        $specialize = $specialize->select('*')->where('employee_id', $request->id)->orderBy('specialize_id', 'asc')->get();
        $literacy = Literacy::get();
        return response()->json([
            'specialize' => $specialize,
            'literacy' => $literacy
        ]);
    }

    public function staff_look_exp_employee(Request $request)
    {
        $experience = new Employee_experience();
        $experience = $experience->select('*')->where('employee_id', $request->id)->orderBy('experience_id', 'asc')->get();
        return response()->json([
            'experience' => $experience
        ]);
    }

    public function form_edit($id)
    {
        // dd(1);
        $employee = Employee::where('employee_id', $id)->first();
        $softwareList = Software::get();
        $careers = Career::orderBy('career_category_name')->get();
        $jobs = Job::get();
        $salaries = Salary::get();
        $staffInCharges = User::where('id', $employee->user_id)->first();


        return view('staff_admin.employee.edit', compact('employee', 'jobs', 'salaries', 'staffInCharges', 'softwareList', 'careers'));
    }

    public function update(Request $request, $id)
    {
        // dd(1);
        $validation = Validator::make($request->all(), [
            'employee_name' => 'required',
        ], [
            //            'enterprise_id.unique' => 'Email đã tồn tại.',
            'employee_name.required' => 'Tên ứng viên không được bỏ trống',

        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $employee = Employee::where('employee_id', $id)->first();
            $userModel = new User();
            $user = $userModel->where('id', $employee->user_id)->first();

            $isChangePassword = $request->input('is_change_password');
            if ($isChangePassword == 1) {
                $user->update([
                    'password' => bcrypt($request->input('password')),
                ]);
            }
            $user->update([
                'name' => $request->input('employee_name'),
                'phone' => $request->has('phone') ? $request->input('phone') : ''
            ]);
            $employeeId = Employee::where('employee_id', $employee->employee_id)->update([
                'employee_name' => $request->input('employee_name'),
                'phone' => $request->input('phone'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'address' => $request->input('address'),
                'employee_image' => $request->input('image'),
                'gender' => $request->input('gender'),
                'birthday' => new \DateTime($request->input('birthday')),
                'marry' => $request->input('marry'),
                'school' => $request->input('school'),
                'cmt' => $request->input('cmt'),

                'cmt_date' => new \DateTime($request->input('cmt_date')),
                'cmt_local' => $request->input('cmt_local'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            Employee::get_user_id_Profile($employee->user_id);
            DB::commit();
            $request->session()->flash('success', 'Cập nhật ứng viên thành công!');
            $url = redirect()->route('detail_employee', $id)->getTargetUrl();
            return redirect($url);
            // return redirect(route('detail_employee'))->with('success', 'Cập nhật mới ứng viên thành công');
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Cập nhật ứng viên thất bại!');
            $url = redirect()->route('detail_employee', $id)->getTargetUrl();
            return redirect($url);
        }
    }

    public function create()
    {
        // dd('Chức năng này tạm thời đóng!');
        $staffInCharges = User::get();
        $softwareList = Software::get();
        $careers = Career::orderBy('career_category_name')->get();
        $jobs = Job::get();
        $salaries = Salary::get();
        return view('staff_admin.employee.add', compact('staffInCharges', 'softwareList', 'careers', 'jobs', 'salaries'));
    }

    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'employee_name' => 'required',
        ], [
            //            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
            'employee_name.required' => 'Tên ứng viên không được bỏ trống',

        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();

            $userModel = new User();
            $user_id_create = $userModel->insertGetId([
                'name' => $request->input('employee_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->has('phone') ? $request->input('phone') : '',
                'role' => 1
            ]);

            $employeeId = Employee::insertGetId([
                'employee_name' => $request->input('employee_name'),
                'phone' => $request->input('phone'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'address' => $request->input('address'),
                'employee_image' => $request->input('image'),
                'gender' => $request->input('gender'),
                'birthday' => new \DateTime($request->input('birthday')),
                'marry' => $request->input('marry'),
                'school' => $request->input('school'),
                'cmt' => $request->input('cmt'),
                'cmt_date' => new \DateTime($request->input('cmt_date')),
                'cmt_local' => $request->input('cmt_local'),
                'email' => $request->input('email'),
                'user_id' => $user_id_create,
                'status_employee' => 1,
                'user_id_handling' => Auth::user()->id,
                'day_handling' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            Employee::get_user_id_Profile($user_id_create);
            DB::commit();
            $request->session()->flash('success', 'Thêm mới ứng viên thành công!');
            $url = redirect()->route('staff_employee.index')->getTargetUrl();
            return redirect($url);
        } catch (\Exception $exception) {
            $request->session()->flash('success', 'Thêm mới ứng viên thành công!');
            $url = redirect()->route('staff_employee.index')->getTargetUrl();
            return redirect($url);
        }
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('staff_admin.employee.edit', compact('employee'));
    }

    public function delete_all_request(Request $request)
    {
        // dd(1);
        try {
            $list_id = $request->Ids;
            for ($i = 0; $i < count($list_id); $i++) {
                $check = Employee_delete_request::where('employee_id', $list_id[$i])->first();
                if ($check == null) {
                    $create = Employee_delete_request::insert([
                        'employee_id' => $list_id[$i],
                        'staff_id' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            $request->session()->flash('success', 'Đề nghị xóa thành công!');
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Đề nghị xóa thất bại!');
            return redirect()->back();
        }
    }
    public function delete_all(Request $request)
    {
        $ids = $request->Ids;
        $arrids = explode(",",$ids);
        DB::beginTransaction();
        foreach ($arrids as $arrid) {
            $employee = Employee::findOrFail($arrid);
            $user = new User();
            $user = $user->where('id', $employee->user_id)->delete();
            $employee->delete();
        }
        DB::commit();
            return response()->json($ids);

    }

    public function delete_request(Request $request)
    {
        $employee_id = $request->employee_id;
        $request_delete = $request->request_delete;
        //$request_delete = 1 là đề nghị xóa
        if($request_delete == 0){
            Employee_delete_request::where('employee_id', $employee_id)->delete();
            return response()->json([
                'mess' => 'Bỏ đề nghị xóa thành công!',
                'delete_request' => 0
            ]);
        }
        else{
            Employee_delete_request::insert([
                'employee_id' => $employee_id,
                'staff_id' => Auth::user()->id,
                'created_at' => new \Datetime()
            ]);
            return response()->json([
                'mess' => 'Đề nghị xóa thành công!',
                'delete_request' => 1
            ]);
        }
    }

    public function undelete_request(Request $request, $id)
    {
        // dd(1);
        try {
            $update = Employee_delete_request::where('employee_id', $id)->delete();
            $request->session()->flash('success', 'Bỏ đề nghị xóa thành công!');
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Bỏ đề nghị xóa thất bại!');
            return redirect()->back();
        }
    }

    public function delete_interactive(Request $request, $id)
    {
        try {
            $interactives = Interactive_history_employee::where('id', $id)->delete();
            $request->session()->flash('success', 'Xóa thành công!');
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Xóa thất bại!');
            return redirect()->back();
        }
    }

    public function statistical()
    {
        $provinces = Province::select('province_id', 'province_name')->get();
        return view('staff_admin.employee.employee_province', compact('provinces'));
    }

    public function district($province_id)
    {
        $province_name = Province::where('province_id', $province_id)->value('province_name');
        $districts = District::select('district_id', 'district_name')
            ->where('province_id', $province_id)
            ->get();
        return view('staff_admin.employee.employee_district', compact('districts', 'province_name', 'province_id'));
    }

    public static function countEmployeeP($province_id)
    {
        return $count_teacher = Employee::where('province', $province_id)
            ->count();
    }

    public static function countEmployeeApprovedP($province_id)
    {
        return $countEmployeeApprovedP = Employee::where('province', $province_id)->where('status_employee', 1)
            ->count();
    }

    public static function countEmployeeNotApprovedP($province_id)
    {
        return $countEmployeeNotApprovedP = Employee::where('province', $province_id)->where('status_employee', 0)
            ->count();
    }

    public static function countEmployeeD($district_id)
    {
        return $count_teacher = Employee::where('district', $district_id)
            ->count();
    }
    public static function countEmployeeApprovedD($district_id)
    {
        return $countEmployeeApprovedD = Employee::where('district', $district_id)->where('status_employee', 1)
            ->count();
    }
    public static function countEmployeeNotApprovedD($district_id)
    {
        return $countEmployeeNotApprovedD = Employee::where('district', $district_id)->where('status_employee', 0)
            ->count();
    }

    public function edit_data(Request $rq)
    {
        Interactive_history_employee::where('id', $rq->id)->update([
            'content' => $rq->input('content')
        ]);
        return Response()->Json([
            'messenge' => 'Sửa thành công'
        ]);
    }

    public function edit_interactive(Request $request, $id)
    {
        // dd($request->all());
        try {
            $interactives = Interactive_history_employee::where('id', $id)->update([
                'content' => $request->input('content'),
                'interactive_day' => $request->input('interactive_day'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $request->session()->flash('success', 'Cập nhật thành công!');
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Cập nhật thất bại!');
            return redirect()->back();
        }
    }

    public function list_deleted(Request $request)
    {
        $emplooyee = new Employee();
        $employees = $emplooyee->select(
            'employees.employee_id',
            'employees.phone',
            'employees.created_at',
            'employees.updated_at',
            'employees.employee_name',
            'employees.employee_image',
            'employees.email',
            'employees.career_category_id',
            'employees.salary_id',
            'employees.user_id',
            'employees.province',
            'employees.district',
            'employees.profile',
            'employees.status',
            'employees.status_employee',
            'employees.user_id_handling',
            'employees.day_handling',
            'employees.deleted_at'
        )->orderBy('employees.deleted_at', 'desc');
        if(url()->current()==route('list_employee_follow')){
            $user_id = Auth::id();
            $staff_id = Staff::where('user_id',$user_id)->value('staff_id');
            $employees = $employees->leftJoin('staff_follow','staff_follow.user_id','employees.user_id')
                                    ->where('staff_follow.status_follow',1)
                                    ->where('staff_follow.staff_id', $staff_id);
        }
        //        if (!empty($request->input('business'))) {
        //            $business = $request->input('business');
        //            $employers = $employers->where('employer.business', $business);
        //        }
        if (!empty($request->input('salary_id'))) {
            $salary_id = $request->input('salary_id');
            $employees = $employees->where('employees.salary_id', $salary_id);
        }
        if (!empty($request->input('career_category_id'))) {
            $career_category_id = $request->input('career_category_id');
            $employees = $employees->where('employees.career_category_id', $career_category_id);
        }
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $employees = $employees->whereDate('employees.deleted_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $employees = $employees->whereDate('employees.deleted_at', '<=', $request->date_search_end);
        }
        // if (!empty($request->input('email_search'))) {
        //     $email_search = $request->input('email_search');
        //     $employees = $employees->where('employees.email', $email_search);
        // }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employees = $employees->where('employees.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employees = $employees->where('employees.district', $district);
        }
        if (!empty($request->input('employee_name'))) {
            $employee_name = $request->input('employee_name');
            $employees = $employees->where('employees.employee_name', 'like', '%' . $employee_name . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $employees = $employees->where('employees.email', 'like', '%' . $email . '%');
        }
        if ($request->input('status_employee') != null && $request->input('status_employee') != "") {
            $status = $request->input('status_employee');
            $employees = $employees->where('employees.status_employee', $status);
        }
        if (!empty($request->is_delete)) {
            // return 3;
            $id = [];
            $ls = Employee_delete_request::get();
            foreach ($ls as $l) {
                $id[] = $l->employee_id;
            }
            // $ls = Employee_delete_request::chunk(100, function($ls) {
            //     foreach ($ls as $l) {
            //         $id[] = $l->employee_id;
            //     }
            // });
            // dd($id);
            if ($request->is_delete == 1) {
                // return 1;
                $employees->whereNotIn('employees.employee_id', $id);
            }
            if ($request->is_delete == 2) {
                // return 2;
                $employees->whereIn('employees.employee_id', $id);
            }
        }
        $employees = $employees->onlyTrashed();
        $total = $employees->count();
        $num = 30;
        if (!empty($request->input('num'))) {
            $num = $request->input('num');
        }
        $employees = $employees->paginate($num);
        $employees->appends(request()->query());
        return view('staff_admin.employee.list_deleted', compact('employees', 'total'));
    }

    public function employee_statistics(Request $request)
    {
        $statiscal_employee = new Statistical_employees();
        $statiscal = $statiscal_employee->select('statistical_employees.*', 'employees.employee_id', 'employees.employee_name', 'employees.email', 'employees.phone')->leftJoin('employees', 'employees.employee_id', '=', 'statistical_employees.employees_id');
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $statiscal = $statiscal->where('employees.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('phone'))) {
            $phone = $request->input('phone');
            $statiscal = $statiscal->where('employees.phone', 'like', '%' . $phone . '%');
        }
        if (!empty($request->input('phone'))) {
            $name = $request->input('name');
            $statiscal = $statiscal->where('employees.employee_name', 'like', '%' . $name . '%');
        }

        if (!empty($request->input('money'))) {
            $money = $request->input('money');
            $statiscal = $statiscal->orderBy('money', $money);
        }
        if (!empty($request->input('total_teacher'))) {
            $total_teacher = $request->input('total_teacher');
            $statiscal = $statiscal->orderBy('total_teacher', $total_teacher);
        }

        if (!empty($request->input('total_exam'))) {
            $total_exam = $request->input('total_exam');
            $statiscal = $statiscal->orderBy('total_exam', $total_exam);
        }
        if (!empty($request->input('total__dowload_voucher'))) {
            $total__dowload_voucher = $request->input('total__dowload_voucher');
            $statiscal = $statiscal->orderBy('total__dowload_voucher', $total__dowload_voucher);
        }
        if (!empty($request->input('total_view_voucher'))) {
            $total_view_voucher = $request->input('total_view_voucher');
            $statiscal = $statiscal->orderBy('total_view_voucher', $total_view_voucher);
        }
        if (!empty($request->input('total_view_job'))) {
            $total_view_job = $request->input('total_view_job');
            $statiscal = $statiscal->orderBy('total_view_job', $total_view_job);
        }
        if (!empty($request->input('total_cv'))) {
            $total_cv = $request->input('total_cv');
            $statiscal = $statiscal->orderBy('total_cv', $total_cv);
        }
        $statiscal = $statiscal->orderBy('id_statistical');
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        $total = $statiscal->count();
        $statiscal = $statiscal->paginate($num);


        return view('staff_admin.employee.employee_statistics', compact('statiscal', 'total'));
    }

    public function report_employee(Request $request)
    {
        $emplooyee = new Employee();
        $employees = $emplooyee->select(
            'employees.employee_id',
            'employees.phone',
            'employees.created_at',
            'employees.updated_at',
            'employees.employee_name',
            'employees.employee_image',
            'employees.email',
            'employees.career_category_id',
            'employees.salary_id',
            'employees.user_id',
            'employees.province',
            'employees.district',
            'employees.profile',
            'employees.status',
            'employees.status_employee',
            'employees.user_id_handling',
            'employees.day_handling'
        )->orderBy('employees.employee_id', 'desc');
        if(url()->current()==route('list_employee_follow')){
            $user_id = Auth::id();
            $staff_id = Staff::where('user_id',$user_id)->value('staff_id');
            $employees = $employees->leftJoin('staff_follow','staff_follow.user_id','employees.user_id')
                                    ->where('staff_follow.status_follow',1)
                                    ->where('staff_follow.staff_id', $staff_id);
        }
        //        if (!empty($request->input('business'))) {
        //            $business = $request->input('business');
        //            $employers = $employers->where('employer.business', $business);
        //        }
        if (!empty($request->input('salary_id'))) {
            $salary_id = $request->input('salary_id');
            $employees = $employees->where('employees.salary_id', $salary_id);
        }
        if (!empty($request->input('career_category_id'))) {
            $career_category_id = $request->input('career_category_id');
            $employees = $employees->where('employees.career_category_id', $career_category_id);
        }
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '<=', $request->date_search_end);
        }
        // if (!empty($request->input('email_search'))) {
        //     $email_search = $request->input('email_search');
        //     $employees = $employees->where('employees.email', $email_search);
        // }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employees = $employees->where('employees.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employees = $employees->where('employees.district', $district);
        }
        if (!empty($request->input('employee_name'))) {
            $employee_name = $request->input('employee_name');
            $employees = $employees->where('employees.employee_name', 'like', '%' . $employee_name . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $employees = $employees->where('employees.email', 'like', '%' . $email . '%');
        }
        if ($request->input('status_employee') != null && $request->input('status_employee') != "") {
            $status = $request->input('status_employee');
            $employees = $employees->where('employees.status_employee', $status);
        }
        if (!empty($request->is_delete)) {
            // return 3;
            $id = [];
            $ls = Employee_delete_request::get();
            foreach ($ls as $l) {
                $id[] = $l->employee_id;
            }
            // $ls = Employee_delete_request::chunk(100, function($ls) {
            //     foreach ($ls as $l) {
            //         $id[] = $l->employee_id;
            //     }
            // });
            // dd($id);
            if ($request->is_delete == 1) {
                // return 1;
                $employees->whereNotIn('employees.employee_id', $id);
            }
            if ($request->is_delete == 2) {
                // return 2;
                $employees->whereIn('employees.employee_id', $id);
            }
        }
        $total = $employees->count();
        if (!empty($request->input('num'))) {
            $num = $request->input('num');
            $employees = $employees->paginate($num);
        } else {
            $employees = $employees->paginate(30);
        }
        $employees->appends(request()->query());
        return view('staff_admin.employee.report_employee', compact('employees', 'total'));
    }

    public static function getEmployeeExperience($employee_id)
    {
        $exps = Employee_experience::where('employee_id', $employee_id)->get();
        $strExp = '';
        foreach ($exps as $exp) {
            $strExp .= $exp->experience_title . 'từ ' . $exp->star_working_time . ' đến ' . $exp->end_working_time . ' tại ' . $exp->company
                . ' vị trí ' . $exp->position;
        }
        return $strExp;
    }

    public static function getEmployeeSpecialize($employee_id)
    {
        $specs = Employee_specialize::where('employee_id', $employee_id)->get();
        $strSpec = '';
        foreach ($specs as $spec) {
            $strSpec .= $spec->specialize_title . 'từ ' . $spec->star_specialize_time . ' đến ' . $spec->star_specialize_time . ' tại ' . $spec->school
                . ' nghành ' . $spec->majors;
        }
        return $strSpec;
    }

    public function SendFeedbackEmployee(Request $request)
    {
            // dd($id);
            $employee_id = $request->employee_id;
            $id_cate_tem = 27;
            $item = Employee::where('employee_id', $employee_id)->first();
            $create = Employee_handling::insert([
                'user_id_handling' => Auth::user()->id,
                'employee_id' => $employee_id,
                'status' => $item->status_employee,
                'feedback' => $request->feedback,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            //trạng thái sử dụng của email
            $status_tem = 1;
            //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
            $template_email_model = new Template_email();
            $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
                ->where('status_tem', $status_tem)
                ->first();

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{content}', '{name}', '{email}'];

            $replace = [$request->feedback, $item->employee_name, $item->email];

            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($item->email, $subject, $content_string);

            // $request->session()->flash('success', 'Phản hồi thành công!');
            return 'Phản hồi thành công!';

    }

    public function SendFeedbackAllEmployee(Request $request)
    {
        //tam thời ẩn
        try {
            // dd($id);
            if (count($request->Ids) > 0) {
                $listAccounting = Employee::wherein('employee_id', $request->Ids)->get();
            } else {
                $request->session()->flash('error', 'Vui lòng chọn ứng viên!');
                return redirect()->back();
            }
            $id_cate_tem = 27;
            //trạng thái sử dụng của email
            $status_tem = 1;
            //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
            $template_email_model = new Template_email();
            $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
                ->where('status_tem', $status_tem)
                ->first();

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            foreach ($listAccounting as $ls) {
                if (strpos($ls->email, '@') !== false && strpos($ls->email, '.') !== false) {
                    $create = Employee_handling::insert([
                        'user_id_handling' => Auth::user()->id,
                        'employee_id' => $ls->employee_id,
                        'status' => $ls->status_employee,
                        'feedback' => $request->input('content'),
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    $search = ['{content}', '{name}', '{email}'];
                    $replace = [$request->input('content'), $ls->employee_name, $ls->email];
                    $content = str_replace($search, $replace, $content_email);
                    MailConfig::sendMail($ls->email, $subject, $content);
                }
            }
            $request->session()->flash('success', 'Phản hồi tất cả thành công!');
            return redirect()->back();
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Phản hồi không thành công!');
            return redirect()->back();
        }
    }

    public function change_employee_to_teacher(Request $request)
    {
    //        echo 1;die();
        try {
        $employee_id = $request->input('employee_id');
            DB::beginTransaction();
            //thông tin ứng viên
            $employee = Employee::select('*')->where('employee_id', $employee_id)->first();
            //thông tin đăng nhập
            $user = User::select('*')->where('id', $employee->user_id);
            //trình độ
            $employee_spec = Employee_specialize::select('*')->where('employee_id', $employee_id)->get();
            $employee_ex = Employee_experience::select('*')->where('employee_id', $employee_id)->get();
    //        tiến hành chuyển tài khoản

            //cập nhật role lên 3
            $user = User::where('id', $employee->user_id)->update([
                'role' => 3
            ]);
            //chuyển thông tai ứng viên sang giáo viên
            $teacher_model = new Teacher();
            $teacher_id = $teacher_model->insertGetId([
                'teacher_name' => $employee->employee_name,
                'teacher_code' => $employee->employee_code,
                'teacher_email' => $employee->email,
                'teacher_phone' => $employee->phone,
                'teacher_images' => $employee->employee_image,
                'province' => $employee->province,
                'district' => $employee->district,
                'address' => $employee->address,
                'user_id' => $employee->user_id,
                'birthday' => $employee->birthday,
                'gender' => $employee->gender,
                'information_verifier' => $employee->information_verifier,
                'created_at' => $employee->created_at,
                'updated_at' => $employee->updated_at,
                'status_teacher_experience' => $employee->status_employees_experience,
                'day_status_teacher_experience' => $employee->day_status_employees_experience,
                'status_teacher_degree' => $employee->status_employee_degree,
                'day_status_teacher_degree' => $employee->day_status_employee_degree,
                'career_category_id' => $employee->career_category_id,
            ]);
            //cập nhật slug
            $slug = Ultility::createSlug($employee->employee_name);
            if(!empty(Teacher::where('slug', $slug)->first())){
                $slug .= '-' . $teacher_id;
            }
            Teacher::where('teacher_id', $teacher_id)->update([
                'slug' => $slug
            ]);
            //cap nhat kinh nghiem neu co
            $teacher_spec = new Teacher_specialize();
            if (!empty($employee_spec)) {
                foreach ($employee_spec as $spec) {
                    $insert = $teacher_spec->insert([
                        'star_specialize_time' => $spec->star_specialize_time,
                        'end_specialize_time' => $spec->end_specialize_time,
                        'school' => $spec->school,
                        'majors' => $spec->majors,
                        'leve' => $spec->leve,
                        'specialize_status' => $spec->specialize_status,
                        'teacher_id' => $teacher_id,
                        'created_at' => $spec->created_at,
                    ]);

                }
            }
            $teacher_ex = new Teacher_experience();
            if (!empty($employee_ex)) {
                foreach ($employee_ex as $ex) {
                    $insert = $teacher_ex->insert([
                        'star_working_time' => $ex->star_working_time,
                        'end_working_time' => $ex->end_working_time,
                        'company' => $ex->company,
                        'position' => $ex->position,
                        'des_position' => $ex->des_position,
                        'teacher_id' => $teacher_id,
                        'created_at' => $ex->star_specialize_time,
                    ]);

                }
            }
            $user_id = Auth::user()->id;
            //cap nhật table employee_move_teacher
            $employee_move_teacher = new Employee_move_teacher();
            $insert_employee_move_teacher = $employee_move_teacher->insert([
                'employee_id' => $employee_id,
                'teacher_id' => $teacher_id,
                'user_move' => $user_id,
                'move_content' => $request->input('move_content'),
                'created_at' => new \DateTime(),
            ]);
    //      xóa ứng viên
            $employee = Employee::where('employee_id', $employee_id)->delete();
            DB::commit();
            return redirect(route('staff_teacher.index'))->with('success', 'Chuyển tài khoản ứng viên sang giáo viên thành công');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('staff_teacher.index'))->with('error', 'Chuyển tài khoản thất bại ! Vui lòng thử lại');
        }
    }

    public function deleteAllHard(Request $request)
    {
        // dd(1);
        $ids = $request->Ids;
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {
            $employee = Employee::onlyTrashed()->where('employee_id', $arrid)->first();
            User::onlyTrashed()->where('id', $employee->user_id)->forceDelete();
            Employee::onlyTrashed()->where('employee_id', $arrid)->forceDelete();
        }
            return response()->json($ids);

    }
    public function deleteHard($id)
    {
        $employee = Employee::onlyTrashed()->where('employee_id', $id)->first();
		
		//xoa file cv
		 $path_forder_images = public_path('/library_employee_cv/' . $employee->user_id);
		 $files_uploadted = glob($path_forder_images . '/*'); // get all file names
        foreach ($files_uploadted as $file_uploadted) { // iterate files
            if (is_file($file_uploadted)) {
                unlink($file_uploadted); // delete file
            }
        }
        User::onlyTrashed()->where('id', $employee->user_id)->forceDelete();
        Employee::onlyTrashed()->where('employee_id', $id)->forceDelete();
		
        return redirect()->back()->with('success', 'Xóa hẳn thành công!');

    }
    public function reset_employee($id)
    {
        $employee = Employee::onlyTrashed()->where('employee_id', $id)->first();
        User::onlyTrashed()->where('id', $employee->user_id)->restore();
        Employee::onlyTrashed()->where('employee_id', $id)->restore();
        return redirect()->back()->with('success', 'Reset thành công!');

    }

    public function interactive_employee(Request $request)
    {
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }

        $interactive_employee = new Interactive_history_employee();
        $interactive_employee = $interactive_employee->orderBy('interactive_history_employee.id', 'desc')
                                                ->join('employees', 'employees.employee_id', 'interactive_history_employee.employee_id')
                                                ->where('interactive_history_employee.user_id', Auth::user()->id )
                                                ->groupBy('interactive_history_employee.employee_id');

        if(!empty($request->date_search_start)){
            $interactive_employee = $interactive_employee->whereDate('employee_submit_job_facebook.created_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $interactive_employee = $interactive_employee->whereDate('employee_submit_job_facebook.created_at', '<=', $request->date_search_end);
        }

        //        tìm tên ứng viên
        if (!empty($request->name)) {
            $interactive_employee = $interactive_employee->where('employees.employee_name', 'like', '%' . $request->name . '%');
        }
        $interactive_employee = $interactive_employee->paginate($num);
        return view('staff_admin.employee.interactive_employee', compact('interactive_employee'));
    }


    public function interactive_employee_list($interactive_employee_id)
    {
        $employee_model = new Employee();
        $employee = $employee_model->select('*')->where('employee_id',$interactive_employee_id)->first();

        $interactive_employee = new Interactive_history_employee();
        $interactive_employee = $interactive_employee->orderBy('interactive_history_employee.id', 'desc')
                                                ->join('employees', 'employees.employee_id', 'interactive_history_employee.employee_id')
                                                ->where('interactive_history_employee.user_id', Auth::user()->id )
                                                ->where('interactive_history_employee.employee_id', $interactive_employee_id)->paginate(20);
        return view('staff_admin.employee.interactive_employee_list', compact('interactive_employee', 'employee'));
    }

    public function interactive_employee_all(Request $request)
    {
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }

        $interactive_employee_all = new Interactive_history_employee();
        $interactive_employee_all = $interactive_employee_all->select(
            'interactive_history_employee.*',
            'employees.employee_name',
            'employees.phone',
            'employees.email',
            'users.name'
            )->whereRaw('interactive_history_employee.id IN (select MAX(interactive_history_employee.id) FROM interactive_history_employee GROUP BY employee_id, user_id)')
            ->orderBy('interactive_history_employee.id', 'desc')
            ->groupBy('interactive_history_employee.employee_id', 'interactive_history_employee.user_id')
        ->join('employees', 'employees.employee_id', 'interactive_history_employee.employee_id')
        ->join('users', 'interactive_history_employee.user_id', 'users.id');

        $interactive_employee_user = new Interactive_history_employee();
        $interactive_employee_user = $interactive_employee_user->select(
            'users.id',
            'users.name'
            )->orderBy('interactive_history_employee.id', 'desc')
        ->join('employees', 'employees.employee_id', 'interactive_history_employee.employee_id')
        ->join('users', 'interactive_history_employee.user_id', 'users.id')->orderBy('users.name')->get();

        if(!empty($request->date_search_start)){
            $interactive_employee_all = $interactive_employee_all->whereDate('employee_submit_job_facebook.created_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $interactive_employee_all = $interactive_employee_all->whereDate('employee_submit_job_facebook.created_at', '<=', $request->date_search_end);
        }
        if (!empty($request->user)) {
            $interactive_employee_all = $interactive_employee_all->where('users.id', $request->user);
        }
        //        tìm tên ứng viên
        if (!empty($request->name)) {
            $interactive_employee_all = $interactive_employee_all->where('employees.employee_name', 'like', '%' . $request->name . '%');
        }
        $total = $interactive_employee_all->count();
        $interactive_employee_all = $interactive_employee_all->paginate($num);
        return view('staff_admin.employee.interactive_employee_all', compact('interactive_employee_all','total', 'interactive_employee_user'));
    }

    public function show_modal_interactive(Request $request)
    {
        $interactive_employee_all = new Interactive_history_employee();
        $interactive_employee_all = $interactive_employee_all->select(
            'interactive_history_employee.*',
            'users.name'
            )->orderBy('interactive_history_employee.id', 'desc')
        ->join('employees', 'employees.employee_id', 'interactive_history_employee.employee_id')
        ->join('users', 'interactive_history_employee.user_id', 'users.id')
        ->where('interactive_history_employee.employee_id', $request->employee_id)
        ->where('interactive_history_employee.user_id', $request->user_id)->get();
        return $interactive_employee_all;
    }

    public function exportExcelEmployee(Request $request)
    {
        // dd($request->all());
        $employee = new Employee();
        $employees = $employee->select(
            'employees.employee_id',
            'employees.phone',
            'employees.created_at',
            'employees.updated_at',
            'employees.employee_name',
            'employees.employee_image',
            'employees.email',
            'employees.career_category_id',
            'employees.salary_id',
            'employees.user_id',
            'employees.province',
            'employees.district',
            'employees.profile',
            'employees.status',
            'employees.birthday',
            'employees.status_employee',
            'employees.user_id_handling',
            'employees.day_handling'
        )->orderBy('employees.employee_id', 'desc');

        if (!empty($request->input('salary_id'))) {
            $salary_id = $request->input('salary_id');
            $employees = $employees->where('employees.salary_id', $salary_id);
        }
        if (!empty($request->input('career_category_id'))) {
            $career_category_id = $request->input('career_category_id');
            $employees = $employees->where('employees.career_category_id', $career_category_id);
        }
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employees = $employees->where('employees.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employees = $employees->where('employees.district', $district);
        }
        if (!empty($request->input('employee_name'))) {
            $employee_name = $request->input('employee_name');
            $employees = $employees->where('employees.employee_name', 'like', '%' . $employee_name . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $employees = $employees->where('employees.email', 'like', '%' . $email . '%');
        }
        if ($request->input('status_employee') != null && $request->input('status_employee') != "") {
            $status = $request->input('status_employee');
            $employees = $employees->where('employees.status_employee', $status);
        }
        if (!empty($request->input('birthday'))) {
            $employees = $employees->whereYear('employees.birthday', $request->input('birthday'));
        }
        if(!empty($request->list_id)){
            $employees = $employees->whereIn('employees.employee_id', $request->list_id);
        }
        $employees = $employees->get();

        $data[] = array(
            'Stt',
            'Tên ứng viên',
            'Email',
        );

        foreach ($employees as $id_emplo => $eplo) {
            // $number = $eplo->number_export + 1;
            // $eplo->update([
            //     'number_export' => $number,
            // ]);
            // $date = date_create($eplo->updated_at);
            // $date_updated = date_format($date, "d/m/Y");

            // if ($eplo->status_employer == 0) {
            //     $status = 'Chưa duyệt';
            // } else {
            //     $status = 'Đã duyệt';
            // }
            // $totalJob = \App\Entity\Job::getAllJobEmployer($eplo->employer_id);
            // $totalJobfacebook = \App\Entity\JobFacebook::getAllJobFacebookEmployer($eplo->employer_id);
            // if ($eplo->status_intership == 0) {
            //     $ttt = 'không';
            // } else {
            //     $ttt = 'có';
            // }

            $data[] = array(
                $id_emplo + 1,
                // $date_updated,
                $eplo->employee_name,
                // $status,
                // $eplo->province_name,
                // $eplo->district_name,
                // $totalJob,
                // $totalJobfacebook,
                // $ttt,
                $eplo->email,
                // $eplo->phone,
                // $eplo->type_of_business_name,
                // $eplo->business_type_name,
            );
        }
        $date = new \DateTime();
        // dd($data);
        $fileName = "Danh-sach-ung-vien_" . $date->format("d/m/y");
        return SpreadsheetFile::download($data, $fileName, ['font' => 'Arial']);
    }


    // public function approved_cv(Request $request)
    // {
    //     $employee_id = $request->employee_id;
    //     $employee_cv_status = $request->employee_cv_status;

    //     Employee_upload_cv::where('employee_id', $employee_id)->update([
    //         'employee_cv_status' => $employee_cv_status,
    //         'updated_at' => new \Datetime(),
    //         'user_id' => Auth::id()
    //     ]);
    //     if($employee_cv_status == 1){
    //         $mess = "Duyệt CV thành công.";
    //         $employee_profile = Employee_profile::where('employee_id', $employee_id)->first();
    //         if(!empty($employee_profile)) {
    //             if($employee_cv_status->profile_cv == 0){
    //                 $employee_profile->update([
    //                     'profile_cv' => 40,
    //                     'updated_at' => new \Datetime()
    //                 ]);
    //             }
    //             //update profile
    //             $profile = $employee_profile->profile_info + $employee_profile->profile_cv + $employee_profile->profile_staff
    //                         + $employee_profile->profile_course + $employee_profile->profile_avg;
    //             Employee::where('employee_id', $employee_id)->update([
    //                 'profile' => $profile
    //             ]);
    //         }
    //         else {
    //             Employee_profile::insert([
    //                 'employee_id' => $employee_id,
    //                 'profile_cv' => 40
    //             ]);
    //             //update profile
    //             Employee::where('employee_id', $employee_id)->update([
    //                 'profile' => 40
    //             ]);
    //         }
    //     }
    //     return response()->json([
    //         'mess' => $mess,
    //         'status' => $un_status
    //     ]);
    // }

    public function follow_employee(Request $request)
    {
        $employee_id = $request->employee_id;
        $follow_status = $request->follow_status;
        if($follow_status == 1)
        {
            $un_follow_status = 1;
        }
        elseif($follow_status == 0)
        {
            $un_follow_status = 2;
        }

        $staff = Staff::select('staff_id')->where('user_id', Auth::id())->first();
        $employee = Employee::select('user_id')->where('employee_id', $employee_id)->first();

        $staff_follow = Staff_follow::where('staff_id', $staff->staff_id)
        ->where('user_id', $employee->user_id)->first();
        if(!empty($staff_follow)){
            $staff_follow->update([
                'status_follow' => $un_follow_status,
                'updated_at' => new \Datetime()
            ]);
        }
        else {
            Staff_follow::insert([
                'staff_id' => $staff->staff_id,
                'user_id' => $employee->user_id,
                'type_user' => 1,
                'status_follow' => 1,
                'created_at' => new \Datetime()
            ]);
        }
        if($follow_status == 0){
            return response()->json([
                'mess' => 'Bỏ theo dõi thành công.',
                'follow' => 0
            ]);
        }
        else{
            return response()->json([
                'mess' => 'Theo dõi thành công.',
                'follow' => 1
            ]);
        }
    }

    //đánh giá hồ sơ ứng viên
    public function evaluate_employee(Request $request)
    {
        $coin = $request->coin;
        $content = $request->input('content');
        $employee_id = $request->employee_id;
        $employee = Employee::findOrFail($employee_id);

        $employee_profile = Employee_profile::where('employee_id', $employee_id)->first();
        // chua co nhan vien nao cho diem ho so
        if(empty($employee_profile)) {
            Employee_profile::insert([
                'employee_id' => $employee_id,
                'profile_staff' => $coin,
                'created_at' => new \Datetime()
            ]);
            $employee_coin = $employee->profile + $coin;
            $employee->update([
                'profile' => $employee_coin
            ]);
        }
        // co nhan vien nao cho diem ho so
        else {
            // update diem trong bang employee_profile(chi tiet)
            $employee_profile->update([
                'profile_staff' => $coin,
                'updated_at' => new \Datetime()
            ]);
            // update diem ho so cho ung vien
            $employee_coin = $employee_profile->profile_cv + $employee_profile->profile_info + $employee_profile->profile_staff + $employee_profile->profile_course + $employee_profile->profile_avg;

            $employee->update([
                'profile' => $employee_coin
            ]);
        }
        // them vao lich su tuong tac nhan vien va ung vien
        Interactive_history_employee::insert([
            'employee_id' => $employee_id,
            'coin' => $coin,
            'interactive_day' => new \Datetime(),
            'user_id' => Auth::id(),
            'content' => $content,
            'created_at' => new \Datetime()
        ]);
        return response()->json([
            'mess' => 'Đánh giá hồ sơ ứng viên thành công.',
            'profile' => $employee->profile
        ]);
    }

    public function detail_cv(Request $request)
    {
        $employee_id = $request->employee_id;
        $employee = Employee::findOrFail($employee_id);
        // $check_upload_cv_status = Employee_upload_cv::where('employee_id', $employee_id)->value('employee_cv_status');
        // $check_employee_approved = Employee::where('employee_id', $employee_id)->value('status_employee');
        // if($check_upload_cv_status == 0 && $check_employee_approved == 1){
        //     $cv_upload = null;
        // }
        // else{
        $cv_upload = Employee_upload_cv::where('employee_id', $employee_id)->where('employee_cv_status', 1)->first();
        // }
        $check_employee_cv = Cv_employee::where('employee_id', $employee_id)->value('cv_id');

        //theo doi
        $staff = Staff::select('staff_id')->where('user_id', Auth::id())->first();
        $employee = Employee::select(
            'employees.user_id',
            'employees.status_employee',
            'employees.employee_name',
            'employees.phone',
            'employees.salary_id',
            'employees.email',
            'employees.province',
            'employees.profile',
            'employees.status',
            'employees.show_hidden_profile',
            'employees.created_at',
            'employees.updated_at',
            'users.status_email_account',
            'salary.description as salary'
        )
        ->join('users', 'users.id', 'employees.user_id')
        ->join('salary', 'salary.salary_id', 'employees.salary_id')
        ->where('employees.employee_id', $employee_id)->first();

        //lấy các công việc mong muốn của ứng viên
        $careers_array = Employee_career_categories::where('employee_career_categories.employee_id', $employee_id)
        ->join('career_categories', 'career_categories.career_category_id', 'employee_career_categories.career_category_id')
        ->pluck('career_categories.career_category_name')->toArray();

        $careers = implode(" | ", $careers_array);
        $employee->careers = $careers;

        //Lấy danh sách khu vực uv cần tìm việc
        $district_array = Employee_district::where('employee_district.employee_id', $employee_id)
        ->join('district', 'district.district_id', 'employee_district.district_id')->pluck('district_name')->toArray();
        $districts = implode(', ', $district_array);
        $province_name = Province::where('province_id', $employee->province)->value('province_name');
        $areas = $province_name . ' - ' .$districts;
        $employee->areas = $areas;


        $staff_follow = Staff_follow::where('staff_id', $staff->staff_id)
        ->where('user_id', $employee->user_id)->first();

        $employee_profile = Employee_profile::select(
            'profile_info',
            'profile_cv',
            'profile_course',
            'profile_avg',
            'profile_staff'
        )->where('employee_id', $employee_id)->first();
        if($cv_upload){
            $link_cv_upload = str_replace('/public', '',$cv_upload->employee_link_cv);
            $link_cv_upload = asset($link_cv_upload);
        }
        else{
            $link_cv_upload = null;
        }
        return response()->json([
            'cv_upload' => $cv_upload,
            'url_cv_upload' => $link_cv_upload,
            'check_employee_cv' => $check_employee_cv,
            'employee' => $employee,
            'employee_profile' => $employee_profile,
            'staff_follow' => $staff_follow
        ]);
    }
    public function caculator_profile(Request $request) {
        $employee_id = $request->employee_id;
        $profile_info = $request->profile_info;
        $profile_cv = $request->profile_cv;

        $array_update = [
            'profile_info' => $profile_info,
            'profile_cv' => $profile_cv
        ];

        $employee_profile = Employee_profile::where('employee_id', $employee_id)->first();
        if(empty($employee_profile)) {
            Employee_profile::insert([
                'employee_id' => $employee_id,
                'profile_info' => $profile_info,
                'profile_cv' => $profile_cv,
                'created_at' => new \Datetime()
            ]);
        }
        else {
            foreach($array_update as $key => $value) {
                if($value != null) {
                    // $profile = Employee::where('employee_id', $employee_id)->value('profile');
                    // Employee::where('employee_id', $employee_id)->update([
                    //     'profile' => $profile - $employee_profile->$key + $value
                    // ]);
                    $employee_profile->update([
                        $key => $value
                    ]);
                    $profile = $employee_profile->profile_cv + $employee_profile->profile_info + $employee_profile->profile_staff + $employee_profile->profile_course + $employee_profile->profile_avg;

                    //update diem tong profile tong employee
                    Employee::where('employee_id', $employee_id)->update([
                        'profile' => $profile
                    ]);
                }
            }
        }
        $profile = Employee::where('employee_id', $employee_id)->value('profile');
        //update profile cua ho so trong bang employee
        // $employee_profile = Employee_profile::select(
        //     'profile_info',
        //     'profile_cv',
        //     'profile_staff',
        //     'profile_course',
        //     'profile_avg'
        // )
        // ->where('employee_id', $employee_id)->first();
        // diem xac thuc email
        // if(Employee::checkEmployeeCertain($employee_id)){
        //     $profile_certein = 5;
        // }
        // else {
        //     $profile_certein = 0;
        // }
        // $profile = $employee_profile->profile_info + $employee_profile->profile_cv + $employee_profile->profile_staff + $employee_profile->profile_course + $employee_profile->profile_avg + $profile_certein;
        // Employee::findOrFail($employee_id)->update([
        //     'profile' => $profile
        // ]);
        return response()->json([
            'mess' => 'Chỉnh sửa thành công.',
            'profile' => $profile,
            'profile_info' => $employee_profile->profile_info,
            'profile_cv' => $employee_profile->profile_cv
        ]);
    }

    public function staff_reload_cv(Request $request)
    {
        $employee_id = $request->employee_id;
        $user_id_emplouee = Employee::where('employee_id', $employee_id)->value('user_id');
        $cv_upload = Employee_upload_cv::where('employee_id', $employee_id)->where('employee_cv_status',1)->first();

        // th1 cv-upload
        if(!empty($cv_upload)){
            $link_cv_upload = str_replace('/public', '',$cv_upload->employee_link_cv);
            $link_cv_upload = asset($link_cv_upload);
            $link_cv = $link_cv_upload;
        }
        // th2 cv tao hoac ko co
        else{
            $check_employee_cv = Cv_employee::where('employee_id', $employee_id)->value('cv_id');
            // cv tao
            if(!empty($check_employee_cv)){
                $link_cv = route('exportpdf_cv_user_id', $user_id_emplouee);
            }
            // kho co
            else{
                $link_cv = null;
            }
        }
        return response()->json([
            'link_cv' => $link_cv
        ]);
    }

    public function task_job(Request $request)
    {
        $giver_id = Staff::where('user_id', Auth::id())->value('staff_id');
        $recipient_id = $request->recipient_id;
        $giver_day = $request->giver_day;
        $note = $request->note;
        $finish_day = $request->finish_day;
        $employee_id = $request->employee_id;
        $employee = Employee::select(
            'status_employee',
            'profile'
        )
        ->where('employee_id', $employee_id)->first();
        DB::beginTransaction();
        try {
            Task_detail::insert([
                'giver_id' => $giver_id,
                'recipient_id' => $recipient_id,
                'giver_day' => $giver_day,
                'finish_day' => $finish_day,
                'note' => $note,
                'employee_id' => $employee_id,
                'profile' => $employee->profile,
                'approved' => $employee->status_employee,
                'created_at' => new \Datetime()
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
        return back()->withSuccess('Giao việc thành công!');
    }

    public function ajax_task_job(Request $request)
    {
        $ids = $request->ids;
        $ajax_recipient_id = $request->ajax_recipient_id;
        $ajax_giver_day = $request->ajax_giver_day;
        $ajax_note = $request->ajax_note;
        $ajax_finish_day = $request->ajax_finish_day;
        $giver_id = Staff::where('user_id', Auth::id())->value('staff_id');

        DB::beginTransaction();
        try {
            foreach($ids as $id)
            {
                $employee = Employee::select(
                    'status_employee',
                    'profile'
                )
                ->where('employee_id', $id)->first();
                Task_detail::insert([
                    'giver_id' => $giver_id,
                    'recipient_id' => $ajax_recipient_id,
                    'giver_day' => $ajax_giver_day,
                    'finish_day' => $ajax_finish_day,
                    'note' => $ajax_note,
                    'employee_id' => $id,
                    'profile' => $employee->profile,
                    'approved' => $employee->status_employee,
                    'created_at' => new \Datetime()
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        return response()->json([
            'mess' => 'thanh cong'
        ], 200);
    }

    public function task_info(Request $request) {
        $employee_id = $request->employee_id;

    }


    public function task_completed_job(Request $request) {
        $removed = $request->removed;
        $content = $request->input('content');
        $task_detail_id = $request->task_detail_id;
        Task_completed::insert([
            'removed' => $removed,
            'task_detail_id' => $task_detail_id,
            'content' => $content,
            'created_at' => new \Datetime()
        ]);
        return back()->withSuccess('Báo cáo thành công');
    }

    public function employee_no_task(Request $request)
    {
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        //la ung vien da dc giao nhiem vu

        $employees_task = Task_detail::groupBy('employee_id')->pluck('employee_id')->toArray();

        $emplooyee = new Employee();
        $employees = $emplooyee->select(
            'employees.employee_id',
            'employees.phone',
            'employees.created_at',
            'employees.updated_at',
            'employees.employee_name',
            'employees.employee_image',
            'employees.email',
            'employees.user_id',
            'employees.profile',
            'employees.status',
            'employees.birthday',
            'employees.status_employee',
            'employee_upload_cv.employee_cv_status'
        )
        ->leftJoin('task_detail as td1', 'td1.employee_id', 'employees.employee_id')
        ->leftJoin('employee_upload_cv', 'employees.employee_id','employee_upload_cv.employee_id')
        ->groupBy('employees.employee_id')
        ->orderBy('employees.updated_at', 'desc')
        ->whereNotIn('employees.employee_id', $employees_task);
        if (empty($request->all)) {
            $employees = $employees->where('employees.status_employee', 0);
        }

        // tìm theo id uv
        if (!empty($request->employee_id)) {
            $employees = $employees->where('employees.employee_id', $request->employee_id);
        }
        //tìm theo trạng thái
        if ($request->status_employee != null && $request->status_employee != "") {
            $employees = $employees->where('employees.status_employee', $request->status_employee);
        }
        // tìm theo năm sinh
        if (!empty($request->birthday)) {
            $employees = $employees->whereYear('employees.birthday', $request->birthday);
        }
        // tìm theo tên uv
        if (!empty($request->employee_name)) {
            $employees = $employees->where('employees.employee_name', 'like', '%'.$request->employee_name.'%');
        }
        // tìm theo email uv
        if (!empty($request->email)) {
            $employees = $employees->where('employees.email', 'like', '%'.$request->email.'%');
        }
        // tìm theo ngày from
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '<=', $request->date_search_end);
         }
        $employees = $employees->paginate($num);
        $employees->appends(request()->query());
        return view('staff_admin.employee.list_employees_no_task', compact('employees'));
    }
    public function employee_task(Request $request)
    {
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        //la ung vien da dc giao nhiem vu

        $employees_task = Task_detail::groupBy('employee_id')->pluck('employee_id')->toArray();

        $emplooyee = new Employee();
        $employees = $emplooyee->select(
            'employees.employee_id',
            'employees.phone',
            'employees.created_at',
            'employees.updated_at',
            'employees.employee_name',
            'employees.employee_image',
            'employees.email',
            'employees.user_id',
            'employees.profile',
            'employees.status',
            'employees.birthday',
            'employees.status_employee',
            'td1.giver_id',
            'td1.recipient_id',
            'td1.finish_day',
            'td1.giver_day',
            'employee_upload_cv.employee_cv_status'
        )
        ->leftJoin('task_detail as td1', 'td1.employee_id', 'employees.employee_id')
        ->leftJoin('employee_upload_cv', 'employees.employee_id','employee_upload_cv.employee_id')
        ->groupBy('employees.employee_id')
        ->orderBy('td1.giver_day', 'desc')
        ->whereIn('employees.employee_id', $employees_task);
        // tìm theo id uv
        if (!empty($request->employee_id)) {
            $employees = $employees->where('employees.employee_id', $request->employee_id);
        }
        //tìm theo trạng thái
        if ($request->status_employee != null && $request->status_employee != "") {
            $employees = $employees->where('employees.status_employee', $request->status_employee);
        }
        // tìm theo năm sinh
        if (!empty($request->birthday)) {
            $employees = $employees->whereYear('employees.birthday', $request->birthday);
        }
        // tìm theo tên uv
        if (!empty($request->employee_name)) {
            $employees = $employees->where('employees.employee_name', 'like', '%'.$request->employee_name.'%');
        }
        // tìm theo email uv
        if (!empty($request->email)) {
            $employees = $employees->where('employees.email', 'like', '%'.$request->email.'%');
        }
        // tìm theo ngày from
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $employees = $employees->whereDate('employees.updated_at', '<=', $request->date_search_end);
         }
         // tìm theo ngày giao nhiem vu
        if(!empty($request->giver_day_start) ){
            $date_start = date_create($request->giver_day_start);
            $giver_day_start = date_format($date_start,"Y/m/d");
            $employees = $employees->whereDate('task_detail.giver_day', '>=', $request->giver_day_start);
        }
        if(!empty($request->giver_day_end)){
            $date_end=date_create($request->giver_day_end);
            $giver_day_end = date_format($date_end,"Y/m/d");
            $employees = $employees->whereDate('task_detail.giver_day', '<=', $request->giver_day_end);
        }
        // tìm theo ngày han hoan thanh
        if(!empty($request->finish_day_start) ){
            $date_start = date_create($request->finish_day_start);
            $finish_day_start = date_format($date_start,"Y/m/d");
            $employees = $employees->whereDate('task_detail.finish_day', '>=', $request->finish_day_start);
        }
        if(!empty($request->finish_day_finish)){
            $date_end=date_create($request->finish_day_finish);
            $finish_day_finish = date_format($date_end,"Y/m/d");
            $employees = $employees->whereDate('task_detail.finish_day', '<=', $request->finish_day_finish);
        }
        // tim theo nguoi giao nv
        if(!empty($request->giver_id)){
            $employees = $employees->where('td1.giver_id', $request->giver_id);
        }
        // tim theo nguoi nhan nv
        if(!empty($request->recipient_id)){
            $employees = $employees->where('td1.recipient_id', $request->recipient_id);
        }
        $employees = $employees->paginate($num);
        $employees->appends(request()->query());
        return view('staff_admin.employee.list_employees_task', compact('employees'));
    }
    public function general_task(Request $request)
    {
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        $array_date = Task_detail::select('giver_day', 'recipient_id')->orderBy('giver_day', 'desc');
        if(!empty($request->recipient_id)){
            $array_date = $array_date->where('recipient_id', $request->recipient_id);
        }
        // tìm theo ngày giao nhiem vu
        if(!empty($request->giver_day_start) ){
            $date_start = date_create($request->giver_day_start);
            $giver_day_start = date_format($date_start,"Y/m/d");
            $array_date = $array_date->whereDate('giver_day', '>=', $request->giver_day_start);
        }
        if(!empty($request->giver_day_end)){
            $date_end=date_create($request->giver_day_end);
            $giver_day_end = date_format($date_end,"Y/m/d");
            $array_date = $array_date->whereDate('giver_day', '<=', $request->giver_day_end);
        }
        $array_date = $array_date->get()->groupBy(function($item) {
            return $item->giver_day->format('Y-m-d');
       });
        //    $myCollectionObj = collect($array_date);
       $array_date = $this->paginate($array_date, $num);
       $array_date->withPath(route('general_task'));
       $array_date->appends(request()->query());
       return view('staff_admin.employee.general_task', compact('array_date'));
        // foreach($array_date as $date){
        //     $date = $date->groupBy('recipient_id');
        //     foreach($date as $day){
        //         echo $day;
        //         echo $day[0]->recipient_id;
        //         echo '<br>';
        //         echo '<br>';
        //     }
        //     echo '<hr>';
        // }
    }
    public function paginate($items, $perPage = 1, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function uv_old($skip, $take)
    {
        $employees = Employee::select(
            'employees.employee_id',
            'employees.employee_image'
        )
        ->orderBy('employees.employee_id', 'DESC')
        ->skip($skip)
        ->take($take)->get();
        foreach($employees as $employee){

        }
        return view('staff_admin.employee.test', compact('employees'));
    }
    public function edit_uv_old(Request $request) {

        $employee_ids = $request->employee_id;
        $employee_images = $request->employee_image;

        foreach($employee_ids as $key => $employee_id)
        {
            Employee::where('employee_id', $employee_id)->update([
                'employee_image' => $employee_images[$key]
            ]);
        }
        return back();
    }

    public function dashboard(Request $request)
    {
        //biểu đồ ứng viên mới theo tháng
        $employeeData = Employee::select(DB::raw("COUNT(*) as count"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))
        ->pluck('count');

        //biểu đồ tất cả ứng viên theo tỉnh
        $provinces = Province::join('employees', 'employees.province', 'province.province_id')
        ->select('province.hc_key', DB::raw("COUNT('employees.employee_id') as count_employee"))
        ->groupBy('province.hc_key')->get()->toArray();
        $arr = [];
        foreach ($provinces as $key => $value) {
            array_push($arr, [$value['hc_key'], $value['count_employee']]);
        }

        //biểu đồ ứng viên chưa duyệt và đã duyệt theo tháng
        $employeeNotApproved = Employee::select(DB::raw("COUNT(*) as count"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))
        ->where('status_employee', 0)
        ->pluck('count');

        $employeeApproved = Employee::select(DB::raw("COUNT(*) as count"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))
        ->where('status_employee', 1)
        ->pluck('count');

        //biểu đồ: hs cũ mới đi làm chưa đi làm
        $profileStatus = Employee::select(DB::raw("COUNT(*) as count"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))
        ->where('status', 1)
        ->pluck('count');

        $profileNotStatus = Employee::select(DB::raw("COUNT(*) as count"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))
        ->where('status', 0)
        ->pluck('count');
        $d=strtotime("-1 Months");
        $date = date("Y-m-d", $d);

        $hoSoMoi = Employee::select(DB::raw("COUNT(*) as count"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))
        ->where('created_at', '>=', $date)
        ->orWhere('updated_at', '>=', $date)
        ->pluck('count');

        $hoSoCu = Employee::select(DB::raw("COUNT(*) as count"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))
        ->where('created_at', '<=', $date)
        ->Where('updated_at', '<=', $date)
        ->pluck('count');

        return view('staff_admin.dashboard.dashboard', compact(
            'employeeData' ,
            'arr',
            'employeeNotApproved',
            'employeeApproved',
            'profileStatus',
            'profileNotStatus',
            'hoSoCu',
            'hoSoMoi'
        ));
    }
    public function staff_employee_no_convert_cv(Request $request)
    {
        $list_employee = Employee::select('employees.employee_id','employees.profile','employees.employee_name','employees.employee_slug','employees.email','employees.phone','employees.user_id','employee_upload_cv.employee_link_cv')
            ->join('employee_upload_cv','employee_upload_cv.employee_id','=','employees.employee_id')
            ->orderBy('employees.updated_at', 'desc')
            ->get();
        $list_cv = array();
        foreach($list_employee as $id=>$emp)
        {
            $path_forder_images = public_path('/library_employee_cv/'.$emp->user_id);
            $files_uploadted = glob($path_forder_images . '/*'); // get all file names
            if(count($files_uploadted) == 1 && $emp->profile > 40 && !empty($emp->employee_link_cv))
            {
                $list_cv[$id]['user_id'] = $emp->user_id;
                $list_cv[$id]['employee_id'] = $emp->employee_id;
                $list_cv[$id]['employee_name'] = $emp->employee_name;
                $list_cv[$id]['employee_slug'] = $emp->employee_slug;
                $list_cv[$id]['email'] = $emp->email;
                $list_cv[$id]['phone'] = $emp->phone;
                $list_cv[$id]['employee_link_cv'] = $emp->employee_link_cv;
            }
        }
//        echo '<pre>';
//        print_r($list_cv);die;

        return view('staff_admin.employee.list_employee_no_convert_cv', compact('list_cv'));
    }
    public function staff_detail_convert_cv($employee_id)
    {
        $employee = Employee::select('employees.employee_id','employees.employee_name','employees.employee_slug','employees.email','employees.phone','employees.user_id','employee_upload_cv.employee_link_cv')
            ->join('employee_upload_cv','employee_upload_cv.employee_id','=','employees.employee_id')
            ->where('employees.employee_id',$employee_id)
            ->first();
        $list_cv = array();
        $path_forder_images = public_path('/library_employee_cv/'.$employee->user_id);
        $files_uploadted = glob($path_forder_images . '/*'); // get all file names

        return view('staff_admin.employee.list_detail_convert_cv', compact('employee','files_uploadted'));
    }
    public function staff_convert_cv(Request $request)
    {
        $user_id = $request->user_id;
        $employee_id = $request->employee_id;
        $employee_link_cv = $request->employee_link_cv;

        $upload_file = new Upload_FileController();
		//$link_upload_cv = $upload_file->upload_file_cv($user_id, $request, 'file');

        $result = explode('.', $employee_link_cv);
        if($result[1] == 'pdf')
        {
            $this->PdfToHtml($employee_link_cv,$user_id);
        }
        if($result[1] == 'docx')
        {
            $this->WordToHtml($result[0], $result[1],$user_id);
        }
		
		$check_employee_cv = Employee_upload_cv::where('employee_id', $employee_id)->first();
        if (!empty($check_employee_cv)) {
            //xóa file
            $move_delete = $upload_file->move_file_cv($check_employee_cv->employee_link_cv);
            $upload_cv = Employee_upload_cv::where('employee_id', $employee_id)->update([
                'employee_link_cv' => $employee_link_cv,
                'employee_cv_status' => 1,
                'updated_at' => new \DateTime()
            ]);
        } else {
            $insert_cv = Employee_upload_cv::insert([
                'employee_id' => $employee_id,
                'employee_link_cv' => $employee_link_cv,
                'employee_cv_status' => 1,
                'created_at' => new \DateTime()
            ]);
        }
        // up date luon diem ho so = 40
        $employee_profile = Employee_profile::where('employee_id', $employee_id)->first();
        $employee_profile->update([
            'profile_cv' => 40
        ]);
        $profile_employee_after_update = $employee_profile->profile_info + $employee_profile->profile_cv + $employee_profile->profile_course + $employee_profile->profile_staff + $employee_profile->profile_avg;

        // chuyển hồ sơ
        $employee = Employee::where('employee_id', $employee_id)->update([
            'status_employee' => 1,
            'profile' => $profile_employee_after_update,
            'updated_at' => new \DateTime()
        ]);
		
        return redirect(route('staff_detail_convert_cv',['employee_id' =>$employee_id]));
    }

    private function PdfToHtml($link_pdf,$user_id)
    {
        $public_full = public_path();
        $public_html = str_replace('public', '', $public_full);
        $public = str_replace('_html', 'public_html', $public_html);
        //        Config::setBinDirectory($public . 'vendor/bin/poppler');
        // set Poppler utils binary location
        Config::setBinDirectory($public . 'public/custom_vendor_PDF/bin/poppler');
        // set output directory
        Config::setOutputDirectory(public_path() . '/library_employee_cv/' . $user_id);


        $pdfToHtml = new PdfToHtml($public . $link_pdf);
        $pdfToHtml->setZoomRatio(1.8);
        $pdfToHtml->exchangePdfLinks();
        $pdfToHtml->startFromPage(1)->stopAtPage(5);
        $pdfToHtml->generateSingleDocument();
        $pdfToHtml->generate();


    }

    private function WordToHtml($link_pdf, $type_file,$user_id)
    {
        $link_pdf_no = str_replace('public/', '', $link_pdf);
        $array = explode('/', $link_pdf);
        $name = end($array);
        $array_name = explode('.', $name);
        $name_file = current($array_name);
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('HTML');
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        if($type_file == 'doc')
        {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load(public_path() . $link_pdf_no, 'MsDoc');
        }
        else{
            $phpWord = \PhpOffice\PhpWord\IOFactory::load(public_path() . $link_pdf_no);
        }

        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord,'HTML');
        $PDFWriter->save(public_path() . '/library_employee_cv/' .$user_id . '/' . $name_file . '-html.html');

        // $docPath = public_path() . $link_pdf_no;
        // $Word = new \PhpOffice\PhpWord\PhpWord();
        // $document = $Word->loadTemplate($docPath);
        //     $document =   \PhpOffice\PhpWord\IOFactory::load($docPath,'MsDoc');

        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($document,'Word2007');
        // $docxPath = public_path() . '/library_employee_cv/' . Auth::id() . '/' . $name_file . '.docx';
        // $objWriter->save($docxPath);

    }
}
