<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Task_detail extends Model
{
    protected $table = 'task_detail';

    protected $primaryKey = 'task_detail_id';
    protected $casts = [
        'finish_day' => 'datetime',
        'giver_day' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'giver_id',
        'recipient_id',
        'giver_day',
        'note',
        'finish_day',
        'employee_id',
        'profile',
        'approved',
        'created_at',
        'updated_at'
    ];
}
