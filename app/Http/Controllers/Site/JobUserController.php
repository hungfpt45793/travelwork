<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Category_tag;
use App\Entity\Career;
use App\Entity\Coin_apply_employee;
use App\Entity\Coin_history_employer;
use App\Entity\Coin_history_money_employer;
use App\Entity\Coin_show_employee;
use App\Entity\Employee;
use App\Entity\Employee_experience;
use App\Entity\Employee_follow_employer;
use App\Entity\Employee_specialize;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Employees_save_job_facebook;
use App\Entity\Employer;
use App\Entity\EmployerIntership;
use App\Entity\Job;
use App\Entity\Job_company;
use App\Entity\Job_question;
use App\Entity\JobFacebook;
use App\Entity\Noti_career_category_id;
use App\Entity\Notification_employer;
use App\Entity\NotificationWindow;
use App\Entity\Order_job;
use App\Entity\Province;
use App\Entity\Salary;
use App\Entity\Teacher;
use App\Entity\Teacher_save_job_facebook;
use App\Exam\Exam;
use App\Http\Controllers\Api\NotificationMobileController;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Rules\Invateemails;
use Illuminate\Support\Facades\Validator;
use App\Mail\Resetpassword;
use Carbon\Carbon;


class JobUserController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!Auth::check()) {
                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng dăng nhập để sử dụng chức năng này !');
            }
            $this->id_user = Auth::user()->id;
            $ckeditor = new CkedittorController();
            $session_image = $ckeditor->checkImage();
            return $next($request);
        });
    }

//    check quyền nhà tuyển dụng
    private function checkRoleUser()
    {
        $role = Auth::user()->role;
        if ($role == 2) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllUser(Request $request)
    {
        $this->checkRoleUser();
        $user_id = Auth::user()->id;
        $jobFacebooks = JobFacebook::select('job_facebook.*', 'province.province_name', 'district.district_name', 'users.name')
            ->leftJoin('province', 'province.province_id', '=', 'job_facebook.province')
            ->leftJoin('district', 'district.district_id', '=', 'job_facebook.district')
            ->leftJoin('users', 'users.id', '=', 'job_facebook.user_id')
            ->where('job_facebook.user_id', $user_id)
            ->orderBy('job_facebook_id', 'desc')
            ->paginate(10);
        $salaries = Salary::orderBy('salary_id')->get();
        $user = Auth::user();

        return view('site.job_facebook.list_job_fb', compact('jobFacebooks', 'salaries', 'user'));
    }

    public function index(Request $request)
    {
//        hien thi o phan function getAllUser();
    }

    public function getAllJobs(Request $request)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user = Auth::user();
        $user_id = Auth::user()->id;

        $employees = New Employer();
        $employee = $employees->select('employer_id')->where('user_id', $user_id)->first();

        $job = new Job();
        $jobs = $job->select(
            '*'
        );
        $jobs = $jobs->where('employer_id', $employee->employer_id);
        $jobs = $jobs->where('status_select_job', 0);
//        $jobs = $jobs->where('active_job', 1);
        $jobs = $jobs->orderBy('job_id', 'desc');
        $total_job = $jobs->count();

        $jobs = $jobs->paginate(30);

//        echo '<pre>';
//        print_r($jobs);die();
        $jobs->appends(request()->query());
        return view('site.jobs_site.list_jobs', compact('jobs', 'total_job', 'user'));
    }

    public function get_job_all_vip(Request $request)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user = Auth::user();
        $user_id = Auth::user()->id;

        $employer_model = New Employer();
        $employer = $employer_model->select('employer_id', 'employer_vip')
            ->where('user_id', $user_id)
            ->where('employer_vip', 1)
            ->first();
        if (empty($employer)) {
            return redirect(route('getAllJobs'))->with('error_login', 'Chức năng này danh cho nhà tuyển dụng vip');
        }
        $job = new Job();
        $jobs = $job->select(
            'job_id',
            'job_code',
            'vip',
            'views',
            'status',
            'employer_id',
            'experience_id',
            'literacy_id',
            'deadline_submit_profile',
            'number_recruit',
            'province',
            'district',
            'address_work',
            'salary_id',
            'age_id',
            'gender',
            'content',
            'sale_package_id',
            'slug',
            'description',
            'tags',
            'created_at',
            'updated_at',
            'deleted_at',
            'people_seen',
            'date_submit',
            'title',
            'date_end',
            'jobgroup_id',
            'career_category_id',
            'status_exam',
            'id_exam',
            'date_exam_job',
            'software_id',
            'welfare',
            'count_updated_at',
            'active_job',
            'sale_money',
            'user_id',
            'day_handling',
            'status_select_job'
        );
        $jobs = $jobs->where('employer_id', $employer->employer_id);
        $jobs = $jobs->where('status_select_job', 1);
//        $jobs = $jobs->where('active_job', 1);
        $jobs = $jobs->orderBy('job_id', 'desc');
        $total_job = $jobs->count();

        $jobs = $jobs->paginate(30);

//        echo '<pre>';
//        print_r($jobs);die();
        $jobs->appends(request()->query());
        return view('site.jobs_site.get_job_all_vip', compact('jobs', 'total_job', 'user'));
    }

    public function ajax_get_company_id(Request $request)
    {
        $job_company_id = $request->input('job_company_id');
        $job_company = Job_company::select('job_company.job_company_id',
            'job_company.job_id',
            'job_company.employer_id',
            'job_company.tax_code',
            'job_company.job_company_title',
            'job_company.province_id',
            'job_company.district_id',
            'job_company.address',
            'job_company.introduction',
            'jobs.title'
        )
            ->join('jobs', 'jobs.job_id', '=', 'job_company.job_id')
            ->where('job_company.job_company_id', $job_company_id)
            ->first();
        return response()->json([
            'status' => 200,
            'job_company' => $job_company,
        ]);


    }

    public function create_job_all_vip(Request $request)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user = Auth::user();
        $salaries = Salary::orderBy('salary_id')->get();
        $exam = new Exam();
        $exams = $exam->select('id_exam', 'code_exam', 'name_exam', 'id_user', 'bank_exam')
            ->where('id_user', $user->id)
            ->orWhere('bank_exam', 1)
            ->orderBy('id_exam', 'desc')
            ->get();
        $employer = Employer::select('employer_id',
            'employer_code',
            'enterprise_name',
            'phone',
            'email',
            'province',
            'district',
            'employer_vip',
            'address'
        )->where('user_id', $user->id)
            ->where('employer_vip', 1)
            ->first();
        if (empty($employer)) {
            return redirect(route('getAllJobs'))->with('error_login', 'Chức năng này danh cho nhà tuyển dụng vip');
        }
        $input_tags = Category_tag::all_tags_job();
        $job_company = Job_company::select('job_company.job_company_id',
            'job_company.job_id',
            'job_company.employer_id',
            'job_company.tax_code',
            'job_company.job_company_title',
            'job_company.province_id',
            'job_company.district_id',
            'job_company.address',
            'job_company.introduction',
            'jobs.title'
        )
            ->join('jobs', 'jobs.job_id', '=', 'job_company.job_id')
            ->where('job_company.employer_id', $employer->employer_id)
            ->get();
//        echo '<pre>';
//        print_r($job_company);die;
        return view('site.jobs_site.add_job_hr', compact('user', 'salaries', 'exams', 'employer', 'input_tags', 'job_company'));
    }

    public function save_job_all_vip(Request $request)

    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user_id = Auth::user()->id;
        $employer = New Employer();
        $employer = $employer->select('employer_id', 'enterprise_name', 'email', 'profile')->where('user_id', $user_id)->first();
        $validation = Validator::make($request->all(), [
            'career_category_id' => 'required',
            'salary_id' => 'required',
            'experience_id' => 'required',
            'deadline_submit_profile' => 'required',
            'number_recruit' => 'required',
            'literacy_id' => 'required',
            'province' => 'required',
            'district' => 'required',
            'address_work' => 'required',
            'description' => 'required',
            'content' => 'required',
            'welfare' => 'required'
        ], [
            'career_category_id.required' => 'Vui lòng chọn vị trí cần tuyển',
            'salary_id.required' => 'Vui lòng chọn mức lương',
            'experience_id.required' => 'Vui lòng chọn kinh nghiệm cần tuyển',
            'deadline_submit_profile.required' => 'Vui lòng chọn hạn nộp hồ sơ',
            'number_recruit.required' => 'Số lượng cần tuyển không được để trống',
            'literacy_id.required' => 'Vui lòng chọn trình độ học vấn',
            'province.required' => 'Vui lòng chọn thành phố',
            'district.required' => 'Vui lòng chọn quận huyện',
            'address_work.required' => 'Địa chỉ làm việc không được để trống',
            'description.required' => 'Mô tả vị trí công việc không được để trống',
            'content.required' => 'Yêu cầu công việc không được để trống',
            'welfare.required' => 'Phúc lợi xã hội không được để trống'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $active_job = 0;
            $tags = "";
            if (!empty($request->input('tags'))) {
                foreach ($request->input('tags') as $tag) {
                    $tags .= $tag . ',';
                }
                $tags = rtrim($tags, ",");
            }

            // END thêm tag
            $jobs = new Job();
            $status_exam = 0;
            if (!empty($request->input('id_exam'))) {
                $status_exam = 1;
            }
            $job_id = $jobs->insertGetId([
                'age_id' => !empty($request->input('age_id') ? $request->input('age_id') : 0),
                'description' => $request->has('description') ? $request->input('description') : '',
                'salary_id' => !empty($request->input('salary_id')) ? $request->input('salary_id') : 0,
                'experience_id' => !empty($request->input('experience_id')) ? $request->input('experience_id') : 0,
                'literacy_id' => !empty($request->input('literacy_id')) ? $request->input('literacy_id') : 0,
                'deadline_submit_profile' => $request->input('deadline_submit_profile'),
                'content' => !empty($request->input('content')) ? $request->input('content') : '',
                'number_recruit' => !empty($request->input('number_recruit')) ? $request->input('number_recruit') : 1,
                'province' => !empty($request->input('province')) ? $request->input('province') : 0,
                'district' => !empty($request->input('district')) ? $request->input('district') : 0,
                'tags' => $tags,
                'vip' => 0,
                'gender' => $request->input('gender'),
                'date_end' => $request->input('deadline_submit_profile'),
                'date_submit' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'created_at' => new \DateTime(),
                //goi bán hàng
                'employer_id' => $employer->employer_id,
                //phần mềm Y/C
                'software_id' => !empty($request->input('software')) ? $request->input('software') : 0,
//                danh mục ngành nghề
                'career_category_id' => $request->input('career_category_id'),
//                Địa chỉ
                'address_work' => $request->input('address_work'),
                'status_exam' => $status_exam,
                'id_exam' => $request->input('id_exam'),
                'welfare' => $request->input('welfare'),
                'active_job' => $active_job,
                'count_updated_at' => 0,
                'status_select_job' => 1
            ]);
            $string_career = Career::where('career_category_id', $request->input('career_category_id'))->value('career_category_name');
            $string_province = Province::where('province_id', $request->input('province'))->value('province_name');

            $title = $string_career . ' tại ' . $string_province;
            $slug = str_slug($string_career) . '-tai-' . str_slug($string_province) . '-' . $job_id;
            $update = $jobs->where('job_id', $job_id)->update([
                'job_code' => 'SKT' . $job_id,
                'title' => $title,
                'slug' => $slug
            ]);
            $compony = Job_company::insert([
                'job_id' => $job_id,
                'employer_id' => $employer->employer_id,
                'tax_code' => $request->input('tax_code'),
                'job_company_title' => !empty($request->input('name_company')) ? $request->input('name_company') : '',
                'province_id' => !empty($request->input('province_company')) ? $request->input('province_company') : '',
                'district_id' => !empty($request->input('district_company')) ? $request->input('district_company') : 0,
                'address' => !empty($request->input('address_company')) ? $request->input('address_company') : '',
                'introduction' => !empty($request->input('introduction_company')) ? $request->input('introduction_company') : '',
                'created_at' => new \DateTime()
            ]);
            //gửi email hướng dẫn sử dụng chức năng của  nhà tuyển dụng
//            $send_email = MailConfigController::employer_create_job($employer->email);
            DB::commit();
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
            return redirect(route('get_job_all_vip'))->with('error', 'Thêm tin tuyển dụng thất bại');
        } finally {
            return redirect(route('get_job_all_vip') . '?job_id=' . $job_id)->with('suscess', 'Thêm tin tuyển dụng thành công');
        }
    }

    public function edit_job_all_vip($job_id)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user = Auth::user();
        $salaries = Salary::orderBy('salary_id')->get();
        $exam = new Exam();
        $exams = $exam->select('id_exam', 'code_exam', 'name_exam', 'id_user', 'bank_exam')
            ->where('id_user', $user->id)
            ->orWhere('bank_exam', 1)
            ->orderBy('id_exam', 'desc')
            ->get();
        $employer = Employer::select('employer_id',
            'employer_code',
            'enterprise_name',
            'phone',
            'email',
            'province',
            'district',
            'employer_vip',
            'address'
        )->where('user_id', $user->id)
            ->where('employer_vip', 1)
            ->first();
        if (empty($employer)) {
            return redirect(route('getAllJobs'))->with('error_login', 'Chức năng này danh cho nhà tuyển dụng vip');
        }
        $input_tags = Category_tag::all_tags_job();
        $job_company = Job_company::select('job_company.job_company_id',
            'job_company.job_id',
            'job_company.employer_id',
            'job_company.tax_code',
            'job_company.job_company_title',
            'job_company.province_id',
            'job_company.district_id',
            'job_company.address',
            'job_company.introduction',
            'jobs.title'
        )
            ->join('jobs', 'jobs.job_id', '=', 'job_company.job_id')
            ->where('job_company.job_id', $job_id)
            ->first();
        $job = Job::where('job_id', $job_id)->where('employer_id', $employer->employer_id)->first();
