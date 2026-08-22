<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Employee;
use App\Entity\Employee_coins;
use App\Entity\Employee_experience;
use App\Entity\Employee_specialize;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\EmployeeCareerCategories;
use App\Entity\Employees_save_job_facebook;
use App\Entity\EmployeeSoftware;
use App\Entity\Employer;
use App\Entity\EmployerAgency;
use App\Entity\EmployerBusiness;
use App\Entity\EmployerIntership;
use App\Entity\EmployerRepresentative;
use App\Entity\EmployerTransaction;
use App\Entity\EmployerTypeBusiness;
use App\Entity\Forum_notification;
use App\Entity\Forum_post;
use App\Entity\Forum_post_comment;
use App\Entity\Job;
use App\Entity\JobFacebook;
use App\Entity\NoteEmployee;
use App\Entity\Post_sale_statistical;
use App\Entity\StarEmployer;
use App\Entity\Statistical_employees;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_job_group;
use App\Entity\Teacher_save_job_facebook;
use App\Entity\Teacher_specialize;
use App\Entity\Teacher_submit_job_faacebook;
use App\Entity\TeacherLearnEmployees;
use App\Entity\TeacherStar;
use App\Entity\TeacherStarLearn;
use App\Entity\User;
use App\Exam\CommentExam;
use App\Exam\Exam;
use App\Exam\Questions;
use App\Exam\StarExam;
use App\Http\Controllers\Site\MailConfigController;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;

class UserController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;

            if (!User::isManager($this->role) && !User::isCreater($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'customers');

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
//        try {
        $user = Auth::user();
        if (User::isCreater($user->role)) {
            $users_model = new User();
            $users = $users_model->select('id',
                'email',
                'password',
                'remember_token',
                'accesstoken',
                'phone',
                'image',
                'role',
                'name',
                'gender',
                'age',
                'address',
                'point',
                'provider',
                'provider_id',
                'created_at',
                'updated_at',
                'deleted_at',
                'reset_password',
                'level',
                'is_bank',
                'status_email_account',
                'link_confirm_account');
            if ($request->input('role')) {
                $role = $request->input('role');
                $users = $users->where('role', $role);
            }
            if ($request->input('status_email_account')) {
                $status_email_account = $request->input('status_email_account');
                $users = $users->where('status_email_account', $status_email_account);
            }
            if ($request->input('email')) {
                $email = $request->input('email');
                $users = $users->where('email', 'like', '%' . $email . '%');
            }

            $users = $users->orderBy('id', 'desc');


            $total_user = $users->count();

            $users = $users->paginate(20);
            $users = $users->appends(request()->query());

//            $total_employee = Employee::count();
//            $sum_employee = User::where('role', 1)->count();
//
//            $total_employer = Employer::count();
//            $sum_employer = User::where('role', 2)->count();
//
//
//            $total_teacher = Teacher::count();
//            $sum_teacher = User::where('role', 3)->count();
//
//            $total_admin = User::where('role', 4)->count();

        } else {
            $users = User::orderBy('id', 'desc')->paginate(20);
        }

//        echo '</pre>';
//        print_r($users);die();
        return View('admin.user.list', compact('users'));

//        } catch (\Exception $e) {
//            Error::setErrorMessage('Lỗi xảy ra khi hiển thị thành viên: dữ liệu không hợp lệ.');
//            Log::error('http->admin->UserController->index: Lỗi xảy ra trong quá trình hiển thị thành viên');
//
//            return redirect('admin/home');
//        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users|unique:users|unique:employees|unique:employer',
        ], [
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
        ]);
        // if validation fail return error
        if ($validation->fails()) {
            return redirect('admin/users/create')
                ->withErrors($validation)
                ->withInput();
        }
