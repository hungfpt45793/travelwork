<?php

namespace App\Console\Commands;

use App\Entity\Age;
use App\Entity\Cron_vouchers;
use App\Entity\Jobs_home;
use App\Entity\MailConfig;
use App\Entity\Voucher;
use App\Http\Controllers\Site\MailConfigController;
use App\Mail\TestEmail;
use Illuminate\Console\Command;

class VoucherCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voucher:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhập tài liệu hàng ngày';

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
        //
        //up date thu bang do tuoi
        $cron_voucher = new Cron_vouchers();
        $delete_voucher = $cron_voucher->select('*')->delete();

        $voucher = new Voucher();
        $vouchers = $voucher->select('slug_voucher','name_voucher','image_voucher','dowload_voucher','id_voucher','view_voucher')
            ->orderBy('view_voucher','desc')
            ->orderBy('dowload_voucher','desc')
            ->limit(10)
            ->get();
        foreach($vouchers as $vou)
        {
            $insert = $cron_voucher->insert([
                'slug_voucher' => $vou->slug_voucher,
                'id_voucher'  => $vou->id_voucher,
                'name_voucher'  => $vou->name_voucher,
                'image_voucher'  => $vou->image_voucher,
                'dowload_voucher'  => $vou->dowload_voucher,
                'view_voucher'  => $vou->view_voucher,
                'created_at' => new \DateTime()
            ]);
        }
    }
}
