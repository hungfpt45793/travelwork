<?php

namespace App\Http\Controllers\Site;


use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\HistoryWork;
use App\Entity\Job;
use App\Entity\JobGroup;
use App\Entity\Order;
use App\Entity\SettingGetfly;
use App\Entity\User;
use App\Entity\Workplace;
use App\Ultility\CallApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prophecy\Call\Call;

class MapController extends SiteController
{
    //
    public function index(){
        return view();
    }
}
