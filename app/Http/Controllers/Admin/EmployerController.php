<?php

namespace App\Http\Controllers\Admin;

use App\Support\SpreadsheetFile;
use App\Entity\Business;
use App\Entity\District;
use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\EmployerAgency;
use App\Entity\EmployerBusiness;
use App\Entity\EmployerIntership;
use App\Entity\EmployerRepresentative;
use App\Entity\EmployerTransaction;
use App\Entity\EmployerTypeBusiness;
use App\Entity\Job;
use App\Entity\JobFacebook;
use App\Entity\MailConfig;
use App\Entity\NoteEmployer;

use App\Entity\StarEmployer;
use App\Entity\TeacherStar;
use App\Entity\TypeOfBusiness;
use App\Entity\User;
use App\Exam\CommentExam;
use App\Exam\StarExam;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Entity\Teacher;
use Illuminate\Support\Facades\Log;
use App\Entity\Employer_delete_request;


class EmployerController extends AdminController
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
            view()->share('menuTop', 'customers');
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
        //        if(!empty($request->input('delete_id')))
        //        {
        //            $data_id = $request->input('delete_id');
        //            print_r($data_id);die();
        //        }
        $employers = new Employer();
        $employers = $employers->leftJoin('employer_typeof_business', 'employer_typeof_business.employer_id', '=', 'employer.employer_id');
        $employers = $employers->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'employer.business');
        $employers = $employers->leftJoin('users', 'users.id', 'employer.user_id');
        $employers = $employers->leftJoin('business_type', 'business_type.business_type_id', '=', 'employer.type_of_business_id');
        $employers = $employers->leftJoin('employer_agency', 'employer_agency.employer_id', '=', 'employer.employer_id');
        //            ->leftJoin('type_of_business','type_of_business.type_of_business_id','=','employer_typeof_business.type_of_business_id')
        $employers = $employers->select(
            'employer.employer_id',
            'employer.employer_code',
            'employer.business',
            'employer.employer_vip',
            'employer.employer_coin',
            'business_type.business_type_name',
            'type_of_business.type_of_business_name',
            'employer.enterprise_name',
            'employer.image',
            'employer.email',
            'employer.phone',
            'users.name',
            'employer.district',
            'employer.province',
            'employer.status',
            'employer.status_agency',
            'employer.total_money_coin',
            'employer.status_intership',
            'employer.status_agency',
            'employer_agency.code_intro'
        );

        if (!empty($request->input('business'))) {
            $business = $request->input('business');
            $employers = $employers->where('employer.business', $business);
        }
        if (!empty($request->input('type_of_business_id'))) {
            $type_of_business_id = $request->input('type_of_business_id');
            $employers = $employers->where('employer.type_of_business_id', $type_of_business_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employers = $employers->where('employer.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employers = $employers->where('employer.district', $district);
        }
        if (!empty($request->input('enterprise_name'))) {
            $enterprise_name = $request->input('enterprise_name');
            $employers = $employers->where('enterprise_name', 'like', '%' . $enterprise_name . '%');
        }
        if (!empty($request->input('email'))) {

            $email = $request->input('email');
            $employers = $employers->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('status_intership'))) {
            $status_intership = $request->input('status_intership');
            $employers = $employers->where('employer.status_intership', $status_intership);
        }
        if (!empty($request->input('status_agency'))) {
            $status_agency = $request->input('status_agency');
            $employers = $employers->where('employer.status_agency', $status_agency);
        }
        $total = $employers->count();

        $employers = $employers->orderBy('employer.employer_id', 'desc');
        $employers = $employers->paginate(20);
        $employers->appends(request()->query());


        return view('customers.employer.list', compact('employers', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typeBusinessList = TypeOfBusiness::orderBy('type_of_business_name')->get();
        $businessList = Business::orderBy('business_type_name')->get();
        $staff = User::where('role', 3)->orderBy('name')->get();
        return view('customers.employer.add', compact('typeBusinessList', 'businessList', 'staff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'address' => 'required',
            'employer_name' => 'required',
            'phone' => 'required'
        ], [
            //            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
            'address.required' => 'Địa chỉ công ty không được bỏ trống',
            'employer_name.required' => 'Tên công ty không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $userModel = new User();
            $user_id_create = $userModel->insertGetId([
                'name' => $request->input('employer_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->has('phone') ? $request->input('phone') : '',
                'role' => 2
            ]);
            $employerId = Employer::insertGetId([
                'enterprise_name' => $request->input('employer_name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'website' => $request->input('website'),
                'district' => $request->input('district'),
                'province' => $request->input('province'),
                'type_of_business_id' => $request->input('type_of_business_id'),
                'business' => $request->input('business'),
                'status' => $request->input('status'),
                'address' => $request->input('address'),
                'introduction' => $request->input('introduction'),
                'user_id' => $user_id_create,
                'image' => $request->input('image'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'is_admin' => $request->input('is_admin'),
                'images_list' => $request->input('images_list'),
                'status_intership' => $request->input('status_intership'),
                'status_agency' => $request->input('status_agency'),
                'service_agency' => $request->input('service_agency'),
                'banner_intership' => $request->input('banner_intership'),
                'des_intership' => $request->input('des_intership'),
                'content_intership' => $request->input('content_intership'),
                'employer_vip' => $request->input('employer_vip'),
                'status_allowance' => $request->input('status_allowance'),
            ]);
            $slug = Ultility::createSlug($request->input('employer_name'));
            if (!empty(Employer::where('slug', $slug)->first())) {
                $slug .= '-' . $employerId;
            }
            Employer::where('employer_id', $employerId)->update([
                'slug' => $slug
            ]);
            DB::commit();
            return redirect(route('employer.index'))->with('success', 'thêm nhà tuyển dụng thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể thêm mới dữ liệu : Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollBack();
            return redirect(route('employer.index'))->with('error', 'thêm nhà tuyển dụng thất bại');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employer $employer)
    {
        $typeBusinessList = TypeOfBusiness::orderBy('type_of_business_name')->get();
        $businessList = Business::orderBy('business_type_name')->get();

        $staff = User::where('role', 3)->get();
        $employerTypeBusinessList = EmployerTypeBusiness::where('employer_id', $employer->employer_id)->get();
        $employerBusinessList = EmployerBusiness::where('employer_id', $employer->employer_id)->get();
        $representatives = EmployerRepresentative::where('employer_id', $employer->employer_id)->get();
        $staffCharge = User::where('id', $employer->user_id)->first();
        $employer_agency = EmployerAgency::select('*')->where('employer_id', $employer->employer_id)->first();

        //        print_r($employer_agency);die();
        return view('customers.employer.edit', compact(
            'employer',
            'typeBusinessList',
            'businessList',
            'staff',
            'employerTypeBusinessList',
            'employerBusinessList',
            'representatives',
            'staffCharge',
            'employer_agency'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employer $employer)
    {
        //        echo $request->input('type_of_business_id');
        //        echo $request->input('business');
        //        die();
        $validation = Validator::make($request->all(), [
            'address' => 'required',
            'employer_name' => 'required',
            'phone' => 'required'
        ], [
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
            'address.required' => 'Địa chỉ công ty không được bỏ trống',
            'employer_name.required' => 'Tên công ty không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',

        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        //        try {
        //            DB::beginTransaction();

        $userModel = new User();
        $user = $userModel->where('id', $employer->user_id)->first();

        $isChangePassword = $request->input('is_change_password');
        if ($isChangePassword == 1) {
            $user->update([
                'name' => $request->input('employer_name'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->has('phone') ? $request->input('phone') : ''
            ]);
        }

        $employers = new Employer();
        $updateEmployer = $employers->where('employer_id', $employer->employer_id)->update([
            'enterprise_name' => $request->input('employer_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
            'district' => $request->input('district'),
            'province' => $request->input('province'),
            'type_of_business_id' => $request->input('type_of_business_id'),
            'business' => $request->input('business'),
            'status' => $request->input('status'),
            'address' => $request->input('address'),
            'introduction' => $request->input('introduction'),
            'image' => $request->input('image'),
            'is_admin' => $request->input('is_admin'),
            'images_list' => $request->input('images_list'),
            'status_intership' => $request->input('status_intership'),
            'status_agency' => $request->input('status_agency'),
            'service_agency' => $request->input('service_agency'),
            'banner_intership' => $request->input('banner_intership'),
            'des_intership' => $request->input('des_intership'),
            'content_intership' => $request->input('content_intership'),
            'employer_vip' => $request->input('employer_vip'),
            'status_allowance' => $request->input('status_allowance'),

        ]);
        //            DB::commit();
        return redirect(route('employer.index'))->with('success', 'Cập nhật nhà tuyển dụng thành công');
        //        } catch (\Exception $exception) {
        //            Error::setErrorMessage('Không thể thêm mới dữ liệu : Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
        //            DB::rollBack();
        //            return redirect(route('employer.index'))->with('error', 'Cập nhật nhà tuyển dụng thất bại');
        //        }


    }

    public function show_employer_angency(Request $request, $employer_id)
    {

        $employer_agency = new EmployerAgency();
        $employer_agency = $employer_agency->select('*')->where('employer_id', $employer_id)->first();

        $employer = Employer::where('employer_id', $employer_id)->first();
        return view('customers.employer.agency', compact('employer_agency', 'employer'));
    }
    public function employer_angency(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'code_intro' => 'required|unique:employer_agency',
        ], [
            //            'enterprise_id.unique' => 'Email đã tồn tại.',
            'code_intro.unique' => 'Mã giới thiệu đã tồn tại',
            'code_intro.required' => 'Mã giới thiệu không được để trống',

        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        $employer_agency = new EmployerAgency();
        $employer_id = $request->input('employer_id');
        if (!empty($request->input('agency_id'))) {
            $update = $employer_agency->where('employer_id', $employer_id)->update([
                'code_intro' => $request->input('code_intro'),
            ]);
            $update_employer = Employer::where('employer_id', $employer_id)->update([
                'status_agency' => 1
            ]);
        } else {
            $update = $employer_agency->insert([
                'code_intro' => $request->input('code_intro'),
                'employer_id' => $request->input('employer_id'),
            ]);
            $update_employer = Employer::where('employer_id', $employer_id)->update([
                'status_agency' => 1
            ]);
        }
        return redirect(route('employer.index'))->with('success', 'Thêm mã giới thiệu thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($employer_id)
    {
        try {
            DB::beginTransaction();

            //            xóa user
            $employer = new Employer();
            $employer = $employer->select('*')->where('employer_id', $employer_id)->first();
            $user = new User();
            $user = $user->where('id', $employer->user_id)->delete();
            $employer->delete();
            //xóa tin tuyen dung
            $jobs = new Job();
            $jobs = $jobs->where('employer_id', $employer->employer_id)->delete();

            //xóa tin tuyen facebook

            $jobfacebook = new  JobFacebook();
            $jobfacebook = $jobfacebook->where('employer_id', $employer->employer_id)->delete();

            DB::commit();

            return redirect(route('employer.index'))->with('success', 'Xóa nhà tuyển dụng thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể xóa dữ liệu : Đã có lỗi xảy ra');
            DB::rollBack();
            return redirect(route('employer.index'))->with('error', 'Xóa nhà tuyển dụng thất bại');
        }
    }

    public function list_intership(Request $request, $employer_id)
    {

        $intership = new EmployerIntership();
        $intership = $intership->select('*')
            ->where('employer_id', $employer_id)
            ->orderBy('intership_id', 'desc');
        $total = $intership->count();
        $intership = $intership->get();

        return view('customers.employer.show_intership', compact('intership', 'total'));
    }

    public function update_status_intership(Request $request)
    {
        try {
            $intership_id = $request->input('intership_id');
            $interships = new EmployerIntership();

            $inter = $interships->select('*')->where('intership_id', $intership_id)->first();
            $intership = $interships->where('intership_id', $intership_id)->update([
                'status_intership' => $request->input('status_intership')
            ]);

            $employee = new Employee();
            $employee = $employee->select('email', 'employee_id')->where('employee_id', $inter->employee_id)->first();

            $employer = new Employer();
            $employer = $employer->select('employer_id', 'enterprise_name')->where('employer_id', $inter->employer_id)->first();

            if (!empty($employee->email) && $request->input('status_intership') == 1) {
                $subject = 'Sanketoan.vn thông báo';
                $content = $employer->enterprise_name . '<p> đã xác nhận hồ sơ thực tập của bạn thực tập của bạn !</p>';
                $content .= '<p> Chi tiết xem tại tủ hồ sơ của <a href="https://sanketoan.vn/">sanketoan.vn</a></p>';
                MailConfig::sendMail($employee->email, $subject, $content);
            }
            return redirect(route('admin_list_intership', ['employer_id' => $employer->employer_id]))->with('suscess', 'Cập nhật trạng thái tuyển thực tập thành công');
        } catch (\Exception $e) {
            return redirect(route('admin_list_intership', ['employer_id' => $employer->employer_id]))->with('erorr', 'Cập nhật trạng thái tuyển thực tập thất bại');
        }
    }

    public function delete_intership(Request $request)
    {
        try {
            $intership_id = $request->input('intership_id');
            $intership = new EmployerIntership();
            $intership = $intership->where('intership_id', $intership_id)->first();
            $employer = new Employer();
            $employer = $employer->select('employer_id', 'enterprise_name')->where('employer_id', $intership->employer_id)->first();


            $delete = $intership->where('intership_id', $intership_id)->delete();

            return redirect(route('admin_list_intership', ['employer_id' => $employer->employer_id]))->with('suscess', 'Xóa hồ sơ thực tập thành công');
        } catch (\Exception $e) {
            return redirect(route('admin_list_intership', ['employer_id' => $employer->employer_id]))->with('erorr', 'Xóa hồ sơ thực tập thất bại');
        }
    }

    public function anyDatatable()
    {
        $employers = Employer::leftJoin('employer_typeof_business', 'employer_typeof_business.employer_id', '=', 'employer.id')
            ->leftJoin('employer_business_type', 'employer_business_type.employer_id', '=', 'employer.id')
            ->leftJoin('users', 'users.id', 'employer.user_id')
            ->leftJoin('business_type', 'business_type.business_type_id', '=', 'employer_business_type.business_type_id')
            ->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'employer_typeof_business.type_of_business_id')
            ->select(
                'employer.id',
                'employer.employer_id',
                'employer.enterprise_name',
                'type_of_business.type_of_business_name',
                'business_type.business_type_name',
                'employer.image',
                'users.name',
                'employer.status',
                'employer.total_money_coin'
            );

        return Datatables::of($employers)
            ->addColumn('action', function ($employer) {
                $string = '<a href="' . route('employer.edit', ['employer' => $employer->employer_id]) . '">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('employer.destroy', ['employer' => $employer->employer_id]) . '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                $string .= '<a href="' . route('transaction', ['employer_id' => $employer->id]) . '">
                                <button type="button" class="btn btn-primary">Lịch sử giao dịch</button>
                           </a>';
                return $string;
            })
            ->orderColumn('employer.id', 'employer.id desc')
            ->make(true);
    }

    public function note(Request $request)
    {
        $idEmployer = NoteEmployer::insertGetId([
            'note' => $request->input('content'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        $string = '<p> -' . $request->input('content') . '. </p>
                    <input type="hidden" name="idEmployer" value="' . $idEmployer . '">';
        echo $string;
    }

    // Lịch sử giao dịch nhà tuyển dụng
    public function transaction(Employer $employer)
    {
        $transactions = EmployerTransaction::leftJoin('employees', 'employees.employee_id', '=', 'employer_transaction.employee_id')
            ->leftJoin('jobs', 'jobs.job_id', '=', 'employer_transaction.job_id')
            ->where('employer_transaction.employer_id', $employer->employer_id)->paginate(10);
        return view('customers.employer.transaction', compact('employer', 'transactions'));
    }

    public function search(Request $request)
    {
        $typeSearch = $request->input('type');
        $businessSearch = $request->input('business');
        $provinceSearch = $request->input('province');
        $districtSearch = $request->input('district');
        $statusSearch = $request->input('status');
        $keywordSearch = $request->input('keyword');

        if (!empty($typeSearch) || !empty($businessSearch) || !empty($provinceSearch) || !empty($districtSearch) || $statusSearch != -1 || !empty($keywordSearch)) {
            $employers = Employer::leftJoin('employer_typeof_business', 'employer_typeof_business.employer_id', '=', 'employer.id')
                ->leftJoin('employer_business_type', 'employer_business_type.employer_id', '=', 'employer.id')
                ->leftJoin('users', 'users.id', 'employer.user_id')
                ->leftJoin('business_type', 'business_type.business_type_id', '=', 'employer_business_type.business_type_id')
                ->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'employer_typeof_business.type_of_business_id');

            if (!empty($typeSearch)) {
                $employers = $employers->where('employer_typeof_business.type_of_business_id', $typeSearch);
            }

            if (!empty($businessSearch)) {
                $employers = $employers->where('employer_business_type.business_type_id', $businessSearch);
            }

            if (!empty($provinceSearch)) {
                $employers = $employers->where('employer.province', $provinceSearch)
                    ->where('employer.district', $districtSearch);
            }

            if ($statusSearch != -1) {
                $employers = $employers->where('employer.status', $statusSearch);
            }

            if (!empty($keywordSearch)) {
                $employers = $employers->where('employer.enterprise_name', 'like', '%' . $keywordSearch . '%');
            }

            $employers = $employers->select(
                'employer.id as employer_id',
                'employer.employer_id as enterprise_id',
                'employer.enterprise_name as enterprise_name',
                'employer.image as image',
                'type_of_business.type_of_business_name as type_of_business_name',
                'business_type.business_type_name as business_type_name',
                'employer.status as status',
                'employer.total_money as total_money',
                'employer.number_recruit_require as number_recruit_require',
                'employer.recruited as recruited'
            );

            $employers = $employers->orderByDesc('employer.id')->paginate(10);
            $employers = $employers->appends([
                'type' => $typeSearch, 'business' => $businessSearch, 'province' => $provinceSearch, 'district' => $districtSearch,
                'status' => $statusSearch, 'keyword' => $keywordSearch
            ]);

            return view('customers.employer.search', compact(
                'employers',
                'typeSearch',
                'businessSearch',
                'provinceSearch',
                'districtSearch',
                'statusSearch',
                'keywordSearch'
            ));
        }

        return redirect(route('employer.index'));
    }

    public function anyDatatableTransaction(Employer $employer)
    {
        $employers = EmployerTransaction::join('employer', 'employer.id', '=', 'employer_transaction.employer_id')
            ->where('employer_transaction.employer_id', $employer->employer_id)
            ->select(
                'employer.employer_id',
                'employer.employer_code',
                'employer.business',
                'employer.business',
                'business_type.business_type_name',
                'type_of_business.type_of_business_name',
                'employer.enterprise_name',
                'employer.image',
                'employer.email',
                'employer.phone',
                'users.name',
                'employer.district',
                'employer.province',
                'employer.status',
                'employer.total_money',
                'employer.number_recruit_require',
                'employer.recruited',
                'employer.status_intership'
            );

        return Datatables::of($employers)
            ->orderByDesc('employer_transaction.employer_transaction_id')
            ->make(true);
    }


    public function exportToExcel(Request $request)
    {
        //    echo 1;die();
        try {
            $employer = new Employer();
            $employers = $employer->select(
                'employer.employer_id',
                'employer.employer_code',
                'employer.business',
                'business_type.business_type_name',
                'type_of_business.type_of_business_name',
                'employer.enterprise_name',
                'employer.image',
                'employer.email',
                'employer.phone',
                'users.name',
                'employer.district',
                'employer.province',
                'employer.status',
                'employer.total_money_coin',
                'employer.status_intership',
                'province.province_id',
                'province.province_name',
                'district.district_id',
                'district.district_name'
            );
            $employers = $employers->leftJoin('employer_typeof_business', 'employer_typeof_business.employer_id', '=', 'employer.employer_id');
            $employers = $employers->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'employer.business');
            $employers = $employers->leftJoin('users', 'users.id', 'employer.user_id');
            $employers = $employers->leftJoin('business_type', 'business_type.business_type_id', '=', 'employer.type_of_business_id');
            $employers = $employers->leftJoin('province', 'province.province_id', '=', 'employer.province');
            $employers = $employers->leftJoin('district', 'district.district_id', '=', 'employer.district');
            $employers = $employers->leftJoin('employer_agency', 'employer_agency.employer_id', '=', 'employer.employer_id');
            //            ->leftJoin('type_of_business','type_of_business.type_of_business_id','=','employer_typeof_business.type_of_business_id')
            if (!empty($request->input('business'))) {
                $business = $request->input('business');
                $employers = $employers->where('employer.business', $business);
            }
            if (!empty($request->input('type_of_business_id'))) {
                $type_of_business_id = $request->input('type_of_business_id');
                $employers = $employers->where('employer.type_of_business_id', $type_of_business_id);
            }
            if (!empty($request->input('province'))) {
                $province = $request->input('province');
                $employers = $employers->where('employer.province', $province);
            }
            if (!empty($request->input('district'))) {
                $district = $request->input('district');
                $employers = $employers->where('employer.district', $district);
            }
            if (!empty($request->input('enterprise_name'))) {
                $enterprise_name = $request->input('enterprise_name');
                $employers = $employers->where('enterprise_name', 'like', '%' . $enterprise_name . '%');
            }
            if (!empty($request->input('email'))) {

                $email = $request->input('email');
                $employers = $employers->where('employer.email', 'like', '%' . $email . '%');
            }
            if (!empty($request->input('status_intership'))) {
                $status_intership = $request->input('status_intership');
                $employers = $employers->where('employer.status_intership', $status_intership);
            }
            if (!empty($request->input('status_agency'))) {
                $status_agency = $request->input('status_agency');
                $employers = $employers->where('employer.status_agency', $status_agency);
            }
            $employers = $employers->get();
            $data = array();
            $data[] = array(
                'Id',
                'Tên công ty',
                'Email',
                'Số điện thoại',
                'Loại hình doanh nghiệp',
                'Loại hình kinh doanh   ',
                'Thành phố',
                'Quận Huyện',
                'Link Logo công ty',
            );

            foreach ($employers as $id_emplo => $eplo) {
                $data[] = array(
                    $id_emplo + 1,
                    $eplo->enterprise_name,
                    $eplo->email,
                    $eplo->phone,
                    $eplo->type_of_business_name,
                    $eplo->business_type_name,
                    $eplo->province_name,
                    $eplo->district_name,
                    asset($eplo->image),
                );
            }
            $date = new \DateTime();

            $fileName = "Danh-sach-cong-ty-tuyen-thuc-tap_" . $date->format("d/m/y");
            return SpreadsheetFile::download($data, $fileName);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi export sản phẩm: dữ liệu không hợp lệ.');
            Log::error('http->admin->productController->exportToExcel: Lỗi xảy ra trong quá trình export sản phẩm');

            return null;
        }
    }

    public function Employer_delete_with_admin(Request $request, $id)
    {
        try {
            $update = Employer_delete_request::where('employer_id', $id)->delete();
            $delete = Employer::where('employer_id', $id)->delete();
            //khoi phuc ban ghi
            DB::commit();
            return redirect(route('listEmployerDeleteRequest'))->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listEmployerDeleteRequest'))->with('error', 'Xóa thất bại');
        }
    }
    public function Employer_undelete_with_admin(Request $request, $id)
    {
        try {
            $update = Employer_delete_request::where('employer_id', $id)->delete();
            //khoi phuc ban ghi
            DB::commit();
            return redirect(route('listEmployerDeleteRequest'))->with('success', 'Hủy thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listEmployerDeleteRequest'))->with('error', 'Hủy thất bại');
        }
    }

    public function listEmployerDeleteRequest(Request $request)
    {
        $employers = new Employer_delete_request();
        $employers = $employers->leftJoin('employer', 'employer_delete_request.employer_id', 'employer.employer_id');
        $employers = $employers->leftJoin('users as u', 'employer_delete_request.staff_id', 'u.id');
        $employers = $employers->leftJoin('employer_typeof_business', 'employer_typeof_business.employer_id', '=', 'employer.employer_id');
        $employers = $employers->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'employer.business');
        $employers = $employers->leftJoin('users', 'users.id', 'employer.user_id');
        $employers = $employers->leftJoin('business_type', 'business_type.business_type_id', '=', 'employer.type_of_business_id');
        $employers = $employers->leftJoin('employer_agency', 'employer_agency.employer_id', '=', 'employer.employer_id');
        //            ->leftJoin('type_of_business','type_of_business.type_of_business_id','=','employer_typeof_business.type_of_business_id')
        $employers = $employers->select(
            'employer.employer_id',
            'employer.employer_code',
            'employer.business',
            'employer.user_id',
            'business_type.business_type_name',
            'type_of_business.type_of_business_name',
            'employer.enterprise_name',
            'employer.image',
            'employer.email',
            'employer.phone',
            'users.name',
            'employer.district',
            'employer.province',
            'employer.status',
            'employer.total_money',
            'employer.number_recruit_require',
            'employer.recruited',
            'employer.status_intership',
            'employer.status_agency',
            'employer_agency.code_intro',
            'u.name as staff_name'
        );

        if (!empty($request->input('business'))) {
            $business = $request->input('business');
            $employers = $employers->where('employer.business', $business);
        }
        if (!empty($request->input('type_of_business_id'))) {
            $type_of_business_id = $request->input('type_of_business_id');
            $employers = $employers->where('employer.type_of_business_id', $type_of_business_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employers = $employers->where('employer.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employers = $employers->where('employer.district', $district);
        }
        if (!empty($request->input('enterprise_name'))) {
            $enterprise_name = $request->input('enterprise_name');
            $employers = $employers->where('enterprise_name', 'like', '%' . $enterprise_name . '%');
        }
        if (!empty($request->input('email'))) {

            $email = $request->input('email');
            $employers = $employers->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('status_intership'))) {
            $status_intership = $request->input('status_intership');
            $employers = $employers->where('employer.status_intership', $status_intership);
        }
        if (!empty($request->input('status_agency'))) {
            $status_agency = $request->input('status_agency');
            $employers = $employers->where('employer.status_agency', $status_agency);
        }
        $total = $employers->count();

        $employers = $employers->orderBy('employer.employer_id', 'desc');
        $employers = $employers->paginate(50);
        $employers->appends(request()->query());

        return view('customers.employer.list_delete_request', compact('employers', 'total'));
    }

    public function listEmployerDelete(Request $request)
    {
        $employers = new Employer();
        $employers = $employers->onlyTrashed()->leftJoin('employer_typeof_business', 'employer_typeof_business.employer_id', '=', 'employer.employer_id');
        $employers = $employers->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'employer.business');
        $employers = $employers->leftJoin('users', 'users.id', 'employer.user_id');
        $employers = $employers->leftJoin('business_type', 'business_type.business_type_id', '=', 'employer.type_of_business_id');
        $employers = $employers->leftJoin('employer_agency', 'employer_agency.employer_id', '=', 'employer.employer_id');
        //            ->leftJoin('type_of_business','type_of_business.type_of_business_id','=','employer_typeof_business.type_of_business_id')
        $employers = $employers->select(
            'employer.employer_id',
            'employer.employer_code',
            'employer.business',
            'employer.user_id',
            'business_type.business_type_name',
            'type_of_business.type_of_business_name',
            'employer.enterprise_name',
            'employer.image',
            'employer.email',
            'employer.phone',
            'users.name',
            'employer.district',
            'employer.province',
            'employer.status',
            'employer.total_money_coin',
            'employer.status_intership',
            'employer.status_agency',
            'employer_agency.code_intro'
        );

        if (!empty($request->input('business'))) {
            $business = $request->input('business');
            $employers = $employers->where('employer.business', $business);
        }
        if (!empty($request->input('type_of_business_id'))) {
            $type_of_business_id = $request->input('type_of_business_id');
            $employers = $employers->where('employer.type_of_business_id', $type_of_business_id);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employers = $employers->where('employer.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employers = $employers->where('employer.district', $district);
        }
        if (!empty($request->input('enterprise_name'))) {
            $enterprise_name = $request->input('enterprise_name');
            $employers = $employers->where('enterprise_name', 'like', '%' . $enterprise_name . '%');
        }
        if (!empty($request->input('email'))) {

            $email = $request->input('email');
            $employers = $employers->where('employer.email', 'like', '%' . $email . '%');
        }
        if (!empty($request->input('status_intership'))) {
            $status_intership = $request->input('status_intership');
            $employers = $employers->where('employer.status_intership', $status_intership);
        }
        if (!empty($request->input('status_agency'))) {
            $status_agency = $request->input('status_agency');
            $employers = $employers->where('employer.status_agency', $status_agency);
        }
        $total = $employers->count();

        $employers = $employers->orderBy('employer.employer_id', 'desc');
        $employers = $employers->paginate(50);
        $employers->appends(request()->query());

        return view('customers.employer.list_delete', compact('employers', 'total'));
    }

    public function Employerestore(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {
                $user_model = new User();


                $restore = $user_model->withTrashed()->where('id', $id)->restore();
                $user = $user_model->where('id', $id)->first();


                $employer_model = new Employer();
                $restore_employer = $employer_model->withTrashed()->where('user_id', $id)->restore();

                $employer = Employer::select('employer_id', 'user_id')->where('user_id', $user->id)->first();

                $delete = Job::withTrashed()->where('employer_id', $employer->employer_id)->restore();
                $delete = JobFacebook::withTrashed()->where('employer_id', $employer->employer_id)->restore();


                //khoi phuc ban ghi
                DB::commit();
                return redirect(route('listEmployerDelete'))->with('success', 'Khôi phục thành công');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listEmployerDelete'))->with('error', 'Khôi phục thất bại');
        }
    }

    public function EmployerForceDelete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {
                $user_model = new User();
                $delete_user = $user_model->where('id', $id)->delete();
                $user = $user_model->onlyTrashed()->where('id', $id)->first();

                //            xóa ứng viên và xóa vĩnh viễn
                //

                $delete  = \App\Http\Controllers\Admin\UserController::deleteEmployer($id);

                //đánh giá ntd
                $star_employer = new StarEmployer();
                $star_employer = $star_employer->where('id_user', $id)->delete();

                //đánh giá đề thi
                $star_exam = new StarExam();
                $star_exam = $star_exam->where('id_user', $id)->delete();

                //đánh giá giáo viên
                $star_teacher = new TeacherStar();
                $star_teacher = $star_teacher->where('id_user', $id)->delete();

                //bình luận đề thi
                $comment_exam = new CommentExam();
                $comment_exam = $comment_exam->where('id_user', $id)->delete();

                //người tạo đề thi phần này xử lý sau
                //                $exam = new Exam();
                //                $list_exam = $exam->where('id_user',$id)->get();
                //
                //                $questions = new Questions();
                //                foreach($list_exam as $l_exam)
                //                {
                //                    $delete = $questions->where('id_exam',$l_exam->id_exam)->delete();
                //                }
                //                $exam = $exam->where('id_user',$id)->delete();

                $forceDelete = $user_model->withTrashed()
                    ->where('id', $id)
                    ->forceDelete();
            }
            DB::commit();
            return redirect(route('listEmployerDelete'))->with('success', 'Xóa vĩnh viễn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('listEmployerDelete'))->with('success', 'Xóa vĩnh viễn thất bại');
        }
    }
}
