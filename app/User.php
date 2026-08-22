<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'users';

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'password',
        'remember_token',
        'accesstoken',
        'phone',
        'image',
        'diendan_image',
        'diendan_code_intro',
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
        'status_phone_account',
        'link_confirm_account',
        'status_teacher_sc',
        'portal_app_token',
        'last_session_id',
        'user_coin',
        'step',
        'api_noti_date'  // api user đã xem thông báo
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public static function check_status_email_account($id)
    {
        $status_email_account = 0;
        $status_email_account = User::where('id',$id)->value('status_email_account');
        return $status_email_account;
    }
}
