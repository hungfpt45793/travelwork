<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{

    protected $table = 'answers';
    protected $primaryKey = 'id_answer';
    protected $fillable = [
        'id_answer',
        'name_answer',
        'slug_name_answer',
        'id_ques',
        'type_answer',
        'statu_answer_1',
        'statu_answer_2',
        'statu_answer_3',
        //cau tra loi
        'correct_answer',
        'created_at',
        'updated_at',
    ];
    public static function getAnswers($id_ques)
    {
        $answers = new Answers();
        $answers->select('*')
            ->leftJoin('questions','questions.id_ques','=','answers.id_ques')
            ->where('answers.id_ques','=',$id_ques)
            ->get();
    }
}
