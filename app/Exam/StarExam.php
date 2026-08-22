<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class StarExam extends Model
{

    protected $table = 'star_exam';
    protected $primaryKey = 'id_star';
    protected $fillable = [
        'id_star',
        'id_user',
        'id_exam',
        'qty_stars',
        'content_star',
        'created_at',
        'updated_at',
    ];
    public static function checkStarExam($id_exam,$id_user)
    {
        $starExam = new StarExam();
        $check_star = $starExam->select('*')->where('id_exam',$id_exam)->where('id_user',$id_user)->count();
       return $check_star;
    }
    public static function getStarExam($id_exam)
    {
        $starExam = new StarExam();
        $starAll = $starExam->select('*')->where('id_exam',$id_exam)->get();
        return $starAll;
    }
    public static function countExam($id_exam)
    {
        $starExam = new StarExam();
        $countStar = $starExam->select('*')->where('id_exam',$id_exam)->count();
        return $countStar;
    }
}
