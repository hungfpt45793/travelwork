<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class Student_school extends Model
{

    protected $table = 'student_school';
    protected $primaryKey = 'student_id';
    protected $fillable = [
        'student_id',
        'student_code',
        'student_name',
        'id_room',
        'student_email',
        'student_phone',
        'student_pass',
        'created_at',
        'updated_at',
        'ip',
        'date_ip',
        'class_primakey',
        'class_section',
    ];
}
