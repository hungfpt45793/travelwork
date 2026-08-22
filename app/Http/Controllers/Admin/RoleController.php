<?php
namespace App\Http\Controllers\Admin;
use App\Entity\Age;
use App\Entity\Role;
use App\Entity\Salary;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RoleController extends AdminController
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
            view()->share('menuTop', 'customers');
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
        $role = new Role();
        $role = $role->select('*')->get();
        return view('customers.role.list',compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.role.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $role = new Role();
            $role = $role->insert([
                'name_role' => $request->input('name_role'),
                'role' => $request->input('role'),
                'created_at' => $request->input('created_at'),
            ]);
            return redirect(route('role.index'))->with('success','thêm quyền thành công');
        }catch (\Exception $e)
        {
            return redirect(route('role.index'))->with('error','thêm quyền thất bại ! có thể quyền role bị trùng');
        }


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
    public function edit(Request $request, $id_role)
    {
        $role = new Role();
        $role = $role->select('*')->where('id_role',$id_role)->first();
        return view('customers.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_role)
    {
        $role = new Role();
        $role = $role->where('id_role',$id_role)->update([
            'name_role' => $request->input('name_role'),
            'role' => $request->input('role'),
            'updated_at' => $request->input('updated_at'),
        ]);
        return redirect(route('role.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id_role)
    {

        try {
            DB::beginTransaction();
            $role = new Role();
            $role = $role->where('id_role',$id_role)->delete();
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('role.index'));
        }
    }

}
