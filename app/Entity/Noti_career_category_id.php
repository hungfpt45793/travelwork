<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Noti_career_category_id extends Model
{
    protected $table = 'noti_career_category_id';
    protected $primaryKey = 'id_note_career';
    protected $fillable = [
        'id_note_career',
        'title_note',
        'job_id',
        'status',
        'employee_id',
        'created_at',
        'updated_at',
    ];
}
