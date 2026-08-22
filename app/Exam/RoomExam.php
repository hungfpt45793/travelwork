<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class RoomExam extends Model
{
    protected $table = 'rooms_exam';
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
        'user_create_room',
        'id_exam',
        'type_exam',
        'created_at',
        'updated_at',
    ];
}
