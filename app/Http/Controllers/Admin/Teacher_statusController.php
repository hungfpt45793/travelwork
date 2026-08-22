<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Teacher_status;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Teacher_statusController extends AdminController
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
    public function index()
    {
        $teacher_status = Teacher_status::select('*')
            ->orderBy('teacher_status_id','asc')
            ->get();
        return view('admin.teacher_status.list',compact('teacher_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.teacher_status.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $slug = Ultility::createSlug($request->input('teacher_status_name'));
        $teacher_status = new Teacher_status();
        $teacher_status_id = $teacher_status->insertGetId([
           'teacher_status_name' => $request->input('teacher_status_name'),
           'teacher_status_slug' => $slug,
           'teacher_status_des' => $request->input('teacher_status_des'),
            'created_at' => new \DateTime(),
        ]);
        // insert slug
        $teacher_slug = $teacher_status
            ->where('teacher_status_slug', $slug)
            ->where('teacher_status_id','!=', $teacher_status_id)
            ->first();
        if (empty($teacher_slug)) {
            $teacher_status->where('teacher_status_id', '=', $teacher_status_id)
                ->update([
                    'teacher_status_slug' => $slug
                ]);
        } else {
            $teacher_status->where('teacher_status_id', '=', $teacher_status_id)
                ->update([
                    'teacher_status_slug' => $slug.'-'.$teacher_status_id
                ]);
        }
        return redirect(route('teacher_status.index'));

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
        $teacher_status = new Teacher_status();
        $teacher = $teacher_status->select('*')
            ->where('teacher_status_id','=', $id)
            ->first();
//        echo '<pre>';
//        print_r($teacher);die();
        return view('admin.teacher_status.edit',compact('teacher'));
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
        $slug = Ultility::createSlug($request->input('teacher_status_name'));
        $teacher_status = new Teacher_status();
        $teacher_status_id = $teacher_status->where('teacher_status_id',$id)->update([
            'teacher_status_name' => $request->input('teacher_status_name'),
            'teacher_status_slug' => $slug,
            'teacher_status_des' => $request->input('teacher_status_des'),
            'created_at' => new \DateTime(),
        ]);
        // insert slug
        $teacher_slug = $teacher_status
            ->where('teacher_status_slug', $slug)
            ->where('teacher_status_id','!=', $id)
            ->first();
        if (empty($teacher_slug)) {
            $teacher_status->where('teacher_status_id', '=', $id)
                ->update([
                    'teacher_status_slug' => $slug
                ]);
        } else {
            $teacher_status->where('teacher_status_id', '=', $id)
                ->update([
                    'teacher_status_slug' => $slug.'-'.$id
                ]);
        }
        return redirect(route('teacher_status.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher_status = new Teacher_status();
        $teacher_status_id = $teacher_status->where('teacher_status_id',$id)->delete();
        return redirect(route('teacher_status.index'));
    }
}
