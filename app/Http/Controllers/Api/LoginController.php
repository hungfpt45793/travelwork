<?php

namespace App\Http\Controllers\Api;
use App\Entity\User;
use App\Entity\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use JWTAuth;
class LoginController extends Controller
{
    use AuthenticatesUsers;
    public function index (Request $request) {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Thông tin tài khoản hoặc mật khẩu không chính xác',
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    ], 401);
            }
        } catch (JWTException $exception) {
            return response()->json(
                ['error' => 'Không thể tạo token. Đã có lỗi xảy ra',
                    'email' => $request->email,
                    'password' => $request->password,
                ], 500

            );
        }
        return response()->json(compact('token'));
    }

    public function getAuthUser(Request $request){

//        $user = Auth::user($request->token);
        $user = JWTAuth::toUser($request->token);

//        $user = JWTAuth::toUser($request->token);

        return response()->json(['result' => $user]);
    }

    public function checkAuthUser(Request $request) {
        try {
            $user = JWTAuth::toUser($request->token);
            return response()->json([
                'status' => '200',
                'user' => array(
                    'email'=> $user->email,
                    'phone'=> $user->phone,
                    'name'=> $user->name,
                    'role'=> $user->role,
                ),
                'message' => 'Token vẫn có thể sử dụng.'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => '400',
                'message' => 'Token đã hết hạn sử dụng.'
            ]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => '400',
                    'error' => 'Thông tin tài khoản hoặc mật khẩu không chính xác',
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                ],400);
            }
        } catch (JWTException $exception) {
            return response()->json(
                ['error' => 'Không thể tạo token. Đã có lỗi xảy ra',
                    'email' => $request->email,
                    'password' => $request->password,
                ], 500
            );
        }
        $user = User::select('id',
            'email',
            'password',
            'phone',
            'role',
            'diendan_image',
            'diendan_role',
            'diendan_code_intro',
            'name'
           )->where('email',$request->input('email'))
        ->first();
        $taikhoan = '';
        if($user->role == 1)
        {
            $taikhoan = 'Tài khoản ứng viên';
        }elseif($user->role == 2)
        {
            $taikhoan = 'Tài khoản nhà tuyển dụng';
        }
        $user['image'] = !empty($user['image']) ? asset($user['image']) : '';
        $user['diendan_image'] = !empty($user['diendan_image']) ? asset($user['diendan_image']) : '';
        return response()->json([
            'status' => 200,
            'token' => $token,
            'user'   => $user,
            'tai-khoan'   => $taikhoan,
        ],200);
    }
    public function login_sandev(Request $request)
    {
        $user = array();
        if($this->attemptLogin($request))
        {
            $user = Users::select('id',
                'email',
                'password',
                'phone',
                'role',
                'name'
            )->where('email',$request->input('email'))
                ->where('role',1)
                ->first();
            $user['password_input'] = $request->password;
            return response()->json([
                'status' => 200,
                'user' => $user,
            ],200);
        }
        return response()->json([
            'status' => 400,
            'user' => $user,
        ],400);
    }
    public function logout(Request $request)
    {

        $token = $request->input('token');
//        echo $token;
        try{
            JWTAuth::invalidate($token);
            $this->guard()->logout();
            return response()->json([
                'status' => 200,
                'message' => 'Đăng xuất tài khoản thành công',
            ],200);
        }catch (\Exception $e)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Đã xảy lỗi trong quá trình đăng xuất ! Vui lòng thử lại',
            ],400);
        }

//        return response()->json(['message' => 'Successfully logged out');

    }
    public function guard()
    {
        return Auth::guard();
    }
}
