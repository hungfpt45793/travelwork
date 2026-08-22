<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum_notification extends Model
{

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'forum_notification';

    protected $primaryKey = 'noti_id';
    protected $fillable = [
        'noti_id',
        'noti_title',
        'for_post_id', //mã bài viết
        'for_comment_id',
        'user_id', //user id nhận thông báo
        'user_id_comment', //user người bình luận
        'noti_type', //kiểu thông báo comment=>là thông báo bình luận về bài viết , post_coin=>là thông báo về bài viết mất 1 xu ,comment_coin=>là thông báo về bình luận tặng xu,  user_pro=>tặng xu khi đăng ký tài khoản pro,
        'noti_status', //trạng thái thông báo 0 là chưa xem 1 đã xem
        'type_status', //minus là trừ xu , plus là cộng xu
        'created_at',
        'updated_at',
        'deleted_at'
    ];
//    public static function get_list_image($for_category_id)
//    {
//        $list_image = Forum_categorie_image::where('for_category_id',$for_category_id)
//            ->orderBy('for_img_id','desc')
//            ->get();
//        return $list_image;
//    }
    //thông báo chưa xem
    public static function get_user_noti($user_id, $noti_status)
    {
        $list_noti = Forum_notification::select(
            'forum_notification.noti_id',
            'forum_notification.noti_title',
            'forum_notification.for_post_id',
            'forum_notification.for_comment_id',
            'forum_notification.noti_type',
            'forum_notification.created_at',
            'users.name',
            'users.image'
        )->join('users', 'users.id', '=', 'forum_notification.user_id')
            ->where('forum_notification.user_id', $user_id)
            ->where('forum_notification.noti_status', $noti_status)
            ->limit(5)
            ->orderBy('forum_notification.noti_id', 'desc')
            ->get();
        return $list_noti;
    }

    //tất cả thông báo
    public static function get_user_all_noti($user_id)
    {

        $list_noti = Forum_notification::select(
            'forum_notification.noti_id',
            'forum_notification.noti_title',
            'forum_notification.for_post_id',
            'forum_notification.for_comment_id',
            'forum_notification.noti_type',
            'forum_notification.created_at',
            'users.name',
            'users.image'
        )->join('users', 'users.id', '=', 'forum_notification.user_id')
            ->where('forum_notification.user_id', $user_id)
//            ->where('forum_notification.noti_status', $noti_status)
            ->limit(5)
            ->orderBy('forum_notification.noti_id', 'desc')
            ->get();
        return $list_noti;

//        $list_noti = Forum_notification::select(
//            'forum_notification.noti_id',
//            'forum_notification.noti_title',
//            'forum_notification.for_post_id',
//            'forum_notification.for_comment_id',
//            'forum_notification.created_at',
//            'users.name',
//            'users.image'
//        )->join('users', 'users.id', '=', 'forum_notification.user_id_comment')
//            ->where('forum_notification.user_id', $user_id)
////            ->where('forum_notification.noti_status', $noti_status)
//            ->limit(10)
//            ->orderBy('forum_notification.noti_id', 'desc')
//            ->get();
        return $list_noti;
    }
}
