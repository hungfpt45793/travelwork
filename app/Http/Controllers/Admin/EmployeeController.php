<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Employee_career_categories;
use App\Entity\Employee_district;
use App\Entity\Employee_profile;
use App\Entity\Employee_upload_cv;
use App\Entity\Evaluate;
use App\Entity\NoteEmployee;
use App\Entity\Salary;
use App\Entity\User;
use App\Entity\Employee;
use App\Entity\Software;
use App\Entity\Career;
use App\Entity\Job;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Entity\Employee_delete_request;
use App\Entity\StarEmployer;
use App\Entity\TeacherStar;
use App\Exam\CommentExam;
use App\Exam\StarExam;



class EmployeeController extends AdminController
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
        $emplooyee = new Employee();
        $employees = $emplooyee->select('employee_id', 'employee_name', 'employee_image', 'email', 'career_category_id', 'salary_id', 'user_id', 'province', 'district')->orderBy('employee_id', 'desc');
        //        if (!empty($request->input('business'))) {
        //            $business = $request->input('business');
        //            $employers = $employers->where('employer.business', $business);
        //        }
        if (!empty($request->input('salary_id'))) {
            $salary_id = $request->input('salary_id');
            $employees = $employees->where('salary_id', $salary_id);
        }
        if (!empty($request->input('career_category_id'))) {
            $career_category_id = $request->input('career_category_id');
            $employees = $employees->where('career_category_id', $career_category_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employees = $employees->where('province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employees = $employees->where('district', $district);
        }
        if (!empty($request->input('employee_name'))) {
            $employee_name = $request->input('employee_name');
            $employers = $employees->where('employee_name', 'like', '%' . $employee_name . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $employers = $employees->where('email', 'like', '%' . $email . '%');
        }

        $total = $employees->count();
        $employees = $employees->paginate(20);
        $employees->appends(request()->query());
        return view('customers.employee.list', compact('employees', 'total'));
    }

    public function create()
    {
        $staffInCharges = User::get();
        $softwareList = Software::get();
        $careers = Career::orderBy('career_category_name')->get();
        $jobs = Job::get();
        $salaries = Salary::get();
        return view('customers.employee.add', compact('staffInCharges', 'softwareList', 'careers', 'jobs', 'salaries'));
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
            'password' => 'required|min:8',
            'employee_name' => 'required',
        ], [
            //            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
            'employee_name.required' => 'Tên công ty không được bỏ trống',

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
                'email' => $request->has('email') ? $request->input('email') : '',
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'address' => $request->input('address'),
                'employee_image' => $request->input('image'),
                'career_category_id' => $request->input('career_category_id'),
                'salary_id' => $request->input('salary_id'),
                // 'literacy' => $request->input('literacy_id'),
                // 'soft_skills' => $request->has('softSkill') ? $request->input('softSkill') : '',
                'information_verifier' => $request->has('information') ? $request->input('information') : '',
                // 'tags' => $request->input('tags'),
                'status' => $request->input('status'),
                'user_id' => $user_id_create,
                'employee_code' => $request->input('employee_code'),
                'gender' => $request->input('gender'),
                'birthday' => new \DateTime($request->input('birthday')),
                'marry' => $request->input('marry'),
                'school' => $request->input('school'),
                'cmt' => $request->input('cmt'),
                'cmt_date' => new \DateTime($request->input('cmt_date')),
                'cmt_local' => $request->input('cmt_local'),
                'majors' => $request->input('majors'),
                // 'meta_title' => $request->has('meta_title') ? $request->input('meta_title') : null,
                // 'meta_description' => $request->has('meta_description') ? $request->input('meta_description') : null,
                // 'meta_keyword' => $request->has('meta_keyword') ? $request->input('meta_keyword') : null,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'employee_level_id' => $request->input('employee_level_id'),
                'experience_id' => $request->input('experience_id'),
                'address_stay' => $request->input('address_stay')
            ]);
            DB::commit();
            return redirect(route('employee.index'))->with('success', 'Thêm mới ứng viên thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
            return redirect(route('employee.index'))->with('error', 'Thêm mới ứng viên thất bại');
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
    public function edit(Employee $employee)
    {

        $softwareList = Software::get();
        $careers = Career::orderBy('career_category_name')->get();
        $jobs = Job::get();
        $salaries = Salary::get();
        $staffInCharges = User::where('id', $employee->user_id)->first();


        return view('customers.employee.edit', compact('employee', 'jobs', 'salaries', 'staffInCharges', 'softwareList', 'careers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validation = Validator::make($request->all(), [
            'employee_name' => 'required',
        ], [
            //            'enterprise_id.unique' => 'Email đã tồn tại.',
            'employee_name.required' => 'Tên công ty không được bỏ trống',

        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        // try {
            DB::beginTransaction();

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
                    'career_category_id' => $request->input('career_category_id'),
                    'salary_id' => $request->input('salary_id'),
                    // 'literacy' => $request->input('literacy_id'),
                    // 'soft_skills' => $request->has('softSkill') ? $request->input('softSkill') : '',
                    'information_verifier' => $request->has('information') ? $request->input('information') : '',
                    // 'tags' => $request->input('tags'),
                    'status' => $request->input('status'),
                    'employee_code' => $request->input('employee_code'),
                    'gender' => $request->input('gender'),
                    'birthday' => new \DateTime($request->input('birthday')),
                    'marry' => $request->input('marry'),
                    'school' => $request->input('school'),
                    'cmt' => $request->input('cmt'),
                    'cmt_date' => new \DateTime($request->input('cmt_date')),
                    'cmt_local' => $request->input('cmt_local'),
                    'majors' => $request->input('majors'),
                    // 'meta_title' => $request->has('meta_title') ? $request->input('meta_title') : null,
                    // 'meta_description' => $request->has('meta_description') ? $request->input('meta_description') : null,
                    // 'meta_keyword' => $request->has('meta_keyword') ? $request->input('meta_keyword') : null,
                    //                'updated_at' => new \DateTime(),
                    'employee_level_id' => $request->input('employee_level_id'),
                    'experience_id' => $request->input('experience_id'),
                    'address_stay' => $request->input('address_stay'),
                ]);
            DB::commit();
            return redirect(route('employee.index'))->with('success', 'Cập nhật mới ứng viên thành công');
        // } catch (\Exception $exception) {
        //     Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
        //     DB::rollBack();
        //     return redirect(route('employee.index'))->with('error', 'Cập nhật ứng viên thất bại');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $user = $user->where('id', $employee->user_id)->delete();
            $employee->delete();

            DB::commit();
            return redirect(route('employee.index'))->with('success', 'Xóa ứng viên thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể xóa dữ liệu. Đã có lỗi xảy ra");
            DB::rollBack();
            return redirect(route('employee.index'))->with('error', 'Xóa ứng viên thất bại');
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

        if (
            !empty($jobSearch) || !empty($literacySearch) || !empty($salarySearch) || !empty($provinceSearch) || !empty($experienceSearch) || $statusSearch != -1 ||
            !empty($skillSearch) || !empty($keyword)
        ) {
            $employees = Employee::leftJoin('jobs', 'jobs.job_id', '=', 'employees.job_id')
                ->leftJoin('users', 'users.id', '=', 'employees.user_id')
                ->leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
                ->select(
                    'employees.employee_id as employee_id',
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

            $employees = $employees->appends([
                'job' => $jobSearch, 'literacy' => $literacySearch, 'salary' => $salarySearch,
                'province' => $provinceSearch, 'district' => $districtSearch, 'experience' => $experienceSearch,
                'status' => $statusSearch, 'skill' => $skillSearch, 'keyword' => $keyword
            ]);

            return view('customers.employee.search', compact(
                'employees',
                'jobSearch',
                'literacySearch',
                'salarySearch',
                'provinceSearch',
                'districtSearch',
                'experienceSearch',
                'statusSearch',
                'skillSearch',
                'keyword'
            ));
        }

        return redirect(route('employee.index'));
    }

    public function listEmployeeDeleteRequest(Request $request)
    {
        $emplooyee = new Employee_delete_request();

        $employees = $emplooyee->select('e.employee_id', 'e.employee_name', 'e.employee_image', 'e.email', 'e.career_category_id', 'e.salary_id', 'e.user_id', 'e.province', 'e.district','u.name as staff_name')
        ->leftjoin('employees as e','employee_delete_request.employee_id','e.employee_id')
        ->leftjoin('users as u','employee_delete_request.staff_id','u.id')
        ->orderBy('employee_id', 'desc');
        //        if (!empty($request->input('business'))) {
        //            $business = $request->input('business');
        //            $employers = $employers->where('employer.business', $business);
        //        }
        if (!empty($request->input('salary_id'))) {
            $salary_id = $request->input('salary_id');
            $employees = $employees->where('e.salary_id', $salary_id);
        }
        if (!empty($request->input('career_category_id'))) {
            $career_category_id = $request->input('career_category_id');
            $employees = $employees->where('e.career_category_id', $career_category_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employees = $employees->where('e.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employees = $employees->where('e.district', $district);
        }
        if (!empty($request->input('employee_name'))) {
            $employee_name = $request->input('employee_name');
            $employers = $employees->where('e.employee_name', 'like', '%' . $employee_name . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $employers = $employees->where('e.email', 'like', '%' . $email . '%');
        }

        $total = $employees->count();
        $employees = $employees->paginate(50);
        $employees->appends(request()->query());
        return view('customers.employee.list_delete_request', compact('employees', 'total'));
    }

    public function listEmployeeDelete(Request $request)
    {
        $emplooyee = new Employee();
        $employees = $emplooyee->onlyTrashed()->select('employee_id', 'employee_name', 'employee_image', 'email', 'career_category_id', 'salary_id', 'user_id', 'province', 'district')->orderBy('employee_id', 'desc');
        //        if (!empty($request->input('business'))) {
        //            $business = $request->input('business');
        //            $employers = $employers->where('employer.business', $business);
        //        }
        if (!empty($request->input('salary_id'))) {
            $salary_id = $request->input('salary_id');
            $employees = $employees->where('salary_id', $salary_id);
        }
        if (!empty($request->input('career_category_id'))) {
            $career_category_id = $request->input('career_category_id');
            $employees = $employees->where('career_category_id', $career_category_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employees = $employees->where('province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employees = $employees->where('district', $district);
        }
        if (!empty($request->input('employee_name'))) {
            $employee_name = $request->input('employee_name');
            $employers = $employees->where('employee_name', 'like', '%' . $employee_name . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $employers = $employees->where('email', 'like', '%' . $email . '%');
        }

        $total = $employees->count();
        $employees = $employees->paginate(50);
        $employees->appends(request()->query());
        return view('customers.employee.list_delete', compact('employees', 'total'));
    }

    public function Employeerestore(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {
                $user_model = new User();


                $restore = $user_model->withTrashed()->where('id', $id)->restore();
                $user = $user_model->where('id', $id)->first();

                $employee_model = new Employee();
                $restore_employee = $employee_model->withTrashed()->where('user_id', $id)->restore();


                //khoi phuc ban ghi
                DB::commit();
                return redirect(route('listEmployeeDelete'))->with('success', 'Khôi phục thành công');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listEmployeeDelete'))->with('error', 'Khôi phục thất bại');
        }
    }

    public function Employee_delete_with_admin(Request $request, $id)
    {
        try {
            $update = Employee_delete_request::where('employee_id',$id)->delete();
            $delete = Employee::where('employee_id',$id)->delete();
            //khoi phuc ban ghi
            DB::commit();
            return redirect(route('listEmployeeDeleteRequest'))->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listEmployeeDeleteRequest'))->with('error', 'Xóa thất bại');
        }
    }
    public function Employee_undelete_with_admin(Request $request, $id)
    {
        try {
            $update = Employee_delete_request::where('employee_id',$id)->delete();
            // $delete = Employee::where('employee_id',$id)->delete();
            //khoi phuc ban ghi
            DB::commit();
            return redirect(route('listEmployeeDeleteRequest'))->with('success', 'Hủy thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listEmployeeDeleteRequest'))->with('error', 'Hủy thất bại');
        }
    }

    public function EmployeeForceDelete(Request $request, $id)
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
                $delete = \App\Http\Controllers\Admin\UserController::deleteEmployee($id);


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

                $forceDelete = $user_model->withTrashed()
                    ->where('id', $id)
                    ->forceDelete();
            }
            DB::commit();
            return redirect(route('listEmployeeDelete'))->with('success', 'Xóa vĩnh viễn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('listEmployeeDelete'))->with('success', 'Xóa vĩnh viễn thất bại');
        }
    }
    public function clear_employee_coin($star,$limit)
    {
        $employee_model = new Employee();
        $list_employee = $employee_model->select('*')
            ->orderBy('employee_id','asc')
            ->skip($star)->take($limit)
            ->get();

        foreach($list_employee as $employee)
        {
            $profile = $employee_model->get_profile_employee_new($employee->user_id);
            $update = $employee_model->where('employee_id',$employee->employee_id)
                ->update(['profile' => $profile]);
            if($employee->status_employee == 0 && $profile > 40)
            {
                $update_status_employee = $employee_model->where('employee_id',$employee->employee_id)
                    ->update(['status_employee' => 1]);
            }
            echo  $employee->employee_name.'--'.$employee->employee_id.'--'.$profile.'</br>';
        }
    }

    public function create_employee_cv(Request $request)
    {
    }

	public function clear_employee_district($star,$limit)
    {
        $employee_model = new Employee();
        $list_employee = $employee_model->select('*')
            ->orderBy('employee_id','asc')
            ->skip($star)->take($limit)
            ->get();
        foreach($list_employee as $employee)
        {
            if($employee->time_to_work == 0)
            {
                $update = $employee_model->where('employee_id',$employee->employee_id)->update([
                    'time_to_work' => 2021
                ]);
            }


        }
    }
    public function clear_employee_cv($star,$limit)
    {
        $employee_model = new Employee();
        $list_employee = $employee_model->select('*')
            ->orderBy('employee_id','asc')
            ->skip($star)->take($limit)
            ->get();
        foreach($list_employee as $employee)
        {
           $employee_profile = Employee_profile::where('employee_id',$employee->employee_id)->first();
           $profile_cv = 0;
           if(!empty($employee_profile))
           {
               $employee_cv_status = Employee_upload_cv::where('employee_id',$employee->employee_id)->value('employee_cv_status');
               if(!empty($employee_cv_status))
               {
                   $profile_cv = 40;
                   $update_employee_profile = Employee_profile::where('employee_id',$employee->employee_id)->update([
                       'profile_cv' => $profile_cv
                   ]);
               }
               else
               {
                   $profile_cv = Employee::check_profile_cv($employee->user_id);
                   //cập nhật điểm cho cv của ứng viên
                   $update_employee_profile = Employee_profile::where('employee_id',$employee->employee_id)->update([
                       'profile_cv' => $profile_cv
                   ]);
                   //cập nhạt lại điểm của ứng viên
               }
               $profile_employee = $employee_profile->profile_info + $profile_cv + $employee_profile->profile_staff +  $employee_profile->profile_course + $employee_profile->profile_avg;

               $update_employee = Employee::where('employee_id',$employee->employee_id)->update([
                   'profile' => $profile_employee,
                   'status_employee' => ($profile_employee >= 40) ? 1 : 0
               ]);
               echo  $employee->employee_id.'----diểm----'.$profile_employee.'</br>';
           }
           else
           {
               echo  'Ung vien chua co trong employee_profile'.$employee->employee_id.'****************'.'</br>';
           }


        }
    }
    public function clear_profile($star,$limit)
    {
        $employee_model = new Employee();
        $list_employee = $employee_model->select('*')
            ->orderBy('employee_id','desc')
            ->skip($star)->take($limit)
            ->get();
        foreach($list_employee as $employee)
        {
           $employee_profile = Employee_profile::where('employee_id',$employee->employee_id)->first();
           if(empty($employee_profile))
           {
               if($employee_profile->profile_info == 0)
               {
                   $update = Employee_profile::where('employee_id',$employee->employee_id)->update([
                       'profile_info' => 10
                   ]);
               }else
               {
                   $insert = Employee_profile::insertGetId([
                       'employee_id' => $employee->employee_id,
                       'profile_info' => 10,
                       'created_at' => new \DateTime()
                   ]);
               }
               echo $employee->employee_id.'--'.$employee->created_at.'</br>';
           }
        }
    }
    public  function check_profile($employee_id)
    {
//        echo $employee_id;die;
        $employee_profile = Employee_profile::where('employee_id',$employee_id)->first();
        if(empty($employee_profile))
        {
            $insert = Employee_profile::insertGetId([
                'employee_id' => $employee_id,
                'profile_info' => 10,
                'created_at' => new \DateTime()
            ]);
        }else
        {
            if($employee_profile->profile_info == 0)
            {
                $update = Employee_profile::where('employee_id',$employee_id)->update([
                    'profile_info' => 10
                ]);
            }
        }
    }
    public function create_slug_employee($star,$limit)
    {
        $employee_model = new Employee();
        $list_employee = $employee_model->select('*')
            ->orderBy('employee_id','desc')
            ->skip($star)->take($limit)
            ->get();
        foreach($list_employee as $employee)
        {
            $employee_slug = str_slug($employee->employee_name).'-'.$employee->employee_id;
            $update = $employee_model->where('employee_id',$employee->employee_id)
                ->update([
                    'employee_slug'=>$employee_slug
                ]);
            echo $employee_slug.'</br>';
        }
    }
}
