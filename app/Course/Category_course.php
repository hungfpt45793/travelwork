<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Category_course extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'category_course';
    protected $primaryKey = 'category_course_id';
    protected $fillable = [
        'category_course_id',
        'category_course_title',
        'category_course_slug',
        'category_course_desc',
        'category_course_content',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
