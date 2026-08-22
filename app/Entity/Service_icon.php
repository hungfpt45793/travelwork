<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Service_icon extends Model
{
    protected $table = 'service_icon';
    protected $primaryKey = 'service_icon_id';
    protected $fillable = [
        'service_icon_id',
        'service_icon_name',
        'service_icon_time',
        'service_icon_image',
        'service_icon_price',
        'service_icon_vat',
        'service_price_id',
        'service_icon_info',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    static function getIcon($service_price_id){
        return Service_icon::where('service_price_id', $service_price_id)->get();
    }
}
