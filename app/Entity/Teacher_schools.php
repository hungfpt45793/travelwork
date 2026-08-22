<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Teacher_schools extends Model
{
    protected $table = 'teacher_schools';
    protected $primaryKey = 'teacher_sc_id';
    protected $fillable = [
        'teacher_sc_id',
        'teacher_sc_name',
        'teacher_sc_email',
        'teacher_sc_phone',
        'user_id',
        'created_at',
        'updated_at',
        'logo_teacher',
        'teacher_school',
    ];
    public static function getTeacher_id($id_user)
    {
        $teacher = new Teacher_schools();
        $teacher = $teacher->select('*')->where('user_id',$id_user)->first();
        return $teacher;
    }
    public static function showTeacher($room_id)
    {
        $teacher = new Teacher_schools();
        $teacher = $teacher->select('teacher_schools.*')
            ->leftJoin('room_school','room_school.teacher_sc_id','=','teacher_schools.teacher_sc_id')
            ->where('room_school.id_room',$room_id)->first();
        return $teacher;
    }

}
