<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Service_price;
use App\Entity\Service_table_price;
use App\Entity\Service_bank;
use App\Entity\Hunter_registration;
use App\Entity\Service_comment;
use App\Entity\Service_order;
use App\Entity\Service_order_icon;
use App\Entity\Service_icon;
use App\Entity\Hunter_pos;
use App\Entity\Hunter_time;
use App\Entity\Hunter_price;
use App\Entity\Service_benifit;
use App\Entity\Service_name_benifit;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ListPriceController extends SiteController
{
    public function list_price()
    {
        $service_benifits = Service_benifit::select(
            'service_benifit_id',
            'service_benifit_name'
        )
            ->distinct()
            ->orderBy('service_benifit_id')
            ->get();
        $service_name_benifits = Service_name_benifit::select(
            'service_name_benifit_id',
            'service_name_benifit_title'
        )
            ->orderBy('service_benifit_id')
            ->get()
            ->groupBy('service_benifit_id');

        $list_prices = Service_price::select(
            'service_price_id',
            'image',
            'service_price_title',
            'service_price_slug',
            'feature'
        )
            ->where('service_price_type', 0)
            ->get();
        $list_prices_dif = Service_price::select(
            'service_price_id',
            'image',
            'service_price_title',
            'service_price_slug',
            'feature'
        )
            ->where('service_price_type', 2)
            ->get();
        $hunters_pos = Hunter_pos::select(
            'hunter_pos_id',
            'hunter_pos_name'
        )
            ->get();
        $hunters_time = Hunter_time::select(
            'hunter_time_id',
            'hunter_time_name',
            'hunter_time_name_small'
        )
            ->orderBy('hunter_time_id', 'ASC')
            ->get();


        return view('site.default_site.list_price', compact('service_name_benifits', 'service_benifits', 'list_prices', 'list_prices_dif', 'hunters_pos', 'hunters_time'));
    }
    public function list_price_free()
    {
        $service_benifits = Service_benifit::select(
            'service_benifit_id',
            'service_benifit_name'
        )
            ->distinct()
            ->orderBy('service_benifit_id')
            ->get();
        $service_name_benifits = Service_name_benifit::select(
            'service_name_benifit_id',
            'service_name_benifit_title'
        )
            ->orderBy('service_benifit_id')
            ->get()
            ->groupBy('service_benifit_id');

        $list_prices = Service_price::select(
            'service_price_id',
            'image',
            'service_price_title',
            'service_price_slug',
            'feature'
        )
            ->where('service_price_type', 0)
            ->get();
        $list_prices_dif = Service_price::select(
            'service_price_id',
            'image',
            'service_price_title',
            'service_price_slug',
            'feature'
        )
            ->where('service_price_type', 2)
            ->get();
        $hunters_pos = Hunter_pos::select(
            'hunter_pos_id',
            'hunter_pos_name'
        )
            ->get();
        $hunters_time = Hunter_time::select(
            'hunter_time_id',
            'hunter_time_name',
            'hunter_time_name_small'
        )
            ->orderBy('hunter_time_id', 'ASC')
            ->get();


        return view('site.default_site.list_price_pree', compact('service_name_benifits', 'service_benifits', 'list_prices', 'list_prices_dif', 'hunters_pos', 'hunters_time'));
    }


    public function detail_list_price($slug)
    {
//        echo 1;die;
        $service_benifits = Service_benifit::distinct()->orderBy('service_benifit_id')->get();
        $service_name_benifits = Service_name_benifit::orderBy('service_benifit_id')->get()->groupBy('service_benifit_id');

        $list_prices = Service_price::where('service_price_type', 0)->get();
        $service_price_title = Service_price::where('service_price_slug', $slug)->value('service_price_title');
        $name = mb_strtolower($service_price_title);
        $list_prices_dif = Service_price::where('service_price_type', 2)->get();
        $hunters_pos = Hunter_pos::get();
        $hunters_time = Hunter_time::orderBy('hunter_time_id', 'ASC')->get();
        $list_price = Service_price::where('service_price_slug', $slug)->first();
//        print_r($service_price_title);
//        print_r($list_prices_dif);
//        print_r($hunters_pos);
//        print_r($hunters_time);die;
//        return view('site.default.detail_list_price', compact('name', 'slug', 'service_name_benifits', 'service_benifits', 'list_prices', 'list_prices_dif', 'hunters_pos', 'hunters_time'));
        return view('site.default_site.detail_list_price', compact('name', 'slug', 'service_name_benifits', 'service_benifits', 'list_prices', 'list_prices_dif', 'hunters_pos', 'hunters_time','list_price'));
    }

    static function getHunterPrice($hunter_pos_id)
    {
        return $hunters_price = Hunter_price::select(
            'hunter_price_id',
            'hunter_price_name',
            'hunter_pos_id',
            'hunter_time_id'
        )
            ->where('hunter_pos_id', $hunter_pos_id
            )->orderBy('hunter_time_id', 'ASC')
            ->get();
    }
    static function getHunterPrice_day($hunter_pos_id,$hunter_time_id)
    {
        return $hunters_price = Hunter_price::select(
            'hunter_price_id',
            'hunter_price_name',
            'hunter_price',
            'hunter_pos_id',
            'hunter_time_id'
        )
            ->where('hunter_pos_id', $hunter_pos_id)
            ->where('hunter_time_id', $hunter_time_id)
            ->first();
    }

    public function pay_price(Request $request)
    {
        $service_price = Service_price::where('service_price_id', $request->service)
            ->select('service_price_id', 'service_price_title')
            ->first();
        $service_table_price = Service_table_price::where('service_table_price_id', $request->service_package)
            ->select('service_table_price_id', 'package_name', 'package_price', 'package_vat', 'package_discount')
            ->first();
        return view('site.default.pay_price', compact('service_price', 'service_table_price'));
    }

    public function pay_icon(Request $request)
    {
        $service_price = Service_price::where('service_price_id', $request->service)->select('service_price_id', 'service_price_title')->first();
        $service_icon = Service_icon::where('service_icon_id', $request->icon)->select('service_icon_id', 'service_icon_name', 'service_icon_price', 'service_icon_vat')->first();
        return view('site.default.pay_icon', compact('service_price', 'service_icon'));
    }

    public function save_order_icon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employer_name' => 'required',
            'employer_phone' => 'required',
            'employer_email' => 'required',
        ], [
            'employer_name.required' => 'Tên nhà tuyển dụng chưa nhập',
            'employer_phone.required' => 'SĐT nhà tuyển dụng chưa nhập',
            'employer_email.required' => 'Email nhà tuyển dụng chưa nhập',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $service_order_icon = new Service_order_icon();
        if (Auth::check() && Auth::user()->role != 2) {
            $employer_id = 0;
            $user_id = Auth::id();
        } elseif (Auth::check() && Auth::user()->role == 2) {
            $user_id = 0;
            $employer = \App\Entity\Employer::where('user_id', Auth::id())->first();
            $employer_id = $employer->employer_id;
        } else {
            $employer_id = 0;
            $user_id = 0;
        }

        $service_order_icon_id = $service_order_icon->insertGetId([
            'service_price_id' => $request->service_price_id,
            'service_icon_id' => $request->service_icon_id,
            'service_price_id' => $request->service_price_id,
            'service_order_icon_code' => 0,
            'status' => 0,
            'employer_name' => $request->employer_name,
            'employer_phone' => $request->employer_phone,
            'employer_email' => $request->employer_email,
            'service_order_icon_price' => Service_icon::where('service_icon_id', $request->service_icon_id)->value('service_icon_price'),
            'service_order_icon_vat' => Service_icon::where('service_icon_id', $request->service_icon_id)->value('service_icon_vat'),
            'employer_id' => $employer_id,
            'user_id' => $user_id,
            'service_order_icon_content' => $request->service_order_icon_content,
        ]);
        Service_order_icon::where('service_order_icon_id', $service_order_icon_id)->update([
            'service_order_icon_code' => 'DHIC' . $service_order_icon_id . $request->service_price_id . $request->service_icon_id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $order_code = Service_order_icon::where('service_order_icon_id', $service_order_icon_id)->first();

        return redirect(route('bank_price', ["order_code" => $order_code->service_order_icon_code, "service_price" => $request->service_price_id, "service_order_icon_price" => $request->service_order_icon_price]))->with('success', 'Cảm ơn bạn tin tưởng sử dụng dịch vụ của chúng tôi, hệ thống sẽ sớm liên lạc với bạn');
    }

    public function bank_price(Request $request)
    {
        $pay_prices2first = Service_bank::skip(0)->take(2)->get();
        $pay_prices2next = Service_bank::skip(2)->take(2)->get();
        $pay_pricesend = Service_bank::skip(4)->take(10)->get();
        $service_price = Service_price::where('service_price_id', $request->service)->select('service_price_id', 'service_price_title')->first();
        $service_table_price = Service_table_price::where('service_table_price_id', $request->service_package)->select('service_table_price_id', 'package_name')->first();
        return view('site.default.bank_price', compact('pay_prices2first', 'pay_prices2next', 'pay_pricesend', 'service_price', 'service_table_price'));
    }

    public function save_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employer_name' => 'required',
            'employer_phone' => 'required',
            'employer_email' => 'required|email',
            // 'g-recaptcha-response' => 'required',
        ], [
            'employer_name.required' => 'Tên nhà tuyển dụng chưa nhập',
            'employer_phone.required' => 'SĐT nhà tuyển dụng chưa nhập',
            'employer_email.required' => 'Email nhà tuyển dụng chưa nhập',
            'employer_email.email' => 'Vui lòng nhập đúng định dạng email',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy hoặc  Im not a robot',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service_order = new Service_order();
        if (Auth::check() && Auth::user()->role != 2) {
            $employer_id = 0;
            $user_id = Auth::id();
        } elseif (Auth::check() && Auth::user()->role == 2) {
            $user_id = 0;
            $employer = \App\Entity\Employer::where('user_id', Auth::id())->first();
            $employer_id = $employer->employer_id;
        } else {
            $employer_id = 0;
            $user_id = 0;
        }
        $ip_order = Ultility::get_client_ip();
        $day_date = new \DateTime();
        //nếu bài viết không bật chức năng chia sẻ kiếm tiền
        $total_order = $service_order->where('ip_order', $ip_order)
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->count();
        if($total_order < 3)
        {
//            echo $total_order;die;
            $service_order_id = $service_order->insertGetId([
                'service_price_id' => $request->service_price_id,
                'service_table_price_id' => $request->service_table_price_id,
                'service_order_code' => 0,
                'employer_name' => $request->employer_name,
                'employer_phone' => $request->employer_phone,
                'employer_email' => $request->employer_email,
                'tax_code' => !empty($request->tax_code) ? $request->tax_code : '',
                'service_order_price' => Service_table_price::where('service_table_price_id', $request->service_table_price_id)->value('package_price'),
                'service_order_discount' => Service_table_price::where('service_table_price_id', $request->service_table_price_id)->value('package_discount'),
                'service_order_vat' => Service_table_price::where('service_table_price_id', $request->service_table_price_id)->value('package_vat'),
                'service_order_benifit' => Service_table_price::where('service_table_price_id', $request->service_table_price_id)->value('benifit'),
                'service_order_endow' => Service_table_price::where('service_table_price_id', $request->service_table_price_id)->value('endow'),
                'employer_id' => $employer_id,
                'user_id' => $user_id,
                'ip_order' => $ip_order
                //'service_order_content' => $request->service_order_content,
            ]);
            Service_order::where('service_order_id', $service_order_id)->update([
                'service_order_code' => 'DH' . $service_order_id . $request->service_price_id . $request->service_table_price_id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $order_code = Service_order::where('service_order_id', $service_order_id)->first();

            if(!empty($request->employer_email))
            {
                $send_email = MailConfigController::send_service_employer($service_order_id,$request->employer_email);
            }

            return redirect(route('bank_price', ["order_code" => $order_code->service_order_code, "service_price" => $request->service_price_id, "service_table_price" => $request->service_table_price_id]))->with('success', 'Cảm ơn bạn tin tưởng sử dụng dịch vụ của chúng tôi, hệ thống sẽ sớm liên lạc với bạn');
        }
        return redirect()->back()->with('success', 'Bạn đã đăng ký dịch vụ này rồi, hệ thống sẽ sớm liên lạc với bạn');

    }

    public function registration_hunter()
    {
        return view('site.default.registration_hunter');
    }

    public function save_registration_hunter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hunter_regis_pos' => 'required',
            'hunter_regis_time' => 'required',
            'hunter_regis_name' => 'required',
            'hunter_regis_phone' => 'required',
            'hunter_regis_email' => 'required',
            // 'hunter_regis_province' => 'required',
            // 'hunter_regis_district' => 'required',
            'hunter_regis_address' => 'required',
            'g-recaptcha-response' => 'required'
        ], [
            'hunter_regis_pos.required' => 'Vị trí cần tuyển dụng chưa nhập',
            'hunter_regis_time.required' => 'Thời gian tuyển dụng chưa nhập',
            'hunter_regis_name.required' => 'Tên tuyển dụng chưa nhập',
            'hunter_regis_phone.required' => 'SĐT nhà tuyển dụng chưa nhập',
            'hunter_regis_email.required' => 'Email nhà tuyển dụng chưa nhập',
            // 'hunter_regis_province.required' => 'Chưa chọn tỉnh thành',
            // 'hunter_regis_district.required' => 'Chưa chọn quận huyện',
            'hunter_regis_address.required' => 'Địa chỉ nhà tuyển dụng chưa nhập',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy hoặc  Im not a robot'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $hunter_regis = new Hunter_registration();

        if (Auth::check() && Auth::user()->role != 2) {
            $employer_id = 0;
            $user_id = Auth::id();
        } elseif (Auth::check() && Auth::user()->role == 2) {
            $user_id = Auth::id();
            $employer = \App\Entity\Employer::where('user_id', Auth::id())->first();
            $employer_id = $employer->employer_id;
        } else {
            $employer_id = 0;
            $user_id = 0;
        }

        $hunter_regis_id = $hunter_regis->insertGetId([
            'hunter_regis_pos' => $request->hunter_regis_pos,
            'hunter_regis_time' => $request->hunter_regis_time,
            'hunter_regis_price' => $request->hunter_regis_price,
            'hunter_regis_name' => $request->hunter_regis_name,
            'hunter_regis_email' => $request->hunter_regis_email,
            'hunter_regis_phone' => $request->hunter_regis_phone,
            'hunter_tax_code' => !empty($request->hunter_tax_code) ? $request->hunter_tax_code : '',
            // 'hunter_regis_province' => $request->hunter_regis_province,
            // 'hunter_regis_district' => $request->hunter_regis_district,
            'hunter_regis_address' => $request->hunter_regis_address,
            'hunter_regis_note' => $request->hunter_regis_note,
            'hunter_regis_code' => 0,
            'user_id' => $user_id,
            'employer_id' => $employer_id,
        ]);
        $hunter_regis_code = 'DH00' . $hunter_regis_id;
        Hunter_registration::where('hunter_regis_id', $hunter_regis_id)->update([
            'hunter_regis_code' => $hunter_regis_code,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $hunter_regis = Hunter_registration::where('hunter_regis_id', $hunter_regis_id)->first();
        if(!empty($request->hunter_regis_email))
        {
            $send_email = MailConfigController::send_order_employer($hunter_regis_id, $request->hunter_regis_email);
        }
        return redirect()->route('bank_price', array('hunter_price_id' => $hunter_regis->hunter_regis_price, 'order_code' => $hunter_regis->hunter_regis_code))->with('success', 'Cảm ơn bạn tin tưởng sử dụng dịch vụ của chúng tôi, hệ thống sẽ sớm liên lạc với bạn');

    }

    public function get_comment(Request $request)
    {
        $service_table_price_id = $request->service_table_price_id;
        $comments = Service_comment::select(
            'service_comment_content',
            'service_comment_image'
        )
            ->where('service_table_price_id', $service_table_price_id)->get();

        return response()->json([
            'comments' => $comments
        ], 200);
    }
}
