<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Course_tag_id extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'course_tag_id';
    protected $primaryKey = 'course_tag_id';
    protected $fillable = [
        'course_tag_id',
        'tag_id',
        'course_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];



}