//        echo '<pre>';
//        print_r($job);die;
        return view('site.jobs_site.edit_job_hr', compact('user', 'salaries', 'exams', 'employer', 'input_tags', 'job_company', 'job'));
    }

    public function update_job_all_vip(Request $request)

    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user_id = Auth::user()->id;
        $employer = New Employer();
        $employer = $employer->select('employer_id', 'enterprise_name', 'email', 'profile')->where('user_id', $user_id)->first();
        $validation = Validator::make($request->all(), [
            'career_category_id' => 'required',
            'salary_id' => 'required',
            'experience_id' => 'required',
            'deadline_submit_profile' => 'required',
            'number_recruit' => 'required',
            'literacy_id' => 'required',
            'province' => 'required',
            'district' => 'required',
            'address_work' => 'required',
            'description' => 'required',
            'content' => 'required',
            'welfare' => 'required'
        ], [
            'career_category_id.required' => 'Vui lòng chọn vị trí cần tuyển',
            'salary_id.required' => 'Vui lòng chọn mức lương',
            'experience_id.required' => 'Vui lòng chọn kinh nghiệm cần tuyển',
            'deadline_submit_profile.required' => 'Vui lòng chọn hạn nộp hồ sơ',
            'number_recruit.required' => 'Số lượng cần tuyển không được để trống',
            'literacy_id.required' => 'Vui lòng chọn trình độ học vấn',
            'province.required' => 'Vui lòng chọn thành phố',
            'district.required' => 'Vui lòng chọn quận huyện',
            'address_work.required' => 'Địa chỉ làm việc không được để trống',
            'description.required' => 'Mô tả vị trí công việc không được để trống',
            'content.required' => 'Yêu cầu công việc không được để trống',
            'welfare.required' => 'Phúc lợi xã hội không được để trống'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $active_job = 0;
            $tags = "";
            if (!empty($request->input('tags'))) {
                foreach ($request->input('tags') as $tag) {
                    $tags .= $tag . ',';
                }
                $tags = rtrim($tags, ",");
            }

            // END thêm tag
            $jobs = new Job();
            $status_exam = 0;
            if (!empty($request->input('id_exam'))) {
                $status_exam = 1;
            }
            $job_id = $jobs->where('job_id', $request->input('job_id'))
                ->where('employer_id', $employer->employer_id)
                ->update([
                    'age_id' => !empty($request->input('age_id') ? $request->input('age_id') : 0),
                    'description' => $request->has('description') ? $request->input('description') : '',
                    'salary_id' => !empty($request->input('salary_id')) ? $request->input('salary_id') : 0,
                    'experience_id' => !empty($request->input('experience_id')) ? $request->input('experience_id') : 0,
                    'literacy_id' => !empty($request->input('literacy_id')) ? $request->input('literacy_id') : 0,
                    'deadline_submit_profile' => $request->input('deadline_submit_profile'),
                    'content' => !empty($request->input('content')) ? $request->input('content') : '',
                    'number_recruit' => !empty($request->input('number_recruit')) ? $request->input('number_recruit') : 1,
                    'province' => !empty($request->input('province')) ? $request->input('province') : 0,
                    'district' => !empty($request->input('district')) ? $request->input('district') : 0,
                    'tags' => $tags,
                    'vip' => 0,
                    'gender' => $request->input('gender'),
                    'date_end' => $request->input('deadline_submit_profile'),
                    'date_submit' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                    'created_at' => new \DateTime(),
                    //goi bán hàng
                    'employer_id' => $employer->employer_id,
                    //phần mềm Y/C
                    'software_id' => !empty($request->input('software')) ? $request->input('software') : 0,
//                danh mục ngành nghề
                    'career_category_id' => $request->input('career_category_id'),
//                Địa chỉ
                    'address_work' => $request->input('address_work'),
                    'status_exam' => $status_exam,
                    'id_exam' => $request->input('id_exam'),
                    'welfare' => $request->input('welfare'),
                    'active_job' => $active_job,
                    'status_select_job' => 1
                ]);
            $string_career = Career::where('career_category_id', $request->input('career_category_id'))->value('career_category_name');
            $string_province = Province::where('province_id', $request->input('province'))->value('province_name');

            $title = $string_career . ' tại ' . $string_province;
            $slug = str_slug($string_career) . '-tai-' . str_slug($string_province) . '-' . $job_id;
            $update = $jobs->where('job_id', $job_id)->update([
                'job_code' => 'SKT' . $job_id,
                'title' => $title,
                'slug' => $slug
            ]);
            $compony = Job_company::where('job_id', $request->input('job_id'))
                ->where('employer_id', $employer->employer_id)->update([
                    'tax_code' => $request->input('tax_code'),
                    'job_company_title' => !empty($request->input('name_company')) ? $request->input('name_company') : '',
                    'province_id' => !empty($request->input('province_company')) ? $request->input('province_company') : '',
                    'district_id' => !empty($request->input('district_company')) ? $request->input('district_company') : 0,
                    'address' => !empty($request->input('address_company')) ? $request->input('address_company') : '',
                    'introduction' => !empty($request->input('introduction_company')) ? $request->input('introduction_company') : '',
                    'updated_at' => new \DateTime()
                ]);
            //gửi email hướng dẫn sử dụng chức năng của  nhà tuyển dụng
//            $send_email = MailConfigController::employer_create_job($employer->email);
            DB::commit();
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
            return redirect(route('get_job_all_vip'))->with('error', 'Cập nhật tin tuyển dụng thất bại');
        } finally {
            return redirect(route('get_job_all_vip') . '?job_id=' . $request->input('job_id'))->with('suscess', 'Cập nhật tin tuyển dụng thành công');
        }
    }

    public function get_job_facebook(Request $request)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user = Auth::user();
        $user_id = Auth::user()->id;

        $employees = New Employer();
        $employee = $employees->select('employer_id')->where('user_id', $user_id)->first();
        $jobfaceboook = new JobFacebook();
        $list_job_facebook = $jobfaceboook->select('*')->where('email', Auth::user()->email)->get();
        $total_job = $jobfaceboook->select('job_facebook_id')->where('email', Auth::user()->email)->count();

        return view('site.job_facebook.list_job_facebook', compact('list_job_facebook', 'total_job', 'user'));
    }

    public function submit_job_facebook($job_facebook_id)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user = Auth::user();
        $user_id = Auth::user()->id;

        $employees = New Employer();
        $employee = $employees->select('employer_id')->where('user_id', $user_id)->first();
        $jobfaceboook = new JobFacebook();
//        $job_facebook = $jobfaceboook->select('*')->where('job_facebook_id', $job_facebook_id)->first();

        $list_jobs = $jobfaceboook::select(
            'job_facebook.*',
            'employee_submit_job_facebook.*',
            'employees.employee_id',
            'employees.employee_slug',
            'employees.employee_name',
            'employees.district',
            'employees.province'
        )
            ->leftJoin('employee_submit_job_facebook', 'employee_submit_job_facebook.id_job_fb', '=', 'job_facebook.job_facebook_id')
            ->join('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
            ->where('job_facebook.job_facebook_id', $job_facebook_id);


        $list_jobs = $list_jobs->orderBy('job_facebook.job_facebook_id', 'desc');
        $list_jobs = $list_jobs->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc');

        $list_jobs = $list_jobs->paginate(10);
        $list_jobs->appends(request()->query());

        return view('site.job_facebook.list_cadidate_job_facebook', compact('list_jobs'));
    }

//    public function detail_employee_submit_job_facebook($submit_job_fb_id)
//    {
//
//        try {
//            $user = Auth::user();
//            if (!$this->checkRoleUser()) {
//                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để sử dụng chức năng này !');
//            }
//
//            $submit_job_employee_model = new Employee_submit_job_faacebook();
//            $submit_job_employee = $submit_job_employee_model->select('employee_submit_job_facebook.*', 'employees.employee_id', 'employees.employee_name')
//                ->join('employees', 'employees.employee_id', '=', 'employee_submit_job_facebook.employee_id')
//                ->where('employee_submit_job_facebook.submit_job_fb_id', $submit_job_fb_id)
//                ->first();
//            $employees = new Employee();
//            $employee = $employees->select('*')->where('employee_id', $submit_job_employee->employee_id)->first();
//
//            //trinh do chuyen mon
//
//            //tong phần tram hồ sơ
//            //$user_id là id trong user
//            $check_syll = $submit_job_employee_model->select('employee_submit_job_facebook.*', 'employees.employee_id', 'employees.employee_name')
//                ->join('employees', 'employees.employee_id', '=', 'employee_submit_job_facebook.employee_id')
//                ->where('employee_submit_job_facebook.submit_job_fb_id', $submit_job_fb_id)
//                ->where('employee_submit_job_facebook.status_syll', 1)
//                ->count();
//
//
//            return view('site.employee.show_profile_facebook_Employee', compact('user', 'employee', 'specialize', 'experience', 'submit_job_employee', 'submit_job_fb_id', 'check_syll'));
//        } catch (\Exception $e) {
//            return redirect(route('get_job_facebook'))->with('error', 'Ứng viên này không tồn tại');
//        }
//    }

    public function create(Request $request)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user = Auth::user();
        $salaries = Salary::where('status_salary', 0)->orderBy('salary_id')->get();
        $exam = new Exam();
        $exams = $exam->select('id_exam', 'code_exam', 'name_exam', 'id_user', 'bank_exam')
            ->where('id_user', $user->id)
            ->orWhere('bank_exam', 1)
            ->orderBy('id_exam', 'desc')
            ->get();
        $employer = Employer::select('employer_id',
            'employer_code',
            'enterprise_name',
            'phone',
            'email',
            'province',
            'district',
            'address'
        )->where('user_id', $user->id)->first();
        $input_tags = Category_tag::all_tags_job();
