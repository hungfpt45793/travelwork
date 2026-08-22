<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'business_type';
    protected $primaryKey = 'business_type_id';
    protected $fillable = [
        'business_type_id',
        'business_type_name',
        'business_type_slug',
        'business_type_salary', //Trọng số lương
        'description',
        'total_costs',
        'recruit',
        'recruited',
        'created_at',
        'updated_at'
    ];

    public static function get_all_buiness()
    {
        $businessModel = new Business();
        $businessLists = $businessModel->select(
            'business_type_name', 'business_type_id'
        )
            ->get();
        return $businessLists;
    }
//    Loại hình kinh doanh
    //lấy tất cả danh sách Loại hình donah nghiệp
    public static function getAll()
    {
        $businessModel = new Business();
        $businessLists = $businessModel->select(
            'business_type.business_type_name as title', 'business_type_id'
        )
            ->get();
        return $businessLists;
    }

    public static function getALLSite()
    {
        $businessModel = new Business();
        $businessLists = $businessModel->select(
            '*'
        )
            ->orderBy('business_type_id')
            ->get();
        return $businessLists;
    }

    public static function getId($business_type_id)
    {
        $businessModel = new Business();
        $businessLists = $businessModel->select(
            'business_type.business_type_name as title', 'business_type_id'
        )
            ->where('business_type_id', $business_type_id)
            ->first();
        return $businessLists;
    }

}
