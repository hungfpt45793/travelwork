<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;


class Service_table_price extends Model
{
    protected $table = 'service_table_price';
    protected $primaryKey = 'service_table_price_id';
    protected $fillable = [
        'service_table_price_id',
        'service_price_id',
        'package_name',
        'package_price',
        'package_discount',
        'package_vat',
        'benifit',
        'endow',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    static function getTablePrices($service_table_price_id)
    {
        return $table_prices = Service_table_price::select(
            'service_table_price_id',
            'service_price_id',
            'package_name',
            'package_price',
            'package_discount',
            'package_vat',
            'benifit',
            'endow'
        )
        ->where('service_price_id', $service_table_price_id)
            ->orderBy('service_table_price_id', 'asc')
            ->get();
    }
    static function getTablePriceFirst($service_table_price_id)
    {
        return $table_prices = Service_table_price::select(
            'service_table_price_id',
            'service_price_id',
            'package_name',
            'package_price',
            'package_discount',
            'package_vat',
            'benifit',
            'endow'
        )
        ->where('service_price_id', $service_table_price_id)->orderBy('service_table_price_id', 'asc')->first();
    }
}
