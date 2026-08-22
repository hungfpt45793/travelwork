<?php

namespace App\Console\Commands;

use App\Entity\Age;
use App\Entity\Category;
use App\Entity\Cron_posts;
use App\Entity\Forum_notification;
use App\Entity\Input;
use App\Entity\Jobs_home;
use App\Entity\MailConfig;
use App\Entity\Notification_employer;
use App\Entity\Notification_post;
use App\Entity\Post;
use App\Http\Controllers\Site\MailConfigController;
use App\Mail\TestEmail;
use Illuminate\Console\Command;

class NotificationPostCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xoa thong bao 2 thang truoc';

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
        $date = date('Y-m-j');
        $newdate = strtotime ( '-2 month' , strtotime ( $date ) ) ;
        $newdate_month = date ( 'm' , $newdate );
        $newdate_year  = date ( 'Y' , $newdate );

//        echo $newdate;die;


        //xóa thông báo hệ thông tin tức , trắc nghiệm
        $noti_post_model = new Notification_post();
        $delete_noti_2_month = $noti_post_model->whereMonth('created_at', '<=',$newdate_month)
            ->whereYear('created_at', '<=',$newdate_year)
            ->where('post_id','!=',0)
            ->delete();
        //xoa thông báo việc làm gồm đăng nhập -> chưa xóa delete_at
        $noti_post_employer = new Notification_employer();
        $delete_2_month_employer = $noti_post_employer->whereMonth('created_at', '<=',$newdate_month)
            ->whereYear('created_at', '<=',$newdate_year)
            ->delete();

        //xóa thông báo hệ thống trên diễn đàn -> chưa xóa delete_at
         $noti_post_forum = new Forum_notification();
         $delete_2_month_employer = $noti_post_forum->whereMonth('created_at', '<=',$newdate_month)
            ->whereYear('created_at', '<=',$newdate_year)
            ->delete();



    }
}
