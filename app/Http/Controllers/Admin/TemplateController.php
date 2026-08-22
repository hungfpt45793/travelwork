<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Domain;
use App\Entity\Template;
use App\Entity\Theme;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;

class TemplateController extends AdminController
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
        $templates = Template::getTemplate();
        
        return View('admin.template.list', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.template.add');
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
            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }
            // insert to database
            $template = new Template();
            $template->insert([
                'title' => $request->input('title'),
                'slug' => $slug,
            ]);
        } catch (\Exception $e) {
            Log::error('http->admin->TemplateController->store: Lỗi thêm mới template');
        } finally {
            return redirect('admin/templates');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        return redirect('admin/templates');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {

        return View('admin.template.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        try {
            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }
            // insert to database
            $template->update([
                'title' => $request->input('title'),
                'slug' => $slug,
            ]);
        } catch (\Exception $e) {
            Log::error('http->admin->TemplateController->update: Lỗi chỉnh sửa template');
        } finally {
            return redirect('admin/templates');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        try {

            Template::where('template_id', $template->template_id)->delete();
        } catch (\Exception $e) {
            Log::error('http->admin->TemplateController->destroy: Lỗi xóa template');
        } finally {
            return redirect('admin/templates');
        }



    }
}
