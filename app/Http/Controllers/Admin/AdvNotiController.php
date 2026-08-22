<?php
namespace App\Http\Controllers\Admin;
use App\Entity\Adv_noti;
use App\Entity\Age;
use App\Entity\Salary;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AdvNotiController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;
            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adv = new Adv_noti();
        $adv = $adv->select('*')->orderBy('adv_id','desc')->paginate(10);
//        echo '<pre>';
//        print_r($adv);die();
        return view('admin.adv_noti.list',compact('adv'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.adv_noti.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $adv = new Adv_noti();
        $adv = $adv->insert([
            'adv_title' => $request->input('adv_title'),
            'adv_link' => $request->input('adv_link'),
            'adv_content' => $request->input('adv_content'),
            'adv_time' => $request->input('adv_time'),
            'created_at' => new \DateTime()
        ]);
        return redirect(route('adv_noti.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit($adv_id)
    {
        $adv = new Adv_noti();
        $adv = $adv->select('*')->where('adv_id',$adv_id)->first();
        return view('admin.adv_noti.edit', compact('adv'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $adv_id)
    {
        $adv = new Adv_noti();
        $adv->where('adv_id',$adv_id)->update([
            'adv_title' => $request->input('adv_title'),
            'adv_link' => $request->input('adv_link'),
            'adv_content' => $request->input('adv_content'),
            'adv_time' => $request->input('adv_time'),
            'updated_at' => new \DateTime()
        ]);
        return redirect(route('adv_noti.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy($adv_id)
    {

        try {
            DB::beginTransaction();
            $adv = new Adv_noti();
            $adv->where('adv_id',$adv_id)->delete();
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('adv_noti.index'));
        }
    }

}
