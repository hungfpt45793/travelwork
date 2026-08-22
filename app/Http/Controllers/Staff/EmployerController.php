<?php

namespace App\Http\Controllers\Staff;

use App\Support\SpreadsheetFile;
use App\Entity\Business;
use App\Entity\District;
use App\Entity\Employee;
use App\Entity\Employer_contact;
use App\Entity\Employer;
use App\Entity\EmployerAgency;
use App\Entity\EmployerBusiness;
use App\Entity\EmployerIntership;
use App\Entity\EmployerRepresentative;
use App\Entity\EmployerTransaction;
use App\Entity\EmployerTypeBusiness;
use App\Entity\Job;
use App\Entity\JobFacebook;
use App\Entity\MailConfig;
use App\Entity\NoteEmployer;
use App\Entity\Employer_handling;
use App\Entity\Interactive_history_employer;
use App\Entity\Employer_delete_request;
use App\Entity\StarEmployer;
use App\Entity\TeacherStar;
use App\Entity\TypeOfBusiness;
use App\Entity\User;
use App\Exam\CommentExam;
use App\Exam\StarExam;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Entity\Teacher;
use Illuminate\Support\Facades\Log;
use App\Entity\Staff;
use App\Entity\Province;
use App\Entity\Template_email;

class EmployerController extends SiteStaffController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'employer');
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $employers = new Employer();
        $employers = $employers->leftJoin('employer_typeof_business', 'employer_typeof_business.employer_id', 'employer.employer_id');
        $employers = $employers->leftJoin('type_of_business', 'type_of_business.type_of_business_id', 'employer.business');
        $employers = $employers->leftJoin('users', 'users.id', 'employer.user_id');
        $employers = $employers->leftJoin('business_type', 'business_type.business_type_id', 'employer.type_of_business_id');
        $employers = $employers->leftJoin('employer_agency', 'employer_agency.employer_id', 'employer.employer_id');
        $employers = $employers->leftJoin('users as u', 'u.id', 'employer.user_id_handling');
        //            ->leftJoin('type_of_business','type_of_business.type_of_business_id','=','employer_typeof_business.type_of_business_id')
        $employers = $employers->select(
            'employer.*',
            'u.name as user_name'
        );
        if (url()->current() == route('list_employer_follow')) {
            $user_id = Auth::id();
            $staff_id = Staff::where('user_id', $user_id)->value('staff_id');
            $employers = $employers->leftJoin('staff_follow', 'staff_follow.user_id', 'employer.user_id')
                ->where('staff_follow.status_follow', 1)
                ->where('staff_follow.staff_id', $staff_id);
        }
        // tìm theo id ntd
        if (!empty($request->employer_id)) {
            $employers = $employers->where('employer.employer_id', $request->employer_id);
        }
        if (!empty($request->input('business'))) {
            $business = $request->input('business');
            $employers = $employers->where('employer.business', $business);
        }
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            $employers = $employers->whereDate('employer.created_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $employers = $employers->whereDate('employer.created_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('type_of_business_id'))) {
            $type_of_business_id = $request->input('type_of_business_id');
            $employers = $employers->where('employer.type_of_business_id', $type_of_business_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employers = $employers->where('employer.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employers = $employers->where('employer.district', $district);
        }
        if (!empty($request->input('enterprise_name'))) {
            $enterprise_name = $request->input('enterprise_name');
            $employers = $employers->where('enterprise_name', 'like', '%' . $enterprise_name . '%');
        }
        if (!empty($request->input('email'))) {

            $email = $request->input('email');
            $employers = $employers->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('status_intership'))) {
            $status_intership = $request->input('status_intership');
            $employers = $employers->where('employer.status_intership', $status_intership);
        }
        if (!empty($request->input('status_agency'))) {
            $status_agency = $request->input('status_agency');
            $employers = $employers->where('employer.status_agency', $status_agency);
        }
        if ($request->input('status_employer') != null && $request->input('status_employer') != "") {
            $status = $request->input('status_employer');
            $employers = $employers->where('status_employer', $status);
        }
        if (!empty($request->is_delete)) {
            // return 3;
            $id = [];
            $ls = Employer_delete_request::get();
            foreach ($ls as $l) {
                $id[] = $l->employer_id;
            }
            if ($request->is_delete == 1) {
                // return 1;
                $employers->whereNotIn('employer.employer_id', $id);
            }
            if ($request->is_delete == 2) {
                // return 2;
                $employers->whereIn('employer.employer_id', $id);
            }
        }
        $total = $employers->count();

        $employers = $employers->orderBy('employer.employer_id', 'desc');
        if (!empty($request->input('num'))) {
            $num = $request->input('num');
            $employers = $employers->paginate($num);
        } else {
            $employers = $employers->paginate(30);
        }
        $employers->appends(request()->query());

        return view('staff_admin.employer.list', compact('employers', 'total'));
    }

    public function approved_employer(Request $request, $id)
    {
        $update = Employer::where('employer_id', $id)->update([
            'status_employer'    => 1
        ]);
        $create = Employer_handling::insert([
            'employee_id'   => $id,
            'user_id_handling'  => Auth::user()->id,
            'status' => 1,
            'created_at'   => date('Y-m-d H:i:s')
        ]);
        $request->session()->flash('success', 'Duyệt thành công!');
        return redirect()->back();
    }

    public function delete_all_request(Request $request)
    {
        // dd(1);
        try {
            $list_id = $request->Ids;
            for ($i = 0; $i < count($list_id); $i++) {
                $check = Employer_delete_request::where('employer_id', $list_id[$i])->first();
                if ($check == null) {
                    $create = Employer_delete_request::insert([
                        'employer_id' => $list_id[$i],
                        'staff_id'    => Auth::user()->id,
                        'created_at'  => date('Y-m-d H:i:s')
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

    public function approved_all_employer(Request $request)
    {
        $ids = $request->Ids;
        $update = Employer::whereIn('employer_id', $ids)->update([
            'status_employer' => 1
        ]);
        for ($i = 0; $i < count($ids); $i++) {
            $create = Employer_handling::insert([
                'employer_id'   => $ids[$i],
                'user_id_handling'  => Auth::user()->id,
                'status' => 1,
                'created_at'   => date('Y-m-d H:i:s')
            ]);
        }
        $request->session()->flash('success', 'Duyệt thành công!');
        return redirect()->back();
    }

    public function report_employer(Request $request)
    {
        $num = 30;
        if (!empty($request->num)) {
            $num = $request->num;
        }
        $employers = new Employer();
        $employers = $employers->leftJoin('employer_typeof_business', 'employer_typeof_business.employer_id', 'employer.employer_id');
        $employers = $employers->leftJoin('type_of_business', 'type_of_business.type_of_business_id', 'employer.business');
        $employers = $employers->leftJoin('users', 'users.id', 'employer.user_id');
        $employers = $employers->leftJoin('business_type', 'business_type.business_type_id', 'employer.type_of_business_id');
        $employers = $employers->leftJoin('employer_agency', 'employer_agency.employer_id', 'employer.employer_id');
        //            ->leftJoin('type_of_business','type_of_business.type_of_business_id','=','employer_typeof_business.type_of_business_id')
        $employers = $employers->select(
            'employer.*'
        );

        if (!empty($request->input('business'))) {
            $business = $request->input('business');
            $employers = $employers->where('employer.business', $business);
        }
        if (!empty($request->input('type_of_business_id'))) {
            $type_of_business_id = $request->input('type_of_business_id');
            $employers = $employers->where('employer.type_of_business_id', $type_of_business_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employers = $employers->where('employer.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employers = $employers->where('employer.district', $district);
        }
        if (!empty($request->input('enterprise_name'))) {
            $enterprise_name = $request->input('enterprise_name');
            $employers = $employers->where('enterprise_name', 'like', '%' . $enterprise_name . '%');
        }
        if (!empty($request->input('email'))) {

            $email = $request->input('email');
            $employers = $employers->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('status_intership'))) {
            $status_intership = $request->input('status_intership');
            $employers = $employers->where('employer.status_intership', $status_intership);
        }
        if (!empty($request->input('status_agency'))) {
            $status_agency = $request->input('status_agency');
            $employers = $employers->where('employer.status_agency', $status_agency);
        }
        if ($request->compare == 1) {
            if (!empty($request->num_export) || $request->num_export == 0 && $request->num_export != null) {
                $employers = $employers->where('employer.number_export', '<=', $request->num_export);
            }
        }
        if ($request->compare == 0) {

            if (!empty($request->num_export)) {
                $employers = $employers->where('employer.number_export', '>=', $request->num_export);
            }
        }

        if (!empty($request->date_search_start)) {
            $employers = $employers->whereDate('employer.updated_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $employers = $employers->whereDate('employer.updated_at', '<=', $request->date_search_end);
        }
        $total = $employers->count();

        $employers = $employers->orderBy('employer.employer_id', 'desc');
        $employers = $employers->paginate($num);
        $employers->appends(request()->query());
        // dd($employers);
        return view('staff_admin.employer.report_employer', compact('employers', 'total'));
    }

    public function Detail($id)
    {
        // dd($id);
        $employerModel = new Employer();
        $employer = $employerModel->select([
            'employer_id',
            'employer_code',
            'enterprise_name',
            'user_id',
            'phone',
            'email',
            'address',
            'introduction',
            'image',
            'website',
            'slug',
            'status_intership',
            'my_facebook',
            'status_employer',
            'my_zalo'
        ])
            ->where('employer_id', $id)
            ->first();
        $check = 0;
        $check_d = Employer_delete_request::where('employer_id', $id)->first();
        if ($check_d != null) {
            $check = 1;
        }
        $interactives = Interactive_history_employer::select('interactive_history_employer.*', 'u.name as user_name')
            ->leftjoin('users as u', 'u.id', 'interactive_history_employer.user_id')
            ->where('employer_id', $id)
            ->orderby('interactive_history_employer.id', 'desc')->limit(3)->get();
        $history = Employer_handling::select('employer_handling.*', 'u.name as user_name')
            ->leftjoin('users as u', 'u.id', 'employer_handling.user_id_handling')
            ->where('employer_handling.employer_id', $id)
            ->orderby('employer_handling.employer_id', 'desc')->paginate(5);
        $employer_contacts = Employer_contact::where('employer_id', $id)->get();
        return view('staff_admin.employer.interactive', compact('interactives', 'employer', 'check', 'history', 'employer_contacts'));
    }

    public function delete_interactive(Request $request, $id)
    {
        try {
            $interactives = Interactive_history_employer::where('id', $id)->delete();
            $request->session()->flash('success', 'Xóa thành công!');
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Xóa thất bại!');
            return redirect()->back();
        }
    }

    public function edit_interactive(Request $request, $id)
    {
        // dd($request->all());
        try {
            $interactives = Interactive_history_employer::where('id', $id)->update([
                'content' => $request->input('content'),
                'interactive_day'   => $request->input('interactive_day'),
                'updated_at'    => date('Y-m-d H:i:s')
            ]);
            $request->session()->flash('success', 'Cập nhật thành công!');
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Cập nhật thất bại!');
            return redirect()->back();
        }
    }

    public function form_edit(Request $request, $id)
    {
        // dd(1);
        $employer = Employer::where('employer_id', $id)->first();
        // dd($employer);
        if ($employer == null) {
            $request->session()->flash('error', 'Không tìm thấy nhà tuyển dụng!');
            return redirect()->back();
        }
        $typeBusinessList = TypeOfBusiness::orderBy('type_of_business_name')->get();
        $businessList = Business::orderBy('business_type_name')->get();

        $staff = User::where('role', 3)->get();
        $employerTypeBusinessList = EmployerTypeBusiness::where('employer_id', $employer->id)->get();
        $employerBusinessList = EmployerBusiness::where('employer_id', $employer->id)->get();
        $representatives = EmployerRepresentative::where('employer_id', $employer->id)->get();
        $staffCharge = User::where('id', $employer->user_id)->first();
        $employer_agency = EmployerAgency::select('*')->where('employer_id', $employer->employer_id)->first();
        // dd($employer);
        return view('staff_admin.employer.edit', compact(
            'employer',
            'typeBusinessList',
            'businessList',
            'staff',
            'employerTypeBusinessList',
            'employerBusinessList',
            'representatives',
            'staffCharge',
            'employer_agency'
        ));
        // return view('staff_admin.employer.edit', compact('employee', 'jobs', 'salaries', 'staffInCharges', 'softwareList', 'careers'));
    }

    public function Create_Interactive_Employer(Request $request, $id)
    {
        // dd($id);
        try {
            // $check = Interactive_history_employee::orderby('id','desc')->first();
            $create = Interactive_history_employer::insert([
                // 'id'          => $check != null? $check->id + 1:1,
                'employer_id' => $id,
                'interactive_day'   => $request->input('interactive_day'),
                'user_id'     => Auth::user()->id,
                'content'     => $request->input('content'),
                'created_at'  => date('Y-m-d H:i:s')
            ]);
            $request->session()->flash('success', 'Tạo tương tác thành công!');
            return redirect()->back();
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Tạo tương tác không thành công!');
            return redirect()->back();
        }
    }


    public function create()
    {
        $typeBusinessList = TypeOfBusiness::orderBy('type_of_business_name')->get();
        $businessList = Business::orderBy('business_type_name')->get();
        $staff = User::where('role', 3)->orderBy('name')->get();
        return view('staff_admin.employer.create', compact('typeBusinessList', 'businessList', 'staff'));
        // return view('staff_admin.employer.create');
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'address' => 'required',
            'employer_name' => 'required',
            'phone' => 'required'
        ], [
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu Phải lớn hơn 6 ký tự.',
            'address.required' => 'Địa chỉ công ty không được bỏ trống',
            'employer_name.required' => 'Tên công ty không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
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
                'name' => $request->input('employer_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->has('phone') ? $request->input('phone') : '',
                'role' => 2
            ]);
            $employerId = Employer::insertGetId([
                'enterprise_name' => $request->input('employer_name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'district' => $request->input('district'),
                'province' => $request->input('province'),
                'status' => $request->input('status'),
                'address' => $request->input('address'),
                'introduction' => $request->input('introduction'),
                'image' => $request->input('image'),
                'user_id'   => $user_id_create,
                'status_select_employer' => 2,
                'user_id_create_select_employer' => 1,
                'status_employer'    => 1,
                'user_id_handling'  => Auth::user()->id,
                'day_handling'   => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $slug = Ultility::createSlug($request->input('employer_name'));
            if (!empty(Employer::where('slug', $slug)->first())) {
                $slug .= '-' . $employerId;
            }
            Employer::where('employer_id', $employerId)->update([
                'slug' => $slug
            ]);
            DB::commit();
            $request->session()->flash('success', 'Thêm nhà tuyển dụng thành công!');
            $url = redirect()->route('detail_employer_with_staff_admin', $employerId)->getTargetUrl();
            return redirect($url);
        } catch (\Exception $exception) {
            DB::rollBack();
            $request->session()->flash('error', 'Thêm nhà tuyển dụng thất bại!');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $employer = Employer::findOrFail($id);
        return view('staff_admin.employer.edit', compact('employer'));
    }
    public function update(Request $request, $id)
    {
        //        echo $request->input('type_of_business_id');
        //        echo $request->input('business');
        //        die();
        $validation = Validator::make($request->all(), [
            'address' => 'required',
            'employer_name' => 'required',
            'phone' => 'required'
        ], [
            'email.required' => 'Bạn chưa nhập email.',
            // 'email.unique' => 'Email đã tồn tại.',
            'address.required' => 'Địa chỉ công ty không được bỏ trống',
            'employer_name.required' => 'Tên công ty không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',

        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            $employer = Employer::where('employer_id', $id)->first();
            DB::beginTransaction();

            $userModel = new User();
            $user = $userModel->where('id', $employer->user_id)->first();

            $isChangePassword = $request->input('is_change_password');
            if ($isChangePassword == 1) {
                $update = $userModel->where('id', $employer->user_id)->update([
                    'name' => $request->input('employer_name'),
                    'password' => bcrypt($request->input('password')),
                    'phone' => $request->has('phone') ? $request->input('phone') : ''
                ]);
            }

            $employers = new Employer();
            $updateEmployer = $employers->where('employer_id', $employer->employer_id)->update([
                'enterprise_name' => $request->input('employer_name'),
                'phone' => $request->input('phone'),
                // 'email' => $request->input('email'),
                'district' => $request->input('district'),
                'province' => $request->input('province'),
                'status' => $request->input('status'),
                'address' => $request->input('address'),
                'introduction' => $request->input('introduction'),
                'image' => $request->input('image'),
                'updated_at' => new \DateTime()
            ]);

            $slug = Ultility::createSlug($request->input('employer_name'));
            if (!empty($employers->where('slug', $slug)->first())) {
                $slug .= '-' . $employer->employer_id;
            }
            $slugs = $employers->where('employer_id', $employer->employer_id)->update([
                'slug' => $slug
            ]);
            DB::commit();
            $request->session()->flash('success', 'Cập nhật nhà tuyển dụng thành công!');
            $url = redirect()->route('detail_employer_with_staff_admin', $id)->getTargetUrl();
            return redirect($url);
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Cập nhật nhà tuyển dụng thất bại!');
            return redirect()->back();
        }
    }

    public function delete_request(Request $request, $id)
    {
        try {
            $update = Employer_delete_request::insert([
                'employer_id' => $id,
                'staff_id'    => Auth::user()->id,
                'created_at'  => date('Y-m-d H:i:s')
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
            $update = Employer_delete_request::where('employer_id', $id)->delete();
            $request->session()->flash('success', 'Bỏ đề nghị xóa thành công!');
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Bỏ đề nghị xóa thất bại!');
            return redirect()->back();
        }
    }
    public function statistical()
    {
        $provinces = Province::select('province_id', 'province_name')->get();
        $province_ids = Province::select('province_id')->get()->toArray();
        foreach ($province_ids as $province_id) {
            $count_teacher = Employer::where('province', $province_id['province_id'])
                ->count();
            $arr_province[] = [
                $province_id['province_id'],
                $count_teacher
            ];
        }
        //số phần tử mảng arr_province
        $lenght = count($arr_province);
        for ($i = 0; $i < ($lenght - 1); $i++) {
            for ($j = $i + 1; $j < $lenght; $j++) {
                if ($arr_province[$i][1] < $arr_province[$j][1]) {
                    // hoán vị
                    $tmp = $arr_province[$j];
                    $arr_province[$j] = $arr_province[$i];
                    $arr_province[$i] = $tmp;
                }
            }
        }
        foreach ($arr_province as $ap) {
            $name = Province::where('province_id', $ap[0])->value('province_name');
            if ($ap[1] > 0) {
                $name_province[] = $name;

                $count_province[] = $ap[1];
            }
        }
        return view('staff_admin.employer.employer_province', compact('provinces', 'name_province', 'count_province'));
    }
    public function statistical12month(Request $request){
        if(!empty($request->year)){
            for($i = 0; $i < 12; $i++){
                $count_employer = Employer::whereYear('updated_at', $request->year)->whereMonth('updated_at', $i)->count();
                $arr_employer[] = $count_employer;
            }

            return view('staff_admin.employer.employer_month', compact('arr_employer'));
        }
        return view('staff_admin.employer.employer_month');
    }
    public function district($province_id)
    {
        $districts = District::select('district_id')->where('province_id', $province_id)->get()->toArray();
        foreach ($districts as $district) {
            $count_teacher = Employer::where('district', $district['district_id'])
                ->count();
            $arr_district[] = [
                $district['district_id'],
                $count_teacher
            ];
        }
        $lenght = count($arr_district);
        for ($i = 0; $i < ($lenght - 1); $i++) {
            for ($j = $i + 1; $j < $lenght; $j++) {
                if ($arr_district[$i][1] < $arr_district[$j][1]) {
                    // hoán vị
                    $tmp = $arr_district[$j];
                    $arr_district[$j] = $arr_district[$i];
                    $arr_district[$i] = $tmp;
                }
            }
        }
        foreach ($arr_district as $ad) {
            $name = District::where('district_id', $ad[0])->value('district_name');
            if ($ad[1] > 0) {
                $name_district[] = $name;

                $count_district[] = $ad[1];
            }
        }
        $province_name = Province::where('province_id', $province_id)->value('province_name');
        $districts = District::select('district_id', 'district_name')
            ->where('province_id', $province_id)
            ->get();
        if (!empty($name_district)) {
            return view('staff_admin.employer.employer_district', compact('districts', 'province_name', 'province_id', 'name_district', 'count_district'));
        }
        return view('staff_admin.employer.employer_district', compact('districts', 'province_name', 'province_id'));
    }
    public static function countEmployerP($province_id)
    {
        return $count_teacher = Employer::where('province', $province_id)
            ->count();
    }
    public static function countEmployerD($district_id)
    {
        return $count_teacher = Employer::where('district', $district_id)
            ->count();
    }

    public function list_deleted(Request $request)
    {
        $employers = new Employer();
        $employers = $employers->leftJoin('employer_typeof_business', 'employer_typeof_business.employer_id', 'employer.employer_id');
        $employers = $employers->leftJoin('type_of_business', 'type_of_business.type_of_business_id', 'employer.business');
        $employers = $employers->leftJoin('users', 'users.id', 'employer.user_id');
        $employers = $employers->leftJoin('business_type', 'business_type.business_type_id', 'employer.type_of_business_id');
        $employers = $employers->leftJoin('employer_agency', 'employer_agency.employer_id', 'employer.employer_id');
        $employers = $employers->leftJoin('users as u', 'u.id', 'employer.user_id_handling');
        //            ->leftJoin('type_of_business','type_of_business.type_of_business_id','=','employer_typeof_business.type_of_business_id')
        $employers = $employers->select(
            'employer.*',
            'u.name as user_name'
        );
        if (url()->current() == route('list_employer_follow')) {
            $user_id = Auth::id();
            $staff_id = Staff::where('user_id', $user_id)->value('staff_id');
            $employers = $employers->leftJoin('staff_follow', 'staff_follow.user_id', 'employer.user_id')
                ->where('staff_follow.status_follow', 1)
                ->where('staff_follow.staff_id', $staff_id);
        }
        if (!empty($request->input('business'))) {
            $business = $request->input('business');
            $employers = $employers->where('employer.business', $business);
        }
        if (!empty($request->date_search_start)) {
            $date_start = date_create($request->date_search_start);
            $date_search_start = date_format($date_start, "Y/m/d");
            $employers = $employers->whereDate('employer.deleted_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $date_end = date_create($request->date_search_end);
            $date_search_end = date_format($date_end, "Y/m/d");
            $employers = $employers->whereDate('employer.deleted_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('type_of_business_id'))) {
            $type_of_business_id = $request->input('type_of_business_id');
            $employers = $employers->where('employer.type_of_business_id', $type_of_business_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employers = $employers->where('employer.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employers = $employers->where('employer.district', $district);
        }
        if (!empty($request->input('enterprise_name'))) {
            $enterprise_name = $request->input('enterprise_name');
            $employers = $employers->where('enterprise_name', 'like', '%' . $enterprise_name . '%');
        }
        if (!empty($request->input('email'))) {

            $email = $request->input('email');
            $employers = $employers->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('status_intership'))) {
            $status_intership = $request->input('status_intership');
            $employers = $employers->where('employer.status_intership', $status_intership);
        }
        if (!empty($request->input('status_agency'))) {
            $status_agency = $request->input('status_agency');
            $employers = $employers->where('employer.status_agency', $status_agency);
        }
        if ($request->input('status_employer') != null && $request->input('status_employer') != "") {
            $status = $request->input('status_employer');
            $employers = $employers->where('status_employer', $status);
        }
        if (!empty($request->is_delete)) {
            // return 3;
            $id = [];
            $ls = Employer_delete_request::get();
            foreach ($ls as $l) {
                $id[] = $l->employer_id;
            }
            if ($request->is_delete == 1) {
                // return 1;
                $employers->whereNotIn('employer.employer_id', $id);
            }
            if ($request->is_delete == 2) {
                // return 2;
                $employers->whereIn('employer.employer_id', $id);
            }
        }
        $employers = $employers->onlyTrashed();

        $total = $employers->count();

        $employers = $employers->orderBy('employer.employer_id', 'desc');
        if (!empty($request->input('num'))) {
            $num = $request->input('num');
            $employers = $employers->paginate($num);
        } else {
            $employers = $employers->paginate(30);
        }
        $employers->appends(request()->query());


        return view('staff_admin.employer.list_deleted', compact('employers', 'total'));
    }
    public function SendFeedbackEmployer(Request $request, $id)
    {
        try {
            // dd($id);
            $id_cate_tem = 27;
            $item = Employer::where('employer_id', $id)->first();
            $create = Employer_handling::insert([
                'user_id_handling'  => Auth::user()->id,
                'employer_id'       => $id,
                'status'            => $item->status_employer,
                'feedback'          => $request->input('feedback'),
                'created_at'        => date('Y-m-d H:i:s')
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

            $replace = [$request->input('feedback'), $item->enterprise_name, $item->email];

            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($item->email, $subject, $content_string);
            $request->session()->flash('success', 'Phản hồi thành công!');
            return redirect()->back();
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Phản hồi không thành công!');
            return redirect()->back();
        }
    }
    public function SendFeedbackAllEmployer(Request $request)
    {
        try {
            // dd($id);
            if (count($request->Ids) > 0) {
                $listAccounting     = Employer::wherein('employer_id', $request->Ids)->get();
            } else {
                $request->session()->flash('error', 'Vui lòng chọn NTD!');
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
                    $create = Employer_handling::insert([
                        'user_id_handling'  => Auth::user()->id,
                        'employer_id'       => $ls->employer_id,
                        'status'            => $ls->status_employer,
                        'feedback'          => $request->input('content'),
                        'created_at'        => date('Y-m-d H:i:s')
                    ]);
                    $search = ['{content}', '{name}', '{email}'];
                    $replace = [$request->input('content'), $ls->enterprise_name, $ls->email];
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

    public function destroy($id)
    {
        //
    }
    public function delete_all(Request $request)
    {
        $ids = $request->Ids;
        $arrids = explode(",", $ids);
        DB::beginTransaction();
        foreach ($arrids as $arrid) {
            $employer = Employer::findOrFail($arrid);
            $user = new User();
            $user = $user->where('id', $employer->user_id)->delete();
            $employer->delete();
            //xóa tin tuyen dung
            $jobs = new Job();
            $jobs = $jobs->where('employer_id', $arrid)->delete();
            $jobfacebook = new  JobFacebook();
            $jobfacebook = $jobfacebook->where('employer_id', $arrid)->delete();
        }
        DB::commit();
        return response()->json($ids);
    }
    public function delete_hard_all(Request $request)
    {
        // dd(1);
        $ids = $request->Ids;
        $arrids = explode(",", $ids);
        foreach ($arrids as $arrid) {
            $id = Employer::onlyTrashed()->where('employer_id', $arrid)->value('user_id');
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 5) {
                $user_model = new User();
                $delete_user = $user_model->where('id', $id)->delete();
                $user = $user_model->onlyTrashed()->where('id', $id)->first();

                //            xóa ứng viên và xóa vĩnh viễn
                //

                $delete  = \App\Http\Controllers\Admin\UserController::deleteEmployer($id);

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
                $forceDelete = $user_model->withTrashed()
                    ->where('id', $id)
                    ->forceDelete();
            }
            DB::commit();
        }
        return response()->json($ids);
    }
    public function delete_hard($employer_id)
    {
        try {
            $id = Employer::onlyTrashed()->where('employer_id', $employer_id)->value('user_id');
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 5) {
                $user_model = new User();
                $delete_user = $user_model->where('id', $id)->delete();
                $user = $user_model->onlyTrashed()->where('id', $id)->first();

                //            xóa ứng viên và xóa vĩnh viễn
                //

                $delete  = \App\Http\Controllers\Admin\UserController::deleteEmployer($id);

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
                $forceDelete = $user_model->withTrashed()
                    ->where('id', $id)
                    ->forceDelete();
            }
            DB::commit();
            return redirect()->back()->with('success', 'Xóa hẳn thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('success', 'Xóa vĩnh viễn thất bại!');
        }
    }
    public function reset_employer($id)
    {
        Employer::where('employer_id', $id)->restore();
        return redirect()->back()->with('success', 'Reset thành công!');
    }
    public function exportExcelEmployer(Request $request)
    {
        $employer = new Employer();
        $employers = $employer->select(
            'employer.employer_id',
            'employer.status_employer',
            'employer.updated_at',
            'employer.employer_code',
            'employer.status_intership',
            'employer.business',
            'business_type.business_type_name',
            'type_of_business.type_of_business_name',
            'employer.enterprise_name',
            'employer.image',
            'employer.email',
            'employer.number_export',
            'employer.phone',
            'users.name',
            'employer.district',
            'employer.province',
            'employer.status',
            'employer.total_money_coin',
            'employer.status_intership',
            'province.province_id',
            'province.province_name',
            'district.district_id',
            'district.district_name'
        );
        $employers = $employers->leftJoin('employer_typeof_business', 'employer_typeof_business.employer_id', '=', 'employer.employer_id');
        $employers = $employers->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'employer.business');
        $employers = $employers->leftJoin('users', 'users.id', 'employer.user_id');
        $employers = $employers->leftJoin('business_type', 'business_type.business_type_id', '=', 'employer.type_of_business_id');
        $employers = $employers->leftJoin('province', 'province.province_id', '=', 'employer.province');
        $employers = $employers->leftJoin('district', 'district.district_id', '=', 'employer.district');
        $employers = $employers->leftJoin('employer_agency', 'employer_agency.employer_id', '=', 'employer.employer_id')->orderBy('employer.updated_at', 'DESC');
        //            ->leftJoin('type_of_business','type_of_business.type_of_business_id','=','employer_typeof_business.type_of_business_id')
        if (!empty($request->input('business'))) {
            $business = $request->input('business');
            $employers = $employers->where('employer.business', $business);
        }
        if (!empty($request->input('type_of_business_id'))) {
            $type_of_business_id = $request->input('type_of_business_id');
            $employers = $employers->where('employer.type_of_business_id', $type_of_business_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employers = $employers->where('employer.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employers = $employers->where('employer.district', $district);
        }
        if (!empty($request->input('enterprise_name'))) {
            $enterprise_name = $request->input('enterprise_name');
            $employers = $employers->where('enterprise_name', 'like', '%' . $enterprise_name . '%');
        }
        if (!empty($request->input('email'))) {

            $email = $request->input('email');
            $employers = $employers->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('status_intership'))) {
            $status_intership = $request->input('status_intership');
            $employers = $employers->where('employer.status_intership', $status_intership);
        }
        if (!empty($request->input('status_agency'))) {
            $status_agency = $request->input('status_agency');
            $employers = $employers->where('employer.status_agency', $status_agency);
        }
        if ($request->compare == 1) {
            if (!empty($request->num_export) || $request->num_export == 0 && $request->num_export != null) {
                $employers = $employers->where('employer.number_export', '<=', $request->num_export);
            }
        }
        if ($request->compare == 0) {

            if (!empty($request->num_export)) {
                $employers = $employers->where('employer.number_export', '>=', $request->num_export);
            }
        }
        if (!empty($request->date_search_start)) {
            $employers = $employers->whereDate('employer.updated_at', '>=', $request->date_search_start);
        }
        if (!empty($request->date_search_end)) {
            $employers = $employers->whereDate('employer.updated_at', '<=', $request->date_search_end);
        }

        if(!empty($request->list_id)){
            $employers = $employers->whereIn('employer.employer_id', $request->list_id);
        }
        $employers = $employers->get();

        $data[] = array(
            'Stt',
            // 'Ngày update',
            'Tên công ty',
            // 'Trạng thái',
            // 'Thành phố',
            // 'Quận Huyện',
            // 'Số tin tuyển dụng',
            // 'Số tin TD/FB',
            // 'Tuyển thực tập',
            'Email',
            // 'Số điện thoại',
            // 'Loại hình doanh nghiệp',
            // 'Loại hình kinh doanh   '
        );

        foreach ($employers as $id_emplo => $eplo) {
            $number = $eplo->number_export + 1;
            $eplo->update([
                'number_export' => $number,
            ]);
            $date = date_create($eplo->updated_at);
            $date_updated = date_format($date, "d/m/Y");

            if ($eplo->status_employer == 0) {
                $status = 'Chưa duyệt';
            } else {
                $status = 'Đã duyệt';
            }
            $totalJob = \App\Entity\Job::getAllJobEmployer($eplo->employer_id);
            $totalJobfacebook = \App\Entity\JobFacebook::getAllJobFacebookEmployer($eplo->employer_id);
            if ($eplo->status_intership == 0) {
                $ttt = 'không';
            } else {
                $ttt = 'có';
            }

            $data[] = array(
                $id_emplo + 1,
                // $date_updated,
                $eplo->enterprise_name,
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
        $fileName = "Danh-sach-cong-ty-tuyen-thuc-tap_" . $date->format("d/m/y");
        return SpreadsheetFile::download($data, $fileName, ['font' => 'Arial']);
    }

    public function add_employer_contact(Request $request)
    {
        $contact_name = $request->contact_name;
        $contact_office = $request->contact_office;
        $contact_phone = $request->contact_phone;
        $contact_email = $request->contact_email;
        $contact_note = $request->contact_note;
        $employer_id = $request->employer_id;

        $employer_contact_id = Employer_contact::insertGetId([
            'contact_name' => $contact_name,
            'employer_id' => $employer_id,
            'contact_office' => $contact_office,
            'contact_phone' => $contact_phone,
            'contact_email' => $contact_email,
            'contact_note' => $contact_note,
            'created_at' => new \Datetime()
        ]);
        return Employer_contact::findOrFail($employer_contact_id);
    }

    public function update_employer_contact(Request $request)
    {
        $employer_contact_id = $request->employer_contact_id;
        $content = $request->input('content');
        $column_name = $request->column_name;
        Employer_contact::findOrFail($employer_contact_id)->update([
            $column_name => $content,
        ]);
    }

    public function delete_employer_contact(Request $request)
    {
        $employer_contact_id = $request->employer_contact_id;
        Employer_contact::findOrFail($employer_contact_id)->delete();
    }

    public function dashboard()
    {
        $employer = new Employer();
        $countemployer = $employer->count();
        $employer_chua_duyet = $employer->where('status_employer', 0)->count();
        $employer_da_duyet = $employer->where('status_employer', 1)->count();
        $employer_xoa = $employer->onlyTrashed()->count();
        $job = new Job();
        $countJob = $job->withTrashed()->count();
        $job_duyet = $job->where('active_job', 1)->count();

        $employerChuaDuyetData = Employer::select(DB::raw("COUNT(*) as countChuaDuyet"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->where('status_employer', 0)
        ->pluck('countChuaDuyet');
        $employerDaDuyetData = Employer::select(DB::raw("COUNT(*) as countDaDuyet"))
        ->whereYear("created_at", date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->where('status_employer', 1)
        ->pluck('countDaDuyet');
        $employerDaXoaData = Employer::select(DB::raw("COUNT(*) as countXoa"))
        ->whereYear("deleted_at", date('Y'))
        ->groupBy(DB::raw("Month(deleted_at)"))->onlyTrashed()
        ->pluck('countXoa');

        return view('staff_admin.dashboard.dashboardEmployer', compact(
            'countemployer',
            'employer_chua_duyet',
            'employer_da_duyet',
            'employer_xoa',
            'countJob',
            'job_duyet',
            'employerChuaDuyetData',
            'employerDaDuyetData',
            'employerDaXoaData'
        ));
    }
}
