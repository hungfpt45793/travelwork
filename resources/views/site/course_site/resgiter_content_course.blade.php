@extends('site.layout_site.site')

{{--@section('type_meta', 'website')--}}
@section('title',!empty($course->course_title) ? 'Bảng giá khóa học '.$course->course_title : 'Bảng giá khóa học')
@section('meta_description',!empty($course->course_descript) ? $course->course_descript : 'Danh sách khóa học tại sanketoan.vn')
@section('keywords', !empty($course->course_title) ? 'Bảng giá khóa học '.$course->course_title : 'Bảng giá khóa học')
@section('meta_image', !empty($course->course_image) ?  asset($course->course_image) : $information['logo'] )

@section('show_css')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/sitebar.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/course/teacher.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/course/res_course.css') }}"/>
@endsection

@section('content')
    <section class="courses  mbds_none_1000">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-12">
                    <div class="box_price_course_resgister">
                        <h1>Bảng giá khóa học : {{ $course->course_title }} </h1>
                        <div class="box_price_course_table row">
                            <div class="col-md-6 padding_right0">
                                <table class="table">
                                    <thead class="">
                                    <tr>
                                        <th class="text-center background_th" scope="col">
                                            <div class="js_max_height_title">STT</div>
                                        </th>
                                        <th scope="col" class="background_th">
                                            <div class="js_max_height_title">Nội dung</div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list_trai as $id=>$trai)
                                        <tr>
                                            <th scope="row" class="text-center">
                                                <div class="js_max_height_table_td_{{$id}}">{{ $id + 1 }}
                                                </div>
                                            </th>
                                            <td>
                                                <div class="js_max_height_table_td_{{$id}}">{{ $trai->trai_title }}</div>
                                            </td>
                                        </tr>
                                    @endforeach



                                    <tr>
                                        <th scope="row" class="text-center">
                                            <div class="js_maxHiegh_bottom"></div>
                                        </th>

                                        <td class="">
                                            <div class="js_maxHiegh_bottom"> Giá</div>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 padding_left0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="">
                                        <tr>
                                            @foreach($learn_training as $learn)
                                                <th scope="col" class="text-center background_th">
                                                    <div class="js_max_height_title">{{ !empty($learn->learn_title) ? $learn->learn_title : '' }}</div>
                                                </th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list_trai as $id=>$trai)
                                            <tr>

                                                @foreach($learn_training as $id_learn=>$learn)
                                                    <?php
                                                    $check = \App\Entity\Learn_training_content::check_learn_training_content($learn->learn_id, $trai->trai_id);
                                                    ?>
                                                    <th scope="row" class="text-center">
                                                        <div class="js_max_height_table_td_{{$id}}">
                                                            @if(!empty($check))
                                                                <i class="fas fa-check f14 clGreen"></i>
                                                            @endif
                                                        </div>
                                                    </th>
                                                @endforeach

                                            </tr>
                                        @endforeach
                                        <tr>
                                            @foreach($learn_training as $learn)
                                                <?php
                                                $price = !empty($learn->learn_discount) ? $learn->learn_discount : $learn->learn_price;
                                                ?>
                                                <th scope="col"
                                                    class="text-center">
                                                    <div class="js_maxHiegh_bottom clRed">{{ !empty($price) ? number_format($price).' VNĐ' : 'Miễn phí' }}</div>
                                                </th>


                                            @endforeach
                                        </tr>





                                        <tr>
                                            @foreach($learn_training as $learn)
                                                <form action="{{ route('payment_learn') }}" method="get">
                                                    <th scope="col" class="text-center">
                                                        <input type="hidden" value="{{ $learn->courses_id }}"
                                                               name="course_id">
                                                        <input type="hidden" value="{{ $learn->learn_id }}"
                                                               name="learn_id">
                                                        <button type="submit" class="btn_res_th">Đăng ký ngay</button>
                                                    </th>
                                                </form>
                                            @endforeach
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

    <section class="courses dsNone mbds_block_1000">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-12">
                    <div class="box_price_course_resgister">
                        <h1>Bảng giá khóa học : {{ $course->course_title }} </h1>
                        <div class="box_price_course_table row ">
                            @foreach($learn_training as $id_learn=>$learn)
                                <div class="col-md-6 col-12  text-center">
                                    <div class="item_box_course_price">
                                        <div class="title_box_price">
                                            <h3>{{ !empty($learn->learn_title) ? $learn->learn_title : '' }}</h3>
                                        </div>
                                        <div class="content_box_price">
                                            <?php
                                            $list_training_1000 = \App\Entity\Learn_training_content::get_list_training($learn->learn_id);
                                            ?>
                                            <ul>
                                                @foreach($list_training_1000 as $trai_1000)
                                                    <li>
                                                        {{ !empty($trai_1000->trai_title) ? $trai_1000->trai_title : '' }}
                                                    </li>
                                                @endforeach
                                                <?php
                                                $price = !empty($learn->learn_discount) ? $learn->learn_discount : $learn->learn_price;
                                                ?>
                                                <li class="f16 fw6"> Giá : <span class="clRed ">
                                                            {{ !empty($price) ? number_format($price).' VNĐ' : 'Miễn phí' }}
                                                        </span></li>

                                            </ul>
                                        </div>
                                        <div class="btn_res_box_price">
                                            <form action="{{ route('payment_learn') }}" method="get">
                                                    <input type="hidden" value="{{ $learn->courses_id }}"
                                                           name="course_id">
                                                    <input type="hidden" value="{{ $learn->learn_id }}"
                                                           name="learn_id">
                                                    <button type="submit" class="btn_res_th">Đăng ký ngay <i class="fas fa-forward"></i></button>

                                            </form>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('show_js')
    {{--//saoo danh gia--}}
    <script>
        $('.js_max_height_title').matchHeight();
        $('.js_maxHiegh_bottom').matchHeight();
        $('.js_max_height_table_td_0').matchHeight();
        $('.js_max_height_table_td_1').matchHeight();
        $('.js_max_height_table_td_2').matchHeight();
        $('.js_max_height_table_td_3').matchHeight();
        $('.js_max_height_table_td_4').matchHeight();
        $('.js_max_height_table_td_5').matchHeight();
        $('.js_max_height_table_td_6').matchHeight();
        $('.js_max_height_table_td_7').matchHeight();
        $('.js_max_height_table_td_8').matchHeight();
        $('.js_max_height_table_td_9').matchHeight();
        $('.js_max_height_table_td_10').matchHeight();
        $('.js_max_height_table_td_11').matchHeight();
        $('.js_max_height_table_td_12').matchHeight();

    </script>
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection

