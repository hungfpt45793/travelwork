<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_curriculum extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $table = 'employee_curriculum';
    protected $primaryKey = 'curri_id';
    protected $fillable = [
        'curri_id',
        'status_update',
        'employee_id',
        'user_id_handing',
        'created_at',
        'updated_at',
        'deleted_at',
        'anh4x6',
        'hoten',
        'gioitinh',
        'ns_ngay',
        'ns_thang',
        'ns_nam',
        'dk_tt',
        'cmtnd',
        'noicap',
        'cm_ngay',
        'cm_thang',
        'cm_nam', 'dt_home',
        'mobile', 'baotin',
        'sohieu', 'kyhieu', 'hoten_p2',
        'bidanh', 'tenthuonggoi', 'ns_ngay_p2',
        'ns_thang_p2', 'ns_nam_p2', 'tai_p2', 'nguyenquan',
        'dk_tt_p2', 'dantoc', 'tongiao', 'thanhphan_bt', 'vanhoa',
        'ngoaingu', 'chuyenmon', 'loaihinh_dt', 'chuyennganh_dt',
        'dang_ngay', 'dang_thang', 'dang_nam', 'dang_ketnap',
        'doan_ngay', 'doan_thang', 'doan_nam', 'doan_ketnap',
        'suckhoe', 'cao', 'can_nang', 'nghenghiep_chuyenmon',
        'capbac', 'luongchinh', 'ngaynhapngu', 'ngayxuatngu',
        'lydo_p2', 'htbo', 'tuoibo', 'nn_bo', 'bo_thang8',
        'bo_khangphap', 'bo_1955', 'htme', 'tuoime', 'nn_me',
        'me_thang8', 'me_khangphap', 'me_1955', 'giadinh', 'hotenvc',
        'tuoivc', 'nn_vc', 'noi_nn_vc', 'noio_vc', 'tencon1',
        'tuoicon1', 'nn_con1', 'tencon2', 'tuoicon2', 'nn_con2',
        'tencon3', 'tuoicon3', 'nn_con3', 'tencon4', 'tuoicon4',
        'nn_con4', 'tencon5', 'tuoicon5', 'nn_con5', 'ht_day',
        'ht_congtac', 'ht_odau', 'ht_chucvu', 'khenthuong',
        'kyluat', 'xacnhan', 'local', 'local_ngay', 'local_thang',
        'local_nam',
    ];

    public static function check_syll_employee($employee_id)
    {
        $check_syll_employee = Employee_curriculum::select('employee_id')->where('employee_id',$employee_id)->count();
        return $check_syll_employee;
    }
    public static function get_detail_syll($employee_id)
    {
        $employee_curriculum = Employee_curriculum::select('employee_curriculum.*','employee_curriculum_extend.*')
            ->leftJoin('employee_curriculum_extend','employee_curriculum_extend.employee_id','employee_curriculum.employee_id')
            ->where('employee_curriculum.employee_id',$employee_id)
            ->first();
        return $employee_curriculum;
    }


}
