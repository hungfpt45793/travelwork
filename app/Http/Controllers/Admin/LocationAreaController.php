<?php
namespace App\Http\Controllers\Admin;
use App\Entity\Age;
use App\Entity\InformationService;
use App\Entity\LocationArea;
use App\Entity\Salary;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LocationAreaController extends AdminController
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
        $local = new LocationArea();
        $locals = $local->select('*')->orderBy('local_id','asc');
        $total = $locals->count();
         $locals = $locals->get();
        return view('admin.localtion_area.list',compact('locals','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.localtion_area.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $local = new LocationArea();

        $local_getId = $local->insertGetId([
            'title' => $request->input('title'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()

        ]);
        $slug = '';
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        $postWithSlug = $local->where('slug', $slug)->first();
        if (empty($postWithSlug)) {
            $local->where('local_id', '=', $local_getId)
                ->update([
                    'slug' => $slug
                ]);
        } else {
            $local->where('local_id', '=', $local_getId)
                ->update([
                    'slug' => $slug.'-'.$local_getId
                ]);
        }
        return redirect(route('location_area.index'));

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
    public function edit($local_id)
    {
        $local = new LocationArea();
        $local  =  $local->select('*')->where('local_id',$local_id)->first();
        return view('admin.localtion_area.edit', compact('local'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $local_id)
    {
        $local = new LocationArea();
        $update  =  $local->select('*')->where('local_id',$local_id)->update([
            'title' => $request->input('title'),
        ]);
        $slug = '';
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        $postWithSlug = $local
            ->where('slug', $slug)
            ->where('local_id', '!=', $local_id)
            ->first();
        if (empty($postWithSlug)) {
            $local->where('local_id', '=', $local_id)
                ->update([
                    'slug' => $slug
                ]);
        } else {
            $local->where('local_id', '=', $local_id)
                ->update([
                    'slug' => $slug.'-'.$local_id
                ]);
        }
        return redirect(route('location_area.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy($local_id)
    {

        try {
            DB::beginTransaction();
            $local = new LocationArea();
            $update  =  $local->select('*')->where('local_id',$local_id)->delete();
            DB::commit();
            return redirect(route('location_area.index'));
        } catch(\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('location_area.index'));
        }
    }

}
