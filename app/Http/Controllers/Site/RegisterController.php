<?php

namespace App\Http\Controllers\Site;

use App\Entity\Cv_employee;
use App\Entity\Employee_curriculum;
use App\Entity\Employer;
use App\Entity\MailConfig;
use App\Entity\Province;
use App\Entity\Teacher;
use App\Entity\Template_email;
use App\Entity\User;
use App\Entity\District;
use App\Entity\Employee;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;


class RegisterController extends SiteController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
//        $this->middleware('guest');
    }


    public function showRegistrationForm()
    {
        return view('site.default_site.register');
    }


    public function showEmployerRegistrationForm()
    {
        return view('site.employer_site.create');
    }

    public function check_tax_code(Request $request)
    {
        $tax_code = $request->input('tax_code');
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => true,
                "verify_peer_name" => true,
            ),
        );
//        $response = file_get_contents('https://sanketoan.vn/api/ma-so-thue/'.$tax_code, false, stream_context_create($arrContextOptions));

        $response = file_get_contents('https://thongtindoanhnghiep.co/api/company/' . $tax_code, false, stream_context_create($arrContextOptions));
        $response = json_decode($response);
        $province_id = Province::where('province_name', 'like', '%' . $response->TinhThanhTitle . '%')->value('province_id');
        $district_id = District::where('district_name', 'like', '%' . $response->QuanHuyenTitle . '%')->value('district_id');

        if (!empty($response->DiaChiCongTy)) {
            $response->province_id = $province_id;
            $response->district_id = $district_id;
            $response = json_encode($response);
//        echo '<pre>';
//        print_r($response);die;
            return $response;
        }

    }

    public function showEmployeeRegistrationForm(Request $request)
    {
//        echo $request->session()->get('activation_code');die;
        return view('site.employee.create');
    }

    public function showTeacherRegistrationForm()
    {

        return view('site.teacher.create');
    }

    public function reset_passwrod()
    {
        return view('site.default_site.reset_password');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'g-recaptcha-response' => 'required',
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);
        return $this->registered($request, $user)
            ?: redirect()->back();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Entity\User
     */
    protected function create(array $data)
    {
        $userModel = new User();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => isset($data['phone']) ? $data['phone'] : '',
            'role' => 1,
        ]);
