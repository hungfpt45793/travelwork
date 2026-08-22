<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Educate_categories extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    protected $table = 'educate_categories';
    protected $primaryKey = 'edu_cate_id';
    public $timestamps = false;
    protected $fillable = [
        'edu_cate_id',
        'edu_cate_title',
        'edu_cate_slug',
        'edu_cate_image',
        'edu_cate_des',
        'edu_cate_content',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public static function getID($edu_cate_id)
    {
        $edu_cate = Educate_categories::select('edu_cate_id','edu_cate_title')
            ->where('edu_cate_id',$edu_cate_id)
            ->first();
        return $edu_cate;
    }
    public static function getAll()
    {
        $edu_cate = Educate_categories::select('edu_cate_id','edu_cate_title')
           ->orderBy('edu_cate_id','desc')
            ->get();
        return $edu_cate;
    }
}
