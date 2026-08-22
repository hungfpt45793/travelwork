<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Age;
use App\Entity\InformationService;
use App\Entity\LocalBranch;
use App\Entity\LocationArea;
use App\Entity\Salary;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LocalBranchController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;

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

        $local_branch = new LocalBranch();
        $locals = $local_branch->select('*')
            ->orderBy('local_branch_id', 'asc');
        $total = $locals->count();
        $locals = $locals->paginate(50);
        return view('admin.local_branch.list', compact('locals', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.local_branch.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $local_branch = new LocalBranch();

        $local_getId = $local_branch->insertGetId([
            'title' => $request->input('title'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'province_id' => $request->input('province_id'),
            'local_id' => $request->input('local_id'),
            'link' => $request->input('link'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()

        ]);
        $slug = '';
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        $postWithSlug = $local_branch->where('slug', $slug)->first();
        if (empty($postWithSlug)) {
            $local_branch->where('local_branch_id', '=', $local_getId)
                ->update([
                    'slug' => $slug
                ]);
        } else {
            $local_branch->where('local_branch_id', '=', $local_getId)
                ->update([
                    'slug' => $slug . '-' . $local_getId
                ]);
        }
        return redirect(route('local_branch.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function edit($local_branch_id)
    {
        $local_branch = new LocalBranch();
        $local_branch = $local_branch->select('*')->where('local_branch_id', $local_branch_id)->first();
        return view('admin.local_branch.edit', compact('local_branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $local_branch_id)
    {
        $local_branch = new LocalBranch();
        $update = $local_branch->select('*')->where('local_branch_id', $local_branch_id)->update([
            'title' => $request->input('title'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'province_id' => $request->input('province_id'),
            'local_id' => $request->input('local_id'),
            'link' => $request->input('link'),
        ]);
        $slug = '';
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('title'));
        }
        $postWithSlug = $local_branch->where('slug', $slug)
            ->where('local_branch_id', '!=', $local_branch_id)
            ->first();
        if (empty($postWithSlug)) {
            $local_branch->where('local_branch_id', '=', $local_branch_id)
                ->update([
                    'slug' => $slug
                ]);
        } else {
            $local_branch->where('local_branch_id', '=', $local_branch_id)
                ->update([
                    'slug' => $slug . '-' . $local_branch_id
                ]);
        }
        return redirect(route('local_branch.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy($local_branch_id)
    {

        try {
            DB::beginTransaction();
            $local_branch = new LocalBranch();
            $update = $local_branch->select('*')->where('local_branch_id', $local_branch_id)->delete();
            DB::commit();
            return redirect(route('local_branch.index'));
        } catch (\Exception $exception) {
            Error::setErrorMessage('Không thể cập nhật dữ liệu. Đã xảy ra lỗi khi nhập dữ liệu');
            DB::rollBack();
        } finally {
            return redirect(route('local_branch.index'));
        }
    }

}
