<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EmployerRepresentative extends Model
{
    protected $table = 'employer_representative';
    protected $primaryKey = 'employer_representative_id';
    protected $fillable = [
      'employer_representative_id',
      'employer_id',
      'representative_name',
      'phone',
      'email',
      'address',
      'created_at',
      'updated_at'
    ];
}
