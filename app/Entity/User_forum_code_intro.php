<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class User_forum_code_intro extends Model
{
    use SoftDeletes;
    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'user_forum_code_intro'; //tính lượt xe cho bài viết

    protected $primaryKey = 'intro_id';
    protected $fillable = [
        'intro_id',
        'user_id', //id người đăng ký
        'user_id_intro', //id người giới thiệu
        'diendan_code_intro', //mã giới thiệu của id giới thiệu
        'diendan_code_status', //0 là tài khoản chưa xác thực , 1 là đã xác thực
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
