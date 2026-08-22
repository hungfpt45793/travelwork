<?php
namespace App\Http\Controllers\Admin;
use App\Entity\Age;
use App\Entity\Config_meta;
use App\Entity\Salary;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ConfigMetaController extends AdminController
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
        $config = new Config_meta();
        $configs = $config->select('*')->orderBy('id_meta','desc')->get();
        return view('admin.config_meta.list',compact('configs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.config_meta.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $config = new Config_meta();
        $config = $config->insert([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),
            'image' => $request->input('image'),
        ]);
        return redirect(route('config_meta.index'));

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
    public function edit($id_meta)
    {
        $config = new Config_meta();
        $config = $config->select('*')->where('id_meta',$id_meta)->first();
        return view('admin.config_meta.edit', compact('config'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_meta)
    {
        $config = new Config_meta();
        $update = $config->where('id_meta',$id_meta)->update([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),
            'image' => $request->input('image'),
        ]);
        return redirect(route('config_meta.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_meta)
    {

        try {
            DB::beginTransaction();
            $config = new Config_meta();
            $config = $config->where('id_meta',$id_meta)->delete();
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('config_meta.index'));
        }
    }

}
