<?php

namespace App\Http\Controllers\Site;
use App\Ultility\Facebook;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class LoginApiController extends SiteController
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
    //check/login-api-token/
    public function login_api(Request $request , $token)
    {
        try {
        if(Auth::check())
        {
            return redirect(route('show_file_job_facebook'));
        }
        else
        {
            $check_user = JWTAuth::toUser($token);
            Auth::login($check_user);
        }
        return redirect(route('show_file_job_facebook'));
        } catch (\Exception $e) {
            return redirect(route('show_file_job_facebook'));
        }
    }
    public function login_api_submit_job(Request $request , $token)
    {
        try {
        if(Auth::check())
        {
            return redirect(route('show_file_job_facebook'));
        }
        else
        {
            $check_user = JWTAuth::toUser($token);
            Auth::login($check_user);
        }
        return redirect(route('list_Job_Candidate_Employee'));
        } catch (\Exception $e) {
            return redirect(route('show_file_job_facebook'));
        }
    }

}
