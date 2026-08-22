<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Service_hunter extends Model
{
    protected $table = 'service_hunter';
    protected $primaryKey = 'service_hunter_id';
    protected $fillable = [
        'service_hunter_id',
        'service_hunter_name',
        'service_hunter_info',
        'service_hunter_image',
        'service_hunter_pay',
        'service_hunter_fee',
        'service_price_id',
        'service_hunter_contact',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    static function get_detail_hunter($service_price_id){
        return Service_hunter::select(
            'service_hunter_id',
            'service_hunter_name',
            'service_hunter_info',
            'service_hunter_image',
            'service_hunter_pay',
            'service_hunter_fee',
            'service_price_id',
            'service_hunter_contact'
        )
        ->where('service_price_id', $service_price_id)->first();
    }
}
