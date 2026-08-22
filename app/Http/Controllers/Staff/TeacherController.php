<?php

namespace App\Http\Controllers\Staff;

use App\Entity\Teacher_status;
use App\Http\Controllers\Site\CkedittorController;
use App\Http\Controllers\Site\MailConfigController;
use App\Http\Controllers\Site\SiteController;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Teacher;
use App\Entity\District;
use App\Entity\Province;
use App\Entity\Teacher_job_group;
use App\Entity\Teacher_specialize;
use App\Entity\Teacher_experience;
use App\Entity\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Entity\Teacher_delete_request;
use Illuminate\Support\Facades\Auth;
use App\Entity\InteractiveTeacher;
use Carbon\Carbon;
use App\Entity\MailConfig;
use App\Entity\Template_email;
use App\Entity\Teacher_submit_job_faacebook;
use App\Entity\Teacher_save_job_facebook;

class TeacherController extends SiteStaffController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'teacher');
            return $next($request);
        });
    }
    public function index(Request $request)
    {

        $teachers = Teacher::select(
            'teacher.created_at',
            'teacher.updated_at',
            'teacher.teacher_id',
            'teacher.teacher_name',
            'teacher.teacher_email',
            'teacher.teacher_phone',
            'teacher.teacher_images',
            'province.province_name',
            'district.district_name',
            'teacher.career_category_id',
            'teacher.status_accounting',
            'teacher.province',
            'teacher.teacher_status_id'
        )->leftJoin('province', 'province.province_id', 'teacher.province')
            ->leftJoin('district', 'district.district_id', 'teacher.district');
        // tìm theo id ntd
        if (!empty($request->teacher_id)) {
            $teachers = $teachers->where('teacher.teacher_id', $request->teacher_id);
        }
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            // dd($date_search_start);
            $teachers = $teachers->whereDate('teacher.updated_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $teachers = $teachers->whereDate('teacher.updated_at', '<=', $request->date_search_end);
        }
        if (!empty($request->teacher_status_id)) {
            $teachers = $teachers->where('teacher_status_id', $request->teacher_status_id);
        }
        if (!empty($request->province)) {
            // return 4;
            $teachers->where('teacher.province', $request->province);
        }
        if (isset($request->status_accounting)) {
            $teachers->where('teacher.status_accounting', $request->status_accounting);
        }
        if (!empty($request->teacher_name)) {
            $teachers->where('teacher.teacher_name', 'like', '%' . $request->teacher_name . '%');
        }
        if (!empty($request->career_category_id)) {
            $teachers->where('teacher.career_category_id', $request->career_category_id);
        }
        if (!empty($request->district)) {
            $teachers->where('teacher.district', $request->district);
        }
        if (!empty($request->email)) {
            $teachers->where('teacher.teacher_email', 'like', '%' . $request->email . '%');
        }
        if (!empty($request->is_delete)) {
            // return 3;
            $id = [];
            $ls = Teacher_delete_request::get();
            foreach ($ls as $l) {
                $id[] = $l->teacher_id;
            }
            if ($request->is_delete == 1) {
                // return 1;
                $teachers->whereNotIn('teacher.teacher_id', $id);
            }
            if ($request->is_delete == 2) {
                // return 2;
                $teachers->whereIn('teacher.teacher_id', $id);
            }
        }
        $total = $teachers->count();
        $num = 30;
        if (!empty($request->num)) {
            $num = $request->num;
        }
        $teachers = $teachers->orderBy('teacher.teacher_id', 'desc')
            ->paginate($num);
        $teachers->appends(request()->query());
        return view('staff_admin.teacher.list', compact('teachers', 'total'));
    }

    public function getListTeacher_not_interactive(Request $request)
    {
        $teacher = new Teacher();
        $teachers = $teacher->select('teacher.*')
            ->leftJoin('province', 'province.province_id', 'teacher.province')
            ->leftJoin('district', 'district.district_id', 'teacher.district');
        $teachers = $teachers->orderBy('teacher_id', 'desc');
        if (!empty($request->input('career_category_id'))) {
            $career_category_id = $request->input('career_category_id');
            $teachers = $teachers->where('career_category_id', $career_category_id);
        }
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            // dd($date_search_start);
            $teachers = $teachers->whereDate('teacher.created_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $teachers = $teachers->whereDate('teacher.created_at', '<=', $request->date_search_end);
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
        $ls_inter_active = InteractiveTeacher::get();
        $id = [];
        foreach ($ls_inter_active as $ls) {
            if (!in_array($ls->teacher_id, $id)) {
                $id[] = $ls->teacher_id;
            }
        }
        $teachers = $teachers->whereNotIn('teacher_id', $id);
        $total = $teachers->count();
        $teachers = $teachers->paginate(20);
        $teachers->appends(request()->query());
        // dd($teachers);
        return view('staff_admin.teacher.list_not_interactive', compact('teachers', 'total'));
    }

    public function getDistrict(Request $request)
    {
        $province_id = $request->province_id;
        $districts = District::where('province_id', $province_id)->get();
        return response($districts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff_admin.teacher.create');
    }


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
            return redirect(route('staff_teacher.index'))->with('success', 'Thêm mới giáo viên thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('staff_teacher.index'))->with('error', 'Thêm mới giáo viên thất bại.');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        // $teacher = new Teacher();
        // $teacher = $teacher->select('*')->where('user_id', $id)->first();
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

        $course = new \App\Course\Course();
        // $course = new Course();
        $course = $course->select('*')->where('course_id', $teacher->course_id)->first();

        // return view('site.job_facebook.update_user_teacher', compact('user', 'teacher', 'specialize', 'experience', 'course', 'id_teacher_job'));
        return view('staff_admin.teacher.edit', compact('teacher', 'specialize', 'experience', 'id_teacher_job', 'course'));
    }

    public function update(Request $request, $id)
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
        $teacher = Teacher::where('teacher_id', $id)->first();
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

        $insert = Teacher::where('teacher_id', $id)->update([
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

        return redirect(route('teacher.index'))->with('success', 'Sửa thông tin giáo viên thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete_all_request(Request $request)
    {
        // dd(1);
        try {
            $list_id = $request->Ids;
            for ($i = 0; $i < count($list_id); $i++) {
                $check = Teacher_delete_request::where('teacher_id', $list_id[$i])->first();
                if ($check == null) {
                    $create = Teacher_delete_request::insert([
                        'teacher_id' => $list_id[$i],
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

    public function delete_request(Request $request, $id)
    {
        try {
            $update = Teacher_delete_request::insert([
                'teacher_id' => $id,
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
            $update = Teacher_delete_request::where('teacher_id', $id)->delete();
            $request->session()->flash('success', 'Bỏ đề nghị xóa thành công!');
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Bỏ đề nghị xóa thất bại!');
            return redirect()->back();
        }
    }

    public static function countTeacherP($province_id)
    {
        return $count_teacher = Teacher::where('province', $province_id)
            ->count();
    }

    public static function countTeacherD($district_id)
    {
        return $count_teacher = Teacher::where('district', $district_id)
            ->count();
    }

    public function statistical()
    {
        $provinces = Province::select('province_id', 'province_name')->get();
        return view('staff_admin.teacher.teacher_province', compact('provinces'));
    }

    public function district($province_id)
    {
        $province_name = Province::where('province_id', $province_id)->value('province_name');

        $districts = District::select('district_id', 'district_name')
            ->where('province_id', $province_id)
            ->get();
        return view('staff_admin.teacher.teacher_district', compact('districts', 'province_name', 'province_id'));
    }

    public function list_deleted(Request $request)
    {
        $teachers = Teacher::select(
            'teacher.created_at',
            'teacher.updated_at',
            'teacher.deleted_at',
            'teacher.teacher_id',
            'teacher.teacher_name',
            'teacher.teacher_email',
            'teacher.teacher_phone',
            'teacher.teacher_images',
            'province.province_name',
            'district.district_name',
            'teacher.career_category_id',
            'teacher.status_accounting',
            'teacher.province',
            'teacher.teacher_status_id'
        )->leftJoin('province', 'province.province_id', 'teacher.province')
            ->leftJoin('district', 'district.district_id', 'teacher.district');
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            // dd($date_search_start);
            $teachers = $teachers->whereDate('teacher.updated_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $teachers = $teachers->whereDate('teacher.updated_at', '<=', $request->date_search_end);
        }
        if (!empty($request->teacher_status_id)) {
            $teachers = $teachers->where('teacher_status_id', $request->teacher_status_id);
        }
        if (!empty($request->province)) {
            // return 4;
            $teachers->where('teacher.province', $request->province);
        }
        if (isset($request->status_accounting)) {
            $teachers->where('teacher.status_accounting', $request->status_accounting);
        }
        if (!empty($request->teacher_name)) {
            $teachers->where('teacher.teacher_name', 'like', '%' . $request->teacher_name . '%');
        }
        if (!empty($request->career_category_id)) {
            $teachers->where('teacher.career_category_id', $request->career_category_id);
        }
        if (!empty($request->district)) {
            $teachers->where('teacher.district', $request->district);
        }
        if (!empty($request->email)) {
            $teachers->where('teacher.teacher_email', 'like', '%' . $request->email . '%');
        }
        if (!empty($request->is_delete)) {
            // return 3;
            $id = [];
            $ls = Teacher_delete_request::get();
            foreach ($ls as $l) {
                $id[] = $l->teacher_id;
            }
            if ($request->is_delete == 1) {
                // return 1;
                $teachers->whereNotIn('teacher.teacher_id', $id);
            }
            if ($request->is_delete == 2) {
                // return 2;
                $teachers->whereIn('teacher.teacher_id', $id);
            }
        }
        $teachers = $teachers->onlyTrashed();
        $total = $teachers->count();
        $num = 30;
        if (!empty($request->num)) {
            $num = $request->num;
        }
        $teachers = $teachers->orderBy('teacher.teacher_id', 'desc')
            ->paginate($num);
        $teachers->appends(request()->query());
        return view('staff_admin.teacher.list_deleted', compact('teachers', 'total'));
    }

    public function report_teacher(Request $request)
    {

        $teachers = Teacher::select(
            'teacher.created_at',
            'teacher.updated_at',
            'teacher.teacher_id',
            'teacher.teacher_name',
            'teacher.teacher_email',
            'teacher.teacher_phone',
            'teacher.teacher_images',
            'province.province_name',
            'district.district_name',
            'teacher.career_category_id',
            'teacher.status_accounting',
            'teacher.province',
            'teacher.teacher_status_id'
        )->leftJoin('province', 'province.province_id', 'teacher.province')
            ->leftJoin('district', 'district.district_id', 'teacher.district');
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            // dd($date_search_start);
            $teachers = $teachers->whereDate('teacher.updated_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $teachers = $teachers->whereDate('teacher.updated_at', '<=', $request->date_search_end);
        }
        if (!empty($request->teacher_status_id)) {
            $teachers = $teachers->where('teacher_status_id', $request->teacher_status_id);
        }
        if (!empty($request->province)) {
            // return 4;
            $teachers->where('teacher.province', $request->province);
        }
        if (isset($request->status_accounting)) {
            $teachers->where('teacher.status_accounting', $request->status_accounting);
        }
        if (!empty($request->teacher_name)) {
            $teachers->where('teacher.teacher_name', 'like', '%' . $request->teacher_name . '%');
        }
        if (!empty($request->career_category_id)) {
            $teachers->where('teacher.career_category_id', $request->career_category_id);
        }
        if (!empty($request->district)) {
            $teachers->where('teacher.district', $request->district);
        }
        if (!empty($request->email)) {
            $teachers->where('teacher.teacher_email', 'like', '%' . $request->email . '%');
        }
        if (!empty($request->is_delete)) {
            // return 3;
            $id = [];
            $ls = Teacher_delete_request::get();
            foreach ($ls as $l) {
                $id[] = $l->teacher_id;
            }
            if ($request->is_delete == 1) {
                // return 1;
                $teachers->whereNotIn('teacher.teacher_id', $id);
            }
            if ($request->is_delete == 2) {
                // return 2;
                $teachers->whereIn('teacher.teacher_id', $id);
            }
        }
        $total = $teachers->count();
        $num = 30;
        if (!empty($request->num)) {
            $num = $request->num;
        }
        $teachers = $teachers->orderBy('teacher.teacher_id', 'desc')
            ->paginate($num);
        $teachers->appends(request()->query());
        return view('staff_admin.teacher.report_teacher', compact('teachers', 'total'));
    }

    public function destroy($id)
    {
        //
    }

    public function datatable_getListTeacher(Request $request)
    {
        // $teachers = Teacher::leftJoin('province', 'province.province_id', 'teacher.province')
        //     ->leftJoin('district', 'district.district_id', 'teacher.district');
        $teachers = Teacher::select(
            'teacher.created_at',
            'teacher.updated_at',
            'teacher.teacher_id',
            'teacher.teacher_name',
            'teacher.teacher_email',
            'teacher.teacher_phone',
            'teacher.teacher_images',
            'province.province_name',
            'district.district_name',
            'teacher.career_category_id',
            'teacher.status_accounting',
            'teacher.province',
            'teacher.teacher_status_id'
        )->leftJoin('province', 'province.province_id', 'teacher.province')
            ->leftJoin('district', 'district.district_id', 'teacher.district');
        if (!empty($request->province)) {
            // return 4;
            $teachers = $teachers->where('teacher.province', $request->province);
        }
        if (isset($request->status_accounting)) {
            $teachers = $teachers->where('teacher.status_accounting', $request->status_accounting);
        }
        if (!empty($request->teacher_name)) {
            $teachers = $teachers->where('teacher.teacher_name', 'like', '%' . $request->teacher_name . '%');
        }
        if (!empty($request->career_category_id)) {
            $teachers = $teachers->where('teacher.career_category_id', $request->career_category_id);
        }
        if (!empty($request->district)) {
            $teachers = $teachers->where('teacher.district', $request->district);
        }
        if ($request->teacher_status_id) {

            $teachers = $teachers->where('teacher.teacher_status_id', $request->teacher_status_id);
        }
        if (!empty($request->email)) {
            $teachers = $teachers->where('teacher.teacher_email', 'like', '%' . $request->email . '%');
        }
        if (!empty($request->is_delete)) {
            // return 3;
            $id = [];
            $ls = Teacher_delete_request::get();
            foreach ($ls as $l) {
                $id[] = $l->teacher_id;
            }
            if ($request->is_delete == 1) {
                // return 1;
                $teachers = $teachers->whereNotIn('teacher.teacher_id', $id);
            }
            if ($request->is_delete == 2) {
                // return 2;
                $teachers = $teachers->whereIn('teacher.teacher_id', $id);
            }
        }
        $teachers = $teachers->orderBy('teacher.teacher_id', 'desc')
            ->get();
        return Datatables::of($teachers)
            ->addColumn('check_box', function ($teacher) {
                $string4 = '';
                $string4 .= '<input type="checkbox" id_customer="' . $teacher->teacher_id . '" class="checkItem" value="' . $teacher->teacher_id . '">';
                return $teacher->teacher_id;
            })
            ->addColumn('is_delete', function ($teacher) {
                $check = Teacher_delete_request::where('teacher_id', $teacher->teacher_id)->first();
                $string1 = '';
                if ($check != null) {
                    // $string1 .= '<span style="color:red">Có</span>';
                    return 1;
                } else {
                    // $string1 .= '<span style="color:green">Không</span>';
                    return 2;
                }

                // return $string1;
            })
            ->addColumn('action', function ($teacher) {
                $string = '';
                $string .= '<a  href="' . route('interactive_index', ['teacher_id' => $teacher->teacher_id]) . '" class="btn btn-info" >Thao tác</a>';
                return $string;
            })
            ->addColumn('exp', function ($teacher) {
                $nowYear = (int)date('Y', strtotime(Carbon::now()));
                $listExp = Teacher_experience::select('*')
                    ->where('teacher_id', $teacher->teacher_id)
                    ->get();


                $exp = [];
                $exp[$teacher->teacher_id] = null;

                if (count($listExp) > 0) {
                    $minYear = $nowYear;
                    foreach ($listExp as $key => $value) {
                        $star_year = (int)$value['star_working_time'];
                        if ($star_year == 0) {
                            $minYear = $nowYear;
                        } else {
                            if ($minYear > $star_year) {
                                $minYear = $star_year;
                            }
                        }
                    }
                    $exp[$teacher->teacher_id] = $nowYear - $minYear;
                }
                if ($exp[$teacher->teacher_id] != null && $exp[$teacher->teacher_id] > 0) {
                    $string2 = $exp[$teacher->teacher_id];
                } else {
                    $string2 = '0';
                }
                // $string2 = '';
                // $string2 .= $exp[$teacher->teacher_id];
                return $string2;
            })
            ->addColumn('user_name', function ($teacher) {
                $user_content_intea = \App\Entity\InteractiveTeacher::get_user_id_content($teacher->teacher_id);
                if (!empty($user_content_intea)) {
                    $string_name = $user_content_intea->name;
                } else {
                    $string_name = '';
                }

                return $string_name;
            })
            ->addColumn('user_content', function ($teacher) {
                $user_content_intea = \App\Entity\InteractiveTeacher::get_user_id_content($teacher->teacher_id);
                if (!empty($user_content_intea)) {
                    $string_content = $user_content_intea->content;
                } else {
                    $string_content = '';
                }
                return $string_content;
            })
            ->addColumn('teacher_status_id', function ($teacher) {
                $user_status_tea = \App\Entity\Teacher_status::getId($teacher->teacher_status_id);
                if (!empty($user_status_tea)) {
                    $string_status_name = $user_status_tea->teacher_status_name;
                } else {
                    $string_status_name = '';
                }
                return $string_status_name;
            })
            ->make(true);
    }

    public function datatable_getListTeacher_not_interactive(Request $request)
    {
        // $teachers = Teacher::leftJoin('province', 'province.province_id', 'teacher.province')
        //     ->leftJoin('district', 'district.district_id', 'teacher.district');
        $teachers = Teacher::select(
            'teacher.created_at',
            'teacher.updated_at',
            'teacher.teacher_id',
            'teacher.teacher_name',
            'teacher.teacher_email',
            'teacher.teacher_phone',
            'teacher.teacher_images',
            'province.province_name',
            'district.district_name',
            'teacher.career_category_id',
            'teacher.status_accounting',
            'teacher.province'
        )->leftJoin('province', 'province.province_id', 'teacher.province')
            ->leftJoin('district', 'district.district_id', 'teacher.district');

        if (!empty($request->province)) {
            // return 4;
            $teachers->where('teacher.province', $request->province);
        }
        if (isset($request->status_accounting)) {
            $teachers->where('teacher.status_accounting', $request->status_accounting);
        }
        if (!empty($request->teacher_name)) {
            $teachers->where('teacher.teacher_name', 'like', '%' . $request->teacher_name . '%');
        }
        if (!empty($request->career_category_id)) {
            $teachers->where('teacher.career_category_id', $request->career_category_id);
        }
        if (!empty($request->district)) {
            $teachers->where('teacher.district', $request->district);
        }
        if (!empty($request->email)) {
            $teachers->where('teacher.teacher_email', 'like', '%' . $request->email . '%');
        }
        if (!empty($request->is_delete)) {
            // return 3;
            $id = [];
            $ls = Teacher_delete_request::get();
            foreach ($ls as $l) {
                $id[] = $l->teacher_id;
            }
            if ($request->is_delete == 1) {
                // return 1;
                $teachers->whereNotIn('teacher.teacher_id', $id);
            }
            if ($request->is_delete == 2) {
                // return 2;
                $teachers->whereIn('teacher.teacher_id', $id);
            }
        }
        $id = [];
        $ls_inter_active = InteractiveTeacher::get();
        // $ls_inter_active = InteractiveTeacher::chunk(100, function($ls_inter_active,$id=[]) {
        //     foreach($ls_inter_active as $ls){
        //         if(!in_array($ls->teacher_id,$id)){
        //             $id[] = $ls->teacher_id;
        //         }
        //     }
        // });
        foreach ($ls_inter_active as $ls) {
            if (!in_array($ls->teacher_id, $id)) {
                $id[] = $ls->teacher_id;
            }
        }
        $teachers = $teachers->whereNotIn('teacher.teacher_id', $id);
        $teachers = $teachers->orderBy('teacher.teacher_id', 'desc')
            ->get();
        return Datatables::of($teachers)
            ->addColumn('check_box', function ($teacher) {
                $string4 = '';
                $string4 .= '<input type="checkbox" id_customer="' . $teacher->teacher_id . '" class="checkItem" value="' . $teacher->teacher_id . '">';
                return $teacher->teacher_id;
            })
            ->addColumn('is_delete', function ($teacher) {
                $check = Teacher_delete_request::where('teacher_id', $teacher->teacher_id)->first();
                $string1 = '';
                if ($check != null) {
                    // $string1 .= '<span style="color:red">Có</span>';
                    return 1;
                } else {
                    // $string1 .= '<span style="color:green">Không</span>';
                    return 2;
                }

                // return $string1;
            })
            ->addColumn('action', function ($teacher) {
                $string = '';
                $string .= '<a  href="' . route('interactive_index', ['teacher_id' => $teacher->teacher_id]) . '" class="btn btn-info" >Thao tác</a>';
                return $string;
            })
            ->addColumn('exp', function ($teacher) {

                $date = date_create();
                $listExp = \App\Entity\Teacher_experience::listExp($teacher['teacher_id']);
                $min_year = \App\Entity\Teacher_experience::min_Exp($teacher['teacher_id']);
                $min_year = intval($min_year);
                // dd($teacher['teacher_id']);
                $nowYear = (int)date_format($date, "Y");
                $exp_teacher  = 0;
                if ($min_year > 1970) {
                    $exp_teacher = $nowYear - $min_year;
                } else {
                    $min_year = date_format($date, "Y");;
                }
                if ($exp_teacher > 0) {
                    $string2 = $exp_teacher;;
                } else {
                    $string2 = '';
                }




                // $string2 = '';
                // $string2 .= $exp[$teacher->teacher_id];
                return $string2;
            })
            ->make(true);
    }

    public function ajaxProvince($province)
    {
        if ($province == 0) {
            echo '<option> -- Tất cả các quận/huyện --</option>';
        }
        $districts = District::where('province_id', $province)->get();
        echo '<option value="">' . '-- Vui lòng chọn quận huyện --' . '</option>';
        foreach ($districts as $district) {
            echo '<option value="' . $district->district_id . '">' . $district->district_name . '</option>';
        }
    }

    public function edit_interactive(Request $request, $id)
    {
        // dd($request->all());
        try {
            $interactives = InteractiveTeacher::where('id', $id)->update([
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

    public function delete_interactive(Request $request, $id)
    {
        try {
            $interactives = InteractiveTeacher::where('id', $id)->delete();
            $request->session()->flash('success', 'Xóa thành công!');
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Xóa thất bại!');
            return redirect()->back();
        }
    }

    public function SendFeedbackTeacher(Request $request, $id)
    {
        try {
            // dd($id);
            $id_cate_tem = 27;
            $item = Teacher::where('teacher_id', $id)->first();
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

            $replace = [$request->input('feedback'), $item->teacher_name, $item->teacher_email];

            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($item->teacher_email, $subject, $content_string);
            $request->session()->flash('success', 'Phản hồi thành công!');
            return redirect()->back();
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Phản hồi không thành công!');
            return redirect()->back();
        }
    }

    public function send_post_content_teacher(Request $request)
    {
        $teacher_id = $request->input('teacher_id');
        $feedback_all = $request->input('feedback_all');
        $list_teacher = Teacher::select('teacher_id', 'teacher_name', 'teacher_email')->whereIn('teacher_id', $teacher_id)->get();
        //        echo $feedback_all;
        //        echo '<pre>';
        //        print_r($teacher_id);
        //        echo '<hr>';
        //        echo '<pre>';
        //        print_r($list_teacher);die();
        foreach ($list_teacher as $teacher) {
            MailConfigController::send_feedback_all_employee($teacher->teacher_name, $teacher->teacher_email, $feedback_all);
        }
        return redirect()->back()->with('success', 'Phản hồi tất cả thành công!');
    }

    public function SendFeedbackAllTeacher(Request $request)
    {
        //tam thời ẩn
        try {
            // dd($id);
            if (count($request->Ids) > 0) {
                $listAccounting = Teacher::wherein('teacher_id', $request->Ids)->get();
            } else {
                $request->session()->flash('error', 'Vui lòng chọn giáo viên!');
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
                $search = ['{content}', '{name}', '{email}'];
                $replace = [$request->input('content'), $ls->teacher_name, $ls->teacher_email];
                $content = str_replace($search, $replace, $content_email);
                MailConfig::sendMail($ls->teacher_email, $subject, $content);
            }
            $request->session()->flash('success', 'Phản hồi tất cả thành công!');
            return redirect()->back();
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Phản hồi không thành công!');
            return redirect()->back();
        }
    }


    public function staff_store_teacher(Request $request)
    {
        // check xem là dữ liệu hợp lệ không
        $validation = $this->validateTeacher($request);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->with('registerEmployee', 'Đăng ký giáo viên lỗi!')
                ->withInput();
        }
        try {
            DB::beginTransaction();
            // Tạo dữ liệu cho bảng user với role = 2 để đăng nhập nhà tuyển dụng
            $userWithPhone = $this->createUser($request);
            // Lưu thông tin nhà tuyển dụng vào bảng employer.
            $this->createNewTeacher($request, $userWithPhone);
            // Đẩy thông tin lên getfly
            //            $this->addNewCampaignGetfly($request);
            //            Auth::guard()->login($userWithPhone);
            $email = $userWithPhone->email;
            DB::commit();
            MailConfigController::send_email_teacher_confirm($userWithPhone);
        } catch (\Exception $e) {
            Error::setErrorMessage("Không thể Đăng ký tài khoản. Vui lòng thử lại ");
            DB::rollBack();
            return redirect(route('staff_teacher.create'))->with('error', 'Đăng kí giáo viên thất bại! Vui lòng thử lại.');
        } finally {
            return redirect(route('staff_teacher.index'))->with('success', 'Bạn đã tạo thành công tài khoản giáo viên! Vui lòng cập nhật thêm thông tin giáo viên.');
        }
    }

    // check điều kiện submit form
    private function validateTeacher($request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'teacher_name' => 'required',
            'address' => 'required',
            'phone' => 'required',

        ], [
            //            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
            'teacher_name.required' => 'Tên giáo viên không được bỏ trống',
            'address.required' => 'Địa chỉ công ty không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'email.unique' => 'Email Đã tồn tại',

        ]);
        return $validation;
    }

    //dang ki user của bang user
    private function createUser($request)
    {

        $userModel = new User();
        $insert_id = $userModel->insertGetId([
            'name' => $request->input('teacher_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->has('phone') ? $request->input('phone') : '',
            'role' => 3,
            'status_email_account' => 0,
        ]);
        $link_confirm_account = str_random(10) . $insert_id;
        $update = $userModel->where('id', $insert_id)->update([
            'link_confirm_account' => $link_confirm_account
        ]);
        $userWithPhone = $userModel->select('name', 'email', 'password', 'phone', 'status_email_account', 'id', 'link_confirm_account')->where('id', $insert_id)->first();
        return $userWithPhone;
    }

    // tao moi nha giáo viên
    private function createNewTeacher($request, $userWithPhone)
    {
        $teacherMoel = new Teacher();
        $teacherId = $teacherMoel->insertGetId([
            'teacher_name' => $request->input('teacher_name'),
            'user_id' => $userWithPhone->id,
            'district' => $request->input('district'),
            'province' => $request->input('province'),
            'teacher_phone' => $request->input('phone'),
            'teacher_email' => $request->input('email'),
            'address' => $request->input('address'),
            'created_at' => new \DateTime(),
        ]);
        $slug = Ultility::createSlug($request->input('teacher_name'));
        if (!empty(Teacher::where('slug', $slug)->first())) {
            $slug .= '-' . $teacherId;
        }
        Teacher::where('teacher_id', $teacherId)->update([
            'slug' => $slug
        ]);
    }

    public function staff_updateTeacher(Request $request)
    {
        try {
            $teacher = new Teacher();
            $teacher_id = $request->input('teacher_id');
            $tea = $teacher->select('teacher_id', 'slug', 'teacher_name', 'user_id')->where('teacher_id', $teacher_id)->first();
            $updateem_ployee = $teacher->where('teacher_id', $teacher_id)->update([
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
            $update = $user_model->where('id', $tea->user_id)->update([
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
            return redirect()->back()->with('suscess', 'Cập nhật thông tin giáo viên thành công! Vui lòng cập nhật thêm trình độ chuyên môn, kinh nghiệm làm việc, công việc làm thêm...');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật thông tin giáo viên thất bại');
        }
    }

    //    kinh nghiêm
    public function staff_store_Experience_Teacher(Request $request)
    {
        $teacher_id = $request->input('teacher_id');
        try {
            $teacher = new Teacher();
            $tea = $teacher->where('teacher_id', $teacher_id)->first();

            $updateem_teacher = $tea->where('teacher_id', $teacher_id)->update([
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
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thất bại.');
        }
    }

    public function staff_update_Experience_Teacher(Request $request)
    {
        $teacher_id = $request->input('teacher_id');
        try {
            DB::beginTransaction();
            $teacher = new Teacher();
            $tea = $teacher->where('teacher_id', $teacher_id)->first();

            $updateem_ployee = $tea->where('teacher_id', $teacher_id)->update([
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
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('suscess_experience', 'Cập nhật kinh nghiệm làm việc thất bại.');
        }
    }

    //trinh độ
    public function staff_store_Specialize_Teacher(Request $request)
    {
        $teacher_id = $request->input('teacher_id');
        try {

            $teacher = new Teacher();
            $tea = $teacher->select('teacher_id')->where('teacher_id', $teacher_id)->first();
            $updateem_teacher = $teacher->where('teacher_id', $teacher_id)->update([
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
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ giáo viên thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ giáo viên thất bại.');
        }
    }

    public function staff_update_Specialize_Teacher(Request $request)
    {
        $teacher_id = $request->input('teacher_id');
        try {
            DB::beginTransaction();
            $teacher = new Teacher();
            $tea = $teacher->select('teacher_id')->where('teacher_id', $teacher_id)->first();

            $updateem_teacher = $teacher->where('teacher_id', $teacher_id)->update([
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
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ ứng viên thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('suscess_specialize', 'Cập nhật thông tin trình độ ứng viên thất bại.');
        }
    }

    //khoa hoc

    public function staff_store_Course_Teacher(Request $request)
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
        $teacher_id = $request->input('teacher_id');
        try {
            DB::beginTransaction();

            $teacher = new Teacher();
            $teacher = $teacher->select('teacher_id', 'user_id')->where('teacher_id', $teacher_id)->first();

            $course = new \App\Course\Course();
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
            $teacher = $teacher->select('teacher_id')->where('teacher_id', $teacher_id)->first();
            $delete = $course->where('course_id', $teacher->course_id)->delete();
            $update = $teacher->where('teacher_id', $teacher_id)->update(['course_id' => $course_id]);

            //
            DB::commit();
            return redirect()->back()->with('suscess_course', 'Cập nhật khóa học thành công', 'user');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('suscess_course', 'Cập nhật khóa học thất bại');
        }
    }

    public function staff_update_Course_Teacher(Request $request)
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
        $teacher_id = $request->input('teacher_id');
        try {
            DB::beginTransaction();

            $teacher = new Teacher();
            $teacher = $teacher->select('teacher_id', 'user_id', 'course_id')->where('teacher_id', $teacher_id)->first();

            //
            $course = new \App\Course\Course();

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
            return redirect()->back()->with('suscess_course', 'Cập nhật khóa học thành công.', 'user');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('suscess_course', 'Cập nhật khóa học thất bại.');
        }
    }

    //tao ma khoa hoc
    public function code_exam($course_id)
    {
        $course = new \App\Course\Course();

        $id_course = intval($course_id);
        $course_code = 'KH' . ($id_course + 100);
        $update = $course->where('course_id', $course_id)->update([
            'course_code' => $course_code,
        ]);
    }

    public function delete_hard_all(Request $request)
    {
        // dd(1);
        $ids = $request->Ids;
        $arrids = explode(",", $ids);
        foreach ($arrids as $arrid) {
            Teacher::where('teacher_id', $arrid)->forceDelete();
        }
        return response()->json(['success'=>"Xóa hẳn thành công!!!"]);
    }
    public function delete_hard($id)
    {
        Teacher::where('teacher_id', $id)->forceDelete();
        return redirect()->back()->with('success', 'Xóa hẳn thành công!');
    }
    public function reset_teacher($id)
    {
        Teacher::where('teacher_id', $id)->restore();
        return redirect()->back()->with('success', 'Reset thành công!');
    }
    public function delete_all(Request $request)
    {
        $ids = $request->Ids;
        $arrids = explode(",", $ids);
        DB::beginTransaction();
        foreach ($arrids as $arrid) {
            $teacher = Teacher::findOrFail($arrid);

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
        }
        DB::commit();
        return response()->json($ids);
    }

    public function dashboard()
    {
        $teacher = new Teacher();
        $teacher_all = $teacher->count();
        $ls_inter_active = new InteractiveTeacher();
        $ls_inter_actives = $ls_inter_active->get();
        $id = [];
        foreach ($ls_inter_actives as $ls) {
            if (!in_array($ls->teacher_id, $id)) {
                $id[] = $ls->teacher_id;
            }
        }
        $teacher_tt = $teacher->whereIn('teacher_id', $id)->count();
        $teacher_chuyen = $teacher->where('status_accounting', 1)->count();
        $teacher_xoa = $teacher->onlyTrashed()->count();

        $teacherData = $teacher->select(DB::raw("COUNT(*) as count"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))
        ->pluck('count');

        $teacherXoaData = $teacher->select(DB::raw("COUNT(*) as countXoa"))
        ->whereYear("deleted_at", date('Y'))
        ->groupBy(DB::raw("Month(deleted_at)"))->onlyTrashed()
        ->pluck('countXoa');

        $teacherActData = $ls_inter_active->select(DB::raw("COUNT(*) as countAct"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))
        ->pluck('countAct');

        $teacherCTK = $teacher->select(DB::raw("COUNT(*) as countCTK"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->where('status_accounting', 1)
        ->pluck('countCTK');

        return view('staff_admin.dashboard.dashboardTeacher', compact(
            'teacher_all',
            'teacher_tt',
            'teacher_chuyen',
            'teacher_xoa',
            'teacherData',
            'teacherXoaData',
            'teacherActData',
            'teacherCTK'
        ));
    }
}
