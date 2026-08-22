<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Business;
use App\Entity\Coin_history_money_employer;
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


class Coin_employerController extends AdminController
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
            view()->share('menuTop', 'employer_coin');
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
        $employers = $employers->select(
            'employer_id',
            'employer_code',
            'enterprise_name',
            'phone',
            'email',
            'address',
            'district',
            'province',
            'address',
            'business',//loại hình kinh doanh
            'type_of_business_id',//trong bảng type_business loại hình doanh nghiệp
            'created_at',
            'updated_at',
            'deleted_at',
            'image',
            'slug',
            'tax_code',
            'website',
            'status_agency',
            'employer_coin',
            'total_employer_coin'
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

        $employers = $employers->orderBy('employer.total_employer_coin', 'desc');
        $employers = $employers->paginate(20);
        $employers->appends(request()->query());

        //danh sách đã xóa

        return view('admin.coin.employer_coin.list', compact('employers', 'total'));
    }

    //giao diên nap xu
    public function create_coin_employer($employer_id)
    {
        $employers = new Employer();
        $employer = $employers->select(
            'employer_id',
            'employer_code',
            'enterprise_name',
            'phone',
            'email',
            'address',
            'district',
            'province',
            'address',
            'business',//loại hình kinh doanh
            'type_of_business_id',//trong bảng type_business loại hình doanh nghiệp
            'created_at',
            'updated_at',
            'deleted_at',
            'image',
            'slug',
            'tax_code',
            'website',
            'status_agency',
            'employer_coin',
            'total_employer_coin',
            'total_money_coin'
        )->where('employer_id', $employer_id)
            ->first();
//        echo '<pre>';
//        print_r($employer);die();
        return view('admin.coin.employer_coin.create_coin_employer', compact('employer'));
    }
    public function list_coin_employer($employer_id)
    {
        $employers = new Employer();
        $employer = $employers->select(
            'employer_id',
            'employer_code',
            'enterprise_name',
            'phone',
            'email',
            'address',
            'district',
            'province',
            'address',
            'business',//loại hình kinh doanh
            'type_of_business_id',//trong bảng type_business loại hình doanh nghiệp
            'created_at',
            'updated_at',
            'deleted_at',
            'image',
            'slug',
            'tax_code',
            'website',
            'status_agency',
            'employer_coin',
            'total_employer_coin',
            'total_money_coin'
        )->where('employer_id', $employer_id)
            ->first();

        $list_coin_money = Coin_history_money_employer::select('*')->where('employer_id',$employer_id);
        $total = $list_coin_money->count();
        $list_coin_money =$list_coin_money->orderBy('coin_money_id','desc')->paginate(20);
//        echo '<pre>';
//        print_r($employer);die();

        $list_coin_money_delete = Coin_history_money_employer::onlyTrashed()->select('*')->where('employer_id',$employer_id)->orderBy('coin_money_id','desc')->paginate(20);


        return view('admin.coin.employer_coin.list_coin_employer', compact('employer','total','list_coin_money','list_coin_money_delete'));

    }

    //xử lý nạp xu
    public function store_coin_employer(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'coint_money' => 'required|min:1',
            'coint' => 'required|min:1',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'coint_money.required' => 'Bạn chưa nhập số tiền nạp.',
            'coint.required' => 'Bạn chưa nhập số xu nhận được.',
            'coint_money.min' => 'Số tiền nạp phải lớn hơn 0.',
            'coint.min' => 'Số xu nhận được phải lớn hơn 0.',

        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $employer_id = $request->input('employer_id');
            $coint_money = (int)str_replace(".", "", $request->input('coint_money'));
            $coint = (int)str_replace(".", "", $request->input('coint'));
            $coin_content  = $request->input('coin_content');
            $user_id = Auth::user()->id;

            $employer = Employer::select( 'employer_coin',
                'total_employer_coin',
                'total_money_coin',
                'employer_id'
            )->where('employer_id',$employer_id)->first();

            //thêm vào bảng lich sử nạp
            $insert_coint_money = Coin_history_money_employer::insert([
               'coint_money' => $coint_money,
               'coint' => $coint,
               'coin_content' => $coin_content,
               'user_id' => $user_id,
               'employer_id' => $employer_id,
               'created_at' => new \DateTime()
            ]);
            //cập nhật số tiền trong bảng employer và số xu
            $total_money_coin = $employer->total_money_coin + $coint_money;
            $total_employer_coin = $employer->employer_coin + $coint;
            $employer_coin = $employer->employer_coin + $coint;

             $update_employer = Employer::where('employer_id',$employer_id)->update([
                'total_employer_coin' => $total_employer_coin,
                'total_money_coin' => $total_money_coin,
                'employer_coin' => $employer_coin,
             ]);

            DB::commit();
            return redirect(route('list_coin_employer',['employer_id'=>$employer_id]))->with('success', 'Giao dịch  thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể thêm mới dữ liệu : Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollBack();
            return redirect(route('list_coin_employer',['employer_id'=>$employer_id]))->with('error', 'Giao dịch thất bại');
        }

    }
    public static function edit_coin_employer($coin_money_id)
    {
        $coin_money_employer = Coin_history_money_employer::select('*')->where('coin_money_id',$coin_money_id)->first();
        $employers = new Employer();
        $employer = $employers->select(
            'employer_id',
            'employer_code',
            'enterprise_name',
            'phone',
            'email',
            'address',
            'district',
            'province',
            'address',
            'business',//loại hình kinh doanh
            'type_of_business_id',//trong bảng type_business loại hình doanh nghiệp
            'created_at',
            'updated_at',
            'deleted_at',
            'image',
            'slug',
            'tax_code',
            'website',
            'status_agency',
            'employer_coin',
            'total_employer_coin',
            'total_money_coin'
        )->where('employer_id', $coin_money_employer->employer_id)
            ->first();
        return view('admin.coin.employer_coin.edit_coin_employer', compact('employer','coin_money_employer'));

    }
    public function update_coin_employer(Request $request,$coin_money_id)
    {
        $validation = Validator::make($request->all(), [
            'coint_money' => 'required|min:1',
            'coint' => 'required|min:1',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'coint_money.required' => 'Bạn chưa nhập số tiền nạp.',
            'coint.required' => 'Bạn chưa nhập số xu nhận được.',
            'coint_money.min' => 'Số tiền nạp phải lớn hơn 0.',
            'coint.min' => 'Số xu nhận được phải lớn hơn 0.',
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $employer_id = $request->input('employer_id');
            $coint_money = (int)str_replace(".", "", $request->input('coint_money'));
            $coint = (int)str_replace(".", "", $request->input('coint'));
            $coin_content  = $request->input('coin_content');
            $user_id = Auth::user()->id;
            $employer = Employer::select( 'employer_coin',
                'total_employer_coin',
                'total_money_coin',
                'employer_id'
            )->where('employer_id',$employer_id)->first();
            $coint_his_money = Coin_history_money_employer::select('*')->where('coin_money_id',$coin_money_id)->first();
            //cập nhật số tiền trong bảng employer và số xu
            $total_money_coin = ($employer->total_money_coin - $coint_his_money->coint_money ) + $coint_money;
            $total_employer_coin = ($employer->employer_coin - $coint_his_money->coint) + $coint;
            $employer_coin = ($employer->employer_coin - $coint_his_money->coint ) + $coint;
            //thêm vào bảng lich sử nạp
            $update = Coin_history_money_employer::where('coin_money_id',$coin_money_id)->update([
                'coint_money' => $coint_money,
                'coint' => $coint,
                'coin_content' => $coin_content,
                'user_id' => $user_id,
                'employer_id' => $employer_id,
                'updated_at' => new \DateTime()
            ]);
            $update_employer = Employer::where('employer_id',$employer_id)->update([
                'total_employer_coin' => $total_employer_coin,
                'total_money_coin' => $total_money_coin,
                'employer_coin' => $employer_coin,
            ]);
            DB::commit();
            return redirect(route('list_coin_employer',['employer_id'=>$employer_id]))->with('success', ' Update Giao dịch  thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể thêm mới dữ liệu : Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollBack();
            return redirect(route('list_coin_employer',['employer_id'=>$employer_id]))->with('error', 'Update Giao dịch thất bại vì nhà tuyển dụng dã sử dung hết xu của lần nạp này');
        }
    }
    public function delete_coin_employer(Request $request,$coin_money_id)
    {
        try {
            DB::beginTransaction();
            $coint_his_money = Coin_history_money_employer::select('*')->where('coin_money_id',$coin_money_id)->first();
            $employer = Employer::select( 'employer_coin',
                'total_employer_coin',
                'total_money_coin',
                'employer_id'
            )->where('employer_id',$coint_his_money->employer_id)->first();

            //cập nhật số tiền trong bảng employer và số xu
            $total_money_coin = ($employer->total_money_coin - $coint_his_money->coint_money );
            $total_employer_coin = ($employer->employer_coin - $coint_his_money->coint);
            $employer_coin = ($employer->employer_coin - $coint_his_money->coint );
            //thêm vào bảng lich sử nạp
            $user_id = Auth::user()->id;
            $update = Coin_history_money_employer::where('coin_money_id',$coin_money_id)->update([
                'user_id' => $user_id,
            ]);
            $update = Coin_history_money_employer::where('coin_money_id',$coin_money_id)->delete();

            $update_employer = Employer::where('employer_id',$coint_his_money->employer_id)->update([
                'total_employer_coin' => $total_employer_coin,
                'total_money_coin' => $total_money_coin,
                'employer_coin' => $employer_coin,
            ]);
            DB::commit();
            return redirect(route('list_coin_employer',['employer_id'=>$coint_his_money->employer_id]))->with('success', ' Xóa Giao dịch  thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể thêm mới dữ liệu : Đã có lỗi xảy ra trong quá trình nhập dữ liệu');
            DB::rollBack();
            return redirect(route('list_coin_employer',['employer_id'=>$coint_his_money->employer_id]))->with('error', 'Xóa Giao dịch thất bại vì nhà tuyển dụng dã sử dung hết xu của lần nạp này');
        }
    }

    //lịch sử giao dịch
    public function history_transaction_employer($employer_id)
    {

        return redirect()->back()->with('success', 'Nạp xu thành công');
    }

    //lịch sử xem hồ sơ
    public function history_employee_employer($employer_id)
    {

        return redirect()->back()->with('success', 'Nạp xu thành công');
    }
}
