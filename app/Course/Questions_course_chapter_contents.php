<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Questions_course_chapter_contents extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;
    protected $table = 'questions_course_chapter_contents';
    protected $primaryKey = 'id_ques';
    protected $fillable = [
        'id_ques',
        'user_id',
        'course_id',
        'course_content_id',
        'course_chapter_id',
        'name_ques',
        'type_ques',
        'show_answer_ques',
        'type_answer',
        'answer1',
        'answer2',
        'answer3',
        'answer4',
        'correct_answer',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function get_total_question($course_content_id)
    {
        return $total = Questions_course_chapter_contents::where('course_content_id', $course_content_id)->count();
    }

    public static function get_list_question($course_content_id)
    {
        $list = Questions_course_chapter_contents::where('course_content_id', $course_content_id)->get();
        $check = Questions_course_chapter_contents::where('course_content_id', $course_content_id)->count();
        if(!empty($check))
        {
            return $list;
        }
        return 0;
    }



}
