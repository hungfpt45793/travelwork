<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class NotificationWindow extends Model
{
    protected $table = 'notification_window';
    protected $primaryKey = 'id_noti';
    protected $fillable = [
        'id_noti',
        'title_noti',
        'user_id',
        'employee_id',
        'employer_id',
        'teacher_id',
        'des_noti',
        'content_noti',
        'link_noti',
        'status_noti',
        'view_noti',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public static function showNoti($user_id)
    {
        $list_noti = NotificationWindow::select(
            'id_noti',
            'title_noti',
            'user_id',
            'des_noti',
            'link_noti',
            'status_noti',
            'view_noti')
            ->where('user_id' , $user_id)
            ->where('view_noti',0)
            ->orderBy('id_noti','desc')
            ->get();
        return $list_noti;
    }
    public static function update_view_window($id_noti)
    {
        try{
            $update = NotificationWindow::where('id_noti',$id_noti)->update([
                'view_noti' => 1,
            ]);
            return true;
        }
        catch (\Exception $ex)
        {
            return false;
        }
    }
    public static function count_Noti($user_id)
    {
        $list_noti = NotificationWindow::where('user_id' , $user_id)
            ->where('status_noti',0)
            ->count();
        return $list_noti;
    }
}
