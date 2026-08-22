<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Detail_result_question_course extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'detail_result_question_course';
    protected $primaryKey = 'detal_result_id';
    protected $fillable = [
        'detal_result_id', 'result_id', 'id_ques', 'user_correct_ques', 'created_at', 'updated_at', 'deleted_at'
    ];

    public static function get_user_correct_ques($result_id, $id_ques)
    {
        $user_correct_ques = Detail_result_question_course::where('result_id', $result_id)
            ->where('id_ques', $id_ques)
            ->value('user_correct_ques');
        return $user_correct_ques;
    }
}
