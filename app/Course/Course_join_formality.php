<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_join_formality extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'course_join_formality';
    protected $primaryKey = 'course_join_formality_id';
    protected $fillable = [
        'course_join_formality_id',
        'course_id',
        'course_formality_id',
        'course_formality_price',
        'course_formality_discount',
        'course_formality_des',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
