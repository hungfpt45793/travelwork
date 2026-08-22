<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Service_order_icon extends Model
{
    protected $table = 'service_order_icon';
    protected $primaryKey = 'service_order_icon_id';
    protected $fillable = [
        'service_order_icon_id',
        'service_price_id',
        'service_icon_id',
        'user_id',
        'employer_id',
        'created_date',
        'status',
        'service_order_icon_price',
        'service_order_icon_discount',
        'service_order_icon_vat',
        'service_order_icon_code',
        'employer_name',
        'employer_phone',
        'employer_email',
        'service_order_icon_content',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

}
