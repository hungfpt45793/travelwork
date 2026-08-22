<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class InteractiveTeacher extends Model
{
    protected $table = 'interactive_history_teacher';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'teacher_id',
        'interactive_day',
        'user_id',
        'content',
        'created_at',
        'updated_at',
        'deleted_at',
        'teacher_status_id'
    ];
    public static  function get_user_id_content($teacher_id)
    {
        $interactive_history_teacher = new InteractiveTeacher();
        $user_id_content = $interactive_history_teacher::select('interactive_history_teacher.teacher_id','interactive_history_teacher.user_id','interactive_history_teacher.content','interactive_history_teacher.interactive_day','users.name','users.id')
            ->join('users','users.id','=','interactive_history_teacher.user_id')
            ->where('interactive_history_teacher.teacher_id',$teacher_id)
            ->orderBy('interactive_history_teacher.interactive_day','desc')
            ->first();
        return $user_id_content;
    }
   
}
