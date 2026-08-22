<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Literacy;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
class LiteracyController extends AdminController
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
        return view('admin.literacy.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.literacy.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'literacy_name' => 'unique:literacies'
        ],[
            'literacy_name.unique' => 'Trình độ bạn thêm đã có. Mời bạn nhập vào trình độ khác'
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            Literacy::insert([
                'literacy_name' => $request->input('literacy_name'),
                'literacy_salary' => $request->input('literacy_salary'),
                'description' => $request->input('description'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            Error::setErrorMessage('Lỗi xảy ra khi thêm mới trình độ học vấn');
            DB::rollBack();
        } finally {
            return redirect(route('literacy.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Literacy  $literacy
     * @return \Illuminate\Http\Response
     */
    public function show(Literacy $literacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Literacy  $literacy
     * @return \Illuminate\Http\Response
     */
    public function edit(Literacy $literacy)
    {
        return view('admin.literacy.edit', compact('literacy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Literacy  $literacy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Literacy $literacy)
    {
        $validator = Validator::make($request->all(), [
            'literacy_name' => Rule::unique('literacies')->ignore($literacy->literacy_id,'literacy_id')
        ],[
            'literacy_name.unique' => 'Trình độ bạn thêm đã có. Mời bạn nhập vào trình độ khác'
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            $literacy->update([
                'literacy_name' => $request->input('literacy_name'),
                'literacy_salary' => $request->input('literacy_salary'),
                'description' => $request->input('description'),
                'updated_at' => new \DateTime()
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật trình độ học vấn');
            DB::rollBack();
        } finally {
            return redirect(route('literacy.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Literacy  $literacy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Literacy $literacy)
    {
        try {
            DB::beginTransaction();
            $literacy->delete();
            DB::commit();
        } catch (\Exception $exception) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa trình độ học vấn');
            DB::rollBack();
        } finally {
            return redirect(route('literacy.index'));
        }
    }

    public function anyDatatable(){
        $literacy_list = Literacy::select(
          'literacy_id',
          'literacy_name',
          'literacy_salary',
          'description'
        );
        return Datatables::of($literacy_list)
            ->addColumn('action', function ($literacy){
                $string = '<a href="' . route('literacy.edit',['literacy_id' => $literacy->literacy_id]) .'">
                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                           </a>';
                $string .= '<a href="' . route('literacy.destroy', ['literacy_id' => $literacy->literacy_id]) .
                        '" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('literacy_id', 'literacy_id desc')
            ->make(true);
    }
}