<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

use Prophecy\Call\Call;
use App\Rules\Invateemails;
use Illuminate\Support\Facades\Validator;
use App\Mail\Resetpassword;
use Illuminate\Support\Facades\URL;


class CkedittorController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!Auth::check()) {
                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng dăng nhập để sử dụng chức năng này !');
            }
            $this->id_user = Auth::user()->id;
            return $next($request);
        });
    }

    public function checkImage()
    {
        if (Auth::check()) {
            $user = Auth::user();
//            if (User::isManager($user->role) || User::isEditor($user->role)) {
            $_SESSION['loginSuccessAdmin'] = $user->email;
            $_SESSION['role'] = $user->role;
            if ($user->role == 1) {
                $upload = "library_employee/" . $user->id;
                $_SESSION['loginSuccessAdmin'] = $user->id;
            }
            if ($user->role == 2) {
                $upload = "library_employer/" . $user->email . "-" . $user->id;
            }
            if ($user->role == 3) {
                $upload = "library_teacher/" . $user->email . "-" . $user->id;
            }
            if ($user->role == 4) {
                $upload = "library";
            }
            if ($user->role == 5) {
                $upload = "library_staff/".$user->id;
            }
            if ($user->role == 6) {
                $upload = "library_staff_member/".$user->id;
            }
            if ($user->role == 7) {
                $upload = "library_staff_hr/".$user->id;
            }
//                if ($user->role == 4) {
//                    $upload = "library";
//                }
//                if ($user->role < 4) {
//                    $upload = "library_employer/" . $user->email . "-" . $user->id;
//                }
            $_SESSION['emailFolder'] = $upload;
//            }
            return $_SESSION;
        }
    }


}


