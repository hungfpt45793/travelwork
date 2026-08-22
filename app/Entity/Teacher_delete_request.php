<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Teacher_delete_request extends Model
{
    protected $table = 'teacher_delete_request';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'teacher_id',
        'staff_id',
        'created_at'
    ];
}