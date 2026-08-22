<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Course_tag extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'course_tag';
    protected $primaryKey = 'tag_id';
    protected $fillable = [
        'tag_id',
        'tag_title',
        'tag_slug',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    static function getTopTag($count=8){
        $courseTagIdModel = new Course_tag_id();
        $course_tags = $courseTagIdModel->select(
            'course_tag_id.tag_id', 'course_tag.tag_title', 'course_tag.tag_slug', DB::raw('count(*) as total'))
            ->join('course_tag', 'course_tag.tag_id', 'course_tag_id.tag_id')
            ->groupBy('course_tag_id.tag_id')
            ->orderBy('total', 'desc')
            ->limit($count)
            ->get();
        return $course_tags;
    }

}
