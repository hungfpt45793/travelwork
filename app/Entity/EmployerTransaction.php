<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EmployerTransaction extends Model
{
    protected $table = 'employer_transaction';
    protected $primaryKey = 'employer_transaction_id';
    protected $fillable = [
        'employer_transaction_id',
        'employer_id',
        'money',
        'reason',
        'employee_id',
        'job_id',
        'created_at'
    ];
}