//        try {
        $user_model = new User();
        if ($request->input('role') == 1) {
            $get_id = $user_model->insertGetId([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
                'image' => $request->input('image'),
                'name' => $request->input('name'),
                'role' => $request->input('role'),
                'status_email_account' => 0,
                'created_at' => new \DateTime(),
            ]);
            $employee_model = new Employee();
            $insert = $employee_model->insert([
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'employee_image' => $request->input('image'),
                'employee_name' => $request->input('name'),
                'user_id' => $get_id,
                'created_at' => new \DateTime(),
                'status' => 0,
                'salary_id' => 6,
                'career_category_id' => 1,
            ]);

            $link_confirm_account = str_random(10) . $get_id;
            $update = $user_model->where('id', $get_id)->update([
                'link_confirm_account' => $link_confirm_account
            ]);
            $userWithPhone = $user_model->select('name', 'email', 'password', 'phone', 'status_email_account', 'id', 'link_confirm_account')->where('id', $get_id)->first();

            MailConfigController::send_email_employee_confirm($userWithPhone);
//                cấu hình gửi email kích hoạt
        }
        if ($request->input('role') == 2) {
            $get_id = $user_model->insertGetId([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
                'image' => $request->input('image'),
                'name' => $request->input('name'),
                'role' => $request->input('role'),
                'status_email_account' => 0,
                'created_at' => new \DateTime(),
            ]);
            $employerModel = new Employer();
            // thêm mới nhà tuyển dụng
            $employerID = $employerModel->insertGetId([
                'enterprise_name' => $request->input('name'),
                'user_id' => $get_id,
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
            ]);
            $slug = Ultility::createSlug($request->input('name'));
            if (!empty(Employer::where('slug', $slug)->first())) {
                $slug .= '-' . $employerID;
            }
//        $employer_id = $employerID.'NTD'.$userWithPhone->id;
//        'employer_id' => $employer_id
            Employer::where('employer_id', $employerID)->update([
                'slug' => $slug
            ]);

            $link_confirm_account = str_random(10) . $get_id;
            $update = $user_model->where('id', $get_id)->update([
                'link_confirm_account' => $link_confirm_account
            ]);
            $userWithPhone = $user_model->select('name', 'email', 'password', 'phone', 'status_email_account', 'id', 'link_confirm_account')->where('id', $get_id)->first();

            MailConfigController::send_email_employer_confirm($userWithPhone);
//                cấu hình gửi email kích hoạt
        }
        if ($request->input('role') == 3) {
            $get_id = $user_model->insertGetId([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
                'image' => $request->input('image'),
                'name' => $request->input('name'),
                'role' => $request->input('role'),
                'status_email_account' => 0,
                'created_at' => new \DateTime(),
            ]);

            $teacherMoel = new Teacher();
            $teacherId = $teacherMoel->insertGetId([
                'teacher_name' => $request->input('name'),
                'user_id' => $get_id,
                'teacher_phone' => $request->input('phone'),
                'teacher_email' => $request->input('email'),
                'created_at' => new \DateTime(),
            ]);
            $slug = Ultility::createSlug($request->input('teacher_name'));
            if (!empty(Teacher::where('slug', $slug)->first())) {
                $slug .= '-' . $teacherId;
            }
            Teacher::where('teacher_id', $teacherId)->update([
                'slug' => $slug
            ]);

            $link_confirm_account = str_random(10) . $get_id;
            $update = $user_model->where('id', $get_id)->update([
                'link_confirm_account' => $link_confirm_account
            ]);
            $userWithPhone = $user_model->select('name', 'email', 'password', 'phone', 'status_email_account', 'id', 'link_confirm_account')->where('id', $get_id)->first();

            MailConfigController::send_email_teacher_confirm($userWithPhone);
//                cấu hình gửi email kích hoạt
        }
        if ($request->input('role') == 4) {
            $get_id = $user_model->insertGetId([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
                'image' => $request->input('image'),
                'name' => $request->input('name'),
                'role' => $request->input('role'),
                'status_email_account' => 0,
                'created_at' => new \DateTime(),
            ]);
            $link_confirm_account = str_random(10) . $get_id;
            $update = $user_model->where('id', $get_id)->update([
                'link_confirm_account' => $link_confirm_account
            ]);
            $userWithPhone = $user_model->select('name', 'email', 'password', 'phone', 'status_email_account', 'id', 'link_confirm_account')->where('id', $get_id)->first();

            MailConfigController::send_email_teacher_confirm($userWithPhone);
//                cấu hình gửi email kích hoạt
        }
        return redirect(route('users.index'));
        // insert to database
