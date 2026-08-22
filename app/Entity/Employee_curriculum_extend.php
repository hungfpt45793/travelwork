<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_curriculum_extend extends Model
{
    public $timestamps = false;

    protected $table = 'employee_curriculum_extend';
    protected $primaryKey = 'id_extend';
    protected $fillable = [
        'id_extend',
        'employee_id',
        'curri_id',
        'htbo',
        'tuoibo',
        'nn_bo',
        'bo_thang8',
        'bo_khangphap',
        'bo_1955',
        'htme',
        'tuoime',
        'nn_me',
        'me_thang8',
        'me_khangphap',
        'me_1955',
        'giadinh',
        'hotenvc',
        'tuoivc',
        'nn_vc',
        'noi_nn_vc',
        'noio_vc',
        'tencon1',
        'tuoicon1',
        'nn_con1',
        'tencon2',
        'tuoicon2',
        'nn_con2',
        'tencon3',
        'tuoicon3',
        'nn_con3',
        'tencon4',
        'tuoicon4',
        'nn_con4',
        'tencon5',
        'tuoicon5',
        'nn_con5',
        'ht_day',
        'ht_congtac',
        'ht_odau',
        'ht_chucvu',
        'khenthuong',
        'kyluat',
        'xacnhan',
        'local',
        'local_ngay',
        'local_thang',
        'local_nam',
    ];


}
