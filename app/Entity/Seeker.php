<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{
    protected $table = 'seeker';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'item_id',
        'user_id',
        'full_name',
        'lastname',
        'firstname',
        'picture',
        'birthday',
        'marital',
        'gender',
        'phone',
        'area',
        'country',
        'province',
        'district',
        'ward',
        'address',
        'website',
        'request_title',
        'request_nature',
        'request_province',
        'friendly_link',
        'show_order',
        'is_authentic',
        'is_show',
        'date_create',
        'date_update',
        'lang'
    ];
    //lấy tất cả danh sách Loại hình donah nghiệp 
    public static function getAll() {
  
    return  static::get();
    }
}
