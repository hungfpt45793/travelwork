<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 5/31/2019
 * Time: 3:32 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Career;
use App\Entity\District;
use App\Entity\Job;
use App\Entity\JobFacebook;
use App\Entity\JobGroup;
use App\Entity\Province;
use App\Ultility\Ultility;
use Illuminate\Http\Request;

class JobGroupController extends SiteController
{
    public function index($jobGroupSlug, Request $request)
    {
        // lấy ra nhóm việc làm
        $user = auth()->user();
        $jobGroup = JobGroup::where('slug', $jobGroupSlug)->first();

        $jobs = $this->getJobs($request);

        $jobs = $jobs->join('job_jobgroup', 'job_jobgroup.job_id', 'jobs.job_id')
            ->where('job_jobgroup.job_group_id', $jobGroup->job_group_id)
            ->paginate(10);


        return view('site.jobs.job_group', compact('jobGroup', 'jobs', 'user'));
    }


    public function city($cityId, Request $request)
    {

        $province = Province::where('province_id', $cityId)->first();

        $jobs = $this->getJobs($request);
        // nếu là tỉnh thành khác
        if ($cityId == 0) {
            $jobs = $jobs->where('jobs.province', '<>', 1)
                ->where('jobs.province', '<>', 1)
                ->where('jobs.province', '<>', 79)
                ->where('jobs.province', '<>', 48)
                ->where('jobs.province', '<>', 92)
                ->where('jobs.province', '<>', 31)
                ->paginate(10);

            return view('site.jobs.city_list_job', compact('province', 'jobs'));
        }
        // nếu là tỉnh thành trực thuộc trung ương
        $jobs = $jobs->where('jobs.province', $cityId)->paginate(10);

        return view('site.jobs.city_list_job', compact('province', 'jobs'));
    }

    public function search(Request $request)
    {

        $jobs = $this->getJobs($request);

        $jobs = $jobs->paginate(10);

        return view('site.jobs.search_job', compact('jobs'));
    }

    private function getJobs($request)
    {
        $jobs = Job::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
            ->leftJoin('province', 'province.province_id', 'jobs.province')
            ->leftJoin('district', 'district.district_id', 'jobs.district')
            ->select(
                'jobs.*',
                'salary.description as salary_description',
                'employer.enterprise_name',
                'employer.image',
                'employer.latitude',
                'employer.longitude',
                'employer.image as employer_image',
                'district_name',
                'province_name'
            )
            ->orderBy('job_id', 'desc');

        // tìm kiếm với thành phố
        if ($request->has('city_id') && $request->input('city_id') != 0) {
            $jobs = $jobs->where('jobs.province', $request->input('city_id'));
        }

        // tim kiem viec lam
        if ($request->has('word') && !empty($request->input('word'))) {
            $word = Ultility::createSlug($request->input('word'));
            $arrayWords = explode('-', $word);
            $jobSearchs = array();

            foreach ($arrayWords as $id => $word) {
                if ($id == 0) {
                    $jobSearchs = Job::where('jobs.slug', 'like', '%' . $word . '%')
                        ->orWhere('jobs.slug', 'like', $word . '%');
                } else {
                    $jobSearchs = $jobSearchs->orWhere('jobs.slug', 'like', '%' . $word . '%')
                        ->orWhere('jobs.slug', 'like', $word . '%');
                }
            }

            $jobSearchs = $jobSearchs->select('job_id')->get();
            $jobIdSearch = array();
            foreach ($jobSearchs as $jobSearch) {
                $jobIdSearch[] = $jobSearch->job_id;
            }

            $jobs = $jobs->whereIn('jobs.job_id', $jobIdSearch);
        }

        // tìm kiếm theo ngành nghề

        // echo count($request->input('careers')); exit;
        if ($request->has('careers') && !empty($request->input('careers'))) {
            if (!(count($request->input('careers')) == 1 && $request->input('careers')[0] == null)) {
                $jobs = $jobs->join('job_career_categories', 'job_career_categories.job_id', 'jobs.job_id')
                    ->whereIn('job_career_categories.career_category_id', $request->input('careers'));
            }
        }

        // tìm kiếm theo mức lương
        if ($request->has('salaries') && !empty($request->input('salaries'))) {
            if (!(count($request->input('salaries')) == 1 && $request->input('salaries')[0] == null)) {
                $jobs = $jobs->whereIn('jobs.salary_id', $request->input('salaries'));
            }
        }

        // tìm kiếm theo tỉnh thành
        if ($request->has('province') && !empty($request->input('province'))) {
            if (!(count($request->input('province')) == 1 && $request->input('province')[0] == null)) {
                $jobs = $jobs->whereIn('province.province_id', $request->input('province'));
            }
        }

        return $jobs;
    }

