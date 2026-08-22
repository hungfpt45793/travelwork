<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class CommentExam extends Model
{

    protected $table = 'comment_exam';
    protected $primaryKey = 'id_comment';
    protected $fillable = [
        'id_comment',
        'name_comment',
        'id_exam',
        'id_user',
        'parent_comment',
        'created_at',
        'updated_at',
    ];

    public static function checkCommentExam($id_exam,$id_user)
    {
        $comment = new CommentExam();
        $check_comment = $comment->select('*')->where('id_exam',$id_exam)->where('id_user',$id_user)->count();
        return $check_comment;
    }
    public static function countCommentExam($id_exam)
    {
        $comment = new CommentExam();
        $check_comment = $comment->select('*')->where('id_exam',$id_exam)->count();
        return $check_comment;
    }
}
