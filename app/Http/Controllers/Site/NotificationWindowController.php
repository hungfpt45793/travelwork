<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\NotificationWindow;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationWindowController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        if (Auth::check()) {
            $this->middleware(function ($request, $next) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $this->id_user = Auth::user()->id;
                $ckeditor = new CkedittorController();
                $session_image = $ckeditor->checkImage();
                return $next($request);
            });
        }
    }

    public function index()
    {

        return view('site.notification.test');
    }

    public function noti_employes()
    {
        try {
            if (Auth::check()) {
                $status_email_account = Auth::user()->status_email_account;


            }
        } catch (\Exception $e) {
            return redirect('/');
        }

    }

    public function ajax_checkNoti(Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            $list_noti = NotificationWindow::select(
                'id_noti',
                'title_noti',
                'user_id',
                'des_noti',
                'link_noti',
                'status_noti',
                'view_noti')
                ->where('user_id', $user_id)
                ->where('view_noti', 0)
                ->orderBy('id_noti', 'desc')
                ->get();
            //khi hien thi thong thi set view = 1 luoon de khoong thong bao nua
            foreach ($list_noti as $noti) {
                $update = NotificationWindow::where('id_noti', $noti->id_noti)->update(
                    ['view_noti' => 1]);
            }
            if (!empty($list_noti)) {
                return response([
                    'status' => 200,
                    'list_noti' => $list_noti
                ])->header('Content-Type', 'text/plain');
            }
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
    }

    public function ajax_update_view_window(Request $request)
    {

//        $id_noti = $request->input('id_noti');
//        echo $id_noti;
//        $update = NotificationWindow::where('id_noti' , $id_noti)->first();
//        print_r($update);
//        return response([
//            'status' => 200,
//        ])->header('Content-Type', 'text/plain');

        try {
            $id_noti = $request->input('id_noti');
            $update = NotificationWindow::where('id_noti', $id_noti)->update([
                'view_noti' => 1,
            ]);
            return response([
                'status' => 200,
            ])->header('Content-Type', 'text/plain');
        } catch (\Exception $ex) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }


    }

    public function noti_employer()
    {
//        try
//        {
        if (Auth::check()) {
            $status_email_account = Auth::user()->status_email_account;

            $noti_window_model = new NotificationWindow();
            $noti_window = $noti_window_model->select('notification_window.*', 'users.id')->join('users',
                'users.id', '=', 'notification_window.user_id')
                ->where('notification_window.user_id', Auth::user()->id)
                ->orderBy('notification_window.status_noti', 'asc')
                ->orderBy('notification_window.id_noti', 'desc');

            $count_noti = $noti_window->count();
            $list_noti = $noti_window->get();
            if (!empty($status_email_account)) {
                $count_noti = $count_noti + 1;
            }
            $user_confirm = User::select('*')->where('id', Auth::user()->id)->first();
            return view('site.notification.noti_employer', compact('count_noti', 'list_noti', 'user_confirm'));
        }
//        }
//        catch (\Exception $e)
//        {
//            return redirect('/');
//        }

    }

//    xóa thông báo
    public function ajax_delete_noti(Request $request)
    {
        try {
            $id_noti = $request->input('id_noti');
            $delete = NotificationWindow::where('id_noti', $id_noti)->delete();
            return response([
                'status' => 200,
            ])->header('Content-Type', 'text/plain');
        } catch (\Exception $ex) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }


    }

    public function ajax_update_status(Request $request)
    {
        try {
            $id_noti = $request->input('id_noti');
            $delete = NotificationWindow::where('id_noti', $id_noti)->update([
                'status_noti' => 1,
            ]);
            return response([
                'status' => 200,
            ])->header('Content-Type', 'text/plain');
        } catch (\Exception $ex) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }


    }


//    co camera tu chup  ảnh

    //ứng viên
    public function noti_employee()
    {
//        try
//        {
        if (Auth::check()) {
            $status_email_account = Auth::user()->status_email_account;

            $noti_window_model = new NotificationWindow();
            $noti_window = $noti_window_model->select('notification_window.*', 'users.id')->join('users',
                'users.id', '=', 'notification_window.user_id')
                ->where('notification_window.user_id', Auth::user()->id)
                ->orderBy('notification_window.status_noti', 'asc')
                ->orderBy('notification_window.id_noti', 'desc');
            $count_noti = $noti_window->count();
            $list_noti = $noti_window->get();

            if (!empty($status_email_account)) {
                $count_noti = $count_noti + 1;
            }
            $user_confirm = User::select('*')->where('id', Auth::user()->id)->first();

            return view('site.notification.noti_employee', compact('count_noti', 'list_noti', 'user_confirm'));
        }
//        }
//        catch (\Exception $e)
//        {
//            return redirect('/');
//        }

    }

    //giáo viên
    public function noti_teacher()
    {
//        try
//        {
        if (Auth::check()) {
            $status_email_account = Auth::user()->status_email_account;

            $noti_window_model = new NotificationWindow();
            $noti_window = $noti_window_model->select('notification_window.*', 'users.id')->join('users',
                'users.id', '=', 'notification_window.user_id')
                ->where('notification_window.user_id', Auth::user()->id)
                ->orderBy('notification_window.status_noti', 'asc')
                ->orderBy('notification_window.id_noti', 'desc');

            $count_noti = $noti_window->count();
            $list_noti = $noti_window->get();
            if (!empty($status_email_account)) {
                $count_noti = $count_noti + 1;
            }
            $user_confirm = User::select('*')->where('id', Auth::user()->id)->first();
            return view('site.notification.noti_teacher', compact('count_noti', 'list_noti', 'user_confirm'));
        }
//        }
//        catch (\Exception $e)
//        {
//            return redirect('/');
//        }

    }


}