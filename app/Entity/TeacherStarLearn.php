<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class TeacherStarLearn extends Model
{
    protected $table = 'teacher_star_learn';
    protected $primaryKey = 'id_teacher_star_learn';
    protected $fillable = [
        'id_teacher_star_learn',
        'id_teacher_learn',
        'status_star',
        'content_star',
        'date_month',
        'created_at',
        'updated_at',
    ];
}
