<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Cv_color;
use App\Entity\Cv_experience;
use App\Entity\Cv_info;
use App\Entity\Cv_note_template;
use App\Entity\Cv_project;
use App\Entity\Cv_skills;
use App\Entity\Cv_specialize;
use App\Entity\Cv_template;
use App\Entity\Cv_work;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Cv_templateController extends AdminController
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
        $list_cv_template = Cv_template::select('cv_template_id',
            'user_id',
            'cv_template_title',
            'cv_template_slug',
            'cv_template_image',
            'cv_template_content')->paginate(10);
        return view('admin.cv_template.list', compact('list_cv_template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = '';
        return view('admin.cv_template.add', compact('employee'));
    }

    public function setting_cv($cv_template_id)
    {
        $employee = '';
        $cv_tem_model = new Cv_template();
        $cv_employee = $cv_tem_model->where('cv_template_id', $cv_template_id)->first();

        return view('admin.cv_template.'.$cv_employee->cv_template_view,compact('cv_employee','employee'));
    }
    public function update_config_cv(Request $request)
    {
        $cv_template_model = new Cv_template();
        $cv_template_id = $request->cv_template_id;
        $update = $cv_template_model->where('cv_template_id',$cv_template_id)->update([
            'cv_title' => $request->cv_title,
            'cv_name' => $request->cv_name,
            'cv_title_job' => $request->cv_title_job,
            'cv_image' => $request->images,
            'cv_email'=> $request->cv_email,
            'cv_phone'=> $request->cv_phone,
            'cv_birthday'=> $request->cv_birthday,
            'cv_address'=> $request->cv_address,
            'cv_facebook'=> $request->cv_facebook,
            'cv_title_career_goals'=> $request->cv_title_career_goals,
            'cv_career_goals'=> $request->cv_career_goals,
            'cv_title_prize'=> $request->cv_title_prize,
            'cv_prize'=> $request->cv_prize,
            'cv_title_card'=> $request->cv_title_card,
            'cv_card'=> $request->cv_card,
            'cv_title_interests'=> $request->cv_title_interests,
            'cv_interests'=> $request->cv_interests,
            'cv_title_reference_person'=> $request->cv_title_reference_person,
            'cv_reference_person'=> $request->cv_reference_person,
            'title_cv_skills'=> $request->title_cv_skills,
            'title_cv_specialize'=> $request->title_cv_specialize,
            'title_cv_experience'=> $request->title_cv_experience,
            'title_cv_work'=> $request->title_cv_work,
            'title_cv_project'=> $request->title_cv_project,
            'title_cv_info'=> $request->title_cv_info,
            'updated_at'=> new \DateTime(),
        ]);
        //insert table skill
        $skils_model = new Cv_skills();
        $delete = $skils_model->where('template_id', $cv_template_id)->delete();
        //input mảng post lên
        $cv_skill_title_array = $request->cv_skill_title;
        $cv_skill_value_array = $request->cv_skill_value;
        foreach($cv_skill_title_array as $id_skill=>$skill)
        {
            $insert = $skils_model->insertGetId([
                'cv_id' => 0,
                'template_id' => $cv_template_id,
                'cv_skill_title'=> $skill,
                'cv_skill_value' =>$cv_skill_value_array[$id_skill],
                'created_at' => new \DateTime(),
            ]);
        }
        //insert cv_specialize
        $cv_specialize_model = new Cv_specialize();
        $delete = $cv_specialize_model->where('template_id', $cv_template_id)->delete();
        //input mảng post lên
        $cv_spec_title_array = $request->cv_spec_title;
        $cv_spec_name_array = $request->cv_spec_name;
        $cv_spec_desc_array = $request->cv_spec_desc;
        foreach($cv_spec_title_array as $id_spe=>$spec)
        {
            $insert = $cv_specialize_model->insertGetId([
                'cv_id' => 0,
                'template_id' => $cv_template_id,
                'cv_spec_title' => $spec,
                'cv_spec_name' => $cv_spec_name_array[$id_spe],
                'cv_spec_desc' => $cv_spec_desc_array[$id_spe],
                'created_at' => new \DateTime(),
            ]);
        }
        //insert Cv_experience
        $cv_ex_model = new Cv_experience();
        $delete = $cv_ex_model->where('template_id', $cv_template_id)->delete();
        //input mảng post lên
        $cv_ex_title_array = $request->cv_ex_title;
        $cv_ex_name_array = $request->cv_ex_name;
        $cv_ex_desc_array = $request->cv_ex_desc;
        foreach($cv_ex_title_array as $id_ex=>$ex)
        {
            $insert = $cv_ex_model->insertGetId([
                'cv_id' => 0,
                'template_id' => $cv_template_id,
                'cv_ex_title' =>$ex,
                'cv_ex_name'=>$cv_ex_name_array[$id_ex],
                'cv_ex_desc'=>$cv_ex_desc_array[$id_ex],
                'created_at' => new \DateTime(),
            ]);
        }
        //insert Cv_project
        $cv_work_model = new Cv_work();
        $delete = $cv_work_model->where('template_id', $cv_template_id)->delete();
        //input mảng post lên
        $cv_work_title_array = $request->cv_work_title;
        $cv_work_name_array = $request->cv_work_name;
        $cv_work_desc_array = $request->cv_work_desc;
        foreach($cv_work_title_array as $id_work=>$work)
        {
            $insert = $cv_work_model->insertGetId([
                'cv_id' => 0,
                'template_id' => $cv_template_id,
                'cv_work_title' => $work,
                'cv_work_name' => $cv_work_name_array[$id_work],
                'cv_work_desc'=> $cv_work_desc_array[$id_work],
                'created_at' => new \DateTime(),
            ]);
        }
        //insert Cv_project
        $cv_project_model = new Cv_project();
        $delete = $cv_project_model->where('template_id', $cv_template_id)->delete();
        //input mảng post lên
        $cv_project_title_array = $request->cv_project_title;
        $cv_project_name_array = $request->cv_project_name;
        $cv_project_des_array = $request->cv_project_des;
        foreach($cv_project_title_array as $id_project=>$project)
        {
            $insert = $cv_project_model->insertGetId([
                'cv_id' => 0,
                'template_id' => $cv_template_id,
                'cv_project_title' => $project,
                'cv_project_name' => $cv_project_name_array[$id_project],
                'cv_project_des' => $cv_project_des_array[$id_project],
                'created_at' => new \DateTime(),
            ]);
        }
        //insert Cv_project
        $cv_info_model = new Cv_info();
        $delete = $cv_info_model->where('template_id', $cv_template_id)->delete();
        //input mảng post lên
        $cv_info_title_array = $request->cv_info_title;
        $cv_info_name_array = $request->cv_info_name;
        $cv_info_des_array = $request->cv_info_des;
        foreach($cv_info_title_array as $id_info=>$info)
        {
            $insert = $cv_info_model->insertGetId([
                'cv_id' => 0,
                'template_id' => $cv_template_id,
                'cv_info_title' => $info,
                'cv_info_name'=>$cv_info_name_array[$id_info],
                'cv_info_des'=>$cv_info_des_array[$id_info],
                'created_at' => new \DateTime(),
            ]);
        }
        //insert Cv_color
//        $cv_color_model = new Cv_color();
//        $delete = $cv_color_model->where('template_id', $cv_template_id)->delete();
//        //input mảng post lên
//        $cv_title_color_array = $request->cv_title_color;
//        $cv_code_color_array = $request->code_color;
//        $cv_order_color_array = $request->order_color;
//        foreach($cv_title_color_array as $id_color=>$color)
//        {
//            $insert = $cv_color_model->insertGetId([
//                'cv_id' => 0,
//                'template_id' => $cv_template_id,
//                'cv_title' => $color,
//                'code_color'=>$cv_code_color_array[$id_color],
//                'order_color'=>$cv_order_color_array[$id_color],
//                'created_at' => new \DateTime(),
//            ]);
//        }
        return redirect()->back()->with('success','Cấu hình template thành công !');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $cv_tem_model = new Cv_template();
        $cv_template_slug = Ultility::createSlug($request->input('cv_template_title'));
        $insert_get_id = $cv_tem_model->insertGetId([
            'cv_career_category_id' => $request->cv_career_category_id,
            'user_id' => $user_id,
            'cv_template_view' => $request->cv_template_view,
            'cv_template_title'=> $request->cv_template_title,
            'cv_template_slug'=> $cv_template_slug,
            'cv_template_image'=> $request->cv_template_image,
            'cv_template_content'=> $request->cv_template_content,
            'created_at' => new \DateTime(),
        ]);

        $postWithSlug = $cv_tem_model->where('cv_template_slug', $cv_template_slug)->first();
        if (empty($postWithSlug)) {
            $cv_tem_model->where('cv_template_id', '=', $insert_get_id)
                ->update([
                    'cv_template_slug' => $cv_template_slug
                ]);
        } else {
            $cv_tem_model->where('cv_template_id', '=', $insert_get_id)
                ->update([
                    'cv_template_slug' => $cv_template_slug.'-'.$insert_get_id
                ]);
        }
        return redirect(route('cv_template.index'))->with('success','Thêm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function note_cv($cv_template_id)
    {
        $employee = '';
        $cv_tem_model = new Cv_template();
        $cv_employee = $cv_tem_model->where('cv_template_id', $cv_template_id)->first();
        $cv_not_model = new Cv_note_template();
        $cv_note = $cv_not_model->where('cv_template_id', $cv_template_id)->first();

        return view('admin.cv_template.note_cv',compact('cv_employee','employee','cv_note'));
    }
    public function update_note_cv(Request $request)
    {
        $cv_template_id = $request->cv_template_id;

        $cv_not_model = new Cv_note_template();
        $total_note = $cv_not_model->where('cv_template_id', $cv_template_id)->count();
        if($total_note > 0)
        {
            $update = $cv_not_model->where('cv_template_id',$cv_template_id)->update([
                'note_cv_personal' => $request->note_cv_personal,
                'note_guide' => $request->note_guide,
                'note_cv_title_career_goals' => $request->note_cv_title_career_goals,
                'note_cv_title_prize' => $request->note_cv_title_prize,
                'note_cv_title_card' => $request->note_cv_title_card,
                'note_cv_title_interests' => $request->note_cv_title_interests,
                'note_title_reference_person' => $request->note_title_reference_person,
                'note_title_cv_skills' => $request->note_title_cv_skills,
                'note_title_cv_specialize' => $request->note_title_cv_specialize,
                'note_title_cv_experience' => $request->note_title_cv_experience,
                'note_title_cv_work' => $request->note_title_cv_work,
                'note_title_cv_project' => $request->note_title_cv_project,
                'note_cv_info' => $request->note_cv_info,
                'updated_at'=> new \DateTime(),
            ]);
        }
        else
        {
            $insert = $cv_not_model->insertGetId([
                'cv_template_id' => $request->cv_template_id,
                'note_cv_personal' => $request->note_cv_personal,
                'note_guide' => $request->note_guide,
                'note_cv_title_career_goals' => $request->note_cv_title_career_goals,
                'note_cv_title_prize' => $request->note_cv_title_prize,
                'note_cv_title_card' => $request->note_cv_title_card,
                'note_cv_title_interests' => $request->note_cv_title_interests,
                'note_title_reference_person' => $request->note_title_reference_person,
                'note_title_cv_skills' => $request->note_title_cv_skills,
                'note_title_cv_specialize' => $request->note_title_cv_specialize,
                'note_title_cv_experience' => $request->note_title_cv_experience,
                'note_title_cv_work' => $request->note_title_cv_work,
                'note_title_cv_project' => $request->note_title_cv_project,
                'note_cv_info' => $request->note_cv_info,
                'created_at'=> new \DateTime(),
            ]);
        }

        return redirect(route('note_cv',['cv_template_id' =>$cv_template_id]))->with('success','Lưu thông tin thành công');
    }
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
