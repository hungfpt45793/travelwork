<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;


class Service_comment extends Model
{
    protected $table = 'service_comment';
    protected $primaryKey = 'service_comment_id';
    protected $fillable = [
        'service_comment_id',
        'service_comment_name',
        'service_comment_content',
        'service_comment_image',
        'service_table_price_id',
        'service_price_id',
        'feature',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    static function getComment($service_table_price_id)
    {
        return Service_comment::where('service_table_price_id', $service_table_price_id)->get();
    }

    public static function get_comments($table_price_id)
    {
        $comments = Service_comment::where('service_table_price_id', $table_price_id)->get();
        return $comments;
    }

    public static function get_table_price($table_price_id)
    {
        $table_prices = Service_table_price::where('service_table_price_id', $table_price_id)->select('benifit', 'endow')->first();
        return $table_prices;
    }
}
