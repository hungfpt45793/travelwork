<?php
namespace App\Http\Controllers\Admin;
use App\Entity\Age;
use App\Entity\InformationService;
use App\Entity\Salary;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InformationServiceController extends AdminController
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
            view()->share('menuTop', 'information_service');
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
        $info_service = new InformationService();
        $info_service = $info_service->select('*')->orderBy('service_id','asc')->get();
        return view('admin.information_service.list',compact('info_service'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.information_service.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $info_service = new InformationService();
        $info_getId = $info_service->insertGetId([
            'title' => $request->input('title'),
            'images' => $request->input('images'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()

        ]);
        $slug = '';
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        $postWithSlug = $info_service->where('slug', $slug)->first();
        if (empty($postWithSlug)) {
            $info_service->where('service_id', '=', $info_getId)
                ->update([
                    'slug' => $slug
                ]);
        } else {
            $info_service->where('service_id', '=', $info_getId)
                ->update([
                    'slug' => $slug.'-'.$info_getId
                ]);
        }
        return redirect(route('information_service.index'));

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
    public function edit($service_id)
    {
        $info = new InformationService();
        $info  =  $info->select('*')->where('service_id',$service_id)->first();
        return view('admin.information_service.edit', compact('info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $service_id)
    {
        $info_service = new InformationService();
        $info_getId = $info_service->where('service_id',$service_id)->update([
            'title' => $request->input('title'),
            'images' => $request->input('images'),
            'description' => $request->input('description'),
            'content' => $request->input('content')
        ]);
        $slug = '';
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        $postWithSlug = $info_service
            ->where('slug', $slug)
            ->where('service_id', '!=', $service_id)
            ->first();
        if (empty($postWithSlug)) {
            $info_service->where('service_id', '=', $service_id)
                ->update([
                    'slug' => $slug
                ]);
        } else {
            $info_service->where('service_id', '=', $service_id)
                ->update([
                    'slug' => $slug.'-'.$service_id
                ]);
        }
        return redirect(route('information_service.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy($service_id)
    {

        try {
            DB::beginTransaction();
            $service = new InformationService();
            $service= $service->where('service_id',$service_id)->delete();
            DB::commit();
            return redirect(route('information_service.index'));
        } catch(\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('information_service.index'));
        }
    }

}
