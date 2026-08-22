<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 5/18/2018
 * Time: 2:33 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class MemberFacebook extends Model
{
    protected $table = 'members_facebook';

    protected $primaryKey = 'member_id';

    protected $fillable = [
        'member_id',
        'uid',
        'name',
        'email',
        'phone',
        'status',
        'created_at',
        'updated_at'
    ];
}