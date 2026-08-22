<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class ExamLocalJob extends Model
{

    protected $table = 'exam_local_job';
    protected $primaryKey = 'exam_local_job_id';
    protected $fillable = [
        'exam_local_job_id',
        'exam_local_job',
        'created_at',
        'updated_at',
    ];
    public static function getAll()
    {
        $examJob = new ExamLocalJob();
        $examJob = $examJob->select('*')
                    ->orderBy('exam_local_job_id','asc')
                    ->get();
        return $examJob;

    }
    public function getId($exam_local_job_id)
    {
        $examJob = new ExamLocalJob();
        $examJob = $examJob->select('*')
            ->where('exam_local_job_id',$exam_local_job_id)
            ->first();
        return $examJob;
    }
}
