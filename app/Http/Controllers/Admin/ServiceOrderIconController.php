<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Service_order_icon;
use App\Entity\Service_icon;
use App\Entity\Employer;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceOrderIconController extends AdminController
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
    public function index(){
        $service_order_icons = Service_order_icon::get();
        return view('admin.service_order_icon.index',compact('service_order_icons'));
    }

    public function create()
    {
        return view('admin.service_order_icon.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'service_price_id' => 'required',
            'service_icon_id' => 'required',
            'status' => 'required',
        ],[
            'service_price_id.required' => 'Dịch vụ chưa chọn',
            'service_icon_id.required' => 'Icon chưa chọn',
            'status.required' => 'Trạng thái đơn hàng chưa chọn',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_order_icon = new Service_order_icon();
        $service_order_icon_id = $service_order_icon->insertGetId([
            'service_price_id' => $request->service_price_id,
            'service_icon_id' => $request->service_icon_id,
            'service_order_icon_code' => 0,
            'employer_name' => '',
            'employer_phone' => '',
            'employer_email' => '',
            'status' => $request->status,
            'user_id' => Auth::id(),
            'employer_id' => $request->employer_id,
            'service_order_icon_content' => $request->service_order_icon_content,
        ]);
        $order_code = Service_order_icon::where('service_order_icon_id', $service_order_icon_id)->first();
        Service_order_icon::where('service_order_icon_id', $service_order_icon_id)->update([
            'service_order_icon_code' => 'DHIC'.$service_order_icon_id.$request->service_price_id.$request->service_icon_id,
            'service_order_icon_price' => Service_icon::where('service_icon_id', $order_code->service_icon_id)->value('service_icon_price'), 
            'service_order_icon_vat' => Service_icon::where('service_icon_id', $order_code->service_icon_id)->value('service_icon_vat'), 
            'employer_name' => Employer::where('employer_id', $order_code->employer_id)->value('enterprise_name'),  
            'employer_phone' => Employer::where('employer_id', $order_code->employer_id)->value('phone'),  
            'employer_email' => Employer::where('employer_id', $order_code->employer_id)->value('email'),  
        ]);
        return redirect()->route('service_order_icon.index')->with('success','Tạo thành công đơn hàng icon');
    }
    public function edit($id)
    {
        $service_order_icon = Service_order_icon::findOrFail($id);
        return view('admin.service_order_icon.edit',compact('service_order_icon'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'service_price_id' => 'required',
            'service_icon_id' => 'required',
            'status' => 'required',
        ],[
            'service_price_id.required' => 'Dịch vụ chưa chọn',
            'service_icon_id.required' => 'Icon chưa chọn',
            'status.required' => 'Trạng thái đơn hàng chưa chọn',
        ]);
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_order_icon = Service_order_icon::findOrFail($id);
        $data = [];
        $data['service_price_id'] = $request->service_price_id;
        $data['service_icon_id'] = $request->service_icon_id;
        $data['service_order_icon_code'] = 'DHIC'.$service_order_icon->service_order_icon_id.$request->service_price_id.$request->service_icon_id;
        $data['status'] = $request->status;
        $data['user_id'] = Auth::id();
        $data['service_order_icon_content'] = $request->service_order_icon_content;
        $service_order_icon->update($data);
        return redirect()->route('service_order_icon.index')->with('success','Sửa thành công order icon');
    }

    public function destroy($id)
    {
        Service_order_icon::findOrFail($id)->delete();   
        return redirect()->route('service_order_icon.index')->with('success','Xóa thành công order icon');
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
        return view('admin.service_order_icon.list_employer', compact('employers', 'total'));
    }
}