//        }
        if (!empty($user)) {
            $subject = 'Sanketoan.vn thông báo';
            $content = '<p>Bạn đã đăng kí ứng viên thành công !</p>';
            MailConfig::sendMail($data['email'], $subject, $content);
        }
        $employeeId = Employee::insertGetId([
            'employee_name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'employee_user_id' => $user->id,
            'status' => 0,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        return $user;

    }


    private function sendMailForget($email, $user, $newPassword)
    {
        $informationGeneralModel = new InformationGeneral();
        $informationGenerals = $informationGeneralModel
            ->where('theme_code', $this->themeCode)
            ->where('user_email', $this->emailUser)
            ->get();

        //lay theo element de show ra
        $informationElement = array();
        foreach ($informationGenerals as $informationGeneral) {
            $informationElement[$informationGeneral->slug] = $informationGeneral->content;
        }
        $link_web = URL::to('/');
        print_r($informationElement);
        exit;
        $phone = informationElement['phone'];
        $address = informationElement['address'];
        $link_fb = informationElement['fb'];
        $link_logo = informationElement['logo'];
        $to = $email;
        $from = 'vn3ctran@gmail.com';
        $subject = 'q m k';
        $content = $mailConfig->content;
//$email, $name, $password,$link_web,$phone,$address,$link_fb,$link_logo
        $mail = new Resetpassword(
            $email,
            $user->name,
            $newPassword,
            $link_web,
            $phone,
            $address,
            $link_fb,
            $link_logo
        );

        \Mail::to($to)->send($mail->from($from)->subject($subject));
    }

    public function send_email(Request $request)
    {
        try {
            $email = $request->input('email');
            $user = User::where('email', $email)
                ->first();
            if (empty($user)) {
                return redirect()->back()->with('error', 'Email đăng kí không tồn tại');
            }
            $email_otp = Ultility::create_random_string(5, 7);
            $update = User::where('email', $email)->update([
                'reset_password' => $email_otp
            ]);
            MailConfigController::resetPassword($email, $user, $email_otp);
            $message = 'Mã xác thực đã được gửi tới Email của bạn . Vui lòng kiểm tra trong Email : '.$email;
            return view('site.default_site.change_password_otp_email', compact('message', 'user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra trong quá trình gửi email mã xác thực! Vui lòng thử lại sau');
        }

    }

    public function change_otp_email(Request $request)
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

        // if validation fail return error
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        $email = $request->input('email');
        $otp_email = $request->input('otp_email');
        $password = $request->input('password');

        $check_user = User::where('email', $email)
            ->where('reset_password', $otp_email)
            ->first();
        $user = User::where('email', $email)
            ->first();
        if (empty($check_user)) {
            $message = 'Mã xác thực không đúng. Vui lòng kiểm tra lại trong Email : '.$email;
            return view('site.default_site.change_password_otp_email', compact('message', 'user'));

        }
        User::where('email', $email)
            ->where('reset_password', $otp_email)
            ->update([
                'password' => bcrypt($request->input('password')),
                'reset_password' => ''
            ]);
        $message_success = 'Bạn đã thay đổi mật khẩu thành công .';
        return view('site.default_site.change_password_success', compact('message_success', 'user'));
    }

    public function active_password(Request $request, $link)
    {
        if (empty($link)) {
            return view('site.default.reset_password_success');
        }
        $user = new User();
        $user = $user->where('reset_password', $link)->first();
        if (!empty($user)) {
            $newPassword = str_random(10);
            $update = $user->where('reset_password', $link)
                ->where('email', $user->email)
                ->update([
                    'password' => bcrypt('123456a@'),
                    'reset_password' => ''
                ]);
            return view('site.default.reset_password_success');
        }
        return redirect('/');


    }

    public function confrirm_email()
    {
        if (Auth::check()) {
            $user_confirm = Auth::user();
//            print_r($user_confirm);die();
            return view('site.default.confirm_email', compact('user_confirm'));

        }
        return redirect('/');
    }

    //thay đổi địa chỉ email và kích hoạt lại tài khoản
    public function change_email_confirm(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'g-recaptcha-response' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->with('registerEmployee', 'Đăng ký ứng viên lỗi !')
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $email_confirm = $request->input('email');
            $user = Auth::user();
            $user_model = new User();
            $link_confirm_account = str_random(10) . $user->id;
            $update = $user_model->where('id', $user->id)->update([
                'email' => $email_confirm,
                'link_confirm_account' => $link_confirm_account,
                'status_email_account' => 0,
            ]);
            //thay đổi địa chỉ email của ứng viên
            if ($user->role == 1) {
                $employee_model = new Employee();
                $update = $employee_model->where('user_id', $user->id)->update([
                    'email' => $email_confirm
                ]);
            }
            //thay đổi địa chỉ email của nhà tuyển dụng
            if ($user->role == 2) {
                $employer_model = new Employer();
                $update = $employer_model->where('user_id', $user->id)->update([
                    'email' => $email_confirm
                ]);
            }
            //thay đổi địa chỉ email của giáo viên
            if ($user->role == 3) {
                $teacher_model = new Teacher();
                $update = $teacher_model->where('user_id', $user->id)->update([
                    'teacher_email' => $email_confirm
                ]);
            }
            //tiến hành gửi email
            MailConfigController::send_change_email($user->name, $email_confirm, $link_confirm_account);
            DB::commit();
            return redirect()->back()->with('success_email', 'Bạn đã thay đổi địa chỉ email thành công ! Vui lòng kích hoạt lại tài khoản trong email của bạn');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('success_email', 'Bạn đã thay đổi địa chỉ email thất bại !');
        }
    }
    //tien hanh gui mail

    //quản lý tài khoản tai-khoan/quan-ly-tai-khoan
    public function management_account()
    {
        if (Auth::check()) {
            $user_confirm = Auth::user();
            $employee_model = new Employee();
            $employee = $employee_model
                ->select('employee_id',
                    'employee_name',
                    'phone',
                    'email',
                    'address',
                    'user_id'
                )
                ->where('user_id', $user_confirm->id)
                ->first();
            $employer_model = new Employer();
            $employer = $employer_model->select('employer_id',
                'employer_code',
                'enterprise_name',
                'phone',
                'email',
                'address',
                'province',
                'district',
                'address',
                'user_id'
            )
                ->where('user_id', $user_confirm->id)
                ->first();
            $teacher_model = new Teacher();
            $teacher = $teacher_model->select('teacher_id',
                'teacher_code',
                'teacher_name',
                'slug',
                'teacher_phone',
                'teacher_email',
                'teacher_images',
                'teacher_info',
                'province',
                'district',
                'address'
            )
                ->where('user_id', $user_confirm->id)
                ->first();
//            if($user_confirm->status_email_account == 0)
//            {
//                MailConfigController::send_email_confirm($user_confirm->email);
//            }
            $status_email_account = '';
            $check_cv = '';
            if (Auth::user()->role == 1) {
                $user = Auth::user();
                $employees = new Employee();
                $employee = $employees->select('*')->where('user_id', $user->id)->first();
                $status_email_account = $user->status_email_account;
                $check_cv = Cv_employee::where('employee_id', $employee->employee_id)->count();


            }

            return view('site.default_site.management_account', compact('user_confirm', 'employee', 'employer', 'teacher', 'status_email_account', 'check_cv'));
        }
        return redirect('/');

    }


}
