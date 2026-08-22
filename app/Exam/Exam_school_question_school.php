<?php

namespace App\Exam;


use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Question\Question;

class Exam_school_question_school extends Model
{

    protected $table = 'exam_school_question_school';
    protected $primaryKey = 'exam_ques_id';
    protected $fillable = [
        'exam_ques_id',
        'id_exam',
        'code_exam',
        'id_ques',
        'teacher_sc_id',
        'created_at',
        'updated_at',
    ];
    public static function count_exam($id_exam)
    {
        $total = Exam_school_question_school::where('id_exam',$id_exam)
            ->join('questions_school','questions_school.id_ques','=','exam_school_question_school.id_ques')
            ->where('type_ques','<',3)
            ->count();
        return $total;
    }
    //$type_ques độ khó của câu hoi 0,1,2,3
    public static function count_exam_type($id_exam,$type_ques)
    {
        $total = Exam_school_question_school::where('exam_school_question_school.id_exam',$id_exam)
            ->join('questions_school','questions_school.id_ques','=','exam_school_question_school.id_ques')
            ->where('type_ques',$type_ques)
            ->count();
        return $total;
    }
//    public static function getALLQuestion($id_exam)
//    {
//        $question = new Questions();
//        $question = $question->where('id_exam', '=', $id_exam)
//            ->get();
//        return $question;
//    }
////    lay ra cau hoi theo ma cai hoi
//    public static function getQuestion($id_ques ,$type)
//    {
//        $question = new Questions();
//        $question = $question->where('id_ques', '=', $id_ques)
//            ->where('type_ques', '=', $type)
//            ->first();
//        return $question;
//    }
//
//    public static function countQuestion($id_exam)
//    {
//        $question = new Questions();
//        $question = $question->where('id_exam', '=', $id_exam)
//            ->count();
//        return $question;
//    }
//    // tong so cau hoi cua de thi
//    public static function countTypeQuestion($id_exam, $type)
//    {
//        $question = new Questions();
//        $question = $question->where('id_exam', '=', $id_exam)
//            ->where('type_ques', '=', $type)
//            ->count();
//        return $question;
//    }
}
