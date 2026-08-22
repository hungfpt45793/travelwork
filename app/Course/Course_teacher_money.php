<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Course_teacher_money extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;
    protected $table = 'course_teacher_money';
    protected $primaryKey = 'course_money_id';
    protected $fillable = [
        'course_money_id',
        'teacher_id',
        'total_money', //Tổng số tiền nhận được do nhận được do chia sẻ
        'total_change_crad', //tổng số tiền giao dịch qua thẻ cào
        'total_change_bank', //tổng số tiền giao dịch qua chuyển khoản
        'total_change_product', //tổng số tiền giao dịch qua đổi sản phẩm
        'money', //số dư tài khoản
        'coints_status', //0 là vẫn chia sẻ . 1 là dừng chia se
        'bank_status', //trạng thái 0 là vẫn chuyển khoản 1 là dừng chuyển khoản
        'created_at',
        'updated_at',
        'deleted_at'
    ];




}
