<?php
namespace App\Http\Controllers\Admin;
use App\Entity\Age;
use App\Entity\District;
use App\Entity\Province;
use App\Entity\Salary;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class DistrictController extends AdminController
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
            view()->share('menuTop', 'setting');
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

        $district_model = new District();
        $district = $district_model->select('*');
            $district = $district->join('province','province.province_id','district.province_id');
            if(!empty($request->input('province_id')))
            {
                $province_id = $request->input('province_id');
                $district = $district->where('province.province_id',$province_id);
            }
            $district = $district->orderBy('district_id','desc');
            $district = $district->paginate(50);
        $district->appends(request()->query());

        $total = $district->count();
        foreach( $district as $dis)
//        {
//            $slug = Ultility::createSlug($dis->district_name);
//            $update = $district_model->where('district_id',$dis->district_id)->update([
//                'district_slug'=> $slug
//            ]);
//        }


        return view('admin.district.list',compact('district','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.district.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'district_id' => 'required|unique:district',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'district_id.unique' => 'Mã quận huyện đã tồn tại.'


        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        $slug = Ultility::createSlug($request->input('district_name'));
        $district = new District();
        $district = $district->insert([
            'district_id' => $request->input('district_id'),
            'district_name' => $request->input('district_name'),
            'district_slug' => $slug,
            'province_id' => $request->input('province_id')
        ]);
        return redirect(route('district.index'));

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
    public function edit($district_id)
    {
        $district = new District();
        $district = $district->select('*')->where('district_id',$district_id)->first();
        return view('admin.district.edit', compact('district'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$district_id)
    {
        $district = new District();
        $slug = Ultility::createSlug($request->input('district_name'));
        $update = $district->where('district_id',$district_id)->update([
            'district_id' => $request->input('district_id'),
            'district_name' => $request->input('district_name'),
            'district_slug' => $slug,
            'province_id' => $request->input('province_id')
        ]);

        return redirect(route('district.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy($district_id)
    {
        $district = new District();
        $delete = $district->where('district_id',$district_id)->delete();
        return redirect(route('district.index'));

    }

}
