<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Employer_select_response extends Model
{
    protected $table = 'employer_select_response';
    protected $primaryKey = 'employer_select_response_id';
    protected $fillable = [
        'employer_select_response_id',
    	'response',
        'created_at',
        'updated_at'
    ];

    public function response()
    {
        return $this->belongsToMany('App\Entity\Employer_response_cv', 'employer_select_response_cv', 'employer_select_response_id', 'employer_response_cv_id');
    }



}
