<?php

namespace App\Http\Controllers\Api;


use App\Entity\Salary;
use App\Http\Controllers\Controller;
use Validator;

class SalaryController extends Controller
{
    public function list_salary()
    {
        try
        {
            $salary_model = new Salary();
            $list_salary = $salary_model->select('salary_id',
                'description'
            )->get();
            return response()->json([
                'status' => 200,
                'descript' => 'thành công',
                'list_salary' => $list_salary
            ],200);
        }catch (\Exception $e)
        {
            return response()->json([
                'status' => 400,
                'descript' => 'thất bại',
            ],400);
        }
    }


}
