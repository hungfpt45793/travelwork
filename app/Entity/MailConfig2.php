<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 3/21/2018
 * Time: 3:08 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

use App\Mail\Mail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MailConfig2 extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'mail_config';

    protected $primaryKey = 'id_config';

    protected $fillable = [
        'id_config',
        'mail_config_id',
        'user_id',
        'email_send',
        'name_send',
        'email',
        'password',
        'address_server',
        'port',
        'sign',
        'method',
        'driver',
        'host',
        'email_receive',
        'encryption',
        'supplier',
        'api_key',
        'created_at',
        'updated_at'
    ];
    public static function sendMail($to = '', $subject, $content) {
        try {
            $emailConfig2 = MailConfig::where('id_config',1)->first();

//            print_r($emailConfig);die();
            if (empty($emailConfig2)) {
                return true;
            }

            if ( empty($emailConfig2->name_send) ) {
                return true;
            }
            // change config send mail
            config(['mail.host' => $emailConfig2->address_server]);
            config(['mail.port' => $emailConfig2->port]);
            config(['mail.from' => [
                'address' => $emailConfig2->email_send,
                'name' => $emailConfig2->name_send
            ]]);
            config(['mail.username' => $emailConfig2->email]);
            config(['mail.password' => $emailConfig2->password]);
            config(['mail.driver' => $emailConfig2->driver]);
            config(['mail.encryption' => $emailConfig2->encryption]);
            if ($emailConfig2->method == 1) {
                // config mailGun
                config(['mail.driver' => $emailConfig2->driver]);
                config(['mail.host' => $emailConfig2->host]);
                config(['services.mailgun' => [
                    'domain' => $emailConfig2->address_server,
                    'secret' => $emailConfig2->api_key,
                ]]);
            }

            $to = (empty($to)) ? $emailConfig2->email_receive : $to;
            $mail = new Mail(
                $content,
                $emailConfig2->sign
            );
            \Mail::to($to)->send($mail->subject($subject));
            return true;
        } catch (\Exception $e) {

            Log::error('Entity->MainConfig->sendMail: lỗi khi gửi mail');

            return false;
        }

    }
}