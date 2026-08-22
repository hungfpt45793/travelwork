<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;


class Employee_upload_cv extends Model
{
    public $timestamps = false;
    protected $table = 'employee_upload_cv';
    protected $primaryKey = 'employee_active_cv_id';
    protected $fillable = [
        'employee_active_cv_id',
        'employee_id',
        'employee_link_cv',
        'employee_link_html', //linh dung để mã hóa ten file html khac và ẩn email phone
        'user_id',
        'message',
        'employee_cv_status', //0 là không chọn, 1 là xuất hiện cv này
        'created_at',
        'updated_at'
    ];

    public static function employee_link_cv($employee_id)
    {
        $employee_link_cv = Employee_upload_cv::where('employee_id', $employee_id)
            ->value('employee_link_cv');
        return $employee_link_cv;
    }

    public static function get_employee_link_cv($employee_id)
    {
        $employee_link_cv = Employee_upload_cv::where('employee_id', $employee_id)
            ->first();
        return $employee_link_cv;
    }

    public static function check_employee_cv_status($employee_id)
    {
        $employee_cv_status = Employee_upload_cv::where('employee_id', $employee_id)
            ->value('employee_cv_status');
        return $employee_cv_status;
    }
}
