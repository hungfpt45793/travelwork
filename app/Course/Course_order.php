<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_order extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;
    protected $table = 'course_order';
    protected $primaryKey = 'course_order_id';
    protected $fillable = [
        'course_order_id',
        'user_id',
        'course_id',
        'course_formality_id',//hinh thuc học
        'course_cost',  //giá của khóa học
        'course_order_status', //trạng thái thanh toán của khóa hoc: 0 là chưa, 1 đã thanh toán
        'admin_id',
        'employee_id', //ung vien chia se bai viet
        'admin_messager',
        'activation_code',  //mã kích hoạt
        'activation_code_status', //trạng thái mã kích hoạt 0 là chưa 1 là đã sử dụng
        'learn_id', //id cách học learn_training
        'learn_title',
        'learn_price',
        'learn_discount',
        'course_name',
        'course_phone',
        'course_email',
        'course_messager',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function get_total($course_id)
    {
        $total = Course_order::where('course_id',$course_id)->count();
        return $total;
    }

}
