<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Service_price;
use App\Entity\Order_interactive;
use App\Entity\Service_order;
use App\Entity\Employer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Entity\Service_table_price;
use App\Entity\Hunter_registration;
use App\Entity\Service_order_icon;
use Illuminate\Support\Facades\DB;

class ServiceOrderController extends SiteStaffController
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
        $order_interactive1 = Order_interactive::join('service_order', 'service_order.service_order_id', 'order_interactive.order_id')
                ->whereNull('service_order.deleted_at')
                ->where('order_interactive.type_order', 1)->distinct('order_interactive.order_id')->pluck('order_interactive.order_id')->toArray();

        $service_order = Service_order::whereNull('deleted_at')->pluck('service_order_id')->toArray();
        $a = array_diff($service_order, $order_interactive1);

        $list_prices = Service_price::where('service_price_type', 0)->get();
        $service_orders = new Service_order();
        if(!empty($request->service_price)){
            $service_orders = $service_orders->where('service_price_id', $request->service_price);
        }
        if(!empty($request->service_order_id)){
            $service_orders = $service_orders->where('service_order_id', $request->service_order_id);
        }
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            // dd($date_search_start);
            $service_orders = $service_orders->whereDate('created_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $service_orders = $service_orders->whereDate('created_at', '<=', $request->date_search_end);
        }
        if(!empty($request->name)){
            $service_orders = $service_orders->where('employer_name', 'like', '%'.$request->name.'%');
        }
        if(!empty($request->email)){
            $service_orders = $service_orders->where('employer_email', 'like', '%'.$request->email.'%');
        }
        if(!empty($request->number_phone)){
            $service_orders = $service_orders->where('employer_phone', 'like', '%'.$request->number_phone.'%');
        }
        if(isset($request->not_interactive)){
            $service_orders = $service_orders->whereIn('service_order_id', $a);
        }
        switch (url()->current()) {
            case route('staff_service_order_status1'):
                $service_orders = $service_orders->where('status', 1);
                break;
        }
        $num = 20;
        if(isset($request->num)){
            $num = $request->num;
        }
        $total = $service_orders->count();
        $service_orders = $service_orders->orderBy('service_order_id','DESC')->paginate($num);
        $service_orders->appends(request()->query());
        return view('staff_admin.service_order.list',compact('service_orders', 'list_prices','total'));
    }
    public function delete_order(Request $request)
    {

        // $order_interactive1 = Order_interactive::join('service_order', 'service_order.service_order_id', 'order_interactive.order_id')
        //         ->whereNull('service_order.deleted_at')
        //         ->where('order_interactive.type_order', 1)->distinct('order_interactive.order_id')->pluck('order_interactive.order_id')->toArray();

        // $service_order = Service_order::whereNull('deleted_at')->pluck('service_order_id')->toArray();
        // $a = array_diff($service_order, $order_interactive1);

        // $list_prices = Service_price::where('service_price_type', 0)->get();
        $service_orders = new Service_order();
        if(!empty($request->service_price)){
            $service_orders = $service_orders->where('service_price_id', $request->service_price);
        }
        if(!empty($request->service_order_id)){
            $service_orders = $service_orders->where('service_order_id', $request->service_order_id);
        }
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            // dd($date_search_start);
            $service_orders = $service_orders->whereDate('created_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $service_orders = $service_orders->whereDate('created_at', '<=', $request->date_search_end);
        }
        if(!empty($request->name)){
            $service_orders = $service_orders->where('employer_name', 'like', '%'.$request->name.'%');
        }
        if(!empty($request->email)){
            $service_orders = $service_orders->where('employer_email', 'like', '%'.$request->email.'%');
        }
        if(!empty($request->number_phone)){
            $service_orders = $service_orders->where('employer_phone', 'like', '%'.$request->number_phone.'%');
        }
        // if(isset($request->not_interactive)){
        //     $service_orders = $service_orders->whereIn('service_order_id', $a);
        // }
        $num = 20;
        if(isset($request->num)){
            $num = $request->num;
        }
        $total = $service_orders->count();
        $service_orders = $service_orders->onlyTrashed();
        $service_orders = $service_orders->orderBy('service_order_id','DESC')->paginate($num);
        $service_orders->appends(request()->query());
        return view('staff_admin.service_order.delete_order',compact('service_orders', 'list_prices','total'));
    }

    public function delete_order_hard($id)
    {
        Service_order::where('service_order_id', $id)->forceDelete();
        return redirect()->back()->with('success','Xóa hẳn thành công !!!');

    }

    public function delete_order_restore($id)
    {
        Service_order::withTrashed()->where('service_order_id', $id)->restore();
        return redirect()->back()->with('success','Khôi phục thành công');
    }

    public function delete_all_hard_service_order(Request $request)
    {
        $ids = $request->ids;
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {

            Service_order::where('service_order_id', $arrid)->forceDelete();
            Order_interactive::where('order_id', $arrid)->forceDelete();

        }

        return response()->json(['success'=>"Xóa hẳn thành công !!!"]);
    }

    public function general_order(){
        $service_orders = Service_order::get();
        $hunter_orders = Hunter_registration::leftJoin('hunter_pos','hunter_pos.hunter_pos_id','hunter_registration.hunter_regis_pos')
        ->leftJoin('hunter_time','hunter_time.hunter_time_id','hunter_registration.hunter_regis_time')
        ->leftJoin('hunter_price','hunter_price.hunter_price_id','hunter_registration.hunter_regis_price')
        ->select('hunter_registration.*','hunter_pos.hunter_pos_name','hunter_time.hunter_time_name','hunter_price.hunter_price_name')->get();
        $service_order_icons = Service_order_icon::get();
        $allItems = new \Illuminate\Database\Eloquent\Collection;
        $allItems = $allItems->merge($service_orders);
        $allItems = $allItems->merge($hunter_orders);
        $allItems = $allItems->merge($service_order_icons);
        // dd($allItems);
        $total = $allItems->count();
        return view('staff_admin.service_order.general_order',compact('allItems','total'));

    }

    public function create()
    {
        return view('staff_admin.service_order.create_service_order');
    }

    public function task_status(Request $request)
    {
        Service_order::where('service_order_id', $request->service_order_id)->update([
            'status' => $request->status,
            'service_order_content' => $request->note
        ]);
        return back()->withSuccess('Thanh toán thành công!');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'service_price_id' => 'required',
            'service_table_price_id' => 'required',
            'status' => 'required',
        ],[
            'service_price_id.required' => 'Dịch vụ chưa chọn',
            'service_table_price_id.required' => 'Gói dịch vụ chưa chọn',
            'status.required' => 'Trạng thái đơn hàng chưa chọn',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_order = new Service_order();
        $service_order_id = $service_order->insertGetId([
            'service_price_id' => $request->service_price_id,
            'service_table_price_id' => $request->service_table_price_id,
            'service_order_code' => 0,
            'employer_name' => '',
            'employer_phone' => '',
            'employer_email' => '',
            'status' => $request->status,
            'user_id' => Auth::id(),
            'employer_id' => $request->employer_id,
            'created_at' => date('Y-m-d H:i:s'),
            'service_order_content' => $request->service_order_content,
        ]);
        $order_code = Service_order::where('service_order_id', $service_order_id)->first();
        Service_order::where('service_order_id', $service_order_id)->update([
            'service_order_code' => 'DH'.$service_order_id.$request->service_price_id.$request->service_table_price_id,
            'service_order_price' => Service_table_price::where('service_table_price_id', $order_code->service_table_price_id)->value('package_price'),
            'service_order_discount' => Service_table_price::where('service_table_price_id', $order_code->service_table_price_id)->value('package_discount'),
            'service_order_vat' => Service_table_price::where('service_table_price_id', $order_code->service_table_price_id)->value('package_vat'),
            'service_order_benifit' => Service_table_price::where('service_table_price_id', $order_code->service_price_id)->value('benifit'),
            'service_order_endow' => Service_table_price::where('service_table_price_id', $order_code->service_price_id)->value('endow'),
            'employer_name' => Employer::where('employer_id', $order_code->employer_id)->value('enterprise_name'),
            'employer_phone' => Employer::where('employer_id', $order_code->employer_id)->value('phone'),
            'employer_email' => Employer::where('employer_id', $order_code->employer_id)->value('email'),
        ]);
        return redirect()->route('staff_service_order.index')->with('success','Tạo thành công order');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $service_order = Service_order::findOrFail($id);
        return view('staff_admin.service_order.edit',compact('service_order'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'service_price_id' => 'required',
            'service_table_price_id' => 'required',
            'status' => 'required',
        ],[
            'service_price_id.required' => 'Dịch vụ chưa chọn',
            'service_table_price_id.required' => 'Gói dịch vụ chưa chọn',
            'status.required' => 'Trạng thái đơn hàng chưa chọn',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_order = Service_order::findOrFail($id);
        $data = [];
        $data['service_price_id'] = $request->service_price_id;
        $data['service_table_price_id'] = $request->service_table_price_id;
        $data['service_order_code'] = 'DH'.$service_order->service_order_id.$request->service_price_id.$request->service_table_price_id;
        $data['status'] = $request->status;
        $data['user_id'] = Auth::id();
        $data['created_date'] = date('Y-m-d');
        $data['service_order_content'] =  $request->service_order_content;
        $service_order->update($data);
        return redirect()->route('staff_service_order.index')->with('success','Sửa thành công order');
    }


    public function destroy($id)
    {
        //
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {

            Service_order::where('service_order_id', $arrid)->delete();
            Order_interactive::where('order_id', $arrid)->delete();

        }

        return response()->json(['success'=>"Xóa thành công!!!"]);
    }
    public function deleteAllGeneral(Request $request)
    {
        $ids = $request->ids;
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {
            Service_order::where('service_order_code', $arrid)->delete();
        }
        foreach ($arrids as $arrid) {
            Hunter_registration::where('hunter_regis_code', $arrid)->delete();
        }
        foreach ($arrids as $arrid) {
            Service_order_icon::where('service_order_icon_code', $arrid)->delete();
        }
        return response()->json(['success'=>"Products Deleted successfully."]);
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
        // if(isset($employers->created_at)){
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
        // }
        // else {
        //     if(!empty($request->date_search_start) ){
        //         $date_start=date_create($request->date_search_start);
        //         $date_search_start = date_format($date_start,"Y/m/d");
        //         // dd($date_search_start);
        //         $employers = $employers->whereDate('employer.updated_at', '>=', $request->date_search_start);
        //     }
        //     if(!empty($request->date_search_end)){
        //         $date_end=date_create($request->date_search_end);
        //         $date_search_end = date_format($date_end,"Y/m/d");
        //         $employers = $employers->whereDate('employer.updated_at', '<=', $request->date_search_end);
        //     }
        // }

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
        return view('staff_admin.service_order.list_employer', compact('employers', 'total'));
    }
}
