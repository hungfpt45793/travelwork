<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/3/2017
 * Time: 2:46 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingOrder extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'setting_order';

    protected $primaryKey = 'setting_order_id';

    protected $fillable = [
        'setting_order_id',
        'point_to_currency',
        'currency_give_point',
        'created_at',
        'deleted_at',
        'updated_at'
    ];

}
