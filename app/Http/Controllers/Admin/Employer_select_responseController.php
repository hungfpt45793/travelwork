<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Career;
use App\Entity\Employer;
use App\Entity\Employer_response_cv;
use App\Entity\Employer_select_response;
use App\Entity\Employer_select_response_cv;
use App\Entity\JobCareer;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class Employer_select_responseController extends AdminController {
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
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'employer_coin');

            return $next($request);
        });
    }

    public function index()
    {
        $total = Employer_select_response::select('*')->count();
        $Employer_select_response = Employer_select_response::select('*')->get();

        return view('admin.employer_select_response.list', compact('Employer_select_response', 'total'));
    }
    public function list_employer_feedback(Request $request)
    {
        $employer_select_response = Employer_select_response::select('*')->get();
        return view('admin.employer_select_response.list_feedback', compact('employer_select_response', 'total'));
    }
    public function detail_feedback_employer(Request $request,$employer_select_response_id)
    {
        $employer_select_response = Employer_select_response::where('employer_select_response_id',$employer_select_response_id)->first();
        $list_response_cv = Employer_select_response_cv::select('employer_select_response_cv.*','employer_response_cv.employer_id','employer_response_cv.employee_id','employees.employee_name',
            'employees.employee_slug',
            'employees.employee_image',
            'employees.phone as employee_phone',
            'employees.email as employee_email',
            'employer.employer_id',
            'employer.employer_code',
            'employer.enterprise_name',
            'employer.phone as employer_phone',
            'employer.email as employer_email',
            'employer.slug as employer_slug'
            )
            ->join('employer_response_cv','employer_response_cv.employer_response_cv_id','employer_select_response_cv.employer_response_cv_id')
            ->join('employees','employees.employee_id','employer_response_cv.employee_id')
            ->join('employer','employer.employer_id','employer_response_cv.employer_id')
            ->where('employer_select_response_cv.employer_select_response_id',$employer_select_response_id)
            ->paginate(20);
//        echo '<pre>';
//        print_r($employer_select_response);die;
        return view('admin.employer_select_response.detail_employer_feedback', compact('employer_select_response', 'list_response_cv'));
    }
    public function employer_feedback_coin($employer_response_cv_id,$cojn_view_profile)
    {
        $response_cv = Employer_response_cv::where('employer_response_cv_id',$employer_response_cv_id)->first();

        $list_response_cv = Employer_response_cv::where('employee_id',$response_cv->employee_id)
            ->where('employer_id',$response_cv->employer_id)
            ->get();
        foreach($list_response_cv as $list)
        {
            $update_response = Employer_select_response_cv::where('employer_response_cv_id',$list->employer_response_cv_id)->update([
                'status_response' => 1
            ]);
        }
        $coin_employer = Employer::where('employer_id',$response_cv->employer_id)->first();
        $employer_coin = $coin_employer->employer_coin + $cojn_view_profile;
        $total_employer_coin = $coin_employer->total_employer_coin + $cojn_view_profile;

        $update_coin_employer = Employer::where('employer_id',$response_cv->employer_id)->update([
            'employer_coin' => $employer_coin,
            'total_employer_coin' => $total_employer_coin
        ]);
        return redirect()->back()->width('success','Trả lại điểm nahf tuyển dụng thành công');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.employer_select_response.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert = Employer_select_response::insert([
            'response' => $request->input('response'),
            'created_at'=> new \DateTime(),
        ]);
        return redirect(route('employer_select_response.index'))->with('thêm mới thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function show(Career $career)
    {
        //
    }

    public function edit($id)
    {
        $employer_select_response = Employer_select_response::where('employer_select_response_id',$id)->first();
        return view('admin.Employer_select_response.edit', compact('employer_select_response'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Employer_select_response::where('employer_select_response_id',$id)->update([
            'response' => $request->input('response'),
            'updated_at'=> new \DateTime(),
        ]);
        return redirect(route('employer_select_response.index'))->with('cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Employer_select_response::where('employer_select_response_id',$id)->delete();
        return redirect(route('employer_select_response.index'))->with('Xóa thành công');
    }
}
