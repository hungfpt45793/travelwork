<?php

namespace App\Http\Controllers\Admin;
use App\Entity\Category_template_email;
use App\Entity\Template_email;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Entity\MailConfig;

class Template_emailController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'template_email');

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
        $category_template_email_model = new Category_template_email();
        $category_template_email = $category_template_email_model->select('*')->orderBy('id_cate_tem','desc')->paginate(50);
        return view('admin.template_email.template.list',compact('category_template_email'));
    }
    public function list_template($id_cate_tem)
    {
        $category_template_email_model = new Category_template_email();
        $category_template_email = $category_template_email_model->select('*')->where('id_cate_tem',$id_cate_tem)->first();
        $template_email_model = new Template_email();
        $template_email = $template_email_model->select('*')->where('id_cate_tem',$id_cate_tem)->paginate(20);

        return view('admin.template_email.template.list_template',compact('template_email','category_template_email'));
    }
    public function add_template(Request $request ,$id_cate_tem)
    {
        $category_template_email_model = new Category_template_email();
        $category_template_email = $category_template_email_model->select('*')->where('id_cate_tem',$id_cate_tem)->first();

        return view('admin.template_email.template.add_template',compact('category_template_email'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_template_email_model = new Category_template_email();
        $category_template_email = $category_template_email_model->select('*')->orderBy('id_cate_tem','desc')->get();
        return view('admin.template_email.template.add',compact('category_template_email'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $template_email_model = new Template_email();
            $slug_tem = \App\Ultility\Ultility::createSlug($request->input('slug_tem'));
            $insert = $template_email_model->insertGetId([
                'name_tem' => $request->input('name_tem'),
                'slug_tem' => $slug_tem,
                'subject_tem' => $request->input('subject_tem'),
                'content_tem' => $request->input('content_tem'),
                'id_cate_tem' => $request->input('id_cate_tem'),
                'status_tem' => $request->input('status_tem'),
                'status_people' => $request->input('status_people'),
                'created_at' => new \DateTime()
            ]);
            return redirect(route('list_template',['id_cate_tem'=>$request->input('id_cate_tem')]))->with('success','Thêm thành công');
        }
        catch (\Exception $ex)
        {
            return redirect(route('list_template',['id_cate_tem'=>$request->input('id_cate_tem')]))->with('error','Thêm thất bại');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $template_email_model = new Template_email();

        $template_email = $template_email_model->select('*')->where('id_tem',$id)->first();

        $category_template_email_model = new Category_template_email();
        $category_template_email = $category_template_email_model->select('*')->orderBy('id_cate_tem','desc')
            ->where('id_cate_tem',$template_email->id_cate_tem)->first();
        return view('admin.template_email.template.edit',compact('template_email','category_template_email'));
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
//        try
//        {
            $template_email_model = new Template_email();
            $slug_tem = \App\Ultility\Ultility::createSlug($request->input('slug_tem'));
            $insert = $template_email_model->where('id_tem',$id)->update([
                'name_tem' => $request->input('name_tem'),
                'slug_tem' => $slug_tem,
                'subject_tem' => $request->input('subject_tem'),
                'content_tem' => $request->input('content_tem'),
                'status_tem' => $request->input('status_tem'),
                'status_people' => $request->input('status_people'),
                'updated_at' => new \DateTime()
            ]);
            return redirect(route('list_template',['id_cate_tem'=>$request->input('id_cate_tem')]))->with('success','Sửa thành công');
//        }
//        catch (\Exception $ex)
//        {
//            return redirect(route('list_template',['id_cate_tem'=>$request->input('id_cate_tem')]))->with('error','Sửa thất bại');
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendEmail(Request $request) {
//        try {
        $id_tem = $request->input('id_tem');
        $template_email_model = new Template_email();
        $template_email = $template_email_model->select('*')->where('id_tem',$id_tem)->first();


//        biến khi gửi mail
        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');

        $content_email = $template_email->content_tem;
        $subject = $template_email->subject_tem;

        $search =['{name}','{phone}','{email}'];
        $replace   = [$name,$phone,$email];
        $content_string = str_replace($search,$replace,$content_email);
//        $string = str_replace('{name}','thắng',$content_email);
//        $string = str_replace('{email}','thang@gmail.com',$content_email);

//        echo $string;die();
        $result = MailConfig::sendMail($email, $subject, $content_string);
        if ($result == true) {
//            route('list_template',['id_cate_tem'=> $cate->id_cate_tem])
           return redirect(route('list_template',['id_cate_tem'=>$template_email->id_cate_tem]))->with('success','Gửi thành công');
        }
        return redirect(route('list_template',['id_cate_tem'=>$template_email->id_cate_tem]))->with('error','Gửi thất bại');

    }


}
