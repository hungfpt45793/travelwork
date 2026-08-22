<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Forum_minus_coin_user extends Model
{
    use SoftDeletes;
    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'forum_minus_coin_user';

    protected $primaryKey = 'minus_id';
    protected $fillable = [
        'minus_id',
        'user_id',
        'forum_post_coin',  //	tổng số xu đã tặng
        'forum_comment_coin', //tổng số xu đã tặng
        'forum_voucher_coin', //tổng số xu đã tặng
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //tiến hành trừ
    public static function set_minus($user_id,$type_coin)
    {
        //$type_coin là forum,comment,voucher
        $forum_post_coin = ($type_coin == 'forum') ? 1 : 0;
        $forum_comment_coin = ($type_coin == 'comment') ? 1 : 0;
        $forum_voucher_coin = ($type_coin == 'voucher') ? 1 : 0;
        $check_minus = Forum_minus_coin_user::where('user_id',$user_id)->first();

        if(!empty($check_minus))
        {
            $update_minus = Forum_minus_coin_user::where('user_id',$user_id)->update([
                'forum_post_coin' => $check_minus->forum_post_coin  + $forum_post_coin,
                'forum_comment_coin' => $check_minus->forum_comment_coin  + $forum_comment_coin,
                'forum_voucher_coin' => $check_minus->forum_voucher_coin  + $forum_voucher_coin,
                'updated_at' => new \DateTime()
            ]);
        }
        else
        {
            $insert = Forum_minus_coin_user::insert([
                'user_id' => $user_id,
                'forum_post_coin' => $forum_post_coin,
                'forum_comment_coin' => $forum_comment_coin,
                'forum_voucher_coin' => $forum_voucher_coin,
                'created_at' => new \DateTime()
            ]);
        }
        return true;
    }


}
