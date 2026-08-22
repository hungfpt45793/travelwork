<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Hunter_price extends Model
{
    protected $table = 'hunter_price';
    protected $primaryKey = 'hunter_price_id';
    protected $fillable = [
        'hunter_price_id',
        'hunter_price_name',
        'hunter_price',
        'hunter_time_name',
        'hunter_pos_id',
        'hunter_time_id',
        'deleted_at',
        'created_at',
    ];
    static function get_hunter_price($hunter_price_id){
        return Hunter_price::leftJoin('hunter_pos','hunter_pos.hunter_pos_id','hunter_price.hunter_pos_id')
        ->leftJoin('hunter_time','hunter_time.hunter_time_id','hunter_price.hunter_time_id')
        ->where('hunter_price.hunter_price_id', $hunter_price_id)->first();
    }

    static function get_hunter_price_day($hunter_price_id){
        return Hunter_price::leftJoin('hunter_pos','hunter_pos.hunter_pos_id','hunter_price.hunter_pos_id')
            ->leftJoin('hunter_time','hunter_time.hunter_time_id','hunter_price.hunter_time_id')
            ->where('hunter_price.hunter_price_id', $hunter_price_id)
            ->first();
    }
}
