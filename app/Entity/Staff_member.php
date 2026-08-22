<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Staff_member extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'staff_member';
    protected $primaryKey = 'staff_member_id';
    protected $fillable = [
        'staff_member_name',
        'staff_member_email',
        'staff_member_phone',
        'staff_member_image',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
