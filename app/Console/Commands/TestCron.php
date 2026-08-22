<?php

namespace App\Console\Commands;

use App\Entity\Age;
use App\Entity\Jobs_home;
use App\Entity\MailConfig;
use App\Http\Controllers\Site\MailConfigController;
use App\Mail\TestEmail;
use Illuminate\Console\Command;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job_home:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Capj nhat bang age theo phut';

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

        $job_home = new Jobs_home();
        $job_home = $job_home->insert([
            'title' => 'aaa',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);


    }
}
