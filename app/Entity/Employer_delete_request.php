<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Employer_delete_request extends Model
{
    protected $table = 'employer_delete_request';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'employer_id',
        'staff_id',
        'created_at'
    ];
}