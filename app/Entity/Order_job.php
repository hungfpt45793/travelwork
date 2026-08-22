<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_job extends Model
{

    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'order_job';
    protected $primaryKey = 'order_job_id';
    protected $fillable = [
        'order_job_id',
        'order_job_code',
        'order_request_id',
        'order_job_title',
        'order_job_des',
        'order_job_price',
        'order_job_discount',
        'order_job_statu_pay', //trang thai thanh toan
        'order_job_status_pay_all', //trang thai thanh toan
        'order_job_statu_content', // nọi dung thanh toán
        'order_job_guarantee',  //thoiwg gian bảo hành
        'order_job_guarantee_date', // ngay kích haotj bao hành
        'user_id',
        'employer_id',
        'job_id',
        'hunter_regis_id',
        'file_upload_contract',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function check_order_employer($employer_id)
    {
        $check_order_employer = Order_job::where('employer_id',$employer_id)->count();
        return $check_order_employer;
    }
}
