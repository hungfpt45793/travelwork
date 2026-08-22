<?php

namespace App\Http\Controllers\Staff;

use App\Entity\Contact;
use App\Entity\ResAdvisory;
use App\Entity\Res_advisory_interactive;
use App\Ultility\Error;
use Illuminate\Http\Request;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;

class AdvisoryEmployerController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'donhang');
            return $next($request);
        });
    }
    public function index(Request $request)
    {

        $num_ntd_tt = Res_advisory_interactive::join('res_advisory', 'res_advisory.id_res', 'res_advisory_interactive.advisory_id')
                ->where('res_advisory.status_res',0)
                ->distinct('res_advisory_interactive.advisory_id')->pluck('res_advisory_interactive.advisory_id')->toArray();
        $total_ntd = ResAdvisory::where('status_res',0)->pluck('id_res')->toArray();
        $a = array_diff($total_ntd, $num_ntd_tt);
       
        $res_ads = new ResAdvisory();
        if(!empty($request->id_sort))
        {
            if($request->id_sort == 1){
                $res_ads = $res_ads->orderBy('id_res', 'asc');
            }
        }
        
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $res_ads = $res_ads->whereDate('created_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $res_ads = $res_ads->whereDate('created_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('email_search'))) {
            $email_search = $request->input('email_search');
            $res_ads = $res_ads->where('email_res','like','%'.$email_search.'%');
        }
        if(!empty($request->name_search)){
            $res_ads = $res_ads->where('name_res', 'like', '%' . $request->name_search . '%');
        }
        if(!empty($request->status_view_search)){
            if($request->status_view_search==1)
            $res_ads = $res_ads->where('status_view', 1);
        }
        if(isset($request->not_interactive)){
            $res_ads = $res_ads->whereIn('id_res', $a);
        }
       
        $numperpage = 20;
        if(!empty($request->num)){
            $numperpage = $request->num;
        }
        $res_ads = $res_ads->select('*')
            ->orderBy('id_res', 'desc')
            ->where('status_res',0);
        $count = $res_ads->count();
        $res_ads = $res_ads->paginate($numperpage);
        $res_ads->appends(request()->query());
        return view('staff_admin.advisory.employer_advisory', compact('res_ads','count'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        
    }

    public function edit($id_res)
    {
        $interactives = Res_advisory_interactive::where('advisory_id', $id_res)->get();
        $res = new ResAdvisory();
        $res = $res->select('*')->where('id_res',$id_res)->first();
        $update = $res->where('id_res',$id_res)->update([
            'status_view' => 1,
        ]);
        return View('staff_admin.advisory.edit_employer_advisory', compact('res','id_res','interactives'));
    }


    public function update(Request $request, $id_res)
    {
        $res = new ResAdvisory();
        $res_ad = $res->select('*')->where('id_res',$id_res)->first();
        $update = $res->where('id_res',$id_res)->update([
            'name_res' => $request->input('name_res'),
            'email_res' => $request->input('email_res'),
            'phone_res' => $request->input('phone_res'),
            'address_res' => $request->input('address_res'),
            'message_res' => $request->input('message_res'),
        ]);
        return redirect(route('staff_advisory_employer.index'));
    }

 
    public function destroy(Request $request, $id_res)
    {
        $res = new ResAdvisory();
        $res_ad = $res->select('*')->where('id_res',$id_res)->first();
        $delete = $res->where('id_res',$id_res)->delete();
            return redirect(route('staff_advisory_employer.index'));
        

    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;   
        $arrids = explode(",",$ids);
        // ResAdvisory::whereIn('id_res',explode(",",$ids))->delete();
        foreach ($arrids as $arrid) {
            ResAdvisory::where('id_res', $arrid)->delete();
        }
       
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
