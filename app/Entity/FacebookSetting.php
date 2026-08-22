<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 5/7/2018
 * Time: 5:02 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class FacebookSetting extends Model
{
    protected $table = 'facebook_setting';

    protected $primaryKey = 'facebook_id';

    protected $fillable = [
        'facebook_id',
        'accesstoken',
        'like_minimum',
        'comment_minimum',
        'groups',
        'face_ids',
        'updated_at'
    ];

}