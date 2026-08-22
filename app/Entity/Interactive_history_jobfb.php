<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interactive_history_jobfb extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    protected $table = 'interactive_history_jobfb';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'jobfb_id',
        'interactive_day',
        'user_id',
        'content',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
