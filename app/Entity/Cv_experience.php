<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Cv_experience extends Model
{

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;

    protected $table = 'cv_experience';
    protected $primaryKey = 'cv_ex_id';
    protected $fillable = [
        'cv_ex_id',
        'cv_id',
        'cv_ex_title',
        'cv_ex_name',
        'cv_ex_desc',
        'created_at',
        'updated_at',
        'deleted_at',
        'template_id',
    ];
    public static function get_cv_id($cv_id)
    {
        $list = Cv_experience::select('*')->where('cv_id',$cv_id)->get();
        return $list;
    }
    public static function get_total($cv_id)
    {
        $list = Cv_experience::select('*')->where('cv_id',$cv_id)->count();
        return $list;
    }
    public static function get_template_id($template_id)
    {
        $list = Cv_experience::select('*')->where('template_id',$template_id)->get();
        return $list;
    }
    public static function get_template_total($template_id)
    {
        $list = Cv_experience::select('*')->where('template_id',$template_id)->count();
        return $list;
    }

}
