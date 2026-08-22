<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Location_Province extends Model
{
    protected $table = 'location_province';
    protected $primaryKey = 'id';
    protected $fillable = [
       	'id',
		'code',
		'area_code',
		'country_code',
		'title',
		'show_order',
		'is_show',
		'date_create',
		'date_update',
		'lang'
    ];
    //lấy tất cả danh sách Loại hình donah nghiệp 
    public static function getAll() {
  
    return  static::get();
    }
}
