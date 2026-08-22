<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Config_meta extends Model
{
    protected $table = 'config_meta';
    protected $primaryKey = 'id_meta';
    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'image',
        'updated_at',
    ];
    public static function getslug($slug)
    {
        $config = new Config_meta();
        $config = $config->select('*')->where('slug',$slug)->first();
        return $config;
    }
}
