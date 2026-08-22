<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Interactive_history_employer extends Model
{
    protected $table = 'interactive_history_employer';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'employer_id',
        'interactive_day',
        'user_id',
        'content',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
   
}
