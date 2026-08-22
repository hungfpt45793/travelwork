<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Filter;
use App\Entity\FilterGroup;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FilterController extends AdminController
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

        try {
            //$filter = new FilterGroup();
            $filterGroup = new FilterGroup();
            $filters = $filterGroup->orderBy('group_filter_id')->get();

        } catch (\Exception $e) {
            $filters = array();
            Error::setErrorMessage('Hiển thị bộ lọc xảy ra lỗi.');
            Log::error('http->Admin->FilterController->index: Hiển thị bộ lọc xảy ra lỗi');
        } finally {
            return view('admin.filter.index', compact('filters'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.filter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // insert to database
            $filterGroup = new FilterGroup();
            $filterGroupId = $filterGroup->insertGetId([
                'group_name' => $request->input('name'),
            ]);

            $filters = $request->input('filter');

            $filterElements = new Filter();
            foreach ($filters as $filter) {
                $filterElements->insert([
                    'name_filter' => $filter,
                    'group_filter_id' => $filterGroupId,
                ]);
            }
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi thêm mới filter: dữ liệu hợp lệ.');
            Log::error('http->admin->FilterController->store: Lỗi xảy tra trong quá trình thêm mới filter');
        } finally {
            return redirect('admin/filter');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $filterGroupModel = new FilterGroup();
        $filterModel = new Filter();
        $filterGroup = $filterGroupModel->where('group_filter_id', $id)->first();
        $filterElements = $filterModel->where('group_filter_id', $filterGroup->group_filter_id)->get();

        return view('admin.filter.edit', compact('filterGroup', 'filterElements'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // insert FilterGroup to database
            $filterGroupModel = new FilterGroup();
            $filterGroup  = $filterGroupModel->where('group_filter_id', $id)->first();
            $filterGroup->update([
                'group_name' => $request->input('name'),
            ]);
            // insert Filter to database
            $filterModel = new Filter();
            $filterModel->where('group_filter_id', $id)->delete();

            $filters = $request->input('filter');

            $filterElements = new Filter();
            foreach ($filters as $filter) {
                $filterElements->insert([
                    'name_filter' => $filter,
                    'group_filter_id' => $filterGroup->group_filter_id,
                ]);
            }


        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa filter: dữ liệu hợp lệ.');
            Log::error('http->admin->FilterController->update: Lỗi xảy tra trong quá trình cập nhật filter');
        } finally {
            return redirect('admin/filter');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $filter = new Filter();
            $filter->where('group_filter_id', $id)->delete();

            $filterGroup = new FilterGroup();
            $filterGroup->where('group_filter_id', $id)->delete();

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa filter: dữ liệu hợp lệ.');
            Log::error('http->admin->FilterController->destroy: Lỗi xảy tra trong quá trình xóa filter');
        } finally {
            return redirect('admin/filter');
        }
    }
}
