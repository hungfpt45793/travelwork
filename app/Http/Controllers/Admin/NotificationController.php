<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/30/2017
 * Time: 2:33 PM
 */

namespace App\Http\Controllers\Admin;


use App\Entity\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends AdminController
{
    public function allReport(){
        try {
            $reports = Notification::orderBy('notify_id', 'desc')
                ->get();
            $notification = new Notification();
            $notification->where('status',0)
                ->update([
                'status' => 1
            ]);
        } catch (\Exception $e) {
             Log::error('http->admin->ReportController->allReport: hiển thị tất cả thông báo.');
        } finally {
            return view('admin.report.index', compact('reports'));
        }
    }

    public function seenNotification() {
        try {
            $notification = new Notification();
            $notification->where('status',0)->update([
                'status' => 1
            ]);
        } catch (\Exception $e) {
            Log::error('http->admin->ReportController->seenNotification: đã xem thông báo');

        } finally {
            return response([
                'status' => 200,
            ])->header('Content-Type', 'text/plain');
        }

    }
    public function readNotification(Request $request){
        try {
            // lấy ra id truyền lên
            $id = $request->input('id');
            // đổi trạng thái id tương ứng là đã đọc
            $notifications = new Notification();
            $notifications->where('notify_id', $id)
                ->update(['status' => 2]);
        } catch (\Exception $e) {
            Log::error('http->admin->ReportController->readNotification: đã đọc thông báo');
        } finally {
            // tra ve ket qua
            return response([
                'status' => 200,
            ])->header('Content-Type', 'text/plain');
        }
    }

    public function pushNotification(){
        try{
            $pushNotifies = Notification::where('status', 0)->get();
            if (!empty($pushNotifies)){
                $message = '';
                foreach ($pushNotifies as $notify) {
                    $message .= $notify->title. ': '.$notify->content;
                }

                return response([
                    'status' => 200,
                    'message' => $message,
                    'url' => route('report')
                ])->header('Content-Type', 'text/plain');
            }

            return response([
                'status' => 500,
                'message' => ''
            ])->header('Content-Type', 'text/plain');
        } catch (\Exception $e){
            Log::error('http->admin->ReportController->pushNotification: Thông báo đẩy');

            return response([
                'status' => 500,
            ])->header('Content-Type', 'text/plain');
        }
    }
}