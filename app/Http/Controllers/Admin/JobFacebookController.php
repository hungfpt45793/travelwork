<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\APIgoogle;
use App\Entity\Category_tag;
use App\Entity\Employer;
use App\Entity\Salary;
use App\Entity\User;
use App\Http\Controllers\Admin\AdminController;
use App\Entity\JobFacebook;
use App\Ultility\Ultility;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Yajra\DataTables\DataTables;

class JobFacebookController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'jobs');

            return $next($request);
        });


    }
    public function index(Request $request)
    {
        $jobFacebooks = new JobFacebook();

        $jobFacebooks = $jobFacebooks->select('job_facebook.*','employer.employer_id as employers_id ','employer.enterprise_name','employer.email as emailNTD');
        $jobFacebooks = $jobFacebooks->leftJoin('employer','employer.employer_id','=','job_facebook.employer_id');

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
            $jobFacebooks = $jobFacebooks->where('job_facebook.title','like', '%'.$title.'%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobFacebooks = $jobFacebooks->where('employer.email','like', '%'.$email.'%');
        }
        if (!empty($request->input('email_job_fb'))) {
            $email_job_fb = $request->input('email_job_fb');
            $jobFacebooks = $jobFacebooks->where('job_facebook.email','like', '%'.$email_job_fb.'%');
        }
        if (!empty($request->has('vip'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.employer_id', $request->input('employer_id'));
        }



        $jobFacebooks = $jobFacebooks->orderBy('job_facebook.job_facebook_id', 'desc');
        $total_job = $jobFacebooks->count();
        $jobFacebooks = $jobFacebooks->paginate(50);

        $jobFacebooks->appends(request()->query());

        return view('jobs.job_facebook.list',compact('total_job','jobFacebooks'));
    }

    public function jobFacebookDatatable(Request $request)
    {
        $jobFacebooks = JobFacebook::select('job_facebook.*', 'province.province_name', 'district.district_name', 'users.name')
            ->leftJoin('province', 'province.province_id', '=', 'job_facebook.province')
            ->leftJoin('district', 'district.district_id', '=', 'job_facebook.district')
            ->leftJoin('users', 'users.id', '=', 'job_facebook.user_id');

        return Datatables::of($jobFacebooks)
            ->addColumn('action', function ($jobFacebook) {
                $string = '<a href="' . route('job-facebook.edit', ['job_facebook_id' => $jobFacebook->job_facebook_id]) . '">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="' . route('job-facebook.destroy', ['job_facebook_id' => $jobFacebook->job_facebook_id]) . '" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('job_facebook_id', 'job_facebook_id desc')
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employers = Employer::getselectNameId();
        $salaries = Salary::orderBy('salary_id')->get();
        $input_tags = Category_tag::all_tags_job();
        return view('jobs.job_facebook.add', compact('salaries', 'employers','input_tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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
            'created_at' => new \DateTime()
        ]);
        $job_face = new JobFacebook();
        $update = $job_face->where('job_facebook_id',$jobFacebookId)->update([
            'job_facebook_code' => 'FB'.$jobFacebookId
        ]);


        // insert slug
        $jobWithSlug = JobFacebook::where('slug', $slug)->first();

            JobFacebook::where('job_facebook_id', '=', $jobFacebookId)
                ->update([
                    'slug' => $slug . '-' . $jobFacebookId
                ]);
        
       

        // gửi API cho google
        $slug_temp = $slug . '-' . $jobFacebookId;
        $slug_gg = 'viec-lam-facebook/'.$slug_temp;
        $type = "URL_UPDATED";
        APIgoogle::APIgoogle($type ,$slug_gg);
        // END gửi API cho google

        return redirect(route('job-facebook.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JobFacebook $jobFacebook
     * @return \Illuminate\Http\Response
     */
    public function show(JobFacebook $jobFacebook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobFacebook $jobFacebook
     * @return \Illuminate\Http\Response
     */
    public function edit(JobFacebook $jobFacebook)
    {
        $employers = Employer::getselectNameId();
        $salaries = Salary::orderBy('salary_id')->get();
        $input_tags = Category_tag::all_tags_job();
        return view('jobs.job_facebook.edit', compact('jobFacebook', 'salaries', 'employers','input_tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\JobFacebook $jobFacebook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobFacebook $jobFacebook)
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

        $slug = Ultility::createSlug($request->input('title'));
        JobFacebook::where('job_facebook_id', $jobFacebook->job_facebook_id)->update([
            'title' => $request->input('title'),
            'job_facebook_code' => 'FB'.$jobFacebook->job_facebook_id,
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
            'updated_at' => new \DateTime(),
            'date_end' => $request->input('date_end'),
            'created_at' => $request->input('created_at'),
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
            
        return redirect(route('job-facebook.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobFacebook $jobFacebook
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobFacebook $jobFacebook)
    {

        // gửi API cho google
        $slug_gg = 'viec-lam-facebook/'.$jobFacebook->slug;
        $type = "URL_DELETED";
        APIgoogle::APIgoogle($type ,$slug_gg);
        // END gửi API cho google

        $jobFacebook->delete();
        return redirect(route('job-facebook.index'));
    }

    public function total_user_facebook(Request $request)
    {

        $empoyer = new Employer();
        $empoyer = $empoyer->select('employer.employer_id', 'employer.email', 'employer.is_admin', 'phone', 'enterprise_name')->where('employer.is_admin', 1)->get();
        $total = $empoyer->count();
        return view('jobs.job_facebook.statistical_job_fb', compact('empoyer', 'total'));
    }

    public function get_day_user_facebook($employer_id)
    {
        $jobfaceboook = new JobFacebook();
        $list_job = $jobfaceboook->select('*')->whereDate('created_at', date('Y/m/d'))->where('employer_id', $employer_id)->paginate(50);
        return view('jobs.job_facebook.list_day', compact('list_job', 'employer_id'));
    }

    public function get_month_user_facebook($employer_id)
    {
        $jobfaceboook = new JobFacebook();
        $list_job =  $jobfaceboook->select('*')->whereMonth('created_at',date('m'))
            ->whereYear('created_at', '=', date('Y'))
            ->where('employer_id',$employer_id)->paginate(50);
        return view('jobs.job_facebook.list_month', compact('list_job', 'employer_id'));
    }
    public function get_between_user_facebook($star_time,$end_time,$employer_id)
    {
        $jobfaceboook = new JobFacebook();
        $list_job =  $jobfaceboook->select('*')
            ->whereDate('created_at', '>=', $star_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('employer_id',$employer_id)->paginate(50);
        return view('jobs.job_facebook.list_between', compact('list_job','star_time','end_time','employer_id'));
    }

    public function loginFB_callback()
    {
        if (!session_id()) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }
        $fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v3.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $exception) {
            echo 'Graph returned an error: ' . $exception->getMessage();
            exit;
        } catch (FacebookSDKException $exception) {
            echo 'Facebook SDK returned an error: ' . $exception->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        $oAuth2Client = $fb->getOAuth2Client();


        // $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // $tokenMetadata->validateAppId('553584265133449');
        // $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo '<p>Error getting long-lived access token: ' . $e->getMessage() . "</p>\n";
                exit;
            }
        }
        session(['fb_access_token' => (string)$accessToken]);
        return redirect(route('job-facebook.index'));
    }

    public function groupFB()
    {
        try {
            $fb = new Facebook([
                'app_id' => env('FACEBOOK_APP_ID'),
                'app_secret' => env('FACEBOOK_APP_SECRET'),
                'default_graph_version' => 'v3.2',
            ]);
            // $permissions = [
            // 'groups_access_member_info',
            // 'publish_to_groups'
            // ];
            $accessToken = session('fb_access_token');
            $response = $fb->get(
                '/1594488497509827/feed',
                $accessToken
            );
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();
        print_r($graphNode);
    }

    public function feed()
    {
        try {
            $fb = new Facebook([
                'app_id' => env('FACEBOOK_APP_ID'),
                'app_secret' => env('FACEBOOK_APP_SECRET'),
                'default_graph_version' => 'v3.2',
            ]);
            $accessToken = session('fb_access_token');
            $response = $fb->get(
                '/1594488497509827/feed',
                $accessToken
            );
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();
        var_dump($graphNode);
        //return view('Api.feed', compact('graphNode'));
    }

    public function photo()
    {
        try {
            $fb = new Facebook([
                'app_id' => env('FACEBOOK_APP_ID'),
                'app_secret' => env('FACEBOOK_APP_SECRET'),
                'default_graph_version' => 'v3.2',
            ]);
            $helper = $fb->getRedirectLoginHelper();
            $accessToken = $helper->getAccessToken();
            $response = $fb->post(
                '/1307129839300551/photos',
                array(
                    'source' => '{image-data}',
                ),
                $accessToken
            );
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();
        var_dump($graphNode);
        //return view('Api.photo', compact('graphNode'));
    }

    public function video()
    {
        try {
            $fb = new Facebook([
                'app_id' => env('FACEBOOK_APP_ID'),
                'app_secret' => env('FACEBOOK_APP_SECRET'),
                'default_graph_version' => 'v3.2',
            ]);
            $helper = $fb->getRedirectLoginHelper();
            $accessToken = $helper->getAccessToken();
            $response = $fb->get(
                '/1307129839300551/videos',
                $accessToken
            );
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();
        var_dump($graphNode);
        //return view('Api.video', compact('graphNode'));
    }
    public function update_job_facebook(Request $request)
    {
        $job_face = new JobFacebook();
        $list_job = $job_face->select('job_facebook_id','job_facebook_code')->get();

        foreach ($list_job as $job)
        {
            $update = $job_face->where('job_facebook_id',$job->job_facebook_id)->update([
                'job_facebook_code'=> 'FB'.$job->job_facebook_id
            ]);
        }
        return redirect(route('job-facebook.index'));
    }
    public function job_facebook_delete(Request $request)
    {
        $jobFacebooks = new JobFacebook();

        $jobFacebooks = $jobFacebooks->onlyTrashed()->select('job_facebook.*','employer.employer_id as employers_id ','employer.enterprise_name','employer.email as emailNTD');
        $jobFacebooks = $jobFacebooks->leftJoin('employer','employer.employer_id','=','job_facebook.employer_id');

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
            $jobFacebooks = $jobFacebooks->where('job_facebook.title','like', '%'.$title.'%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobFacebooks = $jobFacebooks->where('employer.email','like', '%'.$email.'%');
        }
        if (!empty($request->input('email_job_fb'))) {
            $email_job_fb = $request->input('email_job_fb');
            $jobFacebooks = $jobFacebooks->where('job_facebook.email','like', '%'.$email_job_fb.'%');
        }
        if (!empty($request->has('vip'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobFacebooks = $jobFacebooks->where('job_facebook.employer_id', $request->input('employer_id'));
        }



        $jobFacebooks = $jobFacebooks->orderBy('job_facebook.job_facebook_id', 'desc');
        $total_job = $jobFacebooks->count();
        $jobFacebooks = $jobFacebooks->paginate(50);

        $jobFacebooks->appends(request()->query());

        return view('jobs.job_facebook.list_delete',compact('total_job','jobFacebooks'));
    }
    public function Job_facebook_srestore(Request $request, $job_facebook_id)
    {
        try {
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {
                $jobs_model = new JobFacebook();

                $restore = $jobs_model->withTrashed()->where('job_facebook_id', $job_facebook_id)->restore();

                //khoi phuc ban ghi
                DB::commit();
                return redirect(route('job_facebook_delete'))->with('success','Khôi phục thành công');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('job_facebook_delete'))->with('error','Khôi phục thất bại');
        }


    }

    public function Job_facebook_ForceDelete(Request $request, $job_facebook_id)
    {
        try
        {
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {
                $jobs_model = new JobFacebook();
                $forceDelete = $jobs_model->withTrashed()->where('job_facebook_id', $job_facebook_id)->forceDelete();
            }
            DB::commit();
            return redirect(route('job_facebook_delete'))->with('success','Xóa vĩnh viễn thành công');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect(route('job_facebook_delete'))->with('success','Xóa vĩnh viễn thất bại');
        }


    }
}
