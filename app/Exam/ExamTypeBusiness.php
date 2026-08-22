<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class ExamTypeBusiness extends Model
{
    protected $table = 'exam_type_business';
    protected $primaryKey = 'exam_type_id';
    protected $fillable = [
        'exam_type_id',
        'exam_type_name',
        'created_at',
        'updated_at',
    ];
    public static function getAll()
    {
        $examType = new ExamTypeBusiness();
        $examType = $examType->select('*')
            ->orderBy('exam_type_id','asc')
            ->get();
        return $examType;

    }
    public function getId($exam_type_id)
    {
        $examType = new ExamTypeBusiness();
        $examType = $examType->select('*')
            ->where('exam_type_id',$exam_type_id)
            ->first();
        return $examType;
    }
}
