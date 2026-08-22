<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
    protected $table = 'workplace_address';
    protected $primaryKey = 'workplace_address_id';
    protected $fillable = [
      'workplace_address_id',
      'job_id',
      'address',
      'created_at',
      'updated_at'
    ];

    public static function showAddress($jobID){
        $count = Workplace::where('job_id', $jobID)->count();
        $listAddress = Workplace::where('job_id', $jobID)
            ->offset(1)
            ->limit($count)
            ->get();
        return $listAddress;
    }
}
