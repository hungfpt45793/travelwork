<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class List_teacher_agency extends Model
{
    protected $table = 'list_teacher_agency';
    protected $primaryKey = 'agen_id';
    protected $fillable = [
        'agen_id',
        'teacher_id',
        'teacher_email',
        'teacher_name',
        'teacher_slug',
        'local_area',
        'province',
        'district',
        'teacher_ex',
        'teacher_min',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public static function getAll($local_area)
    {
        $list_teacher_agen_model = new List_teacher_agency();
        $list_teacher_agen = $list_teacher_agen_model->select('list_teacher_agency.teacher_name','list_teacher_agency.teacher_slug','list_teacher_agency.teacher_id','list_teacher_agency.province','list_teacher_agency.district','list_teacher_agency.teacher_min','province.local_area','province.province_id','province.province_name','list_teacher_agency.deleted_at')
            ->join('province','province.province_id','list_teacher_agency.province')
            ->where('province.local_area',$local_area)
            ->whereNull('list_teacher_agency.deleted_at')
            ->limit(10)
            ->get();
        return $list_teacher_agen;
    }
}
