<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Educate_class extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    protected $table = 'educate_class';
    protected $primaryKey = 'edu_class_id';
    public $timestamps = false;
    protected $fillable = [
        'edu_class_id',
        'edu_class_name',
        'educate_class_image',
        'edu_class_slug',
        'edu_class_des',
        'edu_class_content',
        'edu_class_link_zalo',
        'edu_tea_id',
        'edu_class_video',
        'edu_class_views',
        'edu_class_id',
        'edu_cate_id',
        'teacher_name',
        'teacher_link',
        'user_id',
        'edu_date_end',
        'edu_total_employee',
        'edu_class_regulations',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public static function get_all_slug($slug,$count)
    {
        $edu_categories = new Educate_categories();
        $edu_categories = $edu_categories->select('edu_cate_id','edu_cate_slug')
            ->where('edu_cate_slug',$slug)
            ->first();
        $day_date = date('Y/m/d');
        $list_edu_class = new Educate_class();
        $list_edu_class = $list_edu_class->select('*')
            ->where('edu_cate_id',$edu_categories->edu_cate_id)
            ->whereDate('edu_date_end', '>=', date('Y-m-d'))
            ->limit($count)
            ->get();
        return $list_edu_class;

    }
}
