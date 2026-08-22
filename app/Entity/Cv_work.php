<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Cv_work extends Model
{

    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $table = 'cv_work';
    protected $primaryKey = 'cv_work_id';
    protected $fillable = [
        'cv_work_id',
        'cv_id',
        'cv_work_title',
        'cv_work_name',
        'cv_work_desc',
        'cv_work_order_position',
        'created_at',
        'updated_at',
        'deleted_at',
        'template_id'
    ];
    public static function get_cv_id($cv_id)
    {
        $list = Cv_work::select('*')->where('cv_id',$cv_id)->get();
        return $list;
    } public static function get_total($cv_id)
    {
        $list = Cv_work::select('*')->where('cv_id',$cv_id)->count();
        return $list;
    }
    public static function get_template_id($template_id)
    {
        $list = Cv_work::select('*')->where('template_id',$template_id)->get();
        return $list;
    } public static function get_template_total($template_id)
    {
        $list = Cv_work::select('*')->where('template_id',$template_id)->count();
        return $list;
    }
}
