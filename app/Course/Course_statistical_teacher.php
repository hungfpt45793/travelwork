<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_statistical_teacher extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'course_statistical_teacher';
    protected $primaryKey = 'course_statis_id';
    protected $fillable = [
        'course_statis_id',
        'course_order_id',
        'course_price',
        'teacher_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function sale_money($course_order_id)
    {
        $course_price = Course_statistical_teacher::where('course_order_id',$course_order_id)
            ->value('course_price');
        return $course_price;
    }
}
