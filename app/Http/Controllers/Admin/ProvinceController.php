<?php
namespace App\Http\Controllers\Admin;
use App\Entity\Age;
use App\Entity\Province;
use App\Entity\Salary;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends AdminController
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
    public function index()
    {
        $province_model = new Province();
        $province = $province_model->select('*')
            ->orderBy('sort_id','asc')
            ->orderBy('province_id','asc')
            ->get();

//        $slug = Ultility::createSlug($request->input('title'));
//
        $total = $province_model->count();
//        foreach( $province as $pro)
//        {
//            $slug = Ultility::createSlug($pro->province_name);
//            $update = $province_model->where('province_id',$pro->province_id)->update([
//                'province_slug'=> $slug
//            ]);
//        }
        return view('admin.province.list',compact('province','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.province.add');
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
            'province_id' => 'required|unique:province',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'province_id.unique' => 'Mã thành phố đã tồn tại.'


        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        $province_model = new Province();
        $province = $province_model->insert([
            'province_id' => $request->input('province_id'),
            'province_name' => $request->input('province_name'),
            'province_salary' => $request->input('province_salary'),
            'postalcode' => $request->input('postalcode'),
            'sort_id' => $request->input('sort_id'),
            'local_area' => $request->input('local_area')
        ]);
        $slug = Ultility::createSlug($request->input('province_name'));
        $postWithSlug = $province_model->where('province_slug', $slug)->first();
        if (empty($postWithSlug)) {
            $province_model->where('province_id', '=', $request->input('province_id'))
                ->update([
                    'province_slug' => $slug
                ]);
        } else {
            $province_model->where('province_id', '=', $request->input('province_id'))
                ->update([
                    'province_slug' => $slug.'-'.$request->input('province_id')
                ]);
        }


//        $getProvince = $province_model
//            ->where('province_slug',$slug)
//            ->first();
//        if (empty($getProvince)) {
//            $province_model->where('province_id', '=', $request->input('province_id'))
//                ->update([
//                    'province_slug' => $slug
//                ]);
//        } else {
//            $province_model->where('province_id', '=', $request->input('province_id'))
//                ->update([
//                    'province_slug' => $slug.'-'.$getProvince->province_id
//                ]);
//        }
        return redirect(route('province.index'));

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
    public function edit($province_id)
    {
        $province = new Province();
        $province = $province->select('*')->where('province_id',$province_id)->first();
        return view('admin.province.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$province_id)
    {
        $province_model = new Province();
        $update = $province_model->where('province_id',$province_id)->update([
            'province_id' => $request->input('province_id'),
            'province_name' => $request->input('province_name'),
            'province_salary' => $request->input('province_salary'),
            'sort_id' => $request->input('sort_id'),
            'postalcode' => $request->input('postalcode'),
            'local_area' => $request->input('local_area')
        ]);
        $slug = Ultility::createSlug($request->input('province_name'));
        $getProvince = $province_model->where('province_slug',$slug)->first();
        // insert slug

        $postWithSlug = $province_model->where('province_slug', $slug)
            ->where('province_id', '!=', $province_id)
            ->first();
        if (empty($postWithSlug)) {
            $province_model->where('province_id', $province_id)
                ->update([
                    'province_slug' => $slug
                ]);
        } else {
            $province_model->where('province_id', $province_id)
                ->update([
                    'province_slug' => $slug.'-'.$province_id
                ]);
        }

        return redirect(route('province.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy($province_id)
    {
        $province = new Province();
        $province = $province->where('province_id',$province_id)->delete();
        return redirect(route('province.index'));

    }

}
