<?php

namespace App\Http\Controllers\Api;

use App\Entity\Category;
use App\Entity\Employee;
use App\Entity\Input;
use App\Entity\Job;
use App\Entity\Post;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_specialize;
use App\Entity\TypeOfBusiness;
use App\Entity\User;
use App\Http\Controllers\Site\MailConfigController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class TypeOfBusinessController extends Controller
{
//http://sanketoan.local/api/tin-tuc/kinh-nghiem-de-tuyen-dung-duoc-mot-ke-toan-tong-hop-co-ky-nang-xu-ly-cong-viec-gioi
    public  function getType()
    {
        $type = New TypeOfBusiness();
        $type = $type->select('type_of_business_id','type_of_business_name','type_of_business_slug')->get();
        if(empty($type)){
            return response([
                'status' => 404,
                'message' => 'Không tìm thấy dữ liệu'
            ],404);
        }
        return response([
            'status' => 200,
            'type' => $type,
        ],200);
    }
}
