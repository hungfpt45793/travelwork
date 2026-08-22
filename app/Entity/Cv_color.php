<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Cv_color extends Model
{
    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;

    protected $table = 'cv_color';
    protected $primaryKey = 'cv_color_id';
    protected $fillable = [
        'cv_color_id',
        'cv_id',
        'template_id',
        'cv_title',
        'code_color',
        'order_color',
        'created_at',
        'updated_at',

    ];

    public static function get_all($template_id)
    {
        $list = Cv_color::select('*')->where('template_id', $template_id)->get();
        return $list;
    }

    public static function get_cv_id($cv_id)
    {
        $list = Cv_color::select('*')->where('cv_id', $cv_id)->first();
        return $list;
    }

    public static function get_cv_color_id($cv_color_id)
    {
        $list = Cv_color::select('*')->where('cv_color_id', $cv_color_id)->first();
        return $list;
    }

    public static function get_total($cv_id)
    {
        $list = Cv_color::select('*')->where('cv_id', $cv_id)->count();
        return $list;
    }

    public static function get_template_id($template_id)
    {
        $list = Cv_color::select('*')->where('template_id', $template_id)->get();
        return $list;
    }

    public static function get_template_total($template_id)
    {
        $list = Cv_color::select('*')->where('template_id', $template_id)->count();
        return $list;
    }

}
