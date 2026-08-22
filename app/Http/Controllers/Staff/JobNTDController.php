<?php

namespace App\Http\Controllers\Staff;

use App\Entity\Employee;
use App\Entity\Notification_employer;
use App\Http\Controllers\Api\NotificationEmployerController;
use App\Http\Controllers\Api\NotificationMobileController;
use App\Http\Controllers\APIgoogle;
use App\Http\Controllers\Site\MailConfigController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Category_tag;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Job;
use App\Entity\Salary;
use App\Entity\Software;
use App\Entity\Employer;
use App\Entity\JobGroup;
use App\Entity\Literacy;
use App\Entity\Sale;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Entity\MailConfig;
use App\Entity\Template_email;
use App\Entity\Job_handling;
use App\Entity\Job_delete_request;

class JobNTDController extends SiteStaffController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $job_vip_not_active = Job::where('active_job', 0)->where('vip', 1)->count();
            $job_cas_not_active = Job::where('active_job', 0)->where('vip', 0)->count();
            view()->share([
                'menuTop' => 'vieclam',
                'job_vip_not_active' => $job_vip_not_active,
                'job_cas_not_active' => $job_cas_not_active,
            ]);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $jobs = new Job();

        $jobs = $jobs->select(
            'jobs.*',
            'employer.employer_id as employers_id ',
            'employer.enterprise_name',
            'employer.email',
            'users.name as user_name'
        );
        $jobs = $jobs->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id');
        $jobs = $jobs->leftJoin('users', 'users.id', 'jobs.user_id');
        //        danh mục ngành nghề
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            // dd($date_search_start);
            $jobs = $jobs->whereDate('jobs.updated_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $jobs = $jobs->whereDate('jobs.updated_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
        if (!empty($request->input('job_id'))) {
            $jobs = $jobs->where('jobs.job_id', $request->input('job_id'));
        }
        //        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
        //        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
        //        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
        //        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
        //        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
        //        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
        //        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('job_code', 'like', '%' . $job_code . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobs = $jobs->where('jobs.employer_id', $request->input('employer_id'));
        }
        if (!empty($request->input('employer_name'))) {
            $jobs = $jobs->where('employer.enterprise_name', 'like', '%' . $request->input('employer_name') . '%');
        }
        if ($request->input('active_job') != null && $request->input('active_job') != "") {
            $active_job = $request->input('active_job');
            $jobs = $jobs->where('active_job', $active_job);
        }
        $num = 30;
        if (!empty($request->num)) {
            $num = $request->num;
        }


        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $total_job = $jobs->count();
        $jobs = $jobs->paginate($num);

        $jobs->appends(request()->query());
        return view('staff_admin.job.job_ntd.list', compact('jobs', 'total_job'));
    }

    public function show_submit_cv_job(Request $request)
    {

    }

    public function employee_submit_job(Request $request)
    {
        $num = 20;
        if ($request->num) {
            $num = $request->num;
        }
        $submit_job = new Employee_submit_job_faacebook();
        $submit_job = $submit_job->select(
            'employee_submit_job_facebook.submit_job_fb_id',
            'employee_submit_job_facebook.day_submit_job',
            'employees.employee_name',
            'employees.employee_id',
            'job_facebook.title as title_job_fb',
            'jobs.title as title_job',
            'employee_submit_job_facebook.status_syll'
        )
            ->leftJoin('employees', 'employee_submit_job_facebook.employee_id', 'employees.employee_id')
            ->leftJoin('job_facebook', 'employee_submit_job_facebook.id_job_fb', 'job_facebook.job_facebook_id')
            ->leftJoin('jobs', 'employee_submit_job_facebook.id_job_fb', 'jobs.job_id')
            ->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc');
        if (!empty($request->employee_name)) {
            $submit_job = $submit_job->where('employees.employee_name', 'like', '%' . $request->employee_name . '%');
        }
        if (!empty($request->title_job)) {
            $submit_job = $submit_job->where('jobs.title', 'like', '%' . $request->title_job . '%');
        }
        if (!empty($request->title_job_fb)) {
            $submit_job = $submit_job->where('job_facebook.title', 'like', '%' . $request->title_job_fb . '%');
        }
        switch (url()->current()) {
            case route('employee_submit_job_ntd'):
                $submit_job = $submit_job->where('employee_submit_job_facebook.status_job', 1);
                break;
            case route('employee_submit_job_fb'):
                $submit_job = $submit_job->where('employee_submit_job_facebook.status_job', 0);
                break;
        }
        $submit_job = $submit_job->paginate($num);
        $submit_job->appends(request()->query());
        return view('staff_admin.job.job_ntd.employee_submit_job', compact('submit_job'));
    }

    public function employee_submit_apply_job(Request $request)
    {

        $submit_job_fb = new Employee_submit_job_faacebook();
        $list_employees = $submit_job_fb->select(
            'employee_submit_job_facebook.submit_job_fb_id',
            'employee_submit_job_facebook.employee_id',
            'employee_submit_job_facebook.id_job_fb',
            'employee_submit_job_facebook.status_job',//0 đề thi facebook ; 1 là đi thi tuyển dụn
            'employee_submit_job_facebook.status_show_cv',//	0 là ứng tuyển nhanh chờ xác thực email hoặc nhanvien duyệt tài khoản , 1 là tìa khoản nộp hồ sơ bình thường ; mặc định = 1
            'employee_submit_job_facebook.id_status_submit_job', //trang thai ho so
            'employee_submit_job_facebook.status_change_profile', //0 là hố sơ ứng viên tự nộp , 1 là trường hợp nhân viên nộp hồ sơ hộ
            'employee_submit_job_facebook.day_submit_job', //	ngày nộp hồ sơ
            'employee_submit_job_facebook.status_syll',
            'employee_submit_job_facebook.job_app_content',
            'employees.employee_name',
            'employees.employee_slug',
            'employees.employee_image',
            'employees.phone',
            'employees.email',
            'jobs.title',
            'jobs.slug',
            'employee_submit_job_facebook.created_at',
            'employee_upload_cv.employee_link_cv',
            'employee_upload_cv.employee_link_html'
        )
            ->join('jobs', 'jobs.job_id', '=', 'employee_submit_job_facebook.id_job_fb')
            ->join('employees', 'employees.employee_id', '=', 'employee_submit_job_facebook.employee_id')
            ->join('employee_upload_cv', 'employee_upload_cv.employee_id', '=', 'employees.employee_id')
//            ->where('employee_submit_job_facebook.status_show_cv', 0)
            ->where('employee_submit_job_facebook.status_apply_cv', 1);
        if (!empty($request->input('employee_name'))) {
            $list_employees = $list_employees->where('employee_name', 'like', '%' . $request->input('employee_name') . '%');
        }
        if (!empty($request->input('email'))) {
            $list_employees = $list_employees->where('email', 'like', '%' . $request->input('email') . '%');
        }
        if (!empty($request->input('phone'))) {
            $list_employees = $list_employees->where('phone', 'like', '%' . $request->input('phone') . '%');
        }
        if ($request->has('status_show_cv')) {
            $list_employees = $list_employees->where('status_show_cv', '=', $request->input('status_show_cv'));
        }

        $list_employees = $list_employees->orderBy('employee_submit_job_facebook.status_show_cv', 'asc')
            ->distinct();
        $list_employees = $list_employees->paginate(20);
        $list_employees->appends(request()->query());
        return view('staff_admin.job.job_ntd.employee_submit_apply_job', compact('list_employees'));
    }

    //duyetj hồ sơ cv
    public function post_submit_apply_job(Request $request)
    {

        $job_id = $request->input('id_job_fb');
        $employee_id = $request->input('employee_id');
        //show cv để upload cv
        $status_show_cv = Employee_submit_job_faacebook::where('employee_id', $employee_id)
            ->where('id_job_fb', $job_id)
            ->value('status_show_cv');
        if (empty($status_show_cv)) {
            $job_submit = Employee_submit_job_faacebook::where('employee_id', $employee_id)
                ->where('id_job_fb', $job_id)
                ->update([
                    'status_show_cv' => 1
                ]);
            //guie thông báo đến ntd
            $employee = Employee::where('employee_id', $employee_id)->first();
            $employee_modal = new \App\Http\Controllers\Site\EmployeeController();
            $employee_modal->show_cv_notication($job_id, $employee);
        }
        return redirect()->back()->with('success', 'Bạn đã duyệt cv thành công');
    }

    public function show_modal_interactive_job(Request $request)
    {
        $interactive_employee_all = new Employee_submit_job_faacebook();
        $interactive_employee_all = $interactive_employee_all->select('employee_submit_job_facebook.job_app_content')
            ->where('employee_submit_job_facebook.submit_job_fb_id', $request->job_id)->get();
        // dd($interactive_employee_all);
        return $interactive_employee_all;
    }

    public function employer_job_list(Request $request)
    {
        $jobs = new Job();

        $jobs = $jobs->select(
            'jobs.*',
            'employer.employer_id as employers_id ',
            'employer.enterprise_name',
            'employer.email',
            'users.name as user_name'
        );
        $jobs = $jobs->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id');
        $jobs = $jobs->leftJoin('users', 'users.id', 'jobs.user_id');
        //        danh mục ngành nghề
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            // dd($date_search_start);
            $jobs = $jobs->join('job_handling as jh1', 'jobs.job_id', 'jh1.job_id');
            $jobs = $jobs->whereDate('jh1.created_at', '>=', $request->date_search_start)->groupBy('jobs.job_id');
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $jobs = $jobs->join('job_handling as jh2', 'jobs.job_id', 'jh2.job_id');
            $jobs = $jobs->whereDate('jh2.created_at', '<=', $request->date_search_end)->groupBy('jobs.job_id');
        }
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
        //        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
        //        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
        //        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
        //        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
        //        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
        //        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
        //        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('job_code', 'like', '%' . $job_code . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobs = $jobs->where('jobs.employer_id', $request->input('employer_id'));
        }
        if (!empty($request->input('employer_name'))) {
            $jobs = $jobs->where('employer.enterprise_name', 'like', '%' . $request->input('employer_name') . '%');
        }
        if (isset($request->active_job)) {
            $active_job = $request->input('active_job');
            $jobs = $jobs->where('active_job', $active_job);
        }
        // if ($request->input('active_job') != null && $request->input('active_job') != "") {
        //     $active_job = $request->input('active_job');
        //     $jobs = $jobs->where('active_job', $active_job);
        // }
        $num = 30;
        if (!empty($request->num)) {
            $num = $request->num;
        }


        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $jobs = $jobs->paginate($num);

        $jobs->appends(request()->query());
        return view('staff_admin.job.job_ntd.employer_job_list', compact('jobs'));
    }


    public function show_modal_feedback(Request $request)
    {
        $history = Job_handling::select('job_handling.*', 'u.name as user_name')
            ->leftjoin('users as u', 'u.id', 'job_handling.user_id_handling')
            ->where('job_handling.job_id', $request->job_id)
            ->orderby('job_handling.id', 'desc')->get();
        return $history;
    }

    public function approved_job_NTD(Request $request, $id)
    {

        $update = Job::where('job_id', $id)->update([
            'active_job' => 1,
            'sale_money' => 1,
            'user_id' => Auth::user()->id,
            'day_handling' => date('Y-m-d H:i:s'),
        ]);
        $request->session()->flash('success', 'Duyệt thành công!');
        // gửi API cho google
        $this->set_active_jobs($id);
        // END gửi API cho google
        return redirect()->back();
    }

    public function set_active_jobs($id)
    {
        $job = Job::select('province', 'career_category_id', 'job_id', 'slug', 'employer_id', 'email_to_profile', 'title')
            ->where('job_id', $id)
            ->first();
        $email_employer = $job->email_to_profile;
        if (empty($job->email_to_profile)) {
            $email_employer = Employer::where('employer_id', $job->employer_id)->value('email');
        }
        $slug_gg = route('job_detail', ['slug' => $job->slug]);
        //gửi email kích hoạt
        $send_email_active_job_employer = MailConfigController::send_email_active_job_employer($id, $email_employer);
        //gửi email makettung
        $this->email_maketting_job($id);
//        $slug_gg = 'cong-viec/'.$slug_temp;
        $type = "URL_UPDATED";
        APIgoogle::APIgoogle($type, $slug_gg);

        $user_id_employer = Employer::where('employer_id', $job->employer_id)->value('user_id');
        $check_noti = Notification_employer::where('job_id', $id)
            ->where('user_id', $user_id_employer)
            ->where('type_noti', 'jobs')
            ->first();
        if (empty($check_noti)) {
            $desc_title = 'Sanketoan thông báo tin tuyển dụng' . $job->title . 'đã được duyệt';
            $noti_id = Notification_employer::insertGetId([
                'title_noti' => 'Sanketoan.vn thông báo', //tiêu đề thông báo
                'user_id' => $user_id_employer, //	0 là thông báo chung
                'des_noti' => $desc_title, //Nội dung thông báo
                'link_noti' => '', //Link thông báo trên window
                'type_noti' => 'jobs', //kiểu thông báo  /notification_employer  //employer thông báo của nhà tuyển dụng //employees thong bao ung vien thông báo dựa theo table job //jobs là thông báo về công việc
                'noti_status' => 0,//trạng thái thông báo 0 là chưa xem 1 đã xem
                'status_noti' => 0, //trạng thái thông báo 1 là đã xem 2 là đã xóa => tạm thời bỏ
                'view_noti' => 0, //Đã hiển thị thông báo ở cửa sơ window
                'job_id' => $id,
                'created_at' => new \DateTime()
            ]);
            //push noti cho app
            $title = 'Sàn kế toán thông báo';
            $type = 'jobs';
            $note = 'Thông báo duyệt tin tuyển dụng';
            $value = $noti_id;
            $to = $user_id_employer;
            $push_noti_app = new NotificationMobileController();
            $send_push = $push_noti_app->pushNotification($title, $desc_title, $to, $type, $note, $value);

            //thong báo cho ung vien co tin tuyen dung phu hop voi ung vien duyetj tin


            //gửi thông báo info den ứng viên
            $list_employee = Employee::select('employees.employee_id', 'employees.user_id', 'employee_career_categories.employee_id')
                ->join('employee_career_categories', 'employee_career_categories.employee_id', 'employees.employee_id')
                ->join('users', 'users.id', 'employees.user_id')
                ->where('employees.province', $job->province)
                ->where('employee_career_categories.career_category_id', $job->career_category_id)
                ->orderBy('users.status_res_api', 'desc')
                ->orderBy('employees.updated_at', 'desc')
                ->distinct('employee_career_categories.employee_id')
                ->skip(0)
                ->take(20)
                ->get();

            $link_noti = '';
            foreach ($list_employee as $emp) {
                $noti_insert = Notification_employer::insertGetId([
                    'title_noti' => 'Sanketoan.vn thông báo',
                    'user_id' => $emp->user_id,
                    'employee_id' => $emp->employee_id,
                    'job_id' => $job->job_id,
                    'des_noti' => 'Việc làm  ' . $job->title . ' phù hợp với bạn',
                    'link_noti' => $link_noti,
                    'type_noti' => 'jobs',
                    'created_at' => new \DateTime()
                ]);
//                    gui api thong bao tren mobile
                $api_push_noti = new NotificationMobileController();
                $title = 'Sàn kế toán thông báo';
                $body = 'Có ứng viên mới phù hợp với công việc ' . $job->title;
                $type = 'jobs';
                $note = 'Ứng viên trên  sanketoan $value đã id của ứng viên';
                $value = $emp->employee_id;
                $to = $emp->user_id;
                $send_noti = $api_push_noti->pushNotification($title, $body, $to, $type, $note, $value);
            }
        }

        return true;
    }

    //guii email maketing cho ung vien co cong viec phu hop
    public function email_maketting_job($job_id)
    {
        $job = Job::select('job_id', 'slug', 'employer_id', 'email_to_profile', 'province',
            'district', 'career_category_id')
            ->where('job_id', $job_id)
            ->first();

        $employee = new Employee();
        $list_employee = $employee->select('employees.email as employee_email', 'employees.province', 'employee_district.district_id', 'employee_career_categories.career_category_id');
        $list_employee = $list_employee->leftJoin('send_user_email_marketting', 'send_user_email_marketting.email', '=', 'employees.email');
        if (!empty($job->district)) {
            $list_employee = $list_employee->leftJoin('employee_district', 'employee_district.employee_id', '=', 'employees.employee_id')->where('employee_district.district_id', $job->district);
        }
        if (!empty($job->career_category_id)) {
            $list_employee = $list_employee->leftJoin('employee_career_categories', 'employee_career_categories.employee_id', '=', 'employees.employee_id')->where('employee_career_categories.career_category_id', $job->career_category_id);
        }
        $list_employee = $list_employee->where('employees.province', $job->province);
        $list_employee = $list_employee->where('employees.status_employee', 1);
        $list_employee = $list_employee->where('employees.show_hidden_profile', 0);
        $list_employee = $list_employee->whereNull('send_user_email_marketting.email')
            ->distinct()
            ->limit(10)
            ->get();
        if (!empty($list_employee)) {
            foreach ($list_employee as $employee) {
                $send_email = MailConfigController::send_email_employee_job($job_id, $employee->employee_email);
            }
        }
    }

    public function job_vip(Request $request)
    {
        $jobs = new Job();
        $jobs = $jobs->select(
            'jobs.*',
            'employer.employer_id as employers_id ',
            'employer.enterprise_name',
            'employer.email',
            'users.name as user_name'
        );
        $jobs = $jobs->leftjoin('employer', 'employer.employer_id', 'jobs.employer_id');
        $jobs = $jobs->leftjoin('users', 'users.id', 'jobs.user_id');
        //        danh mục ngành nghề
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            $jobs = $jobs->whereDate('jobs.updated_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $jobs = $jobs->whereDate('jobs.updated_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
        //        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
        //        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
        //        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
        //        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
        //        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
        //        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
        //        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('jobs.title', 'job_code', '%' . $job_code . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_name'))) {
            $jobs = $jobs->where('employer.enterprise_name', 'like', '%' . $request->input('employer_name') . '%');
        }
        if ($request->input('active_job') != null && $request->input('active_job') != "") {
            $active_job = $request->input('active_job');
            $jobs = $jobs->where('active_job', $active_job);
        }


        $jobs = $jobs->where('jobs.vip', 1);
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $total_job = $jobs->count();
        $num = 20;
        if (!empty($request->num)) {
            $num = $request->num;
        }
        $jobs = $jobs->paginate($num);

        $jobs->appends(request()->query());
        return view('staff_admin.job.job_ntd.job_vip', compact('jobs', 'total_job'));
    }

    public function job_casual(Request $request)
    {
        $jobs = new Job();
        $jobs = $jobs->select(
            'jobs.*',
            'employer.employer_id as employers_id ',
            'employer.enterprise_name',
            'employer.email',
            'users.name as user_name'
        );
        $jobs = $jobs->leftjoin('employer', 'employer.employer_id', 'jobs.employer_id');
        $jobs = $jobs->leftjoin('users', 'users.id', 'jobs.user_id');
        //        danh mục ngành nghề
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            $jobs = $jobs->whereDate('jobs.updated_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $jobs = $jobs->whereDate('jobs.updated_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
        //        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
        //        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
        //        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
        //        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
        //        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
        //        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
        //        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('jobs.title', 'job_code', '%' . $job_code . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobs = $jobs->where('jobs.employer_id', $request->input('employer_id'));
        }
        if ($request->input('active_job') != null && $request->input('active_job') != "") {
            $active_job = $request->input('active_job');
            $jobs = $jobs->where('active_job', $active_job);
        }


        $jobs = $jobs->where('jobs.vip', 0);
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $total_job = $jobs->count();
        $num = 20;
        if (!empty($request->num)) {
            $num = $request->num;
        }
        $jobs = $jobs->paginate($num);

        $jobs->appends(request()->query());
        return view('staff_admin.job.job_ntd.job_casual', compact('jobs', 'total_job'));
    }

    public function update_job(Request $request, $id)
    {
        dd($request->all());
    }

    public function form_edit_job(Request $request, $id)
    {
        // dd("đã vào");
        $job = Job::where('job_id', $id)->first();
        $employers = Employer::getselectNameId();
        $salaries = Salary::get();
        $softwares = Software::get();
        $literacies = Literacy::get();
        $jobgroups = JobGroup::get();
        $salePackages = Sale::get();
        //        echo mb_strlen($job->content, 'UTF-8'); //Kết quả là 10
        //        die();
        //        $callApi = new CallApi();
        //        $campaigns = $callApi->getCampaigns();
        $input_tags = Category_tag::all_tags_job();
        return view('staff_admin.job.job_ntd.edit', compact(
            'job',
            'softwares',
            'employers',
            'salaries',
            'literacies',
            'jobgroups',
            'salePackages',
            'input_tags'
        ));
    }

    public function update_job_code(Request $request)
    {
        $job = new Job();
        $list_jobs = $job->select('job_id', 'job_code')->get();
        foreach ($list_jobs as $jobs) {
            $update = $job->where('job_id', $jobs->job_id)->update([
                'job_code' => 'SKT' . $jobs->job_id
            ]);
        }
        $request->session()->flash('success', 'Cập nhật thành công!');
        return redirect()->back();
    }

    public function list_date_end(Request $request)
    {
        //        mb_strlen($job->content, 'UTF-8')
        $jobs = new Job();
        $jobs = $jobs->select(
            'jobs.*',
            'employer.employer_id as employers_id ',
            'employer.enterprise_name',
            'employer.email',
            'users.name as user_name'
        );
        $jobs = $jobs->leftjoin('employer', 'employer.employer_id', '=', 'jobs.employer_id');
        $jobs = $jobs->leftjoin('users', 'users.id', 'jobs.user_id');
        //        danh mục ngành nghề
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            $jobs = $jobs->whereDate('jobs.created_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $jobs = $jobs->whereDate('jobs.created_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
        //        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
        //        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
        //        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
        //        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
        //        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
        //        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
        //        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('jobs.title', 'job_code', '%' . $job_code . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobs = $jobs->where('jobs.employer_id', $request->input('employer_id'));
        }
        if ($request->input('active_job') != null && $request->input('active_job') != "") {
            $active_job = $request->input('active_job');
            $jobs = $jobs->where('active_job', $active_job);
        }

        $jobs = $jobs->whereDate('jobs.deadline_submit_profile', '<=', date('Y-m-d'));
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $total_job = $jobs->count();
        $num = 20;
        if (!empty($request->num)) {
            $num = $request->num;
        }
        $jobs = $jobs->paginate($num);

        $jobs->appends(request()->query());
        return view('staff_admin.job.job_ntd.job_end', compact('jobs', 'total_job'));
    }

    public function form_create_job()
    {
        $salaries = Salary::get();
        $softwares = Software::get();
        $literacies = Literacy::get();
        $jobgroups = JobGroup::get();
        $salePackages = Sale::get();
        //        echo mb_strlen($job->content, 'UTF-8'); //Kết quả là 10
        //        die();
        //        $callApi = new CallApi();
        //        $campaigns = $callApi->getCampaigns();
        $input_tags = Category_tag::all_tags_job();
        return view('staff_admin.job.job_ntd.create', compact(
            'softwares',
            'salaries',
            'literacies',
            'jobgroups',
            'salePackages',
            'input_tags'
        ));
    }

    public function create()
    {
        $input_tags = Category_tag::all_tags_job();
        return view('staff_admin.job.job_ntd.create', compact('input_tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobs = new Job();
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);
        // thêm tag
        $tags = "";
        foreach ($request->input('tags') as $tag) {
            $tags .= $tag . ',';
        }
        $tags = rtrim($tags, ",");
        // END thêm tag

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        //        echo $request->input('age_id');die();
        try {
            DB::beginTransaction();
            $sale_money = 0;
            if (!empty($request->input('sale_money'))) {
                $sale_money = $request->input('sale_money');
            }

            $job_id = $jobs->insertGetId([
                'title' => $request->input('title'),
                'email_to_profile' => $request->input('email_to_profile'),
                'slug' => $slug,
                'age_id' => $request->input('age_id'),
                'description' => $request->has('description') ? $request->input('description') : '',
                'salary_id' => !empty($request->input('salary_id')) ? $request->input('salary_id') : 0,
                'experience_id' => $request->input('experience_id'),
                'literacy_id' => !empty($request->input('literacy_id')) ? $request->input('literacy_id') : 0,
                'deadline_submit_profile' => $request->input('deadline_submit_profile'),
                'content' => $request->input('content'),
                'welfare' => $request->input('welfare'),
                //se co man hinh rieng de chon nha tuyen dung
                'employer_id' => $request->input('employer_id'),
                'number_recruit' => $request->input('number_recruit'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'vip' => $request->input('vip'),
                // 'position' => $request->input('position'),
                'gender' => $request->input('gender'),
                // 'image' => $request->input('image'),
                // 'image_list' => $request->input('image_list'),
                'tags' => $tags,
                'date_end' => $request->input('date_end'),
                // 'campain_candidate' => $request->input('campain_candidate'),
                // 'user_id_candidate' => $request->input('user_id_candidate'),
                // 'campain_status' => $request->input('campain_status'),
                // 'meta_title' => $request->has('meta_title') ? $request->input('meta_title') : null,
                // 'meta_description' => $request->has('meta_description') ? $request->input('meta_description') : null,
                // 'meta_keyword' => $request->has('meta_keyword') ? $request->input('meta_keyword') : null,
                'active_job' => 1,
                'user_id' => Auth::user()->id,
                'day_handling' => date('Y-m-d H:i:s'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'created_at' => new \DateTime(),
                //chia se kiếm tiền
                'sale_money' => $sale_money,
                'status_select_job' => $request->status_select_job,
                //goi bán hàng
                'sale_package_id' => $request->input('salePackages'),
                //phần mềm Y/C
                'software_id' => $request->input('software'),
                //                nhóm công việc
                'jobgroup_id' => $request->input('jobgroup_id'),
                //                danh mục ngành nghề
                'career_category_id' => $request->input('career_category_id'),
                //                Địa chỉ
                'address_work' => $request->input('address')
            ]);
            $update_code = $jobs->where('job_id', '=', $job_id)
                ->update([
                    'job_code' => 'SKT' . $job_id
                ]);
            $postWithSlug = $jobs->where('slug', $slug)->first();

            $jobs->where('job_id', '=', $job_id)
                ->update([
                    'slug' => $slug . '-' . $job_id
                ]);

            // gửi API cho google
            $slug_gg = 'viec-lam-facebook/' . $slug . '-' . $job_id;
            $type = "URL_UPDATED";
            APIgoogle::APIgoogle($type, $slug_gg);
            // END gửi API cho google
            DB::commit();
            $request->session()->flash('success', 'Thêm mới thành công!');
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Thêm mới thất bại!');
            DB::rollback();
        } finally {

            return redirect(route('staff_job-ntd.index'));
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
        //
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
        // dd($request->all());
        $jobs = new Job();
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        // thêm tag
        $tags = "";
        foreach ($request->input('tags') as $tag) {
            $tags .= $tag . ',';
        }
        $tags = rtrim($tags, ",");
        // END thêm tag

        $job = $jobs->select('*')->where('job_id', $id)->first();
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        if (!empty(Job::where('slug', $slug)
            ->where('job_id', '!=', $id)->first())) {
            $slug .= '-' . $id;
        }

//        try {
        $sale_money = 0;
        if (!empty($request->input('sale_money'))) {
            $sale_money = $request->input('sale_money');
        }
        DB::beginTransaction();
        $update = $jobs->where('job_id', $id)->update([
            'title' => $request->input('title'),
            'email_to_profile' => $request->input('email_to_profile'),
            'job_code' => 'SKT' . $id,
            'slug' => $slug,
            'age_id' => $request->input('age_id'),
            'description' => $request->has('description') ? $request->input('description') : '',
            'salary_id' => !empty($request->input('salary_id')) ? $request->input('salary_id') : 0,
            'experience_id' => $request->input('experience_id'),
            'literacy_id' => !empty($request->input('literacy_id')) ? $request->input('literacy_id') : 0,
            'deadline_submit_profile' => $request->input('deadline_submit_profile'),
            'content' => $request->input('content'),
            'welfare' => $request->input('welfare'),
            //se co man hinh rieng de chon nha tuyen dung
            'employer_id' => $request->input('employer_id'),
            'number_recruit' => $request->input('number_recruit'),
            'province' => $request->input('province'),
            'district' => $request->input('district'),
            'vip' => $request->input('vip'),
            'position' => $request->input('position'),
            'gender' => $request->input('gender'),
            'image' => $request->input('image'),
            'image_list' => $request->input('image_list'),
            'tags' => $tags,
            'date_end' => $request->input('date_end'),
            'updated_at' => new \DateTime(),
            'sale_money' => $sale_money,
            'sale_package_id' => $request->input('salePackages'),
            'software_id' => $request->input('software'),
            'jobgroup_id' => $request->input('jobgroup_id'),
            'career_category_id' => $request->input('career_category_id'),
            'address_work' => $request->input('address')
        ]);

        // gửi API cho google
        $slug_gg = route('job_detail', ['slug' => $job->slug]);
        $type = "URL_UPDATED";
        APIgoogle::APIgoogle($type, $slug_gg);

        if (!empty($request->input('send_email_active'))) {
            $email_employer = $job->email_to_profile;
            if (empty($job->email_to_profile)) {
                $email_employer = Employer::where('employer_id', $job->employer_id)->value('email');
            }
            $send_email_update = MailConfigController::send_email_update_job_employer($id, $email_employer);
        }
        // END gửi API cho google
        //lưu vào thông báo
        //check thông báo trước đó
        $user_id_employer = Employer::where('employer_id', $request->input('employer_id'))->value('user_id');
        $check_noti = Notification_employer::where('job_id', $id)
            ->where('user_id', $user_id_employer)
            ->where('type_noti', 'jobs')
            ->first();
        if ($request->input('vip') > 0 && $job->vip == 0) {
            $desc_title = 'Sanketoan thông báo tin tuyển dụng ' . $request->input('title') . ' đã đăng nâng thành tin tuyển dụng Vip';
            $noti_id = Notification_employer::insertGetId([
                'title_noti' => 'Sanketoan.vn thông báo', //tiêu đề thông báo
                'user_id' => $user_id_employer, //	0 là thông báo chung
                'des_noti' => $desc_title, //Nội dung thông báo
                'link_noti' => '', //Link thông báo trên window
                'type_noti' => 'jobs', //kiểu thông báo  /notification_employer  //employer thông báo của nhà tuyển dụng //employees thong bao ung vien thông báo dựa theo table job //jobs là thông báo về công việc
                'noti_status' => 0,//trạng thái thông báo 0 là chưa xem 1 đã xem
                'status_noti' => 0, //trạng thái thông báo 1 là đã xem 2 là đã xóa => tạm thời bỏ
                'view_noti' => 0, //Đã hiển thị thông báo ở cửa sơ window
                'job_id' => $id,
                'created_at' => new \DateTime()
            ]);
            //push noti cho app
            $title = 'Sàn kế toán thông báo';
            $type = 'jobs';
            $note = 'Thông báo về nâng tin tuyển dụng thành tin vip';
            $value = $noti_id;
            $to = $user_id_employer;
            $push_noti_app = new NotificationMobileController();
            $send_push = $push_noti_app->pushNotification($title, $desc_title, $to, $type, $note, $value);
        }
        DB::commit();
        $request->session()->flash('success', 'Cập nhật thành công!');
        return redirect(route('staff_job-ntd.index'));
//        } catch (\Exception $exception) {
//            $request->session()->flash('error', 'Cập nhật thất bại!');
//            DB::rollback();
//        } finally {
//
//            return redirect(route('staff_job-ntd.index'));
//        }
    }

    public function Detail($id)
    {
        // dd($id);
        $job = new Job();
        $job = $job->select([
            '*'
        ])->where('job_id', $id)
            ->first();

        $check = 0;
        $check_d = Job_delete_request::where('job_id', $id)->first();
        if ($check_d != null) {
            $check = 1;
        }
        $history = Job_handling::select('job_handling.*', 'u.name as user_name')
            ->leftjoin('users as u', 'u.id', 'job_handling.user_id_handling')
            ->where('job_handling.job_id', $id)
            ->orderby('job_handling.id', 'desc')->paginate(4);
        return view('staff_admin.job.job_ntd.interactive', compact('job', 'check', 'history'));
    }

    public function send_email_job(Request $request, $id)
    {
        // dd($id);
        $job = new Job();
        $job = $job->select([
            '*'
        ])->where('job_id', $id)
            ->first();
        $employees = new Employee();
        //sap xep theo so tien
        $vip_employee = $employees->select('employees.employee_id',
            'employees.employee_name',
            'employees.employee_slug',
            'employees.employee_image',
            'employees.employee_level_id',
            'employees.time_to_work',
            'employees.updated_at as date_update',
            'employees.created_at as date_create',
            'employees.user_id',
            'employees.status',
            'employees.views',
            'employees.email',
            'employees.phone',
            'employees.marry',
            'employees.profile',
            'salary.description',
            'province.province_name')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province');

        if (!empty($request->input('province'))) {
            $vip_employee = $vip_employee->where('employees.province', $request->input('province'));
        }
        if (!empty($request->input('career_category_id'))) {
//            echo $request->input('career_category_id');
            $vip_employee = $vip_employee->join('employee_career_categories', 'employee_career_categories.employee_id', '=', 'employees.employee_id');
            $career_category_id = $request->input('career_category_id');
            $vip_employee = $vip_employee->where('employee_career_categories.career_category_id', $career_category_id);
        }
        if (!empty($request->input('district_id'))) {
            //            //join với quận huyện
            $vip_employee = $vip_employee->join('employee_district', 'employee_district.employee_id', '=', 'employees.employee_id');
            $vip_employee = $vip_employee->join('district', 'district.district_id', '=', 'employee_district.district_id');
            $district_id = $request->input('district_id');
            $vip_employee = $vip_employee->where('employee_district.district_id', $district_id);
        }
        if (!empty($request->input('salary_id'))) {
            $salary_id = $request->input('salary_id');
            $vip_employee = $vip_employee->where('employees.salary_id', $salary_id);
        }
        if (!empty($request->input('word'))) {
            $word = $request->input('word');
            $vip_employee = $vip_employee->where('employees.employee_name', 'like', '%' . $word . '%');
        }
        if (!empty($request->input('experience_id'))) {
            $experience_id = $request->input('experience_id');
            $vip_employee = $vip_employee->where('employees.experience_id', $experience_id);
        }
        if (!empty($request->input('profile'))) {
            $profile = $request->input('profile');
            $vip_employee = $vip_employee->where('employees.profile', '>=', $profile);
        }

        if ($request->has('time_to_work')) {
            $date_home = date_create();
            $date_home_year = date_format($date_home, "Y");
            $time_to_work = $request->input('time_to_work');
            $time_ex = $date_home_year - $time_to_work;
//            echo $time_ex;die();
            if ($time_to_work >= 6) {
                $vip_employee = $vip_employee->where('employees.time_to_work', '<=', $time_ex);
            } else {
                $vip_employee = $vip_employee->where('employees.time_to_work', '<=', $time_ex);
                $vip_employee = $vip_employee->orderBy('employees.time_to_work', 'desc');
            }
        };
        $vip_employee = $vip_employee->where('employees.status_employee', 1);
        $vip_employee = $vip_employee->where('employees.show_hidden_profile', 0);
        $vip_employee = $vip_employee->whereNotNull('employees.email');
        $vip_employee = $vip_employee->orderBy('employees.updated_at', 'desc');
        if (!empty($request->input('limit_employee'))) {
            $limit_employee = $request->input('limit_employee');
            $vip_employee = $vip_employee->paginate($limit_employee);
            $vip_employee->appends(request()->query());
        } else {
            $vip_employee = $vip_employee->paginate(20);
            $vip_employee->appends(request()->query());

        }
        return view('staff_admin.job.job_ntd.list_employee_interactive', compact('vip_employee', 'job'));
    }

    public function post_send_email_job(Request $request)
    {
        $list_id = $request->input('list_id');
        $job_id = $request->input('job_id');
        if (!empty($list_id)) {
            foreach ($list_id as $id) {
                $email_employee = Employee::where('employee_id', $id)->value('email');
                $send_email = MailConfigController::send_staff_apply_job($job_id, $email_employee);
            }
        }
//
        return redirect()->back()->with('success', 'Bạn đã gửi mail thành công');
    }

    public function delete_request(Request $request, $id)
    {
        try {
            $update = Job_delete_request::insert([
                'job_id' => $id,
                'staff_id' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $request->session()->flash('success', 'Đề nghị xóa thành công!');
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Đề nghị xóa thất bại!');
            return redirect()->back();
        }
    }

    public function undelete_request(Request $request, $id)
    {
        try {
            $update = Job_delete_request::where('job_id', $id)->delete();
            $request->session()->flash('success', 'Bỏ đề nghị xóa thành công!');
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Bỏ đề nghị xóa thất bại!');
            return redirect()->back();
        }
    }

    public function delete_all_request(Request $request)
    {
        // dd(1);
        try {
            $list_id = $request->Ids;
            for ($i = 0; $i < count($list_id); $i++) {
                $check = Job_delete_request::where('job_id', $list_id[$i])->first();
                if ($check == null) {
                    $create = Job_delete_request::insert([
                        'job_id' => $list_id[$i],
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

    public function deleteAll(Request $request)
    {
        // dd(1);
        $ids = $request->ids;
        $arrids = explode(",", $ids);
        foreach ($arrids as $arrid) {
            Job::where('job_id', $arrid)->delete();
        }
        return response()->json(['success' => "Xóa hẳn thành công !!!"]);

    }

    public function deleteAllHard(Request $request)
    {
        // dd(1);
        $ids = $request->ids;
        $arrids = explode(",", $ids);
        foreach ($arrids as $arrid) {
            Job::where('job_id', $arrid)->forceDelete();
        }
        return response()->json(['success' => "Xóa hẳn thành công !!!"]);

    }

    public function deleteHard($product_id)
    {
        Job::where('job_id', $product_id)->forceDelete();
        return redirect()->back()->with('success', 'Xóa hẳn thành công !!!');

    }

    public function approved_all_job(Request $request)
    {
        $id = $request->input('list_id');
        // dd($id);
        if ($id == null) {
            $request->session()->flash('error', 'Vui lòng chọn việc làm cần duyệt!');
            return redirect()->back();
        }
        $update = Job::whereIn('job_id', $id)->update([
            'active_job' => 1
        ]);
        for ($i = 0; $i < count($id); $i++) {
            $create = Job_handling::insert([
                'job_id' => $id[$i],
                'user_id_handling' => Auth::user()->id,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        $request->session()->flash('success', 'Duyệt thành công!');
        return redirect()->back();
    }

    public function approved_all_job_2(Request $request)
    {
        $list_id = $request->Ids;
        for ($i = 0; $i < count($list_id); $i++) {
            $update = Job::where('job_id', $list_id[$i])->update([
                'active_job' => 1,
                'sale_money' => 1
            ]);
            $this->set_active_jobs($list_id[$i]);
        }
        for ($i = 0; $i < count($list_id); $i++) {
            $check = Job_handling::where('job_id', $list_id[$i])->first();
            if ($check == null) {
                $create = Job_handling::insert([
                    'job_id' => $list_id[$i],
                    'user_id_handling' => Auth::user()->id,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return response()->json();
    }

    public function unapproved_all_job_2(Request $request)
    {
        $list_id = $request->Ids;
        for ($i = 0; $i < count($list_id); $i++) {
            $update = Job::where('job_id', $list_id[$i])->update([
                'active_job' => 0
            ]);
        }
        for ($i = 0; $i < count($list_id); $i++) {
            $check = Job_handling::where('job_id', $list_id[$i])->first();
            if ($check == null) {
                $create = Job_handling::insert([
                    'job_id' => $list_id[$i],
                    'user_id_handling' => Auth::user()->id,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return response()->json();
    }

    public function SendFeedbackJob(Request $request, $id)
    {
        try {
            // dd($id);
            $id_cate_tem = 27;
            $item = Job::select('e.enterprise_name', 'e.email', 'jobs.job_id', 'jobs.active_job', 'jobs.email_to_profile')
                ->join('employer as e', 'e.employer_id', 'jobs.employer_id')->where('jobs.job_id', $id)->first();
            $create = Job_handling::insert([
                'user_id_handling' => Auth::user()->id,
                'job_id' => $id,
                'status' => $item->active_job,
                'feedback' => $request->input('feedback'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $email_employer = $item->email_to_profile;
            if (empty($item->email_to_profile)) {
                $email_employer = $item->email;
            }
            MailConfigController::send_feedback_all_employer($item->enterprise_name, $email_employer, $request->input('feedback'));
            $request->session()->flash('success', 'Phản hồi thành công!');
            return redirect()->back();
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Phản hồi không thành công!');
            return redirect()->back();
        }
    }

    public function SendFeedbackAllJob(Request $request)
    {
        //tam thời ẩn
        // try {
        // return "đã vào";
        if (count($request->Ids) > 0) {
            $listAccounting = Job::select('e.enterprise_name', 'e.email', 'jobs.job_id', 'jobs.active_job')->join('employer as e', 'e.employer_id', 'jobs.employer_id')->wherein('jobs.job_id', $request->Ids)->get();
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
                $create = Job_handling::insert([
                    'user_id_handling' => Auth::user()->id,
                    'job_id' => $ls->job_id,
                    'status' => $ls->active_job,
                    'feedback' => $request->input('content'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $search = ['{content}', '{name}', '{email}'];
                $replace = [$request->input('content'), $ls->enterprise_name, $ls->email];
                $content = str_replace($search, $replace, $content_email);
                MailConfig::sendMail($ls->email, $subject, $content);
            }

        }
        $request->session()->flash('success', 'Phản hồi tất cả thành công!');
        return redirect()->back();
        // } catch (\Exception $e) {
        //     $request->session()->flash('error', 'Phản hồi không thành công!');
        //     return redirect()->back();
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list_deleted(Request $request)
    {
        $jobs = new Job();
        $jobs = $jobs->select(
            'jobs.*',
            'employer.employer_id as employers_id ',
            'employer.enterprise_name',
            'employer.email',
            'users.name as user_name'
        );
        $jobs = $jobs->leftjoin('employer', 'employer.employer_id', 'jobs.employer_id');
        $jobs = $jobs->leftjoin('users', 'users.id', 'jobs.user_id');
        //        danh mục ngành nghề
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            // dd($date_search_start);
            $jobs = $jobs->whereDate('jobs.created_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $jobs = $jobs->whereDate('jobs.created_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
        //        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
        //        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
        //        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
        //        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
        //        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
        //        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
        //        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('job_code', 'like', '%' . $job_code . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobs = $jobs->where('jobs.employer_id', $request->input('employer_id'));
        }
        if (!empty($request->input('employer_name'))) {
            $jobs = $jobs->where('employer.enterprise_name', 'like', '%' . $request->input('employer_name') . '%');
        }
        if ($request->input('active_job') != null && $request->input('active_job') != "") {
            $active_job = $request->input('active_job');
            $jobs = $jobs->where('active_job', $active_job);
        }
        $num = 30;
        if (!empty($request->num)) {
            $num = $request->num;
        }


        $jobs = $jobs->orderBy('jobs.job_id', 'desc')->onlyTrashed();
        $total_job = $jobs->count();
        $jobs = $jobs->paginate($num);

        $jobs->appends(request()->query());


        return view('staff_admin.job.job_ntd.list', compact('jobs', 'total_job'));
    }

    public function job_ntd_srestore(Request $request, $job_id)
    {

        $jobs_model = new Job();

        $restore = $jobs_model->withTrashed()->where('job_id', $job_id)->restore();


        return redirect()->back()->with('success', 'Khôi phục thành công');
    }
}