//        return view('site.jobs.add_job', compact('user', 'salaries', 'exams', 'employer', 'input_tags'));
        return view('site.jobs_site.add_job', compact('user', 'salaries', 'exams', 'employer', 'input_tags'));
    }

    public function ajax_show_content_career(Request $request)
    {
        $career_id = $request->input('career_category_id');
        $career = Career::select('description', 'content', 'welfare')->where('career_category_id', $career_id)->first();

        if (!empty($career)) {
            return response([
                'career' => $career,
                'status' => 200,
            ])->header('Content-Type', 'text/plain');
        } else {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
    }


    public function store(Request $request)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user_id = Auth::user()->id;
        $employer = New Employer();
        $employer = $employer->select('employer_id', 'enterprise_name', 'email', 'profile')->where('user_id', $user_id)->first();
        $validation = Validator::make($request->all(), [
            'career_category_id' => 'required',
            'salary_id' => 'required',
            'experience_id' => 'required',
            'deadline_submit_profile' => 'required',
            'number_recruit' => 'required',
            'literacy_id' => 'required',
            'province' => 'required',
            'district' => 'required',
            'address_work' => 'required',
            'description' => 'required',
            'content' => 'required',
            'welfare' => 'required'
        ], [
            'career_category_id.required' => 'Vui lòng chọn vị trí cần tuyển',
            'salary_id.required' => 'Vui lòng chọn mức lương',
            'experience_id.required' => 'Vui lòng chọn kinh nghiệm cần tuyển',
            'deadline_submit_profile.required' => 'Vui lòng chọn hạn nộp hồ sơ',
            'number_recruit.required' => 'Số lượng cần tuyển không được để trống',
            'literacy_id.required' => 'Vui lòng chọn trình độ học vấn',
            'province.required' => 'Vui lòng chọn thành phố',
            'district.required' => 'Vui lòng chọn quận huyện',
            'address_work.required' => 'Địa chỉ làm việc không được để trống',
            'description.required' => 'Mô tả vị trí công việc không được để trống',
            'content.required' => 'Yêu cầu công việc không được để trống',
            'welfare.required' => 'Phúc lợi xã hội không được để trống'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $active_job = 0;
            $tags = "";
            if (!empty($request->input('tags'))) {
                foreach ($request->input('tags') as $tag) {
                    $tags .= $tag . ',';
                }
                $tags = rtrim($tags, ",");
            }

            // END thêm tag
            $jobs = new Job();
            $status_exam = 0;
            if (!empty($request->input('id_exam'))) {
                $status_exam = 1;
            }
            $job_id = $jobs->insertGetId([
                'age_id' => !empty($request->input('age_id') ? $request->input('age_id') : 0),
                'description' => $request->has('description') ? $request->input('description') : '',
                'salary_id' => !empty($request->input('salary_id')) ? $request->input('salary_id') : 0,
                'experience_id' => !empty($request->input('experience_id')) ? $request->input('experience_id') : 0,
                'literacy_id' => !empty($request->input('literacy_id')) ? $request->input('literacy_id') : 0,
                'deadline_submit_profile' => $request->input('deadline_submit_profile'),
                'content' => !empty($request->input('content')) ? $request->input('content') : '',
                'number_recruit' => !empty($request->input('number_recruit')) ? $request->input('number_recruit') : 1,
                'province' => !empty($request->input('province')) ? $request->input('province') : 0,
                'district' => !empty($request->input('district')) ? $request->input('district') : 0,
                'tags' => $tags,
                'vip' => 0,
                'gender' => $request->input('gender'),
                'date_end' => $request->input('deadline_submit_profile'),
                'date_submit' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'created_at' => new \DateTime(),
                //goi bán hàng
                'employer_id' => $employer->employer_id,
                //phần mềm Y/C
                'software_id' => !empty($request->input('software')) ? $request->input('software') : 0,
//                danh mục ngành nghề
                'career_category_id' => $request->input('career_category_id'),
//                Địa chỉ
                'address_work' => $request->input('address_work'),
                'status_exam' => $status_exam,
                'id_exam' => $request->input('id_exam'),
                'welfare' => $request->input('welfare'),
                'active_job' => $active_job,
                'count_updated_at' => 0
            ]);
            $string_career = Career::where('career_category_id', $request->input('career_category_id'))->value('career_category_name');
            $string_province = Province::where('province_id', $request->input('province'))->value('province_name');

            $title = 'Tuyển dụng ' . $string_career;
            $slug = str_slug('Tuyển dụng') . str_slug($string_career) . '-' . $job_id;

            $update = $jobs->where('job_id', $job_id)->update([
                'job_code' => 'SKT' . $job_id,
                'title' => $title,
                'slug' => $slug
            ]);

            //gửi email hướng dẫn sử dụng chức năng của  nhà tuyển dụng
//            $send_email = MailConfigController::employer_create_job($employer->email);
            DB::commit();
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
            return redirect(route('getAllJobs'))->with('error', 'Thêm tin tuyển dụng thất bại');
        } finally {
            return redirect(route('getAllJobs') . '?job_id=' . $job_id)->with('suscess', 'Thêm tin tuyển dụng thành công');
        }
    }

    public function show(Request $request)
    {

    }

    public function edit(Request $request, $id_job)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $exam = new Exam();
        $exams = $exam->select('id_exam', 'code_exam', 'name_exam', 'id_user', 'bank_exam')
            ->where('id_user', $user->id)
            ->orWhere('bank_exam', 1)
            ->orderBy('id_exam', 'desc')
            ->get();

        $employer_model = new Employer();
        $employer = $employer_model->select('employer_id')->where('user_id', $user_id)->first();
        $job_model = new Job();
        $job = $job_model->select('*')->where('employer_id', $employer->employer_id)->where('job_id', $id_job)->first();
        $salaries = Salary::where('status_salary', 0)->orderBy('salary_id')->get();

        $job_question_model = new Job_question();
        $list_job_question = $job_question_model->select('job_id', 'job_qes_name')->where('job_id', $id_job)->get();
        if (!empty($job)) {
            $input_tags = Category_tag::all_tags_job();
            return view('site.jobs_site.edit_job', compact('user', 'salaries', 'job', 'exams', 'list_job_question', 'input_tags', 'employer'));
//            return view('site.jobs.edit_job', compact('user', 'salaries', 'job', 'exams','list_job_question', 'input_tags'));
        } else {
            return redirect(route('getAllJobs'))->with('erorr', 'Không tồn tại tin tuyển dụng này !');
        }


    }

    //cập nhật tin
    public function update(Request $request, $id_job)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user_id = Auth::user()->id;
        $employer = New Employer();
        $employer = $employer->select('employer_id', 'enterprise_name', 'email', 'profile')->where('user_id', $user_id)->first();
        $validation = Validator::make($request->all(), [
            'career_category_id' => 'required',
            'salary_id' => 'required',
            'experience_id' => 'required',
            'deadline_submit_profile' => 'required',
            'number_recruit' => 'required',
            'literacy_id' => 'required',
            'province' => 'required',
            'district' => 'required',
            'address_work' => 'required',
            'description' => 'required',
            'content' => 'required',
            'welfare' => 'required'
        ], [
            'career_category_id.required' => 'Vui lòng chọn vị trí cần tuyển',
            'salary_id.required' => 'Vui lòng chọn mức lương',
            'experience_id.required' => 'Vui lòng chọn kinh nghiệm cần tuyển',
            'deadline_submit_profile.required' => 'Vui lòng chọn hạn nộp hồ sơ',
            'number_recruit.required' => 'Số lượng cần tuyển không được để trống',
            'literacy_id.required' => 'Vui lòng chọn trình độ học vấn',
            'province.required' => 'Vui lòng chọn thành phố',
            'district.required' => 'Vui lòng chọn quận huyện',
            'address_work.required' => 'Địa chỉ làm việc không được để trống',
            'description.required' => 'Mô tả vị trí công việc không được để trống',
            'content.required' => 'Yêu cầu công việc không được để trống',
            'welfare.required' => 'Phúc lợi xã hội không được để trống'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $jobs = new Job();
            $status_exam = 0;
            if (!empty($request->input('id_exam'))) {
                $status_exam = 1;
            }

            // thêm tag
            $tags = "";
            if (!empty($request->input('tags'))) {
                foreach ($request->input('tags') as $tag) {
                    $tags .= $tag . ',';
                }
                $tags = rtrim($tags, ",");
            }

            $string_career = Career::where('career_category_id', $request->input('career_category_id'))->value('career_category_name');
//            $string_province = Province::where('province_id', $request->input('province'))->value('province_name');

//            $title = $string_career . ' tại ' . $string_province;
            $title = 'Tuyển dụng ' . $string_career;
            $slug = str_slug('Tuyển dụng') . str_slug($string_career) . '-' . $id_job;

            // END thêm tag
            $employer_model = new Employer();
            $employer = $employer_model->select('employer_id')->where('user_id', $user_id)->first();
            $job_id = $jobs->where('employer_id', $employer->employer_id)
                ->where('job_id', $id_job)
                ->update([
                    'age_id' => !empty($request->input('age_id') ? $request->input('age_id') : 0),
                    'description' => $request->has('description') ? $request->input('description') : '',
                    'salary_id' => !empty($request->input('salary_id')) ? $request->input('salary_id') : 0,
                    'experience_id' => !empty($request->input('experience_id')) ? $request->input('experience_id') : 0,
                    'literacy_id' => !empty($request->input('literacy_id')) ? $request->input('literacy_id') : 0,
                    'deadline_submit_profile' => $request->input('deadline_submit_profile'),
                    'content' => !empty($request->input('content')) ? $request->input('content') : '',
                    'number_recruit' => !empty($request->input('number_recruit')) ? $request->input('number_recruit') : 1,
                    'province' => !empty($request->input('province')) ? $request->input('province') : 0,
                    'district' => !empty($request->input('district')) ? $request->input('district') : 0,
                    'tags' => $tags,
                    'gender' => $request->input('gender'),
                    'date_end' => $request->input('deadline_submit_profile'),
                    'date_submit' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                    'created_at' => new \DateTime(),
                    //goi bán hàng
                    'employer_id' => $employer->employer_id,
                    //phần mềm Y/C
                    'software_id' => !empty($request->input('software')) ? $request->input('software') : 0,
//                danh mục ngành nghề
                    'career_category_id' => $request->input('career_category_id'),
//                Địa chỉ
                    'address_work' => $request->input('address_work'),
                    'status_exam' => $status_exam,
                    'id_exam' => $request->input('id_exam'),
                    'welfare' => $request->input('welfare'),
                    'title' => $title,
                    'slug' => $slug
                ]);
            DB::commit();
            return redirect(route('getAllJobs') . '?job_id=' . $id_job)->with('success', 'Cập nhật tin tuyển dụng thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
            return redirect(route('getAllJobs'))->with('error', 'Cập nhật tin tuyển dụng thất bại');
        } finally {
            return redirect(route('getAllJobs') . '?job_id=' . $id_job)->with('success', 'Cập nhật tin tuyển dụng thành công');
        }

    }

    //đẩy tin
    public function update_update_at(Request $request, $id_job)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user_id = Auth::user()->id;
        $employees = New Employer();
        $employee = $employees->select('employer_id')->where('user_id', $user_id)->first();
        try {
            DB::beginTransaction();
            $jobs_model = new Job();
            $status_exam = 0;
            if (!empty($request->input('id_exam'))) {
                $status_exam = 1;
            }
            $employer_model = new Employer();
            $employer = $employer_model->select('employer_id')->where('user_id', $user_id)->first();
            $job = $jobs_model->select('count_updated_at')
                ->where('employer_id', $employer->employer_id)
                ->where('job_id', $id_job)->first();
            $count_updated_at = 1;
            if ($job->count_updated_at > 0) {
                $count_updated_at = $count_updated_at + $job->count_updated_at;
            }
            $job_id = $jobs_model->where('employer_id', $employer->employer_id)
                ->where('job_id', $id_job)
                ->update([
                    'updated_at' => new \DateTime(),
                    'count_updated_at' => $count_updated_at
                ]);
            DB::commit();
            return redirect()->back()->with('success', 'Bạn đã đẩy tin lên tốp thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
        } finally {
            return redirect()->back()->with('success', 'Bạn đã đẩy tin lên tốp thành công');
        }

    }

//    tạm dừng tin
    public function update_stop_job(Request $request, $id_job)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $date_yesterday = Carbon::yesterday();
        //lay về ngày hôm qua để update ngày nộp hồ sơ để dừng đăng tin
        $user_id = Auth::user()->id;
        $employees = New Employer();
        $employee = $employees->select('employer_id')->where('user_id', $user_id)->first();
        try {
            DB::beginTransaction();
            $jobs = new Job();
            $status_exam = 0;
            if (!empty($request->input('id_exam'))) {
                $status_exam = 1;
            }
            $employer_model = new Employer();
            $employer = $employer_model->select('employer_id')->where('user_id', $user_id)->first();
            $job_id = $jobs->where('employer_id', $employer->employer_id)
                ->where('job_id', $id_job)
                ->update([
                    'deadline_submit_profile' => $date_yesterday,
                    'updated_at' => new \DateTime(),
                ]);

            DB::commit();
            return redirect()->back()->with('success', 'Bạn đã tạm dừng đăng tin thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
        } finally {
            return redirect()->back()->with('success', 'Bạn đã tạm dừng đăng tin thành công');
        }

    }

//   Xóa tin đăng fb
    public function destroy($job_id)
    {
        $user_id = Auth::user()->id;
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        try {
            $job_model = new Job();
            $job = $job_model->where('job_id', $job_id)->first();
            $employer_model = new Employer();
            $employer = $employer_model->where('employer_id', $job->employer_id)->first();
            if (!empty($employer)) {
                $delete = $job_model->where('job_id', $job_id)->delete();
            }
            return redirect(route('getAllJobs'))->with('success', 'Bạn đã xóa bài viết việc làm thành công !');
        } catch (\Exception $e) {
            return redirect(route('getAllJobs'))->with('erorr', 'Bạn đã xóa bài viết việc làm thất bại !');
        }
    }

    public function list_Job_Candidate_Employee(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$this->checkRoleUser()) {
                return redirect(route('list_cate_job'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể sử dụng chức năng này !');
            }
            $user_id = Auth::user()->id;
            $employer_model = new Employer();
            $employer = $employer_model->select('employer_id')->where('user_id', $user_id)->first();
            $job_model = New Job();

            //danh sach cong viec

            $list = $job_model::select(
                'jobs.job_id',
                'jobs.job_code',
                'jobs.title',
                'jobs.slug',
                'employer_id'
            )
                ->where('employer_id', $employer->employer_id)
                ->where('status_select_job', 0)
                ->orderBy('jobs.job_id', 'desc')
                ->get();

            $list_jobs = $job_model::select(
                'jobs.job_id',
                'jobs.job_code',
                'jobs.id_exam',
                'jobs.title',
                'jobs.slug',
                'jobs.deadline_submit_profile',
                'jobs.salary_id',
                'jobs.date_submit',
                'employee_submit_job_facebook.*',
                'employees.employee_id',
                'employees.profile',
                'employees.employee_name',
                'employees.employee_slug',
                'employees.district',
                'employees.province'
                //'province.province_name'
            )
                ->leftJoin('employee_submit_job_facebook', 'employee_submit_job_facebook.id_job_fb', '=', 'jobs.job_id')
                ->join('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
                //->join('province', 'province.province_id', '=', 'employees.province')
                ->where('employee_submit_job_facebook.status_job', 1)
                ->where('jobs.status_select_job', 0)
                ->where('jobs.employer_id', $employer->employer_id);
            if (!empty($request->input('id_status_submit'))) {
                $id_status_submit = $request->input('id_status_submit');
                $list_jobs = $list_jobs->whereIn('employee_submit_job_facebook.id_status_submit_job', $id_status_submit);
            }
            $list_jobs = $list_jobs->orderBy('jobs.job_id', 'desc');
            $list_jobs = $list_jobs->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc');

            $list_jobs = $list_jobs->paginate(15);


            $job_id = array();
            foreach ($list_jobs as $job) {
                $job_id[] = $job->id_job_fb;
            }
            $total_employee = $list_jobs->count();
            $job = Job::select('job_code', 'title', 'slug')->where('job_id', $job_id)->first();

            return view('site.jobs_site.list_cadidate_job', compact('list', 'list_jobs', 'job_id', 'job', 'total_employee'));


        } catch (\Exception $e) {
            return redirect(route('list_job_face'))->with('error', 'Ứng viên này không tồn tại');
        }
    }

    public function job_Candidate_Employee(Request $request, $id_job)
    {
        $user = Auth::user();
        if (!$this->checkRoleUser()) {
            return redirect(route('list_cate_job'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể sử dụng chức năng này !');
        }
        $user_id = Auth::user()->id;
        $employer_model = new Employer();
        $employer = $employer_model->select('employer_id')->where('user_id', $user_id)->first();
        $job = Job::select('job_code', 'title', 'slug', 'status_select_job')->where('job_id', $id_job)->first();
        if (empty($job)) {
            return redirect(route('list_Job_Candidate_Employee'))->with('error_login', 'Nhà tuyển dụng đã tạm dừng ứng tuyển công việc này');
        }
        $job_model = New Job();
        $list = $job_model::select(
            'jobs.job_id',
            'jobs.job_code',
            'jobs.title',
            'jobs.slug',
            'employer_id')
            ->where('employer_id', $employer->employer_id)
//            ->where('status_select_job', $job->status_select_job)
            ->orderBy('jobs.job_id', 'desc')
            ->get();

        $list_jobs = $job_model::select(
            'jobs.job_id',
            'jobs.job_code',
            'jobs.id_exam',
            'jobs.title',
            'jobs.slug',
            'jobs.deadline_submit_profile',
            'jobs.salary_id',
            'jobs.date_submit',
            'employee_submit_job_facebook.*',
            'employees.employee_id',
            'employees.profile',
            'employees.employee_name',
            'employees.employee_slug',
            'employees.district',
            'employees.province'
//            'province.province_name'
        )
            ->leftJoin('employee_submit_job_facebook', 'employee_submit_job_facebook.id_job_fb', '=', 'jobs.job_id')
            ->join('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
//            ->join('province', 'province.province_id', '=', 'employees.province')
            ->where('jobs.employer_id', $employer->employer_id)
            ->where('employee_submit_job_facebook.status_job', 1)
            ->where('employee_submit_job_facebook.status_show_cv', 1)
//            ->where('jobs.status_select_job', 0)//tin tuyển dụng bt
            ->where('jobs.job_id', $id_job);
        if (!empty($request->input('id_status_submit'))) {
            $id_status_submit = $request->input('id_status_submit');
            $list_jobs = $list_jobs->whereIn('employee_submit_job_facebook.id_status_submit_job', $id_status_submit);
        }
        $list_jobs = $list_jobs->orderBy('jobs.job_id', 'desc');
        $list_jobs = $list_jobs->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc');
        $list_jobs = $list_jobs->get();

        $total_employee = $list_jobs->count();
//        $list_jobs->appends(request()->query());
        $job_id = $id_job;
//        echo '<pre>';
//        print_r($list_jobs);die;

        return view('site.jobs_site.cadidate_job', compact('list', 'list_jobs', 'job_id', 'job', 'total_employee'));
    }


    public function list_Job_Candidate_Employee_vip(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$this->checkRoleUser()) {
                return redirect(route('list_cate_job'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể sử dụng chức năng này !');
            }
            $user_id = Auth::user()->id;
            $employer_model = new Employer();
            $employer = $employer_model->select('employer_id')->where('user_id', $user_id)->first();
            $job_model = New Job();

            //danh sach cong viec

            $list = $job_model::select(
                'jobs.job_id',
                'jobs.job_code',
                'jobs.title',
                'jobs.slug',
                'employer_id'
            )->where('employer_id', $employer->employer_id)
                ->where('status_select_job', 1)
                ->get();

            $list_jobs = $job_model::select(
                'jobs.job_id',
                'jobs.job_code',
                'jobs.id_exam',
                'jobs.title',
                'jobs.slug',
                'jobs.deadline_submit_profile',
                'jobs.salary_id',
                'jobs.date_submit',
                'employee_submit_job_facebook.*',
                'employees.employee_id',
                'employees.profile',
                'employees.employee_name',
                'employees.employee_slug',
                'employees.district',
                'employees.province'
            )
                ->leftJoin('employee_submit_job_facebook', 'employee_submit_job_facebook.id_job_fb', '=', 'jobs.job_id')
                ->join('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
                ->where('employee_submit_job_facebook.status_job', 1)
                ->where('jobs.status_select_job', 1)
                ->where('jobs.employer_id', $employer->employer_id);
            if (!empty($request->input('id_status_submit'))) {
                $id_status_submit = $request->input('id_status_submit');
                $list_jobs = $list_jobs->whereIn('employee_submit_job_facebook.id_status_submit_job', $id_status_submit);
            }
            $list_jobs = $list_jobs->orderBy('jobs.job_id', 'desc');
            $list_jobs = $list_jobs->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc');

            $list_jobs = $list_jobs->paginate(20);


            $job_id = array();
            foreach ($list_jobs as $job) {
                $job_id[] = $job->id_job_fb;
            }
            $total_employee = $list_jobs->count();
            return view('site.jobs_site.list_cadidate_job', compact('list', 'list_jobs', 'job_id', 'job', 'total_employee'));

        } catch (\Exception $e) {
            return redirect(route('list_job_face'))->with('error', 'Ứng viên này không tồn tại');
        }
    }

    public function list_order_job(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$this->checkRoleUser()) {
                return redirect(route('list_cate_job'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể sử dụng chức năng này !');
            }
            $user_id = Auth::user()->id;
            $employer_model = new Employer();
            $employer = $employer_model->select('employer_id')->where('user_id', $user_id)->first();

            $order_job_model = new Order_job();

            $list_order = $order_job_model->select('order_job.order_job_id',
                'order_job.order_job_code',
                'order_job.order_request_id',
                'order_job.order_job_title',
                'order_job.order_job_des',
                'order_job.order_job_price',
                'order_job.order_job_discount',
                'order_job.order_job_statu_pay', //trang thai thanh toan
                'order_job.order_job_status_pay_all', //trang thai thanh toan
                'order_job.order_job_statu_content', // nọi dung thanh toán
                'order_job.order_job_guarantee',  //thoiwg gian bảo hành
                'order_job.order_job_guarantee_date', // ngay kích haotj bao hành
                'order_job.user_id',
                'order_job.employer_id',
                'order_job.job_id',
                'order_job.hunter_regis_id',
                'order_job.file_upload_contract',
                'order_job.created_at',
                'jobs.title',
                'jobs.slug'
            )
                ->join('jobs', 'jobs.job_id', '=', 'order_job.job_id')
                ->where('order_job.employer_id', $employer->employer_id)
                ->get();


            return view('site.jobs_site.list_order_job', compact('list_order'));

        } catch (\Exception $e) {
            return redirect(route('list_job_face'))->with('error', 'Ứng viên này không tồn tại');
        }
    }

    public function detail_order_job($order_id)
    {
//        try {
        $user = Auth::user();
        if (!$this->checkRoleUser()) {
            return redirect(route('list_cate_job'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể sử dụng chức năng này !');
        }
        $user_id = Auth::user()->id;
        $employer_model = new Employer();
        $employer = $employer_model->select('employer_id')->where('user_id', $user_id)->first();

        $order_job_model = new Order_job();
        $order_job = $order_job_model->select('order_job.*',
            'jobs.title',
            'jobs.slug'
        )
            ->join('jobs', 'jobs.job_id', '=', 'order_job.job_id')
            ->where('order_job_id', $order_id)
            ->where('order_job.employer_id', $employer->employer_id)
            ->first();

        return view('site.jobs_site.detail_order_job', compact('order_job'));

//        } catch (\Exception $e) {
//            return redirect(route('list_job_face'))->with('error', 'Ứng viên này không tồn tại');
//        }
    }

    public function list_submit_employee_order(Request $request)
    {
//        try {
        $user = Auth::user();
        if (!$this->checkRoleUser()) {
            return redirect(route('list_cate_job'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể sử dụng chức năng này !');
        }
        $user_id = Auth::user()->id;
        $employer_model = new Employer();
        $employer = $employer_model->select('employer_id')->where('user_id', $user_id)->first();
        $job_model = New Job();

        //danh sach cong viec

        $list = $job_model::select(
            'jobs.job_id',
            'jobs.job_code',
            'jobs.title',
            'jobs.slug',
            'order_job.employer_id'
        )
            ->join('order_job', 'order_job.job_id', '=', 'jobs.job_id')
            ->where('order_job.employer_id', $employer->employer_id)
            ->get();
        $job = $job_model::select(
            'jobs.job_id',
            'jobs.job_code',
            'jobs.title',
            'jobs.slug',
            'order_job.employer_id'
        )
            ->join('order_job', 'order_job.job_id', '=', 'jobs.job_id')
            ->where('order_job.employer_id', $employer->employer_id)
            ->first();
        $job_id = $job->job_id;


//            $job = Job::select('job_code', 'title','slug')->where('job_id',$job_id)->first();
        //mô tả trạng thái theo table staff_status_job_submit
        $employee_submit_status1 = $this->get_list_staff_employee($request, $job_id, 1, $employer->employer_id);
        $employee_submit_status2 = $this->get_list_staff_employee($request, $job_id, 2, $employer->employer_id);
        $employee_submit_status3 = $this->get_list_staff_employee($request, $job_id, 3, $employer->employer_id);
        $employee_submit_status4 = $this->get_list_staff_employee($request, $job_id, 4, $employer->employer_id);
//        echo '<pre>';
//        print_r($employee_submit_status1);die;

        return view('site.jobs_site.list_submit_employee_order', compact('list', 'employee_submit_status1', 'employee_submit_status2', 'employee_submit_status3', 'employee_submit_status4', 'job_id'));


//        } catch (\Exception $e) {
//            return redirect(route('list_job_face'))->with('error', 'Ứng viên này không tồn tại');
//        }
    }

    public function job_Candidate_Employee_order(Request $request, $job_id)
    {
//        try {
        $user = Auth::user();
        if (!$this->checkRoleUser()) {
            return redirect(route('list_cate_job'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể sử dụng chức năng này !');
        }
        $user_id = Auth::user()->id;
        $employer_model = new Employer();
        $employer = $employer_model->select('employer_id')->where('user_id', $user_id)->first();
        $job_model = New Job();

        //danh sach cong viec

        $list = $job_model::select(
            'jobs.job_id',
            'jobs.job_code',
            'jobs.title',
            'jobs.slug',
            'order_job.employer_id'
        )
            ->join('order_job', 'order_job.job_id', '=', 'jobs.job_id')
            ->where('order_job.employer_id', $employer->employer_id)
            ->get();
//            $job = Job::select('job_code', 'title','slug')->where('job_id',$job_id)->first();
        //mô tả trạng thái theo table staff_status_job_submit
        $employee_submit_status1 = $this->get_list_staff_employee($request, $job_id, 1, $employer->employer_id);
        $employee_submit_status2 = $this->get_list_staff_employee($request, $job_id, 2, $employer->employer_id);
        $employee_submit_status3 = $this->get_list_staff_employee($request, $job_id, 3, $employer->employer_id);
        $employee_submit_status4 = $this->get_list_staff_employee($request, $job_id, 4, $employer->employer_id);
//        echo '<pre>';
//        print_r($employee_submit_status1);die;

        return view('site.jobs_site.list_submit_employee_order', compact('list', 'employee_submit_status1', 'employee_submit_status2', 'employee_submit_status3', 'employee_submit_status4', 'job_id'));

//        } catch (\Exception $e) {
//            return redirect(route('list_job_face'))->with('error', 'Ứng viên này không tồn tại');
//        }
    }

    public function get_list_staff_employee($request, $id_job_fb, $staff_job_id, $employer_id)
    {
        $job_model = New Job();
        $list_jobs = $job_model::select(
            'jobs.job_id',
            'jobs.job_code',
            'jobs.id_exam',
            'jobs.title',
            'jobs.slug',
            'jobs.deadline_submit_profile',
            'jobs.salary_id',
            'jobs.date_submit',
            'employee_submit_job_facebook.*',
            'employees.employee_id',
            'employees.profile',
            'employees.employee_name',
            'employees.employee_slug',
            'employees.district',
            'employees.province',
            'order_job.employer_id',
            'staff_status_job_submit_employee.staff_job_id',
            'employee_submit_job_facebook.submit_job_fb_id'
        )
            ->leftJoin('employee_submit_job_facebook', 'employee_submit_job_facebook.id_job_fb', '=', 'jobs.job_id')
            ->join('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
            ->join('staff_status_job_submit_employee', 'staff_status_job_submit_employee.submit_job_fb_id', 'employee_submit_job_facebook.submit_job_fb_id')
            ->join('order_job', 'order_job.job_id', '=', 'jobs.job_id')
            ->where('employee_submit_job_facebook.status_job', 1)
            ->where('employee_submit_job_facebook.id_job_fb', $id_job_fb)
            ->where('staff_status_job_submit_employee.staff_job_id', $staff_job_id)
            ->where('order_job.employer_id', $employer_id);
        if (!empty($request->input('id_status_submit'))) {
            $id_status_submit = $request->input('id_status_submit');
            $list_jobs = $list_jobs->whereIn('employee_submit_job_facebook.id_status_submit_job', $id_status_submit);
        }
        $list_jobs = $list_jobs->orderBy('jobs.job_id', 'desc');
        $list_jobs = $list_jobs->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc');
        $list_jobs = $list_jobs->get();
        return $list_jobs;
    }

    public function update_id_status_job(Request $request)
    {
        if ($request->has('submit_job_fb_id') && Auth::check() && Auth::user()->role == 2) {
            $submit_job_face = $request->input('submit_job_fb_id');
            foreach ($submit_job_face as $id_submit => $id_status_submit_job) {
                $employee_submit = new Employee_submit_job_faacebook();
                //cập nhật trạng thái của hồ sơ đã nộp
                $update = $employee_submit->where('submit_job_fb_id', $id_submit)->update([
                    'id_status_submit_job' => $id_status_submit_job,
                ]);
                //xem hồ sơ thì thông báo cho ứng viên

                if ($id_status_submit_job == 1) {
                    $job_submit = $employee_submit->where('submit_job_fb_id', $id_submit)
                        ->where('status_job', 1)
                        ->first();
                    $employee_email = Employee::where('employee_id', $job_submit->employee_id)->value('email');
                    $mail = MailConfigController::send_email_view_profile_employee($job_submit->id_job_fb, $employee_email);
                }
                //nếu là hủy hồ sơ
                if ($id_status_submit_job == 4) {
                    $submit_job_face = $employee_submit->select('*')
                        ->where('submit_job_fb_id', $id_submit)
                        ->first();
                    $emloyee_model = new Employee();
                    $employee = $emloyee_model->select('employee_id', 'email', 'user_id')->where('employee_id', $submit_job_face->employee_id)->first();
                    $job = Job::select('slug', 'title', 'job_id', 'employer_id')->where('job_id', $submit_job_face['id_job_fb'])->first();

                    //job là nội dung công việc cần title ,slug
                    //$email là email gửi thu
                    MailConfigController::send_delete_file($job, $employee['email']);

                    //gửi thông báo info den ứng viên
                    $noti_model = new NotificationWindow();
                    $link_noti = route('list_Jobs_Submit_Employee');
                    $noti_insert_id = $noti_model->insertGetId([
                        'title_noti' => 'Sanketoan.vn thông báo',
                        'user_id' => $employee['user_id'],
                        'employee_id' => $employee['employee_id'],
                        'des_noti' => 'Nhà tuyển dụng đã loại hồ sơ của bạn khỏi tin tuyển dụng',
                        'link_noti' => $link_noti,
                        'created_at' => new \DateTime()
                    ]);
                    //thông báo cho ứng viên
                    $desc_title = 'Nhà tuyển dụng đã loại hồ sơ của bạn khỏi tin tuyển dụng' . ' " ' . $job->title . ' "';
                    $noti_id = Notification_employer::insertGetId([
                        'title_noti' => 'Sanketoan.vn thông báo', //tiêu đề thông báo
                        'user_id' => $employee->user_id, //	0 là thông báo chung
                        'des_noti' => $desc_title, //Nội dung thông báo
                        'link_noti' => '', //Link thông báo trên window
                        'type_noti' => 'employee', //kiểu thông báo  /notification_employer  //employer thông báo của nhà tuyển dụng //employees thong bao ung vien thông báo dựa theo table job //jobs là thông báo về công việc
                        'noti_status' => 0,//trạng thái thông báo 0 là chưa xem 1 đã xem
                        'status_noti' => 0, //trạng thái thông báo 1 là đã xem 2 là đã xóa => tạm thời bỏ
                        'view_noti' => 0, //Đã hiển thị thông báo ở cửa sơ window
                        'job_id' => $job->job_id,
                        'created_at' => new \DateTime()
                    ]);
                    //push noti cho app
                    $title = 'Sàn kế toán thông báo';
                    $type = 'employee';
                    $note = 'Nhà tuyển dụng đã loại hồ sơ của bạn khỏi tin tuyển dụng';
                    $value = $noti_id;
                    $to = $employee->user_id;
                    $push_noti_app = new NotificationMobileController();
                    $send_push = $push_noti_app->pushNotification($title, $desc_title, $to, $type, $note, $value);
                }
            }
            return redirect()->back()->with('success', 'Lưu trạng thái thành công');
        } else {
            return redirect()->back()->with('erorr', 'Lưu trạng thái thất bại');
        }

    }

    public function update_id_status_intership(Request $request)
    {
        if ($request->has('id_status') && Auth::check() && Auth::user()->role == 2) {
            $id_status = $request->input('id_status');

//            print_r($id_status);die();
            foreach ($id_status as $id => $status) {
                $intership_update = EmployerIntership::where('intership_id', $id)->update([
                    'id_status' => $status,
                    'updated_at' => new \DateTime()
                ]);

                //nếu là hủy hồ sơ
                if ($status == 4) {
                    $intership = EmployerIntership::select('*')->where('intership_id', $id)->first();

                    $emloyee_model = new Employee();
                    $employee = $emloyee_model->select('employee_id', 'email', 'user_id')->where('employee_id', $intership->employee_id)->first();

                    $employer = Employer::select('employer_id', 'enterprise_name', 'slug')->where('employer_id', $intership->employer_id)->first();

                    //job là nội dung công việc cần title ,slug
                    //$email là email gửi thu
                    MailConfigController::send_delete_file_intership($employer, $employee['email']);

                    //gửi thông báo info den ứng viên
                    $noti_model = new NotificationWindow();
                    $link_noti = route('list_Jobs_Submit_Employee');
                    $noti_insert_id = $noti_model->insertGetId([
                        'title_noti' => 'Sanketoan.vn thông báo',
                        'user_id' => $employee['user_id'],
                        'employee_id' => $employee['employee_id'],
                        'des_noti' => 'Nhà tuyển dụng đã loại hồ sơ của bạn khỏi tin tuyển dụng thực tập kế toán',
                        'link_noti' => $link_noti,
                        'created_at' => new \DateTime()
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Lưu trạng thái thành công');
        } else {
            return redirect()->back()->with('erorr', 'Lưu trạng thái thất bại');
        }

    }

    public function ajax_update_id_status_intership(Request $request)
    {
        if ($request->has('status') && Auth::check() && Auth::user()->role == 2) {
            $id_status = $request->input('status');
            $id = $request->input('submit_job_fb_id');

//            print_r($id_status);die();
            $intership_update = EmployerIntership::where('intership_id', $id)->update([
                'id_status' => $id_status,
                'updated_at' => new \DateTime()
            ]);
            //nếu là hủy hồ sơ
            if ($id_status == 4) {
                $intership = EmployerIntership::select('*')->where('intership_id', $id)->first();

                $emloyee_model = new Employee();
                $employee = $emloyee_model->select('employee_id', 'email', 'user_id')->where('employee_id', $intership->employee_id)->first();

                $employer = Employer::select('employer_id', 'enterprise_name', 'slug')->where('employer_id', $intership->employer_id)->first();

                //job là nội dung công việc cần title ,slug
                //$email là email gửi thu
                MailConfigController::send_delete_file_intership($employer, $employee['email']);

                //gửi thông báo info den ứng viên
                $noti_model = new NotificationWindow();
                $link_noti = route('list_Jobs_Submit_Employee');
                $noti_insert_id = $noti_model->insertGetId([
                    'title_noti' => 'Sanketoan.vn thông báo',
                    'user_id' => $employee['user_id'],
                    'employee_id' => $employee['employee_id'],
                    'des_noti' => 'Nhà tuyển dụng đã loại hồ sơ của bạn khỏi tin tuyển dụng thực tập kế toán',
                    'link_noti' => $link_noti,
                    'created_at' => new \DateTime()
                ]);
            }

            return response()->json([
                'status' => 200,

            ]);
        } else {
            return response()->json([
                'status' => 400,
            ]);
        }

    }

    public function ajax_status_submit_job(Request $request)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_cate_job'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể sử dụng chức năng này !');
        }
        $status = $_GET['status'];
        $submit_job_fb_id = $_GET['submit_job_fb_id'];

        $user_id = Auth::user()->id;
        $role = Auth::user()->role;
        $employer_id = Employer::where('user_id', $user_id)->value('employer_id');

        // note_status_profile($status,$submit_job_fb_id,$employer_id)
        //thong bao đến ứng viên
        $this->note_status_profile($status, $submit_job_fb_id, $employer_id);
        if (empty($employer_id)) {
            return response()->json([
                'status' => 400,
            ]);
        }
//        quyen ung vien
        if ($role == 2) {
            $employee_submit_job_model = new Employee_submit_job_faacebook();
            $employee_submit_job = $employee_submit_job_model->select('employee_submit_job_facebook.*', 'employees.employee_id', 'employees.user_id')
                ->join('employees', 'employees.employee_id', '=', 'employee_submit_job_facebook.employee_id')
                ->join('jobs', 'jobs.job_id', '=', 'employee_submit_job_facebook.id_job_fb')
                ->where('employee_submit_job_facebook.submit_job_fb_id', $submit_job_fb_id)
                ->where('jobs.employer_id', $employer_id)
                ->first();
            if (!empty($employee_submit_job)) {
                $update = $employee_submit_job_model->where('employee_submit_job_facebook.submit_job_fb_id', $employee_submit_job['submit_job_fb_id'])
                    ->update([
                        'id_status_submit_job' => $status
                    ]);
                if ($status == 4) {
                    $job = Job::select('slug', 'title', 'job_id', 'employer_id')->where('job_id', $employee_submit_job['id_job_fb'])->first();
                    $employee = Employee::select('employee_id', 'email')->where('employee_id', $employee_submit_job->employee_id)->first();
                    //job là nội dung công việc cần title ,slug
                    //$email là email gửi thu
                    MailConfigController::send_delete_file($job, $employee['email']);

//                $this->send_submit_job_email(1,$job,$emplo,$emplo->email);
//                gủi email thông báo cho ntd
//                    MailConfigController::send_submit_job_email(2,$job,$emplo,$employer->email);
//                $this->send_submit_job_email(2,$job,$emplo,$employer->email);

                    //gửi thông báo info den ứng viên
                    $noti_model = new NotificationWindow();
                    $link_noti = route('list_Jobs_Submit_Employee');
                    $noti_insert_id = $noti_model->insertGetId([
                        'title_noti' => 'Sanketoan.vn thông báo',
                        'user_id' => $employee_submit_job['user_id'],
                        'employee_id' => $employee_submit_job['employee_id'],
                        'des_noti' => 'Nhà tuyển dụng đã loại hồ sơ của bạn khỏi tin tuyển dụng',
                        'link_noti' => $link_noti,
                        'created_at' => new \DateTime()
                    ]);
                }
                return response()->json([
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                ]);
            }

        } else {
            return response()->json([
                'status' => 400,
            ]);
        }

    }

//    thong bao xem ho so va loai ho so $status = 1 đã xem , $status = 4 loai ho so
    public function note_status_profile($status, $submit_job_fb_id, $employer_id)
    {
        $employee_submit_job_model = new Employee_submit_job_faacebook();
        $employee_submit_job = $employee_submit_job_model->select('employee_submit_job_facebook.*', 'employees.employee_id', 'employees.user_id')
            ->join('employees', 'employees.employee_id', '=', 'employee_submit_job_facebook.employee_id')
            ->join('jobs', 'jobs.job_id', '=', 'employee_submit_job_facebook.id_job_fb')
            ->where('employee_submit_job_facebook.submit_job_fb_id', $submit_job_fb_id)
            ->where('jobs.employer_id', $employer_id)
            ->first();
        $title_job = Job::where('job_id', $employee_submit_job->id_job_fb)->value('title');
        $user_id = Employee::where('employee_id', $employee_submit_job->employee_id)->value('user_id');
        $des_noti = '';
        if ($status == 1) //gửi thông báo info den ứng viên
        {
            $des_noti = 'Nhà tuyển dụng đã xem hồ sơ của bạn';

        }
        if ($status == 4) //gửi thông báo info den ứng viên
        {
            $des_noti = 'Nhà tuyển dụng đã loại hồ sơ của bạn khỏi tin tuyển dụng' . ' " ' . $title_job . ' "';

        }
        $noti_model = new Notification_employer();
        $link_noti = '';
        $noti_insert = $noti_model->insert([
            'title_noti' => 'Sanketoan.vn thông báo',
            'user_id' => $user_id,
            'employee_id' => $employee_submit_job->employee_id,
            'job_id' => $employee_submit_job->id_job_fb,
            'des_noti' => $des_noti,
            'link_noti' => $link_noti,
            'type_noti' => 'jobs',
            'created_at' => new \DateTime()
        ]);
//                    gui api thong bao tren mobile
        $api_push_noti = new NotificationMobileController();
        $title = 'Sàn kế toán thông báo';
        $body = $des_noti;
        $type = 'jobs';
        $note = $des_noti;
        $value = $employee_submit_job->employee_id;
        $to = $user_id;
        $send_noti = $api_push_noti->pushNotification($title, $body, $to, $type, $note, $value);
    }

//    xu li ajax luu viec lam
    public function saveJob(Request $request)
    {
        $id_job_fb = $_GET['id_job'];
        $status_job = $_GET['status_job'];
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;
//        quyen ung vien
        if ($role == 1) {
            $save_job_fb = new Employees_save_job_facebook();
            $employee = new Employee();
            $emplo = $employee->select('employee_id', 'user_id')->where('user_id', $user_id)->first();
            $count_save = $save_job_fb->where('id_job_fb', $id_job_fb)
                ->where('employee_id', $emplo->employee_id)
                ->where('status_job', $status_job)
                ->count();
            if ($count_save < 1) {
                $insert_id = $save_job_fb->insertGetId([
                    'id_job_fb' => $id_job_fb,
                    'employee_id' => $emplo->employee_id,
                    'status_job' => $status_job,
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ]);
                return response()->json([
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                ]);
            }
        } elseif ($role == 3) {
            $save_job_fb = new Teacher_save_job_facebook();
            $teacher = new Teacher();
            $tea = $teacher->select('teacher_id', 'user_id')->where('user_id', $user_id)->first();

            $count_save = $save_job_fb->where('id_job_fb', $id_job_fb)
                ->where('teacher_id', $tea->teacher_id)
                ->where('status_job', $status_job)
                ->count();
            if ($count_save < 1) {
                $insert_id = $save_job_fb->insertGetId([
                    'id_job_fb' => $id_job_fb,
                    'teacher_id' => $tea->teacher_id,
                    'status_job' => $status_job,
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ]);
                return response()->json([
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                ]);
            }
        }

    }

    public function deletesaveJob(Request $request)
    {
        $id_job_fb = $_GET['id_job'];
        $status_job = $_GET['status_job'];
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;

//        quyen ung vien
        if ($role == 1) {
            $save_job_fb = new Employees_save_job_facebook();
            $employee = new Employee();
            $emplo = $employee->select('employee_id', 'user_id')->where('user_id', $user_id)->first();
            $count_save = $save_job_fb->where('id_job_fb', $id_job_fb)
                ->where('employee_id', $emplo->employee_id)
                ->where('status_job', $status_job)
                ->count();
            if ($count_save > 0) {
                $delete = $save_job_fb->where('id_job_fb', $id_job_fb)
                    ->where('employee_id', $emplo->employee_id)
                    ->where('status_job', $status_job)
                    ->delete();
                return response()->json([
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                ]);
            }
        } elseif ($role == 3) {
            $save_job_fb = new Teacher_save_job_facebook();
            $teacher = new Teacher();
            $tea = $teacher->select('teacher_id', 'user_id')->where('user_id', $user_id)->first();

            $count_save = $save_job_fb->where('id_job_fb', $id_job_fb)
                ->where('teacher_id', $tea->teacher_id)
                ->where('status_job', $status_job)
                ->count();
            if ($count_save > 0) {

                $delete = $save_job_fb->where('id_job_fb', $id_job_fb)
                    ->where('teacher_id', $tea->teacher_id)
                    ->where('status_job', $status_job)
                    ->delete();
                return response()->json([
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                ]);
            }
        }

    }

//    xu li  ajax nộp hồ sơ


    //lay theo danh mục việc làm  - việc làm yêu thích
    public function jobs_Like_Employee(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;


        $emplo = new Employee();
        $emplo = $emplo->select('career_category_id', 'user_id')->where('user_id', $user_id)->first();

        $teacher = new Teacher();
        $tea = $teacher->select('career_category_id', 'user_id')->where('user_id', $user_id)->first();


        $jobModel = new Job();
        $jobs = $jobModel
            ->join('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug',
                'salary.description as salary_description', 'jobs.deadline_submit_profile'
            );
        if ($role == 1) {
            $jobs = $jobs->where('jobs.career_category_id', $emplo->career_category_id);

        } elseif ($role == 3) {
            $jobs = $jobs->where('jobs.career_category_id', $tea->career_category_id);
        }
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        //tong so bai viet
        $total_jobs = $jobs->count();
        $jobs = $jobs->paginate(20);
//        luu url khi phan trang


        return view('site.jobs.list_like_job', compact('jobs', 'user', 'total_jobs'));

    }

//    việc làm đã lưu từ facebook
    public function list_Jobs_Save_Employee(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;
        $jobs = 0;
        $total_jobs = 0;
        $jobFacebooks = 0;
        $totalfacebook = 0;

        if (Auth::check() && $role == 1) {
//            $status_job = 0 ;là JobFaceBook
//            $status_job = 1 ;là Job
            $jobs = $this->EmpoloyeeSaveJobs($user_id, 1, 0);
            $total_jobs = $this->EmpoloyeeSaveJobs($user_id, 1, 1);
            $jobFacebooks = $this->EmpoloyeeSaveJobFacebooks($user_id, 0, 0);;
            $totalfacebook = $this->EmpoloyeeSaveJobFacebooks($user_id, 0, 1);
        } elseif (Auth::check() && $role == 3) {
            $jobs = $this->TeacherSaveJobs($user_id, 1, 0);
            $total_jobs = $this->TeacherSaveJobs($user_id, 1, 1);
            $jobFacebooks = $this->TeacherSaveJobFacebooks($user_id, 0, 0);;
            $totalfacebook = $this->TeacherSaveJobFacebooks($user_id, 0, 1);
        }
        return view('site.jobs.list_save_job', compact('jobs', 'user', 'total_jobs', 'jobFacebooks', 'totalfacebook'));

    }

//    Luu hồ sơ ứng viên
    public function EmpoloyeeSaveJobFacebooks($user_id, $status_job, $count)
    {
        $emplo = new Employee();
        $emplo = $emplo->select('career_category_id', 'user_id', 'employee_id')->where('user_id', $user_id)->first();
        $jobfaceModule = new JobFacebook();
        $jobFacebooks = $jobfaceModule->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
        $jobFacebooks = $jobFacebooks->leftJoin('employees_save_job_facebook', 'employees_save_job_facebook.id_job_fb', 'job_facebook.job_facebook_id');
        $jobFacebooks = $jobFacebooks->select('job_facebook.*',
            'employees_save_job_facebook.employee_id',
            'employees_save_job_facebook.id_job_fb',
            'salary.description as salary_description'
        );
        $jobFacebooks = $jobFacebooks->where('employees_save_job_facebook.employee_id', $emplo->employee_id);
        $jobFacebooks = $jobFacebooks->where('employees_save_job_facebook.status_job', $status_job);
        $totalfacebook = $jobFacebooks->count();
        $jobFacebooks = $jobFacebooks->get();
        if ($count == 0) {
            return $jobFacebooks;
        } else {
            return $totalfacebook;
        }

    }

    public function EmpoloyeeSaveJobs($user_id, $status_job, $count)
    {
        $emplo = new Employee();
        $emplo = $emplo->select('career_category_id', 'user_id', 'employee_id')->where('user_id', $user_id)->first();
        $jobModel = new Job();
        $jobs = $jobModel->select(
            'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.province', 'jobs.district',
            'salary.description as salary_description', 'jobs.deadline_submit_profile'
        )->join('salary', 'salary.salary_id', 'jobs.salary_id');
        $jobs = $jobs->leftJoin('employees_save_job_facebook', 'employees_save_job_facebook.id_job_fb', 'jobs.job_id');
        $jobs = $jobs->where('employees_save_job_facebook.employee_id', $emplo->employee_id);
        $jobs = $jobs->where('employees_save_job_facebook.status_job', $status_job);
        $jobs = $jobs->where('jobs.active_job', 1);
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        //tong so bai viet
        $total_jobs = $jobs->count();
        $jobs = $jobs->get();
        if ($count == 0) {
            return $jobs;
        } else {
            return $total_jobs;
        }
    }
//    End Luu hồ sơ ứng viên
//    Luu hồ sơ Giáo viên
    public function TeacherSaveJobFacebooks($user_id, $status_job, $count)
    {
        $teacher = new Teacher();
        $tea = $teacher->select('career_category_id', 'user_id', 'teacher_id')->where('user_id', $user_id)->first();
        $jobfaceModule = new JobFacebook();
        $jobFacebooks = $jobfaceModule->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
        $jobFacebooks = $jobFacebooks->leftJoin('teacher_save_job_facebook', 'teacher_save_job_facebook.id_job_fb', 'job_facebook.job_facebook_id');
        $jobFacebooks = $jobFacebooks->select('job_facebook.*',
            'teacher_save_job_facebook.teacher_id',
            'teacher_save_job_facebook.id_job_fb',
            'salary.description as salary_description'
        );
        $jobFacebooks = $jobFacebooks->where('teacher_save_job_facebook.teacher_id', $tea->teacher_id);
        $jobFacebooks = $jobFacebooks->where('teacher_save_job_facebook.status_job', $status_job);
        $totalfacebook = $jobFacebooks->count();
        $jobFacebooks = $jobFacebooks->get();
        if ($count == 0) {
            return $jobFacebooks;
        } else {
            return $totalfacebook;
        }
    }

    public function TeacherSaveJobs($user_id, $status_job, $count)
    {
        $teacher = new Teacher();
        $tea = $teacher->select('career_category_id', 'user_id', 'teacher_id')->where('user_id', $user_id)->first();
        $jobModel = new Job();
        $jobs = $jobModel->select(
            'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug',
            'salary.description as salary_description', 'jobs.deadline_submit_profile'
        )->join('salary', 'salary.salary_id', 'jobs.salary_id');
        $jobs = $jobs->leftJoin('teacher_save_job_facebook', 'teacher_save_job_facebook.id_job_fb', 'jobs.job_id');
        $jobs = $jobs->where('teacher_save_job_facebook.teacher_id', $tea->teacher_id);
        $jobs = $jobs->where('teacher_save_job_facebook.status_job', $status_job);
        $jobs = $jobs->where('jobs.active_job', 1);
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        //tong so bai viet
        $total_jobs = $jobs->count();
        $jobs = $jobs->get();
        if ($count == 0) {
            return $jobs;
        } else {
            return $total_jobs;
        }
    }
//    End Luu hồ sơ Giáo viên


    //    việc làm đã nộp hồ sơ từ facebook
    public function list_Jobs_Submit_Employee(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;
        $jobs = 0;
        $total_jobs = 0;
        $jobFacebooks = 0;
        $totalfacebook = 0;

        $employee = Employee::select('*')->where('user_id', $user_id)->first();
        if ($role == 1) {

            //công việc thực tập
            $intership_model = new EmployerIntership();
            $list_intership = $intership_model->select('employer_intership.*', 'employer.employer_id', 'employer.enterprise_name', 'employer.phone', 'employer.slug', 'employer.district', 'employer.province',
                'status_submit_job.id_status', 'status_submit_job.name_status')
                ->leftJoin('employer', 'employer.employer_id', '=', 'employer_intership.employer_id')
                ->leftJoin('status_submit_job', 'status_submit_job.id_status', '=', 'employer_intership.id_status')
                ->where('employer_intership.employee_id', $employee->employee_id)
                ->get();


            //công viêc đã kiểm duyệt
            $jobs = $this->EmployeeSubmitJob($user_id, 1, 0);
            $jobFacebooks = $this->EmployeeSubmitJobFacebook($user_id, 0, 0);
//            print_r($jobs);die();

//            echo '<pre>';
//            print_r($jobs);
//            echo '</pre>';
//            echo '<pre>';
//            print_r($jobFacebooks);
//            echo '</pre>';
//            die();
        }
        if ($role == 3) {
            $jobs = $this->TeacherSubmitJob($user_id, 1, 0);

            $jobFacebooks = $this->TeacherSubmitJobFacebook($user_id, 0, 0);

        }
        return view('site.jobs.list_submit_job', compact('jobs', 'user', 'jobFacebooks', 'list_intership'));
    }

    public function list_employee_follow_employer(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;

        if (Auth::check() && $role == 1) {
//            $status_job = 0 ;là JobFaceBook
//            $status_job = 1 ;là Job
            $emplo = new Employee();
            $emplo = $emplo->select('career_category_id', 'user_id', 'employee_id')->where('user_id', $user_id)->first();

            $employee_follow_employer = Employee_follow_employer::select('*')->where('employee_id', $emplo->employee_id)->get();

            $employer_id = array();
            foreach ($employee_follow_employer as $follow) {
                $employer_id[] = $follow->employer_id;
            }
            $list_follow_employer = Employer::select('employer_id',
                'employer_code',
                'enterprise_name',
                'phone',
                'email',
                'address',
                'province',
                'district',
                'slug'
            )->whereIn('employer_id', $employer_id)->get();
            $jobModel = new Job();
            $jobs = $jobModel->select(
                'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.employer_id', 'jobs.slug', 'jobs.province', 'jobs.district',
                'salary.description as salary_description', 'jobs.deadline_submit_profile'
            )->join('salary', 'salary.salary_id', 'jobs.salary_id');
            $jobs = $jobs->whereIn('jobs.employer_id', $employer_id);
            $jobs = $jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
            $jobs = $jobs->where('jobs.active_job', 1);
            $jobs = $jobs->get();
//            echo '<pre>';
//            print_r($list_follow_employer);
//            echo '</pre>';
        }
        return view('site.jobs.list_job_follow', compact('jobs', 'list_follow_employer'));
    }

    public function list_employee_follow_employer_id(Request $request, $id_employer)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;

        if (Auth::check() && $role == 1) {
//            $status_job = 0 ;là JobFaceBook
//            $status_job = 1 ;là Job
            $emplo = new Employee();
            $emplo = $emplo->select('career_category_id', 'user_id', 'employee_id')->where('user_id', $user_id)->first();

            $employee_follow_employer = Employee_follow_employer::select('*')->where('employee_id', $emplo->employee_id)->get();

            $employer_id = array();
            foreach ($employee_follow_employer as $follow) {
                $employer_id[] = $follow->employer_id;
            }
            $list_follow_employer = Employer::select('employer_id',
                'employer_code',
                'enterprise_name',
                'phone',
                'email',
                'address',
                'province',
                'district',
                'slug'
            )->whereIn('employer_id', $employer_id)->get();
            $jobModel = new Job();
            $jobs = $jobModel->select(
                'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.employer_id', 'jobs.slug', 'jobs.province', 'jobs.district',
                'salary.description as salary_description', 'jobs.deadline_submit_profile'
            )->join('salary', 'salary.salary_id', 'jobs.salary_id');
            $jobs = $jobs->where('jobs.employer_id', $id_employer);
            $jobs = $jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
            $jobs = $jobs->where('jobs.active_job', 1);
            $jobs = $jobs->get();
//            echo '<pre>';
//            print_r($list_follow_employer);
//            echo '</pre>';
        }
        return view('site.jobs.list_job_follow', compact('jobs', 'list_follow_employer', 'id_employer'));
    }

//    Nộp hồ sơ ứng viên
    public function EmployeeSubmitJob($user_id, $status_job, $count)
    {
        $jobs = new Job();
        $emplo = new Employee();
        $emplo = $emplo->select('career_category_id', 'user_id', 'employee_id')->where('user_id', $user_id)->first();
        $jobs = $jobs->leftJoin('employee_submit_job_facebook', 'employee_submit_job_facebook.id_job_fb', 'jobs.job_id')->join('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->leftJoin('status_submit_job', 'status_submit_job.id_status', '=', 'employee_submit_job_facebook.id_status_submit_job')
            ->join('salary', 'salary.salary_id', 'jobs.salary_id');

        $jobs = $jobs->select(
            'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug as job_slug',
            'salary.description as salary_description', 'jobs.deadline_submit_profile', 'employer.employer_id', 'employer.enterprise_name', 'employer.slug', 'employee_submit_job_facebook.*', 'status_submit_job.id_status', 'status_submit_job.name_status'
        );

        $jobs = $jobs->where('employee_submit_job_facebook.employee_id', $emplo->employee_id);
        $jobs = $jobs->where('employee_submit_job_facebook.status_job', $status_job);
        $jobs = $jobs->where('jobs.active_job', 1);
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $total_jobs = $jobs->count();
        $jobs = $jobs->get();
        if ($count == 0) {
            return $jobs;
        } else {
            return $total_jobs;
        }
    }

    public function EmployeeSubmitJobFacebook($user_id, $status_job, $count)
    {
        $jobs = new JobFacebook();
        $emplo = new Employee();
        $emplo = $emplo->select('career_category_id', 'user_id', 'employee_id')->where('user_id', $user_id)->first();
        $jobFacebooks = $jobs->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
        $jobFacebooks = $jobFacebooks->leftJoin('employee_submit_job_facebook', 'employee_submit_job_facebook.id_job_fb', 'job_facebook.job_facebook_id');
        $jobFacebooks = $jobFacebooks->select('job_facebook.*',
            'employee_submit_job_facebook.employee_id',
            'employee_submit_job_facebook.id_job_fb',
            'salary.description as salary_description'
        );
        $jobFacebooks = $jobFacebooks->where('employee_submit_job_facebook.employee_id', $emplo->employee_id);
        $jobFacebooks = $jobFacebooks->where('employee_submit_job_facebook.status_job', $status_job);
        $jobFacebooks = $jobFacebooks->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
        $total = $jobFacebooks->count();
        $jobFacebooks = $jobFacebooks->get();
        if ($count == 0) {
            return $jobFacebooks;
        } else {
            return $total;
        }
    }
//    End Nộp hồ sơ ứng viên
//    Nộp hồ sơ giáo viên
    public function TeacherSubmitJob($user_id, $status_job, $count)
    {
        $jobs = new Job();
        $teacher = new Teacher();
        $tea = $teacher->select('career_category_id', 'user_id', 'teacher_id')->where('user_id', $user_id)->first();
        $jobs = $jobs->leftJoin('teacher_submit_job_facebook', 'teacher_submit_job_facebook.id_job_fb', 'jobs.job_id');
        $jobs = $jobs->select(
            'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug',
            'salary.description as salary_description', 'jobs.deadline_submit_profile'
        )->join('salary', 'salary.salary_id', 'jobs.salary_id');

        $jobs = $jobs->where('teacher_submit_job_facebook.teacher_id', $tea->teacher_id);
        $jobs = $jobs->where('teacher_submit_job_facebook.status_job', $status_job);
        $jobs = $jobs->where('jobs.active_job', 1);
        $total_jobs = $jobs->count();
        $jobs = $jobs->get();
        if ($count == 0) {
            return $jobs;
        } else {
            return $total_jobs;
        }
    }

//    End Nộp hồ sơ giáo viên
    public function TeacherSubmitJobFacebook($user_id, $status_job, $count)
    {
        $jobfaceModule = new JobFacebook();
        $teacher = new Teacher();
        $tea = $teacher->select('career_category_id', 'user_id', 'teacher_id')->where('user_id', $user_id)->first();
        $jobFacebooks = $jobfaceModule->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
        $jobFacebooks = $jobFacebooks->leftJoin('teacher_submit_job_facebook', 'teacher_submit_job_facebook.id_job_fb', 'job_facebook.job_facebook_id');

        $jobFacebooks = $jobFacebooks->select('job_facebook.*',
            'teacher_submit_job_facebook.teacher_id',
            'teacher_submit_job_facebook.id_job_fb',
            'salary.description as salary_description'
        );
        $jobFacebooks = $jobFacebooks->where('teacher_submit_job_facebook.teacher_id', $tea->teacher_id);
        $jobFacebooks = $jobFacebooks->where('teacher_submit_job_facebook.status_job', $status_job);
        $jobFacebooks = $jobFacebooks->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
        $total = $jobFacebooks->count();
        $jobFacebooks = $jobFacebooks->get();
        if ($count == 0) {
            return $jobFacebooks;
        } else {
            return $total;
        }
    }

    //lịch sử giao dịch
    public function list_transaction_coin_employer()
    {
        try {
            $user_id = Auth::user()->id;
//        return view('site.jobs.list_jobs', compact('jobs', 'total_job', 'user'));
            $check_employer = $this->check_employer_role();;
            $employer = Employer::select('employer_id',
                'enterprise_name',
                'phone',
                'email',
                'user_id',
                'employer_coin',
                'total_employer_coin',
                'total_money_coin')->where('user_id', $user_id)->first();
            $list_transaction_coins = Coin_history_money_employer::select('*')
                ->where('employer_id', $employer->employer_id)
                ->orderBy('coin_money_id', 'desc')
                ->paginate(10);


            //lịch sử dùng điểm xem thông tin ứng viên
            $sum_coin_info = 0;
            $sum_coin_info = Coin_history_employer::select('*')
                ->where('employer_id', $employer->employer_id)
                ->where('coin_history_status', 1)
                ->where('coin_employee_status', 0)
                ->sum('coin');
            //lịch sử dùng điểm mời ứng viên
            $sum_coin_send = 0;
            $sum_coin_send = Coin_history_employer::select('*')
                ->where('employer_id', $employer->employer_id)
                ->where('coin_history_status', 1)
                ->where('coin_employee_status', 1)
                ->sum('coin');

            return view('site.employer.list_transaction_coin', compact('employer', 'list_transaction_coins', 'sum_coin_info', 'sum_coin_send'));


        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy vui lòng thử lại');
        }
    }

    public function check_employer_role()
    {
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;
        if ($role != 2) {
            return false;
        }
        return true;
    }

    //thông tin liên hệ ứng viên
    public function list_coin_employer_show_employee()
    {
        $user_id = Auth::user()->id;
//        return view('site.jobs.list_jobs', compact('jobs', 'total_job', 'user'));
        $check_employer = $this->check_employer_role();;
        $employer = Employer::select('employer_id',
            'enterprise_name',
            'phone',
            'email',
            'user_id',
            'employer_coin',
            'total_employer_coin',
            'total_money_coin')->where('user_id', $user_id)->first();
        $employees = new Employee();


        $list_employer_show_employee = $employees->select('employees.employee_id', 'employees.employee_slug', 'employees.employee_name', 'employees.province', 'employees.district', 'employees.phone', 'employees.employee_level_id', 'employees.experience_id', 'employees.employee_image', 'employees.updated_at as date_update', 'employees.created_at as date_create', 'employees.profile', 'employees.salary_id', 'employees.my_facebook', 'employees.career_category_id', 'employees.email', 'statistical_employees.*')
            ->leftJoin('statistical_employees', 'statistical_employees.employees_id', '=', 'employees.employee_id', 'coin_show_employee.employee_id', 'coin_show_employee.employer_id')
            ->join('coin_show_employee', 'coin_show_employee.employee_id', 'employees.employee_id')
            ->where('coin_show_employee.employer_id', $employer->employer_id)
            ->orderBy('statistical_employees.money', 'desc')
            ->orderBy('statistical_employees.total_teacher', 'desc')
            ->orderBy('statistical_employees.total_exam', 'desc')
            ->orderBy('statistical_employees.total__dowload_voucher', 'desc')
            ->orderBy('statistical_employees.total_view_voucher', 'desc')
            ->orderBy('statistical_employees.total_view_job', 'desc')
            ->orderBy('statistical_employees.total_cv', 'desc')
            ->orderBy('statistical_employees.id_statistical', 'asc')
            ->orderBy('employees.employee_id', 'desc');
        $total = $list_employer_show_employee->count();
        $list_employer_show_employee = $list_employer_show_employee->paginate(15);
//            echo '<pre>';
//            print_r($total);die();
        return view('site.employer.list_coin_employer_show_employee', compact('total', 'list_employer_show_employee'));
    }

    public function list_coin_employer_invitation_employee()
    {
        $user_id = Auth::user()->id;
//        return view('site.jobs.list_jobs', compact('jobs', 'total_job', 'user'));
        $check_employer = $this->check_employer_role();
        $employer = Employer::select('employer_id',
            'enterprise_name',
            'phone',
            'email',
            'user_id',
            'employer_coin',
            'total_employer_coin',
            'total_money_coin')->where('user_id', $user_id)->first();
        $employees = new Employee();

        $list_employer_show_employee = $employees->select('employees.employee_id', 'employees.employee_name', 'employees.province', 'employees.district', 'employees.phone', 'employees.employee_level_id', 'employees.experience_id', 'employees.employee_image', 'employees.updated_at as date_update', 'employees.created_at as date_create', 'employees.profile', 'employees.salary_id', 'employees.my_facebook', 'employees.career_category_id', 'employees.email', 'coin_apply_employee.employee_id', 'coin_apply_employee.employee_id')
            ->leftJoin('coin_apply_employee', 'coin_apply_employee.employee_id', 'employees.employee_id')
            ->where('coin_apply_employee.employer_id', $employer->employer_id)
            ->orderBy('employees.employee_id', 'desc')
            ->distinct('coin_apply_employee.employee_id');
        $list_employer_show_employee = $list_employer_show_employee->paginate(15);

        $job = new Job();
        $jobs = $job->select(
            '*'
        );
        $jobs = $jobs->where('employer_id', $employer->employer_id);
        $jobs = $jobs->orderBy('job_id', 'desc');
        $total_job = $jobs->count();

        $jobs = $jobs->paginate(15);

//            echo '<pre>';
//            print_r($total);die();
        return view('site.employer.list_coin_employer_invitation_employee', compact('list_employer_show_employee', 'jobs'));

    }

    public function list_invitation_employee_job($job_id)
    {

        $user_id = Auth::user()->id;
//        return view('site.jobs.list_jobs', compact('jobs', 'total_job', 'user'));
        $check_employer = $this->check_employer_role();;
        $employer = Employer::select('employer_id',
            'enterprise_name',
            'phone',
            'email',
            'user_id',
            'employer_coin',
            'total_employer_coin',
            'total_money_coin')->where('user_id', $user_id)->first();
        $employees = new Employee();

        $job = Job::select('*')->where('job_id', $job_id)->first();
        Carbon::setLocale('vi'); // hiển thị ngôn ngữ tiếng việt.
        $date = date_create($job->updated_at);
        $date_fb = Carbon::create((date_format($date, "Y")), (date_format($date, "m")), (date_format($date, "d")), (date_format($date, "H")), (date_format($date, "i")), (date_format($date, "s")));
        $now = Carbon::now();
        $date_facebook = $date_fb->diffForHumans($now); //1 giờ trước

        $list_employer_show_employee = $employees->select('employees.employee_id', 'employees.employee_name', 'employees.province', 'employees.district', 'employees.phone', 'employees.employee_level_id', 'employees.experience_id', 'employees.employee_image', 'employees.updated_at as date_update', 'employees.created_at as date_create', 'employees.profile', 'employees.salary_id', 'employees.my_facebook', 'employees.career_category_id', 'employees.email', 'coin_apply_employee.employee_id', 'coin_apply_employee.employee_id', 'coin_apply_employee.job_id')
            ->leftJoin('coin_apply_employee', 'coin_apply_employee.employee_id', 'employees.employee_id')
            ->where('coin_apply_employee.employer_id', $employer->employer_id)
            ->where('coin_apply_employee.job_id', $job_id)
            ->orderBy('employees.employee_id', 'desc');
//             ->distinct('coin_apply_employee.employee_id');
        $total = $list_employer_show_employee->count();
        $list_employer_show_employee = $list_employer_show_employee->paginate(15);
//            echo '<pre>';
//            print_r($total);die();
        return view('site.employer.list_coin_employer_invitation_employee_job', compact('total', 'list_employer_show_employee', 'job', 'date_facebook'));

    }

    //Danh sách tin mời ứng viên đồng loạt
    public function list_coin_employees_invitation_job()
    {
        $user_id = Auth::user()->id;
//        return view('site.jobs.list_jobs', compact('jobs', 'total_job', 'user'));
        $check_employer = $this->check_employer_role();
        if (!$check_employer) {
            return redirect()->back()->with('error_login', 'Vui lòng đăng nhập tài khoản nhà tuyển dụng để sử dụng chức năng này');
        }
        $employer = Employer::select('employer_id',
            'enterprise_name',
            'phone',
            'email',
            'user_id',
            'employer_coin',
            'total_employer_coin',
            'total_money_coin')->where('user_id', $user_id)->first();
        $employees = new Employee();

        $list_employer_show_employee = $employees->select('employees.employee_id', 'employees.employee_name', 'employees.employee_slug', 'employees.province', 'employees.district', 'employees.phone', 'employees.employee_level_id', 'employees.experience_id', 'employees.employee_image', 'employees.updated_at as date_update', 'employees.created_at as date_create', 'employees.profile', 'employees.salary_id', 'employees.my_facebook', 'employees.career_category_id', 'employees.email', 'coin_apply_employee.employee_id', 'coin_apply_employee.employee_id')
            ->leftJoin('coin_apply_employee', 'coin_apply_employee.employee_id', 'employees.employee_id')
            ->where('coin_apply_employee.employer_id', $employer->employer_id)
            ->orderBy('employees.employee_id', 'desc')
            ->distinct('coin_apply_employee.employee_id');
        $list_employer_show_employee = $list_employer_show_employee->paginate(15);

        $job = new Job();
        $jobs = $job->select(
            '*'
        );
        $jobs = $jobs->where('employer_id', $employer->employer_id);
        $jobs = $jobs->orderBy('job_id', 'desc');
        $total_job = $jobs->count();

        $jobs = $jobs->paginate(15);

//            echo '<pre>';
//            print_r($jobs);die();
        return view('site.employer.list_coin_employees_invitation_job', compact('list_employer_show_employee', 'jobs'));

    }

    //Mời danh sách ứng viên ứng tuyển cho tin tuyển dụng
    public function list_coin_employees_invitation_job_apply(Request $request, $job_id)
    {
        $user_id = Auth::user()->id;
//        return view('site.jobs.list_jobs', compact('jobs', 'total_job', 'user'));
        $check_employer = $this->check_employer_role();
        if (!$check_employer) {
            return redirect()->back()->with('error_login', 'Vui lòng đăng nhập tài khoản nhà tuyển dụng để sử dụng chức năng này');
        }
        $employer = Employer::select('employer_id',
            'enterprise_name',
            'phone',
            'email',
            'user_id',
            'employer_coin',
            'total_employer_coin',
            'total_money_coin')->where('user_id', $user_id)->first();

        $job = Job::select('*')->where('job_id', $job_id)
            ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
            ->where('jobs.active_job', 1)
            ->first();
        if (empty($job)) {
            return redirect()->back()->with('error', 'Tin tuyển dụng này đã hết hạn nên không thể mời ứng viên ứng tuyển');
        }
        Carbon::setLocale('vi'); // hiển thị ngôn ngữ tiếng việt.
        $date = date_create($job->updated_at);
        $date_fb = Carbon::create((date_format($date, "Y")), (date_format($date, "m")), (date_format($date, "d")), (date_format($date, "H")), (date_format($date, "i")), (date_format($date, "s")));
        $now = Carbon::now();
        $date_facebook = $date_fb->diffForHumans($now); //1 giờ trước

        $employees = new Employee();
        //sap xep theo so tien
        $list_employee = $employees->select('employees.employee_id',
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
            $list_employee = $list_employee->where('employees.province', $request->input('province'));
        }
        if (!empty($request->input('career_category_id'))) {
//            echo $request->input('career_category_id');
            $list_employee = $list_employee->join('employee_career_categories', 'employee_career_categories.employee_id', '=', 'employees.employee_id');
            $career_category_id = $request->input('career_category_id');
            $list_employee = $list_employee->where('employee_career_categories.career_category_id', $career_category_id);
        }
        if (!empty($request->input('district_id'))) {
            //            //join với quận huyện
            $list_employee = $list_employee->join('employee_district', 'employee_district.employee_id', '=', 'employees.employee_id');
            $list_employee = $list_employee->join('district', 'district.district_id', '=', 'employee_district.district_id');
            $district_id = $request->input('district_id');
            $list_employee = $list_employee->where('employee_district.district_id', $district_id);
        }
        if (!empty($request->input('salary_id'))) {
            $salary_id = $request->input('salary_id');
            $list_employee = $list_employee->where('employees.salary_id', $salary_id);
        }
        if (!empty($request->input('word'))) {
            $word = $request->input('word');
            $list_employee = $list_employee->where('employees.employee_name', 'like', '%' . $word . '%');
        }
        if (!empty($request->input('experience_id'))) {
            $experience_id = $request->input('experience_id');
            $list_employee = $list_employee->where('employees.experience_id', $experience_id);
        }
        if (!empty($request->input('profile'))) {
            $profile = $request->input('profile');
            $list_employee = $list_employee->where('employees.profile', '>=', $profile);
        }

        if ($request->has('time_to_work')) {
            $date_home = date_create();
            $date_home_year = date_format($date_home, "Y");
            $time_to_work = $request->input('time_to_work');
            $time_ex = $date_home_year - $time_to_work;
//            echo $time_ex;die();
            if ($time_to_work >= 6) {
                $list_employee = $list_employee->where('employees.time_to_work', '<=', $time_ex);
            } else {
                $list_employee = $list_employee->where('employees.time_to_work', '<=', $time_ex);
                $list_employee = $list_employee->orderBy('employees.time_to_work', 'desc');
            }
        };
        $list_employee = $list_employee->where('employees.status_employee', 1);
        $list_employee = $list_employee->where('employees.show_hidden_profile', 0);
        $list_employee = $list_employee->whereNotNull('employees.email');
        $list_employee = $list_employee->orderBy('employees.updated_at', 'desc');
        if (!empty($request->input('limit_employee'))) {
            $limit_employee = $request->input('limit_employee');
            $list_employee = $list_employee->paginate($limit_employee);
            $list_employee->appends(request()->query());
        } else {
            $list_employee = $list_employee->paginate(20);
            $list_employee->appends(request()->query());

        }

//        echo '<pre>';
//            print_r($list_employee);die();
        return view('site.employer.list_coin_employees_invitation_job_apply', compact('list_employee', 'job', 'date_facebook', 'employer'));
    }

    public function send_employees_invitation_job_apply(Request $request)
    {
        $job_id = $request->input('job_id');
        $user_id = Auth::user()->id;
        $check_employer = $this->check_employer_role();
        if (!$check_employer) {
            return redirect()->back()->with('error_login', 'Vui lòng đăng nhập tài khoản nhà tuyển dụng để sử dụng chức năng này');
        }
        $employer = Employer::select('employer_id',
            'enterprise_name',
            'phone',
            'email',
            'user_id',
            'employer_coin',
            'total_employer_coin',
            'total_money_coin')->where('user_id', $user_id)->first();
        $job = Job::select('job_id', 'deadline_submit_profile', 'career_category_id')
            ->where('job_id', $job_id)
            ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
            ->where('jobs.active_job', 1)
            ->first();
        if (empty($job)) {
            return redirect()->back()->with('error', 'Tin tuyển dụng này đã hết hạn nên không thể mời ứng viên ứng tuyển');
        }
        //tính tổng số điểm để mời ứng viên
        $array_employee = $request->input('employee');
        $caree = \App\Entity\Career::getIdCareer($job->career_category_id);
        $total_coin_employee = count($array_employee) * $caree->view_apply;
//        echo '<pre>';
//        print_r($array_employee);die();
//        echo count($array_employee).'*'.$caree->view_apply.'---';
//echo $employer->employer_coin.' so sanh ';
//        echo $total_coin_employee;die();
        //dung điểm nhà tuyển dụng

        $infomation_coin = \App\Entity\Coin_type_information_employer::get_coin_info();
        $coin_free = !empty($infomation_coin['so-diem-mien-phi-theo-ngay']) ? $infomation_coin['so-diem-mien-phi-theo-ngay'] : 0;
        $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
        $coin_surplus = $coin_free - $history_coin;
        $coin_surplus = !empty($coin_surplus) ? $coin_surplus : 0;
        //trường hợp ntd dùng điểm miễn phí
        if (empty($employer->total_employer_coin) && $coin_surplus < $total_coin_employee) {
            return redirect()->back()->with('error', 'Số điểm miễn phí không đủ để mời ứng viên ứng tuyển');
        }
        //trường họp ntd dùng điểm đã nạp
        if (!empty($employer->total_employer_coin) && $employer->employer_coin < $total_coin_employee) {
            return redirect()->back()->with('error', 'Số điểm của bạn không đủ để mời ứng viên ứng tuyển');
        }
        DB::beginTransaction();
        if (!empty($employer->total_employer_coin)) {
            //trường họp trừ xu của ntd
            $employer_coin = $employer->employer_coin - $total_coin_employee;
            $update_coin = Employer::where('employer_id', $employer->employer_id)->update([
                'employer_coin' => $employer_coin
            ]);
            $coin_history_status = 1;
        } else {
            //trường hợp xu miễn phí
            $coin_history_status = 0;
        }

        //trừ xu lưu trong bảng lịch sử
        $insert_get_id = Coin_history_employer::insertGetId([
            'coin_history_title' => 'Mời danh sách ứng viên ứng tuyển tin tuyển dụng',
            'coin' => $total_coin_employee,
            'coin_history_status' => $coin_history_status,
            'coin_employee_status' => 1,
            'employer_id' => $employer->employer_id,
            'created_at' => new \DateTime()
        ]);
        foreach ($array_employee as $employee) {
            $inser_coin_show_employee = Coin_apply_employee::insertGetId([
                'coin_history_id' => $insert_get_id,
                'employer_id' => $employer->employer_id,
                'employee_id' => $employee,
                'job_id' => $job_id,
                'created_at' => new \DateTime()
            ]);
            $email_employee = Employee::where('employee_id', $employee)->value('email');
            $send_email = MailConfigController::send_staff_apply_job($job_id, $email_employee);
//            $sendmail = MailConfigController::send_email_invitation_employee($job, $employee);
        }
        DB::commit();
        return redirect()->back()->with('suscess', 'Mời ứng viên ứng tuyển thành công');
    }

}
