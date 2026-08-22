<?php
namespace App\Http\Controllers\Admin;
use App\Entity\Age;
use App\Entity\Experience;
use App\Entity\Salary;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExperienceController extends AdminController
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
        $experience = new Experience();
        $experience = $experience->select('*')->orderBy('experience_id','asc')->get();
        return view('admin.experience.list',compact('experience'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.experience.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $experience = new Experience();
        $experience = $experience->insert([
            'experience_name' => $request->input('experience_name'),
            'experience_des' => $request->input('experience_des'),
            'experience_month' => $request->input('experience_month')
        ]);
        return redirect(route('experience.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */

    public function edit(Experience $experience)
    {
        return view('admin.experience.edit', compact('experience'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $experience = Experience::findOrFail($id);
        $experience->update([
            'experience_name' => $request->input('experience_name'),
            'experience_des' => $request->input('experience_des'),
            'experience_month' => $request->input('experience_month')
        ]);
        return redirect(route('experience.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {

        try {
            DB::beginTransaction();
            $experience->delete();
            DB::commit();
        } catch(\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
            DB::rollBack();
        }finally{
            return redirect(route('experience.index'));
        }
    }

}