//        } catch (\Exception $exception) {
//            Error::setErrorMessage('Lỗi xảy ra khi thêm mới thành viên: dữ liệu không hợp lệ.');
//            Log::error('http->admin->UserController->store: Lỗi xảy ra trong quá trình thêm mới thành viên');
//        } finally {
//            return redirect(route('users.index'));
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
//        print_r($user);die();
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Entity\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        try {
            $validation = Validator::make($request->all(), [
                'email' => Rule::unique('users')->ignore($user->id, 'id'),
            ]);
            $user_login = Auth::user();
            if (User::isCreater($user_login->role)) {
                $isChangePassword = $request->input('is_change_password');
                if ($isChangePassword == 1) {
                    $user->update([
                        'password' => bcrypt($request->input('password'))
                    ]);
                }
                // update to database

                $user->update([
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'image' => $request->input('image'),
                    'name' => $request->input('name'),
                    'updated_at' => new \DateTime()
                ]);
                $employee_model = new Employee();
                $update = $employee_model->where('user_id', $user->id)->update([
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'employee_image' => $request->input('image'),
                    'employee_name' => $request->input('name'),
                    'updated_at' => new \DateTime()
                ]);
            }
            return redirect(route('users.index'));
        } catch (\Exception $exception) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa thành viên: dữ liệu không hợp lệ.');
            Log::error('http->admin->UserController->update: Lỗi xảy ra trong quá trình chỉnh sửa thành viên');
        } finally {
            return redirect('admin/users');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {
                //xoa ứng viên
                if ($user->role == 1) {
                    Employee::where('user_id', $user->id)->delete();
                }
                if ($user->role == 2) {

                    $employer = Employer::select('employer_id', 'user_id')->where('user_id', $user->id)->first();
                    //xóa tin tuyển dụng
                    $delete = Job::where('employer_id', $employer->employer_id)->delete();
                    $delete = JobFacebook::where('employer_id', $employer->employer_id)->delete();
                    Employer::where('user_id', $user->id)->delete();
                }
                if ($user->role == 3) {
                    Teacher::where('user_id', $user->id)->delete();
                }
                $delete_forum_post = Forum_post::where('for_user_id',$user->id)->delete();
                $delete_forum_comment = Forum_post_comment::where('user_id',$user->id)->delete();
                $delete_forum_noti = Forum_notification::where('user_id',$user->id)->delete();


                User::where('id', $user->id)->delete();
            }
            return redirect('admin/users');
        } catch (\Exception $exception) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa thành viên: dữ liệu không hợp lệ.');
            Log::error('http->admin->UserController->destroy: Lỗi xảy ra trong quá trình xóa thành viên');
        }
    }

    public function listUserDelete(Request $request)
    {
        $user_model = new User();
        $users = $user_model->onlyTrashed();

        if(!empty($request->input('email')))
        {
            $users = $users->where('email',$request->input('email'));
        }
        $users = $users->orderBy('id', 'desc');
        $total_user = $users->count();
        $users = $users->paginate(30);

        return View('admin.user.list_delete', compact('users', 'total_user'));

    }

    public function Userrestore(Request $request, $id)
    {
//        try {
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {
                $user_model = new User();
                $restore = $user_model->withTrashed()->where('id', $id)->restore();
                $user = $user_model->where('id', $id)->first();

                if ($user['role'] == 1) {
                    $employee_model = new Employee();
                    $restore_employee = $employee_model->withTrashed()->where('user_id', $id)->restore();
                }
                if ($user['role'] == 2) {
                    $employer_model = new Employer();
                    $restore_employer = $employer_model->withTrashed()->where('user_id', $id)->restore();
                    $employer = Employer::select('employer_id', 'user_id')->where('user_id', $user->id)->first();
                    $delete = Job::withTrashed()->where('employer_id', $employer->employer_id)->restore();
                    $delete = JobFacebook::withTrashed()->where('employer_id', $employer->employer_id)->restore();

                }
                if ($user['role'] == 3) {
                    $teacher_model = new Teacher();
                    $restore_teacher = $teacher_model->withTrashed()->where('user_id', $id)->restore();
                }

//                $delete_forum_post = Forum_post::withTrashed()->where('for_user_id',$id)->restore();
//                $delete_forum_comment = Forum_post_comment::withTrashed()->where('user_id',$id)->restore();
//                $delete_forum_noti = Forum_notification::withTrashed()->where('user_id',$id)->restore();
                //khoi phuc ban ghi
                DB::commit();
                return redirect(route('listUserDelete'))->with('success', 'Khôi phục thành công');
            }
//        } catch (\Exception $exception) {
//            DB::rollBack();
//            return redirect(route('listUserDelete'))->with('error', 'Khôi phục thất bại');
//        }


    }

    public function UserForceDelete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $userLogin = Auth::user();

            if ($userLogin->role == 4) {
                $user_model = new User();
                $delete_user = $user_model->where('id', $id)->delete();
                $user = $user_model->onlyTrashed()->where('id', $id)->first();

//            xóa ứng viên và xóa vĩnh viễn


//
                if ($user['role'] == 1) {
                    $delete = \App\Http\Controllers\Admin\UserController::deleteEmployee($id);

                }
                if ($user['role'] == 2) {
                    $delete = \App\Http\Controllers\Admin\UserController::deleteEmployer($id);

                }
                if ($user['role'] == 3) {
                    $delete = \App\Http\Controllers\Admin\UserController::deleteTeacher($id);
                }
                //đánh giá ntd
                $star_employer = new StarEmployer();
                $star_employer = $star_employer->where('id_user', $id)->delete();

                //đánh giá đề thi
                $star_exam = new StarExam();
                $star_exam = $star_exam->where('id_user', $id)->delete();

                //đánh giá giáo viên
                $star_teacher = new TeacherStar();
                $star_teacher = $star_teacher->where('id_user', $id)->delete();

                //bình luận đề thi
                $comment_exam = new CommentExam();
                $comment_exam = $comment_exam->where('id_user', $id)->delete();

                //người tạo đề thi phần này xử lý sau
//                $exam = new Exam();
//                $list_exam = $exam->where('id_user',$id)->get();
//
//                $questions = new Questions();
//                foreach($list_exam as $l_exam)
//                {
//                    $delete = $questions->where('id_exam',$l_exam->id_exam)->delete();
//                }
//                $exam = $exam->where('id_user',$id)->delete();

                $delete_forum_post = Forum_post::withTrashed()->where('for_user_id',$id)->forceDelete();
                $delete_forum_comment = Forum_post_comment::withTrashed()->where('user_id',$id)->forceDelete();
                $delete_forum_noti = Forum_notification::withTrashed()->where('user_id',$id)->forceDelete();

                $forceDelete = $user_model->withTrashed()
                    ->where('id', $id)
                    ->forceDelete();
            }
            DB::commit();
            return redirect(route('listUserDelete'))->with('success', 'Xóa vĩnh viễn thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listUserDelete'))->with('error', 'Xóa vĩnh viễn thất bại');
        }

    }

    public static function deleteEmployee($id)
    {
        $employee_model = new Employee();
        $delete_employee = $employee_model->where('user_id', $id)->delete();
        $employee = $employee_model->onlyTrashed()->select('employee_id', 'user_id')->where('user_id', $id)->first();
        //xóa vĩnh viễn bảng ứng viên


        //xóa kinh nghiệm ứng viên
        $employees_experience = new Employee_experience();
        $employees_experience->where('employee_id', $employee->employee_id)->delete();

        //trình độ ứng viên
        $employees_specialize = new Employee_specialize();
        $employees_specialize->where('employee_id', $employee->employee_id)->delete();

        //danh mục
        $employee_career_categories = new EmployeeCareerCategories();
        $employee_career_categories->where('employee_id', $employee->employee_id)->delete();

        //xóa lưu công việc facebook
        $employees_save_job_facebook = new Employees_save_job_facebook();
        $employees_save_job_facebook->where('employee_id', $employee->employee_id)->delete();

        //phần mềm
        $employee_software = new EmployeeSoftware();
        $employee_software->where('employee_id', $employee->employee_id)->delete();

        //nộp hồ sơ
        $employee_submit_job_facebook = new Employee_submit_job_faacebook();
        $employee_submit_job_facebook->where('employee_id', $employee->employee_id)->delete();

        //thống kê ứng viên
        $statistical_employees = new Statistical_employees();
        $statistical_employees->where('employees_id', $employee->employee_id)->delete();

        // học với giáo viên

        $teacher_learn_employees = new TeacherLearnEmployees();
        $teacher_learn_employees->where('employee_id', $employee->employee_id)->delete();

        //số tiền chia se
        $employee_coins = new Employee_coins();
        $employee_coins->where('employee_id', $employee->employee_id)->delete();


        //xóa thống kê chia sẻ bài viết
        $post_sale_statistical = new Post_sale_statistical();
        $post_sale_statistical->where('employee_id', $employee->employee_id)->delete();

        $employee_model->withTrashed()->where('user_id', $id)->forceDelete();
    }

    public static function deleteEmployer($id)
    {


        $employer_model = new Employer();

        $employer_model->where('user_id', $id)->delete();
        $employer = $employer_model->onlyTrashed()->select('employer_id', 'user_id')->where('user_id', $id)->first();

        $employer_agency = new EmployerAgency();
        $agency = $employer_agency->select('*')->where('employer_id', $employer->employer_id)->get();

        if (!empty($agency)) {
            $employer_agency->where('employer_id', $employer->employer_id)->delete();
        }

        $employer_business_type = new EmployerBusiness();
        $business_type = $employer_business_type->where('employer_id', $employer->employer_id)->get();
        if (!empty($business_type)) {
            $employer_business_type->where('employer_id', $employer->employer_id)->delete();
        }

        //xóa hồ sơ thực tập
        $employer_intership = new EmployerIntership();
        $intership = $employer_intership->where('employer_id', $employer->employer_id)->get();
        if (!empty($intership)) {
            $employer_intership->where('employer_id', $employer->employer_id)->delete();
        }


        $employer_representative = new EmployerRepresentative();
        $representative = $employer_representative->where('employer_id', $employer->employer_id)->get();
        if (!empty($representative)) {
            $employer_representative->where('employer_id', $employer->employer_id)->delete();
        }


        $employer_transaction = new EmployerTransaction();
        $transaction = $employer_transaction->where('employer_id', $employer->employer_id)->get();
        if (!empty($transaction)) {
            $employer_transaction->where('employer_id', $employer->employer_id)->delete();
        }


        $employer_typeof_business = new EmployerTypeBusiness();
        $typeof_business = $employer_typeof_business->where('employer_id', $employer->employer_id)->get();
        if (!empty($typeof_business)) {
            $employer_typeof_business->where('employer_id', $employer->employer_id)->delete();
        }


        $jobs = new Job();
        $jobs->where('employer_id', $employer->employer_id)->delete();
        $list_jobs = $jobs->onlyTrashed()->select('job_id', 'employer_id')->where('employer_id', $employer->employer_id)->get();
        foreach ($list_jobs as $l_job) {
            $employee_submit_job_facebook = new Employee_submit_job_faacebook();

            $submit_job = $employee_submit_job_facebook->where('status_job', 1)->where('id_job_fb', $l_job->job_id)->get();
            if (!empty($submit_job)) {
                $employee_submit_job_facebook->where('status_job', 1)->where('id_job_fb', $l_job->job_id)->delete();
            }
            $employees_save_job_facebook = new Employees_save_job_facebook();
            $save_job_facebook = $employees_save_job_facebook->where('status_job', 1)->where('id_job_fb', $l_job->job_id)->get();

            if (!empty($save_job_facebook)) {
                $employees_save_job_facebook->where('status_job', 1)->where('id_job_fb', $l_job->job_id)->delete();
            }

        }

        $jobs->withTrashed()->where('employer_id', $employer->employer_id)->forceDelete();


        //danh giá
        $star_employer = new StarEmployer();
        $lisst_star_employer = $star_employer->where('id_employer', $employer->employer_id)->get();
        if (!empty($lisst_star_employer)) {
            $star_employer->where('id_employer', $employer->employer_id)->delete();
        }


        //xóa vĩnh viễn bảng ứng viên

        $employer_model->withTrashed()->where('user_id', $id)->forceDelete();

    }

    public static function deleteTeacher($id)
    {
        $teacher_model = new Teacher();
        $teacher_model->where('user_id', $id)->delete();
        $teacher = $teacher_model->onlyTrashed()->select('teacher_id', 'user_id')->where('user_id', $id)->first();


        //Xóa đánh giá giáo viên
        $star_teacher = new TeacherStar();
        $star_teacher->where('id_teacher', $teacher->teacher_id)->delete();

        //Xóa kinh nghiệm giáo viên
        $teacher_experience = new Teacher_experience();
        $teacher_experience->where('teacher_id', $teacher->teacher_id)->delete();

        //Xóa trình độ giáo viên
        $teacher_specialize = new Teacher_specialize();
        $teacher_specialize->where('teacher_id', $teacher->teacher_id)->delete();

        //Xóa nhóm kinh nghiệm
        $teacher_job_group = new Teacher_job_group();
        $teacher_job_group->where('teacher_id', $teacher->teacher_id)->delete();

        //xóa giao viên dạy học viên
        $teacher_learn_employees = new TeacherLearnEmployees();
        $list_teacher_learn_employees = $teacher_learn_employees->select('id_teacher_learn', 'teacher_id')
            ->where('teacher_id', $teacher->teacher_id)->get();
        //xóa đánh giá khóa học trước
        foreach ($list_teacher_learn_employees as $list_learn) {
            $teacher_star_learn = new TeacherStarLearn();
            $delete_teacher_star_learn = $teacher_star_learn->where('id_teacher_learn', $list_learn->teacher_learn_employees)->delete();
        }
        $teacher_learn_employees->where('teacher_id', $teacher->teacher_id)->delete();

        //giáo viên lưu công việc
        $teacher_save_job_facebook = new Teacher_save_job_facebook();
        $teacher_save_job_facebook->where('teacher_id', $teacher->teacher_id)->delete();
        //giáo viên xóa nộp hồ sơ facebook
        $teacher_submit_job_facebook = new Teacher_submit_job_faacebook();
        $teacher_submit_job_facebook->where('teacher_id', $teacher->teacher_id)->delete();
        $teacher_model->withTrashed()->where('user_id', $id)->forceDelete();
    }
}
