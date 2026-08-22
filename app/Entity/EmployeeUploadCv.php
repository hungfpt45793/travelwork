<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EmployeeUploadCv extends Model
{
    protected $table = 'employee_upload_cv';
    protected $primaryKey = 'employee_active_cv_id';
    protected $fillable = [
        'employee_active_cv_id',
        'employee_id',
        'employee_link_cv',
        'user_id',
        'employee_cv_status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function storeData($employee_id, $employee_link_cv, $user_id = 0, $employee_cv_status = 0)
    {
        $employeeUploadCv = EmployeeUploadCv::where('employee_id', $employee_id)
        ->first();
        if(empty($employeeUploadCv))
        {
            EmployeeUploadCv::insert([
                'employee_id' => $employee_id,
                'employee_link_cv' => $employee_link_cv,
                'user_id' => $user_id,
                'employee_cv_status' => $employee_cv_status,
                'created_at' => new \Datetime()
            ]);
        }
        else{
            $employeeUploadCv->update([
                'employee_id' => $employee_id,
                'employee_link_cv' => $employee_link_cv,
                'user_id' => $user_id,
                'employee_cv_status' => $employee_cv_status,
                'updated' => new \Datetime()
            ]);
        }
       
    }

}
