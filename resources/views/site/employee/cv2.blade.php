<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page{
			margin:0!important;
			padding:0!important;
			font-size: 13px;
		}
		body, body * {
            /*font-family: "Josefin Slab";*/
			/*font-family: "Roboto Slab" ;*/
			font-family: DejaVu Sans, sans-serif;
			letter-spacing: -.81px;
        }
        #block01 ,#block02 ,#block03 ,#block04 ,#block05 ,#block06
        {
            margin-left: 10px;

        }
        .ctbx {
            padding-left: 10px;
            padding-right: 15px;
            margin-bottom: 20px;
        }

        .head .block-title
        {
            margin-top: 15px;
        }
        .right{
            width:505px;
            height:100%;
            float:right;
            margin-bottom:30px;
        }
        img{
            width:195px;
            margin-left:49px;
            margin-top:16px
        }
        #box01{
            margin-top:5px;
        }
        #box01 p{
            display:block;
            width:271px;
            height:30px;
            line-height:20px;
            background:#ffad33;
            text-align: center;
            vertical-align:auto;
            margin: auto;
            margin-top:10px;
            border-radius:6px;
        }
        #box02 h3,#box03 .kynang,#box04 .giaithuong,#box05 h3,#box06 h3,#box07 h3{
            font-weight: bold;
            width:271px;
            display:block;
            height:30px;
            min-width: 25pt;
            margin: auto;
            color: #374d59;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 10px;
            text-align: center;
            border-radius: 100%;
            margin-top: 10px;
            border: solid 1px #fff;
            font-size: 18px;
        }
     
        #box02 p,#box04 p,#box05 p,#box06 p,#box07 p{
            width:271px;
            padding:10px;
            color: rgb(255, 255, 255);
        }
        h1{
            padding: 15px 30px 5px 45px;
            line-height: normal;
            text-align: left;
            margin-bottom: 0;
            margin-left: 0px;
            color: #fff;
            font-weight: 500;
        }
        #cv-top{
         
            margin:0
        }
        #cv-top h2{
            font-size: 20px;
            text-align: left;
            color: #ffad33;
            margin-left: 43px;
            margin-top: 5px;
            padding-top: 10px;
            border-top: solid 1px #fff;
        }
        #box-hvt{
            /* padding-top: 25px; */
            padding-bottom: 15px;
            line-height: normal;
            text-align: left;
            margin-bottom: 0;
            letter-spacing: 0px;
            margin-left: 0px;
            color: #fff;
            font-weight: 500;
        }
        #cv-content{
            margin-left:0px;
            margin-right:20px;
            margin-top:50px;
        }
        .head{
            font-size: 16px;
            margin-top: 0;
            font-weight:bold;
            text-transform: uppercase;
            /* display:inline-block; */
            color: #374d59;
            height: 30px;
            line-height: 22px;
            padding: 2px 10px;
            border-radius: 5px;
            max-width: 225px;
            width: 225px;
            margin-bottom: 0px;
            margin-top: 10px;
        }
        h3{
            min-height: 1em;
            font-weight: 600;
            color: #ffad33!important;
            width: 100%;
            margin:0!important;
        }
        .h3{
            min-height: 1em;
            display: inline-block;
            z-index: 9999;
            color: #374d59;
            font-size: 15px;
            margin:5px 0!important;
        }
        .exp-content{
            text-align: justify;
            /*width:480px!important;*/
            width:445px!important;
            padding-left: 5px;
            padding-right: 10px;
        }
        footer { position: fixed; bottom: 4mm; left: 0px; right: -4px;height: 25px;}
		.pagenum:after {
        content: counter(page);
}
    </style>
