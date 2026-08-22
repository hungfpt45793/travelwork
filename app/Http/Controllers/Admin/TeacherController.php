<?php

namespace App\Http\Controllers\Admin;

use App\Entity\NoteEmployee;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_save_job_facebook;
use App\Entity\Teacher_specialize;
use App\Entity\Teacher_submit_job_faacebook;
use App\Entity\User;
use App\Entity\Employee;
use App\Entity\Job;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Entity\Employer;
use App\Entity\JobFacebook;
use App\Entity\StarEmployer;
use App\Entity\TeacherStar;
use App\Exam\CommentExam;
use App\Exam\StarExam;
use App\Entity\Teacher_delete_request;
class TeacherController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;

            if (User::isMember($this->role)) {
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
        $teacher = new Teacher();
        $teachers = $teacher->select('teacher_id', 'teacher_name', 'teacher_email', 'teacher_phone', 'teacher_images', 'province', 'district', 'career_category_id','status_accounting');
        $teachers = $teachers->orderBy('teacher_id', 'desc');
        if (!empty($request->input('career_category_id'))) {
            $career_category_id = $request->input('career_category_id');
            $teachers = $teachers->where('career_category_id', $career_category_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $teachers = $teachers->where('province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $teachers = $teachers->where('district', $district);
        }
        if (!empty($request->input('teacher_name'))) {
            $teacher_name = $request->input('teacher_name');
            $teachers = $teachers->where('teacher_name', 'like', '%' . $teacher_name . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $teachers = $teachers->where('teacher_email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('status_accounting'))) {
            $status_accounting = $request->input('status_accounting');
            $teachers = $teachers->where('status_accounting', $status_accounting);
        }
        $total = $teachers->count();
        $teachers = $teachers->paginate(20);
        $teachers->appends(request()->query());
        return view('customers.teacher.list', compact('teachers', 'total'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('customers.teacher.add');
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
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'teacher_name' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu Phải lớn hơn 6 ký tự.',
            'teacher_name.required' => 'Tên giáo viên không được bỏ trống',

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
                'name' => $request->input('teacher_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->has('teacher_phone') ? $request->input('teacher_phone') : '',
                'role' => 3
            ]);
            $teacher = new Teacher();
            $insert = $teacher->insertGetId([
                'teacher_name' => $request->input('teacher_name'),
                'teacher_phone' => $request->input('teacher_phone'),
                'teacher_email' => $request->has('email') ? $request->input('email') : '',
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'address' => $request->input('address'),
                'teacher_images' => $request->input('teacher_images'),
                'career_category_id' => $request->input('career_category_id'),
                'information_verifier' => $request->has('information_verifier') ? $request->input('information_verifier') : '',
                'user_id' => $user_id_create,
                'gender' => $request->input('gender'),
                'birthday' => new \DateTime($request->input('birthday')),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);

//        return redirect(route('teacher.index'))->with('success','Thêm mới giáo viên thành công');

            DB::commit();
            return redirect(route('teacher.index'))->with('success', 'Thêm mới giáo viên thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
            return redirect(route('teacher.index'))->with('error', 'Thêm mới giáo viên thất bại');
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
    public function edit(Teacher $teacher)
    {
        $staffCharge = User::where('id', $teacher->user_id)->first();
        return view('customers.teacher.edit', compact('teacher', 'staffCharge'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validation = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'teacher_name' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'password.min' => 'Mật khẩu Phải lớn hơn 6 ký tự.',
            'teacher_name.required' => 'Tên giáo viên không được bỏ trống',
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
//        try {
//            DB::beginTransaction();

            //goi APi xử lý chuyển tài khoản sang sanketoanthue.vn

        $userModel = new User();
        $user_id_create = $userModel->where('id', $teacher->user_id)->update([
            'name' => $request->input('teacher_name'),
            'phone' => $request->has('teacher_phone') ? $request->input('teacher_phone') : '',
        ]);
        $isChangePassword = $request->input('is_change_password');
        if ($isChangePassword == 1) {
            $userModel->where('id', $teacher->user_id)->update([
                'password' => bcrypt($request->input('password')),
            ]);
        }

        $insert = $teacher->update([
            'teacher_name' => $request->input('teacher_name'),
            'teacher_phone' => $request->input('teacher_phone'),
            'province' => $request->input('province'),
            'district' => $request->input('district'),
            'address' => $request->input('address'),
            'teacher_images' => $request->input('teacher_images'),
            'career_category_id' => $request->input('career_category_id'),
            'information_verifier' => $request->has('information_verifier') ? $request->input('information_verifier') : '',
            'gender' => $request->input('gender'),
            'birthday' => new \DateTime($request->input('birthday')),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        return redirect(route('teacher.index'))->with('success', 'Sửa thông tin giáo viên  thành công');

//            DB::commit();
//            return redirect(route('teacher.index'))->with('success','Sửa thông tin giáo viên thành công');
//        } catch (\Exception $exception) {
//            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
//            DB::rollBack();
//            return redirect(route('teacher.index'))->with('error', 'Sửa thông tin giáo viên thất bại');
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
//        print_r($teacher);die();
        try {
            DB::beginTransaction();

            //xóa kinh nghiệm giáo viên
            $teacher_experience = new Teacher_experience();
            $teacher_experience = $teacher_experience->where('teacher_id', $teacher->teacher_id)->delete();
            //giao viên lưu tin facebook và tin tuyển dụng
            $teacher_save_facebook = new  Teacher_save_job_facebook();
            $teacher_save_facebook = $teacher_save_facebook->where('teacher_id', $teacher->teacher_id)->delete();
//            trình độ giáo viên
            $teacher_speccialize = new Teacher_specialize();
            $teacher_speccialize = $teacher_speccialize->where('teacher_id', $teacher->teacher_id)->delete();
//            hồ sơ đã nộp , ứng tuyển
            $teacher_submit = new Teacher_submit_job_faacebook();
            $teacher_submit = $teacher_submit->where('teacher_id', $teacher->teacher_id)->delete();
//            xóa user
            $user = new User();
            $user = $user->where('id', $teacher->user_id)->delete();
            //xoa giao vien
            $teacher->delete();
            DB::commit();
            return redirect(route('teacher.index'))->with('success', 'Xóa ứng viên thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể xóa dữ liệu. Đã có lỗi xảy ra");
            DB::rollBack();
            return redirect(route('teacher.index'))->with('error', 'Xóa ứng viên thất bại');
        }
    }

    public function anyDatatable()
    {
        $employees = Employee::leftJoin('employer', 'employer.employer_id', '=', 'employees.employer_id')
            ->leftJoin('users', 'users.id', '=', 'employees.user_id')
            ->leftJoin('jobs', 'jobs.job_id', '=', 'employees.job_id')
            ->select(
                'employees.employee_id',
                'employees.employee_code',
                'employees.employee_name',
                'employees.employee_image',
                'jobs.title',
                'users.name',
                'employees.phone',
                'employees.email',
                'employees.status',
                'employer.enterprise_name',
                'employees.created_at'
            )->orderByDesc('employees.employee_id');
        return Datatables::of($employees)
            ->addColumn('action', function ($employee) {
                $string = '<a href="' . route('employee.edit', ['employee_id' => $employee->employee_id]) . '">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('employee.destroy', ['employee_id' => $employee->employee_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })->orderColumn('employees.employee_id', 'employees.employee_id desc')
            ->make(true);
    }

    public function note(Request $request)
    {
        $employee = NoteEmployee::insertGetId([
            'note' => $request->input('content'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        $string = '<p> -' . $request->input('content') . '. </p>
                    <input type="hidden" name="idEmployee" value="' . $employee . '">';
        echo $string;
    }

    public function search(Request $request)
    {
        $jobSearch = $request->input('job');
        $literacySearch = $request->input('literacy');
        $salarySearch = $request->input('salary');
        $provinceSearch = $request->input('province');
        $districtSearch = $request->input('district');
        $experienceSearch = $request->input('experience');
        $statusSearch = $request->input('status');
        $skillSearch = $request->input('skill');
        $keyword = $request->input('keyword');

        if (!empty($jobSearch) || !empty($literacySearch) || !empty($salarySearch) || !empty($provinceSearch) || !empty($experienceSearch) || $statusSearch != -1 ||
            !empty($skillSearch) || !empty($keyword)) {
            $employees = Employee::leftJoin('jobs', 'jobs.job_id', '=', 'employees.job_id')
                ->leftJoin('users', 'users.id', '=', 'employees.user_id')
                ->leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
                ->select('employees.employee_id as employee_id',
                    'employees.employee_code as employee_code',
                    'employees.phone as employee_phone',
                    'employees.employee_name as employee_name',
                    'employees.employee_image as employee_image',
                    'employees.email as employee_email',
                    'jobs.title as title',
                    'users.name as name',
                    'employees.status as status',
                    'employer.enterprise_name as enterprise_name',
                    'employees.created_at as created_at'
                );

            if (!empty($jobSearch)) {
                $employees = $employees->where('employees.job_id', $jobSearch);
            }

            if (!empty($literacySearch)) {
                $employees = $employees->where('employees.literacy', $literacySearch);
            }

            if (!empty($salarySearch)) {
                $employees = $employees->where('employees.salary_id', $salarySearch);
            }

            if (!empty($provinceSearch)) {
                $employees = $employees->where('employees.province', $provinceSearch)
                    ->where('employees.district', $districtSearch);
            }

            if (!empty($experienceSearch)) {
                $employees = $employees->where('employees.experience', 'like', '%' . $experienceSearch . '%');
            }

            if ($statusSearch != -1) {
                $employees = $employees->where('employees.status', $statusSearch);
            }

            if (!empty($skillSearch)) {
                $employees = $employees->where('employees.soft_skills', 'like', '%' . $skillSearch . '%');
            }

            if (!empty($keyword)) {
                $employees = $employees->where('employees.employee_name', 'like', '%' . $keyword . '%');
            }

            $employees = $employees->orderBy('employees.employee_name')
                ->paginate(10);

            $employees = $employees->appends(['job' => $jobSearch, 'literacy' => $literacySearch, 'salary' => $salarySearch,
                'province' => $provinceSearch, 'district' => $districtSearch, 'experience' => $experienceSearch,
                'status' => $statusSearch, 'skill' => $skillSearch, 'keyword' => $keyword]);

            return view('customers.employee.search', compact('employees', 'jobSearch', 'literacySearch', 'salarySearch',
                'provinceSearch', 'districtSearch', 'experienceSearch', 'statusSearch', 'skillSearch', 'keyword'));
        }

        return redirect(route('employee.index'));
    }

    public function Teacher_delete_with_admin(Request $request, $id)
    {
        try {
            $update = Teacher_delete_request::where('teacher_id',$id)->delete();
            $delete = Teacher::where('teacher_id',$id)->delete();
            //khoi phuc ban ghi
            DB::commit();
            return redirect(route('listTeacherDeleteRequest'))->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listTeacherDeleteRequest'))->with('error', 'Xóa thất bại');
        }
    }
    public function Teacher_undelete_with_admin(Request $request, $id)
    {
        try {
            $update = Teacher_delete_request::where('teacher_id',$id)->delete();
            //khoi phuc ban ghi
            DB::commit();
            return redirect(route('listTeacherDeleteRequest'))->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listTeacherDeleteRequest'))->with('error', 'Xóa thất bại');
        }
    }

    public function listTeacherDeleteRequest(Request $request)
    {
        $teacher = new Teacher_delete_request();
        $teachers = $teacher->select('t.teacher_id', 't.teacher_name', 't.teacher_email', 't.teacher_phone', 't.teacher_images', 't.province', 't.district', 't.career_category_id', 't.user_id','u.name as staff_name')
                            ->leftjoin('teacher as t','teacher_delete_request.teacher_id','t.teacher_id')
                            ->leftjoin('users as u','teacher_delete_request.staff_id','u.id');
        $teachers = $teachers->orderBy('t.teacher_id', 'desc');
        if (!empty($request->input('career_category_id'))) {
            $career_category_id = $request->input('career_category_id');
            $teachers = $teachers->where('t.career_category_id', $career_category_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $teachers = $teachers->where('t.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $teachers = $teachers->where('t.district', $district);
        }
        if (!empty($request->input('teacher_name'))) {
            $teacher_name = $request->input('teacher_name');
            $teachers = $teachers->where('t.teacher_name', 'like', '%' . $teacher_name . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $teachers = $teachers->where('t.teacher_email', 'like', '%' . $email . '%');
        }

        $teachers = $teachers->paginate(50);
        $total = $teachers->count();
        $teachers->appends(request()->query());
        return view('customers.teacher.list_delete_request', compact('teachers', 'total'));
    }

    public function listTeacherDelete(Request $request)
    {
        $teacher = new Teacher();
        $teachers = $teacher->onlyTrashed()->select('teacher_id', 'teacher_name', 'teacher_email', 'teacher_phone', 'teacher_images', 'province', 'district', 'career_category_id', 'user_id');
        $teachers = $teachers->orderBy('teacher_id', 'desc');
        if (!empty($request->input('career_category_id'))) {
            $career_category_id = $request->input('career_category_id');
            $teachers = $teachers->where('career_category_id', $career_category_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $teachers = $teachers->where('province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $teachers = $teachers->where('district', $district);
        }
        if (!empty($request->input('teacher_name'))) {
            $teacher_name = $request->input('teacher_name');
            $teachers = $teachers->where('teacher_name', 'like', '%' . $teacher_name . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $teachers = $teachers->where('teacher_email', 'like', '%' . $email . '%');
        }

        $teachers = $teachers->paginate(50);
        $total = $teachers->count();
        $teachers->appends(request()->query());
        return view('customers.teacher.list_delete', compact('teachers', 'total'));
    }

    public function Teacherrestore(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {

                $user_model = new User();
                $restore = $user_model->withTrashed()->where('id', $id)->restore();
                $user = $user_model->where('id', $id)->first();
                $teacher_model = new Teacher();
                $restore_teacher = $teacher_model->withTrashed()->where('user_id', $id)->restore();
                //khoi phuc ban ghi
                return redirect(route('listTeacherDelete'))->with('success', 'Khôi phục thành công');
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listTeacherDelete'))->with('error', 'Khôi phục thất bại');
        }


    }

    public function TeacherForceDelete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $userLogin = Auth::user();

            if ($userLogin->role == 4) {
                $user_model = new User();
                $delete_user = $user_model->where('id', $id)->delete();
                $user = $user_model->onlyTrashed()->where('id', $id)->first();

//
                $delete = \App\Http\Controllers\Admin\UserController::deleteTeacher($id);
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

                $forceDelete = $user_model->withTrashed()
                    ->where('id', $id)
                    ->forceDelete();
            }
            DB::commit();
            return redirect(route('listTeacherDelete'))->with('success', 'Xóa vĩnh viễn thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listTeacherDelete'))->with('error', 'Xóa vĩnh viễn thất bại');
        }

    }
}
