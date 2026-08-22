<?php

namespace App\Http\Controllers\Site;

use App\Entity\EmployerEmployee;
use App\Entity\EmployerTransfer;
use App\Entity\Invite;
use App\Entity\MailConfig;
use App\Entity\SettingGetfly;
use App\Entity\Teacher;
use App\Entity\Template;
use App\Entity\Template_email;
use App\Ultility\CallApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Business;
use App\Entity\District;
use App\Entity\Employer;
use App\Entity\EmployerBusiness;
use App\Entity\EmployerRepresentative;
use App\Entity\EmployerTypeBusiness;
use App\Entity\NoteEmployer;
use App\Entity\TypeOfBusiness;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Entity\Remuneration;
use App\Entity\Reason_choose;

class TeacherController extends SiteController
{
    public function createTeacher(Request $request) {
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
            $this->createNewTeacher($request,$userWithPhone);
            // Đẩy thông tin lên getfly
//            $this->addNewCampaignGetfly($request);
            Auth::guard()->login($userWithPhone);
            $email = $userWithPhone->email;
            DB::commit();
            MailConfigController::send_email_teacher_confirm($userWithPhone);
        } catch (\Exception $e) {
            Error::setErrorMessage("Không thể Đăng ký tài khoản. Vui lòng thử lại ");
            DB::rollBack();
            return redirect(route('employer_register'))->with('error','Đăng kí giáo viên thất bại ! Vui lòng thử lại');
        }
        finally {
            return redirect(route('show_file_job_facebook'))->with('success_login','Bạn đã tạo thành công tài khoản giáo viên ! Vui lòng cập nhật thêm thông tin giáo viên');
        }
    }
    // check điều kiện submit form
    private function validateTeacher($request) {
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password'=>'required|min:8',
            'teacher_name'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'g-recaptcha-response' => 'required'
        ],[
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
            'teacher_name.required'=>'Tên giáo viên không được bỏ trống',
            'address.required'=>'Địa chỉ công ty không được bỏ trống',
            'phone.required'=>'Số điện thoại không được bỏ trống',
            'email.unique'=> 'Email Đã tồn tại',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy hoặc  Im not a robot'
        ]);
        return $validation;
    }
    //dang ki user của bang user
    private function createUser($request) {

        $userModel = new User();
        $insert_id = $userModel->insertGetId([
            'name' => $request->input('teacher_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->has('phone') ? $request->input('phone') : '',
            'role' => 3,
            'status_email_account' => 0,
        ]);
        $link_confirm_account =str_random(10).$insert_id;
        $update = $userModel->where('id',$insert_id)->update([
            'link_confirm_account' => $link_confirm_account
        ]);
        $userWithPhone = $userModel->select('name','email','password','phone','status_email_account','id','link_confirm_account')->where('id',$insert_id)->first();
        return $userWithPhone;
    }
    // tao moi nha giáo viên
    private function createNewTeacher ($request, $userWithPhone) {
        $teacherMoel = new Teacher();
        $teacherId = $teacherMoel->insertGetId([
            'teacher_name' => $request->input('teacher_name'),
            'user_id'=> $userWithPhone->id,
            'district'=>$request->input('district'),
            'province'=>$request->input('province'),
            'teacher_phone' => $request->input('phone'),
            'teacher_email' => $request->input('email'),
            'address' => $request->input('address'),
            'created_at' => new \DateTime(),
        ]);
        $slug = Ultility::createSlug($request->input('teacher_name'));
        if(!empty(Teacher::where('slug', $slug)->first())){
            $slug .= '-' . $teacherId;
        }
        Teacher::where('teacher_id', $teacherId)->update([
            'slug' => $slug
        ]);
    }


    public function employeeManagement($slug){
        $user = Auth::user();
        $employer = Employer::where('slug', $slug)->first();
        if(!empty($employer)){
            $employees = Invite::join('employer','employer.employer_id','=', 'invite.employer_id')
                ->join('jobs','jobs.job_id', '=','invite.job_id')
                ->join('employees','employees.employee_id','=','invite.employee_id')
                ->where('invite.updated_at', null)
                ->where('employer.employer_id', $employer->employer_id)
                ->select('employees.employee_name as employee_name',
                    'jobs.title as title',
                    'employees.employee_id as employee_id',
                    'jobs.job_id as job_id',
                    'invite.created_at as created_at',
                    'invite.status as status')
                ->paginate(10);
        }
        return view('site.infomation.employer.employee_management', compact('employees', 'employer','user'));
    }
}
