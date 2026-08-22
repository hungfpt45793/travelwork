<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class User_new extends Model
{
    protected $table = 'user_new';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'username',
        'password',
        'user_type',
        'picture',
        'session',
        'date_login',
        'email',
        'first_name',
        'last_name',
        'nickname',
        'phone',
        'fax',
        'mobile',
        'area',
        'country',
        'province',
        'district',
        'ward',
        'address',
        'arr_address_book',
        'user_code',
        'folder_upload',
        'show_order',
        'is_focus',
        'is_show',
        'date_create',
        'date_update',
        'wcoin',
        'code_authentic',
        'pass_reset',
        'email_change',
        'fb_id',
        'gg_id',
    ];
    //lấy tất cả danh sách Loại hình donah nghiệp 
    public static function getAll() {
  
    return  static::get();
    }
}
