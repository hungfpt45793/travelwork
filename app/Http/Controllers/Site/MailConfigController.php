<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\District;
use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\Hunter_registration;
use App\Entity\Job;
use App\Entity\Send_user_email_marketting;
use App\Entity\Template_email;
use App\Entity\User;
use App\Exam\ResultRoomExam;
use App\Exam\RoomExam;
use App\Mail\Mail as AccountMail;
use Illuminate\Http\Request;
use App\Entity\MailConfig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail as MailFacade;
use Illuminate\Support\Str;
use Validator;

class MailConfigController extends SiteController
{
    public function send(Request $request)
    {
        try {
            //mã danh mục mẫu email
            $id_cate_tem = 10;
            //trạng thái sử dụng của email
            $status_tem = 1;

            $template_email_model = new Template_email();
            $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
                ->where('status_tem', $status_tem)
                ->first();
            //cấu hình biến khi gửi mail

            $email_confirm = $request->input('email');

            $user_model = new User();

            $user_update = $user_model->select('name', 'phone', 'email', 'id', 'link_confirm_account')->where('email', $email_confirm)->first();


            $link_confirm_account = str_random(10) . $user_update->id;

            $update = $user_model->where('email', $email_confirm)->update([
                'link_confirm_account' => $link_confirm_account,
                'status_email_account' => 0,
            ]);
            $userWithPhone = $user_model->select('name', 'phone', 'email', 'id', 'link_confirm_account')->where('email', $email_confirm)->first();

            $name = $userWithPhone->name;
            $phone = $userWithPhone->phone;
            $email = $userWithPhone->email;
            $link_confirm_account = $userWithPhone->link_confirm_account;
            $link_kich_hoat = route('link_confirm_account', ['link' => $link_confirm_account]);

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;

            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{name}', '{phone}', '{email}', '{link_kich_hoat}'];
            $replace = [$name, $phone, $email, $link_kich_hoat];
            $content_string = str_replace($search, $replace, $content_email);

//            echo $subject;die();
            //tiến hành gửi email
            $result = MailConfig::sendMail($email, $subject, $content_string);
//            return response([
//                'status' => 200,
//            ])->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
//            return response('Error', 404)
//                ->header('Content-Type', 'text/plain');
        }

    }