    public function getMap(Request $request)
    {
        $jobs = $this->getJobs($request);

        $jobs = $jobs->paginate(10);

        return view('site.default.google_map', compact('jobs'));
    }

    public function listCateJob(Request $request)
    {
        $user = auth()->user();
        $jobModel = new Job();
        $jobs_vip = $jobModel
            ->join('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile'
            );
        $jobs_vip = $jobs_vip->where('jobs.vip', 1);
        $jobs_vip = $jobs_vip->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $jobs_vip = $jobs_vip->orderBy('jobs.job_id', 'asc');
        //tong so bai viet

        $jobs_vip = $jobs_vip->limit(10)->get();
//        luu url khi phan trang


        $jobs = $jobModel
            ->join('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile'
            );
        $jobs = $jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $jobs = $jobs->orderBy('jobs.salary_id', 'desc');
        //tong so bai viet
        $total_jobs = $jobs->count();
        $jobs = $jobs->paginate(18);
//        luu url khi phan trang
        $jobs->appends(request()->query());


        $jobs_new = $jobModel
            ->join('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile'
            );
        $jobs_new = $jobs_new->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $jobs_new = $jobs_new->orderBy('jobs.job_id', 'desc');
        //tong so bai viet
        $total_jobs = $jobs->count();
        $jobs_new = $jobs_new->paginate(18);
//        luu url khi phan trang
        $jobs_new->appends(request()->query());

        return view('site.jobs.category_job', compact('jobs_vip', 'jobs', 'jobs_new', 'user', 'total_jobs'));
    }

    public function submit_search(Request $request)
    {
        $user = auth()->user();
        $career = 'tuyen-ke-toan';
        if (!empty($request->input('career'))) {
            $career = 'tuyen-' . $request->input('career');
        }
        $career .= '';
        if (!empty($request->input('province'))) {
            $career .= '-tai-' . $request->input('province');
        }
        $career_caetgory = Career::select('*')->where('career_category_slug',$request->input('career'))->first();
        $provice = Province::select('*')->where('province_slug',$request->input('province'))->first();
        $district = District::select('*')->where('district_slug',$request->input('district'))->first();

        $career .= '?';
        if (!empty($request->input('career'))) {
            $career .= 'c='.$career_caetgory['career_category_id'];
        }
        if (!empty($request->input('province'))) {
            $career .= '&p='.$provice['province_id'];
        }
        if (!empty($request->input('district'))) {
            $career .= '&q=' . $district['district_id'];
        }
        if (!empty($request->input('salary'))) {
            $career .= '&l=' . $request->input('salary');
        }
        if ($request->has('vip')) {
            $career .= '&v=' . $request->input('vip');
        }
        if (!empty($request->input('word'))) {
            $career .= '&w=' . $request->input('word');
        }
        return redirect(route('search_job', ['slug' => $career]));

    }

    public function search_job(Request $request, $slug)
    {
        $jobModel = new Job();
        $jobs = $jobModel
            ->join('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile'
            );

        $career = new Career();
        $career = $career->select('*')->where('career_category_slug', 'like', '%' . $slug . '%')->first();


        if (!empty($request->input('c'))) {
            $jobs = $jobs->where('jobs.career_category_id', $request->input('c'));
        }
        if ($request->has('v')) {
            $vip = $request->input('v');
            if ($vip != '') {
                if ($vip == 1) {
                    $jobs = $jobs->where('jobs.vip', $vip);
                } elseif ($vip == 0) {
                    $jobs = $jobs->whereNull('jobs.vip');
                    $jobs = $jobs->orWhere('jobs.vip', '<>', 1);
                }
            }
        }
        if (!empty($request->input('p'))) {
            $jobs = $jobs->where('jobs.province', $request->input('p'));
        }

        if (!empty($request->input('q'))) {
            if (!empty($request->input('q'))) {
                $jobs = $jobs->where('jobs.district', $request->input('q'));
            }
        } else {
            if (!empty($request->input('p'))) {
                $jobs = $jobs->orWhere('jobs.province', $request->input('p'));
            }
        }
        if ($request->input('l')) {
            $jobs = $jobs->where('jobs.salary_id', $request->input('l'));
        }
        if (!empty($request->input('w'))) {
            $word = $request->input('w');
            $jobs = $jobs->where('jobs.title', 'like', '%' . $word . '%');
        }
        $jobs = $jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $jobs = $jobs->orderBy('jobs.job_id', 'desc');
        $count = $jobs->count();
        //tong so bai viet
        $jobs = $jobs->paginate(18);
//        luu url khi phan trang
        $jobs->appends(request()->query());
        return view('site.jobs.search_job', compact('jobs', 'count'));
    }
}