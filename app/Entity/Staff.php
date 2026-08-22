<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Staff extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'staff';
    protected $primaryKey = 'staff_id';
    protected $fillable = [
        'staff_name',
        'staff_email',
        'staff_phone',
        'staff_image',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
