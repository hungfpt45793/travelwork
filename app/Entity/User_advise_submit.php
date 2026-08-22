<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;


class User_advise_submit extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $casts = ['deleted_at' => 'datetime'];
    protected $table = 'user_advise_submit';
    protected $primaryKey = 'submit_id';
    protected $fillable = [
        'submit_id',
        'ad_id', //id của chuyên gia
        'sup_id', //id của người hỗ trợ
        'ques_id', //id câu hỏi hỗ trợ
        'sub_status', //0 chưa nhận ,1 là đã nhận , 2 là từ chối , 3 là hoàn thành
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
