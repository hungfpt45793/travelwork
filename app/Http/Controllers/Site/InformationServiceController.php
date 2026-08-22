<?php

namespace App\Http\Controllers\Site;

use App\Entity\Category;
use App\Entity\Employee;
use App\Entity\Employee_experience;
use App\Entity\Employee_specialize;
use App\Entity\EmployerEmployee;
use App\Entity\EmployerIntership;
use App\Entity\EmployerTransfer;
use App\Entity\InformationService;
use App\Entity\Input;
use App\Entity\Invite;
use App\Entity\LocalBranch;
use App\Entity\MailConfig;
use App\Entity\Post;
use App\Entity\SettingGetfly;
use App\Entity\StarEmployer;
use App\Ultility\CallApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Business;
use App\Entity\District;
use App\Entity\Employer;
use App\Entity\EmployerBusiness;
use App\Entity\EmployerRepresentative;
use App\Entity\EmployerTypeBusiness;
use App\Entity\NoteEmployer;
use App\Entity\TypeOfBusiness;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Entity\Remuneration;
use App\Entity\Reason_choose;

class InformationServiceController extends SiteController
{
    public function detail_information($slug)
    {
        $information_service = new InformationService();
        $information_service = $information_service->select('*')->where('slug',$slug)->first();
        return view('site.default.single_info',compact('information_service'));
    }
    public function search_branch(Request $request)
    {
        $id_location = $_GET['id_location'];
        $name_input = $_GET['id_input'];
        if (empty($name_input)) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
        $local_barnch = new LocalBranch();
        $local_barnch = $local_barnch->select('*')
            ->where('local_id',$id_location)
            ->where('title','like','%'.$name_input.'%')
            ->get();
        return response([
            'status' => 200,
            'local_barnch' => $local_barnch
        ])->header('Content-Type', 'text/plain');
    }
}
