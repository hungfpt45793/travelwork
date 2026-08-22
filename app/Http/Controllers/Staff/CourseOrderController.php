<?php

namespace App\Http\Controllers\Staff;
use App\Entity\Information_money;
use Illuminate\Support\Facades\Auth;
use App\Course\Courses;
use App\Http\Controllers\Site\MailConfigController;
use App\Course\Course_teacher_money;
use App\Course\Course_statistical_teacher;
use App\Course\Course_statistical_employee;
use App\Entity\Employee_coins;
use App\Course\Course_order;
use Illuminate\Http\Request;
use App\Http\Controllers\Staff\SiteStaffController;

class CourseOrderController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'khoahoc');
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $course_order = new Course_order();
        $list_order = $course_order->select('course_order.*','courses.course_title','courses.course_code');
        $list_order = $list_order->join('courses', 'courses.course_id', '=', 'course_order.course_id');
        if($request->has('course_order_status'))
        {
            $list_order = $list_order->where('course_order.course_order_status', $request->input('course_order_status'));

        }
        if($request->has('activation_code'))
        {
            $list_order = $list_order->where('course_order.activation_code', $request->input('activation_code'));

        }
        if($request->has('course_title'))
        {
            $list_order = $list_order->where('courses.course_title','like', '%'.$request->input('course_title').'%');
        }
        $list_order = $list_order->orderBy('course_order.course_order_id', 'desc')
            ->paginate(20);
        $list_order->appends(request()->query());
        return view('staff_admin.course_order.list', compact('list_order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_order_id)
    {
        $course_order = new Course_order();
        $order = $course_order->select('course_order.*','courses.course_title','courses.course_code');
        $order = $order->join('courses', 'courses.course_id', '=', 'course_order.course_id')
            ->where('course_order_id',$course_order_id)
            ->first();
        return view('staff_admin.course_order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_order_id)
    {
        //

        $information_money = Information_money::get_information_money();
        $course_order_model = new Course_order();
        $update_order = $course_order_model->where('course_order_id',$course_order_id)->update([
            'admin_id' => Auth::user()->id,
            'course_order_status' => $request->input('course_order_status'),
            'admin_messager' => $request->input('admin_messager'),
            'updated_at' => new \DateTime()
        ]);
        //tiến hành gủi email;
        if($request->input('course_order_status')  == 1)
        {
            $course_order = Course_order::where('course_order_id', $course_order_id)->first();
            $course = Courses::select('course_title',
                'course_id',
                'course_code',
                'course_slug',
                'course_code',
                'course_image')
                ->where('course_id', $course_order->course_id)
                ->first();

            if($course->course_id == 39)
            {
                //mau email 50
                $send_email = MailConfigController::send_email_active_facebook_course($course, $course_order);
            }
            else
            {
                //mau email 51
                $send_email = MailConfigController::send_email_active_course($course, $course_order);
            }

            //cộng tiền cho ứng viên chia sẻ (nếu có)  khi đã thanh toán đơn hàng
            if(!empty($course_order->employee_id))
            {
                //tính số tiền mà user hưởng
                $course_money_order = 0;
                $course_money_order = ($course_order->course_cost /100) * (!empty($information_money['phan-tram-cho-ung-vien-chia-se-khoa-hoc']) ? $information_money['phan-tram-cho-ung-vien-chia-se-khoa-hoc'] : 10);

                $course_statis_employee = Course_statistical_employee::where('employee_id',$course_order->employee_id)
                    ->where('course_order_id',$course_order->course_order_id)
                    ->first();
                if(empty($course_statis_employee))
                {
                    $course = Course_statistical_employee::insert([
                        'employee_id' => $course_order->employee_id,
                        'course_order_id' =>$course_order->course_order_id,
                        'course_money_order' => $course_money_order,
                        'created_at' => new \DateTime()
                    ]);
                    //công tiền vào bảng tổng của user
                    $employee_coins = Employee_coins::select('total_money','money','employee_id')->where('employee_id',$course_order->employee_id)->first();
                    //nếu chưa có thì tiến hành thêm mới
                    if(empty($employee_coins))
                    {
                        $insert_employee_coin = Employee_coins::insert([
                            'employee_id' => $course_order->employee_id,
                            'total_money' => $course_money_order,
                            'money' => $course_money_order,
                            'created_at' => new \DateTime()
                        ]);
                    }else
                    {
                        $total_money = $employee_coins->total_money + $course_money_order;
                        $money = $employee_coins->money + $course_money_order;
                        //update
                        $update_employee_coint = Employee_coins::where('employee_id',$course_order->employee_id)->update([
                            'total_money' => $total_money,
                            'money' => $money,
                            'updated_at' => new \DateTime()
                        ]);
                    }
                }
            }
            //cộng tiền cho giáo viên
            $teacher_id = Courses::get_teacher_id($course_order->course_id);
            $money_teacher_order =  ($course_order->course_cost /100) * (!empty($information_money['phan-tram-khoa-hoc-cho-giao-vien']) ? $information_money['phan-tram-khoa-hoc-cho-giao-vien'] : 40);
            //
            $course_statistical_teacher = Course_statistical_teacher::where('teacher_id',$teacher_id)->where('course_order_id',$course_order->course_order_id)->first();
            //nếu chưa có thì tiến hành thêm mới
            if(empty($course_statistical_teacher))
            {
                $insert_statistical_teacher = Course_statistical_teacher::insert([
                    'course_order_id' =>$course_order->course_order_id,
                    'course_price' =>$money_teacher_order,
                    'teacher_id' => $teacher_id,
                    'created_at' => new \DateTime()
                ]);

                $teacher_money = Course_teacher_money::select('total_money', 'money')->where('teacher_id',$teacher_id)->first();
                if(empty($teacher_money))
                {
                    $inser_teacher_id_money = Course_teacher_money::insert([
                        'teacher_id' => $teacher_id,
                        'total_money' => $money_teacher_order, //Tổng số tiền nhận được do nhận được do chia sẻ
                        'money' => $money_teacher_order, //số dư tài khoản
                        'created_at' => new \DateTime()
                    ]);
                }else
                {
                    $total_money_teacher = $teacher_money->total_money + $money_teacher_order;
                    $money_teacher = $teacher_money->money + $money_teacher_order;
                    $update = Course_teacher_money::where('teacher_id',$teacher_id)->update([
                        'total_money' => $total_money_teacher,
                        'money' => $money_teacher,
                        'updated_at' => new \DateTime()
                    ]);
                }
            }
        }
        return redirect(route('courseOrder.index'))->with('success', 'Cập nhật đơn hàng thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function courseOrderDestroy($course_order_id)
    {
        $courses_model = new Course_order();
        $delete_id = $courses_model->where('course_order_id', $course_order_id)->delete();
        return redirect(route('courseOrder.index'))->with('success', 'Xóa đơn hàng thành công');
    }

    public function order_sales_statistics_staff(Request $request)
    {
        $list_order = Course_order::select('course_order.course_cost',
            'course_order.course_order_id',
            'course_statistical_employee.course_money_order as course_price_employee',
            'course_statistical_teacher.course_price as course_price_teacher',
            'courses.course_title',
            'courses.course_code',
            'course_formality.course_formality_title'
        )
            ->where('course_order_status',1)
            ->leftJoin('course_statistical_employee','course_statistical_employee.course_order_id','=','course_order.course_order_id')
            ->leftJoin('course_statistical_teacher','course_statistical_teacher.course_order_id','=','course_order.course_order_id')
            ->join('courses','courses.course_id','=','course_order.course_id')
            ->join('course_formality','course_formality.course_formality_id','=','course_order.course_formality_id')
            ->orderBy('course_order.course_order_id','desc')
            ->paginate(20);

        $sum_order = Course_order::where('course_order_status',1)
            ->orderBy('course_order.course_order_id','desc')
            ->paginate(20)
            ->sum('course_cost');
        return view('staff_admin.course_order.order_sales_statistics_staff', compact('list_order','sum_order'));
    }
}
