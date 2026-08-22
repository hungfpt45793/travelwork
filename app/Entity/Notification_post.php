<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Notification_post extends Model
{
    protected $table = 'notification_post';
    protected $primaryKey = 'noti_id';
    protected $fillable = [
        'noti_id',
        'noti_title',
        'post_id',
        'slug',
        'id_podcast', // id cua podcast  //url https://www.buzzsprout.com/api/2176164/episodes.json   header : [{"key":"Authorization","value":"Token token=11cd74abc6e3806365aa3bd3a7d8eace","description":""}]
        'type', //post la bai viet  ,exam la de thi ,podcast laf id am thanh
        'created_at',
        'updated_at',
    ];
}