    //mai xác thực tài khoản
    public function ajax_send_email_confirm(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.',
            ], 401);
        }

        $user = User::select('name', 'phone', 'email', 'id', 'link_confirm_account', 'status_email_account')
            ->find(Auth::id());

        if (!$user || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'success' => false,
                'message' => 'Địa chỉ email của tài khoản không hợp lệ.',
            ], 422);
        }

        if ((int) $user->status_email_account === 1) {
            return response()->json([
                'success' => false,
                'message' => 'Tài khoản này đã được xác thực email.',
            ], 422);
        }

        $template_email = Template_email::where('id_cate_tem', 10)
            ->where('status_tem', 1)
            ->first();

        if (!$template_email) {
            Log::error('Không tìm thấy mẫu email xác thực tài khoản đang hoạt động.', [
                'user_id' => $user->id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Chưa cấu hình mẫu email xác thực. Vui lòng liên hệ quản trị viên.',
            ], 500);
        }

        try {
            $link_confirm_account = Str::random(10) . $user->id;
            $link_kich_hoat = route('link_confirm_account', ['link' => $link_confirm_account]);
            $search = ['{name}', '{phone}', '{email}', '{link_kich_hoat}'];
            $replace = [$user->name, $user->phone, $user->email, $link_kich_hoat];
            $content_string = str_replace($search, $replace, $template_email->content_tem);

            DB::transaction(function () use ($user, $link_confirm_account, $content_string, $template_email) {
                User::where('id', $user->id)->update([
                    'link_confirm_account' => $link_confirm_account,
                    'status_email_account' => 0,
                ]);

                if (!self::sendAccountVerificationMail($user->email, $template_email->subject_tem, $content_string)) {
                    throw new \RuntimeException('Mail transport did not accept the verification email.');
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Email xác thực đã được gửi. Vui lòng kiểm tra cả hộp thư Spam/Junk.',
            ]);
        } catch (\Throwable $e) {
            Log::error('Gửi lại email xác thực tài khoản thất bại.', [
                'user_id' => $user->id,
                'exception' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không thể gửi email xác thực lúc này. Vui lòng thử lại sau.',
            ], 500);
        }
    }

    public static function send_email_confirm($email_confirm)
    {
        if (!filter_var($email_confirm, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        try {
            //mã danh mục mẫu email
            $id_cate_tem = 10;
            //trạng thái sử dụng của email
            $status_tem = 1;

            $template_email_model = new Template_email();
            $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
                ->where('status_tem', $status_tem)
                ->first();
            $user_model = new User();

            $user_update = $user_model->select('name', 'phone', 'email', 'id', 'link_confirm_account')->where('email', $email_confirm)->first();


            $link_confirm_account = str_random(10) . $user_update->id;

            $update = $user_model->where('email', $email_confirm)->update([
                'link_confirm_account' => $link_confirm_account,
                'status_email_account' => 0,
            ]);
            $userWithPhone = $user_model->select('name', 'phone', 'email', 'id', 'link_confirm_account')->where('email', $email_confirm)->first();

            $name = $userWithPhone->name;
            $phone = $userWithPhone->phone;
            $email = $userWithPhone->email;
            $link_confirm_account = $userWithPhone->link_confirm_account;
            $link_kich_hoat = route('link_confirm_account', ['link' => $link_confirm_account]);

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;

            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{name}', '{phone}', '{email}', '{link_kich_hoat}'];
            $replace = [$name, $phone, $email, $link_kich_hoat];
            $content_string = str_replace($search, $replace, $content_email);

//            echo $subject;die();
            //tiến hành gửi email
            $result = self::sendAccountVerificationMail($email, $subject, $content_string);
//            return response([
//                'status' => 200,
//            ])->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
//            return response('Error', 404)
//                ->header('Content-Type', 'text/plain');
        }

    }

    //gưi email thông báo cho admin có user xác thực tài khoản
    public static function send_email_confirm_admin($email_confirm, $email_admin)
    {
        if (!filter_var($email_confirm, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        try {
            //mã danh mục mẫu email
            $id_cate_tem = 10;
            //trạng thái sử dụng của email
            $status_tem = 1;

            $template_email_model = new Template_email();
            $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
                ->where('status_tem', $status_tem)
                ->first();
            $user_model = new User();

            $user_update = $user_model->select('name', 'phone', 'email', 'id', 'link_confirm_account')->where('email', $email_confirm)->first();


            $link_confirm_account = str_random(10) . $user_update->id;

            $update = $user_model->where('email', $email_confirm)->update([
                'link_confirm_account' => $link_confirm_account,
                'status_email_account' => 0,
            ]);
            $userWithPhone = $user_model->select('name', 'phone', 'email', 'id', 'link_confirm_account')->where('email', $email_confirm)->first();

            $name = $userWithPhone->name;
            $phone = $userWithPhone->phone;
            $email = $userWithPhone->email;
            $link_confirm_account = $userWithPhone->link_confirm_account;
            $link_kich_hoat = route('link_confirm_account', ['link' => $link_confirm_account]);

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;

            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{name}', '{phone}', '{email}', '{link_kich_hoat}'];
            $replace = [$name, $phone, $email, $link_kich_hoat];
            $content_string = str_replace($search, $replace, $content_email);

//            echo $subject;die();
            //tiến hành gửi email
            $result = MailConfig::sendMail($email_admin, $subject, $content_string);
//            return response([
//                'status' => 200,
//            ])->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
//            return response('Error', 404)
//                ->header('Content-Type', 'text/plain');
        }

    }

    // đăng kí tài khoản úng viên
    public static function send_email_employee_confirm($userWithPhone)
    {
        if (!filter_var($userWithPhone->email, FILTER_VALIDATE_EMAIL)) {
            return false;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 1;
        //trạng thái sử dụng của email
        $status_tem = 1;

        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();

        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $name = $userWithPhone->name;
            $phone = $userWithPhone->phone;
            $email = $userWithPhone->email;
            $otp = str_replace('otp_', '', $userWithPhone->link_confirm_account);

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{name}', '{phone}', '{email}', '{link_kich_hoat}'];
            $replace = [$name, $phone, $email, ''];
            $content_string = str_replace($search, $replace, $content_email);
            $content_string .= '<p>Mã OTP xác nhận email của bạn là: <strong>' . e($otp) . '</strong></p>';
            $content_string .= '<p>Mã OTP có 6 chữ số. Vui lòng nhập mã trên trang đăng ký để kích hoạt tài khoản.</p>';
            //tiến hành gửi email
            return MailConfig::sendMail($email, $subject, $content_string);
        }

        return false;

        return false;
    }

    // đăng kí tài khoản nhà tuyển dụng
    public static function send_email_employer_confirm($userWithPhone)
    {
        //chek dinh dang email
        if (!filter_var($userWithPhone->email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 2;
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        //cấu hình biến khi gửi mail
        if (!empty($template_email)) {
            $name = $userWithPhone->name;
            $phone = $userWithPhone->phone;
            $email = $userWithPhone->email;
            $link_confirm_account = $userWithPhone->link_confirm_account;
            $link_kich_hoat = route('link_confirm_account', ['link' => $link_confirm_account]);

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;

            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{name}', '{phone}', '{email}', '{link_kich_hoat}'];
            $replace = [$name, $phone, $email, $link_kich_hoat];
            $content_string = str_replace($search, $replace, $content_email);

            //tiến hành gửi email
            return self::sendAccountVerificationMail($email, $subject, $content_string);
        }

        return false;
    }

    // đăng kí giáo viên
    public static function send_email_teacher_confirm($userWithPhone)
    {
        //chek dinh dang email
        if (!filter_var($userWithPhone->email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 3;
        //trạng thái sử dụng của email
        $status_tem = 1;

        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $name = $userWithPhone->name;
            $phone = $userWithPhone->phone;
            $email = $userWithPhone->email;
            $link_confirm_account = $userWithPhone->link_confirm_account;
            $link_kich_hoat = route('link_confirm_account', ['link' => $link_confirm_account]);

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;

            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{name}', '{phone}', '{email}', '{link_kich_hoat}'];
            $replace = [$name, $phone, $email, $link_kich_hoat];
            $content_string = str_replace($search, $replace, $content_email);

            //tiến hành gửi email
            return self::sendAccountVerificationMail($email, $subject, $content_string);
        }

        return false;
    }

    // nop ho cho cong viec fb
    public static function send_submit_job_fb_email($status_people, $job_fb, $employee, $email, $submit_job_fb_id)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
//        $status_people là mẫu email gui cho ai $job_fb thông tin tuyenr dung , $employee ung vien ,$email là email nhận
        //mã danh mục mẫu email
        $id_cate_tem = 5;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
//        $status_people  = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model
            ->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $link_cong_viec = route('detail_job_face', ['slug' => $job_fb->slug]);
            $link_ho_so = route('detail_employee_show', ['employee_slug' => $employee->employee_slug]);


            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = [
                '{title}',
                '{content}',
                '{slug}',
                '{email}',
                '{link_cong_viec}',
                '{employee_id}',
                '{employee_name}',
                '{employee_phone}',
                '{employee_email}',
                '{province}',
                '{link_ho_so}',
                '{link_danh_sach_ho_so}'
            ];
            $province = \App\Entity\Province::getId($employee->province);
            $link_danh_sach_ho_so = route('list_Job_Candidate_Employee');
            $replace = [
                $job_fb->title,
                $job_fb->content,
                $job_fb->slug,
                $job_fb->email,
                $link_cong_viec,
                $employee->employee_id,
                $employee->employee_name,
                $employee->phone,
                $employee->email,
                $province['province_name'],
                $link_ho_so,
                $link_danh_sach_ho_so
            ];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }
    }

    //nop ho so cho cong viec NTD
    public static function send_submit_job_email($status_people, $job, $employee, $email, $submit_job_fb_id)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
//        $status_people là mẫu email gui cho ai $job_fb thông tin tuyenr dung , $employee ung vien ,$email là email nhận
        //mã danh mục mẫu email
        $id_cate_tem = 7;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
//        $status_people  = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model
            ->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        //cấu hình biến khi gửi mail

        if (!empty($template_email)) {
            $link_cong_viec = route('job_detail', ['slug' => $job->slug]);
            $link_ho_so = route('detail_employee_show', ['employee_slug' => $employee->employee_slug]);

            $employer_id = Job::where('slug', $job->slug)->value('employer_id');
            $employer = Employer::select('employer.email', 'employer.employer_id')->where('employer_id', $employer_id)->first();
            $link_danh_sach_ho_so = '';
            if (!empty($employer)) {
                $link_danh_sach_ho_so = route('list_profile_job') . '?email=' . $employer->email . '&employer_id=' . $employer->employer_id;
            }
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;

            //thay đổi biến thành chuỗi khi gửi email
            $search = [
                '{title}',
                '{content}',
                '{slug}',
                '{email}',
                '{link_cong_viec}',
                '{employee_id}',
                '{employee_name}',
                '{employee_phone}',
                '{employee_email}',
                '{province}',
                '{link_ho_so}',
                '{link_danh_sach_ho_so}'
            ];

            $province = \App\Entity\Province::getId($employee->province);
            $replace = [
                $job->title,
                $job->content,
                $job->slug,
                $job->email,
                $link_cong_viec,
                $employee->employee_id,
                $employee->employee_name,
                $employee->phone,
                $employee->email,
                $province['province_name'],
                $link_ho_so,
                $link_danh_sach_ho_so,
            ];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }
        return true;
    }

    //thay đổi địa chỉ email kích hoạt
    public static function send_change_email($name, $email, $link_confirm_account)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 11;
        //trạng thái sử dụng của email
        $status_tem = 1;

        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        //cấu hình biến khi gửi mail
        if (!empty($template_email)) {
            $link_kich_hoat = route('link_confirm_account', ['link' => $link_confirm_account]);

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;

            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{name}', '{email}', '{link_kich_hoat}'];
            $replace = [$name, $email, $link_kich_hoat];
            $content_string = str_replace($search, $replace, $content_email);

            //tiến hành gửi email
            return self::sendAccountVerificationMail($email, $subject, $content_string);
        }

        return false;
    }

    private static function sendAccountVerificationMail($email, $subject, $content)
    {
        try {
            $mail = (new AccountMail($content))->subject($subject);
            MailFacade::to($email)->send($mail);

            return true;
        } catch (\Throwable $e) {
            Log::error('Gửi email xác thực tài khoản qua Laravel Mail thất bại.', [
                'exception' => $e->getMessage(),
            ]);

            return false;
        }
    }

    //đổi mật khẩu
    public static function resetPassword($email_to, $user, $email_otp)
    {
        if (!filter_var($email_to, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        try {
            $template_email = Template_email::where('id_cate_tem', 4)
                ->where('status_tem', 1)
                ->first();

            if (!$template_email) {
                \Log::error('Không tìm thấy template email quên mật khẩu.');

                return false;
            }

            $content = str_replace(
                ['{name}', '{email}', '{email_otp}'],
                [e($user->name), e($user->email), e($email_otp)],
                $template_email->content_tem
            );

            $mail = new \App\Mail\Mail($content);

            \Mail::to($email_to)->send(
                $mail->subject($template_email->subject_tem)
            );

            \Log::info('Đã gửi OTP quên mật khẩu.', ['user_id' => $user->id]);

            return true;
        } catch (\Throwable $exception) {
            \Log::error('Lỗi gửi OTP quên mật khẩu: '.$exception->getMessage(), [
                'user_id' => $user->id,
            ]);

            return false;
        }
    }

    //nộp hồ sơ thực tập
    public static function send_submit_intership($status_people, $employer, $employee, $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }

//        $status_people là mẫu email gui cho ai $job_fb thông tin tuyenr dung , $employee ung vien ,$email là email nhận
        //mã danh mục mẫu email
        $id_cate_tem = 6;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
//        $status_people  = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model
            ->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        //cấu hình biến khi gửi mail

        if (!empty($template_email)) {
            $link_chi_tiet = route('detail_intership', ['slug' => $employer->slug]);
            $link_ho_so = route('detail_employee_show', ['employee_slug' => $employee->employee_slug]);


            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = [
                '{enterprise_name}',
                '{phone}',
                '{email}',
                '{link_chi_tiet}',
                '{employee_id}',
                '{employee_name}',
                '{employee_phone}',
                '{employee_email}',
                '{province}',
                '{link_ho_so}',
                '{link_danh_sach_ho_so}',

            ];
            $province = \App\Entity\Province::getId($employee->province);
            $link_danh_sach_ho_so = route('list_profile_intership') . '?email=' . $email . '&employer_id=' . $employer->employer_id;

            $replace = [
                $employer->enterprise_name,
                $employer->phone,
                $employer->email,
                $link_chi_tiet,
                $employee->employee_id,
                $employee->employee_name,
                $employee->phone,
                $employee->email,
                $province['province_name'],
                $link_ho_so,
                $link_danh_sach_ho_so,
            ];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }

    }

    // nộp hồ sơ đăng kí học với giáo viên
    public static function send_learn_teacher($status_people, $teacher, $employee, $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }

//        $status_people là mẫu email gui cho ai $job_fb thông tin tuyenr dung , $employee ung vien ,$email là email nhận
        //mã danh mục mẫu email
        $id_cate_tem = 8;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
//        $status_people  = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model
            ->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        //cấu hình biến khi gửi mail

        if (!empty($template_email)) {
            $link_giao_vien = route('detailTeacher', ['slug' => $teacher->slug]);
            $link_ung_vien = route('show_emplooyee', ['employee_id' => $employee->employee_id]);


            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = [
                '{link_ung_vien}',
                '{employee_name}',
                '{employee_email}',
                '{employee_phone}',
                '{link_giao_vien}',
                '{teacher_name}',

            ];
            $replace = [
                $link_ung_vien,
                $employee->employee_name,
                $employee->email,
                $employee->phone,
                $link_giao_vien,
                $teacher->teacher_name

            ];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }


    }

    // nhà tuyển dụng loại hồ sơ ứng viên
    public static function send_delete_file($job, $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 13;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)

        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $link_cong_viec = route('job_detail', ['slug' => $job['slug']]);

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{job_title}', '{link_cong_viec}'];
            $replace = [$job['title'], $link_cong_viec];
            $content_string = str_replace($search, $replace, $content_email);

            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }
    }

    public static function send_delete_file_intership($employer, $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 14;
        //trạng thái sử dụng của email
        $status_tem = 1;

        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();

        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $link_thuc_tap = route('detail_intership', ['slug' => $employer['slug']]);

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{employer_name}', '{link_thuc_tap}'];
            $replace = [$employer['enterprise_name'], $link_thuc_tap];
            $content_string = str_replace($search, $replace, $content_email);

            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }

    }

    //thông báo cho email trong đăng tin facebook
    public static function notif_job_facebook($job_facebook, $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 15;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();

        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $title = $job_facebook['title'];
            $des_facebook = $job_facebook['des_facebook'];
            $content = $job_facebook['content'];
            $link_tin_facebook = route('detail_job_face', ['slug' => $job_facebook['slug']]);

//        print_r($template_email);die();
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{title}', '{des_facebook}', '{content}', '{link_tin_facebook}', '{email}'];


            $replace = [$title, $des_facebook, $content, $link_tin_facebook, $email];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }
    }
    //Nhà tuyển dụng đăng tin tuyển dụng
    //Email hướng dẫn sử dụng chức năng của nhà tuyển dụng
    public static function employer_create_job($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 16;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
//        print_r($template_email);die();
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            MailConfig::sendMail($email, $subject, $content_email);
        }
    }

