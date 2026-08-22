<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Location_District extends Model
{
    protected $table = 'location_district';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'code',
        'area_code',
        'country_code',
        'province_code',
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
