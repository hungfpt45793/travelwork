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
		body {
			font-family: DejaVu Sans;
			letter-spacing: -.81px;
        }
        .container{
            width:790px;
        }
        .left{
            float:left;
            width:293px;
            height:100%;
        }
       
        img{
            width:195px;
            margin-left:49px; 
            height:210px;
            margin-top:16px;
            border:3px solid #fff;
            border-top:4px solid #fff;
            border-left:4px solid #fff;
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
        #box01 p.p{
            display:block;
            width:271px;
            height:60px;
            line-height:20px;
            background:#ffad33;
            text-align: center;
            vertical-align:auto;
            margin: auto;
            margin-top:10px;
            border-radius:6px;
        }
        #box02 h3,#box03 h3,#box04 h3,#box05 h3,#box06 h3,#box07 h3{
            font-weight: bold;
            width:271px;
            display:block;
            height:30px;
            min-width: 25pt;
            margin: auto;
            color: #374d59;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 0px;
            text-align: center;
            border-radius: 100%;
            margin-top: 35px;
            border: solid 1px #fff;
            font-size: 18px;
        }
     
        #box02 p,#box04 p,#box05 p,#box06 p,#box07 p{
            width:271px;
            padding:10px;
            color: rgb(255, 255, 255);
        }
        #box01 p.box-content , #box02 p.box-content , #box03 p ,#box04 p ,#box05 p ,#box06 p ,#box07 p ,#box08 p
        {
            width: 260px !important;
            margin-left: 12px;
            margin-right: 12px;
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
        <div class="left" style="background:{{ $color->code_color }}">
			@if(!empty($employee->employee_image))
				<?php
				$cv = str_replace("/public","",$employee->employee_image);
                    $cv =  public_path($cv);
                    
				?>
				@else
					<?php
				$cv = public_path('/assets/image/no_avatar.jpg');
				?>
			@endif
	

            <div id="cvo-profile-avatar-wraper">
                <img src="{{ !empty($employee->employee_image) ?  $cv  : public_path('/assets/image/no_avatar.jpg') }}"/>
            </div>
            <div id="sortable">


                <div id="box01">
                    {{-- @if (!empty($cv_employee->cv_email)) --}}
                    <p class="icoweb cvi-envelope-square">
                       <span>{{!empty($employee->email) ? $employee->email : 'Email'  }}</span> 
                    </p>
                    {{-- @endif --}}
                    {{--  --}}
                    {{-- @if (!empty($cv_employee->cv_phone)) --}}
                    <p class="icoweb cvi-phone">
                        <span>{{!empty($employee->phone) ? $employee->phone : 'Điện thoại'  }}</span> 
                    </p>
                    {{-- @endif --}}
                    {{--  --}}
                    {{-- @if (!empty($cv_employee->cv_birthday)) --}}
                    <p class="icoweb cvi-date">
                        <span>{{!empty($employee->birthday) ? date_format(date_create($employee->birthday),"d/m/Y") : 'Ngày sinh'  }}</span> 
                    </p>
                    {{-- @endif --}}
                    {{--  --}}
                    {{-- @if (!empty($cv_employee->cv_address)) --}}
                    <p class="icoweb cvi-map-marker p">
                        <span>{{!empty($employee->address) ? $employee->address : $employee->address  }}</span> 
                    </p>
                    {{-- @endif --}}
                    {{--  --}}
                    {{-- @if (!empty($cv_employee->cv_facebook)) --}}
                    <p class="icoweb cvi-info p">
                        <span>{{!empty($employee->my_facebook) ? $employee->my_facebook : 'Facebook'  }}</span> 
                    </p>
                    {{-- @endif  --}}
                </div>
                {{--tinh từ khoi block 2--}}
                <?php
                $order_left = array();
                $order_left = explode(',', $cv_employee->cv_order);
                $show_hidden_left = array();
                $show_hidden_left = explode(',', $cv_employee->show_hidden_cv_order);
                ?>
                @foreach($order_left as $or_left)
                @if($or_left == 1)
                <div id="box02" data_box="box02"
                    data_show="note_cv_title_career_goals"
                    data_title="{{ !empty($cv_employee->cv_title_career_goals) ? $cv_employee->cv_title_career_goals : 'Thông tin thêm' }}"
                    class="js_click_box block cvo-block"
                    @if(!empty($show_hidden_left[0])) style="display: none"
                    @endif>
                    <input type="hidden" name="cv_order[]" value="1">
                    <input type="hidden" name="show_hidden_cv_order[]"
                        class="show_hidden_cv_order"
                        @if(!empty($show_hidden_left[0])) value="1" @else
                        value="0" @endif>
                    
                    <h3 style="color:{{ $cl_cv_2 }}">
                        {{!empty($cv_employee->cv_title_career_goals) ? $cv_employee->cv_title_career_goals : 'Mục tiêu nghề nghiệp' }}
                    </h3>
                    <p style="color:{{ $cl_cv_6 }}" class="box-content">{!! !empty($cv_employee->cv_career_goals) ? nl2br($cv_employee->cv_career_goals) : '' !!}</p>
                </div>
                @endif
                @if($or_left == 2)
                <div id="box03" data_box="box03"
                    data_show="note_title_cv_skills"
                    data_title="{{!empty($cv_employee->title_cv_skills) ? $cv_employee->title_cv_skills : 'Kỹ năng' }}"
                    class="js_click_box block cvo-block box-skills"
                    @if(!empty($show_hidden_left[1])) style="display: none"
                    @endif>
                    <input type="hidden" name="cv_order[]" value="2">
                    <input type="hidden" name="show_hidden_cv_order[]"
                        class="show_hidden_cv_order"
                        @if(!empty($show_hidden_left[1])) value="1" @else
                        value="0" @endif>
                    
                    <h3 style="color:{{ $cl_cv_2 }}">
                        {{!empty($cv_employee->title_cv_skills) ? $cv_employee->title_cv_skills : 'Kỹ năng' }}
                    </h3>
                    <div class="exp content-edit skill">
                        <?php
                                $list_cv_skill = \App\Entity\Cv_skills::get_cv_id($cv_employee->cv_id);
                                ?>

                        @if(!empty($list_cv_skill))
                        @foreach($list_cv_skill as $id_skill=>$skill)
                        <div class="ctbx">
                            
                            <div style="color:{{ $cl_cv_6 }};width:271px;margin:auto;margin-bottom:5px">{{ !empty($skill->cv_skill_title) ? $skill->cv_skill_title : '' }}</div>
                           
                            <div class="bar-value-exp" style="position: relative;width:271px;margin:auto;margin-bottom: 12px;">
                                {{-- <input
                                    name="cv_skill_value[]" min="0" max="100"
                                    type="text"
                                    value="{{ !empty($skill->cv_skill_value) ? $skill->cv_skill_value : '50' }}"> --}}
                                <div class="thanhtrang" style="width:100%;background:#fff;height:10px;position: absolute;top:0;left:0;z-index:1;border-radius:4px"></div>
                                <div class="thanhtrang" style="width: @if($skill->cv_skill_value >= 100) 100% @else {{ $skill->cv_skill_value }}% @endif;background:rgb(0, 164, 210);height:10px;position: absolute;top:0;left:0;z-index:2;border-radius:4px"></div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                @endif
                @if($or_left == 3)
                <div id="box04" data_box="box04" data_show="note_cv_title_prize"
                    data_title="{{!empty($cv_employee->cv_title_prize) ? $cv_employee->cv_title_prize : 'Giải thưởng' }}"
                    class="js_click_box block cvo-block"
                    @if(!empty($show_hidden_left[2])) style="display: none"
                    @endif>
                    <input type="hidden" name="cv_order[]" value="3">
                    <input type="hidden" name="show_hidden_cv_order[]"
                        class="show_hidden_cv_order"
                        @if(!empty($show_hidden_left[2])) value="1" @else
                        value="0" @endif>
                    
                    <h3 style="color:{{ $cl_cv_2 }}">
                        {{!empty($cv_employee->cv_title_prize) ? $cv_employee->cv_title_prize : 'Giải thưởng' }}
                    </h3>
                    <p style="color:{{ $cl_cv_6 }}">{!! !empty($cv_employee->cv_interests) ? nl2br($cv_employee->cv_interests) : ''  !!}</p>
                </div>
                @endif
                @if($or_left == 4)
                <div id="box05" data_box="box05" data_show="note_cv_title_card"
                    data_title="{{!empty($cv_employee->cv_title_card) ? $cv_employee->cv_title_card : 'Chứng chỉ' }}"
                    class="js_click_box block cvo-block"
                    @if(!empty($show_hidden_left[3])) style="display: none"
                    @endif>
                    <input type="hidden" name="cv_order[]" value="4">
                    <input type="hidden" name="show_hidden_cv_order[]"
                        class="show_hidden_cv_order"
                        @if(!empty($show_hidden_left[3])) value="1" @else
                        value="0" @endif>
                    
                    <h3 style="color:{{ $cl_cv_2 }}">
                        {{!empty($cv_employee->cv_title_card) ? $cv_employee->cv_title_card : 'Chứng chỉ' }}
                    </h3>
                    <p style="color:{{ $cl_cv_6 }}">
                       {!! !empty($cv_employee->cv_card) ? nl2br($cv_employee->cv_card) : '' !!}
                    </p>
                </div>
                @endif
                @if($or_left == 5)
                <div id="box06" data_box="box06"
                    data_show="note_cv_title_interests"
                    data_title="{{!empty($cv_employee->cv_title_interests) ? $cv_employee->cv_title_interests : 'Sở thích' }}"
                    class="js_click_box block cvo-block"
                    @if(!empty($show_hidden_left[4])) style="display: none"
                    @endif>
                    <input type="hidden" name="cv_order[]" value="5">
                    <input type="hidden" name="show_hidden_cv_order[]"
                        class="show_hidden_cv_order"
                        @if(!empty($show_hidden_left[4])) value="1" @else
                        value="0" @endif>
                    
                    <h3 style="color:{{ $cl_cv_2 }}">
                        {{!empty($cv_employee->cv_title_interests) ? $cv_employee->cv_title_interests : 'Sở thích' }}
                    </h3>
                    <p style="color:{{ $cl_cv_6 }}">
                    {!! !empty($cv_employee->cv_interests) ? nl2br($cv_employee->cv_interests) : '' !!}
                    </p>
                </div>
                @endif
                @if($or_left == 6)
                <div id="box07" data_box="box07"  data_show="note_cv_title_reference_person"
                    data_title="{{!empty($cv_employee->cv_title_reference_person) ? $cv_employee->cv_title_reference_person : 'Người tham chiếu' }}"
                    class="js_click_box block cvo-block"
                    @if(!empty($show_hidden_left[5])) style="display: none"
                    @endif>
                    <input type="hidden" name="cv_order[]" value="6">
                    <input type="hidden" name="show_hidden_cv_order[]"
                        class="show_hidden_cv_order"
                        @if(!empty($show_hidden_left[5])) value="1" @else
                        value="0" @endif>
                    
                    <h3 style="color:{{ $cl_cv_2 }}">
                        {{!empty($cv_employee->cv_title_reference_person) ? $cv_employee->cv_title_reference_person : 'Người tham chiếu' }}
                    </h3>
                    <p  style="color:{{ $cl_cv_6 }}"
                    >
                    {!! !empty($cv_employee->cv_reference_person) ? nl2br($cv_employee->cv_reference_person) : '' !!}
                    </p>
                </div>
                @endif
                <div style="page-break-after: never"></div>
                @endforeach
            </div>
        </div>
  
   
    </div>
    <script>
        @php 
            $color = \App\Entity\Cv_color::get_cv_color_id($cv_employee->cv_color);
            $list_color_cv = array();
            $list_color_cv = explode(',', $color['order_color']);
        @endphp
            var cl_cv_1 = '{{ $list_color_cv[0] }}';
            var cl_cv_2 = '{{ $list_color_cv[1] }}';
            var cl_cv_3 = '{{ $list_color_cv[2] }}';
            var cl_cv_4 = '{{ $list_color_cv[3] }}';
            var cl_cv_5 = '{{ $list_color_cv[4] }}';
            var cl_cv_6 = '{{ $list_color_cv[5] }}';

            $('#box-hvt').css('background', cl_cv_1);
            $('#sortable').css('background', cl_cv_1);
            $('#cvo-profile-avatar-wraper').css('background', cl_cv_1);
            $('#form-cv').css('border', 'solid 1px' + cl_cv_1);
            $('#cv-right').css('background', 'solid 1px' + cl_cv_1);
            $('h3').css('color', cl_cv_2);
            $('h2').css('color', cl_cv_3);
            $('.head').css('background-color', cl_cv_4);
            $('#cv-content .head input').css('color', cl_cv_5);
            $('#ctbx .exp-title').css('color', cl_cv_1);
            $('textarea.box-content').css('color', cl_cv_6);
            $('input.skill-name').css('color', cl_cv_6);
			
			 console.log('1111111111');
			function toDataURL(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.onload = function() {
    var reader = new FileReader();
    reader.onloadend = function() {
      callback(reader.result);
    }
    reader.readAsDataURL(xhr.response);
  };
  xhr.open('GET', url);
  xhr.responseType = 'blob';
  xhr.send();
}

toDataURL({{$cv_employee->cv_image}}, function(dataUrl) {
  console.log('RESULT:', dataUrl)
})
   </script>
   
   
</body>
</html>