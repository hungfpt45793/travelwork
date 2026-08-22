<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class StarEmployer extends Model
{
    protected $table = 'star_employer';
    protected $primaryKey = 'star_employer_id';
    protected $fillable = [
        'star_employer_id',
        'id_user',
        'id_employer',
        'qty_stars',
        'content_star',
        'created_at',
        'updated_at',
    ];
    public static function checkStarEmployer($employer_id)
    {
        $employer_star = new StarEmployer();
        $employer_star = $employer_star->select('*')->where('id_employer',$employer_id)->get();
        return $employer_star;
    }
    public static function sumStarEmployer($employer_id)
    {
        $employer_star = new StarEmployer();
        $employer_star = $employer_star->select('id_employer','qty_stars')->where('id_employer',$employer_id)->sum('qty_stars');
        return $employer_star;
    }
    public static function countEmployer($employer_id)
    {
        $employer_star = new StarEmployer();
        $employer_star = $employer_star->select('*')->where('id_employer',$employer_id)->count();
        return $employer_star;
    }
//    public static function getStarExam($teacher_id)
//    {
//        $teacherStar = new TeacherStar();
//        $teacherStar = $teacherStar->select('*')->where('id_teacher',$teacher_id)->get();
//        return $teacherStar;
//    }
//    public static function countTeacher($teacher_id)
//    {
//        $teacherStar = new TeacherStar();
//        $teacherStar = $teacherStar->select('*')->where('id_teacher',$teacher_id)->count();
//        return $teacherStar;
//    }
    public static function checkUserStar($id_employer, $id_user)
    {
        $employer_star = new StarEmployer();
        $employer_star = $employer_star->select('*')->where('id_employer',$id_employer)->where('id_user',$id_user)->count();
        return $employer_star;
    }
    public static  function listStar($employer_id)
    {
        $list = StarEmployer::select('star_employer.*','users.id')
            ->join('users','users.id','=','star_employer.id_user')
            ->where('id_employer',$employer_id)
            ->get();
        return $list;
    }



}
