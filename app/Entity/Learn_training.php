<?php

namespace App\Entity;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Learn_training extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'learn_training';
    protected $primaryKey = 'learn_id';

    protected $fillable = [
        'learn_id',
        'learn_title',
        'learn_slug',
        'learn_content',
        'courses_id',
        'learn_price',
        'learn_discount',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function check_learn_training()
    {

    }
    public static function min_learn_discount($courses_id)
    {
        $course_min_price = Learn_training::where('courses_id',$courses_id)
            ->orderBy('learn_discount','asc')
            ->first();
        return $course_min_price;
    }
    public static function get_total($courses_id)
    {
        $course_min_price = Learn_training::where('courses_id',$courses_id)
            ->count();
        return $course_min_price;
    }
}
