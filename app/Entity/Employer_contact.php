<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Employer_contact extends Model
{
    protected $table = 'employer_contact';
    protected $primaryKey = 'employer_contact_id';
    protected $fillable = [
        'employer_contact_id', 
        'employer_id', 
        'contact_name', 
        'contact_office', 
        'contact_phone', 
        'contact_email', 
        'contact_note', 
        'created_at', 
        'updated_at'
    ];
}
