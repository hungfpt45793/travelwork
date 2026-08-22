<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/16/2017
 * Time: 9:24 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entity\Contact;
use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\Information;
use App\Entity\Job;
use App\Entity\JobFacebook;
use App\Entity\Notification;
use App\Entity\Order;
use App\Entity\Post;
use App\Entity\Teacher;
use App\Entity\TypeInformation;
use App\Entity\TypeSubPost;
use App\Entity\User;
use App\Entity\Voucher;
use App\Exam\Exam;
use App\Http\Controllers\Controller;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected $isSale;

    public function __construct($countNotifi = 12){
        try {
            if(Auth::check() && Auth::user()->role != 4)
            {
                return redirect(route('name'));
            }
            $countNotification = new Notification();
            $countReport = $countNotification->countReport();
            $typeSubPostsAdmin = TypeSubPost::orderBy('type_sub_post_id')
                ->get();
            $notifications = Notification::orderBy('notify_id', 'desc')
                ->offset(0)->limit($countNotifi)->get();


            $typeInformations = TypeInformation::orderBy('type_infor_id')
                ->get();
            // get information
            $informations = Information::get();
            $informationShow = array();
            foreach($typeInformations as $id => $typeInformation) {
                $typeInformations[$id]['information'] = '';
                foreach ($informations as $information) {
                    if ($information->slug_type_input == $typeInformation->slug) {
                        $informationShow[$typeInformation->slug] = $information->content;
                        break;
                    }
                }
            }


        } catch (\Exception $e) {
            $countReport = 0;
            $notifications = array();
            $typeSubPostsAdmin = array();

            Log::error('Lấy dạng bài viết và thông báo: '.$e->getMessage());

        } finally {

            view()->share([
                'menuTop' => 'websites',
                'information' => $informationShow,
                'countRp'=>$countReport,
                'notifications'=>$notifications,
                'typeSubPostsAdmin' => $typeSubPostsAdmin,
            ]);
        }

        
    }


    protected function createSlug($request) {
        try {
            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }
        } catch (\Exception $exception) {
            $slug = rand(10,10000000);

        } finally {
            return $slug;
        }
    }

    public function home() {
        if (!Auth::check() or Auth::user()->role != 4) {
//            Auth::logout();
            return redirect('/admin');
        }
		if (session_status() === PHP_SESSION_NONE) {
		    session_start();
		}
        $user = Auth::user();
        if (User::isManager($user->role) || User::isEditor($user->role)) {
            $_SESSION['loginSuccessAdmin'] = $user->email;
            $_SESSION['role'] = $user->role;

            if($user->role == 4)
            {
                $upload = "library";
            }
            if($user->role == 1)
            {
                $upload = "library_employee/".$user->email."-".$user->id;
            }
            if($user->role == 2)
            {
                $upload = "library_employer/".$user->email."-".$user->id;
            }
            if($user->role == 3)
            {
                $upload = "library_teacher/".$user->email."-".$user->id;
            }
            $_SESSION['emailFolder'] = $upload;
        }
        $countPost = Post::where('post_type', 'post')->count();
        $countProduct = Post::where('post_type', 'product')->count();
        $countUser = User::count();
        $countOrder = Order::count();
        $orders = Order::
            select(
                DB::raw('SUM(total_price) as total_sum'),
                DB::raw('YEAR (created_at) as year'),
                DB::raw('QUARTER(created_at) as quarter')
            )
            ->groupBy (
                DB::raw('YEAR (created_at)'),
                DB::raw('QUARTER(created_at)')
                )
            ->get();

        $countJobfacebook = JobFacebook::count();
        $countJob = Job::count();
        $countvoucher = Voucher::count();
        $countexam = Exam::count();

        $countemployer = Employer::count();
        $countemployee = Employee::count();
        $countteacher = Teacher::count();
        $countcontact = Contact::count();

        return View('admin.home.index', compact(
            'countPost',
            'countProduct',
            'countUser',
            'orders',
            'countOrder',
            'countJobfacebook',
            'countJob',
            'countvoucher',
            'countexam',
            'countemployer',
            'countemployee',
            'countteacher',
            'countcontact'
        ));
    }

    public function dateline() {
        return View('admin.home.dateline');
    }
}
