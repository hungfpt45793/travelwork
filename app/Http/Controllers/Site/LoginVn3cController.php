<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 1/24/2018
 * Time: 2:02 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Post;
use App\Entity\User;
use App\Mail\Mail;
use App\Ultility\InforFacebook;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;

class LoginVn3cController extends SiteController
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
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.template.dang-nhap-tao-theme');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
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

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // kiem tra xem ton tai domain ko
        if ($this->attemptLogin($request)) {
            $user = User::where('email', $request->input('email'))->first();
            if ($user->role >= 3) {

                return $this->sendLoginResponse($request);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return redirect('/trang/quan-ly-theme');
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect('/trang/dang-nhap-tao-theme')
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    public function callbackLogin(Request $request) {
        $app = new InforFacebook();

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
            $user = User::where('email', $userFacebook['id'].'@kidandmom.com')->first();
            if (!empty($user)) {
                Auth::login($user);

                return redirect(URL::to('/'));
            }

            $user = new User();
            $user->insert([
                'name' => $userFacebook['name'],
                'role' => 1,
                'email' => $userFacebook['id'].'@kidandmom.com',
                'password' => bcrypt($userFacebook['id'].$userFacebook['name']),
                'remember_token' => str_random(10),
            ]);

            $userNew = User::where('email', $userFacebook['id'].'@kidandmom.com')->first();
            Auth::login($userNew);

            return redirect(URL::to('/'));

        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleProviderCallback()
    {
        $userGoogle = Socialite::driver('google')->user();

        $user = User::where('email',  $userGoogle->getEmail())->first();
        if (!empty($user)) {
            Auth::login($user);

            return redirect(URL::to('/'));
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

        return redirect(URL::to('/'));
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}