<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $table = 'invite';
    protected $primaryKey = 'invite_id';
    protected $fillable = [
        'invite_id',
        'employer_id',
        'employee_id',
        'job_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function getInviteWihtEmployeeId( $employee_id= 134 ){

        $inviteModel = new Invite();
        $invite = $inviteModel
        ->leftJoin('employer','employer.employer_id','invite.employer_id')
        ->leftJoin('jobs','jobs.job_id','invite.job_id')
        ->leftJoin('salary','salary.salary_id','jobs.salary_id')
        ->select(
                'invite.employee_id',
                'invite.status',
                'employer.enterprise_name',
                'employer.image',
                'employer.address',
                'jobs.job_id',
                'jobs.slug',
                'jobs.title',
                'salary.description'                       
                )
        ->where('invite.employee_id' ,$employee_id)
        ->orderBy('invite.invite_id', 'desc')
        ->get();

        return $invite;
    }

}
