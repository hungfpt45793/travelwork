<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Coefficients_salary extends Model
{
    protected $table = 'coefficients_salary';
    protected $primaryKey = 'coe_id';
    protected $fillable = [
        'coe_id',
        'ip',
        'user_id',
        'total_salary',
        'career_category_id', //danh mục ngành nghề
        'career_category_salary',
        'type_of_business_id', //loại hình doanh nghiệp
        'type_of_business_salary',
        'business_type_id', //	loại hình kinh doanh
        'business_type_salary',
        'literacy_id', //trình dodjd học vấn
        'literacy_salary',
        'office_id', //	tin học văn phòng
        'office_salary',
        'exp_id', //kinh nghiệm vị trí khác
        'exp_salary',
        'exp_bus_id', //	kinh nghiệm loại hình doanh nghiệp
        'exp_bus_salary',
        'software_id', //phần mềm kê toán
        'software_salary',
        'lang_id', //trình độ ngoại ngữ
        'lang_salary',
        'soft_id', //kỹ năng mềm
        'soft_salary',
        'cer_id', //chứng chỉ nghề nghiệp
        'cer_salary',
        'work_id', //khả năng chịu áp lực
        'work_salary',
        'province_id', //thành phố
        'province_salary',
        'com_id', //cam kết gắn bó với công ty
        'com_salary',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
