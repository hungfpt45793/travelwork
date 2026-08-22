<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Educate_teacher extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    protected $table = 'educate_teacher';
    protected $primaryKey = 'edu_tea_id';
    public $timestamps = false;
    protected $fillable = [
        'edu_tea_id',
        'edu_tea_name',
        'edu_tea_slug',
        'edu_tea_email',
        'edu_tea_phone',
        'edu_tea_image',
        'edu_tea_content',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public static function getID($edu_tea_id)
    {
        $edu_cate = Educate_teacher::select('edu_tea_id','edu_tea_name')
            ->where('edu_tea_id',$edu_tea_id)
            ->first();
        return $edu_cate;
    }
    public static function getAll()
    {
        $edu_cate = Educate_teacher::select('edu_tea_id','edu_tea_name')
            ->orderBy('edu_tea_id','desc')
            ->get();
        return $edu_cate;
    }
}
