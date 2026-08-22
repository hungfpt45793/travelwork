<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Employer_stk extends Model
{
    protected $table = 'employer_skt';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'item_id',
        'user_id',
        'level_id',
        'company',
        'picture',
        'size',
        'content',
        'phone',
        'area',
        'country',
        'province',
        'district',
        'ward',
        'address',
        'website',
        'arr_saved',
        'link_youtube',
        'file_attach',
        'hidden_image',
        'contact_full_name',
        'contact_phone',
        'contact_email',
        'show_order',
        'is_authentic',
        'is_show',
        'num_re',
        'lang',
        'date_create',
        'date_update'
    ];
    //lấy tất cả danh sách Loại hình donah nghiệp 
    public static function getAll() {
  
    return  static::get();
    }
}
