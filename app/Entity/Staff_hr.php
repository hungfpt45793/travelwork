<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Staff_hr extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'staff_hr';
    protected $primaryKey = 'staff_hr_id';
    protected $fillable = [
        'staff_hr_name',
        'staff_hr_email',
        'staff_hr_phone',
        'staff_hr_image',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
