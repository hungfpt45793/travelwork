<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Service_order;
use App\Entity\Service_table_price;
use App\Entity\Hunter_registration;
use App\Entity\Hunter_pos;
use App\Entity\Hunter_time;
use App\Entity\Order_interactive;
use App\Entity\Hunter_price;
use App\Entity\Service_price;
use App\Entity\Employer;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HunterOrderController extends SiteStaffController
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

        $order_interactive2 = Order_interactive::join('hunter_registration', 'hunter_registration.hunter_regis_id', 'order_interactive.order_id')
                ->whereNull('hunter_registration.deleted_at')
                ->where('order_interactive.type_order', 2)->distinct('order_interactive.order_id')->pluck('order_interactive.order_id')->toArray();
        
        $total_hunter_order = Hunter_registration::whereNull('deleted_at')->pluck('hunter_regis_id')->toArray();
        $a = array_diff($total_hunter_order, $order_interactive2);

        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        $hunter_orders = Hunter_registration::leftJoin('hunter_pos','hunter_pos.hunter_pos_id','hunter_registration.hunter_regis_pos')
        ->leftJoin('hunter_time','hunter_time.hunter_time_id','hunter_registration.hunter_regis_time')
        ->leftJoin('hunter_price','hunter_price.hunter_price_id','hunter_registration.hunter_regis_price')
        ->select('hunter_registration.*','hunter_pos.hunter_pos_name','hunter_time.hunter_time_name','hunter_price.hunter_price_name');
        if(!empty($request->hunter_regis_status)){
            if($request->hunter_regis_status==2){
                $hunter_regis_status = 0;
            }
            else $hunter_regis_status = 1;
            $hunter_orders = $hunter_orders->where('hunter_registration.hunter_regis_status', $hunter_regis_status );
        }
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            // dd($date_search_start);
            $hunter_orders = $hunter_orders->whereDate('hunter_registration.created_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $hunter_orders = $hunter_orders->whereDate('hunter_registration.created_at', '<=', $request->date_search_end);
        }
        
        if(!empty($request->name)){
            $hunter_orders = $hunter_orders->where('hunter_registration.hunter_regis_name', 'like', '%'.$request->name.'%');
        }
        if(!empty($request->email)){
            $hunter_orders = $hunter_orders->where('hunter_registration.hunter_regis_email', 'like', '%'.$request->email.'%');
        }
        if(!empty($request->number_phone)){
            $hunter_orders = $hunter_orders->where('hunter_registration.hunter_regis_phone', 'like', '%'.$request->number_phone.'%');
        }
        if(isset($request->not_interactive)){
            $hunter_orders = $hunter_orders->whereIn('hunter_regis_id', $a);
        }
        $total = $hunter_orders->count();
        $hunter_orders = $hunter_orders->orderBy('hunter_registration.created_at','DESC');
        $hunter_orders = $hunter_orders->paginate($num);
        $hunter_orders->appends(request()->query());
        return view('staff_admin.hunter_order.list',compact('hunter_orders','total'));
    }
    public function edit($id)
    {
        $hunter_order = Hunter_registration::findOrFail($id);

        $hunters_pos = Hunter_pos::get();
        $hunters_time = Hunter_time::orderBy('hunter_time_id', 'ASC')->get();
        $employer_id = $hunter_order->employer_id;
        return view('staff_admin.hunter_order.edit',compact('hunter_order','employer_id','hunters_pos','hunters_time'));
    }
    public function update(Request $request, $id)
    {

        $user_id = Auth::id();
        $employer_id = $request->employer_id;
        $hunter_price_id = $request->hunter_regis_price;
        $hunter_regis_price = Hunter_price::where('hunter_price_id', $hunter_price_id)->first();
        $hunter_pos_id = $hunter_regis_price->hunter_pos_id;
        $hunter_time_id = $hunter_regis_price->hunter_time_id;
        $hunter_order = Hunter_registration::findOrFail($id);
        $data=[];
        $data['hunter_regis_pos'] = $hunter_pos_id;
        $data['hunter_regis_time'] = $hunter_time_id;
        $data['hunter_regis_price'] = $hunter_price_id;
        $data['hunter_regis_name'] = $request->hunter_regis_name;
        $data['hunter_regis_email'] = $request->hunter_regis_email;
        $data['hunter_regis_phone'] = $request->hunter_regis_phone;
        $data['hunter_regis_province'] = $request->hunter_regis_province; 
        $data['hunter_regis_district'] = $request->hunter_regis_district;
        $data['hunter_regis_address'] = $request->hunter_regis_address;
        $data['hunter_regis_note'] = $request->hunter_regis_note;
        $data['hunter_regis_status']= $request->hunter_regis_status;
        $data['user_id']= $user_id;
        $data['employer_id']=$employer_id;
        $hunter_order->update($data);
        return redirect()->route('staff_hunter_order.index')->with('success','Sửa đơn hàng thành công');
    }
    public function list_employer(Request $request){
        $employers = new Employer();
        $employers = $employers->leftJoin('employer_typeof_business', 'employer_typeof_business.employer_id', '=', 'employer.employer_id');
        $employers = $employers->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'employer.business');
        $employers = $employers->leftJoin('users', 'users.id', 'employer.user_id');
        $employers = $employers->leftJoin('business_type', 'business_type.business_type_id', '=', 'employer.type_of_business_id');
        $employers = $employers->leftJoin('employer_agency', 'employer_agency.employer_id', '=', 'employer.employer_id');
        //            ->leftJoin('type_of_business','type_of_business.type_of_business_id','=','employer_typeof_business.type_of_business_id')
        $employers = $employers->select(
            'employer.*'
        );
            if(!empty($request->date_search_start) ){
                $date_start=date_create($request->date_search_start);
                $date_search_start = date_format($date_start,"Y/m/d");
                // dd($date_search_start);
                $employers = $employers->whereDate('employer.created_at', '>=', $request->date_search_start);
            }
            if(!empty($request->date_search_end)){
                $date_end=date_create($request->date_search_end);
                $date_search_end = date_format($date_end,"Y/m/d");
                $employers = $employers->whereDate('employer.created_at', '<=', $request->date_search_end);
            }
        
        if (!empty($request->input('business'))) {
            $business = $request->input('business');
            $employers = $employers->where('employer.business', $business);
        }
        if (!empty($request->input('type_of_business_id'))) {
            $type_of_business_id = $request->input('type_of_business_id');
            $employers = $employers->where('employer.type_of_business_id', $type_of_business_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employers = $employers->where('employer.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employers = $employers->where('employer.district', $district);
        }
        if (!empty($request->input('enterprise_name'))) {
            $enterprise_name = $request->input('enterprise_name');
            $employers = $employers->where('enterprise_name', 'like', '%' . $enterprise_name . '%');
        }
        if (!empty($request->input('email'))) {

            $email = $request->input('email');
            $employers = $employers->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('status_intership'))) {
            $status_intership = $request->input('status_intership');
            $employers = $employers->where('employer.status_intership', $status_intership);
        }
        if (!empty($request->input('status_agency'))) {
            $status_agency = $request->input('status_agency');
            $employers = $employers->where('employer.status_agency', $status_agency);
        }
        if (!empty($request->is_delete)) {
            // return 3;
            $id = [];
            $ls = Employer_delete_request::get();
            foreach ($ls as $l) {
                $id[] = $l->employer_id;
            }
            if ($request->is_delete == 1) {
                // return 1;
                $employers->whereNotIn('employer.employer_id', $id);
            }
            if ($request->is_delete == 2) {
                // return 2;
                $employers->whereIn('employer.employer_id', $id);
            }
        }
        $total = $employers->count();

        $employers = $employers->orderBy('employer.employer_id', 'desc');
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        $employers = $employers->paginate($num);
        $employers->appends(request()->query());
        return view('staff_admin.hunter_order.list_employer', compact('employers', 'total'));
    }
    public function create()
    {
        $employer = Employer::where('employer_id', $_GET['employer_id'])->first();
        $hunters_pos = Hunter_pos::get();
        $hunters_time = Hunter_time::orderBy('hunter_time_id', 'ASC')->get();
        $employer_id = $_GET['employer_id'];
        return view('staff_admin.hunter_order.create_hunter_order', compact('employer','hunters_pos','hunters_time','employer_id'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'hunter_regis_pos' => 'required',
            'hunter_regis_time' => 'required',
            'hunter_regis_name' => 'required',
            'hunter_regis_phone' => 'required',
            'hunter_regis_email' => 'required',
            'hunter_regis_province' => 'required',
            'hunter_regis_district' => 'required',
            'hunter_regis_address' => 'required',
        ],[
            'hunter_regis_pos.required' => 'Vị trí cần tuyển dụng chưa nhập',
            'hunter_regis_time.required' => 'Thời gian tuyển dụng chưa nhập',
            'hunter_regis_name.required' => 'Tên tuyển dụng chưa nhập',
            'hunter_regis_phone.required' => 'SĐT nhà tuyển dụng chưa nhập',
            'hunter_regis_email.required' => 'Email nhà tuyển dụng chưa nhập',
            'hunter_regis_province.required' => 'Chưa chọn tỉnh thành',
            'hunter_regis_district.required' => 'Chưa chọn quận huyện',
            'hunter_regis_address.required' => 'Địa chỉ nhà tuyển dụng chưa nhập',
        ]);
        
        $hunter_regis = new Hunter_registration();
        $user_id = Auth::id();
        $employer_id = $request->employer_id;
        $hunter_price_id = $request->hunter_regis_price;
        $hunter_regis_price = Hunter_price::where('hunter_price_id', $hunter_price_id)->first();
        $hunter_pos_id = $hunter_regis_price->hunter_pos_id;
        $hunter_time_id = $hunter_regis_price->hunter_time_id;

        $hunter_regis_id = $hunter_regis->insertGetId([
            'hunter_regis_pos' => $hunter_pos_id,
            'hunter_regis_time' => $hunter_time_id,
            'hunter_regis_price' => $hunter_price_id,
            'hunter_regis_name' => $request->hunter_regis_name,
            'hunter_regis_email' => $request->hunter_regis_email,
            'hunter_regis_phone' => $request->hunter_regis_phone,
            'hunter_regis_province' => $request->hunter_regis_province, 
            'hunter_regis_district' => $request->hunter_regis_district,
            'hunter_regis_address' => $request->hunter_regis_address,
            'hunter_regis_note' => $request->hunter_regis_note,
            'hunter_regis_code'=> 0,
            'hunter_regis_status'=> $request->hunter_regis_status,
            'user_id'=> $user_id,
            'employer_id'=>$employer_id,
        ]);
        if($hunter_regis_id < 10){
            $hunter_regis_code = 'TD10000'.$hunter_regis_id;
        }
        elseif($hunter_regis_id >= 10 && $hunter_regis_id < 100){
            $hunter_regis_code = 'TD1000'.$hunter_regis_id;
        }
        elseif($hunter_regis_id >= 100 && $hunter_regis_id < 1000){
            $hunter_regis_code = 'TD100'.$hunter_regis_id;
        }
        elseif($hunter_regis_id >= 1000 && $hunter_regis_id < 10000){
            $hunter_regis_code = 'TD10'.$hunter_regis_id;
        }
        else $hunter_regis_code = 'TD1'.$hunter_regis_id;
        Hunter_registration::where('hunter_regis_id', $hunter_regis_id)->update([
            'hunter_regis_code'=>$hunter_regis_code,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->route('staff_hunter_order.index')->with('success','Thêm mới đơn hàng thành công');
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;   
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {
            Hunter_registration::where('hunter_regis_code', $arrid)->delete();
        }
       
        return response()->json(['success'=>"Products Deleted successfully."]);
    }

    public function get_employer_select2(Request $request)
    {
        $search  = trim($request->search);
        $page = !empty($request->page) ? $request->page : 1;
        $resultCount = 50;
        $offset = ($page - 1) * $resultCount;
        if($search == ''){
            $employers = Employer::select('employer_id','email', 'enterprise_name')->latest()->skip($offset)->take($resultCount)->get();
            $count = Employer::select('employer_id','email', 'enterprise_name')->get()->count();
         }else{
            $employers = Employer::select('employer_id','email', 'enterprise_name')->latest()->where('email', 'like', '%' .$search . '%')
            ->orWhere('enterprise_name', 'like', '%' .$search . '%')
            ->skip($offset)->take($resultCount)->get();
            $count = Employer::select('employer_id','email', 'enterprise_name')
            ->where('email', 'like', '%' .$search . '%')->get()->count();
        }

        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;
   
         $response = array();
         foreach($employers as $employer){
            $response[$employer->employer_id] = array(
                 "id"=>$employer->employer_id,
                 "text"=>$employer->email . '-' . $employer->enterprise_name
            );
         }
        echo (json_encode([
            'result' => $response,
            'search' => $search,
            "pagination" => ["more" => $morePages]
        ]));
        exit;

    }
}