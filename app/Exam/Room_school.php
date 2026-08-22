<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class Room_school extends Model
{
    protected $table = 'room_school';
    protected $primaryKey = 'id_room';
    protected $fillable = [
        'id_room',
        'code_room',
        'des_room',
        'name_room',
        'password_room',
        'day_room',
        'time_star_room',
        'time_end_room',
        'teacher_sc_id',
        'created_at',
        'updated_at',
        'exam_rules',
        'type_room',
        'sub_id',
    ];
}
