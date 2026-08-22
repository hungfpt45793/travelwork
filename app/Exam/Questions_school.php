<?php

namespace App\Exam;


use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Question\Question;

class Questions_school extends Model
{

    protected $table = 'questions_school';
    protected $primaryKey = 'id_ques';
    protected $fillable = [
        'id_ques',
        'name_ques',
        'teacher_sc_id',
        'type_ques',
        'status_ques',
        'show_answer_ques',
        'type_answer',
        'answer1',
        'answer2',
        'answer3',
        'answer4',
        'correct_answer',
        'questions_school',
        'sub_id',
        'created_at',
        'updated_at',
    ];

    public static function countQuestionSchool($type_ques, $teacher_sc_id)
    {
        $question = Questions_school::select('*')
            ->where('type_ques', $type_ques)
            ->where('teacher_sc_id', $teacher_sc_id)
            ->orderBy('id_ques', 'asc');
        $total = $question->count();
        return $total;
    }

    public static function countQuestion($id_exam)
    {
        $question = new Questions_school();
        $question = $question->leftJoin('exam_school_question_school', 'exam_school_question_school.id_ques', '=', 'questions_school.id_ques')
            ->where('exam_school_question_school.id_exam', '=', $id_exam)
            ->count();

        return $question;
    }

    public static function getALLQuestion($id_exam)
    {
        $question = new Questions();
        $question = $question->where('id_exam', '=', $id_exam)
            ->get();
        return $question;
    }

//    lay ra cau hoi theo ma cai hoi
    public static function getQuestion($id_ques, $type)
    {
        $question = new Questions_school();
        $question = $question->where('id_ques', '=', $id_ques)
            ->where('type_ques', '=', $type)
            ->first();
        return $question;
    }

    public static function getIdQuestion($id_ques, $type)
    {
        $question = new Questions_school();
        $question = $question->where('id_ques', '=', $id_ques)
            ->where('type_ques', '<', $type)
            ->first();
        return $question;
    }


    // tong so cau hoi cua de thi
    public static function countTypeQuestion($id_exam, $type)
    {
        $question = new Questions_school();
        $question = $question->where('id_exam', '=', $id_exam)
            ->where('type_ques', '=', $type)
            ->count();
        return $question;
    }
}
