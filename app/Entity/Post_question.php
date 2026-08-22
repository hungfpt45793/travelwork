<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Post_question extends Model
{
    protected $table = 'post_question';
    protected $primaryKey = 'post_ques_id';
    protected $fillable = [
        'post_ques_id',
        'post_id',
        'post_ques',
        'post_answer',
        'created_at',
        'updated_at',
    ];
    public static function get_total_question($post_id)
    {
        $count = Post_question::where('post_id',$post_id)->count();
        return $count;
    }
    public static function get_question($post_id)
    {
        $list_post_question = Post_question::select('*')->where('post_id',$post_id)->get();
        return $list_post_question;
    }
}
