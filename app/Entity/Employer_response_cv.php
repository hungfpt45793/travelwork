<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Employer_response_cv extends Model
{
    protected $table = 'employer_response_cv';
    protected $primaryKey = 'employer_response_cv_id';
    protected $fillable = [
        'employer_response_cv_id',
        'employer_id',
        'employee_id',
        'response_diff',
        'created_at',
        'updated_at'
    ];

    public function abc()
    {
        return $this->belongsToMany('App\Entity\Employer_select_response', 'employer_select_response_cv', 'employer_select_response_id', 'employer_response_cv_id');
    }

    public static function get_reponse_cv($employee_id, $employer_id)
    {
        $list_reponse_cv = Employer_response_cv::where('employee_id', $employee_id)
            ->where('employer_id', $employer_id)
            ->get();
        return $list_reponse_cv;
    }
}
