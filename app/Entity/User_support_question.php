<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;


class User_support_question extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'user_support_question';
    protected $primaryKey = 'ques_id';
    protected $fillable = [
        'ques_id',
        'ques_title',
        'ques_content',
        'support_id', // danh sach cần hỗ trợ list_support
        'sup_id', //id người ra câu hỏi
        'ad_id', //id chuyên gia nhận tuwe vấn
        'ques_status',  //0 cần được tư vấn ,1 là đã được tư vấn, 2 là từ chối , 3 là hoàn thành
        'status_show',  //0 0 là hiện còn 1 là ẩn
        'user_status_show',  //0 user cap nhạt trang thai
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function get_support_title($sup_id)
    {

    }

}
