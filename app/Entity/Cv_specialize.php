<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Cv_specialize extends Model
{


    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $table = 'cv_specialize';
    protected $primaryKey = 'cv_spec_id';
    protected $fillable = [
        'cv_spec_id',
        'cv_id',
        'cv_spec_title',
        'cv_spec_name',
        'cv_spec_desc',
        'created_at',
        'updated_at',
        'deleted_at',
        'template_id',

    ];
    public static function get_cv_id($cv_id)
    {
       $list = Cv_specialize::select('*')->where('cv_id',$cv_id)->get();
       return $list;
    }
    public static function get_total_count($cv_id)
    {
        $list = Cv_specialize::select('*')->where('cv_id',$cv_id)->count();
        return $list;
    }
    public static function get_template_id($template_id)
    {
       $list = Cv_specialize::select('*')->where('template_id',$template_id)->get();
       return $list;
    }
    public static function get_template_count($template_id)
    {
        $list = Cv_specialize::select('*')->where('template_id',$template_id)->count();
        return $list;
    }
}
