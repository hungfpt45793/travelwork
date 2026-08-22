<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/7/2017
 * Time: 2:45 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubcribeEmail extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'subcribe_email';

    protected $primaryKey = 'subcribe_email_id';

    protected $fillable = [
        'subcribe_email_id',
        'email',
        'name',
        'group_id',
        'slug_gruop',
        'created_at',
        'deleted_at',
        'updated_at'
    ];
}
