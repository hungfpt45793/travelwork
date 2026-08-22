<?php

namespace App\Exam;


use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Question\Question;

class Questions extends Model
{

    protected $table = 'questions';
    protected $primaryKey = 'id_ques';
    protected $fillable = [
        'id_ques',
        'name_ques',
        'slug_ques',
        'type_ques', //kiểu câu hỏi 0-trắc nghiêm , 1 -đúng sai 2-tự luận
        'show_answer_ques', //	hiển thị đáp án 0 là chia đều 2 cột , 1 các đáp án trên 1 dòng , 2 mỗi đáp án trên 1 dòng	null là câu hỏi tự luận
        'id_exam',
        'id_topic',
        'type_answer', //	kiểu đáp án
        'answer1',
        'answer2',
        'answer3',
        'answer4',
        'correct_answer', //	đáp án đúng
        'explain_answer', //giải đáp án đúng
        'created_at',
        'updated_at',
    ];

    public static function getALLQuestion($id_exam)
    {
        $question = new Questions();
        $question = $question->where('id_exam', '=', $id_exam)
            ->get();
        return $question;
    }
//    lay ra cau hoi theo ma cai hoi
    public static function getQuestion($id_ques ,$type)
    {
        $question = new Questions();
        $question = $question->where('id_ques', '=', $id_ques)
            ->where('type_ques', '=', $type)
            ->first();
        return $question;
    }

    public static function countQuestion($id_exam)
    {
        $question = new Questions();
        $question = $question->where('id_exam', '=', $id_exam)
            ->count();
        return $question;
    }
    // tong so cau hoi cua de thi
    public static function countTypeQuestion($id_exam, $type)
    {
        $question = new Questions();
        $question = $question->where('id_exam', '=', $id_exam)
            ->where('type_ques', '=', $type)
            ->count();
        return $question;
    }
}
