<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\APIgoogle;
use App\Entity\Category_tag;
use App\Entity\JobFacebook;
use App\Entity\Employer;
use App\Entity\Salary;
use App\Entity\Interactive_history_jobfb;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class JobFacebookController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'vieclam');
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }

        $jobFacebooks = new JobFacebook();
        $jobFacebooks = $jobFacebooks->select(
            'job_facebook.job_facebook_id',
            'job_facebook.job_facebook_code',
            'job_facebook.title',
            'job_facebook.slug',
            'job_facebook.phone',
            'job_facebook.email',
            'job_facebook.salary_id',
            'job_facebook.province',
            'job_facebook.view',
            'job_facebook.district',
            'job_facebook.date_end',
            'job_facebook.warning_job_fb',
            'job_facebook.employer_id',
            'job_facebook.deleted_at',
            'job_facebook.vip',
            'job_facebook.company_name',
            'job_facebook.created_at',
            'employer.employer_id as employers_id ', 'employer.enterprise_name', 'employer.email as emailNTD' )
            ->groupBy('job_facebook.job_facebook_id');
        $jobFacebooks = $jobFacebooks->leftJoin('employer', 'employer.employer_id', '=', 'job_facebook.employer_id');

        // dd($request->all());
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            // dd($date_search_start);
            $jobFacebooks = $jobFacebooks->whereDate('job_facebook.created_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $jobFacebooks = $jobFacebooks->whereDate('job_facebook.created_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('career_category_id'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.career_category_id', $request->input('career_category_id'));
        }
        if (!empty($request->input('job_facebook_id'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.job_facebook_id', $request->input('job_facebook_id'));
        }
        //        Mức lương
        if (!empty($request->input('salary'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.salary_id', $request->input('salary'));
        }
        //        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.province', $request->input('province'));
        }
        //        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.district', $request->input('district'));
        }
        //        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobFacebooks = $jobFacebooks->where('job_facebook.title', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobFacebooks = $jobFacebooks->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('email_job_fb'))) {
            $email_job_fb = $request->input('email_job_fb');
            $jobFacebooks = $jobFacebooks->where('job_facebook.email', 'like', '%' . $email_job_fb . '%');
        }
        if (!empty($request->has('vip'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.employer_id', $request->input('employer_id'));
        }
        if (!empty($request->input('code'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.job_facebook_code', $request->input('code'));
        }


        $jobFacebooks = $jobFacebooks->orderBy('job_facebook.job_facebook_id', 'desc');
        $jobFacebooks = $jobFacebooks->paginate($num);

        $jobFacebooks->appends(request()->query());

        return view('staff_admin.job.job_facebook.list', compact('jobFacebooks'));
    }

    public function get_user_facebook(Request $request, $employer_id)
    {
        $jobFacebooks = new JobFacebook();

        $jobFacebooks = $jobFacebooks->select('job_facebook.*', 'employer.employer_id as employers_id ', 'employer.enterprise_name', 'employer.email as emailNTD');
        $jobFacebooks = $jobFacebooks->leftJoin('employer', 'employer.employer_id', '=', 'job_facebook.employer_id')
            ->where('job_facebook.employer_id', $employer_id);
        // dd($request->all());
        if (!empty($request->get('check'))) {
            if ($request->get('check') == "day") {
                $jobFacebooks = $jobFacebooks->where('job_facebook.created_at', 'like', '%' . date('Y-m-d') . '%');
            } elseif ($request->get('check') == "month") {
                $jobFacebooks = $jobFacebooks->where('job_facebook.created_at', 'like', '%' . date('Y-m') . '%');
            }
        }
        $jobFacebooks = $jobFacebooks->orderBy('job_facebook.job_facebook_id', 'desc');
        $total_job = $jobFacebooks->count();
        $jobFacebooks = $jobFacebooks->paginate(50);

        $jobFacebooks->appends(request()->query());

        return view('staff_admin.job.job_facebook.list', compact('total_job', 'jobFacebooks'));
    }

    public function get_between_user_facebook(Request $request, $star_time, $end_time, $employer_id)
    {
        $jobFacebooks = new JobFacebook();

        $jobFacebooks = $jobFacebooks->select('job_facebook.*', 'employer.employer_id as employers_id ', 'employer.enterprise_name', 'employer.email as emailNTD');
        $jobFacebooks = $jobFacebooks->leftJoin('employer', 'employer.employer_id', '=', 'job_facebook.employer_id')
            ->where('job_facebook.employer_id', $employer_id);
        if ($star_time != null && $star_time != "") {
            $jobFacebooks = $jobFacebooks->where('job_facebook.created_at','>=',$star_time);
        }
        if ($end_time != null && $end_time != "") {
            $jobFacebooks = $jobFacebooks->where('job_facebook.created_at','<=',date('Y-m-d H:i:s',strtotime($end_time)+24*3600-1));
        }
        $jobFacebooks = $jobFacebooks->orderBy('job_facebook.job_facebook_id', 'desc');
        $total_job = $jobFacebooks->count();
        $jobFacebooks = $jobFacebooks->paginate(50);

        $jobFacebooks->appends(request()->query());

        return view('staff_admin.job.job_facebook.list', compact('total_job', 'jobFacebooks'));
    }


    public function total_user_facebook(Request $request)
    {

        $empoyer = new Employer();
        $empoyer = $empoyer->select('employer.employer_id', 'employer.email', 'employer.is_admin', 'phone', 'enterprise_name')->where('employer.is_admin', 1)->get();
        $total = $empoyer->count();
        return view('staff_admin.job.job_facebook.statistical_job_fb', compact('empoyer', 'total'));
    }

    public function update_job_facebook(Request $request)
    {
        $job_face = new JobFacebook();
        $list_job = $job_face->select('job_facebook_id', 'job_facebook_code')->get();

        foreach ($list_job as $job) {
            $update = $job_face->where('job_facebook_id', $job->job_facebook_id)->update([
                'job_facebook_code' => 'FB' . $job->job_facebook_id
            ]);
        }
        $request->session()->flash('success', 'Cập nhật thành công!');
        return redirect()->back();
    }

    public function form_create_job_facebook()
    {
        $employers = Employer::getselectNameId();
        $salaries = Salary::orderBy('salary_id')->get();
        $input_tags = Category_tag::all_tags_job();
        return view('staff_admin.job.job_facebook.create', compact('salaries', 'employers','input_tags'));
    }
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $this->validate($request, [
            'career_category_id' => 'required',
            'salary_id' => 'required',
        ]);

        // thêm tag
        $tags = "";
        foreach ($request->input('tags') as $tag)
        {
            $tags .= $tag.',';
        }
        $tags = rtrim($tags, ",");
        // END thêm tag

        try {
            $slug = Ultility::createSlug($request->input('title'));
            $jobFacebookId = JobFacebook::insertGetId([
                'title' => $request->input('title'),
                'des_facebook' => $request->input('des_facebook'),
                'content' => $request->input('content'),
                'tags' => $tags,
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'link' => $request->input('link'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'company_name' => $request->input('company_name'),
                'salary_id' => $request->input('salary_id'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                //            mã ngành nghề
                'career_category_id' => $request->input('career_category_id'),
                'view' => $request->input('view'),
                'employer_id' => $request->input('employer_id'),
                'job_info_contact' => $request->input('job_info_contact'),
                'user_id' => $user_id,
                'vip' => $request->input('vip'),
                'date_end' => new \DateTime(date('Y-m-d H:i:s', strtotime("+30 days"))),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $job_face = new JobFacebook();
            $update = $job_face->where('job_facebook_id', $jobFacebookId)->update([
                'job_facebook_code' => 'FB' . $jobFacebookId
            ]);


            // insert slug
            $jobWithSlug = JobFacebook::where('slug', $slug)->first();

            JobFacebook::where('job_facebook_id', '=', $jobFacebookId)
                ->update([
                    'slug' => $slug . '-' . $jobFacebookId
                ]);
            $request->session()->flash('success', 'Thêm mới thành công!');

            // gửi API cho google
            $slug_temp = $slug . '-' . $jobFacebookId;
            $slug_gg = 'viec-lam-facebook/'.$slug_temp;
            $type = "URL_UPDATED";
            APIgoogle::APIgoogle($type ,$slug_gg);
            // END gửi API cho google



        } catch (\Exception $exception) {
            $request->session()->flash('error', 'Thêm mới thất bại!');
            DB::rollback();
        } finally {
            return redirect(route('staff_job-facebook.index'));
        }
    }
    public function form_edit_job_facebook($id)
    {
        $interactives = Interactive_history_jobfb::where('jobfb_id',$id)->orderBy('interactive_history_jobfb.id', 'desc')->paginate(4);
        $jobFacebook = JobFacebook::where('job_facebook_id', $id)->first();
        $employers = Employer::getselectNameId();
        $salaries = Salary::orderBy('salary_id')->get();
        $input_tags = Category_tag::all_tags_job();
        return view('staff_admin.job.job_facebook.edit', compact('jobFacebook', 'salaries', 'employers','interactives','input_tags'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'career_category_id' => 'required',
            'salary_id' => 'required',
        ]);

        // thêm tag
        $tags = "";
        foreach ($request->input('tags') as $tag)
        {
            $tags .= $tag.',';
        }
        $tags = rtrim($tags, ",");
        // END thêm tag

        $jobFacebook = JobFacebook::where('job_facebook_id', $id)->first();
        $slug = Ultility::createSlug($request->input('title'));
        JobFacebook::where('job_facebook_id', $jobFacebook->job_facebook_id)->update([
            'title' => $request->input('title'),
            'job_facebook_code' => 'FB' . $jobFacebook->job_facebook_id,
            'des_facebook' => $request->input('des_facebook'),
            'content' => $request->input('content'),
            'tags' => $tags,
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'link' => $request->input('link'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'company_name' => $request->input('company_name'),
            'salary_id' => $request->input('salary_id'),
            'province' => $request->input('province'),
            'employer_id' => $request->input('employer_id'),
            //            'code'  => $request->input('code'),
            'career_category_id' => $request->input('career_category_id'),
            'job_info_contact' => $request->input('job_info_contact'),
            'view' => $request->input('view'),
            'district' => $request->input('district'),
            'warning_job_fb' => $request->input('warning_job_fb'),
            'vip' => $request->input('vip'),
            'updated_at' => new \DateTime()
        ]);

        // insert slug
        $jobWithSlug = JobFacebook::where('slug', $slug)
            ->where('job_facebook_id', '!=', $jobFacebook->job_facebook_id)
            ->first();

        JobFacebook::where('job_facebook_id', $jobFacebook->job_facebook_id)
            ->update([
                'slug' => $slug . '-' . $jobFacebook->job_facebook_id
            ]);

        // gửi API cho google
        $slug_temp = $slug . '-' . $jobFacebook->job_facebook_id;
        $slug_gg = 'viec-lam-facebook/'.$slug_temp;
        $type = "URL_UPDATED";
        APIgoogle::APIgoogle($type ,$slug_gg);
        // END gửi API cho google

        $request->session()->flash('success', 'Cập nhật thành công!');
        return redirect(route('staff_job-facebook.index'));
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {

            // gửi API cho google
            $slug_temp = JobFacebook::findOrFail($arrid)->slug;
            $slug_gg = 'viec-lam-facebook/'.$slug_temp;
            $type = "URL_DELETED";
            APIgoogle::APIgoogle($type ,$slug_gg);
            // END gửi API cho google

            JobFacebook::where('job_facebook_id', $arrid)->delete();
        }
        return response()->json(['success'=>"Xóa thành công!!!"]);
    }

    public function deleteHardAll(Request $request)
    {
        $ids = $request->ids;
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {
            JobFacebook::where('job_facebook_id', $arrid)->forceDelete();
        }

        return response()->json(['success'=>"Xóa hẳn thành công!!!"]);
    }

    public function job_facebook_deleted(Request $request){
        $jobFacebooks = new JobFacebook();

        $jobFacebooks = $jobFacebooks->select('job_facebook.*', 'employer.employer_id as employers_id ', 'employer.enterprise_name', 'employer.email as emailNTD');
        $jobFacebooks = $jobFacebooks->leftJoin('employer', 'employer.employer_id', '=', 'job_facebook.employer_id');
        // dd($request->all());
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            // dd($date_search_start);
            $jobFacebooks = $jobFacebooks->whereDate('job_facebook.created_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $jobFacebooks = $jobFacebooks->whereDate('job_facebook.created_at', '<=', $request->date_search_end);
        }
        if (!empty($request->input('career_category_id'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.career_category_id', $request->input('career_category_id'));
        }
        //        Mức lương
        if (!empty($request->input('salary'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.salary_id', $request->input('salary'));
        }
        //        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.province', $request->input('province'));
        }
        //        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.district', $request->input('district'));
        }
        //        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobFacebooks = $jobFacebooks->where('job_facebook.title', 'like', '%' . $title . '%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobFacebooks = $jobFacebooks->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('email_job_fb'))) {
            $email_job_fb = $request->input('email_job_fb');
            $jobFacebooks = $jobFacebooks->where('job_facebook.email', 'like', '%' . $email_job_fb . '%');
        }
        if (!empty($request->has('vip'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.employer_id', $request->input('employer_id'));
        }
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }


        $jobFacebooks = $jobFacebooks->onlyTrashed()->orderBy('job_facebook.job_facebook_id', 'desc');
        $total_job = $jobFacebooks->count();
        $jobFacebooks = $jobFacebooks->paginate($num);

        $jobFacebooks->appends(request()->query());

        return view('staff_admin.job.job_facebook.list_deleted', compact('total_job', 'jobFacebooks'));
    }
    public function hard_delete_job_facebook($id) {
        JobFacebook::where('job_facebook_id', $id)->forceDelete();
        return redirect()->back()->with('success','Xóa hẳn thành công!!!');
    }

    public function Job_facebook_srestore(Request $request, $job_facebook_id)
    {

        $jobs_model = new JobFacebook();

        $restore = $jobs_model->withTrashed()->where('job_facebook_id', $job_facebook_id)->restore();


        return redirect()->back()->with('success','Khôi phục thành công');
    }
    public function create_interactive_jobfb(Request $request){
        try
        {
            $interactive = new Interactive_history_jobfb();
            $create = Interactive_history_jobfb::insert([
                'jobfb_id' => $request->jobfb_id,
                'interactive_day'   => $request->input('interactive_day'),
                'user_id'     => Auth::id(),
                'content'     => $request->input('content'),
                'created_at'  => date('Y-m-d H:i:s')
            ]);
            $request->session()->flash('success', 'Tạo tương tác thành công!');
            return redirect()->back();
        }catch(\Exception $e){
            $request->session()->flash('error', 'Tạo tương tác không thành công!');
            return redirect()->back();
        }
    }
    public function update_interactive_jobfb(Request $request,$id){

        $interactive = Interactive_history_jobfb::findOrFail($id);
        $update = $interactive->update([
            'interactive_day'   => $request->input('interactive_day'),
            'content'     => $request->input('content'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);
        $request->session()->flash('success', 'Cập nhật tương tác thành công!');
        return redirect()->back();
    }
    public function delete_interactive_jobfb(Request $request,$id){

        $interactive = Interactive_history_jobfb::findOrFail($id)->delete();
        $request->session()->flash('success', 'Xóa tương tác thành công!');
        return redirect()->back();
    }
    public function bao_cao_thong_ke_jobfb(Request $request){
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        $interactives = Interactive_history_jobfb::select(
            'interactive_history_jobfb.id',
            'interactive_history_jobfb.jobfb_id',
            'interactive_history_jobfb.user_id',
            'users.name',
            'job_facebook.job_facebook_code',
            'job_facebook.title',
            'interactive_history_jobfb.content',
            'interactive_history_jobfb.created_at'
        )->whereRaw('interactive_history_jobfb.id IN (select MAX(interactive_history_jobfb.id) FROM interactive_history_jobfb GROUP BY jobfb_id, user_id)')
        ->join('job_facebook', 'interactive_history_jobfb.jobfb_id', 'job_facebook.job_facebook_id')
        ->join('users', 'interactive_history_jobfb.user_id', 'users.id')
        ->groupBy('interactive_history_jobfb.jobfb_id','interactive_history_jobfb.user_id')
        ->orderBy('interactive_history_jobfb.created_at', 'desc');
        // tìm theo ma cong việc
        if (!empty($request->code)) {
            $interactives = $interactives->where('job_facebook.job_facebook_code', $request->code);
        }
        // tìm theo nguoi tuong tac
        if (!empty($request->user_name)) {
            $interactives = $interactives->where('users.name', 'like', '%'.$request->user_name.'%');
        }
        // tìm theo ngày from
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            $interactives = $interactives->whereDate('interactive_history_jobfb.created_at', '>=', $request->date_search_start);
        }
        // tìm theo ngày to
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $interactives = $interactives->whereDate('interactive_history_jobfb.created_at', '<=', $request->date_search_end);
        }
        // $interactives = Interactive_history_jobfb::groupBy('jobfb_id','user_id')
        // ->orderBy('interactive_history_jobfb.created_at', 'desc')
        // ->paginate($num);

        $interactives = $interactives->paginate($num);
        return view('staff_admin.job.job_facebook.bao_cao_tt',compact('interactives'));
    }

    public function show_modal_content_tt(Request $request)
    {
        $interactives = Interactive_history_jobfb::select('interactive_history_jobfb.created_at','users.name','interactive_history_jobfb.content')
        ->join('job_facebook', 'interactive_history_jobfb.jobfb_id', 'job_facebook.job_facebook_id')
        ->join('users', 'interactive_history_jobfb.user_id', 'users.id')
        ->where('interactive_history_jobfb.jobfb_id', $request->jobfb_id)
        ->where('interactive_history_jobfb.user_id', $request->user_id)
        ->orderBy('interactive_history_jobfb.created_at', 'desc')
        ->get();
        return $interactives;
    }

}
