<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_status_voucher extends Model
{

    public $timestamps = false;
    protected $table = 'course_status_voucher';
    protected $primaryKey = 'course_status_voucher_id';
    protected $fillable = [
        'course_status_voucher_id',
        'course_content_voucher_id',
        'course_content_id',
        'course_chapter_id',
        'course_id',
        'employee_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
