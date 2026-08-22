<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class TeacherLearnEmployees extends Model
{
    protected $table = 'teacher_learn_employees';
    protected $primaryKey = 'id_teacher_learn';
    protected $fillable = [
        'id_teacher_learn',
        'teacher_id',
        'employee_id',
        'status_learn',
        'status_teacher',
        'created_at',
        'updated_at',
    ];
}
