<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employer_handling extends Model
{
    protected $table = 'employer_handling';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id_handling',
        'employer_id',
        'status',
        'feedback',
        'created_at'
    ];
}
