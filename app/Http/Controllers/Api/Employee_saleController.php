<?php

namespace App\Http\Controllers\Api;

use App\Entity\District;
use App\Entity\Employee_coins;
use App\Entity\Province;
use App\Http\Controllers\Controller;
use Validator;

class Employee_saleController extends Controller
{

    //copy tai khaon chia se bai viet kiem tien sang ketoanthue
    //tạm thời đóng lại chức năng copy này
    public function copy_employee_to_sanketoan()
    {
        $list_employee = Employee_coins::select('employee_coins.employee_id','employees.employee_id','employees.employee_image','employees.user_id','users.id','users.email','users.name','users.phone','users.image','users.diendan_image','users.diendan_code_intro','users.diendan_role','users.role','users.step','users.user_coin')
            ->join('employees','employees.employee_id','employee_coins.employee_id')
            ->join('users','users.id','employees.user_id')
            ->whereNotNull('users.email');
        $total = $list_employee->count();
        $list_employee = $list_employee->get();
//        return response([
//            'status' => 200,
//            'total' => $total,
//            'list_employee' => $list_employee,
//        ], 200);
    }
}
