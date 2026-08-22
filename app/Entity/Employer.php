<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employer extends Model
{

    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'employer';
    protected $primaryKey = 'employer_id';
    protected $fillable = [
        'employer_id',
        'employer_code',
        'enterprise_name',
        'phone',
        'email',
        'district',
        'province',
        'address',
        'introduction',
        'user_id',
        'image',
        'slug',
        'website',
        'tax_code',
        'company_size',
        'business',
        'type_of_business_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'status_post',
        'is_admin',
        'images_list',
        'status_intership',
        'des_intership',
        'content_intership',
        'banner_intership',
        'total_star',
        'view',
        'employer_vip',
        'status_agency',
        'service_agency', //Mô tả dịch vụ cung cấp của đại lý
        'status_allowance',
        'my_facebook',
        'my_zalo',
        'profile',
        'employer_coin', // Số dư xu
        'total_employer_coin', // Tổng số xu
        'total_money_coin', // Số tiền đã nạp
        'status',
        'status_select_employer', //0 là nhà tuyển dụng bt, 1 là nhà tuyển dụng đặc biệt , 2 là nhà tuyển dụng do nhân viên tao
        'user_id_create_select_employer', //0 là do nhà tuyển dụng tự đăng ký, còn lại là do nhân viên cập nhật
        'status_employer',
        'user_id_handling',
        'day_handling',
        'number_export'
    ];
    //khu vực đại lý của nhà ruyển dụng 3 khu vuc
    public static function get_province_local($local_area)
    {
        //$local_area gồm 3 miền 1 2 3
        $employer = new Employer;
        $employer = $employer->select(
            'employer.enterprise_name',
            'employer.employer_id',
            'employer.phone',
            'employer.slug',
            'employer.website',
            'employer.province',
            'employer.district',
            'province.province_name',
            'district.district_name',
            'enterprise_name'
        )
            ->join('province','province.province_id','employer.province')
            ->join('district','district.district_id','employer.district')
            ->where('employer.status_agency' , 1)
            ->where('province.local_area' , $local_area)
            ->get();
        return $employer;
    }
    public static function showAllEmployer()
    {
        return static::get();
    }

    public static function getselectNameId()
    {
        $employer = new Employer;
        $employer = $employer->select('employer_id', 'enterprise_name')->get();
        return $employer;
    }

    public static function getIdemployer($employer_id)
    {
        $employer = new Employer;
        $employers = $employer->select('enterprise_name', 'image', 'email', 'phone', 'employer_id','slug')
            //            ->where('employer_id', 'LIKE', "'".$employer_id."'")
            ->where('employer_id', '=', $employer_id)
            ->first();
        //        return $employer_id;
        return $employers;
        //        return $employers;
    }

    public static function get_employer_id($user_id)
    {
        $employer = new Employer;
        $employers = $employer->select('employer_id', 'user_id')
            //            ->where('employer_id', 'LIKE', "'".$employer_id."'")
            ->where('user_id', '=', $user_id)
            ->first();
        //        return $employer_id;
        return $employers;
    }
    public static function getIdUser($user_id)
    {
        $employer = new Employer;
        $employers = $employer->select('employer_vip','enterprise_name', 'image', 'employer_id', 'phone', 'email', 'address', 'employer_coin', 'total_employer_coin', 'total_money_coin')
            ->where('user_id', $user_id)
            ->first();
        return $employers;
    }
    public static function getIdUsers($user_id)
    {
        $employer = new Employer;
        $employers = $employer->select('*')
            //            ->where('employer_id', 'LIKE', "'".$employer_id."'")
            ->where('user_id', '=', $user_id)
            ->first();
        //        return $employer_id;
        return $employers;
        //        return $employers;
    }

        public static function check_employer_vip($user_id)
        {
            $employer_model = new Employer;
            $employer_vip = $employer_model->where('user_id', '=', $user_id)
                ->value('employer_vip');
            return $employer_vip;
        }

    public static function getAllStar()
    {
        $employer = new Employer();
        $employers = $employer->select('employer_id', 'image', 'phone', 'email', 'image', 'province', 'district', 'enterprise_name', 'status_intership', 'slug', 'view')
            ->where('status_intership', 1)
            ->limit(13)
            ->orderBy('employer_vip', 'desc')
            ->orderBy('total_star', 'desc')
            ->get();
        return $employers;
    }
    public static function getNew()
    {
        $employer = new Employer();
        $employers = $employer->select('employer_id', 'image', 'phone', 'email', 'image', 'province', 'district', 'enterprise_name', 'status_intership', 'slug', 'view')
            ->where('status_intership', 1)
            ->limit(13)
            //            ->orderBy('employer_id','desc')
            ->orderBy('view', 'desc')
            ->get();
        return $employers;
    }

    public static function getTotalEmployerTypeBusiness($type_of_business_id)
    {
        $employer = new Employer();
        $total = $employer->where('status_intership', 1)
            ->where('type_of_business_id', $type_of_business_id)
            ->count();
        return $total;
    }
    public static function getTotalEmployerProvince($province)
    {
        $employer = new Employer();
        $total = $employer->select('status_intership', 'province')
            ->where('status_intership', 1)
            ->where('province', $province)
            ->count();
        return $total;
    }
    public static function check_is_admin($user_id)
    {
        $employer = new Employer();
        $employer = $employer->select('user_id', 'is_admin')
            ->where('user_id', $user_id)
            ->where('is_admin', 1)
            ->count();
        return $employer;
    }
    public static function get_user_id_Profile($user_id)
    {
        $employer_model = new Employer();
        $employer = $employer_model->select('*')
            ->where('user_id', $user_id)->first();
        $profile = 0;
        if (!empty($employer['enterprise_name'])) {
            $profile = $profile + 10;  //
        }
        if (!empty($employer['phone'])) {
            $profile = $profile + 10;  //
        }
        if (!empty($employer['email'])) {
            $profile = $profile + 10;  //
        }
        if (!empty($employer['address'])) {
            $profile = $profile + 10;  //
        }
        if (!empty($employer['introduction'])) {
            $profile = $profile + 10;  //
        }
        if (!empty($employer['province'])) {
            $profile = $profile + 10;  //
        }
        if (!empty($employer['district'])) {
            $profile = $profile + 10;  //
        }
        if (!empty($employer['business'])) {
            $profile = $profile + 10;  //
        }
        if (!empty($employer['type_of_business_id'])) {
            $profile = $profile + 10;  //
        }
        if (!empty($employer['image'])) {
            $profile = $profile + 10;  //
        }
        $update = $employer_model->where('user_id', $user_id)->update([
            'profile' => $profile
        ]);
        return true;
    }
}