</head>
<body>
    <footer>
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
                <td style="width:39.333%;opacity:0"></p></td>
				<td style="width:27.333%;text-align:center;margin:auto"><p  style="color:rgb(26, 77, 172);" class="pagenum"> </p></td>
				<td style="width:33.333%;text-align:right;padding-right:5mm"></td>
			</tr>
		</table>
    </footer>
    <?php
    $color_id = $cv_employee->cv_color;

    $color = App\Entity\Cv_color::where('cv_color_id',$color_id)->first();
    $list_color_cv = explode(',', $color['order_color']);
    $color = \App\Entity\Cv_color::get_cv_color_id($cv_employee->cv_color);
            $list_color_cv = array();
            $list_color_cv = explode(',', $color['order_color']);
            $cl_cv_1 = $list_color_cv[0];
            $cl_cv_2 = $list_color_cv[1];
            $cl_cv_3 = $list_color_cv[2];
            $cl_cv_4 = $list_color_cv[3];
            $cl_cv_5 = $list_color_cv[4];
            $cl_cv_6 = $list_color_cv[5];
    ?>
    
    <div class="container" >
        <div class="right">
            <div id="cv-top" style="background:{{ $color->code_color }}">
                <div id="cvo-profile">
                    <div class="box-01">
                       
                        <div id="box-hvt" data_show="note_title_reference_person"
                            data_title="{{ 'Thông tin cá nhân' }}" class="js_click_box ">
                            <h1  style="color:{{ $cl_cv_2 }};margin-left:0;padding-left:0">
                                {{-- ho ten --}}
                                {{!empty($employee->employee_name) ? $employee->employee_name : '' }}
                            </h1>
                            @if(!empty($list_career))
                            <span style="color: #ffad33;font-size:16px">
                                @foreach($list_career as $career)
                                    - {{ $career->career_category_name }} <br>
                                @endforeach
                            </span>
                            @else
                            <h2 style="color: #ffad33;">
                                {{-- Vị trí công việc bạn muốn ứng tuyển" --}}
                                {{!empty($cv_employee->cv_title_job) ? $cv_employee->cv_title_job : '' }}
                            </h2>
                            @endif
                            {{-- <p><span id="cv-profile-about"></span></p> --}}
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
            <div id="cv-content">
                <div class="ir" id="sort_block">
                    <?php
                    $order_right = array();
                    $order_right = explode(',', $cv_employee->cv_order_join);
                    $show_hidden_right = array();
                    $show_hidden_right = explode(',', $cv_employee->show_hidden_cv_order_join);
                    ?>
                    @foreach($order_right as $or_right)
                    @if($or_right == 1)

                    <div id="block01" @if(!empty($show_hidden_right[0])) style="display: none" @endif>
                        {{-- trinh do hoc van --}}
                        <input type="hidden" name="cv_order_join[]" value="1">
                        <input type="hidden" name="show_hidden_cv_order_join[]"
                            class="show_hidden_cv_order"
                            @if(!empty($show_hidden_right[0])) value="1" @else value="0"
                            @endif>
                        
                        <p class="head" style="background:{{ $cl_cv_4 }};color:{{ $cl_cv_5 }}">
                            {{ !empty($cv_employee->title_cv_specialize) ? $cv_employee->title_cv_specialize : 'Trình độ học vấn' }}
                        </p>
                        <div id="experience-table">
                            <?php
                                    $list_cv_spe = \App\Entity\Cv_specialize::get_cv_id($cv_employee->cv_id);
                                    ?>
                            @if(!empty($list_cv_spe))
                            @foreach($list_cv_spe as $id_spec=>$spec)
                            <div id="exp{{ $id_spec + 1 }}" class="ctbx experience">
                                

                                <h3>
                                    {{-- ten cong ty --}}
                                    {{ !empty($spec->cv_spec_title) ? $spec->cv_spec_title : '' }}
                                </h3>
                                {{-- vi tri cong viec --}}
                                <p class="h3">
                                    {{ !empty($spec->cv_spec_name) ? $spec->cv_spec_name : '' }}
                                </p>
                                {{-- mo ta chi tiet lam dc nhung gi trong qua trinh lam viec --}}
                                <div class="exp-content" style="text-align: justify">
                                {!! !empty($spec->cv_spec_desc) ? nl2br($spec->cv_spec_desc) : '' !!}
                                </div>

                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($or_right == 2)
                    {{--kinh nghiệm làm việc--}}
                    <div id="block02" @if(!empty($show_hidden_right[1])) style="display: none" @endif>
                        <input type="hidden" name="cv_order_join[]" value="2">
                        <input type="hidden" name="show_hidden_cv_order_join[]"
                            class="show_hidden_cv_order"
                            @if(!empty($show_hidden_right[1])) value="1" @else value="0"
                            @endif>
                        

                        <p class="head" style="background:{{ $cl_cv_4 }};color:{{ $cl_cv_5 }}">
                            {{-- tieu de muc lon-kinh nghiem lam viec --}}
                            {{ !empty($cv_employee->title_cv_experience) ? $cv_employee->title_cv_experience : 'Kinh nghiệm làm việc' }}
                        </p>
                        <div id="experience-table">
                            <?php
                                    $list_cv_ex = \App\Entity\Cv_experience::get_cv_id($cv_employee->cv_id);
                                    ?>
                            @if(!empty($list_cv_ex))
                            @foreach($list_cv_ex as $id_ex=>$ex)
                            <div id="exp{{$id_ex + 1}}" class="ctbx experience">
                                
                                <h3>
                                    {{-- Công ty TNHH cổ phần Sắc màu --}}
                                    {{ !empty($ex->cv_ex_title) ? $ex->cv_ex_title : '' }}
                                </h3>
                                <p class="h3">
                                    {{-- Vị trí: Kế toán tổng hợp --}}
                                    {{ !empty($ex->cv_ex_name) ? $ex->cv_ex_name : '' }}
                                </p>
                                <br>
                                <div class="exp-content">{!! !empty($ex->cv_ex_desc) ? nl2br($ex->cv_ex_desc) : '' !!} </div>
                            </div>
                            @endforeach
                            @endif

                        </div>
                    </div>
                    @endif
                    @if($or_right == 3)
                    {{--Hoạt động--}}
                    <div id="block03" @if(!empty($show_hidden_right[2])) style="display: none" @endif>
                        <input type="hidden" name="cv_order_join[]" value="3">
                        <input type="hidden" name="show_hidden_cv_order_join[]"
                            class="show_hidden_cv_order"
                            @if(!empty($show_hidden_right[2])) value="1" @else value="0"
                            @endif>
                        
                        <p class="head" style="background:{{ $cl_cv_4 }};color:{{ $cl_cv_5 }}">
                            {{ !empty($cv_employee->title_cv_work) ? $cv_employee->title_cv_work : 'Hoạt động' }}
                        </p>
                        <div id="experience-table">
                            <?php
                                    $list_cv_work = \App\Entity\Cv_work::get_cv_id($cv_employee->cv_id);
                                    ?>
                            @if(!empty($list_cv_work))
                            @foreach($list_cv_work as $id_work=>$work)
                            <div id="exp{{ $id_work + 1 }}" class="ctbx experience">
                                
                                <h3>
                                    {{-- Nhóm tình nguyện Sàn kế toán 1 --}}
                                    {{ !empty($work->cv_work_title) ? $work->cv_work_title : '' }}
                                </h3>
                                <p class="h3">
                                    {{-- Tình nguyện viên --}}
                                    {{ !empty($work->cv_work_name) ? $work->cv_work_name : '' }}
                                </p>
                                <div class="exp-content"> {!! !empty($work->cv_work_desc) ? nl2br($work->cv_work_desc) : '' !!}</div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($or_right == 4)
                    {{--dự án tham gia--}}
                    <div id="block04" @if(!empty($show_hidden_right[3])) style="display: none" @endif>
                        <input type="hidden" name="cv_order_join[]" value="4">
                        <input type="hidden" name="show_hidden_cv_order_join[]"
                            class="show_hidden_cv_order"
                            @if(!empty($show_hidden_right[3])) value="1" @else value="0"
                            @endif>
                        
                        <p class="head" style="background:{{ $cl_cv_4 }};color:{{ $cl_cv_5 }}">
                            {{ !empty($cv_employee->title_cv_project) ? $cv_employee->title_cv_project : 'Dự án tham gia' }}
                        </p>
                        <div id="experience-table">
                            <?php
                                    $list_cv_project = \App\Entity\Cv_project::get_cv_id($cv_employee->cv_id);
                                    ?>
                            @if(!empty($list_cv_project))
                            @foreach($list_cv_project as $id_project=>$project)
                            <div id="exp{{ $id_project + 1 }}" class="ctbx experience">
                                
                                <h3>
                                    {{ !empty($project->cv_project_title) ? $project->cv_project_title : '' }}
                                </h3>
                                <p class="h3">
                                    {{ !empty($project->cv_project_name) ? $project->cv_project_name : '' }}
                                </p>
                                <div class="exp-content">
                                    {!! !empty($project->cv_project_des) ? nl2br($project->cv_project_des) : '' !!}
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($or_right == 5)
                    {{--Thông tin thêm--}}
                    <div id="block05" @if(!empty($show_hidden_right[4])) style="display: none" @endif>
                        <input type="hidden" name="cv_order_join[]" value="5">
                        <input type="hidden" name="show_hidden_cv_order_join[]"
                            class="show_hidden_cv_order"
                            @if(!empty($show_hidden_right[4])) value="1" @else value="0"
                            @endif>
                        
                        <p class="head" style="background:{{ $cl_cv_4 }};color:{{ $cl_cv_5 }}">
                            {{ !empty($cv_employee->title_cv_info) ? $cv_employee->title_cv_info : 'Thông tin thêm' }}
                        </p>
                        <div id="experience-table">
                            <?php
                                    $list_cv_info = \App\Entity\Cv_info::get_cv_id($cv_employee->cv_id);
                                    ?>
                            @if(!empty($list_cv_info))
                            @foreach($list_cv_info as $id_info=>$info)
                            <div id="exp{{ $id_info + 1 }}" class="ctbx experience">
                                
                                <h3>
                                    {{ !empty($info->cv_info_title) ? $info->cv_info_title : '' }}
                                </h3>
                                <p class="h3">
                                    {{ !empty($info->cv_info_name) ? $info->cv_info_name : '' }}
                                </p>
                                <div class="exp-content">{!! !empty($info->cv_info_des) ? nl2br($info->cv_info_des) : '' !!}</div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
   
</body>
</html>
