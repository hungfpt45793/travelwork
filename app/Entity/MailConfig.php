<?php

namespace App\Entity;

use App\Mail\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class MailConfig extends Model
{
    protected $table = 'mail_config';

    protected $primaryKey = 'mail_config_id';

    protected $fillable = [
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
        'updated_at',
    ];

    public static function sendMail($emailTo, $subject, $content)
    {
        $apiKey = env('SENDGRID_API_KEY');

        if (empty($apiKey)) {
            Log::warning('SENDGRID_API_KEY is not configured.');

            return false;
        }

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom('thongbao@sanketoan.vn', 'Sàn kế toán thông báo');
        $email->setSubject($subject);
        $email->addTo($emailTo, 'sanketoan.vn');
        $email->addContent('text/plain', strip_tags($content));
        $email->addContent('text/html', $content);

        try {
            $sendgrid = new \SendGrid($apiKey);
            $sendgrid->send($email);

            return true;
        } catch (\Exception $e) {
            Log::error('Entity->MailConfig->sendMail: lỗi khi gửi mail');

            return false;
        }
    }

    public static function sendMail_gmail($to = '', $subject = '', $content = '')
    {
        try {
            $userId = ModelParent::getUserId();
            $emailConfig = static::where('user_id', $userId)->first();

            if (!$emailConfig) {
                return false;
            }

            $driver = $emailConfig->driver ?: 'smtp';

            config(['mail.default' => $driver]);
            config(['mail.from' => [
                'address' => $emailConfig->email_send,
                'name' => $emailConfig->name_send,
            ]]);
            config(["mail.mailers.{$driver}.transport" => $driver]);
            config(["mail.mailers.{$driver}.host" => $emailConfig->address_server]);
            config(["mail.mailers.{$driver}.port" => $emailConfig->port]);
            config(["mail.mailers.{$driver}.username" => $emailConfig->email]);
            config(["mail.mailers.{$driver}.password" => $emailConfig->password]);
            config(["mail.mailers.{$driver}.encryption" => $emailConfig->encryption]);

            if ($emailConfig->method == 1) {
                config(["mail.mailers.{$driver}.host" => $emailConfig->host]);
                config(['services.mailgun' => [
                    'domain' => $emailConfig->address_server,
                    'secret' => $emailConfig->api_key,
                ]]);
            }

            app('mail.manager')->purge($driver);

            if (empty($to) && empty($emailConfig->email_receive)) {
                return false;
            }

            $emailReceive = explode(',', $emailConfig->email_receive);
            $to = empty($to) ? $emailReceive : $to;
            $mail = new Mail($content, $emailConfig->sign);

            \Mail::to($to)->send($mail->subject($subject));

            return true;
        } catch (\Exception $e) {
            Log::error('Entity->MailConfig->sendMail_gmail: lỗi khi gửi mail');

            return false;
        }
    }

    public static function test_sendMail($to = '', $subject = '', $content = '')
    {
        try {
            $mail = new Mail($content);
            \Mail::to($to)->send($mail->subject($subject));

            return true;
        } catch (\Exception $e) {
            Log::error('Entity->MailConfig->test_sendMail: lỗi khi gửi mail');

            return false;
        }
    }
}
