<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 5/21/2018
 * Time: 3:21 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class FacebookSaveUid extends Model
{
    protected $table = 'facebook_save_uid';

    protected $primaryKey = 'facebook_save_uid_id';

    protected $fillable = [
        'facebook_save_uid_id',
        'uid_list',
        'start',
        'created_at',
        'updated_at'
    ];
}