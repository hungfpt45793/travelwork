<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class TypeOfBusiness extends Model
{
    protected $table = 'type_of_business';
    protected $primaryKey = 'type_of_business_id';
    protected $fillable = [
        'type_of_business_id',
        'type_of_business_name',
        'type_of_business_slug',
        'type_of_business_salary',
        'description',
        'total_money',
        'recruit',
        'recruited',
        'created_at',
        'updated_at'
    ];

//        loại hình doanh nghiệp
    public static function showType()
    {
        return static::get();
    }

    public static function getAllTypeBusiness()
    {
        $type = New TypeOfBusiness();
        $type = $type->select('type_of_business_id', 'type_of_business_name', 'type_of_business_slug')->get();
        return $type;
    }

    public static function getIdTypeBusiness($type_of_business_id)
    {
        $type = New TypeOfBusiness();
        $type = $type->select('type_of_business_id', 'type_of_business_name', 'type_of_business_slug')->where('type_of_business_id', $type_of_business_id)->first();
        return $type;
    }

    // de thi trac nghiem
    public static function list_type_of_business_id_exam()
    {
        $literacy = new TypeOfBusiness();
        $list_literacy = $literacy->select('type_of_business.type_of_business_id', 'type_of_business.type_of_business_name', 'type_of_business.type_of_business_slug'
        )->join('exam', 'exam.exam_type_id', '=', 'type_of_business.type_of_business_id')
            ->distinct('type_of_business.type_of_business_id')
            ->orderBy('type_of_business.type_of_business_id', 'asc')
            ->get();
        return $list_literacy;
    }

}
