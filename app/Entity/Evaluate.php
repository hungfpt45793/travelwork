<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{
    protected $table = 'evaluate';
    protected $primaryKey = 'evaluate_id';
    protected $fillable = [
        'evaluate_id',
        'employer_id',
        'employee_id',
        'start_number',
        'status',
        'approved',
        'review',
        'type',
        'date_evaluate',
        'created_at',
        'updated_at'
    ];
}
