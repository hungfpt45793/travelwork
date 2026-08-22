<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/3/2017
 * Time: 2:50 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'order_items';

    protected $primaryKey = 'item_id';

    protected $fillable = [
        'item_id',
        'product_id',
        'order_id',
        'description',
        'currency',
        'quantity',
        'properties',
        'created_at',
        'deleted_at',
        'updated_at'
    ];
}
