<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Cv_info extends Model
{


    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $table = 'cv_info';
    protected $primaryKey = 'cv_info_id';
    protected $fillable = [
        'cv_info_id',
        'cv_id',
        'cv_info_title',
        'cv_info_name',
        'cv_info_des',
        'created_at',
        'updated_at',
        'deleted_at',
        'template_id',
    ];

    public static function get_cv_id($cv_id)
    {
        $list = Cv_info::select('*')->where('cv_id',$cv_id)->get();
        return $list;
    } public static function get_total($cv_id)
    {
        $list = Cv_info::select('*')->where('cv_id',$cv_id)->count();
        return $list;
    }
    public static function get_template_id($template_id)
    {
        $list = Cv_info::select('*')->where('template_id',$template_id)->get();
        return $list;
    } public static function get_template_total($template_id)
    {
        $list = Cv_info::select('*')->where('template_id',$template_id)->count();
        return $list;
    }
}
