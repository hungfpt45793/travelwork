<?php

namespace App\Console\Commands;

use App\Entity\Age;
use App\Entity\Category;
use App\Entity\Cron_posts;
use App\Entity\Input;
use App\Entity\Jobs_home;
use App\Entity\MailConfig;
use App\Entity\Notification_post;
use App\Entity\Post;
use App\Http\Controllers\Api\NotificationMobileController;
use App\Http\Controllers\Site\MailConfigController;
use App\Mail\TestEmail;
use Illuminate\Console\Command;

class PodcastCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'podcast:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhập podcast theo ngày';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.buzzsprout.com/api/2176164/episodes.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Token token=11cd74abc6e3806365aa3bd3a7d8eace",
                "cache-control: no-cache",
                "postman-token: 1ddd7081-42f5-534a-a927-d4af26d3ccfb"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $noti_post_model = new Notification_post();
            foreach (json_decode($response, true) as $re) {
                $check_id_podcast = $noti_post_model->where('type', 'podcast')->where('id_podcast', $re['id'])->value('id_podcast');

                if ($check_id_podcast != $re['id']) {
                    $postId = $noti_post_model->insertGetId([
                        'noti_title' => $re['title'],
                        'post_id' => 0,
                        'slug' => '',
                        'id_podcast' => $re['id'], // id cua podcast  //url https://www.buzzsprout.com/api/2176164/episodes.json   header : [{"key":"Authorization","value":"Token token=11cd74abc6e3806365aa3bd3a7d8eace","description":""}]
                        'type' => 'podcast', //post la bai viet  ,exam la de thi ,podcast laf id am thanh
                        'created_at' => new \DateTime()
                    ]);
                    //tao thong bao
//                $api_push_noti = new NotificationMobileController();
                    $title = 'Sàn kế toán thông báo';
                    $body = $re['title'];
                    $type = 'podcast';
                    $note = 'Bài viết trên  post $value slug bài viết';
                    $value =  $re['id'];
                    $to = '';
                    $noti = new NotificationMobileController();
                    $send = $noti->pushNotification( $title, $body, $to,$type,$note,$value);
//                ( $title = '', $body = '', $to = '',$type='',$note='',$value='')
                }

            }
        }
    }
}
