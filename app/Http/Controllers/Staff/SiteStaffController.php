<?php
namespace App\Http\Controllers\Staff;

use App\Entity\Domain;
use App\Entity\Information;
use App\Entity\Information_money;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Theme;
use App\Entity\TypeInformation;
use App\Entity\TypeInformation_money;
use App\Entity\Job;
use App\Entity\ResAdvisory;
use App\Entity\User;
use App\Entity\Res_advisory_interactive;
use App\Entity\VoucherComment;
use App\Entity\Order_interactive;
use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\Hunter_registration;
use App\Entity\Service_order_icon;
use App\Entity\Service_order;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\CkedittorController;
use App\Ultility\InforFacebook;
use App\Ultility\Ultility;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:02 AM
 */
class SiteStaffController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!Auth::check()) {
                return redirect(route('home'))->with('error_login', 'Vui lòng đăng nhập để sử dụng chức năng này!');
            }
            if (Auth::user()->role != 5) {
                return redirect(route('home'))->with('error_login', 'Tài khoản không có quyền truy cập khu vực nhân viên!');
            }
            //dem tin viec lam chua duyet
            $job_not_active = Job::where('active_job', 0)->count();
            //dem ntd dang ky tu van chua dc tuong tac
                $ntd_dk_tt = Res_advisory_interactive::join('res_advisory', 'res_advisory.id_res', 'res_advisory_interactive.advisory_id')
                ->where('res_advisory.status_res',0)
                ->distinct('res_advisory_interactive.advisory_id')->count('res_advisory_interactive.advisory_id');
                $ntd_dk_untt = ResAdvisory::where('status_res', 0)->count() - $ntd_dk_tt;
            //dem uv dang ky tu van chua dc tuong tac
                $uv_dk_tt = Res_advisory_interactive::join('res_advisory', 'res_advisory.id_res', 'res_advisory_interactive.advisory_id')
                ->where('res_advisory.status_res',1)
                ->distinct('res_advisory_interactive.advisory_id')->count('res_advisory_interactive.advisory_id');
                $uv_dk_untt = ResAdvisory::where('status_res', 1)->count() - $uv_dk_tt;
            //dem don hang chua co tuong tac nao 
                

            //dem binh luan chua tra loi
                $total_comments = VoucherComment::where('voucher_comment.parent_id_voucher_cm', 0)->count();
                $commented = VoucherComment::join('users','users.id','=','voucher_comment.user_id')
                ->distinct('voucher_comment.parent_id_voucher_cm')->count('voucher_comment.parent_id_voucher_cm') -1;//do default 0
                $total_no_comment = $total_comments - $commented;
            //dem ung vien chua duyet
                $unemployee = Employee::where('status_employee', 0)->count();
            //dem nha tuyen dung chua duyet
                $unemployer = Employer::where('status_employer', 0)->count();
            if($menuTop = 'donhang')
            {
                //sl don hang service da tt
                $order_interactive1 = Order_interactive::join('service_order', 'service_order.service_order_id', 'order_interactive.order_id')
                ->whereNull('service_order.deleted_at')
                ->where('order_interactive.type_order', 1)->distinct('order_interactive.order_id')->count('order_interactive.order_id');
                //sl don hang hunter da tt
                $order_interactive2 = Hunter_registration::leftJoin('order_request', 'order_request.hunter_regis_id', 'hunter_registration.hunter_regis_id')->distinct('hunter_registration.hunter_regis_id')->whereNotNull('order_request.order_request_id')->pluck('hunter_registration.hunter_regis_id')->count();
                //sl don hang icon da tt
                $order_interactive3 = Order_interactive::join('service_order_icon', 'service_order_icon.service_order_icon_id', 'order_interactive.order_id')
                ->whereNull('service_order_icon.deleted_at')
                ->where('order_interactive.type_order', 3)->distinct('order_interactive.order_id')->count('order_interactive.order_id');
            
                $total_service_order = Service_order::count();
                $total_hunter_order = Hunter_registration::count();

                //sl don hang service chua tt
                $un_order_interactive1 = $total_service_order - $order_interactive1;
                //sl don hang hunter chua tt
                $un_order_interactive2 = $total_hunter_order - $order_interactive2;

                //tong
                $un_tong_order = $un_order_interactive1 + $un_order_interactive2 ;
                $total_order_request = \App\Entity\Order_request::count();
                $total_order_job = \App\Entity\Order_job::count();
                $total_hunter_regis = \App\Entity\Hunter_registration::count();
                view()->share([
                    'total_order_request' => $total_order_request,
                    'total_order_job' => $total_order_job,
                    'total_hunter_regis' => $total_hunter_regis,
                    'un_order_interactive1' => $un_order_interactive1,
                    'un_order_interactive2' => $un_order_interactive2,
                    'un_tong_order' => $un_tong_order
                ]);
            }
            view()->share([
                'menuTopsite' => 'menuwebsite',
                'job_not_active' => $job_not_active,
                'total_no_comment' => $total_no_comment,
                'unemployee' => $unemployee,
                'unemployer' => $unemployer,
                'ntd_dk_untt' => $ntd_dk_untt,
                'uv_dk_untt' => $uv_dk_untt
            ]);

            $user = Auth::user();
            $this->id_user = $user->id;
            $ckeditor = new CkedittorController();
            $session_image = $ckeditor->checkImage();
            $_SESSION['loginSuccessAdmin'] = $user->email;
            $_SESSION['role'] = $user->role;

            $upload = "library_staff/" . $user->id;
            $_SESSION['emailFolder'] = $upload;
            return $next($request);
        });
    }


}
