<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 3/20/2018
 * Time: 8:46 AM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThemeUse extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'theme_use';

    protected $primaryKey = 'theme_use_id';

    protected $fillable = [
        'theme_use_id',
        'user_id',
        'created_at',
        'deleted_at',
        'updated_at'
    ];
}