//    email thông báo kết thi của ứng viên với đề thi
    public static function show_exam_employee($employee_id, $job_id, $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 17;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail trong email

            $employee = Employee::select('employee_id', 'employee_name')->where('employee_id', $employee_id)->first();
            $job = Job::select('job_id', 'job_code', 'title')->where('job_id', $job_id)->first();

            $employee_name = $employee['employee_name'];
            $job_title = $job['title'];

            $link_ket_qua_thi = route('detail_exam_employee', ['employee_id' => $employee['employee_id'], 'job_facebook_id' => $job['job_id']]);

//        print_r($template_email);die();
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{employee_name}', '{job_title}', '{link_ket_qua_thi}'];

            $replace = [$employee_name, $job_title, $link_ket_qua_thi];

            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }
    }

//    email thông báo kết thi của phòng thi
    public static function show_exam_room($id_result_room, $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 18;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
        $status_people = 2;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_people', $status_people)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail trong email
            $result_room_exam = ResultRoomExam::select('id_result_room', 'id_room', 'user_exam_room')->where('id_result_room', $id_result_room)->first();
            $employee = Employee::select('employee_id', 'employee_name', 'user_id')->where('user_id', $result_room_exam->user_exam_room)->first();
            $room = RoomExam::select('id_room', 'name_room')->where('id_room', $result_room_exam->id_room)->first();

            $link_ket_qua_thi_phong_thi = route('showResultRoom', ['id_result' => $result_room_exam->id_result_room]);
            $employee_name = $employee->employee_name;
            $room_name = $room->name_room;


//        print_r($template_email);die();
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{employee_name}', '{room_name}', '{link_ket_qua_thi_phong_thi}'];
            $replace = [$employee_name, $room_name, $link_ket_qua_thi_phong_thi];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }
    }

    //email thông báo chuyển trạng thái hồ sơ thực tập thành công
    public static function change_intership($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 19;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
        $status_people = 2;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_people', $status_people)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email


            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_email);
        }

    }

    public static function support($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 21;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();

        if (!empty($template_email)) {
            //lấy ra nội dung gửi email
//        print_R($template_email);die();
            $content_email = isset($template_email->content_tem) ? $template_email->content_tem : '';
            //tiêu đề khi gửi email
            $subject = isset($template_email->subject_tem) ? $template_email->subject_tem : '';
            //thay đổi biến thành chuỗi khi gửi email


            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_email);
        }

    }

    public static function feedback($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 22;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email


            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_email);
        }
    }

    //mời ứng viên ứng tuyển
    public static function send_email_invitation_employee($job_id, $employee_id)
    {
        //mã danh mục mẫu email
        $id_cate_tem = 25;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
        $status_people = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();

        if (!empty($template_email)) {
            //cấu hình nội dung gửi email
//        {employee_email} {employee_phone}{job_title}{job_slug}enterprise_name} {link_job}
            //lấy ra nội dung gửi email
            $job = Job::select('jobs.job_id', 'jobs.title', 'jobs.slug', 'employer.enterprise_name', 'employer.employer_id', 'jobs.employer_id')
                ->join('employer', 'employer.employer_id', 'jobs.employer_id')
                ->where('jobs.job_id', $job_id)
                ->first();

            $employee = Employee::select('email', 'phone', 'employee_id')
                ->where('employee_id', $employee_id)
                ->first();

            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email

            $employee_email = $employee->email;
            if (!filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
                return true;
                //email khong dung dinh dang nen se k gửi email
            }
            $employee_phone = $employee->phone;
            $job_title = $job->title;
            $job_slug = $job->slug;
            $enterprise_name = $job->enterprise_name;
            $link_job = route('job_detail', ['slug' => $job->slug]);
            $search = ['{employee_email}', '{employee_phone}', '{job_title}', '{job_slug}', '{enterprise_name}', '{link_job}'];
            $replace = [$employee_email, $employee_phone, $job_title, $job_slug, $enterprise_name, $link_job];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($employee_email, $subject, $content_string);
        }

    }

    //gửi phản hồi nhà tuyển dụng
    public static function send_feedback_all_employee($teacher_name, $teacher_email, $feedback_all)
    {
        if (!filter_var($teacher_email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 27;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)

        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi emails
            $search = ['{name}', '{email}', '{content}'];
            $replace = [$teacher_name, $teacher_email, $feedback_all];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($teacher_email, $subject, $content_string);
        }

    }

    //gửi phản hồi nhà tuyển dụng
    public static function send_feedback_all_employer($teacher_name, $employer_email, $feedback_all)
    {
        if (!filter_var($employer_email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 27;
        //trạng thái sử dụng của email
        $status_tem = 1;
        //gui cho ai (1 là ứng viên)(2 là NTD)(3 là GV)
        $status_people = 2;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi emails
            $search = ['{name}', '{email}', '{content}'];
            $replace = [$teacher_name, $employer_email, $feedback_all];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($employer_email, $subject, $content_string);
        }

    }

    //email gửi mã kích hoạt cho khóa học cho khóa học miễn phí
    public static function send_email_actove_course($course, $course_order)
    {
        //mã danh mục mẫu email
        $id_cate_tem = 28;
        //trạng thái sử dụng của email
        $status_tem = 1;

        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $course_title = $course->course_title;
            $course_price = !empty($course_order->course_cost) ? number_format($course_order->course_cost) . 'đ' : 'Miễn phí';
            $activation_code = $course_order->activation_code;

            $email = $course_order->course_email;
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
                //email khong dung dinh dang nen se k gửi email
            }
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{course_title}', '{course_price}', '{activation_code}'];
            $replace = [$course_title, $course_price, $activation_code];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);

            return true;
        }

    }

    //email thong báo đơn hàng khóa học cho khóa học facebook có phí
    public static function send_email_facebook_course($course, $course_order)
    {
        //mã danh mục mẫu email
        $id_cate_tem = 48;
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $email = $course_order->course_email;
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
                //email khong dung dinh dang nen se k gửi email
            }
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{ho_va_ten}', '{so_dien_thoai}', '{email}', '{noi_dung}', '{ma_don_hang}', '{ten_khoa_hoc}', '{ma_khoa_hoc}', '{cach_hoc}', '{tong_thanh_toan}'];
            //thong tin dăng ký
            $ho_va_ten = $course_order->course_name;
            $so_dien_thoai = $course_order->course_phone;
            $email = $course_order->course_email;
            $noi_dung = $course_order->course_messager;
            //thông tin khóa choc
            $ma_don_hang = $course_order->course_order_id;
            $ten_khoa_hoc = $course->course_title;
            $ma_khoa_hoc = $course->course_code;
            $cach_hoc = $course_order->learn_title;
            $tong_thanh_toan = !empty($course_order->course_cost) ? number_format($course_order->course_cost) . 'đ' : 'Miễn phí';
            $replace = [$ho_va_ten, $so_dien_thoai, $email, $noi_dung, $ma_don_hang, $ten_khoa_hoc, $ma_khoa_hoc, $cach_hoc, $tong_thanh_toan];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
            return true;
        }

    }

    //email thong báo đơn hàng khóa học cho khóa học
    public static function send_email_course($course, $course_order)
    {
        //mã danh mục mẫu email
        $id_cate_tem = 49;
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $email = $course_order->course_email;
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
                //email khong dung dinh dang nen se k gửi email
            }
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{ho_va_ten}', '{so_dien_thoai}', '{email}', '{noi_dung}', '{ma_don_hang}', '{ten_khoa_hoc}', '{ma_khoa_hoc}', '{cach_hoc}', '{tong_thanh_toan}'];
            //thong tin dăng ký
            $ho_va_ten = $course_order->course_name;
            $so_dien_thoai = $course_order->course_phone;
            $email = $course_order->course_email;
            $noi_dung = $course_order->course_messager;
            //thông tin khóa choc
            $ma_don_hang = $course_order->course_order_id;
            $ten_khoa_hoc = $course->course_title;
            $ma_khoa_hoc = $course->course_code;
            $cach_hoc = $course_order->learn_title;
            $tong_thanh_toan = !empty($course_order->course_cost) ? number_format($course_order->course_cost) . 'đ' : 'Miễn phí';
            $replace = [$ho_va_ten, $so_dien_thoai, $email, $noi_dung, $ma_don_hang, $ten_khoa_hoc, $ma_khoa_hoc, $cach_hoc, $tong_thanh_toan];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
            return true;
        }

    }
    //email gui mã kích hoạt facebook
    public static function send_email_active_facebook_course($course, $course_order)
    {
        //mã danh mục mẫu email
        $id_cate_tem = 50;
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $email = $course_order->course_email;
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
                //email khong dung dinh dang nen se k gửi email
            }
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{ho_va_ten}', '{so_dien_thoai}', '{email}', '{noi_dung}', '{ma_don_hang}','{ma_kich_hoat}','{ten_khoa_hoc}','{ma_khoa_hoc}', '{cach_hoc}', '{tong_thanh_toan}'];
            //thong tin dăng ký
            $ho_va_ten = $course_order->course_name;
            $so_dien_thoai = $course_order->course_phone;
            $email = $course_order->course_email;
            $noi_dung = $course_order->course_messager;
            //thông tin khóa choc
            $ma_don_hang = $course_order->course_order_id;
            $ma_kich_hoat = $course_order->activation_code;
            $ten_khoa_hoc =  $course->course_title;
            $ma_khoa_hoc =  $course->course_code;
            $cach_hoc = $course_order->learn_title;
            $tong_thanh_toan =  !empty($course_order->course_cost) ? number_format($course_order->course_cost) . 'đ' : 'Miễn phí';
            $replace = [$ho_va_ten, $so_dien_thoai, $email,$noi_dung,$ma_don_hang,$ma_kich_hoat,$ten_khoa_hoc,$ma_khoa_hoc,$cach_hoc,$tong_thanh_toan];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
            return true;
        }

    }
    //email gui mã kích hoạt khóa hoc bt
    public static function send_email_active_course($course, $course_order)
    {
        //mã danh mục mẫu email
        $id_cate_tem = 51;
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $email = $course_order->course_email;
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
                //email khong dung dinh dang nen se k gửi email
            }
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = ['{ho_va_ten}', '{so_dien_thoai}', '{email}', '{noi_dung}', '{ma_don_hang}','{ma_kich_hoat}','{ten_khoa_hoc}','{ma_khoa_hoc}', '{cach_hoc}', '{tong_thanh_toan}'];
            //thong tin dăng ký
            $ho_va_ten = $course_order->course_name;
            $so_dien_thoai = $course_order->course_phone;
            $email = $course_order->course_email;
            $noi_dung = $course_order->course_messager;
            //thông tin khóa choc
            $ma_don_hang = $course_order->course_order_id;
            $ma_kich_hoat = $course_order->activation_code;
            $ten_khoa_hoc =  $course->course_title;
            $ma_khoa_hoc =  $course->course_code;
            $cach_hoc = $course_order->learn_title;
            $tong_thanh_toan =  !empty($course_order->course_cost) ? number_format($course_order->course_cost) . 'đ' : 'Miễn phí';
            $replace = [$ho_va_ten, $so_dien_thoai, $email,$noi_dung,$ma_don_hang,$ma_kich_hoat,$ten_khoa_hoc,$ma_khoa_hoc,$cach_hoc,$tong_thanh_toan];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
            return true;
        }

    }

    //duyệt tin tuyển dụng của nhà tuyển dụng
    public static function send_email_active_job_employer($job_id, $email_employer)
    {
        if (!filter_var($email_employer, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 29;
        $status_people = 2;//nhà tuyển dụng
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            $job = Job::select('job_id', 'title', 'slug')->where('job_id', $job_id)->first();
            //cấu hình biến khi gửi mail
            if (!empty($job)) {
                $title = $job->title;
                $link_tuyen_dung = route('job_detail', ['slug' => $job->slug]);
                //lấy ra nội dung gửi email
                $content_email = $template_email->content_tem;
                //tiêu đề khi gửi email
                $subject = $template_email->subject_tem;
                //thay đổi biến thành chuỗi khi gửi email
                $search = ['{title}', '{link_tuyen_dung}'];
                $replace = [$title, $link_tuyen_dung];
                $content_string = str_replace($search, $replace, $content_email);
                //tiến hành gửi email
                MailConfig::sendMail($email_employer, $subject, $content_string);
            }
            return true;
        }
        return true;
    }

    public static function send_email_update_job_employer($job_id, $email_employer)
    {
        if (!filter_var($email_employer, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 30;
        $status_people = 2;//nhà tuyển dụng
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            $job = Job::select('job_id', 'title', 'slug')->where('job_id', $job_id)->first();
            //cấu hình biến khi gửi mail
            if (!empty($job)) {
                $title = $job->title;
                $link_tuyen_dung = route('job_detail', ['slug' => $job->slug]);
                //lấy ra nội dung gửi email
                $content_email = $template_email->content_tem;
                //tiêu đề khi gửi email
                $subject = $template_email->subject_tem;
                //thay đổi biến thành chuỗi khi gửi email
                $search = ['{title}', '{link_tuyen_dung}'];
                $replace = [$title, $link_tuyen_dung];
                $content_string = str_replace($search, $replace, $content_email);
                //tiến hành gửi email
                MailConfig::sendMail($email_employer, $subject, $content_string);
            }
            return true;
        }
        return true;
    }

    public static function send_email_50_view_job_employer($job_id, $email_employer, $luot_xem)
    {
        if (!filter_var($email_employer, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 31;
        $status_people = 2;//nhà tuyển dụng
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            $job = Job::select('job_id', 'title', 'slug')->where('job_id', $job_id)->first();
            //cấu hình biến khi gửi mail
            if (!empty($job)) {
                $title = $job->title;
                $link_tuyen_dung = route('job_detail', ['slug' => $job->slug]);
                //lấy ra nội dung gửi email
                $content_email = $template_email->content_tem;
                //tiêu đề khi gửi email
                $subject = $template_email->subject_tem;
                //thay đổi biến thành chuỗi khi gửi email
                $search = ['{title}', '{link_tuyen_dung}', '{luot_xem}'];
                $replace = [$title, $link_tuyen_dung, $luot_xem];
                $content_string = str_replace($search, $replace, $content_email);
                //tiến hành gửi email
                MailConfig::sendMail($email_employer, $subject, $content_string);
            }
            return true;
        }
        return true;
    }

    //email thông báo tin tuyển dụng hết han. là tin tự động nên cần duyệt sau
    public static function send_email_job_date_end($job_id, $email_employer)
    {
        if (!filter_var($email_employer, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 32;
        $status_people = 2;//nhà tuyển dụng
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            $job = Job::select('job_id', 'title', 'slug')->where('job_id', $job_id)->first();
            //cấu hình biến khi gửi mail
            if (!empty($job)) {
                $title = $job->title;
                $link_tuyen_dung = route('job_detail', ['slug' => $job->slug]);
                //lấy ra nội dung gửi email
                $content_email = $template_email->content_tem;
                //tiêu đề khi gửi email
                $subject = $template_email->subject_tem;
                //thay đổi biến thành chuỗi khi gửi email
                $search = ['{title}', '{link_tuyen_dung}'];
                $replace = [$title, $link_tuyen_dung];
                $content_string = str_replace($search, $replace, $content_email);
                //tiến hành gửi email
                MailConfig::sendMail($email_employer, $subject, $content_string);
            }
            return true;
        }
        return true;
    }

    //NTD nhận thông báo về ứng viên đăng ký phù hợp với tiêu chí của công ty
    public static function send_email_profile_job($employee_id, $email_employer)
    {
        if (!filter_var($email_employer, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //xoa tat email makettign da gui truoc do
        $delete_email_maketting = Send_user_email_marketting::delete_email();
        //them moi email maketting
        $insert_send_email_maketting = Send_user_email_marketting::insert_email($email_employer);
        //mã danh mục mẫu email
        $id_cate_tem = 34;
        $status_people = 2;//nhà tuyển dụng
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            $employee = Employee::select('employees.employee_id', 'employees.employee_name', 'employees.employee_slug', 'province.province_name')
                ->where('employees.employee_id', $employee_id)
                ->leftJoin('province', 'province.province_id', '=', 'employees.province')
                ->first();
            $list_district_name = \App\Entity\Employee_district::get_district_name($employee_id);
            $district_name = '';
            foreach ($list_district_name as $ids => $district) {
                if ($ids == 0) {
                    $district_name .= $district->district_name;
                } else {
                    $district_name .= ' , ' . $district->district_name;
                }
            }
            //cấu hình biến khi gửi mail
            if (!empty($employee)) {
                $ten_ung_vien = $employee->employee_name;
                $dia_chi_ung_vien = $employee->province_name . ' | ' . $district_name;
                $link_ung_vien = route('detail_employee_show', ['employee_slug' => $employee->employee_slug]);
                //lấy ra nội dung gửi email
                $content_email = $template_email->content_tem;
                //tiêu đề khi gửi email
                $subject = $template_email->subject_tem;
                //thay đổi biến thành chuỗi khi gửi email
                $search = ['{ten_ung_vien}', '{dia_chi_ung_vien}', '{link_ung_vien}'];
                $replace = [$ten_ung_vien, $dia_chi_ung_vien, $link_ung_vien];
                $content_string = str_replace($search, $replace, $content_email);
                //tiến hành gửi email
                MailConfig::sendMail($email_employer, $subject, $content_string);
            }
            return true;
        }
        return true;
    }

    //thông báo cho ứng viên NTD đã xem hồ sơ đã nộp
    public static function send_email_view_profile_employee($job_id, $employee_email)
    {
        if (!filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 35;
        $status_people = 1;//ung vien
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            $job = Job::select('job_id', 'title', 'slug', 'employer_id')->where('job_id', $job_id)->first();
            //cấu hình biến khi gửi mail

            if (!empty($job)) {
                $employer_name = Employer::where('employer_id', $job->employer_id)->value('enterprise_name');
                $title = $job->title;
                $link_tuyen_dung = route('job_detail', ['slug' => $job->slug]);
                //lấy ra nội dung gửi email
                $content_email = $template_email->content_tem;
                //tiêu đề khi gửi email
                $subject = $template_email->subject_tem;
                //thay đổi biến thành chuỗi khi gửi email
                $search = ['{title}', '{ten_cong_ty}', '{link_tuyen_dung}'];
                $replace = [$title, $employer_name, $link_tuyen_dung];
                $content_string = str_replace($search, $replace, $content_email);
                //tiến hành gửi email
                MailConfig::sendMail($employee_email, $subject, $content_string);
            }
            return true;
        }
        return true;

    }

    //thông báo ứng viên đã được 50 lượt xem
    public static function send_view_50_employee($employee_email, $luot_xem)
    {
        if (!filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 36;
        $status_people = 1;//ung vien
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            $content_email = $template_email->content_tem;
            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            $search = ['{luot_xem}'];
            $replace = [$luot_xem];
            $content_string = str_replace($search, $replace, $content_email);
            //thay đổi biến thành chuỗi khi gửi email
            //tiến hành gửi email
            MailConfig::sendMail($employee_email, $subject, $content_email);
        }
        return true;
    }
    //email số 37 tạm dừng

    //email thông báo đơn hàng nhà tuyển dụng
    public static function send_order_employer($hunter_regis_id, $employer_email)
    {
        if (!filter_var($employer_email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 38;
        $status_people = 2;//ung vien
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {

            $hunter_regis = Hunter_registration::where('hunter_regis_id', $hunter_regis_id)->first();
            if (!empty($hunter_regis)) {
                $hunter_res = \App\Entity\Hunter_price::get_hunter_price($hunter_regis->hunter_regis_price);
                $ma_don_hang = !empty($hunter_regis->hunter_regis_code) ? $hunter_regis->hunter_regis_code : '';
                $noi_dung_don_hang = !empty($hunter_regis->hunter_regis_note) ? $hunter_regis->hunter_regis_note : '';
                $vi_tri_cong_viec = !empty($hunter_res->hunter_pos_name) ? $hunter_res->hunter_pos_name : '';
                $thoi_gian_tuyen = !empty($hunter_res->hunter_time_name) ? $hunter_res->hunter_time_name : '';
                $chi_phi = !empty($hunter_res->hunter_price_name) ? $hunter_res->hunter_price_name : '';
                //lấy ra nội dung gửi email
                $content_email = $template_email->content_tem;
                //tiêu đề khi gửi email
                $subject = $template_email->subject_tem;
                //thay đổi biến thành chuỗi khi gửi email
                $search = ['{ma_don_hang}', '{noi_dung_don_hang}', '{vi_tri_cong_viec}', '{thoi_gian_tuyen}', '{chi_phi}'];
                $replace = [$ma_don_hang, $noi_dung_don_hang, $vi_tri_cong_viec, $thoi_gian_tuyen, $chi_phi];
                $content_string = str_replace($search, $replace, $content_email);
                //tiến hành gửi email
                MailConfig::sendMail($employer_email, $subject, $content_string);
            }
        }
        return true;
    }

    //email thông báo đơn hàng dich vu
    public static function send_service_employer($service_order_id, $employer_email)
    {
        if (!filter_var($employer_email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 42;
        $status_people = 2;//ung vien
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {

            $hunter_order = \App\Entity\Service_order::where('service_order_id', $service_order_id)->first();
            if (!empty($hunter_order)) {
                $ma_don_hang = !empty($hunter_order->service_order_code) ? $hunter_order->service_order_code : '';
                $noi_dung_don_hang = !empty($hunter_order->service_order_content) ? $hunter_order->service_order_content : '';
                $service_price_title = \App\Entity\Service_price::where('service_price_id', $hunter_order->service_price_id)->value('service_price_title');
                $package_name = \App\Entity\Service_table_price::where('service_table_price_id', $hunter_order->service_table_price_id)->value('package_name');
                $dich_vu = !empty($service_price_title) ? $service_price_title : '';
                $goi_dich_vu = !empty($package_name) ? $package_name : '';
                $gia_dich_vu = !empty($hunter_order->service_order_price) ? $hunter_order->service_order_price : '';
                $chiet_khau = !empty($hunter_order->service_order_discount) ? $hunter_order->service_order_discount : '';
                $gia_co_vat = !empty($hunter_order->service_order_vat) ? $hunter_order->service_order_vat : '';
                //lấy ra nội dung gửi email
                $content_email = $template_email->content_tem;
                //tiêu đề khi gửi email
                $subject = $template_email->subject_tem;
                //thay đổi biến thành chuỗi khi gửi email
                $search = ['{ma_don_hang}', '{noi_dung_don_hang}', '{dich_vu}', '{goi_dich_vu}', '{gia_dich_vu}', '{chiet_khau}', '{gia_co_vat}'];
                $replace = [$ma_don_hang, $noi_dung_don_hang, $dich_vu, $goi_dich_vu, $gia_dich_vu, $chiet_khau, $gia_co_vat];
                $content_string = str_replace($search, $replace, $content_email);
                //tiến hành gửi email
                MailConfig::sendMail($employer_email, $subject, $content_string);
            }
        }
        return true;
    }

    public static function send_apply_job($job_id_array, $employee_email)
    {
        if (!filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 39;
        $status_people = 1;//ung vien
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            $list_job = Job::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district')
                ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
                ->select(
                    'jobs.title',
                    'jobs.slug',
                    'jobs.district',
                    'jobs.province',
                    'jobs.deadline_submit_profile',
                    'employer.employer_id',
                    'employer.enterprise_name',
                    'employer.website as employer_website',
                    'employer.image as employer_image',
                    'salary.description as salary_description',
                    'district_name',
                    'province_name'
                )
                ->whereIn('jobs.job_id', $job_id_array)
                ->get();
            if (!empty($list_job)) {
                $string_html = '';
                foreach ($list_job as $job) {
                    $district_name = District::where('district_id', $job->district)->value('district_name');
                    $date = date_create($job->deadline_submit_profile);
                    $date_end = date_format($date, "d/m/Y");

                    $string_html .= '<div style="border-bottom: 1px solid #ccc;width: 100%">';
                    $string_html .= '<p style="margin: 5px 0">';
                    $string_html .= '<a style="font-size: 20px;color: #009385 !important;" href="' . route('job_detail', ['slug' => $job->slug]) . '"> ';
                    $string_html .= 'Tên công viêc : ' . !empty($job->title) ? $job->title : '';
                    $string_html .= '</a>';
                    $string_html .= '</p>';
                    $string_html .= '<p style="margin: 5px 0">';
                    $string_html .= 'Tên công ty : ' . !empty($job->enterprise_name) ? $job->enterprise_name : '';
                    $string_html .= '</p>';
                    $string_html .= '<p style="margin: 5px 0">';
                    $string_html .= 'Địa chỉ : ' . !empty($district_name) ? $district_name . ' - ' : '';
                    $string_html .= !empty($job->province_name) ? $job->province_name : '';
                    $string_html .= '</p>';
                    $string_html .= '<p style="margin: 5px 0">';
                    $string_html .= 'Hạn nộp hồ sơ : ';
                    $string_html .= !empty($date_end) ? $date_end : '';
                    $string_html .= '</p>';
                    $string_html .= '</div>';
                }
                //lấy ra nội dung gửi email
                $noi_dung_cong_viec = '';
                $content_email = $template_email->content_tem;
                //tiêu đề khi gửi email
                $subject = $template_email->subject_tem;
                //thay đổi biến thành chuỗi khi gửi email
                $search = ['{noi_dung_cong_viec}'];
                $replace = [$string_html];
                $content_string = str_replace($search, $replace, $content_email);
                //tiến hành gửi email
                MailConfig::sendMail($employee_email, $subject, $content_string);
            }
        }
        return true;
    }

    //nhân viên mời ứng tuyển cho công việc
    public static function send_staff_apply_job($job_id, $employee_email)
    {
        if (!filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //mã danh mục mẫu email
        $id_cate_tem = 40;
        $status_people = 1;//ung vien
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            $job = Job::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district')
                ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
                ->select(
                    'jobs.title',
                    'jobs.slug',
                    'jobs.district',
                    'jobs.province',
                    'jobs.deadline_submit_profile',
                    'employer.employer_id',
                    'employer.enterprise_name',
                    'employer.website as employer_website',
                    'employer.image as employer_image',
                    'salary.description as salary_description',
                    'district_name',
                    'province_name'
                )
                ->where('jobs.job_id', $job_id)
                ->first();
            if (!empty($job)) {
                $string_html = '';
                $district_name = District::where('district_id', $job->district)->value('district_name');
                $date = date_create($job->deadline_submit_profile);
                $date_end = date_format($date, "d/m/Y");

                $string_html .= '<div style="border-bottom: 1px solid #ccc;width: 100%">';
                $string_html .= '<p style="margin: 5px 0">';
                $string_html .= '<a style="font-size: 20px;color: #009385 !important;" href="' . route('job_detail', ['slug' => $job->slug]) . '"> ';
                $string_html .= 'Tên công viêc : ' . !empty($job->title) ? $job->title : '';
                $string_html .= '</a>';
                $string_html .= '</p>';
                $string_html .= '<p style="margin: 5px 0">';
                $string_html .= 'Tên công ty : ' . !empty($job->enterprise_name) ? $job->enterprise_name : '';
                $string_html .= '</p>';
                $string_html .= '<p style="margin: 5px 0">';
                $string_html .= 'Địa chỉ : ' . !empty($district_name) ? $district_name . ' - ' : '';
                $string_html .= !empty($job->province_name) ? $job->province_name : '';
                $string_html .= '</p>';
                $string_html .= '<p style="margin: 5px 0">';
                $string_html .= 'Hạn nộp hồ sơ : ';
                $string_html .= !empty($date_end) ? $date_end : '';
                $string_html .= '</p>';
                $string_html .= '</div>';

                //lấy ra nội dung gửi email
                $noi_dung_cong_viec = '';
                $content_email = $template_email->content_tem;
                //tiêu đề khi gửi email
                $subject = $template_email->subject_tem;
                //thay đổi biến thành chuỗi khi gửi email
                $search = ['{noi_dung_cong_viec}'];
                $replace = [$string_html];
                $content_string = str_replace($search, $replace, $content_email);
                //tiến hành gửi email
                MailConfig::sendMail($employee_email, $subject, $content_string);
            }
        }
        return true;
    }

    //email gui cho ung vien khi co cong viec phu hop
    public static function send_email_employee_job($job_id, $employee_email)
    {
        if (!filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //xoa tat email makettign da gui truoc do
        $delete_email_maketting = Send_user_email_marketting::delete_email();
        //them moi email maketting
        $insert_send_email_maketting = Send_user_email_marketting::insert_email($employee_email);
        //mã danh mục mẫu email
        //mã danh mục mẫu email
        $id_cate_tem = 41;
        $status_people = 1;//ung vien
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        if (!empty($template_email)) {
            $job = Job::select('job_id', 'title', 'slug', 'employer_id')->where('job_id', $job_id)->first();
            //cấu hình biến khi gửi mail

            if (!empty($job)) {
                $employer_name = Employer::where('employer_id', $job->employer_id)->value('enterprise_name');
                $title = $job->title;
                $link_tuyen_dung = route('job_detail', ['slug' => $job->slug]);
                //lấy ra nội dung gửi email
                $content_email = $template_email->content_tem;
                //tiêu đề khi gửi email
                $subject = $template_email->subject_tem;
                //thay đổi biến thành chuỗi khi gửi email
                $search = ['{title}', '{ten_cong_ty}', '{link_tuyen_dung}'];
                $replace = [$title, $employer_name, $link_tuyen_dung];
                $content_string = str_replace($search, $replace, $content_email);
                //tiến hành gửi email
                MailConfig::sendMail($employee_email, $subject, $content_string);
            }
            return true;
        }
        return true;

    }

    public static function send_email_apply_now_cv($job_id, $employee_email)
    {
        if (!filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
            return true;
            //email khong dung dinh dang nen se k gửi email
        }
        //xoa tat email makettign da gui truoc do
        //mã danh mục mẫu email
        $id_cate_tem = 43;
        $status_people = 1;//ung vien
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model
            ->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->where('status_people', $status_people)
            ->first();
        //cấu hình biến khi gửi mail
        $job = Job::select('job_id', 'slug', 'title', 'content', 'employer_id')->where('job_id', $job_id)->first();
        $employee = Employee::select('employee_id', 'employee_name', 'phone', 'email', 'employee_slug')->where('email', $employee_email)->first();
        //chjeclk neu loi thi k gui email
        if (empty($job) || empty($employee)) {
            return true;
        }
        if (!empty($template_email)) {
            $link_cong_viec = route('job_detail', ['slug' => $job->slug]);
            $link_ho_so = route('detail_employee_show', ['employee_slug' => $employee->employee_slug]);
            $user_model = new User();
            $userWithPhone = $user_model->select('name', 'phone', 'email', 'id', 'link_confirm_account')->where('email', $employee_email)->first();
            $link_confirm_account = $userWithPhone->link_confirm_account;
            $link_kich_hoat = route('link_confirm_account', ['link' => $link_confirm_account]) . '?job_id=' . $job_id;

            $employer = Employer::select('employer.email', 'employer.employer_id')->where('employer_id', $job->employer_id)->first();
            $link_danh_sach_ho_so = '';
            if (!empty($employer)) {
                $link_danh_sach_ho_so = route('list_profile_job') . '?email=' . $employer->email . '&employer_id=' . $employer->employer_id;
            }
            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;

            //thay đổi biến thành chuỗi khi gửi email
            $search = [
                '{title}',
                '{name}',
                '{email}',
                '{phone}',
                '{link_cong_viec}',
                '{link_kich_hoat}',
            ];

            $province = \App\Entity\Province::getId($employee->province);
            $replace = [
                $job->title,
                $employee->employee_name,
                $employee->email,
                $employee->phone,
                $link_cong_viec,
                $link_kich_hoat,
            ];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($employee_email, $subject, $content_string);
        }
        return true;

    }

    //dang-ky/nhan-gia-su-1-1  - route  user_advise_submit
    // Kết nối với gia
    public static function send_user_advise_submit($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        $id_cate_tem = 44;
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model
            ->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $link_ket_noi = route('list_support_user');
            $name = User::where('email', $email)->value('name');

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = [
                '{name}',
                '{link_ket_noi}',
            ];
            $replace = [
                $name,
                $link_ket_noi,
            ];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }
    }

    //dang-ky/tu-van-ke-toan  - route  support_user_advise
    // Kết nối với gia
    public static function send_support_user_advise($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        $id_cate_tem = 45;
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model
            ->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $link_ket_noi = route('list_advise_user');
            $name = User::where('email', $email)->value('name');

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = [
                '{name}',
                '{link_ket_noi}',
            ];
            $replace = [
                $name,
                $link_ket_noi,
            ];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }
    }
    //danh-sach/cap-nhat-trang-thai-giang-vien  - route  list_update_advise_status
    // Kết nối với gia
    public static function send_list_update_advise_status($email, $trang_thai)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        $id_cate_tem = 46;
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model
            ->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $link_ket_noi = route('list_support_user');
            $name = User::where('email', $email)->value('name');

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = [
                '{name}',
                '{link_ket_noi}',
                '{trang_thai}',
            ];
            $replace = [
                $name,
                $link_ket_noi,
                $trang_thai,
            ];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }
    }
    ///danh-sach/cap-nhat-trang-thai-ke-toan/  - route  list_update_support_status
    // Kết nối với gia
    public static function send_list_update_support_status($email, $trang_thai)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        $id_cate_tem = 47;
        //trạng thái sử dụng của email
        $status_tem = 1;
        $template_email_model = new Template_email();
        $template_email = $template_email_model
            ->where('id_cate_tem', $id_cate_tem)
            ->where('status_tem', $status_tem)
            ->first();
        if (!empty($template_email)) {
            //cấu hình biến khi gửi mail
            $link_ket_noi = route('list_advise_user');
            $name = User::where('email', $email)->value('name');

            //lấy ra nội dung gửi email
            $content_email = $template_email->content_tem;

            //tiêu đề khi gửi email
            $subject = $template_email->subject_tem;
            //thay đổi biến thành chuỗi khi gửi email
            $search = [
                '{name}',
                '{link_ket_noi}',
                '{trang_thai}',
            ];
            $replace = [
                $name,
                $link_ket_noi,
                $trang_thai,
            ];
            $content_string = str_replace($search, $replace, $content_email);
            //tiến hành gửi email
            MailConfig::sendMail($email, $subject, $content_string);
        }
    }


    public static function test_send_email()
    {
        $send_email = \App\Entity\MailConfig::test_sendMail($to = 'tttthang1996@gmail.com', 'tesst email', 'tesst noi dung gui');

        echo 1;
        echo '<pre>';
        print_r($send_email);
    }

    public function view_send_email()
    {
        return view('site.send_email.view_send_email');
    }

    public static function post_send_email(Request $request)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("tttthang1996@gmail.com", "Example User");
        $email->setSubject("Sending with Twilio SendGrid is Fun");
        $email->addTo("hotro@sanketoan.vn", "Example User");
        $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", "<strong>Email test tu sanketoan.vn</strong>"
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            echo '<pre>';
            print $response->statusCode() . "\n";
            echo '<pre>';
            print_r($response->headers());
            echo '<pre>';
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
//            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}
