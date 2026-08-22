<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Entity\Order_request;
use App\Entity\Hunter_pos;
use App\Entity\Hunter_price;
use App\Entity\Hunter_time;
use App\Entity\Hunter_registration;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class OrderRequestController extends SiteStaffController
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
        if(!empty($request->num)){
            $num = $request->num;
        }
        $order_requests = Order_request::select(
            'order_request_id', 
            'order_request_code', 
            'order_request_price', 
            'order_request_discount', 
            'advance_status_pay', 
            'image_pay', 
            'guarantee_time', 
            'user_id', 
            'employer_id', 
            'hunter_regis_id', 
            'hunter_pos', 
            'hunter_time', 
            'job_description', 
            'job_requirements', 
            'welfare', 
            'file_upload_contract', 
            'start_time', 
            'created_at', 
            'all_status_pay'
        )->orderBy('order_request_id', 'desc');
        // tim trang thai thanh toan don hang
        if(isset($request->advance_status_pay)){
            $order_requests = $order_requests->where('advance_status_pay', $request->advance_status_pay);
        }
        if(isset($request->all_status_pay)){
            $order_requests = $order_requests->where('all_status_pay', $request->all_status_pay);
        }
         // tim theo nha uyen dung
         if(!empty($request->employer_id)){
            $order_requests = $order_requests->where('employer_id', $request->employer_id);
        }
        // tìm theo ngày from
        if(!empty($request->date_search_start) ){
            $order_requests = $order_requests->whereDate('order_request.created_at', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $order_requests = $order_requests->whereDate('order_request.created_at', '<=', $request->date_search_end);
        }
        $order_requests = $order_requests->paginate($num);
        return view('staff_admin.order_request.list', compact('order_requests'));
    }

    public function staff_create_order_request($hunter_regis_id)
    {
        $hunter_regis = Hunter_registration::select(
            'hunter_registration.hunter_regis_id', 
            'hunter_registration.hunter_regis_pos', 
            'hunter_registration.hunter_regis_time', 
            'hunter_registration.hunter_regis_price', 
            'hunter_registration.hunter_regis_phone', 
            'hunter_registration.employer_id',
            'hunter_time.hunter_time_name',
            'hunter_pos.hunter_pos_name',
            'hunter_price.hunter_price'
        )
        ->leftJoin('hunter_price', 'hunter_price.hunter_price_id', 'hunter_registration.hunter_regis_price')
        ->leftJoin('hunter_pos', 'hunter_pos.hunter_pos_id', 'hunter_registration.hunter_regis_pos')
        ->leftJoin('hunter_time', 'hunter_time.hunter_time_id', 'hunter_registration.hunter_regis_time')
        ->where('hunter_registration.hunter_regis_id', $hunter_regis_id)
        ->first();
        $time = preg_replace('/[^0-9]/', '', $hunter_regis->hunter_time_name);
        $hunter_regis->time = (int)$time;
        return view('staff_admin.order_request.create', compact('hunter_regis'));
    }

    public function create()
    {
        
        return view('staff_admin.order_request.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'employer_id' => 'required',
            'guarantee_time' => 'required',
            'order_request_price' => 'required'
        ],[
            'employer_id.required' => 'Chưa chọn nhà tuyển dụng',
            'guarantee_time.required' => 'Chưa nhập thời gian bảo hành',
            'order_request_price.required' => 'Chưa nhập giá đơn hàng'
        ]);
        $employer_id = $request->employer_id;
        $order_request = new Order_request();
        if($request->file_upload_contract){
            $link_contract = $order_request->upload_file_contract($employer_id, $request, 'file_upload_contract');
            if (empty($link_contract)) {
                return redirect()->back()->with('error', 'File hợp đồng phải là file docx hoặc là pdf và dung lượng file < 10M');
            }
        }
        // link hinh anh chup noi dung chuyen khoan
        if($request->image_pay){
            $image_pay = $order_request->upload_image($employer_id, $request, 'image_pay');
            if (empty($image_pay)) {
                return redirect()->back()->with('error', 'Hình ảnh chụp nội dung chuyển khoản phải là định dạng hình ảnh và dung lượng file < 10M');
            }
        }
        $order_request_discount = str_replace(",","", $request->order_request_discount);
        $order_request_price = str_replace(",","", $request->order_request_price);
        $advance_status_pay = 0;
        if(isset($request->advance_status_pay)){
            $advance_status_pay = $request->advance_status_pay;
        }
        $all_status_pay = 0;
        if(isset($request->all_status_pay)){
            $all_status_pay = $request->all_status_pay;
        }
        // lưu order_request
        $order_request_id = Order_request::insertGetId([
            'order_request_price' => $order_request_price,
            'order_request_discount' => $order_request_discount,
            'order_request_discount' => $order_request_discount,
            'advance_status_pay' => $advance_status_pay,
            'image_pay' => !empty($image_pay) ? $image_pay : '',
            'guarantee_time' => $request->guarantee_time,
            'user_id' => Auth::id(),
            'employer_id' => $employer_id,
            'hunter_regis_id' => $request->hunter_regis_id,
            'hunter_pos' => $request->hunter_pos,
            'hunter_time' => $request->hunter_time,
            'job_description' => $request->job_description,
            'job_requirements' => $request->job_requirements,
            'welfare' => $request->welfare,
            'file_upload_contract' => !empty($link_contract) ? $link_contract : '', 
            'start_time' => $request->start_time,
            'all_status_pay' => $all_status_pay,
            'created_at' => new \Datetime()
        ]);
        Order_request::where('order_request_id', $order_request_id)->update([
            'order_request_code' => 'ORC_' . $order_request_id
        ]);
        return redirect()->route('staff_order_request.index')->with('success', 'Lập yêu cầu thực hiện đơn hàng thành công!');
    }


    public function edit($order_request_id)
    {
        $order_request = Order_request::findOrFail($order_request_id);
        return view('staff_admin.order_request.edit', compact('order_request'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'employer_id' => 'required',
            'guarantee_time' => 'required',
            'order_request_price' => 'required'
        ],[
            'employer_id.required' => 'Chưa chọn nhà tuyển dụng',
            'guarantee_time.required' => 'Chưa nhập thời gian bảo hành',
            'order_request_price.required' => 'Chưa nhập giá đơn hàng'
        ]);
        $order_request = Order_request::findOrFail($id);
        $order_req = new Order_request();
        $employer_id = $request->employer_id;
        //update file hopdong
        if(!empty($request->file_upload_contract)){
            $link_contract = $order_req->upload_file_contract($employer_id, $request, 'file_upload_contract');
            if (empty($link_contract)) {
                return redirect()->back()->with('error', 'File hợp đồng phải là file docx hoặc là pdf và dung lượng file < 10M');
            }
            else{
                $order_request->update([
                    'file_upload_contract' => $link_contract,
                    'updated_at' => new \Datetime()
                ]);
            }
        }
        //update hinh anh  thanh toans
        if(!empty($request->image_pay)){
            $image_pay = $order_req->upload_image($employer_id, $request, 'image_pay');
            if (empty($image_pay)) {
                return redirect()->back()->with('error', 'Hình ảnh phải có định dạng hình ảnh và dung lượng file < 10M');
            }
            else{
                $order_request->update([
                    'image_pay' => $image_pay,
                    'updated_at' => new \Datetime()
                ]);
            }
        }
        $order_request_discount = str_replace(",","", $request->order_request_discount);
        $order_request_price = str_replace(",","", $request->order_request_price);
        //update cac truong con lai
        $order_request->update([
            'order_request_price' => $order_request_price, 
            'order_request_discount' => $order_request_discount, 
            'advance_status_pay' => $request->advance_status_pay, 
            'guarantee_time' => $request->guarantee_time, 
            'employer_id' => $request->employer_id, 
            'hunter_regis_id' => $request->hunter_regis_id, 
            'hunter_pos' => $request->hunter_pos, 
            'hunter_time' => $request->hunter_time, 
            'job_description' => $request->job_description, 
            'job_requirements' => $request->job_requirements, 
            'welfare' => $request->welfare, 
            'start_time' => $request->start_time, 
            'updated_at' => new \Datetime(), 
            'all_status_pay' => $request->all_status_pay
        ]);
        return redirect()->route('staff_order_request.index')->withSuccess('Chỉnh sửa thành công!');
    }

    public function destroy($id)
    {
        Order_request::findOrFail($id)->delete();
        return back()->withSuccess('Xóa yêu cầu đơn hàng thành công.');
    }

    public function list_deleted(Request $request)
    {
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        $order_requests = Order_request::select(
            'order_request_id', 
            'order_request_code', 
            'order_request_price', 
            'order_request_discount', 
            'advance_status_pay', 
            'image_pay', 
            'guarantee_time', 
            'user_id', 
            'employer_id', 
            'hunter_regis_id', 
            'hunter_pos', 
            'hunter_time', 
            'job_description', 
            'job_requirements', 
            'welfare', 
            'file_upload_contract', 
            'start_time', 
            'created_at', 
            'all_status_pay'
        )->onlyTrashed()->orderBy('order_request_id', 'desc');
        // tim trang thai thanh toan don hang
        if(isset($request->advance_status_pay)){
            $order_requests = $order_requests->where('advance_status_pay', $request->advance_status_pay);
        }
        if(isset($request->all_status_pay)){
            $order_requests = $order_requests->where('all_status_pay', $request->all_status_pay);
        }
         // tim theo nha uyen dung
         if(!empty($request->employer_id)){
            $order_requests = $order_requests->where('employer_id', $request->employer_id);
        }
        // tìm theo ngày from
        if(!empty($request->date_search_start) ){
            $order_requests = $order_requests->whereDate('order_request.created_at', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $order_requests = $order_requests->whereDate('order_request.created_at', '<=', $request->date_search_end);
        }
        $order_requests = $order_requests->paginate($num);
        return view('staff_admin.order_request.list_deleted', compact('order_requests'));
    }

    public function restore_request_orders_deleted($id)
    {
        Order_request::onlyTrashed()->where('order_request_id', $id)->restore();
        return redirect()->route('staff_order_request.index')->withSuccess('Khôi phục thành công.');
    }
    public function request_orders_deleted_force($id)
    {
        $order_request = Order_request::onlyTrashed()->where('order_request_id', $id)->first();
        $link_file_contract = $order_request->file_upload_contract;
        $link_file_contract = str_replace('/public', '', $order_request->file_upload_contract);
        $link_file_contract = public_path($link_file_contract);

        if (file_exists($link_file_contract)) {
            unlink($link_file_contract);
        }

        $order_request->forceDelete();
        return redirect()->route('staff_order_request.index')->withSuccess('Xóa hẳn thành công.');
    }

    public function get_info_hunter_register(Request $request){
        $hunter_regis_id = $request->hunter_regis_id;
        $hunter = Hunter_registration::select(
            'hunter_pos.hunter_pos_name',
            'hunter_price.hunter_price',
            'hunter_time.hunter_time_name'
        )
        ->leftJoin('hunter_pos', 'hunter_pos.hunter_pos_id', 'hunter_registration.hunter_regis_pos')
        ->leftJoin('hunter_time', 'hunter_time.hunter_time_id', 'hunter_registration.hunter_regis_time')
        ->leftJoin('hunter_price', 'hunter_price.hunter_price_id', 'hunter_registration.hunter_regis_price')
        ->where('hunter_registration.hunter_regis_id', $hunter_regis_id)
        ->first();
        $time = preg_replace('/[^0-9]/', '', $hunter->hunter_time_name);
        $hunter->time = (int)$time;
        return $hunter;
    }
}
