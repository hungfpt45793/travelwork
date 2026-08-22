<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_content_voucher extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;
    protected $table = 'course_content_voucher';
    protected $primaryKey = 'course_content_voucher_id';
    protected $fillable = [
        'course_content_voucher_id',
        'course_content_id',
        'content_voucher_title',
        'content_voucher_link',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function get_total_voucher($course_content_id)
    {
        $total = Course_content_voucher::where('course_content_id',$course_content_id)->count();
        return $total;
    }

}
