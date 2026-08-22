<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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
        'user_advise_support', //0 là chưa chọn , 1 là gia sư, 2 là tư vấn'
        'reset_password',
        'level',
        'status_res_api', //check dang ký tren app 1 la dang ky tren app de ban noti
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

    public static function isManager($role) {
        if ($role == User::$manager || $role == User::$creater) {
            return true;
        }
        return false;
    }
    public static function isEditor($role) {
        if ($role == User::$employer) {
            return true;
        }

        return false;
    }
    public static function isMember($role) {
        if ($role == User::$candidate) {
            return true;
        }

        return false;
    }
    public static function isCreater($role) {
        if ($role == User::$creater) {
            return true;
        }
        return false;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    public static function getAllUser() {
        try {
            $users = static::select('id', 'email')->orderBy('id', 'desc')
                ->where('role', '>=', 3)->get();

            return $users;
        } catch (\Exception $exception) {
            Log::error('Entity->User->getAllUser: Lỗi lấy tất cả user');
            return null;
        }
    }

    public static function getUserComment() {
        try {
            $userModel = new User();

            $users = $userModel->select('id', 'email')
                ->orderBy('id', 'desc')
                ->where('role', '<=', 3)
                ->get();

            return $users;
        } catch (\Exception $exception) {
            Log::error('Entity->User->getAllUser: Lỗi lấy tất cả user');
            return null;
        }
    }
    public static function getIdUser($id)
    {
        $userModel = new User();
        $userModel = $userModel->select('*')
            ->where('id',$id)
            ->first();
        return $userModel;
    }
    public static function getUser($id_user)
    {
        $userModel = new User();
        $userModel = $userModel->select('*')->where('id',$id_user)->first();
        return $userModel;
    }
    public static function get_count($role)
    {
        $userModel = new User();
        $userModel = $userModel->select('role')->where('role',$role)->count();
        return $userModel;
    }
    public static function getIdNameUser($id)
    {
        $userModel = new User();
        $userModel = $userModel->select('id',
            'email',
            'phone',
            'name')
            ->where('id',$id)
            ->first();
        return $userModel;
    } public static function check_status_email_account($id)
    {
        $userModel = new User();
        $userModel = $userModel->select('id',
            'email',
            'phone',
            'name',
            'status_email_account')
            ->where('id',$id)
            ->where('status_email_account',1)
            ->count();
        return $userModel;
    }
}
