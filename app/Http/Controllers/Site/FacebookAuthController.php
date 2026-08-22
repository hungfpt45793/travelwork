<?php

namespace App\Http\Controllers\Site;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Socialite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class FacebookAuthController extends Controller
{
    protected $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $auth_login = $this->findOrCreateUser($user);
        // Chỗ này để check xem nó có chạy hay không
        //dd($user);
        ini_set('memory_limit', '-1');
        //print_r($auth_login);die();
        Auth::login($auth_login,true);
        if(empty(Auth::user()->email))
        {
            return redirect()->route('show_file_job_facebook')->with('success_login','Bạn vui lòng bổ sung thông tin hồ sơ!');
        }
        return redirect()->route('post_sale_employee')->with('success_login','Bạn đã đăng nhập thành công!');
    }
    private function findOrCreateUser($facebookUser){
        try{
            $authUser = User::where('provider_id', $facebookUser->id)->first();
            if($authUser){
                return $authUser;
            }
            else
            {
                DB::beginTransaction();
                $user_model = new User();
                $user_id = $user_model->insertGetId([
                    'name' => $facebookUser->name,
                    'password' => $facebookUser->token,
                    'provider_id' => $facebookUser->id,
                    'provider' => $facebookUser->id,
                    'role' => 1,
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
                $employeeId = Employee::insertGetId([
                    'employee_name' => $facebookUser->name,
                    'user_id' => $user_id,
                    'status' => 0,
                    'salary_id' => 6,
                    'career_category_id' => 1,
                    'created_at' => new \DateTime(),
                ]);
                DB::commit();
                $authUser_insert = User::select('*')->where('id', $user_id)->first();
                $authUser_login = User::where('provider_id', $authUser_insert->provider_id)->first();
                if($authUser_login){
                    return $authUser_login;
                }
            }
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect(URL::to('/'));
        }
    }
}