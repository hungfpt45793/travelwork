<?php

namespace App\Http\Controllers\Api;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\Service_bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Service_price;
use App\Entity\Service_table_price;
use App\Entity\Service_order;
use App\Entity\Service_name_benifit;
use App\Http\Controllers\Site\MailConfigController;
use Tymon\JWTAuth\Facades\JWTAuth;


class ListPriceController extends Controller
{
    public function list_price()
    {
        //danh sach goi
        $list_prices = Service_price::get_all();

        foreach ($list_prices as $id=>$p)
        {
            $list_prices[$id]['image'] = !empty($p['image']) ?  asset($p['image']) : '';
        }
        //quyen loi dang tin
        $service_name_benifit = Service_name_benifit::get();


        return response([
            'status' => 200,
            'message' => 'Danh sách gói dịch vụ và quyền lợi',
            'list_prices' => $list_prices,
            'service_name_benifit' => $service_name_benifit,
        ],200);
    }


    public function detail_list_price($service_price_id)
    {

        $list_prices = Service_price::where('service_price_id',$service_price_id)->first();
        $list_prices['image'] = !empty($list_prices['image']) ?  asset($list_prices['image']) : '';
        //quyen loi dang tin
        $service_name_benifit = Service_name_benifit::get();

        $table_prices = Service_table_price::getTablePrices($service_price_id);
        return response([
            'status' => 200,
            'message' => 'Danh sách gói dịch vụ và quyền lợi',
            'list_prices' => $list_prices,
            'table_prices' => $table_prices,
            'service_name_benifit' => $service_name_benifit

        ],200);
    }

    public function pay_employer_price(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        $service_price_id = $request->input('service_price_id');
        $service_table_price_id = $request->input('service_table_price_id');
        $service_price = Service_price::where('service_price_id', $service_price_id)
            ->select('service_price_id', 'service_price_title')
            ->first();
        $service_table_price = Service_table_price::where('service_table_price_id', $service_table_price_id)
            ->select('*')
            ->first();

        if(empty($service_table_price))
        {
            return response()->json([
                'status' => 400,
                'message' => 'Không tìm thấy dịch vụ này'
            ], 400);
        }
        if($user->role == 2)
        {
            $employer = Employer::where('user_id',$user->id)->first();
            $service_order = new Service_order();

            $service_order_id = $service_order->insertGetId([
                'service_price_id' => $request->service_price_id,
                'service_table_price_id' => $request->service_table_price_id,
                'service_order_code' => 0,
                'employer_name' => $employer->enterprise_name,
                'employer_phone' => $employer->phone,
                'employer_email' => $employer->email,
                'service_order_price' => $service_table_price->package_price,
                'service_order_discount' => $service_table_price->package_discount,
                'service_order_vat' => $service_table_price->package_vat,
                'service_order_benifit' => $service_table_price->benifit,
                'service_order_endow' => $service_table_price->endow,
                'employer_id' => $employer->employer_id,
                'user_id' => $user->id,
                'service_order_content' => $request->service_order_content,
            ]);
        }
        if($user->role == 1)
        {
            $employee = Employee::where('user_id',$user->id)->first();
            $service_order = new Service_order();

            $service_order_id = $service_order->insertGetId([
                'service_price_id' => $request->service_price_id,
                'service_table_price_id' => $request->service_table_price_id,
                'service_order_code' => 0,
                'employer_name' => $employee->employee_name,
                'employer_phone' => $employee->phone,
                'employer_email' => $employee->email,
                'service_order_price' => $service_table_price->package_price,
                'service_order_discount' => $service_table_price->package_discount,
                'service_order_vat' => $service_table_price->package_vat,
                'service_order_benifit' => $service_table_price->benifit,
                'service_order_endow' => $service_table_price->endow,
                'employer_id' => $employee->employee_id,
                'user_id' => $user->id,
                'service_order_content' => $request->service_order_content,
            ]);
        }

        Service_order::where('service_order_id', $service_order_id)->update([
            'service_order_code' => 'DH' . $service_order_id . $request->service_price_id . $request->service_table_price_id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $order_code = Service_order::where('service_order_id', $service_order_id)->first();

        if(!empty($user->email))
        {
            $send_email = MailConfigController::send_service_employer($service_order_id,$user->email);
        }
        $service_bank = Service_bank::get();
        foreach($service_bank as $id=>$bank)
        {
            $service_bank[$id]['service_bank_image'] = !empty($bank->service_bank_image) ? asset($bank->service_bank_image) : '';
        }
        return response()->json([
            'status' => 200,
            'order_code' => $order_code,
            'service_bank' => $service_bank,
            'message' => 'Đơn hàng của bạn đang được xử lý'
        ], 200);
    }

}
