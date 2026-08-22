<?php

namespace App\Course;

use App\Support\Rating\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_sale_money extends Model
{

    protected $table = 'course_sale_money';
    protected $primaryKey = 'sale_id';
    protected $fillable = [
        'sale_id',
        'employee_id',
        'course_id',
        'ip_sale',
        'mac_sale',
        'date_sale',
        'created_at',
        'updated_at'
    ];
    public static function getMonthView($course_id,$employe_id,$day_date_static)
    {
        $post_sale_money_model = new Course_sale_money();
        $post_coun =$post_sale_money_model->select('*')
            ->where('course_id',$course_id)
            ->where('employee_id',$employe_id)
            ->whereMonth('date_sale',date_format($day_date_static, "m"))
            ->whereYear('date_sale', date_format($day_date_static, "Y"))
            ->count();
        return $post_coun;
    }
}
