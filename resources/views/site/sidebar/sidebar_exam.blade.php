
<div class="dnav col-xl-3 col-lg-4 col-md-12 sidebar_exam " id="">
    <div class="box_sidebar">
        <div class="header_box_sidebar">
            <span class="box_icon_exam">
                <i class="fa fa-building" aria-hidden="true"></i>
            </span>
            <span class="box_text_exam">
                 Loại hình doanh nghiệp
            </span>
            <span class="show_hidden_icon js_show_hidden_icon" >
                <i class="fa fa-angle-double-down" aria-hidden="true"></i>

                {{--<i class="fa fa-angle-double-up" aria-hidden="true"></i>--}}
            </span>
        </div>
        <div class="content_box_sidebar js_show">
            <ul>
                <?php
                $listtype = \App\Entity\TypeOfBusiness::list_type_of_business_id_exam();
                $get_type_of_business_id = !empty($_GET['t']) ? $_GET['t'] : '';
                $list_career =\App\Entity\Career::list_carrer_category_exam();
                $get_career_category_id = !empty($_GET['c']) ? $_GET['c'] : '';
//                $word = !empty($_GET['w']) ? $_GET['w'] : '';
                ?>
                @foreach($listtype as $id_y=>$type)
                    {{--type_of_business_slug--}}
                    {{--<option value="{{ $type->type_of_business_slug }}"--}}
                            {{--@if($type_of_business_id_get == $type->type_of_business_id) selected @endif--}}
                    {{--></option>--}}
                        <li>
                            <a href="{{ route('submit_category_Exam') }}?type_of_business_id={{ $type->type_of_business_id }}&career_category_id={{$get_career_category_id}}" class="js_type @if($type->type_of_business_id == $get_type_of_business_id) active @endif" data_id = "{{ $type->type_of_business_id }}">{{ $type->type_of_business_name }}</a>
                        </li>
                @endforeach
            </ul>
        </div>
    </div>



    <div class="box_sidebar">
        <div class="header_box_sidebar">
            <span class="box_icon_exam">
                <i class="fa fa-briefcase" aria-hidden="true"></i>
            </span>
            <span class="box_text_exam">
                 Vị trí công việc
            </span>
            <span class="show_hidden_icon js_show_hidden_icon">
                <i class="fa fa-angle-double-down" aria-hidden="true"></i>
            </span>
        </div>
        <div class="content_box_sidebar js_show">
            <ul>
                    @foreach($list_career  as $id_c=>$career)
                    {{--<option value="{{ $type->type_of_business_slug }}"--}}
                    {{--@if($type_of_business_id_get == $type->type_of_business_id) selected @endif--}}
                    {{--></option>--}}
                    {{--career_category_slug--}}
                    <li>
                        <a href="{{ route('submit_category_Exam') }}?type_of_business_id={{$get_type_of_business_id}}&career_category_id={{ $career->career_category_id }}" class="js_career @if($career->career_category_id == $get_career_category_id) active @endif" data_id = "{{ $career->career_category_id }}">{{  $career->career_category_name }}</a>

                        {{--<a @if($id_c == 0)class="active" @endif>{{ $career->career_category_name }}</a>--}}
                    </li>
                @endforeach
            </ul>

        </div>


    </div>

</div>
<script>
    $('.js_show_hidden_icon').click(function(){
        $(this).parent().parent().find('.content_box_sidebar').toggle(300);

        // if($(this).parent().parent().find('.content_box_sidebar').hasClass("js_show"))
        // {
        //     $(this).parent().parent().find('.content_box_sidebar').slideUp("slow");;
        //     $(this).parent().parent().find('.content_box_sidebar').removeClass("js_show");
        // }
        // else
        // {
        //     $(this).parent().parent().find('.content_box_sidebar').slideDown("slow");;
        //     $(this).parent().parent().find('.content_box_sidebar').addClass("js_show");
        // }

    });
</script>
