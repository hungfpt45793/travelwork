<?php

namespace App\Http\Controllers\Api;

use App\Entity\Employee;
use App\Entity\Employee_career_categories;
use App\Entity\Employee_district;
use App\Entity\Employee_experience;
use App\Entity\Employee_profile;
use App\Entity\Employee_specialize;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Employer;
use App\Entity\Forum_notification;
use App\Entity\Job;
use App\Entity\JobFacebook;
use App\Entity\NotificationWindow;
use App\Entity\Salary;

use App\Entity\User_forum_code_intro;
use App\Http\Controllers\Site\MailConfigController;
use App\Ultility\Ultility;
use Google\Service\HangoutsChat\DateInput;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\Validator;
use JWTAuth;
use App\Entity\User;
use Validator;

class ResgisterController extends Controller
{
    public function resgister_account(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
            'name' => 'required',
        ], [
            'name.required' => 'Họ và tên không được để trống',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'email.required' => 'Bạn chưa nhập email, Vui lòng nhập email mới ',
            'email.unique' => 'Email đã tồn tại.',
            'email.email' => 'Vui lòng nhập đúng định dạng email.',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
        ]);
        if ($validation->fails()) {
            $massage = '';
            foreach ($validation->errors()->all() as $error) {
                $massage .= $error;
            }
            return response()->json([
                'status' => 400,
                'message' => $massage,
            ], 400);
        }

        $user_model = new User();
        $step = 'step1';
        $userWithPhone = $this->createUser($request);
        //Tạo ứng viên trong bảng employee
        $createEmployee = $this->createNewEmployee($request, $userWithPhone);
        $employee_model = new Employee();
        $employee_id = $employee_model->where('user_id', $userWithPhone->id)->value('employee_id');
        $profile_info = $employee_model->get_profile_info($userWithPhone->id);
        $profile_employee = $profile_info;
        //cong điểm cho ứng viên
        $update_profile = Employee::where('user_id', $userWithPhone->id)->update([
            'profile' => $profile_employee
        ]);
        //thêm vào bảng profile
        $insert_employee_profile = Employee_profile::insert([
            'employee_id' => $employee_id,
            'profile_info' => $profile_info,
            'profile_course' => 0,
            'created_at' => new \DateTime()
        ]);
        //cập nhật thêm bảng mã giới thiệu
        if (!empty($request->input('diendan_code_intro'))) {
            $user_code_intro = User::where('diendan_code_intro', $request->input('diendan_code_intro'))->select('id', 'diendan_code_intro', 'name','user_coin')->first();
            if (!empty($user_code_intro)) {
                $insert_code_intro = User_forum_code_intro::insert([
                    'user_id' => $userWithPhone->id, //id người đăng ký
                    'user_id_intro' => $user_code_intro->id, //id người giới thiệu
                    'diendan_code_intro' => $user_code_intro->diendan_code_intro, //mã giới thiệu của id giới thiệu
                    'diendan_code_status' => 0, //mã giới thiệu của id giới thiệu
                    'created_at' => new \DateTime()
                ]);
//                nếu user này xác thực bên saketoan.vn thì mới dc cộng xu
                //cộng thêm 5xu cho tài khoản giới thiệu
                $noti_model = new Forum_notification();
                $noti_title = 'Bạn sẽ được nhận + 5 xu khi ' . $request->input('name') .' đã nhập mã giới thiệu của bạn và xác thực tài khoản bên sanketoan.vn';
                $noti_id = $noti_model->insertGetId([
                    'noti_title' => $noti_title,
                    'for_post_id' => 0,
                    'for_comment_id' => 0,
                    'user_id' => $user_code_intro->id,
                    'user_id_comment' => 0,
                    'noti_type' => 'user_pro',
                    'noti_status' => 0,
                    'created_at' => new \DateTime()
                ]);

                //push noti cho app
                $title = 'Sàn kế toán thông báo';
                $type = 'forum';
                $note = 'Tặng xu khi nhập mã giới thiệu';
                $value = $noti_id;
                $to = $user_code_intro->id;
                $push_noti_app = new NotificationMobileController();
                $send_push = $push_noti_app->pushNotification( $title, $noti_title, $to,$type,$note,$value);

//                //cọng thêm 5 xu cho user dc giơi thiêu
//                $update_user_coin = User::where('id',$user_code_intro->id)->update([
//                   'user_coin' => $user_code_intro->user_coin + 5
//                ]);
            }
        }

        if(empty($insert_employee_profile))
        {
            $massage = 'Đăng ký tài khoản thất bại ! Vui Lòng thử lại';
            return response()->json([
                'status' => 400,
                'message' => $massage,
            ], 400);
        }
        $massage = 'Đăng ký tài khoản thành công !';
        return response()->json([
            'status' => 200,
            'message' => $massage,
            'user' => $userWithPhone,
            'step' => $step,
        ], 200);

    }

    //dang ki user của bang user
    private function createUser($request)
    {
        $userModel = new User();
        $insert_id = $userModel->insertGetId([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'step' =>'step1',
            'role' =>'1',
            'status_res_api' =>1,
            'user_coin' => 0,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);
        $link_confirm_account = str_random(10) . $insert_id;
        $update = $userModel->where('id', $insert_id)->update([
            'link_confirm_account' => $link_confirm_account
        ]);
        $diendan_code_intro = Ultility::create_random_string(1,3).$insert_id;
        $update_code_intro = User::where('id',$insert_id)->update([
            'diendan_code_intro' => $diendan_code_intro
        ]);

        $userWithPhone = $userModel->select('name', 'email', 'password', 'phone', 'status_email_account','role', 'id', 'link_confirm_account','diendan_code_intro')->where('id', $insert_id)->first();
        return $userWithPhone;
    }


//    tao mới ưng viên
    private function createNewEmployee($request, $userWithPhone)
    {
        try {
            $employeeId = Employee::insertGetId([
                'employee_name' => $userWithPhone['name'],
                'phone' => $userWithPhone['phone'],
                'email' => $userWithPhone['email'],
                'user_id' => $userWithPhone['id'],
                'status' => 0,
                'salary_id' => 6,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }
    public function select_option_user(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'role' => 'required',
            'id' => 'required',
        ], [
            'role.required' => 'Vui lòng chọn tài khoản',
            'id.required' => 'Không tìm thấy ID tài khoản.',
        ]);
        if ($validation->fails()) {
            $massage = '';
            foreach ($validation->errors()->all() as $error) {
                $massage .= $error;
            }
            return response()->json([
                'status' => 400,
                'message' => $massage,
            ], 400);
        }
        $role = $request->input('role');
        $id = $request->input('id');

        if($role == 2)
        {

            $employee_id = Employee::where('user_id',$id)->value('employee_id');
            //xoa phan ugn vien da tạo trước đó
            $delete = Employee_profile::where('employee_id',$employee_id)->delete();
            //xoa ugn vien
            $delete_employee = Employee::where('employee_id',$employee_id)->delete();
            $delete_focus_employee = Employee::withTrashed()->where('employee_id', $employee_id)->forceDelete();
            //update ứng viên
            $update_user = User::where('id',$id)->update([
               'role' => 2
            ]);
            //tọa nhà tuyển dụng
            $user_fist = User::select('name', 'email', 'password', 'phone', 'status_email_account','role', 'id', 'link_confirm_account')
                ->where('id', $id)
                ->first();
            $employer = Employer::insert([
                'user_id' => $id,
                'email' => $user_fist->email,
                'enterprise_name' => $user_fist->name,
                'created_at' => new \DateTime()

            ]);

        }
        $step = 'step2';
        $update_user = User::where('id',$id)->update([
            'step' =>$step
        ]);
        $userWithPhone = User::select('name', 'email', 'password', 'phone', 'status_email_account','role', 'id', 'link_confirm_account')
            ->where('id', $id)
            ->first();
        if($role == 2)
        {
            MailConfigController::send_email_employer_confirm($userWithPhone);
        }else
        {
            MailConfigController::send_email_employee_confirm($userWithPhone);
        }
        $massage = 'Chọn tài khoản thành công ! Linh kích hoạt tài khoản đã dược gửi đến email của bạn';
        return response()->json([
            'status' => 200,
            'message' => $massage,
            'user' => $userWithPhone,
            'step' => $step,
        ], 200);
    }


}
