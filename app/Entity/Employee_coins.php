<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_coins extends Model
{
    protected $table = 'employee_coins';
    protected $primaryKey = 'coins_id';
    protected $fillable = [
        'coins_id',
        'employee_id',
        'total_sale', //tổng số lần chia sẻ bài viết
        'total_view', //	tổng số lần xem bài viết
        'total_money', //Tổng số tiền nhận được do nhận được do chia sẻ và số tiền thanh toán khóa học và tiền xem tài liệu
        'total_sale_course', //Tổng số lần chia sẻ khóa học
        'total_view_course', //Tổng số lần xem khóa học
        'total_sale_voucher', //Tống số lần chia sẻ tài liệu
        'total_view_voucher', //Tống số lần xem tài liệu
        'total_sale_job', //Tống số lần chia sẻ tin tuyển dụng
        'total_view_job', //Tống số lần xem tin tuyển dụng
        'total_sale_employer', //Tống số lần chia sẻ tin thực tập
        'total_view_employer', //Tống số lần xem tin thực tập
        'total_change_crad', //	tổng số tiền giao dịch qua thẻ cào
        'total_change_bank', //	tổng số tiền giao dịch qua chuyển khoản
        'total_change_product', //	tổng số tiền giao dịch qua đổi sản phẩm
        'money', //số dư tài khoản
        'coints_status', //0 là vẫn chia sẻ . 1 là dừng chia sẻ
        'bank_status',
        'created_at',
        'updated_at'

    ];
    public static function get_coins($employee_id)
    {
        $employee_coins_model = new Employee_coins();
        $coins = $employee_coins_model->select('*')->where('employee_id',$employee_id)->count();
        return $coins;
    }

    public static function get_id($employee_id)
    {
        $employee_coins_model = new Employee_coins();
        $employee_coins = $employee_coins_model->select('*')->where('employee_id',$employee_id)->first();
        return $employee_coins;
    }
}
