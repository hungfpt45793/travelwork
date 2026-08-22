<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class TeacherStar extends Model
{
    protected $table = 'star_teacher';
    protected $primaryKey = 'id_star';
    protected $fillable = [
        'id_star',
        'id_user',
        'id_teacher',
        'qty_stars',
        'content_star',
        'content_answer_admin',
        'created_at',
        'updated_at',
    ];
    public static function checkStarTeacher($teacher_id)
    {
        $teacherStar = new TeacherStar();
        $teacherStar = $teacherStar->select('*')->where('id_teacher',$teacher_id)->get();
        return $teacherStar;
    }
    public static function getStarExam($teacher_id)
    {
        $teacherStar = new TeacherStar();
        $teacherStar = $teacherStar->select('*')->where('id_teacher',$teacher_id)->get();
        return $teacherStar;
    }
    public static function countTeacher($teacher_id)
    {
        $teacherStar = new TeacherStar();
        $teacherStar = $teacherStar->select('*')->where('id_teacher',$teacher_id)->count();
        return $teacherStar;
    }
    public static function checkUserStar($teacher_id, $user_id)
    {
        $teacherStar = new TeacherStar();
        $teacherStar = $teacherStar->select('*')->where('id_teacher',$teacher_id)->where('id_user',$user_id)->count();
        return $teacherStar;
    }
}
