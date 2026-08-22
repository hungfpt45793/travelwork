<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_chapter_contents extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'course_chapter_contents';
    protected $primaryKey = 'course_content_id';
    protected $fillable = [
        'course_content_id',
        'course_id',
        'course_chapter_id',
        'course_content_title',
        'course_content_image',
        'course_content_descript',
        'course_content_content',
        'course_link_youtuber',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    static function getChapterContent($chapter_id)
    {
        $courseChapterContentModel = new Course_chapter_contents();
        return $courseChapterContentModel
            ->select('course_content_id',
                'course_id',
                'course_chapter_id',
                'course_content_title',
                'course_content_descript',
                'course_content_content',
                'course_link_youtuber'
            )
            ->where('course_chapter_id', $chapter_id)
            ->get();
    }
    static function get_try_content_question($course_id)
    {
        $courseChapterContentModel = new Course_chapter_contents();
        return $courseChapterContentModel
            ->select('course_chapter_contents.course_content_id',
                'course_chapter_contents.course_content_title'
            )
            ->join('course_chapters','course_chapters.course_chapter_id','=','course_chapter_contents.course_chapter_id')
            ->where('course_chapter_contents.course_id', $course_id)
            ->where('course_chapters.course_chapter_status',0)
            ->get();
    }

}
