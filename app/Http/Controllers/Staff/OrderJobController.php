<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Entity\Order_request;
use App\Entity\Order_job;
use App\Entity\Staff;
use App\Entity\Employee;
use App\Entity\Staff_status_job_submit;
use App\Entity\Staff_status_job_submit_employee;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Hunter_registration;
use App\Entity\Job;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderJobController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'donhang');
            return $next($request);
        });
    }
    
    public function index(Request $request)
    {
        $num = 20;
        if(!empty($request->num))
        {
            $num = $request->num;
        }
        $order_jobs = Order_job::select(
            'order_job_id', 
            'order_request_id', 
            'order_job_code', 
            'order_job_title', 
            'order_job_des', 
            'order_job_price', 
            'order_job_discount', 
            'order_job_statu_pay', 
            'order_job_status_pay_all', 
            'order_job_statu_content', 
            'order_job_guarantee', 
            'order_job_guarantee_date', 
            'user_id', 
            'employer_id', 
            'job_id', 
            'hunter_regis_id', 
            'file_upload_contract', 
            'created_at'
        )
        ->orderBy('order_job_id', 'desc');
        // tim trang thai thanh toan don hang
        if(isset($request->order_job_statu_pay)){
            $order_jobs = $order_jobs->where('order_job_statu_pay', $request->order_job_statu_pay);
        }
        if(isset($request->order_job_status_pay_all)){
            $order_jobs = $order_jobs->where('order_job_status_pay_all', $request->order_job_status_pay_all);
        }
         // tim theo nha uyen dung
         if(!empty($request->employer_id)){
            $order_jobs = $order_jobs->where('employer_id', $request->employer_id);
        }
        // tìm theo ngày from
        if(!empty($request->date_search_start) ){
            $order_jobs = $order_jobs->whereDate('order_request.created_at', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $order_jobs = $order_jobs->whereDate('order_request.created_at', '<=', $request->date_search_end);
        }
        $order_jobs = $order_jobs->paginate($num);
        return view('staff_admin.order_job.list', compact('order_jobs'));
    }

    public function staff_create_order_job($order_request_id)
    {
        $order_req = Order_request::findOrfail($order_request_id);
        return view('staff_admin.order_job.create', compact('order_req'));
    }

    public function create()
    {
        return view('staff_admin.order_job.create');
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'employer_id' => 'required',
            'job_id' => 'required',
            'order_request_id' => 'required',
            'order_job_price' => 'required',
        ],[
            'employer_id.required' => 'Chưa chọn nhà tuyển dụng',
            'job_id.required' => 'Chưa chọn việc làm',
            'order_request_id.required' => 'Chưa chọn yêu cầu đơn hàng',
            'order_job_price.required' => 'Chưa nhập giá đơn hàng'
        ]);
        $employer_id = $request->employer_id;
        $link_contract = '';
        $image_pay = '';
        $upload_file = new Order_request();
        if($request->file_upload_contract){
            $link_contract = $upload_file->upload_file_contract($employer_id, $request, 'file_upload_contract');
            if (empty($link_contract)) {
                return redirect()->back()->with('error', 'File hợp đồng phải là file docx hoặc là pdf và dung lượng file < 10M');
            }
        }
        if($request->order_job_statu_content){
            // link hinh anh chup noi dung chuyen khoan
            $image_pay = $upload_file->upload_image($employer_id, $request, 'order_job_statu_content');
            if (empty($image_pay)) {
                return redirect()->back()->with('error', 'Hình ảnh chụp nội dung chuyển khoản phải là định dạng hình ảnh và dung lượng file < 10M');
            }
        }
        $order_job_discount = str_replace(",","", $request->order_job_discount);
        $order_job_price = str_replace(",","", $request->order_job_price);
        $order_job_statu_pay = 0;
        if(isset($request->order_job_statu_pay)){
            $order_job_statu_pay = $request->order_job_statu_pay;
        }
        $order_job_status_pay_all = 0;
        if(isset($request->order_job_status_pay_all)){
            $order_job_status_pay_all = $request->order_job_status_pay_all;
        }
        // lưu order_request
        $order_job_id = Order_job::insertGetId([
            'order_request_id' => $request->order_request_id,
            'order_job_des' => $request->order_job_des,
            'order_job_price' => $order_job_price,
            'order_job_discount' => $order_job_discount,
            'order_job_statu_pay' => $order_job_statu_pay,
            'order_job_status_pay_all' => $order_job_status_pay_all,
            'user_id' => Auth::id(),
            'order_job_statu_content' => $image_pay,
            'order_job_guarantee' => $request->order_job_guarantee,
            'employer_id' => $employer_id,
            'job_id' => $request->job_id,
            'hunter_regis_id' => $request->hunter_regis_id,
            'file_upload_contract' => $link_contract,
            'created_at' => new \Datetime()
        ]);
        Order_job::where('order_job_id', $order_job_id)->update([
            'order_job_code' => 'OJC_' . $order_job_id
        ]);
        return redirect()->route('staff_order_job.index')->with('success', 'Lập đơn hàng thành công!');
    }

    public function edit($id)
    {
        $order_job = Order_job::findOrFail($id);
        return view('staff_admin.order_job.edit', compact('order_job'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'employer_id' => 'required',
            'job_id' => 'required',
            'order_request_id' => 'required',
            'order_job_price' => 'required',
        ],[
            'employer_id.required' => 'Chưa chọn nhà tuyển dụng',
            'job_id.required' => 'Chưa chọn việc làm',
            'order_request_id.required' => 'Chưa chọn yêu cầu đơn hàng',
            'order_job_price.required' => 'Chưa nhập giá đơn hàng'
        ]);

        $order_job = Order_job::findOrFail($id);
        $upload_file = new Order_request();
        $employer_id = $request->employer_id;
        if(!empty($request->file_upload_contract)){
            $link_contract = $upload_file->upload_file_contract($employer_id, $request, 'file_upload_contract');
            if (empty($link_contract)) {
                return redirect()->back()->with('error', 'File hợp đồng phải là file docx hoặc là pdf và dung lượng file < 10M');
            }
            else{
                $order_job->update([
                    'file_upload_contract' => $link_contract,
                    'updated_at' => new \Datetime()
                ]);
            }
        }
        //update hinh anh  thanh toans
        if(!empty($request->order_job_statu_content)){
            $image_pay = $upload_file->upload_image($employer_id, $request, 'order_job_statu_content');
            if (empty($image_pay)) {
                return redirect()->back()->with('error', 'Hình ảnh phải có định dạng hình ảnh và dung lượng file < 10M');
            }
            else{
                $order_job->update([
                    'order_job_statu_content' => $image_pay,
                    'updated_at' => new \Datetime()
                ]);
            }
        }
        $order_job_price = str_replace(",","", $request->order_job_price);
        $order_job_discount = str_replace(",","", $request->order_job_discount);
        //update cac truong con lai
        $order_job->update([
            'order_request_id' => $request->order_request_id, 
            'order_job_des' => $request->order_job_des, 
            'order_job_price' => $order_job_price, 
            'order_job_discount	' => $order_job_discount, 
            'order_job_statu_pay' => $request->order_job_statu_pay, 
            'order_job_status_pay_all' => $request->order_job_status_pay_all, 
            'order_job_guarantee' => $request->order_job_guarantee, 
            'order_job_guarantee_date' => $request->order_job_guarantee_date, 
            'employer_id' => $request->employer_id, 
            'job_id' => $request->job_id, 
            'hunter_regis_id' => $request->hunter_regis_id, 
            'updated_at' => new \Datetime()
        ]);
        return redirect()->route('staff_order_job.index')->withSuccess('Chỉnh sửa thành công!');
    }

    public function destroy($id)
    {
        $order_job = Order_job::findOrFail($id);
        $order_request = Order_request::where('order_request_id', $order_job->order_request_id)->first();
        if(!empty($order_request)){
            return back()->withError('Cần xóa yêu cầu đơn hàng trước khi xóa đơn hàng.');
        }
        $order_job = $order_job->delete();
        return back()->withSuccess('Xóa đơn hàng thành công');
    }

    public function staff_order_job_deleted(Request $request)
    {
        $num = 20;
        if(!empty($request->num))
        {
            $num = $request->num;
        }
        $order_jobs = Order_job::select(
            'order_job_id', 
            'order_request_id', 
            'order_job_code', 
            'order_job_title', 
            'order_job_des', 
            'order_job_price', 
            'order_job_discount', 
            'order_job_statu_pay', 
            'order_job_status_pay_all', 
            'order_job_statu_content', 
            'order_job_guarantee', 
            'order_job_guarantee_date', 
            'user_id', 
            'employer_id', 
            'job_id', 
            'hunter_regis_id', 
            'file_upload_contract', 
            'created_at'
        )->onlyTrashed()
        ->orderBy('order_job_id', 'desc');
        // tim trang thai thanh toan don hang
        if(isset($request->order_job_statu_pay)){
            $order_jobs = $order_jobs->where('order_job_statu_pay', $request->order_job_statu_pay);
        }
        if(isset($request->order_job_status_pay_all)){
            $order_jobs = $order_jobs->where('order_job_status_pay_all', $request->order_job_status_pay_all);
        }
         // tim theo nha uyen dung
         if(!empty($request->employer_id)){
            $order_jobs = $order_jobs->where('employer_id', $request->employer_id);
        }
        // tìm theo ngày from
        if(!empty($request->date_search_start) ){
            $order_jobs = $order_jobs->whereDate('order_request.created_at', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $order_jobs = $order_jobs->whereDate('order_request.created_at', '<=', $request->date_search_end);
        }
        $order_jobs = $order_jobs->paginate($num);
        return view('staff_admin.order_job.list_deleted', compact('order_jobs'));
    }

    public function restore_job_orders_deleted($id)
    {
        Order_job::onlyTrashed()->where('order_job_id', $id)->restore();
        return redirect()->route('staff_order_job.index')->withSuccess('Khôi phục thành công.');
    }

    public function job_orders_deleted_force($id)
    {
        $order_job = Order_job::onlyTrashed()->where('order_job_id', $id)->first();
        $link_file_contract = $order_job->file_upload_contract;
        $link_file_contract = str_replace('/public', '', $order_job->file_upload_contract);
        $link_file_contract = public_path($link_file_contract);

        if (file_exists($link_file_contract)) {
            unlink($link_file_contract);
        }

        $order_job->forceDelete();
        return redirect()->route('staff_order_job.index')->withSuccess('Xóa hẳn thành công.');
    }

    public function get_job_select2(Request $request)
    {
        $search  = trim($request->search);
        $page = !empty($request->page) ? $request->page : 1;
        $resultCount = 50;
        $offset = ($page - 1) * $resultCount;
        if($search == ''){
            $jobs = Job::select('job_id','job_code', 'title')->latest()->skip($offset)->take($resultCount)->get();
            $count = Job::select('job_id','job_code', 'title')->get()->count();
         }else{
            $jobs = Job::select('job_id','job_code', 'title')->latest()->where('job_code', $search)
            ->orWhere('title', 'like', '%' .$search . '%')
            ->skip($offset)->take($resultCount)->get();
            $count = Job::select('job_id','job_code', 'title')
            ->where('job_code', $search)
            ->orWhere('title', 'like', '%' .$search . '%')->get()->count();
        }

        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;
   
         $response = array();
         foreach($jobs as $job){
            $response[$job->job_id] = array(
                 "id"=>$job->job_id,
                 "text"=>$job->job_code . '-' . $job->title
            );
         }
        echo (json_encode([
            'result' => $response,
            'search' => $search,
            "pagination" => ["more" => $morePages]
        ]));
        exit;
    }

    public function manager_order_job($order_job_id)
    {
        $job_id = Order_job::where('order_job_id', $order_job_id)->value('job_id');
        $employee = Employee_submit_job_faacebook::where('id_job_fb', $job_id)->pluck('employee_id');

        //lay cac ung vien moi nop ho so chua chuyen trang thai
        $employees_no_status = Employee_submit_job_faacebook::select(
            'employee_submit_job_facebook.employee_id',
            'employee_submit_job_facebook.submit_job_fb_id'
        )
        ->leftJoin('staff_status_job_submit_employee', 'staff_status_job_submit_employee.submit_job_fb_id', 'employee_submit_job_facebook.submit_job_fb_id')
        ->where('employee_submit_job_facebook.id_job_fb', $job_id)
        ->where('staff_status_job_submit_employee.staff_employee_id', null)->get();
        // update trang thai ho so xu ly cho cac ho so ung vien moi nop ung tuyen
        if(!empty($employees_no_status))
        {
            foreach($employees_no_status as $employee_no_status){
                Staff_status_job_submit_employee::insert([
                    'submit_job_fb_id' => $employee_no_status->submit_job_fb_id,
                    'staff_job_id' => 1
                ]);
            }
        }
        // lay cac ho so da co trang thai nhan vien xu ly
        $staff_status_job_submit_employee = Staff_status_job_submit_employee::select(
            'staff_status_job_submit_employee.staff_job_id',
            'staff_status_job_submit_employee.staff_employee_id',
            'employee_submit_job_facebook.submit_job_fb_id',
            'staff_status_job_submit_employee.staff_id',
            'staff_status_job_submit_employee.updated_at as date_move_state',
            'employee_submit_job_facebook.id_job_fb',
            'employee_submit_job_facebook.created_at as date_submit_cv',
            'employee_submit_job_facebook.status_change_profile',
            'employee_submit_job_facebook.employee_id'
        )
        ->join('employee_submit_job_facebook', 'employee_submit_job_facebook.submit_job_fb_id', 'staff_status_job_submit_employee.submit_job_fb_id')
        ->where('employee_submit_job_facebook.id_job_fb', $job_id)->get();
        //cac trang thai su ly ho so
        $staff_status_job_submit = Staff_status_job_submit::get();
        return view('staff_admin.order_job.manager_order_job', compact('staff_status_job_submit_employee', 'staff_status_job_submit', 'job_id'));
    }

    public function change_staff_status_job_submit(Request $request)
    {
        $staff_id = Staff::where('user_id', Auth::id())->value('staff_id');
        Staff_status_job_submit_employee::where('staff_employee_id', $request->staff_employee_id)->update([
            'staff_job_id' => $request->status_job,
            'staff_id' => $staff_id,
            'updated_at' => new \Datetime()
        ]);

        $staff_status_job_submit_employee = Staff_status_job_submit_employee::select(
            'staff_status_job_submit_employee.staff_id',
            'staff_status_job_submit_employee.updated_at as date_move_state',
            'employee_submit_job_facebook.created_at as date_submit_cv'
        )
        ->join('employee_submit_job_facebook', 'employee_submit_job_facebook.submit_job_fb_id', 'staff_status_job_submit_employee.submit_job_fb_id')
        ->where('staff_status_job_submit_employee.staff_employee_id', $request->staff_employee_id)->first();
        $staff_name = Staff::where('staff_id', $staff_status_job_submit_employee->staff_id)->value('staff_name');
        $staff_status_job_submit_employee->staff_name = $staff_name;
        return $staff_status_job_submit_employee;
    }

    public function get_status_job_employee(Request $request)
    {
        $staff_employee_id = $request->staff_employee_id;
        $staff_employee = Staff_status_job_submit_employee::select(
            'staff_employee_id',
            'staff_job_id',
            'staff_id_comment'
        )
        ->where('staff_employee_id', $staff_employee_id)->first();
        $staff_status_job_submit = Staff_status_job_submit::get();
        return response()->json([
            'staff_status_job_submit' => $staff_status_job_submit,
            'staff_employee' => $staff_employee
        ]);
    }

    public function form_change_staff_status_job_submit(Request $request)
    {
        $staff_id = Staff::where('user_id', Auth::id())->value('staff_id');
        Staff_status_job_submit_employee::where('staff_employee_id', $request->staff_employee_id)->update([
            'staff_id_comment' => $request->staff_id_comment,
            'staff_job_id' => $request->staff_job_id,
            'staff_id' => $staff_id,
            'updated_at' => new \Datetime()
        ]);
        return redirect()->back();
    }

    public function search_employee_order_job(Request $request)
    {
        $employee_id = $request->employee_id;
        $phone = $request->phone;
        $email = $request->email;

        $employees = Employee::select('employee_id', 'employee_name', 'phone', 'email');
        if(!empty($request->employee_id)){
            $employees = $employees->where('employee_id', $employee_id);
        }
        if(!empty($request->phone)){
            $employees = $employees->where('phone', $phone);
        }
        if(!empty($request->email)){
            $employees = $employees->where('email', 'like', '%' . $email . '%');
        }
        $employees = $employees->get();
        return $employees;
    }

    public function add_employee_apply_order_job(Request $request)
    {
        $staff_id = Staff::where('user_id', Auth::id())->value('staff_id');
        // kiem tra ung vien da nop hho so chua
        $submit_job_fb_id = Employee_submit_job_faacebook::where('employee_id', $request->employee_id)
        ->where('id_job_fb', $request->job_id)
        ->value('submit_job_fb_id');
        if(!empty($submit_job_fb_id))
        {

        }
        else{
            $submit_job_fb_id = Employee_submit_job_faacebook::insertGetId([
                'employee_id' => $request->employee_id,
                'id_job_fb' => $request->job_id,
                'status_job' => 1,
                'day_submit_job' => new \Datetime(),
                'status_change_profile' => 1,
                'created_at' => new \Datetime()
            ]);
            Staff_status_job_submit_employee::insert([
                'submit_job_fb_id' => $submit_job_fb_id,
                'staff_id' => $staff_id,
                'staff_job_id' => 1,
                'created_at' => new \Datetime()
            ]);
        }

    }
    public function delete_employer_in_order($staff_employee_id, $submit_job_fb_id){
        Staff_status_job_submit_employee::where('staff_employee_id', $staff_employee_id)->delete();
        Employee_submit_job_faacebook::where('submit_job_fb_id', $submit_job_fb_id)->delete();

        Staff_status_job_submit_employee::withTrashed()->where('staff_employee_id', $staff_employee_id)->forceDelete();
        return back()->withSuccess('Xóa thành công.');
    }
}
