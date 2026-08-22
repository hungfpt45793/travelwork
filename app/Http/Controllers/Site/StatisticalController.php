<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\HistoryWork;
use App\Entity\Job;
use App\Entity\JobGroup;
use App\Entity\Order;
use App\Entity\Invite;
use App\Entity\SettingGetfly;
use App\Entity\Statistical_employees;
use App\Entity\User;
use App\Entity\Workplace;
use App\Ultility\CallApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Entity\MailConfig;
use App\Ultility\Error;
use Prophecy\Call\Call;

class StatisticalController extends SiteController
{
    public function updateStatiscal_view_job(Request $request, $val)
    {
        if (Auth::check() && Auth::user()->role == 1) {
            $user_id = Auth::user()->id;
            $role = Auth::user()->role;
            if ($role == 1) {
                $employee = new Employee();
                $employee = $employee->select('employee_id', 'user_id')->where('user_id', $user_id)->first();

                $statiscals = new Statistical_employees();
                $statiscal = $statiscals->select('*')->where('employees_id', $employee->employee_id)->first();
                if (!empty($statiscal)) {
                    $update = $this->update_total_view_job($employee->employee_id, $val);
                    if ($update) {
                        return response()->json([
                            'status' => 200,
                        ]);
                    } else {
                        return response()->json([
                            'status' => 500,
                        ]);
                    }
                } else {
                    $statiscals_id = $statiscals->insertGetId([
                        'employees_id' => $employee->employee_id
                    ]);

                    $update = $this->update_total_view_job($employee->employee_id, $val);
                    if ($update) {
                        return response()->json([
                            'status' => 200,
                        ]);
                    } else {
                        return response()->json([
                            'status' => 500,
                        ]);
                    }
                }
            }
        }
        return response()->json([
            'status' => 500,
        ]);
    }
    public function update_total_view_job($employees_id, $val)
    {
        if($val == 'total_view_job')
        {
            $statiscals = new Statistical_employees();
            $statis = $statiscals->select('*')->where('employees_id', $employees_id)->first();
            $total_view_job = $statis->total_view_job + 1;
            $statiscal = $statiscals->where('employees_id', $employees_id)->update([
                'total_view_job' => $total_view_job
            ]);
            return true;
        }
        if($val == 'total_view_voucher')
        {
            $statiscals = new Statistical_employees();
            $statis = $statiscals->select('*')->where('employees_id', $employees_id)->first();
            $total_view_voucher = $statis->total_view_voucher + 1;
            $statiscal = $statiscals->where('employees_id', $employees_id)->update([
                'total_view_voucher' => $total_view_voucher
            ]);
            return true;
        }
        if($val == 'total__dowload_voucher')
        {
            $statiscals = new Statistical_employees();
            $statis = $statiscals->select('*')->where('employees_id', $employees_id)->first();
            $total__dowload_voucher = $statis->total__dowload_voucher + 1;
            $statiscal = $statiscals->where('employees_id', $employees_id)->update([
                'total__dowload_voucher' => $total__dowload_voucher
            ]);
            return true;
        }
        if($val == 'total_exam')
        {
            $statiscals = new Statistical_employees();
            $statis = $statiscals->select('*')->where('employees_id', $employees_id)->first();
            $total_exam = $statis->total_exam + 1;
            $statiscal = $statiscals->where('employees_id', $employees_id)->update([
                'total_exam' => $total_exam
            ]);
            return true;
        }
        return false;
    }
}