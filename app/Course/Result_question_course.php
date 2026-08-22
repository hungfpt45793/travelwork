<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Result_question_course extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;
    protected $table = 'result_question_course';
    protected $primaryKey = 'result_id';
    protected $fillable = [
        'result_id','user_id', 'course_content_id', 'total_ques', 'created_at', 'updated_at', 'deleted_at'
    ];

}
