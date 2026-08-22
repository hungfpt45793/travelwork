<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Service_order extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    protected $table = 'service_order';
    protected $primaryKey = 'service_order_id';
    protected $fillable = [
        'service_order_id', //mã đơn hàng
        'service_price_id', // mã gói hàng
        'service_table_price_id',
        'user_id', //id người mua
        'employer_id', // id ntd mua nếu ó
        'created_date', // ngày mua
        'status', //trang thái
        'service_orde_price',
        'service_order_discount',
        'service_order_vat',
        'service_order_benifit',
        'service_order_endow',
        'ip_order', //ip dang nhap
        'service_order_code',
        'employer_name',
        'employer_phone',
        'employer_email',
        'tax_code',
        'service_order_content',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    static function getCountAlowServicePrice($service_price_id){
        return $count = Service_order::where('service_price_id', $service_price_id)->count();
    }
}
