<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/3/2017
 * Time: 2:45 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderBank extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'order_bank';

    protected $primaryKey = 'order_bank_id';

    protected $fillable = [
        'order_bank_id',
        'name_bank',
        'manager_account',
        'branch',
        'number_bank',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
