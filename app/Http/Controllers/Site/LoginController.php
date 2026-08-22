<?php

namespace App\Http\Controllers\Site;

use App\Course\Course_order;
use App\Course\Course_teacher_active;
use App\Course\Courses;
use App\Entity\Employee;
use App\Entity\Post;
use App\Entity\User;
use App\Http\Controllers\Site\Course\CourseEmployeeController;
use App\Mail\Mail;
use App\Ultility\Facebook;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\View;
use JWTAuth;

class LoginController extends SiteController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('/');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [
            'required' => 'Trường :attribute không được để trống'
        ]);
    }

    public function callbackLogin(Request $request)
    {
        $app = new Facebook();

        $fb = new \Facebook\Facebook([
            'app_id' => $app->getAppId(),
            'app_secret' => $app->getAppSecret(),
            'default_graph_version' => $app->getDefaultGraphVersion()
        ]);

        $helper = $fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $accessToken = $helper->getAccessToken();
            $response = $fb->get('/me', $accessToken);
            $userFacebook = $response->getDecodedBody();
            $user = User::where('email', $userFacebook['id'] . '@kidandmom.com')->first();
            if (!empty($user)) {
                Auth::login($user);
                return redirect(URL::to('/'));
            }

            $user = new User();
            $user->insert([
                'name' => $userFacebook['name'],
                'role' => 1,
                'email' => $userFacebook['id'] . '@kidandmom.com',
                'password' => bcrypt($userFacebook['id'] . $userFacebook['name']),
                'remember_token' => str_random(10),
            ]);

            $userNew = User::where('email', $userFacebook['id'] . '@kidandmom.com')->first();
            Auth::login($userNew);

            return redirect(URL::to('/'));

        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        }
    }

