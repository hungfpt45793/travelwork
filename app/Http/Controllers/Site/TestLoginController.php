<?php

namespace App\Http\Controllers\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Course\Course;
use App\Entity\Category;
use App\Entity\Employee;
use App\Entity\EmployerEmployee;
use App\Entity\EmployerTransfer;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Province;
use App\Entity\Statistical_employees;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_specialize;
use App\Entity\TeacherLearnEmployees;
use App\Entity\TeacherStarLearn;
use App\Entity\District;
use App\Entity\TypeOfBusiness;
use App\Entity\User;





class TestLoginController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('menuTopsite', 'teacher');
    }

    // test thử chức năng đăng nhập trên 1 máy  
    public function index()
    {
        return view('site.test_login.index');
    }
    // END test thử chức năng đăng nhập trên 1 máy  

    // hàm check đăng nhập 
    public function authenticated () {
        
        $user = Auth::user();
        $previous_session = $user->last_session_id;
        if ($previous_session != null) {
            \Session::getHandler()->destroy($previous_session);
            $check = true;
        } else {
            $check = false;
        }

        // update session_id cho user 
        $temp_user = User::where('id', $user->id)->first();
        $temp_user->update([
            'last_session_id' => \Session::getId()
        ]);
        // END update session_id cho user 
        return $check;
    }
    // END hàm check đăng nhập 


    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if ( Auth::attempt(['email' => $email, 'password' => $password]) ) {
            $message = "đăng nhập thành công";
            $check = $this->authenticated();
            if ($check == true) {
                $message = "đăng nhập thành công, đăng xuất chỗ khác";
            } else {
                $message = "đăng nhập thành công, đăng nhập mới";
            }
        } else {
            $message = "đăng nhập KHÔNG thành công";
        }
        return redirect(route('test_login'))->with('message', $message);
    }

    public function logout (Request $request) {
        $user = Auth::user();
        // update session_id cho user 
        $temp_user = User::where('id', $user->id)->first();
        $temp_user->update([
            'last_session_id' => null
        ]);
        // END update session_id cho user 
        Auth::logout();
        $message = "đăng xuất thành công";
        return view('site.test_login.logout');
    }
}