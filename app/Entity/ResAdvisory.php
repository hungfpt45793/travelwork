<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 12/5/2017
 * Time: 2:07 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResAdvisory extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'res_advisory';

    protected $primaryKey = 'id_res';

    

    protected $fillable = [
        'id_res',
        'name_res',
        'email_res',
        'phone_res',
        'address_res',
        'message_res',
        'status_res',
        'status_view',
        'created_at',
        'updated_at'
    ];
}

