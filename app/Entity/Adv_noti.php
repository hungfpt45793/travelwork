<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Adv_noti extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    protected $table = 'adv_noti';
    protected $primaryKey = 'adv_id';
    public $timestamps = false;
    protected $fillable = [
        'adv_id',
        'adv_title',
        'adv_link',
        'adv_content',
        'adv_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public static function get_adv_noti()
    {
        $adv = new Adv_noti();
        $adv = $adv->orderBy('adv_id','desc')->limit(1)->first();
       return $adv;
    }
}
