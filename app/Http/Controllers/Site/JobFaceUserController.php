<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Course\Course;
use App\Course\Course_employee;
use App\Entity\Coin_show_employee;
use App\Entity\Cv_employee;
use App\Entity\Cv_note_template;
use App\Entity\Cv_template;
use App\Entity\Employee;
use App\Entity\Employee_business_type;
use App\Entity\Employee_career_categories;
use App\Entity\Employee_curriculum;
use App\Entity\Employee_district;
use App\Entity\Employee_experience;
use App\Entity\Employee_specialize;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Employee_upload_cv;
use App\Entity\Employees_save_job_facebook;
use App\Entity\Employer;
use App\Entity\EmployerIntership;
use App\Entity\Hunter_registration;
use App\Entity\Job;
use App\Entity\Job_desired;
use App\Entity\JobFacebook;
use App\Entity\JobFacebookWarning;
use App\Entity\Noti_career_category_id;
use App\Entity\NotificationWindow;
use App\Entity\Salary;
use App\Entity\Service_order;
use App\Entity\Staff_status_job_submit_employee;
use App\Entity\Statistical_employees;
use App\Entity\Employee_profile;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_job_group;
use App\Entity\Teacher_save_job_facebook;
use App\Entity\Teacher_specialize;
use App\Entity\User;
use App\Exam\Questions;
use App\Exam\Result_job_exam;
use App\Http\Controllers\Api\NotificationMobileController;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Rules\Invateemails;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Mail\Resetpassword;
use function Sodium\compare;
use JWTAuth;
use Storage;


class JobFaceUserController extends SiteController
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

