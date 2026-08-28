<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\APIgoogle;
use App\Entity\Category_tag;
use App\Entity\District;
use App\Entity\Job;
use App\Entity\JobCareer;
use App\Entity\Sale;
use App\Entity\Salary;
use App\Entity\Software;
use App\Entity\Literacy;
use App\Entity\Employer;
use App\Entity\JobGroup;
use App\Entity\JobJobGroup;
use App\Entity\JobSoftware;
use App\Entity\JobSalePackage;
use App\Entity\User;
use App\Entity\Workplace;
use App\Ultility\CallApi;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Entity\Job_delete_request;

class JobController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if (!User::isCreater($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'jobs');
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        mb_strlen($job->content, 'UTF-8')
        $jobs = new Job();
        $jobs = $jobs->select(
            'jobs.*','employer.employer_id as employers_id ','employer.enterprise_name','employer.email'
        );
        $jobs = $jobs->join('employer','employer.employer_id','=','jobs.employer_id');
//        danh mục ngành nghề
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
//        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
//        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
//        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
//        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
//        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
//        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
//        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title','like', '%'.$title.'%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('jobs.title','job_code', '%'.$job_code.'%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email','like', '%'.$email.'%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobs = $jobs->where('jobs.employer_id', $request->input('employer_id'));
        }
        if ($request->has('sale_money')) {
            $jobs = $jobs->where('jobs.sale_money', $request->input('sale_money'));
        }



        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $total_job = $jobs->count();
        $jobs = $jobs->paginate(50);

        $jobs->appends(request()->query());
        return view('jobs.job.list', compact('jobs', 'total_job'));
    }


    public function listJobDeleteRequest(Request $request)
    {
//        mb_strlen($job->content, 'UTF-8')
        $jobs_dr = new Job_delete_request();
        $jobs = $jobs_dr->select(
            'jobs.*','employer.employer_id as employers_id ','employer.enterprise_name','employer.email'
        )->leftjoin('jobs','job_delete_request.job_id','jobs.job_id')
        ->leftjoin('users as u','job_delete_request.staff_id','u.id');
        $jobs = $jobs->join('employer','employer.employer_id','=','jobs.employer_id');
//        danh mục ngành nghề
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
//        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
//        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
//        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
//        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
//        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
//        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
//        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title','like', '%'.$title.'%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('jobs.title','job_code', '%'.$job_code.'%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email','like', '%'.$email.'%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobs = $jobs->where('jobs.employer_id', $request->input('employer_id'));
        }
        if ($request->has('sale_money')) {
            $jobs = $jobs->where('jobs.sale_money', $request->input('sale_money'));
        }



        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $total_job = $jobs->count();
        $jobs = $jobs->paginate(50);

        $jobs->appends(request()->query());
        return view('jobs.job.list_delete_request', compact('jobs', 'total_job'));
    }


    public function Job_delete_with_admin(Request $request, $id)
    {
        try {
            $update = Job_delete_request::where('job_id',$id)->delete();
            $delete = Job::where('job_id',$id)->delete();
            //khoi phuc ban ghi
            DB::commit();
            return redirect(route('listJobDeleteRequest'))->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listJobDeleteRequest'))->with('error', 'Xóa thất bại');
        }
    }
    public function Job_undelete_with_admin(Request $request, $id)
    {
        try {
            $update = Job_delete_request::where('job_id',$id)->delete();
            // $delete = Employee::where('employee_id',$id)->delete();
            //khoi phuc ban ghi
            DB::commit();
            return redirect(route('listJobDeleteRequest'))->with('success', 'Hủy thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listJobDeleteRequest'))->with('error', 'Hủy thất bại');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employers = Employer::select('employer_id','enterprise_name')->get();
        $salaries = Salary::get();
        $softwares = Software::get();
        $literacies = Literacy::get();
        $jobgroups = JobGroup::get();
        $salePackages = Sale::get();
//        echo mb_strlen($job->content, 'UTF-8'); //Kết quả là 10
//        die();
//        $callApi = new CallApi();
//        $campaigns = $callApi->getCampaigns();
        $input_tags = Category_tag::all_tags_job();
        return view('jobs.job.add', compact( 'softwares', 'employers',
            'salaries', 'literacies', 'jobgroups', 'salePackages', 'input_tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobs = new Job();
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $slug = $request->input('slug');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
//        echo $request->input('age_id');die();
        try {
            DB::beginTransaction();
            $sale_money = 0;
            if(!empty($request->input('sale_money')))
            {
                $sale_money = $request->input('sale_money');
            }

            // thêm tag
            $tags = "";
            foreach ($request->input('tags') as $tag)
            {
                $tags .= $tag.',';
            }
            $tags = rtrim($tags, ",");
            // END thêm tag

            $job_id = $jobs->insertGetId([
            'title' => $request->input('title'),
            'slug' => $slug,
            'age_id' => $request->input('age_id'),
            'description' => $request->has('description') ? $request->input('description') : '',
            'salary_id' => !empty($request->input('salary_id')) ? $request->input('salary_id') : 0,
            'experience_id' => $request->input('experience_id'),
            'literacy_id' => !empty($request->input('literacy_id')) ? $request->input('literacy_id') : 0,
            'deadline_submit_profile' => $request->input('deadline_submit_profile'),
            'content' => $request->input('content'),
            'welfare' => $request->input('welfare'),
//se co man hinh rieng de chon nha tuyen dung
            'employer_id' => $request->input('employer_id'),
            'number_recruit' => $request->input('number_recruit'),
            'province' => $request->input('province'),
            'district' => $request->input('district'),
            'vip' => $request->input('vip'),
            'position' => $request->input('position'),
            'gender' => $request->input('gender'),
            'image' => $request->input('image'),
            'image_list' => $request->input('image_list'),
            'tags' => $tags,
            'date_end' => $request->input('date_end'),
            'campain_candidate' => $request->input('campain_candidate'),
            'user_id_candidate' => $request->input('user_id_candidate'),
            'campain_status' => $request->input('campain_status'),
            'meta_title' => $request->has('meta_title') ? $request->input('meta_title') : null,
            'meta_description' => $request->has('meta_description') ? $request->input('meta_description') : null,
            'meta_keyword' => $request->has('meta_keyword') ? $request->input('meta_keyword') : null,
            'active_job' => 1,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
            //chia se kiếm tiền
                'sale_money' => $sale_money,
            //goi bán hàng
            'sale_package_id' => $request->input('salePackages'),
            //phần mềm Y/C
            'software_id' => $request->input('software'),
//                nhóm công việc
            'jobgroup_id' => $request->input('jobgroup_id'),
//                danh mục ngành nghề
            'career_category_id' => $request->input('career_category_id'),
//                Địa chỉ
            'address_work' => $request->input('address')
        ]);
            $update_code = $jobs->where('job_id', '=', $job_id)
                ->update([
                    'job_code' => 'SKT'.$job_id
                ]);
            $postWithSlug = $jobs->where('slug', $slug)->first();

                $jobs->where('job_id', '=', $job_id)
                    ->update([
                        'slug' => $slug.'-'.$job_id
                    ]);

        // gửi API cho google
        $slug_temp = $slug.'-'.$job_id;
        $slug_gg = 'cong-viec/'.$slug_temp;
        $type = "URL_UPDATED";
        APIgoogle::APIgoogle($type ,$slug_gg);
        // END gửi API cho google               

            DB::commit();
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
        } finally {
            return redirect(route('job.index'));
        }
//        $job_id

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Job $job)
    {
        $employers = Employer::getselectNameId();
        $salaries = Salary::get();
        $softwares = Software::get();
        $literacies = Literacy::get();
        $jobgroups = JobGroup::get();
        $salePackages = Sale::get();
//        echo mb_strlen($job->content, 'UTF-8'); //Kết quả là 10
//        die();
//        $callApi = new CallApi();
//        $campaigns = $callApi->getCampaigns();
        $input_tags = Category_tag::all_tags_job();
        return view('jobs.job.edit', compact('job', 'softwares', 'employers',
            'salaries', 'literacies', 'jobgroups', 'salePackages', 'input_tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $jobId = $job->job_id;
        $slug = $request->filled('slug')
            ? Ultility::createSlug($request->input('slug'))
            : $job->slug;

        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title')) . '-' . $jobId;
        }

        try {
            $saleMoney = $request->input('sale_money', 0);
            DB::beginTransaction();

            // thêm tag
            $tags = implode(',', array_filter((array) $request->input('tags', [])));
            // END thêm tag

            Job::where('job_id', $jobId)->update([
                'title' => $request->input('title'),
                'job_code' => 'SKT' . $jobId,
                'slug' => $slug,
                'age_id' => $request->input('age_id'),
                'description' => $request->has('description') ? $request->input('description') : '',
                'salary_id' => !empty($request->input('salary_id')) ? $request->input('salary_id') : 0,
                'experience_id' => $request->input('experience_id'),
                'literacy_id' => !empty($request->input('literacy_id')) ? $request->input('literacy_id') : 0,
                'deadline_submit_profile' => $request->input('deadline_submit_profile'),
                'content' => $request->input('content'),
                'welfare' => $request->input('welfare'),
//se co man hinh rieng de chon nha tuyen dung
                'employer_id' => $request->input('employer_id'),
                'number_recruit' => $request->input('number_recruit'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'vip' => $request->input('vip'),
                'position' => $request->input('position'),
                'gender' => $request->input('gender'),
                'image' => $request->has('image') ? $request->input('image') : $job->image,
                'image_list' => $request->has('image_list') ? $request->input('image_list') : $job->image_list,
                'tags' => $tags,
                'date_end' => $request->input('date_end'),
                'campain_candidate' => $request->has('campain_candidate') ? $request->input('campain_candidate') : $job->campain_candidate,
                'user_id_candidate' => $request->has('user_id_candidate') ? $request->input('user_id_candidate') : $job->user_id_candidate,
                'campain_status' => $request->has('campain_status') ? $request->input('campain_status') : $job->campain_status,
                'meta_title' => $request->has('meta_title') ? $request->input('meta_title') : null,
                'meta_description' => $request->has('meta_description') ? $request->input('meta_description') : null,
                'meta_keyword' => $request->has('meta_keyword') ? $request->input('meta_keyword') : null,
                'updated_at' => new \DateTime(),
            //chia se kiếm tiền
                'sale_money' => $saleMoney,
            //goi bán hàng
                'sale_package_id' => $request->input('salePackages'),
            //phần mềm Y/C
                'software_id' => $request->input('software', 0),
//                nhóm công việc
                'jobgroup_id' => $request->input('jobgroup_id'),
//                danh mục ngành nghề
                'career_category_id' => $request->input('career_category_id'),
//                Địa chỉ
                'address_work' => $request->input('address')
            ]);

            DB::commit();
        } catch (\Throwable $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu: Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollback();
            report($exception);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Cập nhật tin tuyển dụng thất bại.');
        }

        // Google Indexing là tác vụ phụ, không được phép rollback dữ liệu đã lưu.
        if (!app()->environment('testing')) {
            try {
                APIgoogle::APIgoogle('URL_UPDATED', route('job_detail', ['slug' => $slug]));
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        return redirect(route('job.index'))
            ->with('success', 'Cập nhật tin tuyển dụng thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        try {
            DB::beginTransaction();

            // gửi API cho google
            $slug_gg = 'cong-viec/'.$job->slug;
            $type = "URL_DELETED";
            APIgoogle::APIgoogle($type ,$slug_gg);
            // END gửi API cho google

            $job->delete();
            JobSoftware::where('job_id', $job->job_id)->delete();
            JobJobGroup::where('job_id', $job->job_id)->delete();
            JobSalePackage::where('job_id', $job->job_id)->delete();
            JobCareer::where('job_id', $job->job_id)->delete();
            Workplace::where('job_id', $job->job_id)->delete();
            DB::commit();
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể xóa dữ liệu: Đã có lỗi xảy ra trong quá trình xóa dữ liệu');
            DB::rollback();
        } finally {
            return redirect(route('job.index'));
        }
    }


    public function anyDatatable()
    {
        $jobs = Job::leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->leftJoin('job_sale_package', 'job_sale_package.job_id', '=', 'jobs.job_id')
            ->leftJoin('sale_package', 'sale_package.sale_package_id', '=', 'job_sale_package.sale_package_id')
            ->select(
                'jobs.job_id',
                'employer.enterprise_name',
                'jobs.title',
                'jobs.number_recruit',
                'jobs.number_recruited',
                'jobs.applicants',
                'sale_package.sale_package_name',
                'jobs.people_seen',
                'jobs.date_submit'
            );

        return Datatables::of($jobs)
            ->addColumn('inventory', function ($job) {
                return $job->number_recruit - $job->number_recruited;
            })
            ->addColumn('action', function ($job) {
                $string = '<a href="' . route('job.edit', ['job' => $job->job_id]) . '">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('job.destroy', ['job' => $job->job_id]) .
                    '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                </a>';
                return $string;
            })
            ->orderColumn('jobs.job_id', 'jobs.job_id desc')
            ->make(true);
    }

    // Việc làm cần phê duyệt
    public function jobApproval()
    {
        return view('jobs.job.approval');
    }

    public function anyDatatableApproval()
    {
        $jobs = Job::leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->leftJoin('job_sale_package', 'job_sale_package.job_id', '=', 'jobs.job_id')
            ->leftJoin('sale_package', 'sale_package.sale_package_id', '=', 'job_sale_package.sale_package_id')
            ->where('approved', 0)
            ->select(
                'jobs.job_id',
                'employer.enterprise_name',
                'jobs.title',
                'jobs.number_recruit',
                'jobs.number_recruited',
                'jobs.created_at',
                'sale_package.sale_package_name',
                'jobs.people_seen',
                'jobs.deadline_submit_profile'
            );

        return Datatables::of($jobs)
            ->addColumn('inventory', function ($job) {
                return $job->number_recruit - $job->number_recruited;
            })
            ->addColumn('action', function ($job) {
                $string = '<a href="' . route('job.edit', ['job' => $job->job_id]) . '">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('job.destroy', ['job' => $job->job_id]) .
                    '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('jobs.job_id', 'jobs.job_id desc')
            ->make(true);
    }

    // Việc làm vip
    public function jobVip()
    {
        return view('jobs.job.vip');
    }

    public function anyDatatableVip()
    {
        $jobs = Job::leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->leftJoin('job_sale_package', 'job_sale_package.job_id', '=', 'jobs.job_id')
            ->leftJoin('sale_package', 'sale_package.sale_package_id', '=', 'job_sale_package.sale_package_id')
            ->where('vip', '<>', 0)
            ->select(
                'jobs.job_id',
                'employer.enterprise_name',
                'jobs.title',
                'jobs.number_recruit',
                'jobs.number_recruited',
                'jobs.created_at',
                'sale_package.sale_package_name',
                'jobs.people_seen',
                'jobs.deadline_submit_profile'
            );

        return Datatables::of($jobs)
            ->addColumn('inventory', function ($job) {
                return $job->number_recruit - $job->number_recruited;
            })
            ->addColumn('action', function ($job) {
                $string = '<a href="' . route('job.edit', ['job' => $job->job_id]) . '">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('job.destroy', ['job' => $job->job_id]) .
                    '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('jobs.job_id', 'jobs.job_id desc')
            ->make(true);
    }

    public function jobInventory()
    {
        return view('jobs.job.inventory');
    }

    public function anyDatatableInventory()
    {
        $jobs = Job::leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->leftJoin('job_sale_package', 'job_sale_package.job_id', '=', 'jobs.job_id')
            ->leftJoin('sale_package', 'sale_package.sale_package_id', '=', 'job_sale_package.sale_package_id')
            ->where('vip', 1)
            ->select(
                'jobs.job_id',
                'employer.enterprise_name',
                'jobs.title',
                'jobs.number_recruit',
                'jobs.number_recruited',
                'jobs.created_at',
                'sale_package.sale_package_name',
                'jobs.people_seen',
                'jobs.deadline_submit_profile'
            );

        return Datatables::of($jobs)
            ->addColumn('inventory', function ($job) {
                return $job->number_recruit - $job->number_recruited;
            })
            ->addColumn('action', function ($job) {
                $string = '<a href="' . route('job.edit', ['job' => $job->job_id]) . '">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('job.destroy', ['job' => $job->job_id]) .
                    '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('jobs.job_id', 'jobs.job_id desc')
            ->make(true);
    }

    public function jobEnough()
    {
        return view('jobs.job.enough');
    }

    public function anyDatatableEnough()
    {
        $jobs = Job::leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->leftJoin('job_sale_package', 'job_sale_package.job_id', '=', 'jobs.job_id')
            ->leftJoin('sale_package', 'sale_package.sale_package_id', '=', 'job_sale_package.sale_package_id')
            ->where('vip', 1)
            ->select(
                'jobs.job_id',
                'employer.enterprise_name',
                'jobs.title',
                'jobs.number_recruit',
                'jobs.number_recruited',
                'jobs.created_at',
                'sale_package.sale_package_name',
                'jobs.people_seen',
                'jobs.deadline_submit_profile'
            );

        return Datatables::of($jobs)
            ->addColumn('inventory', function ($job) {
                return $job->number_recruit - $job->number_recruited;
            })
            ->addColumn('action', function ($job) {
                $string = '<a href="' . route('job.edit', ['job' => $job->job_id]) . '">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('job.destroy', ['job' => $job->job_id]) .
                    '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('jobs.job_id', 'jobs.job_id desc')
            ->make(true);
    }

    public function search(Request $request)
    {
        $careerSearch = $request->input('career');
        $literacySearch = $request->input('literacy');
        $salarySearch = $request->input('salary');
        $jobGroupSearch = $request->input('jobGroup');
        $saleSearch = $request->input('sale');
        $provinceSearch = $request->input('province');
        $districtSearch = $request->input('district');
        $startSearch = $request->input('start_at');
        $endSearch = $request->input('end_at');
        $title = $request->input('title');

        if (!empty($careerSearch) || !empty($literacySearch) || !empty($salarySearch) || !empty($jobGroupSearch) || !empty($saleSearch)
            || !empty($provinceSearch) || !empty($startSearch) || !empty($endSearch) || !empty($title)) {
            $jobs = Job::leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
                ->leftJoin('job_sale_package', 'job_sale_package.job_id', '=', 'jobs.job_id')
                ->leftJoin('sale_package', 'sale_package.sale_package_id', '=', 'job_sale_package.sale_package_id')
                ->leftJoin('job_career_categories', 'job_career_categories.job_id', '=', 'jobs.job_id')
                ->leftJoin('job_jobgroup', 'job_jobgroup.job_id', '=', 'jobs.job_id');
            if (!empty($careerSearch)) {
                $jobs = $jobs->where('job_career_categories.career_category_id', $careerSearch);
            }

            if (!empty($literacySearch)) {
                $jobs = $jobs->where('jobs.literacy_id', $literacySearch);
            }

            if (!empty($salarySearch)) {
                $jobs = $jobs->where('jobs.salary_id', $salarySearch);
            }

            if (!empty($jobGroupSearch)) {
                $jobs = $jobs->where('job_jobgroup.job_group_id', $jobGroupSearch);
            }

            if (!empty($saleSearch)) {
                $jobs = $jobs->where('job_sale_package.sale_package_id', $saleSearch);

            }

            if (!empty($provinceSearch)) {
                $jobs = $jobs->where('jobs.province', $provinceSearch)
                    ->where('jobs.district', $districtSearch);
            }

            if (!empty($startSearch)) {
                $jobs = $jobs->where('jobs.date_submit', '>=', $startSearch);
            }

            if (!empty($endSearch)) {
                $jobs = $jobs->where('jobs.date_submit', '<=', $endSearch);
            }

            if (!empty($title)) {
                $jobs = $jobs->where('jobs.title', 'like', '%' . $request->input('title') . '%');
            }

            $jobs = $jobs->select([
                'jobs.job_id as job_id',
                'employer.enterprise_name as enterprise_name',
                'jobs.title as title',
                'jobs.number_recruit as number_recruit',
                'jobs.applicants as applicants',
                'jobs.number_recruited as number_recruited',
                'jobs.deadline_submit_profile as deadline_submit_profile',
                'sale_package.sale_package_name as sale_package_name',
                'jobs.people_seen as people_seen'
            ]);

            $jobs = $jobs->orderByDesc('jobs.job_id')->paginate(10);

            $jobs = $jobs->appends(['career' => $careerSearch, 'literacy' => $literacySearch, 'salary' => $salarySearch,
                'jobGroup' => $jobGroupSearch, 'sale' => $saleSearch, 'province' => $provinceSearch, 'district' => $districtSearch,
                'start_at' => $startSearch, 'end_at' => $endSearch, 'title' => $title]);

            return view('jobs.job.search', compact('jobs', 'careerSearch', 'literacySearch', 'salarySearch', 'jobGroupSearch',
                'saleSearch', 'provinceSearch', 'districtSearch', 'startSearch', 'endSearch', 'title'));
        }

        return redirect(route('job.index'));
    }
    public function update_job_code(Request $request)
    {
        $job = new Job();
        $list_jobs = $job->select('job_id','job_code')->get();
        foreach ($list_jobs as $jobs)
        {
            $update =  $job->where('job_id',$jobs->job_id)->update([
                'job_code' => 'SKT'.$jobs->job_id
            ]);
        }
        return redirect(route('job.index'));
    }
    public function list_date_end(Request $request)
    {
//        mb_strlen($job->content, 'UTF-8')
        $jobs = new Job();
        $jobs = $jobs->select(
            'jobs.*','employer.employer_id as employers_id ','employer.enterprise_name','employer.email'
        );
        $jobs = $jobs->join('employer','employer.employer_id','=','jobs.employer_id');
//        danh mục ngành nghề
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
//        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
//        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
//        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
//        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
//        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
//        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
//        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title','like', '%'.$title.'%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('jobs.title','job_code', '%'.$job_code.'%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email','like', '%'.$email.'%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobs = $jobs->where('jobs.employer_id', $request->input('employer_id'));
        }


        $jobs = $jobs->whereDate('jobs.deadline_submit_profile', '<=', date('Y-m-d'));
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $total_job = $jobs->count();
        $jobs = $jobs->paginate(50);

        $jobs->appends(request()->query());
        return view('jobs.job.list_date_end', compact('jobs', 'total_job'));
    }
    public function list_vip(Request $request)
    {
//        mb_strlen($job->content, 'UTF-8')
        $jobs = new Job();
        $jobs = $jobs->select(
            'jobs.*','employer.employer_id as employers_id ','employer.enterprise_name','employer.email'
        );
        $jobs = $jobs->join('employer','employer.employer_id','=','jobs.employer_id');
//        danh mục ngành nghề
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
//        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
//        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
//        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
//        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
//        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
//        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
//        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title','like', '%'.$title.'%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('jobs.title','job_code', '%'.$job_code.'%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email','like', '%'.$email.'%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobs = $jobs->where('jobs.employer_id', $request->input('employer_id'));
        }


        $jobs = $jobs->where('jobs.vip', 1);
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $total_job = $jobs->count();
        $jobs = $jobs->paginate(50);

        $jobs->appends(request()->query());
        return view('jobs.job.list_vip', compact('jobs', 'total_job'));
    }
    public function list_believe(Request $request)
    {
//        mb_strlen($job->content, 'UTF-8')
        $jobs = new Job();
        $jobs = $jobs->select(
            'jobs.*','employer.employer_id as employers_id ','employer.enterprise_name','employer.email'
        );
        $jobs = $jobs->join('employer','employer.employer_id','=','jobs.employer_id');
//        danh mục ngành nghề
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
//        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
//        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
//        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
//        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
//        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
//        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
//        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title','like', '%'.$title.'%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('jobs.title','job_code', '%'.$job_code.'%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email','like', '%'.$email.'%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobs = $jobs->where('jobs.employer_id', $request->input('employer_id'));
        }
        $jobs = $jobs->where('jobs.vip', 0);
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $total_job = $jobs->count();
        $jobs = $jobs->paginate(50);

        $jobs->appends(request()->query());
        return view('jobs.job.list_believe', compact('jobs', 'total_job'));
    }
    public function list_delete(Request $request)
    {
        //        mb_strlen($job->content, 'UTF-8')
        $jobs = new Job();
        $jobs = $jobs->onlyTrashed()->select(
            'jobs.*','employer.employer_id as employers_id ','employer.enterprise_name','employer.email'
        );
        $jobs = $jobs->join('employer','employer.employer_id','=','jobs.employer_id');
//        danh mục ngành nghề
        if (!empty($request->input('career_category_id'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('career_category_id'));
        }
//        Trình độ yêu cầu
        if (!empty($request->input('literacy'))) {
            $jobs = $jobs->where('jobs.literacy_id', $request->input('literacy'));
        }
//        Mức lương
        if (!empty($request->input('salary'))) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('salary'));
        }
//        Nhóm việc làm
        if (!empty($request->input('jobGroup'))) {
            $jobs = $jobs->where('jobs.jobgroup_id', $request->input('jobGroup'));
        }
//        Gói bán hàng
        if (!empty($request->input('sale'))) {
            $jobs = $jobs->where('jobs.sale_package_id', $request->input('sale'));
        }
//        Tỉnh /thành phố
        if (!empty($request->input('province'))) {
            $jobs = $jobs->where('jobs.province', $request->input('province'));
        }
//        Quận / huyên
        if (!empty($request->input('district'))) {
            $jobs = $jobs->where('jobs.district', $request->input('district'));
        }
//        Tên công viêcj
        if (!empty($request->input('title'))) {
            $title = $request->input('title');
            $jobs = $jobs->where('jobs.title','like', '%'.$title.'%');
        }
        if (!empty($request->input('job_code'))) {
            $job_code = $request->input('job_code');
            $jobs = $jobs->where('jobs.title','job_code', '%'.$job_code.'%');
        }
        if (!empty($request->input('email'))) {
            $email = $request->input('email');
            $jobs = $jobs->where('employer.email','like', '%'.$email.'%');
        }
        if (!empty($request->has('vip'))) {
            $jobs = $jobs->where('jobs.vip', $request->input('vip'));
        }
        if (!empty($request->input('employer_id'))) {
            $jobs = $jobs->where('jobs.employer_id', $request->input('employer_id'));
        }



        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $total_job = $jobs->count();
        $jobs = $jobs->paginate(50);

        $jobs->appends(request()->query());
        return view('jobs.job.list_delete', compact('jobs', 'total_job'));
    }

    public function Jobsrestore(Request $request, $job_id)
    {
        try {
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {
                $jobs_model = new Job();

                $restore = $jobs_model->withTrashed()->where('job_id', $job_id)->restore();

                //khoi phuc ban ghi
                DB::commit();
                return redirect(route('list_delete'))->with('success','Khôi phục thành công');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('list_delete'))->with('error','Khôi phục thất bại');
        }


    }

    public function JobsForceDelete(Request $request, $job_id)
    {
        try
        {
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {
                $jobs_model = new Job();
                $forceDelete = $jobs_model->withTrashed()->where('job_id', $job_id)->forceDelete();
            }
            DB::commit();
            return redirect(route('list_delete'))->with('success','Xóa vĩnh viễn thành công');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect(route('list_delete'))->with('success','Xóa vĩnh viễn thất bại');
        }
    }
}
