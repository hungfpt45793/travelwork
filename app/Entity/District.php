<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district';
    protected $primaryKey = 'district_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
      'district_id',
      'district_name',
      'district_slug',
      'province_id',
        'updated_at'
    ];
    public static function get_district_ids($array_id) {
        return static::whereIn('district_id',$array_id)->get();
    }
     public static function showDistrict () {
        return static::orderBy('district_name','asc')->get();
    }
    public static function  getAllDistrict()
    {
        $district = new District();
        $district = $district->select('*')
            ->orderBy('district_name','asc')
            ->get();
        return $district;
    }
    public static function getId($district_id)
    {
        $district = new District();
        $district = $district->select('*')
            ->where('district_id',$district_id)
            ->first();
        return $district;
    }
    public static function get_province_id($province_id)
    {
        $district = new District();
        $district = $district->select('*')
            ->where('province_id',$province_id)
            ->get();
        return $district;
    }
    public static function get_ditrics($array_district)
    {
        $array_district = explode(',', $array_district);
        $list_district =  District::select('district_name')->whereIn('district_id',$array_district)->get();
        $district_name = '';
        foreach ($list_district as $dis)
        {
            $district_name .= $dis->district_name.',';
        }
        if(!empty($district_name)){
            return $district_name;
        }

    }
}
