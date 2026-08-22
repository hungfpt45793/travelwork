<?php

namespace App\Http\Controllers\Staff;

use App\Entity\Category_template_email;
use App\Entity\MailConfig;
use App\Entity\Template_email;
use Illuminate\Http\Request;

class Template_emailController extends SiteStaffController
{
    function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'mauemail');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        $array_category_template_email = Category_template_email::orderBy('category_template_email.id_cate_tem', 'desc');

        if (!empty($request->input('name'))) {
            $array_category_template_email = $array_category_template_email->where('category_template_email.name_cate_tem', 'like', '%' . $request->input('name') . '%');
        }
        if (!empty($request->input('id_cate_tem'))) {
            $array_category_template_email = $array_category_template_email->where('category_template_email.id_cate_tem', $request->id_cate_tem);
        }
        $total = $array_category_template_email->count();
        $array_category_template_email = $array_category_template_email->paginate($num);
        return view('staff_admin.template_email.form_email', compact('array_category_template_email', 'total'));
    }

    public function create()
    {
        return view('staff_admin.template_email.create_email');
    }
    public function store(Request $request)
    {
        $category_template_email_model = new Category_template_email();
            $slug = \App\Ultility\Ultility::createSlug($request->input('name_cate_tem'));
            $insert = $category_template_email_model->insertGetId([
                'name_cate_tem' => $request->input('name_cate_tem'),
                'slug_cate_tem' => $slug,
                'note_tem_var' => $request->input('note_tem_var'),
                'created_at' => new \DateTime()
            ]);
        return redirect(route('form_email'))->with('success','Thêm thành công');
    }

    public function list_category_template_email($id_cate_tem)
    {
        $category_template_email_model = new Category_template_email();
        $category_template_email = $category_template_email_model->select('*')->where('id_cate_tem',$id_cate_tem)->first();
        $template_email_model = new Template_email();
        $template_email = $template_email_model->select('*')->where('id_cate_tem',$id_cate_tem)->paginate(20);

        return view('staff_admin.template_email.list_category_template_email',compact('template_email','category_template_email'));
    }

    public function edit_category_template_email($id)
    {

        $template_email_model = new Template_email();

        $template_email = $template_email_model->select('*')->where('id_tem',$id)->first();

        $category_template_email_model = new Category_template_email();
        $category_template_email = $category_template_email_model->select('*')->orderBy('id_cate_tem','desc')
            ->where('id_cate_tem',$template_email->id_cate_tem)->first();
        return view('staff_admin.template_email.edit_category_template_email',compact('template_email','category_template_email'));
    }

    public function update_category_template_email(Request $request, $id)
    {
        $idCategoryTemplateEmail = $request->input('id_cate_tem');
        $category_template_email = Template_email::find($id)->update($request->all());
        return redirect()->route('list_category_template_email', ['id'=> $idCategoryTemplateEmail])->with('success','Sửa mẫu email thành công');
    }

    public function sendEmailOfStaff(Request $request) {
        $id_tem = $request->input('id_tem');
        $template_email_model = new Template_email();
        $template_email = $template_email_model->select('*')->where('id_tem',$id_tem)->first();

        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');

        $content_email = $template_email->content_tem;
        $subject = $template_email->subject_tem;

        $search =['{name}','{phone}','{email}'];
        $replace   = [$name,$phone,$email];
        $content_string = str_replace($search,$replace,$content_email);
        $result = MailConfig::sendMail($email, $subject, $content_string);
        if ($result == true) {
            return redirect()->route('edit_category_template_email', ['id' => $id_tem])->with('success','Gửi thành công');
        }
        return redirect()->route('edit_category_template_email', ['id' => $id_tem])->with('success','Gửi thất bại');
    }


}
