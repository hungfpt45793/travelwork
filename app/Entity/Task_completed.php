<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Task_completed extends Model
{
    protected $table = 'task_completed';

    protected $primaryKey = 'task_completed_id';

    protected $fillable = [
        'task_detail_id',
        'removed',
        'content',
        'created_at',
        'updated_at'
    ];
}
