<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_chapters extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'course_chapters';
    protected $primaryKey = 'course_chapter_id';
    protected $fillable = [
        'course_chapter_id',
        'course_id',
        'course_chapter_name',
        'course_chapter_descript',
        'course_chapter_content',
        'course_chapter_status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    static function getCourseChapters($course_id = null)
    {
        $course_chapters = Course_chapters::where('course_id', $course_id)
            ->select( 'course_chapter_id',
                'course_chapter_name',
                'course_chapter_descript',
                'course_chapter_content',
                'course_chapter_status'
            )
            ->get();
        return $course_chapters;
    }
    public static function getCourse_try($course_id = null)
    {
        $course_chapters = Course_chapters::select( 'course_chapter_id',
            'course_chapter_name',
            'course_chapter_descript',
            'course_chapter_content',
            'course_chapter_status'
        )
            ->where('course_id', $course_id)
            ->where('course_chapter_status',0)
            ->get();
        return $course_chapters;
    }

}
