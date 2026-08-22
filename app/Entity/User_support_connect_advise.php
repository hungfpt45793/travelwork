<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;


class User_support_connect_advise extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $casts = ['deleted_at' => 'datetime'];
    protected $table = 'user_support_connect_advise';
    protected $primaryKey = 'connect_id';
    protected $fillable = [
        'connect_id',
        'ad_id',
        'user_id',
//        'sup_id',
        'status_connect',  //0 chưa nhận ,1 là đã nhận , 2 là từ chối , 3 là hoàn thành
        'support_id',  //id hỗ trợ
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function check_res_advise($ad_id,$user_id)
    {
        $check = User_support_connect_advise::where('ad_id', $ad_id)
//            ->where('sup_id', $user_spport->sup_id)
            ->where('user_id', $user_id)
            ->first();
        return $check;
    }


}
