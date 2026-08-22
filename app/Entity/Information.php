<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 9/24/2017
 * Time: 3:59 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'information';

    protected $primaryKey = 'infor_id';

    protected $fillable = [
        'infor_id',
        'slug_type_input',
        'content',
        'deleted_at',
        'updated_at'
    ];
}
