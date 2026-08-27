<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Teacher;
use App\Entity\User;
use App\Entity\Voucher;
use App\Entity\VoucherCategories;
use App\Entity\VoucherChildCategories;
use App\Entity\VoucherComment;
use App\Exam\Result_school;
use App\Exam\Room_school;
use App\Exam\Student_school;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ValidateformController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function check_email_employee(Request $request)
    {
        $email = $request->input('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)
            || !preg_match('/^[^@\s]+@[^@\s]+\.[^@\s]{2,}$/', $email)) {
            return response([
                'status' => 422,
                'message' => 'Địa chỉ email không hợp lệ.'
            ], 422);
        }

        $domain = substr(strrchr($email, '@'), 1);
        $hasMailServer = false;
        $dnsCheckFailed = false;
        try {
            $hasMailServer = checkdnsrr($domain, 'MX');
            if (!$hasMailServer) {
                $hasMailServer = checkdnsrr($domain, 'A') || checkdnsrr($domain, 'AAAA');
            }
        } catch (\Throwable $exception) {
            $dnsCheckFailed = true;
        }

        $user_model = new User();
        $user = $user_model->select('email')->where('email', $email)->first();
        $user_delete = $user_model->onlyTrashed()->select('email')->where('email', $email)->first();

        $employee_model = new Employee();
        $employee = $employee_model->select('email')->where('email', $email)->first();
        $employee_delete = $employee_model->onlyTrashed()->select('email')->where('email', $email)->first();

        $employer_model = new Employer();
        $employer = $employer_model->select('email')->where('email', $email)->first();
        $employer_delete = $employer_model->onlyTrashed()->select('email')->where('email', $email)->first();

        $teacher_model = new Teacher();
        $teacher = $teacher_model->select('teacher_email')->where('teacher_email', $email)->first();
        $teacher_delete = $teacher_model->onlyTrashed()->select('teacher_email')->where('teacher_email', $email)->first();

        if (!empty($user) || !empty($employee) || !empty($employer) || !empty($teacher) || !empty($user_delete) || !empty($employee_delete) || !empty($employer_delete) || !empty($teacher_delete)) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }

        if (!$hasMailServer && !$dnsCheckFailed) {
            return response([
                'status' => 422,
                'message' => 'Tên miền email không có cấu hình nhận thư.'
            ], 422);
        }

        return response([
            'status' => 200,
            'email' => 'có thể sử dụng email này',
            'dns_warning' => $dnsCheckFailed
        ]);
    }
//    public function check_email_employer(Request $request)
//    {
//        $email = $request->input('email');
//        $user_model = new User();
//        $user = $user_model->select('email')->where('email',$email)->first();
//
//        $employer_model = new Employer();
//        $employer = $employer_model->select('email')->where('email',$email)->first();
//
//        if(!empty($user) || !empty($employer))
//        {
//            return response('Error', 404)
//                ->header('Content-Type', 'text/plain');
//        }
//        return response([
//            'status' => 200,
//            'email' => 'có thể sử dụng email này'
//        ])->header('Content-Type', 'text/plain');
//    }
//    public function check_email_teacher(Request $request)
//    {
//        $email = $request->input('email');
//        $user_model = new User();
//        $user = $user_model->select('email')->where('email',$email)->first();
//
//        $teacher_model = new Teacher();
//        $teacher = $teacher_model->select('teacher_email')->where('teacher_email',$email)->first();
//
//        if(!empty($user))
//        {
//            return response('Error', 404)
//                ->header('Content-Type', 'text/plain');
//        }
//        return response([
//            'status' => 200,
//            'email' => 'có thể sử dụng email này'
//        ])->header('Content-Type', 'text/plain');
//    }

    public function check_student_code(Request $request)
    {


        $check_student = Student_school::where('student_code',$request->input('code'));
        $check_student = $check_student->where('id_room',$request->input('id_room'));
        $check_student = $check_student->whereDate('date_ip', '=', date('Y-m-d'));
        $check_student = $check_student->first();

        if (!empty($check_student)) {
            return response([
                'status' => 400,
                'code' => 'Mã sinh viên này đã làm đè thi rồi',
            ], 400)->header('Content-Type', 'text/plain');
        }
        return response([
            'status' => 200,
            'code' => 'Mã sinh viên này có thể sử dụng',
        ], 200)->header('Content-Type', 'text/plain');
    }

    public function check_password(Request $request)
    {
        $room_school = Room_school::select('*')->where('password_room', '=', $request->input('password'))
            ->where('id_room', $request->input('id_room'))->first();
        if (!empty($room_school)) {
            return response([
                'status' => 200,
                'code' => 'Mật khẩu phòng thi chính xác',
            ], 200)->header('Content-Type', 'text/plain');
        }
        return response([
            'status' => 400,
            'code' => 'Mật khẩu phòng thi không chính xác',
        ], 400)->header('Content-Type', 'text/plain');

    }
}
