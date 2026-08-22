<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EmployerAgency extends Model
{
    protected $table = 'employer_agency';
    protected $primaryKey = 'agency_id';
    protected $fillable = [
        'agency_id',
        'agency_name',
        'code_intro',
        'employer_id',
        'created_at',
        'updated_at',
    ];
    public static function get_code_intro($employer_id)
    {
        $employer_agency = new EmployerAgency();
        $employer_agency = $employer_agency->select('employer_id','code_intro')
            ->where('employer_id',$employer_id)
            ->first();
        return $employer_agency;
    }

}
