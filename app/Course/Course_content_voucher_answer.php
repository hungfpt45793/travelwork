<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_content_voucher_answer extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'course_content_voucher_answer';
    protected $primaryKey = 'course_content_voucher_answer_id';
    protected $fillable = [
        'course_content_voucher_answer_id',
        'course_content_id',
        'content_voucher_title',
        'content_voucher_answer_link',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
