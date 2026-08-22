<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 3/22/2018
 * Time: 9:44 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entity\Input;
use App\Entity\MailConfig;
use App\Entity\Order;
use App\Entity\OrderBank;
use App\Entity\OrderCodeSale;
use App\Entity\OrderItem;
use App\Entity\OrderShip;
use App\Entity\Post;
use App\Entity\SettingGetfly;
use App\Entity\SettingOrder;
use App\Entity\User;
use App\Ultility\CallApi;
use App\Ultility\Error;
use App\Ultility\InforFacebook;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class SettingController extends AdminController
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

            view()->share('menuTop', 'setting');
            return $next($request);
        });

    }


    public function testEmail(Request $request) {
//        try {
            $emailTest = $request->input('email_test');
            $content_email = $request->input('contentEmail');
            $search =['{name}', '{email}'];
            $replace   = ['thắng12121', 'thang@gmail.com1212'];

        $string = str_replace($search,$replace,$content_email);


//        $string = str_replace('{name}','thắng',$content_email);
//        $string = str_replace('{email}','thang@gmail.com',$content_email);

//        echo $string;die();

            $result = $this->sendMailContent($emailTest,$string);

            if ($result == true) {
                return redirect(route('method_payment').'?error=0');
            }

            return redirect(route('method_payment').'?error=1');
//        } catch (\Exception $e) {
//            return redirect(route('method_payment').'?error=1');
//        }

    }

    private function sendMail($emailTest) {
        if (!empty($this->domainUser)) {
            $subject = 'Website '.$this->domainUser->name.' kiểm tra email';
        } else {
            $subject = 'Website vn3c kiểm tra email';
        }

        $content = 'Kiểm tra cài dặt thông tin email thành công. Bạn có thể sử dụng để gửi đơn hàng, hay chăm sóc khách hàng.';

        return MailConfig::sendMail($emailTest, $subject, $content, Auth::user()->id);

    }
    private function sendMailContent($emailTest,$content) {
        if (!empty($this->domainUser)) {
            $subject = 'Website '.$this->domainUser->name.' kiểm tra email';
        } else {
            $subject = 'Website vn3c kiểm tra email';
        }
        return MailConfig::sendMail($emailTest, $subject, $content, Auth::user()->id);

    }

    public function setting(Request $request) {
//        try {
            if ($request->has('accesstoken')) {
                User::where('id', Auth::user()->id)->update([
                    'accesstoken' => $request->input('accesstoken')
                ]);
            }
            $userId = Auth::user()->id;
            $settingEmail = MailConfig::where('user_id', $userId)->first();
            if (empty($settingEmail)) {
                $mailConfigModel =  new MailConfig();
                $mailConfigModel->insert([
                    'user_id' => $userId,
                    'id_config' => 1,
                    'mail_config_id' => 1,
                    'created_at' => new \Datetime(),
                    'updated_at' => new \DateTime()
                ]);
                $settingEmail = MailConfig::where('user_id', $userId)->first();
            }

//            $loginUrl = $this->getLoginFacebook();

            return view('admin.setting.setting', compact('settingEmail'));
//        } catch(\Exception $e) {
//            Error::setErrorMessage('Lỗi xảy ra khi hiển thị cài đặt thanh toán: dữ liệu không hợp lệ.');
//            Log::error('http->admin->OrderController->setting: Lỗi xảy ra trong quá trình hiển thị cài đặt thanh toán');
//
//            return redirect('admin/home');
//        }
    }
    public function settingGetfly (Request $request) {
        try {
            if ($request->has('accesstoken')) {
                User::where('id', Auth::user()->id)->update([
                    'accesstoken' => $request->input('accesstoken')
                ]);
            }

            $userId = Auth::user()->id;
            $callApi = new CallApi();
            $campaigns = $callApi->getCampaigns();

            return view('admin.setting.setting_getfly', compact('campaigns'));
        } catch(\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị cài đặt thanh toán: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->setting: Lỗi xảy ra trong quá trình hiển thị cài đặt thanh toán');

            return redirect('admin/home');
        }
    }

    private function getLoginFacebook() {
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $urlLogin = 'http://facebook.vn3c.net/flogin?service_code=1c9b7597b1e8b09e61b419235f1d207a&currentUrl='.$actual_link;

        return $urlLogin;
    }

    public function updateSetting(Request $request) {
        try {
            $settingOrder = new SettingOrder();

            $settingOrder->where('theme_code', $this->themeCode)
                ->where('user_email', $this->emailUser)->delete();
            $settingOrder->insert([
                'point_to_currency' => $request->input('point_to_currency'),
                'currency_give_point' => $request->input('currency_give_point'),

                'theme_code' => $this->themeCode,
                'user_email' => $this->emailUser,
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật cài đặt thanh toán: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->setting: Lỗi xảy ra trong quá trình cập nhật cài đặt thanh toán');
        } finally {
            return redirect(route('method_payment'));
        }
    }


    public function updateSettingGetFly(Request $request) {
        try {
            $user = Auth::user();
            $settingGetfly = SettingGetfly::where('user_id', $user->id)->first();

            $campain = $request->input('campaign_employer');
            $campains = explode('-', $campain);
            $campainEmployer = 0;
            $campainStatusEmployer = 0;
            if (count($campains) == 2 ) {
                $campainEmployer = $campains[0];
                $campainId = $campains[1];
                $callApi = new CallApi();
                $campaignStatusList = $callApi->getCampaignStatus($campainId);
                $campainStatusEmployer = isset($campaignStatusList['decode'][0]['opportunity_status_id']) ? $campaignStatusList['decode'][0]['opportunity_status_id'] : 0;
            }


            // Nếu không tồn tại thì thêm mới
            if (empty($settingGetfly)) {
                SettingGetfly::insert([
                    'user_id' => $user->id,
                    'api_key' => $request->input('api_key'),
                    'base_url' => $request->input('base_url'),
                    'user_id_candidate' => $request->input('user_id_candidate'),
                    'campain_candidate' => $request->input('campain_candidate'),
                    'campain_status' => $request->input('campain_status'),
                    'campaign_employer' => $campainEmployer,
                    'campaign_status_employer' => $campainStatusEmployer,
                    'created_at' => new \Datetime(),
                    'updated_at' => new \DateTime()
                ]);

                return redirect()->back();
            }

            $settingGetfly->update([
                'api_key' => $request->input('api_key'),
                'base_url' => $request->input('base_url'),
                'user_id_candidate' => $request->input('user_id_candidate'),
                'campain_candidate' => $request->input('campain_candidate'),
                'campain_status' => $request->input('campain_status'),
                'campaign_employer' => $campainEmployer,
                'campaign_status_employer' => $campainStatusEmployer,
                'created_at' => new \Datetime(),
                'updated_at' => new \DateTime()
            ]);

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật dữ liệu getfly: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->updateSettingGetFly: Lỗi xảy ra trong quá trình cập nhật cài đặt getfly');
        } finally {
            return redirect()->back();
        }
    }

    public function updateSettingEmail(Request $request) {
        try {
            $user = Auth::user();
            $mailConfigModel = new MailConfig();
            $mailConfig = $mailConfigModel->where('user_id', $user->id)->first();
            // Nếu không tồn tại thì thêm mới
            if (empty($mailConfig)) {
                $mailConfigModel->insert([
                    'user_id' => $user->id,
                    'email_send' => $request->input('email_send'),
                    'name_send' => $request->input('name_send'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'address_server' => $request->input('address_server'),
                    'port' => $request->input('port'),
                    'sign' => $request->input('sign'),
                    'supplier' => $request->input('supplier'),
                    'method' => $request->input('method'),
                    'api_key' => $request->input('api_key'),
                    'driver' => $request->input('driver'),
                    'host' => $request->input('host'),
                    'email_receive' => $request->input('email_receive'),
                    'encryption' => $request->input('encryption'),
                    'created_at' => new \Datetime(),
                    'updated_at' => new \DateTime()
                ]);

                return redirect(route('method_payment').'#email');
            }

            $mailConfig->update([
                'user_id' => $user->id,
                'email_send' => $request->input('email_send'),
                'name_send' => $request->input('name_send'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'address_server' => $request->input('address_server'),
                'port' => $request->input('port'),
                'sign' => $request->input('sign'),
                'supplier' => $request->input('supplier'),
                'method' => $request->input('method'),
                'api_key' => $request->input('api_key'),
                'driver' => $request->input('driver'),
                'host' => $request->input('host'),
                'email_receive' => $request->input('email_receive'),
                'encryption' => $request->input('encryption'),
                'created_at' => new \Datetime(),
                'updated_at' => new \DateTime()
            ]);

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật cấu hình email: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->updateSettingEmail: Lỗi xảy ra trong quá trình cập nhật cấu hình email');
        } finally {
            return redirect(route('method_payment'));
        }
    }

    public function deleteShip(OrderShip $orderShips)
    {
        try {
            OrderShip::where('order_ship_id', $orderShips->order_ship_id)->where('theme_code', $this->themeCode)
                ->where('user_email', $this->emailUser)->delete();
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa ship hàng: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->deleteShip: Lỗi xảy ra trong quá trình xóa ship hàng ');
        } finally {
            return redirect(route('method_payment'));
        }
    }
}