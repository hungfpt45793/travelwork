<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Service_order;
use App\Entity\Service_table_price;
use App\Entity\Service_price;
use App\Entity\Employer;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceOrderController extends AdminController
{
    protected $role;
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'orders');
            return $next($request);
        });


    }
    public function index(Request $request)
    {
        $list_prices = Service_price::where('service_price_type', 0)->get();
        $service_orders = new Service_order();
        if(isset($request->service_price)){
            $service_orders = $service_orders->where('service_price_id', $request->service_price);
        }
        $service_orders = $service_orders->get();
        return view('admin.service_order.index',compact('service_orders', 'list_prices'));
    }

    

    public function create()
    {
        return view('staff_admin.service_order.list');
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
            'created_date' => date('Y-m-d'),
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
        return redirect()->route('service_order.index')->with('success','Tạo thành công order');
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $service_order = Service_order::findOrFail($id);
        return view('admin.service_order.edit',compact('service_order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        return redirect()->route('service_order.index')->with('success','Sửa thành công order');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service_order::findOrFail($id)->delete();   
        return redirect()->route('service_order.index')->with('success','Xóa thành công order');
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
        $employers = $employers->paginate(30);
        $employers->appends(request()->query());
        return view('admin.service_order.list_employer', compact('employers', 'total'));
    }
}
