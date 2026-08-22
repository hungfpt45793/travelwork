<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site\Course;

use App\Course\Course;
use App\Course\Course_employee;
use App\Course\Course_order;
use App\Course\Course_teacher_active;
use App\Course\Courses;
use App\Entity\Employee;
use App\Http\Controllers\Site\CkedittorController;
use App\Http\Controllers\Site\SiteController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use App\Rules\Invateemails;
use App\Mail\Resetpassword;

class CourseEmployeeController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('menuTopsite', 'teacher');
    }

    public function employee_active_course(Request $request)
    {
        $activation_code = $request->input('activation_code');
        $course_order = Course_order::select('course_cost',
            'course_order.course_order_status', //trạng thái thanh toán của khóa hoc: 0 là chưa, 1 đã thanh toán
            'course_order.course_id',
            'course_order.admin_id',
            'course_order.admin_messager',
            'course_order.activation_code',  //mã kích hoạt
            'course_order.activation_code_status' //trạng thái mã kích hoạt 0 là chưa 1 là đã sử dụng
        )
            ->where('course_order.activation_code', $activation_code)
            ->where('course_order.course_order_status', 1)
            ->first();

        $course_active = Courses::select('course_id')
            ->where('activation_code',$activation_code)
            ->first();
        $course_teacher = Course_teacher_active::select('*')
        ->where('activation_code',$activation_code)
        ->whereDate('date_end_active', '>=', date('Y-m-d'))
        ->first();

        if (empty($course_order) && empty($course_active) && empty($course_teacher)) {
            return redirect()->back()->with('mesage_modal', 'Không tồn tại mã kích hoạt này hoặc mã kích hoạt đã hết hạn!');
        }

        $course_id = 0;
        $status_select_active_code = 0; //trạng thái mã kích hoạt thuộc bảng nào
        // check mã kh mặc đinh
        if(!empty($course_active))
        {
            $course_id = $course_active->course_id;

            $status_select_active_code = 0;
            $request->session()->put('activation_code', $activation_code);
            $request->session()->put('status_select_active_code', $status_select_active_code);
        }
        //check mã kh đơn hàng
        if(!empty($course_order))
        {
            $course_id = $course_order->course_id;
            if (($course_order->activation_code_status == 1) && ($course_order->activation_code == $activation_code)) {
                return redirect()->back()->with('mesage_modal', 'Mã kích hoạt này đã được sử dụng !');
            }

            $status_select_active_code = 1;
            $request->session()->put('activation_code', $activation_code);
            $request->session()->put('status_select_active_code', $status_select_active_code);
        }
//        check mã kh miễn phí
        if(!empty($course_teacher))
        {
            $course_id = $course_teacher->course_id;
            if (($course_teacher->status_active_code == 1) && ($course_teacher->activation_code == $activation_code)) {
                return redirect()->back()->with('mesage_modal', 'Mã kích hoạt này đã được sử dụng !');
            }
            $status_select_active_code = 2;
            $request->session()->put('activation_code', $activation_code);
            $request->session()->put('status_select_active_code', $status_select_active_code);
        }
        if (Auth::check() && Auth::user()->role == 1) {
            $check_course_id = $this->get_active_employee(Auth::user()->id, $course_id, $activation_code,$status_select_active_code);
            $request->session()->forget('activation_code');
            $request->session()->forget('status_select_active_code');
        }
        return redirect()->back()->with('mesage_modal', 'Bạn đã kích hoạt khóa học thành công!');
    }

    public function get_active_employee($user_id, $course_id, $activation_code,$status_select_active_code)
    {
        $employee_id = Employee::where('user_id', $user_id)->value('employee_id');
        $course_employee_count = Course_employee::where('employee_id', $employee_id)
            ->where('course_id', $course_id)
            ->count();
        if (empty($course_employee_count)) {
            $course_employee = Course_employee::insertGetId([
                'employee_id' => $employee_id,
                'course_id' => $course_id,
                'activation_code' => $activation_code,
                'status_select_active_code' => $status_select_active_code,
                'created_at' => new \DateTime(),
            ]);
            //cap nhat trang thai khoa hoc
            if($status_select_active_code == 1)
            {
                $course_order = Course_order::where('activation_code', $activation_code)
                    ->update([
                        'activation_code_status' => 1,
                        'updated_at' => new \DateTime()
                    ]);
            }
            if($status_select_active_code == 2)
            {
                $course_teacher = Course_teacher_active::where('activation_code', $activation_code)
                    ->update([
                        'status_active_code' => 1,
                        'updated_at' => new \DateTime()
                    ]);
            }
        }
        return $employee_id;

    }


}