//check quyền ung vien
    private function checkRoleUserEmployee()
    {
        $role = Auth::user()->role;
        if ($role == 1) {
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

    public function create(Request $request)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user = Auth::user();
        $salaries = Salary::orderBy('salary_id')->get();
        return view('site.job_facebook.add_job_fb', compact('user', 'salaries'));
    }

    public function store(Request $request)
    {
        $id = Auth::user()->id;
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user_id = Auth::user()->id;

        $validation = Validator::make($request->all(), [
            'career_category_id' => 'required',
            'salary_id' => 'required',
//            'company_name' => 'required',
//          'email' => 'unique:job_facebook',
            'g-recaptcha-response' => 'required',
        ], [
            'career_category_id.required' => 'Vui lòng chọn ngành nghề của công việc',
            'salary_id.required' => 'Vui lòng chọn mức lương',
//            'company_name.required' => 'Vui lòng nhập tên công ty',
//            'email.unique' => 'Email đã tồn tại . Vui lòng nhập email khác',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        $employer = new Employer();
        $employer = $employer->select('*')->where('user_id', $id)->first();
        $slug = Ultility::createSlug($request->input('title'));
        $jobFacebookId = JobFacebook::insertGetId([
            'title' => $request->input('title'),
            'des_facebook' => $request->input('des_facebook'),
            'employer_id' => $employer->employer_id,
            'content' => $request->input('content'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'link' => $request->input('link'),
            'email' => $request->input('email'),
            'salary_id' => $request->input('salary_id'),
            'province' => $request->input('province'),
//            mã ngành nghề
            'career_category_id' => $request->input('career_category_id'),
            'view' => $request->input('view'),
            'district' => $request->input('district'),
            'job_info_contact' => $request->input('job_info_contact'),
            'user_id' => $user_id,
            'warning_job_fb' => 0,
            'date_end' => new \DateTime(date('Y-m-d H:i:s', strtotime("+30 days"))),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
//            'welfare' => $request->input('welfare'),
            'company_name' => $request->input('company_name'),
        ]);
        $job_facebook = new JobFacebook();
        $update_facebook = $job_facebook->where('job_facebook_id', $jobFacebookId)->update([
            'job_facebook_code' => 'FB' . $jobFacebookId
        ]);
        // insert slug
        $jobWithSlug = JobFacebook::where('slug', $slug)->first();

        JobFacebook::where('job_facebook_id', '=', $jobFacebookId)
            ->update([
                'slug' => $slug . '-' . $jobFacebookId
            ]);
        //            Luư thông tin vào bảng thông báo để tìm ứng viên phù hơp

//        $noti_carrer_model = new Noti_career_category_id();
//        $insert = $noti_carrer_model->insert([
//            'title_note' => 'Có công việc kế toán phù hợp với bạn',
//            'job_id' => $jobFacebookId,
//            'status' => 0,
//            'created_at' => new \DateTime(),
//            'updated_at' => new \DateTime(),
//        ]);

        //gủi email thông báo đến email nhận thông báo tin tuyển dụng trong sanketoan.vn
        $job_face_email = JobFacebook::where('job_facebook_id', '=', $jobFacebookId)->first();
//        print_r($job_face_email);die();
        //gui thong bao tren mobile


        if (!empty($job_face_email['email'])) {
            MailConfigController::notif_job_facebook($job_face_email, $job_face_email['email']);
        }
        return redirect(route('getAllUser'))->with('suscess', 'Thêm việc làm facebook thành công');
    }

    public function show(Request $request)
    {

    }

    public function edit(Request $request, $id_job_fb)
    {
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $jobFacebook = new JobFacebook();
        $jobFacebook = $jobFacebook->select('*')
            ->where('job_facebook_id', $id_job_fb)
            ->where('user_id', $user_id)
            ->first();
        $salaries = Salary::orderBy('salary_id')->get();
        return view('site.job_facebook.edit_job_fb', compact('user', 'salaries', 'jobFacebook'));
    }

    //cập nhật tin
    public function update(Request $request, $id_job_fb)
    {
        $user_id = Auth::user()->id;
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $this->validate($request, [
            'career_category_id' => 'required',
            'salary_id' => 'required',
            'g-recaptcha-response' => 'required',
        ]);
        try {
            $jobFacebook = new JobFacebook();
            $jobFacebook = $jobFacebook->select('*')
                ->where('job_facebook_id', $id_job_fb)
                ->where('user_id', $user_id)
                ->first();
            $slug = Ultility::createSlug($request->input('title'));
            JobFacebook::where('job_facebook_id', $id_job_fb)
                ->where('user_id', $user_id)
                ->update([
                    'job_facebook_code' => 'FB' . $id_job_fb,
                    'title' => $request->input('title'),
                    'des_facebook' => $request->input('des_facebook'),
                    'content' => $request->input('content'),
                    'address' => $request->input('address'),
                    'phone' => $request->input('phone'),
                    'link' => $request->input('link'),
                    'email' => $request->input('email'),
                    'salary_id' => $request->input('salary_id'),
                    'province' => $request->input('province'),
//            'code'  => $request->input('code'),
                    'career_category_id' => $request->input('career_category_id'),
                    'district' => $request->input('district'),
                    'job_info_contact' => $request->input('job_info_contact'),
                    'updated_at' => new \DateTime(),
//                    'welfare' => $request->input('welfare'),
                    'company_name' => $request->input('company_name'),
                ]);

            // insert slug
            $jobWithSlug = JobFacebook::where('slug', $slug)
                ->where('job_facebook_id', '!=', $jobFacebook->job_facebook_id)
                ->first();

            JobFacebook::where('job_facebook_id', $jobFacebook->job_facebook_id)
                ->update([
                    'slug' => $slug . '-' . $jobFacebook->job_facebook_id
                ]);

            return redirect(route('getAllUser'))->with('success', 'Bạn đã sửa bài viết việc làm thành công !');
        } catch (\Exception $e) {
            return redirect(route('getAllUser'))->with('erorr', 'Bạn đã sửa bài viết việc làm thất bại !');
        }
    }

//   Xóa tin đăng fb
    public function destroy($id_job_fb)
    {
        $user_id = Auth::user()->id;
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        try {
            $jobFacebook = new JobFacebook();
            $jobFacebook = $jobFacebook->select('*')->where('job_facebook_id', $id_job_fb)
                ->where('user_id', $user_id)
                ->delete();
            return redirect(route('getAllUser'))->with('success', 'Bạn đã xóa bài viết việc làm thành công !');
        } catch (\Exception $e) {
            return redirect(route('getAllUser'))->with('erorr', 'Bạn đã xóa bài viết việc làm thất bại !');
        }
    }

    // xu li ajax báo tin lỗi
    public function addWarning(Request $request)
    {
        $id_job_fb = $_GET['id_job_fb'];
        $status_job = $_GET['status_job'];
        $user_id = Auth::user()->id;
        $jobFacebook = new JobFacebook();
        $job_warning = new JobFacebookWarning();
        $jobFacebook = $jobFacebook->select('*')->where('job_facebook_id', $id_job_fb)->first();
        $count_job_warning = $job_warning->select('*')
            ->where('job_facebook_id', $id_job_fb)
            ->where('user_warning', $user_id)
            ->where('status_job', $status_job)
            ->count();
        $view_warning = intval($jobFacebook->warning_job_fb) + 1;
        if ($count_job_warning < 1) {
            $update = $jobFacebook->where('job_facebook_id', $id_job_fb)->update([
                'warning_job_fb' => $view_warning,
                'user_warning' => $user_id,
            ]);
            $insert = $job_warning->insert([
                'job_facebook_id' => $id_job_fb,
                'user_warning' => $user_id,
                'status_job' => $status_job
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

//    xu li ajax luu viec lam
    public function saveJobFacebook(Request $request)
    {
        $id_job_fb = $_GET['id_job_fb'];
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
                    'created_at' => new \DateTime()
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

    public function deletesaveJobFacebook(Request $request)
    {
        $id_job_fb = $_GET['id_job_fb'];
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
    public function job_Like_Employee(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;


        $emplo = new Employee();
        $emplo = $emplo->select('career_category_id', 'user_id')->where('user_id', $user_id)->first();

        $teacher = new Teacher();
        $tea = $teacher->select('career_category_id', 'user_id')->where('user_id', $user_id)->first();

        $user_id = Auth::user()->id;
        $jobFacebooks = new JobFacebook();


        $jobfaceModule = new JobFacebook();
        $jobFacebooks = $jobfaceModule->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
        if ($role == 1) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.career_category_id', $emplo->career_category_id);

        } elseif ($role == 3) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.career_category_id', $tea->career_category_id);
        }
        $jobFacebooks = $jobFacebooks->select(
            'job_facebook.*',
            'salary.description as salary_description'
        );
        $jobFacebooks = $jobFacebooks->where('warning_job_fb', '<', 4);
        $jobFacebooks = $jobFacebooks->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
        $total = $jobFacebooks->count();
        $jobFacebooks = $jobFacebooks->paginate(20);
//        echo $total;die();
        $jobFacebooks->appends(request()->query());

        return view('site.job_facebook.list_like_job_fb', compact('jobFacebooks', 'user', 'total'));
    }

    public function job_desired_employee(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;


        $emplo = new Employee();
        $emplo = $emplo->select('career_category_id', 'user_id', 'employee_id')->where('user_id', $user_id)->first();

        $jobs_desired = Job_desired::select('*')->where('employee_id', $emplo->employee_id)->first();
        if (empty($jobs_desired)) {
            $list_jobs = array();
            $list_job_fb = array();
            $total_jobs = 0;
            $total_job_fb = 0;
        } else {
            $jobs_model = new Job();
            $list_jobs = $jobs_model
                ->join('salary', 'salary.salary_id', 'jobs.salary_id')
                ->select(
                    'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at', 'jobs.province', 'jobs.career_category_id', 'jobs.salary_id', 'jobs.district',
                    'salary.description as salary_description', 'jobs.deadline_submit_profile'
                );
            if (!empty($jobs_desired->province_id)) {
                $list_jobs = $list_jobs->where('jobs.province', $jobs_desired->province_id);
            }
            if (!empty($jobs_desired->salary_id)) {

                $array_salary_id = explode(',', $jobs_desired->salary_id);
                $list_jobs = $list_jobs->whereIn('jobs.salary_id', $array_salary_id);
            }
            if (!empty($jobs_desired->career_category_id)) {
                $array_career_category_id = explode(',', $jobs_desired->career_category_id);
                $list_jobs = $list_jobs->whereIn('jobs.career_category_id', $array_career_category_id);
            }
            if (!empty($jobs_desired->district_id)) {
                $array_district_id = explode(',', $jobs_desired->district_id);
                $list_jobs = $list_jobs->whereIn('jobs.district', $array_district_id);
            }

            $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
            $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
            $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
            //tong so bai viet
            $total_jobs = $list_jobs->count();
            $list_jobs = $list_jobs->paginate(10);
            $list_jobs->appends(request()->query());


            $jobfaceModule = new JobFacebook();
//        sắp xếp theo tin mới nhất
            $list_job_fb = $jobfaceModule->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
            $list_job_fb->select('salary.description as salary_description', 'job_facebook.*');
            if (!empty($jobs_desired->province_id)) {
                $list_job_fb = $list_job_fb->where('job_facebook.province', $jobs_desired->province_id);
            }
            if (!empty($jobs_desired->salary_id)) {

                $array_salary_id = explode(',', $jobs_desired->salary_id);
                $list_job_fb = $list_job_fb->whereIn('job_facebook.salary_id', $array_salary_id);
            }

            if (!empty($jobs_desired->career_category_id)) {
                $array_career_category_id = explode(',', $jobs_desired->career_category_id);
                $list_job_fb = $list_job_fb->whereIn('job_facebook.career_category_id', $array_career_category_id);
            }
            if (!empty($jobs_desired->district_id)) {
                $array_district_id = explode(',', $jobs_desired->district_id);
                $list_job_fb = $list_job_fb->whereIn('job_facebook.district', $array_district_id);
            }

            $list_job_fb = $list_job_fb->where('warning_job_fb', '<', 4);
//        sắp xếp theo lương
            $list_job_fb = $list_job_fb->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
            $list_job_fb = $list_job_fb->orderBy('job_facebook.vip', 'desc');
            $list_job_fb = $list_job_fb->orderBy('job_facebook.job_facebook_id', 'desc');
            $total_job_fb = $list_job_fb->count();
            $list_job_fb = $list_job_fb->paginate(10);
            $list_job_fb->appends(request()->query());
//            echo '<pre>';
//            print_r($list_job_fb);die();

        }
        return view('site.jobs.job_desired_employee', compact('list_jobs', 'user', 'total_jobs', 'total_job_fb', 'jobs_desired', 'list_job_fb'));
    }

    public function check_job_desired(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;
        $emplo = new Employee();
        $emplo = $emplo->select('career_category_id', 'user_id', 'employee_id')->where('user_id', $user_id)->first();

        $jobs_desired_model = new Job_desired();
        $jobs_desired = $jobs_desired_model->select('*')->where('employee_id', $emplo->employee_id)->first();
        $array_career = '';
        $array_salary = '';
        $array_district = '';
        if (!empty($request->input('career_category_id'))) {
            $array_career_input = $request->input('career_category_id');
//            print_r($array_career_input);die();
            $array_career = implode(',', $array_career_input);
        }
        if (!empty($request->input('salary_id'))) {
            $array_salary_input = $request->input('salary_id');
            $array_salary = implode(',', $array_salary_input);
        }
        if (!empty($request->input('district'))) {
            $array_district_input = $request->input('district');
            $array_district = implode(',', $array_district_input);
        }


        if (!empty($jobs_desired)) {
            $update = $jobs_desired_model->where('employee_id', $emplo->employee_id)->update([
                'province_id' => $request->input('province'),
                'district_id' => $array_district,
                'salary_id' => $array_salary,
                'career_category_id' => $array_career,
                'updated_at' => new \DateTime(),
            ]);
        } else {
            $insert = $jobs_desired_model->insert([
                'employee_id' => $emplo->employee_id,
                'province_id' => $request->input('province'),
                'district_id' => $array_district,
                'salary_id' => $array_salary,
                'career_category_id' => $array_career,
                'created_at' => new \DateTime()
            ]);
        }
        return redirect(route('job_desired_employee'));
    }


//    hien thi giao dien
    public function show_user_job_facebook(Request $request)
    {
        $user = Auth::user();
        return view('site.job_facebook_site.update_user', compact('user'));
    }

    //doi mat khau
    public function storeResetPassword(Request $request)
    {
        $user = Auth::user();
        if (!Hash::check($request->input('password_old'), $user->password)) {
            $faidOldPassword = "Mật khẩu cũ của bạn điền không đúng";

            return redirect()->back()
                ->with('faidOldPassword', $faidOldPassword)
                ->withInput();
        }

        $validation = Validator::make($request->all(), [
            'password' => 'required|string|min:7|confirmed',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        User::where('id', $user->id)->update([
            'password' => bcrypt($request->input('password')),
        ]);
        return redirect()->back()
            ->with('success', 'Bạn đã thay đổi mật khẩu thành công')
            ->withInput();
    }

    public function show_step_profile_employee(Request $request)
    {
        $user = Auth::user();
        $employees = new Employee();
        $employee = $employees->select(
            'employee_id',
            'status',
            'user_id',
            'profile',
            'status_employee'
        )
            ->where('user_id', $user->id)
            ->first();
        //xác thục tài khoản
        $status_email_account = $user->status_email_account;
        //thông tin điểm của hồ sơ

        $check_employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
		
		$profile_info = Employee::get_profile_info($user->id);
		if(empty($check_employee_profile))
		{
			 $insert_employee_profile = Employee_profile::insert([
                'employee_id' => $employee->employee_id,
                'profile_info' => $profile_info,
                'created_at' => new \DateTime()
            ]);
		}else
		{
			  //cộng lại điểm cho employee_profile
			$update_employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->update([
				'profile_info' => $profile_info,
				'updated_at' => new \DateTime()
			]);
		}
		$employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
        $profile = $profile_info + $employee_profile->profile_cv + $employee_profile->profile_staff + $employee_profile->profile_course + $employee_profile->profile_avg;
        $update_employee = $employees->where('employee_id', $employee->employee_id)->update([
            'profile' => $profile,
            'status_employee' => $profile >= 40 ? 1 : 0,
            'updated_at' => new \DateTime()
        ]);

        //thông tin cv đã tạo
        $check_cv = Cv_employee::where('employee_id', $employee->employee_id)->count();
        //cv đã upload
        $check_file_cv = Employee_upload_cv::where('employee_id', $employee->employee_id)->count();
        //ứng viên đăng kí khóa học
        $check_course = Course_employee::where('employee_id', $employee->employee_id)->count();
        return view('site.employee_site.step_profile_employee', compact('employee', 'status_email_account', 'employee_profile', 'check_cv', 'check_file_cv', 'check_course'));

//        return view('site.employee.step_profile_employee',compact('status_email_account','check_cv', 'status_employee'));
    }

    public function show_file_job_facebook(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;

//        check role user xem la user nao
        $role = Auth::user()->role;
        if ($role == 1) {
            $employees = new Employee();
            $employee = $employees->select('*')->where('user_id', $id)->first();
//          $user_id là id trong user
            $profile = $employee->profile;
//           return view('site.employee.test_step_update_profile_employee', compact('user', 'employee', 'profile'));
            return view('site.employee.step_update_profile_employee', compact('user', 'employee', 'profile'));
        }
        if ($role == 2) {
            $employer = new Employer();
            $employer = $employer->select('*')->where('user_id', $id)->first();
            if (!empty($employer)) {
                $update = \App\Entity\Employer::get_user_id_Profile($id);
//                return view('site.job_facebook.update_user_employer', compact('user', 'employer'));
                return view('site.job_facebook_site.update_user_employer', compact('user', 'employer'));
            } else {
                return redirect()->back();
            }

        }
        if ($role == 3) {
            $teacher = new Teacher();
            $teacher = $teacher->select('*')->where('user_id', $id)->first();
            $teacher_jobs = new Teacher_job_group();
            $teacher_job = $teacher_jobs->select('*')->where('teacher_id', $teacher->teacher_id)->get();

            $id_teacher_job = array();
            foreach ($teacher_job as $job) {
                $id_teacher_job[] = $job->job_group_id;
            }
//trinh do chuyen mon giao vien
            $specialize = new Teacher_specialize();
            $specialize = $specialize->select('*')->where('teacher_id', $teacher->teacher_id)->orderBy('specialize_id', 'asc')->get();
//            Kinh nghiệm giao vien

            $experience = new Teacher_experience();
            $experience = $experience->select('*')->where('teacher_id', $teacher->teacher_id)->orderBy('experience_id', 'asc')->get();
//            khoa hoc giao vien
            $course = new Course();
            $course = $course->select('*')->where('course_id', $teacher->course_id)->first();

            return view('site.job_facebook.update_user_teacher', compact('user', 'teacher', 'specialize', 'experience', 'course', 'id_teacher_job'));
        }

    }

    public function show_file_job_facebook2(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;


//        check role user xem la user nao
        $role = Auth::user()->role;
        if ($role == 1) {
            $employees = new Employee();
            $employee = $employees->select('*')->where('user_id', $id)->first();
            //trinh do chuyen mon
            $specialize = new Employee_specialize();
            $specialize = $specialize->select('*')->where('employee_id', $employee->employee_id)->orderBy('specialize_id', 'asc')->get();
//            Kinh nghiệm làm việc

            $experience = new Employee_experience();
            $experience = $experience->select('*')->where('employee_id', $employee->employee_id)->orderBy('experience_id', 'asc')->get();
            return view('site.job_facebook.update_user_employee', compact('user', 'employee', 'specialize', 'experience'));
        }
        if ($role == 2) {
            $employer = new Employer();
            $employer = $employer->select('*')->where('user_id', $id)->first();
            if (!empty($employer)) {
                return view('site.job_facebook.update_user_employer', compact('user', 'employer'));
            } else {
                return redirect()->back();
            }

        }
        if ($role == 3) {
            $teacher = new Teacher();
            $teacher = $teacher->select('*')->where('user_id', $id)->first();

            $teacher_jobs = new Teacher_job_group();
            $teacher_job = $teacher_jobs->select('*')->where('teacher_id', $teacher->teacher_id)->get();

            $id_teacher_job = array();
            foreach ($teacher_job as $job) {
                $id_teacher_job[] = $job->job_group_id;
            }
//trinh do chuyen mon giao vien
            $specialize = new Teacher_specialize();
            $specialize = $specialize->select('*')->where('teacher_id', $teacher->teacher_id)->orderBy('specialize_id', 'asc')->get();
//            Kinh nghiệm giao vien

            $experience = new Teacher_experience();
            $experience = $experience->select('*')->where('teacher_id', $teacher->teacher_id)->orderBy('experience_id', 'asc')->get();
//            khoa hoc giao vien
            $course = new Course();
            $course = $course->select('*')->where('course_id', $teacher->course_id)->first();

            return view('site.job_facebook.update_user_teacher2', compact('user', 'teacher', 'specialize', 'experience', 'course', 'id_teacher_job'));
        }

    }

    //cap nhat ho so nha tuyen dung
    public function updateEmployer(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $validation = Validator::make($request->all(), [
            'enterprise_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'district' => 'required',
            'address' => 'required',
            'introduction' => 'required',
            'type_of_business_id' => 'required',
            'business' => 'required'
        ], [
            'employer_name.required' => 'Tên người phụ trách không được bỏ trống',
            'address.required' => 'Địa chỉ công ty không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'province.required' => 'Vui lòng chọn tỉnh / thành phố',
            'district.required' => 'Vui lòng chọn quận / huyện',
            'introduction.required' => 'Giới thiệu về công ty không được để trống',
            'type_of_business_id.required' => 'Vui lòng chọn loại hình doanh nghiệp',
            'business.required' => 'Vui lòng chọn loại hình kinh doanh'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            $employer = new Employer();
            $update = $employer->where('user_id', $id)->update([
                'enterprise_name' => $request->input('enterprise_name'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'introduction' => $request->input('introduction'),
                'type_of_business_id' => $request->input('type_of_business_id'),
                'business' => $request->input('business'),
                'website' => $request->input('website'),
                'tax_code' => $request->input('tax_code'),
                'image' => $request->input('image'),
                'images_list' => $request->input('images_list')
            ]);
            // insert slug

            $employers = $employer->select('*')->where('user_id', $id)->first();
            $slug = Ultility::createSlug($request->input('enterprise_name'));
            $postWithSlug = $employer->where('slug', $employers->slug)->first();
            if (empty($postWithSlug)) {
                $employer->where('employer_id', '=', $employers->employer_id)
                    ->update([
                        'slug' => $slug
                    ]);
            } else {
                $employer->where('employer_id', '=', $employers->employer_id)
                    ->update([
                        'slug' => $slug . '-' . $employers->employer_id
                    ]);
            }
            $user_model = new User();
            $update = $user_model->where('id', $id)->update([
                'name' => $request->input('enterprise_name'),
                'phone' => $request->input('phone'),
            ]);
            $update_profile = \App\Entity\Employer::get_user_id_Profile($id);
            return redirect(route('job-user.create'))->with('suscess', 'Cập nhật thông tin công ty thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('erorr', 'Cập nhật thông tin công ty thất bại');
        }
    }

    //cổng thục tập
    public function show_intership_employee(Request $request)
    {
        $user = Auth::user();
        if (!$this->checkRoleUserEmployee()) {
            return redirect(route('list_job_face'))->with('error_login', 'Chức năng này chỉ dành cho !');
        }
        $employee = new Employee();
        $employee = $employee->select('*')->where('user_id', $user->id)->first();

        $intership = new EmployerIntership();
        $intership = $intership->select('employer_intership.*', 'employer.enterprise_name', 'employer.employer_id', 'employer.email', 'employer.phone', 'employer.slug', 'employer.address')
            ->leftJoin('employer', 'employer.employer_id', '=', 'employer_intership.employer_id')
            ->where('employer_intership.employee_id', $employee->employee_id)
            ->orderBy('intership_id', 'desc')
            ->get();
        return view('site.job_facebook.show_intership_employee', compact('user', 'employee', 'intership'));
    }

    public function show_intership(Request $request)
    {
        $user = Auth::user();
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Chức năng này chỉ dành cho nhà tuyển  dụng!');
        }
        $employer = new Employer();
        $employer = $employer->select('employer_id', 'status_intership', 'status_allowance', 'des_intership', 'content_intership', 'user_id', 'updated_at', 'banner_intership')->where('user_id', $user->id)->first();


        return view('site.job_facebook_site.show_intership', compact('user', 'employer'));
    }

    public function list_intership_employer(Request $request)
    {
        $user = Auth::user();
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Chức năng này chỉ dành cho nhà tuyển  dụng!');
        }
        $employer = new Employer();
        $employer = $employer->select('employer_id', 'status_intership', 'status_allowance', 'des_intership', 'content_intership', 'user_id', 'updated_at', 'banner_intership')->where('user_id', $user->id)->first();

        $intership = new EmployerIntership();
        $intership = $intership->select('employer_intership.*', 'employees.employee_id', 'employees.employee_slug', 'employees.employee_name', 'employees.province', 'employees.district')
            ->join('employees', 'employees.employee_id', '=', 'employer_intership.employee_id');
        $intership = $intership->where('employer_intership.employer_id', $employer->employer_id);


        if (!empty($request->input('id_status_submit'))) {
            $id_status_submit = $request->input('id_status_submit');
            $intership = $intership->whereIn('employer_intership.id_status', $id_status_submit);
        }
        $intership = $intership->orderBy('employer_intership.intership_id', 'desc');
        $intership = $intership->paginate(10);
        $intership->appends(request()->query());

        return view('site.job_facebook_site.list_intership', compact('user', 'employer', 'intership'));

    }

    public function update_intership(Request $request)
    {
//        echo $request->input('status_allowance');die();
        try {
            $user = Auth::user();
            $employer_model = new Employer();
            $update = $employer_model->where('user_id', $user->id)->update([
                'status_intership' => $request->input('status_intership'),
                'status_allowance' => $request->input('status_allowance'),
                'des_intership' => $request->input('des_intership'),
                'content_intership' => $request->input('content_intership'),
                'banner_intership' => $request->input('banner_intership'),
            ]);
            if ($request->input('status_intership') == 1) {
                $employer = $employer_model->select('email', 'user_id')->where('user_id', $user->id)->first();
//                gửi email thông báo chuyển trạng thái sang hồ sơ tuyển dụng
                MailConfigController::change_intership($employer->email);
            }
            return redirect()->back()->with('suscess', 'Cập nhật thông tin tuyển thực tập thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('erorr', 'Cập nhật thông tin tuyển thực tập thất bại');
        }
    }

    //capj nhat trang thai ho so thuc tap
    public function update_status_intership(Request $request)
    {
        try {
            $intership_id = $request->input('intership_id');
            $interships = new EmployerIntership();

            $inter = $interships->select('*')->where('intership_id', $intership_id)->first();
            $intership = $interships->where('intership_id', $intership_id)->update([
                'status_intership' => $request->input('status_intership')
            ]);

            $employee = new Employee();
            $employee = $employee->select('email', 'employee_id')->where('employee_id', $inter->employee_id)->first();

            $employer = new Employer();
            $employer = $employer->select('employer_id', 'enterprise_name')->where('employer_id', $inter->intership_id)->first();

            if (!empty($employee->email) && $request->input('status_intership') == 1) {
                $subject = 'Sanketoan.vn thông báo';
                $content = $employer->enterprise_name . '<p> đã xác nhận hồ sơ thực tập của bạn thực tập của bạn !</p>';
                $content .= '<p> Chi tiết xem tại tủ hồ sơ của <a href="https://sanketoan.vn/">sanketoan.vn</a></p>';
                MailConfig::sendMail($employee->email, $subject, $content);
            }
            return redirect()->back()->with('suscess', 'Cập nhật trạng thái tuyển thực tập thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('erorr', 'Cập nhật trạng thái tuyển thực tập thất bại');
        }
    }

    public function delete_intership(Request $request)
    {
        try {
            $intership_id = $request->input('intership_id');
            $intership = new EmployerIntership();
            $intership = $intership->where('intership_id', $intership_id)->delete();

            return redirect()->back()->with('suscess', 'Xóa hồ sơ thực tập thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('erorr', 'Xóa hồ sơ thực tập thất bại');
        }
    }

    //het cap nhat ho so nha tuyen dung
    //cap nhat ho so ung vien
    public function check_cv($file_name, $file_size)
    {
//        echo $file_name,'---'.$file_size;
        $file_ext = explode('.', $file_name);
        $file_extension = end($file_ext);
        $expensions = array("doc", "docx", "pdf");
        if (in_array($file_extension, $expensions) === false) {
            $errors[] = "Chỉ hỗ trợ upload file .doc hoặc .docx hoặc .pdf ";
            return false;
        }
        if ($file_size > 500000) {
            $errors[] = 'Kích thước file không được lớn hơn 5MB';
            return false;
        }
        return true;
    }

    public function upload_CV($request, $file_cv, $email, $employee_id)
    {
        //luu luôn dịnh dạng ngày tháng năm
        try {
            if (file_exists(public_path() . 'library_cv/' . $file_cv) && !empty($file_cv)) {
                unlink(public_path('library_cv/' . $file_cv));
            }
            $file = $request->employee_cv;
            $name_file = 'CV_' . Ultility::createSlug($email) . '_' . $employee_id . '.' . $file->getClientOriginalExtension();
            $type = $file->getClientOriginalExtension();
            $file->move('library_cv', $name_file);
            return $name_file;
        } catch (\Exception $e) {
            return null;
        }

    }

    public function ajaxUpdateEmployeeImage(Request $request)
    {
        $id = Auth::user()->id;
        //upload image
        $upload_file = new Upload_FileController();
        $link_image = $upload_file->check_ajax_upload_image($id, $_FILES['file']);
//        $slug_name = str_slug(Auth::user()->name);
//       $link_image = $upload_file->upload_tinify_image($id, $_FILES['file'],$slug_name);
        if (empty($link_image)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng chọn đúng định dạng file image và kích thước file nhỏ hơn 10M.',
                'link_image' => $link_image
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Tải ảnh thành công !'
        ]);
    }

    public function updateEmployee(Request $request)
    {
//        echo $request->submit_form;die();

        $validation = Validator::make($request->all(), [
            'employee_name' => 'required',
            'phone' => 'required',
            'career_category_id' => 'required',
            'province' => 'required',
            'district' => 'required',
            'image_scrop' => 'required',
            'address' => 'required',
            'employee_level_id' => 'required',
            'gender' => 'required'
        ], [
            'employee_name.required' => 'Tên ứng viên không được bỏ trống',
            'phone.required' => 'Số điện thoại của ứng viên không được bỏ trống',
            'career_category_id.required' => 'Vui lòng chọn công việc cần tìm',
            'province.required' => 'Vui lòng chọn thành phố',
            'district.required' => 'Vui lòng chọn quận huyện',
            'image_scrop.required' => 'Hình ảnh ứng viên không được bỏ trống',
            'address.required' => 'Địa chỉ cụ thể của ứng viên không được bỏ trống',
            'employee_level_id.required' => 'Vui lòng chọn trình độ cao nhất',
            'gender.required' => 'Vui lòng chọn giới tính'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        $user = Auth::user();
        $id = Auth::user()->id;
        $employee_model = new Employee();
        $employee = $employee_model->where('user_id', $id)->first();

        //upload image
        $link_image = $employee->employee_image;
        $check_url = $request->input('image_scrop');
        if (strlen($check_url) > 250) {
            $upload_file = new Upload_FileController();
//            $link_image = $upload_file->upload_image($id, $request, 'images');
//            $file_path = $request->file('images');
//            $link_image = $upload_file->upload_tinify_image($id, $file_path,str_slug(Auth::user()->name),$employee->employee_image);

            $link_image = $upload_file->scrop_image_base64($request);
//            echo $link_image;die;
            if (empty($link_image)) {
                return redirect()->back()->with('error', 'Vui lòng chọn đúng định dạng file image và kích thước file nhỏ hơn 10M');
            }
        }
        $time = strtotime($request->input('month') . '/' . $request->input('day') . '/' . $request->input('year'));
        $birthday = date('Y-m-d', $time);
        $employee_slug = str_slug($request->input('employee_name')) . '-' . $employee->employee_id;

        $updateem_ployee = $employee_model->where('user_id', $id)->update([
            'employee_name' => $request->input('employee_name'),
            'employee_slug' => $employee_slug,
            'phone' => $request->input('phone'),
            'province' => $request->input('province'),
            'time_to_work' => $request->input('time_to_work'),
            'address' => $request->input('address'),
            'employee_level_id' => $request->input('employee_level_id'),
            'salary_id' => $request->input('salary_id'),
            'birthday' => $birthday,
            'employee_image' => $link_image,
            'gender' => $request->input('gender'),
            'marry' => $request->input('marry')
        ]);

        $user_model = new User();
        $update = $user_model->where('id', $id)->update([
            'name' => $request->input('employee_name'),
            'phone' => $request->input('phone'),
        ]);
        //cap nhat cong viec
        if (!empty($request->input('career_category_id'))) {
            //xoa su lieu cu va them lại
            $delete_carrer = Employee_career_categories::where('employee_id', $employee->employee_id)
                ->delete();
            $career_array = $request->input('career_category_id');
            foreach ($career_array as $career) {
                $insert_carrer = Employee_career_categories::insert([
                    'employee_id' => $employee->employee_id,
                    'career_category_id' => $career,
                    'created_at' => new \DateTime()
                ]);
            }
        }
        //cap nhat kinh nghiem
        //xoa su lieu cu va them lại
        $business_array = $request->input('business_type_id');
        if (is_array($business_array)) {
            $delete_business = Employee_business_type::where('employee_id', $employee->employee_id)
                ->delete();
            foreach ($business_array as $business) {
                $insert_business = Employee_business_type::insert([
                    'employee_id' => $employee->employee_id,
                    'business_type_id' => $business,
                    'created_at' => new \DateTime()
                ]);
            }
        }


        //cap nhat quan huyen
        if (!empty($request->input('district'))) {
            //xoa su lieu cu va them lại
            $delete_district = Employee_district::where('employee_id', $employee->employee_id)
                ->delete();
            $district_array = $request->input('district');
            foreach ($district_array as $district) {
                $insert_business = Employee_district::insert([
                    'employee_id' => $employee->employee_id,
                    'district_id' => $district,
                    'created_at' => new \DateTime()
                ]);
            }
        }
        //cap nhat lại ti le ho sơ

        $profile_info = Employee::get_profile_info($id);
        //update diểm lại cho 2 bảng
        $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
        //công điểm cho ứng viên
		if(empty($employee_profile))
		{
			 $insert_employee_profile = Employee_profile::insert([
                'employee_id' => $employee->employee_id,
                'profile_info' => $profile_info,
                'created_at' => new \DateTime()
            ]);
		}else
		{
			  //cộng lại điểm cho employee_profile
			$update_employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->update([
				'profile_info' => $profile_info,
				'updated_at' => new \DateTime()
			]);
		}
    
        $profile = $profile_info + $employee_profile->profile_cv + $employee_profile->profile_staff + $employee_profile->profile_course + $employee_profile->profile_avg;
        $update_employee = $employee_model->where('employee_id', $employee->employee_id)->update([
            'profile' => $profile,
            'status_employee' => $profile >= 40 ? 1 : 0,
            'updated_at' => new \DateTime()
        ]);


        $button_request = '';
        $button_request = $request->input('submit_form');
//        if ($button_request == 'btn_save_next') {
//
//        }
        return redirect(route('show_step_profile_employee'))->with('suscess', 'Cập nhật thông tin ứng viên thành công ! Vui lòng cập nhật thêm CV');

//        } catch (\Exception $e) {
//            return redirect()->back()->with('erorr', 'Cập nhật thông tin ứng viên thất bại');
//        }
    }

    //trinh do ung vien
    public function store_Specialize_Employee(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $this->statis_employee($id);
        try {
            $employee = new Employee();
            $emplo = $employee->select('employee_id')->where('user_id', $id)->first();
            $updateem_ployee = $employee->where('user_id', $id)->update([
                'status_employee_degree' => 1,
                'day_status_employee_degree' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $specialize = new Employee_specialize();
            $insert = $specialize->insertGetId([
                'star_specialize_time' => $request->input('star_specialize_time'),
                'end_specialize_time' => $request->input('end_specialize_time'),
                'school' => $request->input('school'),
                'majors' => $request->input('majors'),
                'leve' => $request->input('leve'),
                'specialize_status' => $request->input('specialize_status'),
                'employee_id' => $emplo->employee_id,
                'created_at' => new \DateTime()
            ]);
            $update = \App\Entity\Employee::get_user_id_Profile($id);
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ ứng viên thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ ứng viên thất bại');
        }
    }

    public function update_Specialize_Employee(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $this->statis_employee($id);
        try {
            DB::beginTransaction();
            $employee = new Employee();
            $emplo = $employee->select('employee_id', 'user_id')->where('user_id', $id)->first();
            $updateem_ployee = $employee->where('user_id', $id)->update([
                'status_employee_degree' => 1,
                'day_status_employee_degree' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $specialize = new Employee_specialize();

            $specialize_inputs = $request->input('specialize');
            $delete = $specialize->where('employee_id', $emplo->employee_id)->delete();
            if (!empty($specialize_inputs)) {
                foreach ($specialize_inputs as $id_input => $input) {
                    $specialize->insertGetId([
                        'star_specialize_time' => $input['star_specialize_time'],
                        'end_specialize_time' => $input['end_specialize_time'],
                        'school' => $input['school'],
                        'majors' => $input['majors'],
                        'leve' => $input['leve'],
                        'specialize_status' => $input['specialize_status'],
                        'employee_id' => $emplo->employee_id,
                        'created_at' => new \DateTime()
                    ]);

                }
            }
            $check_employee_specialize = $specialize->where('employee_id', $emplo->employee_id)->count();
            if (empty($check_employee_specialize)) {
                //cập nhật lại trạng thái hồ sơ
                $check_updateem_ployee = $employee->where('user_id', $id)->update([
                    'status_employee_degree' => 0,
                    'day_status_employee_degree' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ]);
            }
            $update = \App\Entity\Employee::get_user_id_Profile($id);
            DB::commit();
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ ứng viên thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ ứng viên thất bại');
        }
    }

    //quá trình làm việc
    public function store_Experience_Employee(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $this->statis_employee($id);
        try {
            $employee = new Employee();
            $emplo = $employee->where('user_id', $id)->first();

            $updateem_ployee = $employee->where('user_id', $id)->update([
                'status_employees_experience' => 1,
                'day_status_employees_experience' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);

            $experience = new Employee_experience();

            $insert = $experience->insertGetId([
                'star_working_time' => $request->input('star_working_time'),
                'end_working_time' => $request->input('end_working_time'),
                'company' => $request->input('company'),
                'type_of_business_id' => $request->input('type_of_business_id'),
                'business' => $request->input('business'),
                'position' => $request->input('position'),
                'des_position' => $request->input('des_position'),
                'employee_id' => $emplo->employee_id,
                'created_at' => new \DateTime()
            ]);
            $update = \App\Entity\Employee::get_user_id_Profile($id);
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thất bại');
        }
    }

    public function update_Experience_Employee(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $this->statis_employee($id);
        try {
            DB::beginTransaction();
            $employee = new Employee();
            $emplo = $employee->select('employee_id')->where('user_id', $id)->first();
            $updateem_ployee = $employee->where('user_id', $id)->update([
                'status_employees_experience' => 1,
                'day_status_employees_experience' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $experience = new Employee_experience();

            $experience_inputs = $request->input('experience');

            $delete = $experience->where('employee_id', $emplo->employee_id)->delete();

            if ($experience_inputs) {
                foreach ($experience_inputs as $id_input => $input) {
                    $experience->insertGetId([
                        'star_working_time' => $input['star_working_time'],
                        'end_working_time' => $input['end_working_time'],
                        'company' => $input['company'],
                        'type_of_business_id' => $input['type_of_business_id'],
                        'business' => $input['business'],
                        'position' => $input['position'],
                        'des_position' => $input['des_position'],
                        'employee_id' => $emplo->employee_id,
                        'created_at' => new \DateTime()
                    ]);

                }
            }
            $check_employee_experience = $experience->where('employee_id', $emplo->employee_id)->count();
            if (empty($check_employee_experience)) {
                //cập nhật lại trạng thái kinh nghiêm ứng viên
                $check_updateem_ployee = $employee->where('user_id', $id)->update([
                    'status_employees_experience' => 0,
                    'day_status_employees_experience' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ]);
            }
            $update = \App\Entity\Employee::get_user_id_Profile($id);
            DB::commit();
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thất bại');
        }
    }

    public function update_File_Employee(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $this->statis_employee($id);
//        echo $request->input('status');
        try {
            DB::beginTransaction();
            $employee = new Employee();
            $emplo = $employee->select('employee_id')->where('user_id', $id)->first();
            $updateem_ployee = $employee->where('user_id', $id)->update([
                'status' => $request->input('status'),
            ]);
            DB::commit();
            return redirect()->back()->with('suscess_file', 'Cập nhật trạng thái hồ sơ thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('suscess_file', 'Cập nhật trạng thái hồ sơ thất bại');
        }
    }

    // cap nhat ho so giao vien
    public function updateTeacher(Request $request)
    {
        $user = Auth::user();
        $email = Auth::user()->email;
        $id = Auth::user()->id;
        $validation = Validator::make($request->all(), [
            'teacher_name' => 'required',
            'teacher_phone' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'teacher_name.required' => 'Tên giáo viên không được bỏ trống',
            'teacher_phone.required' => 'Số điện thoại không được bỏ trống',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            $teacher = new Teacher();
            $tea = $teacher->select('teacher_id', 'slug', 'teacher_name', 'user_id')->where('user_id', $id)->first();
            $updateem_ployee = $teacher->where('user_id', $id)->update([
                'teacher_email' => $email,
                'teacher_name' => $request->input('teacher_name'),
                'gender' => $request->input('gender'),
                'address' => $request->input('address'),
                'teacher_phone' => $request->input('teacher_phone'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'information_verifier' => $request->input('information_verifier'),
                'teacher_images' => $request->has('images') ? $request->input('images') : '',
                'birthday' => $request->input('birthday'),
                'business_type_id' => $request->input('business_type_id')
            ]);

            $user_model = new User();
            $update = $user_model->where('id', $id)->update([
                'name' => $request->input('teacher_name'),
                'phone' => $request->input('teacher_phone'),
            ]);


            $job_group_id = $request->input('job_group_id');
            $teacher_job = new Teacher_job_group();
            $delete = $teacher_job->where('teacher_id', $tea->teacher_id)->delete();
            if ($job_group_id) {
                foreach ($job_group_id as $gruop_id) {
                    $insert = $teacher_job->insert([
                        'teacher_id' => $tea->teacher_id,
                        'job_group_id' => $gruop_id,
                        'created_at' => new \DateTime()
                    ]);
                }
            }

            $slug = Ultility::createSlug($request->input('teacher_name'));
            if (!empty(Teacher::where('slug', $slug)->first())) {
                $slug .= '-' . $tea->teacher_id;
            }
            Teacher::where('teacher_id', $tea->teacher_id)->update([
                'slug' => $slug
            ]);
            return redirect()->back()->with('suscess', 'Cập nhật thông tin giáo viên thành công ! Vui lòng cập nhật thêm trình độ chuyên môn ,  kinh nghiệm làm việc , công việc làm thêm');
        } catch (\Exception $e) {
            return redirect()->back()->with('erorr', 'Cập nhật thông tin giáo viên thất bại');
        }
    }

//    kinh nghiêm
    public function store_Experience_Teacher(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $employee = new Employee();
        try {
            $teacher = new Teacher();
            $tea = $teacher->where('user_id', $id)->first();

            $updateem_teacher = $tea->where('user_id', $id)->update([
                'status_teacher_experience' => 1,
                'day_status_teacher_experience' => new \DateTime()
            ]);

            $experience = new Teacher_experience();

            $insert = $experience->insertGetId([
                'star_working_time' => $request->input('star_working_time'),
                'end_working_time' => $request->input('end_working_time'),
                'company' => $request->input('company'),
                'position' => $request->input('position'),
                'des_position' => $request->input('des_position'),
                'teacher_id' => $tea->teacher_id,
                'created_at' => new \DateTime()
            ]);
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thất bại');
        }
    }

    public function update_Experience_Teacher(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        try {
            DB::beginTransaction();
            $teacher = new Teacher();
            $tea = $teacher->where('user_id', $id)->first();

            $updateem_ployee = $tea->where('user_id', $id)->update([
                'status_teacher_experience' => 1,
                'day_status_teacher_experience' => new \DateTime()
            ]);
            $experience = new Teacher_experience();

            $experience_inputs = $request->input('experience');
//            echo '<pre>';
//            print_r($experience_inputs);
//            echo '</pre>';die();
            $delete = $experience->where('teacher_id', $tea->teacher_id)->delete();


            if (!empty($experience_inputs)) {
                foreach ($experience_inputs as $id_input => $input) {

                    $experience->insertGetId([
                        'star_working_time' => $input['star_working_time'],
                        'end_working_time' => $input['end_working_time'],
                        'company' => $input['company'],
                        'position' => $input['position'],
                        'des_position' => $input['des_position'],
                        'teacher_id' => $tea->teacher_id,
                        'created_at' => new \DateTime()
                    ]);

                }
            }

            DB::commit();
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thất bại');
        }
    }

//trinh độ
    public function store_Specialize_Teacher(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        try {

            $teacher = new Teacher();
            $tea = $teacher->select('teacher_id')->where('user_id', $id)->first();
            $updateem_teacher = $teacher->where('user_id', $id)->update([
                'status_teacher_degree' => 1,
                'day_status_teacher_degree' => new \DateTime()
            ]);
            $specialize = new Teacher_specialize();
            $insert = $specialize->insertGetId([
                'star_specialize_time' => $request->input('star_specialize_time'),
                'end_specialize_time' => $request->input('end_specialize_time'),
                'school' => $request->input('school'),
                'majors' => $request->input('majors'),
                'leve' => $request->input('leve'),
                'specialize_status' => $request->input('specialize_status'),
                'teacher_id' => $tea->teacher_id,
                'created_at' => new \DateTime()
            ]);
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ giáo viên thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ giáo viên thất bại');
        }
    }

    public function update_Specialize_Teacher(Request $request)
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        try {
            DB::beginTransaction();
            $teacher = new Teacher();
            $tea = $teacher->select('teacher_id')->where('user_id', $id)->first();

            $updateem_teacher = $teacher->where('user_id', $id)->update([
                'status_teacher_degree' => 1,
                'day_status_teacher_degree' => new \DateTime()
            ]);
            $specialize = new Teacher_specialize();

            $specialize_inputs = $request->input('specialize');

            $delete = $specialize->where('teacher_id', $tea->teacher_id)->delete();
            if (!empty($specialize_inputs)) {
                foreach ($specialize_inputs as $id_input => $input) {
                    $specialize->insertGetId([
                        'star_specialize_time' => $input['star_specialize_time'],
                        'end_specialize_time' => $input['end_specialize_time'],
                        'school' => $input['school'],
                        'majors' => $input['majors'],
                        'leve' => $input['leve'],
                        'specialize_status' => $input['specialize_status'],
                        'teacher_id' => $tea->teacher_id,
                        'created_at' => new \DateTime()
                    ]);

                }
            }
            DB::commit();
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ ứng viên thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ ứng viên thất bại');
        }
    }

    //khoa hoc

    public function store_Course_Teacher(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'course_name' => 'required',
//            'images' => 'required',
            'course_intro' => 'required',
            'course_price' => 'required',
            'course_time' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'course_name.required' => 'Tên khóa học không được bỏ trống',
//            'images.required' => 'Ảnh mô tả không được bỏ trống',
            'course_intro.required' => 'Giới thiệu không được bỏ trống',
            'course_price.required' => 'Giá khóa học không được để trống',
            'course_time.required' => 'Thời gian về khóa học không được để trống',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        $user = Auth::user();
        $user_id = Auth::user()->id;
        try {
            DB::beginTransaction();

            $teacher = new Teacher();
            $teacher = $teacher->select('teacher_id', 'user_id')->where('user_id', $user_id)->first();

            $course = new Course();
            $teacher_course = $course->select('*')->where('course_id', $teacher->course_id)->first();

            $slug = Ultility::createSlug($request->input('course_name'));
            $course_id = $course->insertGetId([
                'course_name' => $request->input('course_name'),
                'course_image' => $request->input('course_image'),
                'course_intro' => $request->input('course_intro'),
                'course_content' => $request->input('course_content'),
                'course_price' => !empty($request->input('course_price')) ? str_replace(".", "", $request->input('course_price')) : 0,
                'course_time' => $request->input('course_time'),
                'course_image' => $request->has('images') ? $request->input('images') : '',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            ]);
            $this->code_exam($course_id);
            // insert slug
            $jobWithSlug = $course->where('slug', $slug)->first();
            if (empty($jobWithSlug)) {
                $course->where('course_id', '=', $course_id)
                    ->update([
                        'slug' => $slug
                    ]);
            } else {
                $course->where('course_id', '=', $course_id)
                    ->update([
                        'slug' => $slug . '-' . $course_id
                    ]);
            }
            $teacher = new Teacher();
            $teacher = $teacher->select('teacher_id')->where('user_id', $user_id)->first();
            $delete = $course->where('course_id', $teacher->course_id)->delete();
            $update = $teacher->where('user_id', $user_id)->update(['course_id' => $course_id]);

//
            DB::commit();
            return redirect()->back()->with('suscess_course', 'Cập nhật khóa học thành công', 'user');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('suscess_course', 'Cập nhật khóa học thất bại');
        }
    }

    public function update_Course_Teacher(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'course_name' => 'required',
//            'images' => 'required',
            'course_intro' => 'required',
            'course_price' => 'required',
            'course_time' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'course_name.required' => 'Tên khóa học không được bỏ trống',
//            'images.required' => 'Ảnh mô tả không được bỏ trống',
            'course_intro.required' => 'Giới thiệu không được bỏ trống',
            'course_price.required' => 'Giá khóa học không được để trống',
            'course_time.required' => 'Thời gian về khóa học không được để trống',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        $user = Auth::user();
        $user_id = Auth::user()->id;
        try {
            DB::beginTransaction();

            $teacher = new Teacher();
            $teacher = $teacher->select('teacher_id', 'user_id', 'course_id')->where('user_id', $user_id)->first();

//
            $course = new Course();

            $slug = Ultility::createSlug($request->input('course_name'));
            $course_id = $course->where('course_id', $teacher->course_id)->update([
                'course_name' => $request->input('course_name'),
                'course_image' => $request->input('course_image'),
                'course_intro' => $request->input('course_intro'),
                'course_content' => $request->input('course_content'),
                'course_price' => !empty($request->input('course_price')) ? str_replace(".", "", $request->input('course_price')) : 0,
                'course_time' => $request->input('course_time'),
                'course_image' => $request->has('images') ? $request->input('images') : '',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            ]);
            // insert slug
            $jobWithSlug = $course->where('slug', $slug)->first();
            if (empty($jobWithSlug)) {
                $course->where('course_id', '=', $course_id)
                    ->update([
                        'slug' => $slug
                    ]);
            } else {
                $course->where('course_id', '=', $course_id)
                    ->update([
                        'slug' => $slug . '-' . $course_id
                    ]);
            }
//
            DB::commit();
            return redirect()->back()->with('suscess_course', 'Cập nhật khóa học thành công', 'user');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('suscess_course', 'Cập nhật khóa học thất bại');
        }
    }

    //tao ma khoa hoc
    public function code_exam($course_id)
    {
        $id_course = intval($course_id);
        $course_code = 'KH' . ($id_course + 100);
        Course::where('course_id', $course_id)->update([
            'course_code' => $course_code,
        ]);
    }

//    nha tuyển dụng
    public function list_Candidate_Employee(Request $request)
    {
        $user = Auth::user();
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user_id = Auth::user()->id;
        $jobFacebooks = JobFacebook::select('job_facebook.*', 'province.province_name', 'district.district_name', 'users.name')
            ->leftJoin('province', 'province.province_id', '=', 'job_facebook.province')
            ->leftJoin('district', 'district.district_id', '=', 'job_facebook.district')
            ->leftJoin('users', 'users.id', '=', 'job_facebook.user_id')
            ->where('job_facebook.user_id', $user_id)
            ->orderBy('job_facebook_id', 'desc')
            ->paginate(10);


        $salaries = Salary::orderBy('salary_id')->get();
        return view('site.job_facebook.list_cadidate_job_fb', compact('jobFacebooks', 'salaries', 'user'));

    }

    public function detail_Candidate_Employee(Request $request, $job_facebook_id)
    {
        $user = Auth::user();
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để sử dụng chức năng này !');
        }
        $jobFacebook = JobFacebook::select('job_facebook.*', 'province.province_name', 'district.district_name', 'users.name')
            ->leftJoin('province', 'province.province_id', '=', 'job_facebook.province')
            ->leftJoin('district', 'district.district_id', '=', 'job_facebook.district')
            ->leftJoin('users', 'users.id', '=', 'job_facebook.user_id')
            ->where('job_facebook.job_facebook_id', $job_facebook_id)
            ->first();

        $employees = new Employee();
        $list_employee = $employees->select('employees.employee_id',
            'employees.employee_name',
            'employees.email',
            'employees.phone',
            'employees.province',
            'employees.district',
            'employees.address')
            ->rightJoin('employee_submit_job_facebook', 'employee_submit_job_facebook.employee_id', 'employees.employee_id')
            ->where('employee_submit_job_facebook.id_job_fb', $job_facebook_id)
            ->paginate(15);
        return view('site.job_facebook.list_cadidate_user_submit', compact('jobFacebook', 'list_employee', 'user', 'job_facebook_id'));

    }

    //thong tin của ung viên
    public function detail_Submit_Employee($employee_id)
    {
        $user = Auth::user();
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để sử dụng chức năng này !');
        }
        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();
        //trinh do chuyen mon
        $specialize = new Employee_specialize();
        $specialize = $specialize->select('*')->where('employee_id', $employee_id)->orderBy('specialize_id', 'asc')->get();
//            Kinh nghiệm làm việc
        $experience = new Employee_experience();
        $experience = $experience->select('*')->where('employee_id', $employee_id)->orderBy('experience_id', 'asc')->get();

        if (!empty($employee)) {
            return view('site.job_facebook.detail_submit_employee', compact('user', 'employee', 'specialize', 'experience'));
        } else {
            return redirect()->back();
        }
    }

    public function show_profile_Employee($submit_job_fb_id)
    {
        try {
            $user = Auth::user();
            if (!$this->checkRoleUser()) {
                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để sử dụng chức năng này !');
            }
            $employer_id = Employer::where('user_id',$user->id)->value('employer_id');
            $submit_job_employee_model = new Employee_submit_job_faacebook();
            $submit_job_employee = $submit_job_employee_model->select('employee_submit_job_facebook.*', 'employees.employee_id', 'employees.employee_name')
                ->join('employees', 'employees.employee_id', '=', 'employee_submit_job_facebook.employee_id')
                ->join('jobs', 'jobs.job_id', '=', 'employee_submit_job_facebook.id_job_fb')
                ->where('employee_submit_job_facebook.submit_job_fb_id', $submit_job_fb_id)
                ->where('jobs.employer_id', $employer_id)
                ->first();
            $employee = Employee::select(
                'employees.*',
                'salary.description',
                'province.province_name')
                ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
                ->leftJoin('province', 'province.province_id', '=', 'employees.province')
                ->where('employees.employee_id', $submit_job_employee->employee_id)
                ->first();
            $view = $employee->views + 1;
            $update_view = Employee::where('employees.employee_id', $submit_job_employee->employee_id)->update([
                'views' => $view
            ]);
            //điểm của ứng viên
            $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
            //check xem thong tin hồ sơ
            $check_profile_intro = Staff_status_job_submit_employee::where('submit_job_fb_id', $submit_job_fb_id)->count();
            if (!empty($check_profile_intro)) {
                $employer_id = Employer::where('user_id', $user->id)->value('employer_id');
                $inser_coin_show_employee = Coin_show_employee::insertGetId([
                    'coin_history_id' => 0,
                    'employer_id' => $employer_id,
                    'employee_id' => $submit_job_employee->employee_id,
                    'created_at' => new \DateTime()
                ]);
            }
//            echo '<pre>';
//            print_r($employee_profile);die;

            //gui thong bao cho ung vien
            $job_user = new JobUserController();
            //$status,$submit_job_fb_id,$employer_id ; 1 là đã xem
            $note = $job_user->note_status_profile(1,$submit_job_fb_id,$employer_id);

            return view('site.employee_site.job_submit_detail_employee', compact('employee', 'employee_profile', 'submit_job_employee'));
        } catch (\Exception $e) {
            return redirect(route('list_Job_Candidate_Employee'))->with('error', 'Ứng viên này không tồn tại');
        }
    }

    //luu trang thai ho so trong xem ho so trang thai
    public function save_id_status_submit_job(Request $request)
    {
        $user = Auth::user();
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Chức năng này danh cho nha tuyển dụng');
        }
        $status = $request->input('id_status_submit_job');
        $submit_job_fb_id = $request->input('submit_job_fb_id');
//        quyen ung vien
        $employee_submit_job_model = new Employee_submit_job_faacebook();
        $employee_submit_job = $employee_submit_job_model->select(
            'employee_submit_job_facebook.*', 'employees.employee_id', 'employees.user_id'
        )->join('employees', 'employees.employee_id', '=', 'employee_submit_job_facebook.employee_id')
            ->where('employee_submit_job_facebook.submit_job_fb_id', $submit_job_fb_id)
            ->first();

        //kiểm tra xem tin này có phải nhà tuyển dụng đăng k
        $check_employer_job = Job::select('employer_id')->where('job_id', $employee_submit_job->id_job_fb)->first();
        if (!empty($check_employer_job) && $employee_submit_job->status_job == 1) {
            $update = $employee_submit_job_model->where('employee_submit_job_facebook.submit_job_fb_id', $employee_submit_job['submit_job_fb_id'])
                ->update([
                    'id_status_submit_job' => $status
                ]);

            if ($status == 1)
            {
                $employee_email = Employee::where('employee_id',$employee_submit_job->employee_id)->value('email');
                $mail = MailConfigController::send_email_view_profile_employee($employee_submit_job->id_job_fb, $employee_email);
            }
            if ($status == 4) {
                $job = Job::select('slug', 'title', 'job_id', 'employer_id')->where('job_id', $employee_submit_job['id_job_fb'])->first();
                $employee = Employee::select('employee_id', 'email')->where('employee_id', $employee_submit_job->employee_id)->first();
                //job là nội dung công việc cần title ,slug
                //$email là email gửi thu
                MailConfigController::send_delete_file($job, $employee['email']);
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
                //gui thong bao cho ung vien
                $job_user = new JobUserController();
                //$status,$submit_job_fb_id,$employer_id ; 4 la loại ho sơst
                $employer_id = Employer::where('user_id',$user->id)->value('employer_id');
                $note = $job_user->note_status_profile(4,$submit_job_fb_id,$employer_id);
            }
            return redirect()->back()->with('mesage_modal', 'Lưu trạng thái hồ sơ thành công');
        } else {
            return redirect()->back()->with('mesage_modal', 'Lưu trạng thái hồ sơ thất bại');
        }
    }

    //hien thi thong tin CV
    public function show_cv_Employee($submit_job_fb_id)
    {
        try {
            $user = Auth::user();
            if (!$this->checkRoleUser()) {
                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để sử dụng chức năng này !');
            }

            $submit_job_employee_model = new Employee_submit_job_faacebook();
            $submit_job_employee = $submit_job_employee_model->select('employee_submit_job_facebook.*', 'employees.employee_id', 'employees.employee_name')
                ->join('employees', 'employees.employee_id', '=', 'employee_submit_job_facebook.employee_id')
                ->where('employee_submit_job_facebook.submit_job_fb_id', $submit_job_fb_id)
                ->first();


            $employees = new Employee();
            $employee = $employees->select('*')->where('employee_id', $submit_job_employee->employee_id)->first();
            $employee_id = $employee->employee_id;

            $cv_template = Cv_template::select('*')->first();
            $cv_note_template = Cv_note_template::select('*')->where('cv_template_id', $cv_template->cv_template_id)->first();
            $check_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->count();
            if (!empty($check_employee)) {
                $cv_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();
//            echo '<pre>';
//            print_r($cv_employee);die();
                return view('site.employee.show_employee_cv', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee', 'experience', 'specialize', 'employee_id', 'submit_job_fb_id'));
            }
            return redirect(route('show_profile_Employee', ['submit_job_fb_id' => $submit_job_fb_id]))->with('error', 'Ứng viên này chưa tạo CV');

//            return view('site.employee.show_cv_Employee', compact('user', 'employee', 'specialize', 'experience', 'submit_job_employee'));


        } catch (\Exception $e) {
            return redirect(route('list_Job_Candidate_Employee'))->with('error', 'Ứng viên này không tồn tại');
        }
    }


    //hien thi thong tin syll
    public function show_syll_Employee($submit_job_fb_id)
    {
        try {
            $user = Auth::user();
            if (!$this->checkRoleUser()) {
                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để sử dụng chức năng này !');
            }

            $submit_job_employee_model = new Employee_submit_job_faacebook();
            $submit_job_employee = $submit_job_employee_model->select('employee_submit_job_facebook.*', 'employees.employee_id', 'employees.employee_name')
                ->join('employees', 'employees.employee_id', '=', 'employee_submit_job_facebook.employee_id')
                ->where('employee_submit_job_facebook.submit_job_fb_id', $submit_job_fb_id)
                ->where('employee_submit_job_facebook.status_syll', 1)
                ->first();


            $employees = new Employee();
            $employee = $employees->select('*')->where('employee_id', $submit_job_employee->employee_id)->first();
            $employee_curriculum = '';
            $employee_curriculum = Employee_curriculum::select('employee_curriculum.*', 'employee_curriculum_extend.*')
                ->leftJoin('employee_curriculum_extend', 'employee_curriculum_extend.employee_id', 'employee_curriculum.employee_id')
                ->where('employee_curriculum.employee_id', $employee->employee_id)
                ->first();
            if (!empty($employee_curriculum)) {
                return view('site.employee.show_syll_employee', compact('employee', 'employee_curriculum', 'submit_job_fb_id'));
            }
            return redirect(route('show_profile_Employee', ['submit_job_fb_id' => $submit_job_fb_id]))->with('error', 'Ứng viên này chưa tạo CV');

//            return view('site.employee.show_cv_Employee', compact('user', 'employee', 'specialize', 'experience', 'submit_job_employee'));


        } catch (\Exception $e) {
            return redirect(route('list_Job_Candidate_Employee'))->with('error', 'Ứng viên này không tồn tại');
        }
    }


    public function show_profile_Employee_intership($intership_id)
    {
        try {
            $user = Auth::user();
            if (!$this->checkRoleUser()) {
                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để sử dụng chức năng này !');
            }
            $intership_model = new EmployerIntership();
            $intership = $intership_model->select('*')->where('intership_id', $intership_id)->first();

            $employees = new Employee();
            $employee = $employees->select('*')->where('employee_id', $intership->employee_id)->first();
            //trinh do chuyen mon


            return view('site.employee.show_profile_Employee_intership', compact('user', 'employee', 'intership', 'intership_id'));
        } catch (\Exception $e) {
            return redirect(route('list_Job_Candidate_Employee'))->with('error', 'Ứng viên này không tồn tại');
        }
    }

    public function intership_show_cv_Employee($intership_id)
    {
        try {
            $user = Auth::user();
            if (!$this->checkRoleUser()) {
                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để sử dụng chức năng này !');
            }
            $intership_model = new EmployerIntership();
            $intership = $intership_model->select('*')->where('intership_id', $intership_id)->first();

            $employees = new Employee();
            $employee = $employees->select('*')->where('employee_id', $intership->employee_id)->first();
            //trinh do chuyen mon


            //tong phần tram hồ sơ
            //$user_id là id trong user
            $profile = \App\Entity\Employee::get_user_id_Profile($employee->user_id);
            return view('site.employee.show_cv_intership', compact('user', 'employee', 'intership', 'intership_id'));
        } catch (\Exception $e) {
            return redirect(route('list_Job_Candidate_Employee'))->with('error', 'Ứng viên này không tồn tại');
        }
    }

    public function intership_show_syll_Employee($intership_id)
    {
        try {
            $user = Auth::user();
            if (!$this->checkRoleUser()) {
                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để sử dụng chức năng này !');
            }
            $intership_model = new EmployerIntership();
            $intership = $intership_model->select('*')->where('intership_id', $intership_id)->first();

            $employees = new Employee();
            $employee = $employees->select('*')->where('employee_id', $intership->employee_id)->first();
            //trinh do chuyen mon


            //tong phần tram hồ sơ
            //$user_id là id trong user
            $profile = \App\Entity\Employee::get_user_id_Profile($employee->user_id);
            return view('site.employee.show_syll_intership', compact('user', 'employee', 'intership', 'intership_id'));
        } catch (\Exception $e) {
            return redirect(route('list_Job_Candidate_Employee'))->with('error', 'Ứng viên này không tồn tại');
        }
    }


//    kêt quả thi của ứng viên

    public function detail_Submit_Teacher($teacher_id)
    {
        $user = Auth::user();
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để sử dụng chức năng này !');
        }
        $teachers = new Teacher();
        $teacher = $teachers->select('*')->where('teacher_id', $teacher_id)->first();
        //trinh do chuyen mon
        $specialize = new Teacher_specialize();
        $specialize = $specialize->select('*')->where('teacher_id', $teacher_id)->orderBy('specialize_id', 'asc')->get();
//            Kinh nghiệm làm việc

        $experience = new Teacher_experience();
        $experience = $experience->select('*')->where('teacher_id', $teacher_id)->orderBy('experience_id', 'asc')->get();
        if (!empty($teacher)) {
            return view('site.job_facebook.detail_submit_teacher', compact('user', 'teacher', 'specialize', 'experience'));
        } else {
            return redirect()->back();
        }


    }

    public function check_user_role()
    {
        if (Auth::check() && Auth::user()->role == 2) {
            $user_id = Auth::user()->id;
            $employer = Employer::select('employer_id',
                'enterprise_name',
                'phone',
                'email',
                'employer_coin',
                'total_employer_coin',
                'total_money_coin',
                'user_id')->where('user_id', $user_id)->first();
            return $employer;
        }
        return false;
    }

    //thong ke
    public function statis_employee($id)
    {
        $employee = new Employee();
        $employees = $employee->select('employee_id', 'user_id')->where('user_id', $id)->first();

        $statiscals = new Statistical_employees();
        $statis = $statiscals->select('*')->where('employees_id', $employees->employee_id)->first();
//        print_r($employees);
        if (empty($statis)) {
            $total_cv = 1;
            $statiscal = $statiscals->insert([
                'employees_id' => $employees->employee_id,
                'total_cv' => $total_cv
            ]);
//            where('employees_id', $employees->employee_id)->update([
//                'total_cv' => $total_cv
        } else {

            $total_cv = $statis->total_cv + 1;
            $statiscal = $statiscals->where('employees_id', $employees->employee_id)->update([
                'total_cv' => $total_cv
            ]);
        }


    }

    //dich vu don hang tuyển dụng
    public function show_service_price()
    {
        $id = Auth::user()->id;
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user_id = Auth::user()->id;
        $user = Auth::user();
        $employer = new Employer();
        $employer_id = $employer->select('*')->where('user_id', $id)->value('employer_id');
        $hunter_registration = Hunter_registration::where('employer_id',$employer_id)->paginate(20);
        return view('site.job_facebook_site.show_service_price', compact('user','hunter_registration'));
    }
    public function show_service_profile_job()
    {
        $id = Auth::user()->id;
        if (!$this->checkRoleUser()) {
            return redirect(route('list_job_face'))->with('error_login', 'Vui lòng đăng kí thành nhà tuyển dụng để có thể đăng tin !');
        }
        $user_id = Auth::user()->id;
        $user = Auth::user();
        $employer = new Employer();
        $employer_id = $employer->select('*')->where('user_id', $id)->value('employer_id');
        $service_order = Service_order::where('employer_id',$employer_id)->paginate(20);
        return view('site.job_facebook_site.show_service_profile_job', compact('user','service_order'));
    }
}
