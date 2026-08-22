<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Interactive_history_employee extends Model
{
    protected $table = 'interactive_history_employee';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'employee_id',
        'coin',
        'interactive_day',
        'user_id',
        'content',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    public static function get_total_interactive_employee($employee_id, $user_id)
    {
        $total_employee = Interactive_history_employee::where('employee_id',$employee_id)->where('user_id', $user_id)
            ->count();
        return $total_employee;
    }
}
