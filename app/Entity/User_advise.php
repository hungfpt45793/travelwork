<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;


class User_advise extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'user_advise';
    protected $primaryKey = 'ad_id';
    protected $fillable = [
        'ad_id',
        'user_id',
        'user_ad_status', //0 là không có ai duyệt
        'ad_status', //	0 là chưa duyêt, 1 là đã duyệt
        'combo_ad_id', //0laf chưa chọn gói tu vấn
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function get_list_advise($count)
    {
        $list_advise = User_advise::select('user_advise.*', 'users.name', 'users.image', 'users.role', 'users.id')
            ->join('users', 'users.id', 'user_advise.user_id')
            ->where('user_advise.ad_status', 1)
            ->orderBy('user_advise.ad_id', 'desc')
            ->skip(0)
            ->take($count)
            ->get();
        return $list_advise;
    }






}
