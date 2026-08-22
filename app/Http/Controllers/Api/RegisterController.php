<?php

namespace App\Http\Controllers\Api;

use App\Entity\Employee;
use App\Entity\Employee_experience;
use App\Entity\Employee_specialize;
use App\Entity\Salary;
use App\Entity\User;
use App\Http\Controllers\Site\MailConfigController;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class RegisterController extends Controller
{
    public function send_email_password(Request $request)
    {
        try {
            $email = $request->input('email');
            $user = User::where('email', $email)
                ->first();
            if (empty($user)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Email đăng kí không tồn tại'
                ],404);
            }
            $email_otp = Ultility::create_random_string(5, 7);
            $update = User::where('email', $email)->update([
                'reset_password' => $email_otp
            ]);
            MailConfigController::resetPassword($email, $user, $email_otp);
            $message = 'Mã xác thực đã được gửi tới Email của bạn . Vui lòng kiểm tra trong Email : '.$email;
            return response()->json([
                'status' => 200,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Có lỗi xảy ra vui lòng thử lại'
            ],404);
        }
    }
    public function inforEmployee(Request $request){
        $user = JWTAuth::toUser($request->input('token'));
//        print_r($user);die();
        try{
            $employee = Employee::where('user_id', $user->id)->first();
            if(empty($employee)){
                return response()->json([
                    'status' => 404,
                    'message' => 'Bạn cần đăng nhập để có thể xem thông tin của mình.'
                ]);
            }
            return response()->json([
                'status' => 200,
                'employee' => $employee
            ]);
        }catch (JWTException $exception){
            return response()->json([
                'status' => 404,
                'message' => 'Bạn cần đăng nhập để có thể xem thông tin của mình.'
            ]);
        }
    }
    public function update_password(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'password' => 'required|min:7|confirmed',
            'otp_email' => 'required',
        ], [
            'otp_email.required' => 'Mã xác thực không được để trống.',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu của bạn phải lớn hơn hoặc bằng 8 ký tự',
            'password.confirmed' => 'Mật khẩu nhập lại không đúng',

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
        $email = $request->input('email');
        $otp_email = $request->input('otp_email');
        $password = $request->input('password');

        $check_user = User::where('email', $email)
            ->where('reset_password', $otp_email)
            ->first();
        $user = User::where('email', $email)
            ->first();
        $user['image'] = !empty($user['image']) ? asset($user['image']) : '';
        if (empty($check_user)) {
            $message = 'Mã xác thực không đúng. Vui lòng kiểm tra lại trong Email : '.$email;
            return response()->json([
                'status' => 400,
                'message' => $message,
            ], 400);
        }
        User::where('email', $email)
            ->where('reset_password', $otp_email)
            ->update([
                'password' => bcrypt($request->input('password')),
                'reset_password' => ''
            ]);
        return response()->json([
            'status' => 200,
            'message' => 'Bạn đã đổi mật khẩu thành công',
            'user' => $user
        ], 200);

    }
}
