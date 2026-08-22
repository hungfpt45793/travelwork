<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class NoteEmployee extends Model
{
    protected $table = 'note_employee';
    protected $primaryKey = 'note_employee_id';
    protected $fillable = [
      'note_employee_id',
      'employee_id',
      'note',
      'created_at',
      'updated_at'
    ];
}
