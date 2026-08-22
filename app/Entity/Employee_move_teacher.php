<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_move_teacher extends Model
{
    public $timestamps = false;

    protected $table = 'employee_move_teacher';
    protected $primaryKey = 'move_id';
    protected $fillable = [
        'move_id',
        'employee_id',
        'teacher_id',
        'user_move',
        'move_content',
        'created_at',
        'updated_at',
    ];
    public static function  check_teacher($teacher_id)
    {
        $employee_move = Employee_move_teacher::select('employee_move_teacher.*','users.name')
            ->join('users','users.id','employee_move_teacher.user_move')
            ->where('teacher_id',$teacher_id)->first();
        return $employee_move;
    } public static function  check_exit_teacher($teacher_id)
    {
        $employee_move = Employee_move_teacher::select('employee_move_teacher.*','users.name')
            ->join('users','users.id','employee_move_teacher.user_move')
            ->where('teacher_id',$teacher_id)->count();
        return $employee_move;
    }
}
