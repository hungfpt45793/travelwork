<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Staff_follow extends Model
{
    protected $table = 'staff_follow';
    protected $fillable = [
        'id',
        'staff_id',
        'user_id',
        'type_user',
        'status_follow',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
