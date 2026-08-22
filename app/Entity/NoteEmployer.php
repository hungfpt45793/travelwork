<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class NoteEmployer extends Model
{
    protected $table = 'note_employer';
    protected $primaryKey = 'note_employer_id';
    protected $fillable = [
      'note_employer_id',
      'employer_id',
      'note',
      'created_at',
      'updated_at'
    ];
}
