<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Course_teacher_active extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;
    protected $table = 'course_teacher_active';
    protected $primaryKey = 'course_teacher_id';
    protected $fillable = [
        'course_teacher_id',
        'teacher_id',
        'course_id',
        'activation_code',
        'status_active_code',
        'date_end_active',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
