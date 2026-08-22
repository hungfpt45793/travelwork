<?php

namespace App\Http\Controllers\Api;

use App\Entity\Employee;
use App\Entity\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class VoucherController extends Controller
{
    public function show_voucher(Request $request){
        $voucher_model = new Voucher();
        $voucher = $voucher_model->select('id_voucher','name_voucher','slug_voucher','image_voucher','des_voucher','type_voucher','view_voucher','link_dowload_voucher','dowload_voucher')->orderBy('view_voucher','desc')
            ->orderBy('dowload_voucher','desc')
            ->limit(10)
            ->get();
        try{
            if(empty($voucher)){
                return response()->json([
                    'status' => 404,
                    'message' => 'Không có tài liệu kế toán.'
                ]);
            }
            return response()->json([
                'status' => 200,
                'voucher' => $voucher
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status' => 404,
                'message' => 'Không có tài liệu kế toán.'
            ]);
        }
    }
}