//    protected function sendLoginResponse(Request $request)
//    {
////        if (\Request::is('site_home')) {
////            // show companies menu or something
////            echo 1;die();
////        }
//        $request->session()->regenerate();
//        $this->clearLoginAttempts($request);
//            $role = Auth::user()->role;
//            if($role == 1)
//            {
//                return redirect(route('list_job_face'));
//            }
//            if($role == 2)
//            {
//                return redirect(route('portEmployer'));
//            }
//            if($role == 3)
//            {
//                return redirect(route('showTeacher'));
//            }
//            return redirect(route('list_job_face'));
//    }
    public function login(Request $request)
    {
        if (Auth::check()) {
            $url = redirect()->back()->getTargetUrl();
            return redirect($url)->with('error', 'Bạn đã đăng nhập rồi');
        }
        $this->validateLogin($request);
        // kiem tra xem ton tai domain ko
        $user = User::where('email', $request->input('email'))
            ->first();
        if(empty($user->email))
        {
            return redirect()->back()->with('mesage_modal', 'Tài khoản hoặc mật khẩu không đúng');
        }
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if (!empty($user->email) && $this->attemptLogin($request)) {
            //tam an de test laij dang nhap
//            $request->session()->regenerate();
//            $this->clearLoginAttempts($request);
            $user_level = User::where('email', $user->email)
                ->first();
            $role = Auth::user()->role;
            if ($role == 1) {
                //luu mã kích hoat khóa học
                if($request->session()->has('activation_code') && $request->session()->has('status_select_active_code') )
                {
                    $activation_code = $request->session()->get('activation_code');
                    $status_select_active_code = $request->session()->get('status_select_active_code');

                    $course_id = 0;
                    if($status_select_active_code == 0)
                    {
                        $course_id =  Courses::where('activation_code',$activation_code)->value('course_id');
                    }
                    if($status_select_active_code == 1)
                    {
                        $course_id =  Course_order::where('activation_code',$activation_code)->value('course_id');
                    }
                    if($status_select_active_code == 2)
                    {
                        $course_id =  Course_teacher_active::where('activation_code',$activation_code)->value('course_id');
                    }
                    if(!empty($course_id))
                    {
                        $course_employee = new CourseEmployeeController();
                        $active_employee = $course_employee->get_active_employee(Auth::user()->id,$course_id,$activation_code,$status_select_active_code);
                    }
                    //xóa session
                    $request->session()->forget('activation_code');
                    $request->session()->forget('status_select_active_code');
                }
                $url = redirect()->back()->getTargetUrl();
                $employee_profile = \App\Entity\Employee::get_profile(Auth::user()->id);
                if($employee_profile->profile < 50)
                {
                     return redirect($url)->with('mesage_modal', 'Đăng nhập thành công ! Hồ sơ của bạn chưa được cập nhật đầy đủ , Vui lòng hoàn thiện hồ sơ');
                }
                return redirect($url)->with('mesage_modal', 'Đăng nhập thành công');
                //đăng nhâp thì vào trang danh sách công viêc
            }
            if (!empty($request->input('home'))) {
                if ($user->status_email_account == 0) {
                    return redirect(route('management_account'));
                } elseif ($role == 2) {
                    //đăng nhập vào phần nhà tuyển dụng
                    return redirect(route('portEmployer'));
                } elseif ($role == 3 && $user->status_teacher_sc == 0) {
                    //đăng nhập vào tủ hồ sơ
                    return redirect(route('course_index'));
                } elseif ($role == 3 && $user->status_teacher_sc == 1) {
                    //đăng nhập vào tủ hồ sơ quản lý đề thi các trường đại học
                    return redirect(route('getRomAll'));
                } elseif ($role == 5) {
                    //đăng nhập vào tủ hồ sơ quản lý đề thi các trường đại học
                    return redirect(route('dashboard'));
                } else {
                    $url = redirect()->back()->getTargetUrl();
                    return redirect($url)->with('mesage_modal', 'Đăng nhập thành công');
                }
            }
            if ($role == 5) {
                //đăng nhập vào tủ hồ sơ quản lý đề thi các trường đại học
                return redirect(route('staff_employee.index'));
            }
            $url = redirect()->back()->getTargetUrl();
            return redirect($url)->with('mesage_modal', 'Đăng nhập tài khoản thành công');
        }
//        if ($this->attemptLogin($request)) {
//            $request->session()->regenerate();
//            $this->clearLoginAttempts($request);
//            $url = redirect()->back()->getTargetUrl();
//            return redirect($url)->with('mesage_modal', 'Tài khoản hoặc mật khẩu không đúng');
////            return redirect(route('showAllExam'));
//        }
        $this->incrementLoginAttempts($request);
        $errors = [$this->username() => trans('auth.failed')];
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors)
            ->with('mesage_modal', 'Tài khoản hoặc mật khẩu không đúng');
    }

    public function login_money(Request $request)
    {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        // kiem tra xem ton tai domain ko
        $user = User::where('email', $request->input('email'))
            ->first();
        if (isset($user->email) && $this->attemptLogin($request)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            $user_level = User::where('email', $user->email)
                ->first();

            if (!empty($request->input('home'))) {
                $role = Auth::user()->role;
                if ($role == 1) {
                    return redirect(route('post_sale_employee'));
                } elseif ($role == 2) {
                    return redirect(route('portEmployer'));
                } elseif ($role == 3 && $user->status_teacher_sc == 0) {
                    return redirect(route('showTeacher'));
                } elseif ($role == 3 && $user->status_teacher_sc == 1) {
                    return redirect(route('getRomAll'));
                } else {
                    $url = redirect()->back()->getTargetUrl();
                    return redirect($url)->with('succes', 'Đăng nhập thành công');
                }
            } else {
                $url = redirect()->back()->getTargetUrl();
                return redirect($url)->with('succes', 'Đăng nhập thành công');
            }
        }
        if ($this->attemptLogin($request)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            $url = redirect()->back()->getTargetUrl();
            return redirect($url)->with('error_login', 'Tài khoản hoặc mật khẩu không đúng');
//            return redirect(route('showAllExam'));
        }
        $this->incrementLoginAttempts($request);
        $errors = [$this->username() => trans('auth.failed')];
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors)
            ->with('error_login', 'Tài khoản hoặc mật khẩu không đúng');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errorsLogin = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errorsLogin, 422);
        }

        $errorsLogin['loginFail'] = 'Đăng nhập bị lỗi';

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errorsLogin);
    }

    public function handleProviderCallback()
    {
        $userGoogle = Socialite::driver('google')->user();






        $user = User::where('email', $userGoogle->getEmail())->first();
        if (!empty($user)) {
            Auth::login($user);
            return $url = redirect(route('list_job_face'));
        }

        $user = new User();
        $user->insert([
            'name' => $userGoogle->getName(),
            'role' => 1,
            'email' => $userGoogle->getEmail(),
            'password' => bcrypt(str_random(10)),
            'remember_token' => str_random(10),
        ]);
        $userNew = User::where('email', $userGoogle->getEmail())->first();
        Auth::login($userNew);

        return $url = redirect(route('list_job_face'));
    }

    //check/login-api-token/
    public function login_api(Request $request, $token)
    {
        echo $token;
        die();
//        try {
        if (Auth::check()) {

            return redirect(route('show_file_job_facebook'));
        } else {
            $check_user = JWTAuth::toUser($token);
            Auth::login($check_user);
        }
        return redirect(route('show_file_job_facebook'));
//        } catch (\Exception $e) {
//            return redirect(route('show_file_job_facebook'));
//        }

    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        // xóa session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        return redirect('/');
    }
    public function get_logout(Request $request)
    {
//        echo 1;die;
        $this->guard()->logout();
        $request->session()->invalidate();
        // xóa session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        return redirect()->back()->with('success_logout','Bạn đã đăng xuất tài khoản thành công !');
    }

}
