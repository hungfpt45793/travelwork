<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Entity\Service_order;
use App\Entity\Service_table_price;
use App\Entity\Hunter_registration;
use App\Entity\Hunter_pos;
use App\Entity\Hunter_time;
use App\Entity\Hunter_price;
use App\Entity\Service_price;
use App\Entity\Employer;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HunterOrderController extends AdminController
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
    public function index()
    {
        $hunter_orders = Hunter_registration::leftJoin('hunter_pos','hunter_pos.hunter_pos_id','hunter_registration.hunter_regis_pos')
        ->leftJoin('hunter_time','hunter_time.hunter_time_id','hunter_registration.hunter_regis_time')
        ->leftJoin('hunter_price','hunter_price.hunter_price_id','hunter_registration.hunter_regis_price')
        ->select('hunter_registration.*','hunter_pos.hunter_pos_name','hunter_time.hunter_time_name','hunter_price.hunter_price_name')
        ->get();
        // $hunter_orders->appends(request()->query());
        return view('admin.hunter_order.index',compact('hunter_orders'));
    }

    public function create()
    {
        $employer = Employer::where('employer_id', $_GET['employer_id'])->first();
        $hunters_pos = Hunter_pos::get();
        $hunters_time = Hunter_time::orderBy('hunter_time_id', 'ASC')->get();
        $employer_id = $_GET['employer_id'];
        return view('admin.hunter_order.create', compact('employer','hunters_pos','hunters_time','employer_id'));
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
        return redirect()->route('hunter_order.index')->with('success','Quản trị viên thêm mới đơn hàng thành công');
    }

    
    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $hunter_order = Hunter_registration::findOrFail($id);

        $hunters_pos = Hunter_pos::get();
        $hunters_time = Hunter_time::orderBy('hunter_time_id', 'ASC')->get();
        $employer_id = $hunter_order->employer_id;
        return view('admin.hunter_order.edit',compact('hunter_order','employer_id','hunters_pos','hunters_time'));
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
        return redirect()->route('hunter_order.index')->with('success','Quản trị viên sửa đơn hàng thành công');
    }

    public function destroy($id)
    {
        Hunter_registration::findOrFail($id)->delete();   
        return redirect()->route('hunter_order.index')->with('success','Xóa thành công ');
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
        return view('admin.hunter_order.list_employer', compact('employers', 'total'));
    }
}
