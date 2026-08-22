<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Entity\Domain;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Validator;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;

class ApiOtpController extends Controller
{
    //gửi mã otp
    public function sendOtp($phone_input)
    {
        try {
            $rest = substr($phone_input, 1);
            $phone = '+84' . $rest;
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            $twilio->verify->v2->services($twilio_verify_sid)
                ->verifications
                ->create($phone, "sms", ["locale" => "vi"]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    //check mã xác thực otp
    public function verifyOtp($phone_input, $code_otp)
    {
        try {
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $rest = substr($phone_input, 1);
            $phone = '+84' . $rest;
            $twilio = new Client($twilio_sid, $token);
            $data['verification_code'] = $code_otp;
            $data['phone_number'] = $phone;
            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                ->verificationChecks
//                ->create(['code' => $data['verification_code'], 'to' => $data['phone_number']]);
//                ->create(['code_otp' => $code_otp, 'to' => $phone]);
                ->create($code_otp, array('to' => $phone));
            if ($verification->valid) {
                $rest = substr($phone_input, 3);
                return $code_otp;
            }
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
