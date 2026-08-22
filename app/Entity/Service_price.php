<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Service_price extends Model
{
    protected $table = 'service_price';
    protected $primaryKey = 'service_price_id';
    protected $fillable = [
        'service_price_id',
        'service_price_type',
        'service_price_title',
        'service_price_icon',
        'service_price_slug',
        'image',
        'feature',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    public static function get_all()
    {
        $list_prices = Service_price::select(
            'service_price_id',
            'image',
            'service_price_title',
            'service_price_slug',
            'feature'
        )
            ->orderBy('service_price_type', 'asc')
            ->get();
        return $list_prices;
    }
    public static function get_list_prices()
    {
        $list_prices = Service_price::select(
            'service_price_id',
            'image',
            'service_price_title',
            'service_price_slug',
            'feature'
        )
            ->where('service_price_type', 0)
            ->get();
        return $list_prices;
    }
    public static function get_list_prices_dif()
    {
        $list_prices_dif = Service_price::select(
            'service_price_id',
            'image',
            'service_price_title',
            'service_price_slug',
            'feature'
        )
            ->where('service_price_type', 2)
            ->get();
        return $list_prices_dif;
    }
}
