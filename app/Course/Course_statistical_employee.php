<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Course_statistical_employee extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;
    protected $table = 'course_statistical_employee';
    protected $primaryKey = 'course_statis_id';
    protected $fillable = [
        'course_statis_id',
        'employee_id',
        'course_order_id',
        'course_money_order',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function money_sale_order($course_order_id)
    {
        $sale_money = Course_statistical_employee::where('course_order_id',$course_order_id)
            ->value('course_money_order');
        return $sale_money;
    }
}
