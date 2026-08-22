<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Course_questions extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'course_questions';
    protected $primaryKey = 'course_comments_id';
    protected $fillable = [
        'course_comments_id',
        'course_comments_content',
        'user_id',
        'course_id',
        'course_comments_status',
        'parent_course_comments_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    static function getMyQuestion($course_id,$parent_id=0){
        $user_id = Auth::id();
        return  Course_questions::where('user_id',$user_id)
            ->where('parent_course_comments_id',$parent_id)
            ->where('course_id',$course_id)
            ->select('course_comments_id',
                'course_comments_content',
                'course_questions.user_id',
                'course_id',
                'course_comments_status', //0 là ẩn , 1 là hiện
                'parent_course_comments_id', //kết quả trả lời của  course_comments_id
                'course_questions.created_at',
                'name',
                'image',
                'role'
            )
            ->join('users','users.id','course_questions.user_id')
            ->get();
    }
    static function getCourseComments($course_id,$parent_id=0,$except_user_id=-1){
        return Course_questions::where('parent_course_comments_id',$parent_id)
            ->where('user_id','!=',$except_user_id)
            ->where('course_id',$course_id)
            ->select('course_comments_id',
                'course_comments_content',
                'course_questions.user_id',
                'course_id',
                'course_comments_status', //0 là ẩn , 1 là hiện
                'parent_course_comments_id', //kết quả trả lời của  course_comments_id
                'course_questions.created_at',
                'name',
                'image',
                'role'
            )
            ->join('users','users.id','course_questions.user_id')
            ->get();
    }

}
