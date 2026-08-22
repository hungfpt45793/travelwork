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

class OrderShip extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'order_ship';

    protected $primaryKey = 'order_ship_id';

    protected $fillable = [
        'order_ship_id',
        'method_ship',
        'cost',
        'created_at',
        'deleted_at',
        'updated_at'
    ];
}
