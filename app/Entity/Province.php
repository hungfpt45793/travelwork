<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'province';
    protected $primaryKey = 'province_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'province_id',
        'province_name',
        'province_slug',
        'postalcode',
        'province_salary',
        'sort_id',
        'updated_at',
        'local_area'
    ];

    public static function getAllProvince(){
        return static::orderBy('sort_id','asc')->orderBy('province_id','asc')->get();
    }
    public static function GetAllProvinces()
    {
        $province = new Province();
        $province = $province->select('*')
            ->orderBy('sort_id','asc')
//            ->orderBy('province_id','asc')
            ->get();
        return $province;
    }
    public static function getId($province_id)
    {
        $province = new Province();
        $province = $province->select('*')
            ->where('province_id','=',$province_id)
            ->first();
        return $province;
    }public static function getSlug($province_slug)
    {
        $province = new Province();
        $province = $province->select('province_id','province_slug')
            ->where('province_slug','=',$province_slug)
            ->first();
        return $province;
    }
}
