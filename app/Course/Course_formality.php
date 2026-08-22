<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_formality extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'course_formality';
    protected $primaryKey = 'course_formality_id';
    protected $fillable = [
        'course_formality_id',
        'course_formality_title',
        'course_formality_des',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function get_formality($course_id)
    {
        $list_formality = Course_formality::select('course_formality.course_formality_id',
            'course_formality.course_formality_title',
            'course_formality.course_formality_des',
            'course_formality.created_at')
            ->join('course_join_formality','course_join_formality.course_formality_id','=','course_formality.course_formality_id')
            ->where('course_join_formality.course_id',$course_id)
            ->get();
        return $list_formality;
    }

}
