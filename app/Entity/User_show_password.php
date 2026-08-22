<?php

namespace App\Entity;

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class User_show_password extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'users';

    protected $fillable = [
        'id',
        'email',
        'password',
        'remember_token',
        'accesstoken',
        'phone',
        'image',
        'role',
        'name',
        'gender',
        'age',
        'address',
        'point',
        'provider',
        'provider_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'reset_password',
        'level',
        'is_bank',
        'status_email_account',
        'link_confirm_account',
        'status_teacher_sc',
        'portal_app_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    // ứng viên
    protected static $candidate = 1;
    // nhà tuyển dụng
    protected static $employer = 2;
    // Quản lý
    protected static $manager = 3;
    // admin
    protected static $creater = 4;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
}
