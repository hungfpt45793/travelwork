@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', !empty($information_service->title) ? $information_service->title : 'Bảng giá dịch vụ')
@section('meta_description', !empty($information_service->title) ? $information_service->title : 'Bảng giá dịch vụ website sanketoan.vn')
@section('keywords', !empty($information_service->title) ? $information_service->title : 'Bảng giá')
{{--@section('meta_image', !empty($information_service->title) ? $information_service->title : '')--}}
@section('meta_image', !empty($information['og_image']) ?  asset($information['og_image']) : '' )
@section('meta_url',!empty($information_service->title) ? $information_service->title : '' )
<style>

</style>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/list_price.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/web/css/list_employee.css') }}"/>


@section('content')

    <section class="list_price_pree">
        <div class="container container_w_1200">

            @include('site.partials_site.box_price')

            <div class="row table_price">
                <div class=" col-md-12 text-center title_table_price" id="href_table_combo_profile">
                    <h2>
                        Bảng giá Sàn Kế Toán
                    </h2>
                </div>
                <?php
                $list_all_prices = App\Entity\Service_price::get_all();
                ?>
                @foreach ($list_all_prices as $id=>$i_price)
                    <div class="col-lg-3 col-xl-3 col-md-6 mb-3 col-12 total_box @if($i_price->service_price_slug == $slug) active_table @endif"
                         id="href_table_combo_profile{{ $i_price->service_price_id }}">
                        <div class="item_table_price maxHeight_service_feature">
                            <div class="maxHeight_service">
                                <div class="img_item_table">
                                    <img src="{{ !empty($i_price->image) ? asset($i_price->image) : '' }}">
                                    {{--<img src="https://sanketoan.vn/public/library/images/img_bang_gia/ic2.png">--}}
                                </div>
                                <div class="title_goi_tin text-center">
                                    <h3 class="name_box text-center text-uppercase">
                                        {{ $i_price->service_price_title }}
                                    </h3>
                                </div>
                                <div class="detail_box pl-2 ">
                                    <span style="line-height: 1em">{!! $i_price->feature !!}</span>
                                </div>
                            </div>
                            <div class="button_more text-center">
                                <a href="{{ route('detail_list_price',['slug'=>$i_price->service_price_slug]) }}#href_table_combo_profile{{ $i_price->service_price_id }}"
                                   class="ct_button_more text-center">Xem
                                    chi tiết <i class="fa fa-caret-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>

                    {{--//hien thi tren moble--}}
                    <div class="col-12 hide_pc show_mobile show_table_mobile">
                        @if($i_price->service_price_slug == $slug)
                            <h2>{{ $list_price->service_price_title }}</h2>
                            @if(!empty($list_prices_dif))
                                @foreach ($list_prices_dif as $list_price_dif)
                                    @php
                                        $hunter = \App\Entity\Service_hunter::get_detail_hunter($list_price_dif->service_price_id)
                                    @endphp

                                    <div id="scroll{{ $list_price_dif->service_price_id }} {{ ($slug==$list_price_dif->service_price_slug) ? 'scrollit' : '' }}"
                                         class="col-12 item_price_list total_box{{ $list_price_dif->service_price_id }} {{ ($slug!=$list_price_dif->service_price_slug) ? 'd-none' : '' }}">
                                        <div class="row">
                                            <div class="col-9 pt-2">
                                                <h5>{{ $hunter->service_hunter_name }}</h5>
                                            </div>
                                            <div class="col-3 pt-2">
                                                <div class="float-right">
                                                    {{-- <i class="fas fa-times btn btn-danger"></i> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <img class="lazy" data-src="{{ $hunter->service_hunter_image }}" alt="">
                                            </div>
                                            <div class="col-12">
                                                <p class="intro">
                                                    {!! $hunter->service_hunter_info !!}
                                                </p>
                                            </div>
                                            <hr>
                                            <div class="col-12">
                                                {!! $hunter->service_hunter_pay !!}
                                            </div>
                                            <div class="col-12">
                                                @foreach ($hunters_pos as $hunter_pos)
                                                    <div class="item_mobile_combo">
                                                        <ul>
                                                            <li class="mobile_label">Vị trí cần tuyển</li>
                                                            <li class="mobile_value">{{ $hunter_pos->hunter_pos_name }}</li>
                                                            @foreach ($hunters_time as $hunter_time)
                                                                <li class="mobile_label">{{ $hunter_time->hunter_time_name }}
                                                                    <sup style="font-size: 12px">(thời gian)</sup></li>
                                                                <?php
                                                                $hunters_price = \App\Http\Controllers\Site\ListPriceController::getHunterPrice_day($hunter_pos->hunter_pos_id, $hunter_time->hunter_time_id)
                                                                ?>
                                                                <li class="mobile_value mobile_value_hunter">
                                                                    <form id="hunter_price_form"
                                                                          action="{{ route('save_registration_hunter') }}">

                                                                    <span>
                                                                        {{--{{ $hunters_price->hunter_price }}---}}
                                                                        {{ $hunters_price->hunter_price_name }}
                                                                        {{--{{ $hunters_price->hunter_time_id }}---}}
                                                                    </span>
                                                                        <input type="hidden" name="hunter_price_id"
                                                                               value="{{ $hunters_price->hunter_price_id }}"
                                                                               id="id{{ $hunters_price->hunter_price_id }}">
                                                                        <button type="submit"
                                                                                class="btn btn-primary btn{{ $hunter_pos->hunter_pos_id }} res_from_table">
                                                                            Đăng
                                                                            ký ngay<i class="fa fa-caret-right"
                                                                                      aria-hidden="true"></i>
                                                                        </button>
                                                                    </form>
                                                                </li>

                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endforeach


                                            </div>
                                            <div class="col-12">
                                                {!! $hunter->service_hunter_contact !!}
                                            </div>
                                        </div>

                                        <a href="{{ route('pdf_list_price_hunter',  $list_price_dif->service_price_id ) }}"
                                           class="btn btn-primary">Xuất bảng giá</a>
                                    </div>
                                @endforeach
                            @endif

                            @php
                                $table_prices = \App\Entity\Service_table_price::getTablePrices($list_price->service_price_id);
                            @endphp

                            @if(!empty($table_prices))

                                @foreach ($table_prices as $id_b=>$table_price)
                                    <div class="item_mobile_combo">
                                        <ul>
                                            <li class="mobile_label">Số tuần</li>
                                            <li class="mobile_value">{{ $table_price->package_name }}</li>
                                            <li class="mobile_label">Giá (Vnđ)</li>
                                            <li class="mobile_value mobile_value_price">{{ $table_price->package_price }}</li>
                                            <li class="mobile_label">Chiết khấu</li>
                                            <li class="mobile_value">{{ $table_price->package_discount }}</li>
                                            <li class="mobile_label ">Giá sau chiết khấu</li>
                                            <li class="mobile_value mobile_value_package_vat">{{ $table_price->package_vat }}</li>
                                        </ul>
                                        <div class="footer_item_mobile">
                                            <a class="modal_rs js_show_ql"
                                               data_id="{{$table_price->service_table_price_id}}"><i
                                                        class="fa fa-check-circle" aria-hidden="true"></i>Quyền lợi</a>
                                            <a class="modal_rs js_show_combo"
                                               data_id="{{$table_price->service_table_price_id}}"><i
                                                        class="fa fa-check-circle" aria-hidden="true"></i>Ưu đãi</a>
                                            <a href="{{ route('pay_price') }}?service={{$list_price->service_price_id}}&&service_package={{ $table_price->service_table_price_id }}"
                                               class="res_from_table">Đăng ký ngay <i class="fa fa-caret-right"
                                                                                      aria-hidden="true"></i></a>
                                        </div>
                                    </div>

                                    <?php
                                    $get_table_price = \App\Entity\Service_comment::get_table_price($table_price->service_table_price_id);
                                    ?>
                                    <div class="col-12 ">
                                        <div class="box_ql_combo js_hidden_mobile js_hidden_ql{{$table_price->service_table_price_id}}">
                                            {!! !empty($get_table_price['benifit']) ? $get_table_price['benifit'] : '' !!}
                                        </div>
                                        <div class="box_ql_combo js_hidden_mobile js_hidden_combo{{$table_price->service_table_price_id}}">
                                            {!! !empty($get_table_price['endow']) ? $get_table_price['endow'] : '' !!}
                                        </div>
                                    </div>

                                @endforeach
                                {{--//show luon quyen loi va uu dai ben dươi--}}

                                @if($slug != 'tuyen-dung-ke-toan-theo-yeu-cau')
                                    <a href="{{ route('pdf_list_price', $list_price->service_price_id ) }}"
                                       class="btn btn-primary pdf_list_price">Xuất bảng giá</a>
                                @endif

                            @endif





                        @endif
                    </div>

                @endforeach
            </div>

            <div class="row table_combo_profile hide_mobile" id="">
                <div class="col-md-12 title_table_combo_profile">
                  
                    <h2>{{ $list_price->service_price_title }}</h2>
                </div>

                <div class="col-md-12 list_table_combo_profile ">
                    @if(!empty($list_prices_dif) && $slug == 'tuyen-dung-ke-toan-theo-yeu-cau')
                        @foreach ($list_prices_dif as $list_price_dif)
                            @php
                                $hunter = \App\Entity\Service_hunter::get_detail_hunter($list_price_dif->service_price_id)
                            @endphp


                            <div id="scroll{{ $list_price_dif->service_price_id }} {{ ($slug==$list_price_dif->service_price_slug) ? 'scrollit' : '' }}"
                                 class="col-12 pt-5 mt-2 item_price_list total_box{{ $list_price_dif->service_price_id }} {{ ($slug!=$list_price_dif->service_price_slug) ? 'd-none' : '' }}">
                                <div class="row">
                                    <div class="col-9 pt-2">
                                        <h5>{{ $hunter->service_hunter_name }}</h5>
                                    </div>
                                    <div class="col-3 pt-2">
                                        <div class="float-right">
                                            {{-- <i class="fas fa-times btn btn-danger"></i> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <img class="lazy" data-src="{{ $hunter->service_hunter_image }}" alt="">
                                    </div>
                                    <div class="col-12">
                                        <p class="intro">
                                            {!! $hunter->service_hunter_info !!}
                                        </p>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        {!! $hunter->service_hunter_pay !!}
                                    </div>
                                    <div class="col-12">


                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th rowspan="2" class="text-center">Vị trí cần tuyển</th>
                                                    <th colspan="{{ $hunters_time->count() }}" class="text-center">Thời
                                                        gian
                                                    </th>
                                                    <th rowspan="2" class="text-center">Đăng ký</th>
                                                </tr>
                                                <tr>
                                                    @foreach ($hunters_time as $hunter_time)
                                                        <th class="text-center">{{ $hunter_time->hunter_time_name }}</th>
                                                    @endforeach
                                                </tr>
                                                @foreach ($hunters_pos as $hunter_pos)
                                                    <tr>
                                                        @php
                                                            $hunters_price =
                                                            \App\Http\Controllers\Site\ListPriceController::getHunterPrice($hunter_pos->hunter_pos_id)
                                                        @endphp
                                                        <td class="text-center">{{ $hunter_pos->hunter_pos_name }}</td>

                                                        <form id="hunter_price_form"
                                                              action="{{ route('save_registration_hunter') }}">
                                                            @foreach ($hunters_price as $hunter_price)
                                                                <td><span class="float-right hunter_price_id"><input
                                                                                type="radio"
                                                                                data="btn{{ $hunter_pos->hunter_pos_id }}"
                                                                                name="hunter_price_id"
                                                                                id="id{{ $hunter_price->hunter_price_id }}"
                                                                                value="{{ $hunter_price->hunter_price_id }}"> <label
                                                                                for="id{{ $hunter_price->hunter_price_id }}">{{ $hunter_price->hunter_price_name }}</label></span>
                                                                </td>
                                                            @endforeach
                                                            <td class="d-flex justify-content-center">
                                                                <button type="submit" disabled
                                                                        class="btn btn-primary btn{{ $hunter_pos->hunter_pos_id }} res_from_table">
                                                                    Đăng
                                                                    ký
                                                                </button>
                                                            </td>
                                                        </form>
                                                    </tr>
                                                @endforeach
                                            </table>
                                            <a href="{{ route('pdf_list_price_hunter',  $list_price_dif->service_price_id ) }}"
                                               class="btn btn-primary">Xuất bảng giá</a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        {!! $hunter->service_hunter_contact !!}
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    @endif




                    @php
                        $table_prices = \App\Entity\Service_table_price::getTablePrices($list_price->service_price_id);
                    @endphp
                    @if(!empty($table_prices) && $slug != 'tuyen-dung-ke-toan-theo-yeu-cau')

                        <form action="{{ route('pay_price') }}" method="get">
                            <table class="table table-bordered table-hover d-table-respon">
                                <thead>
                                <tr>
                                    <th>Số tuần</th>
                                    <th>Giá <span class="mbdsNone">(vnđ)</span></th>
                                    <th>Chiết khấu</th>
                                    <th>Giá sau CK <span class="mbdsNone">(vnđ)</span></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>


                                <input value="{{ $list_price->service_price_id }}" type="text"
                                       name="service" hidden>
                                @foreach ($table_prices as $id_b=>$table_price)
                                    <tr class="@if($id_b == 0) active_td @endif" data_id={{$id_b}} >
                                        <td>
                                            <label for="q{{ $table_price->service_table_price_id }}">
                                                {{ $table_price->package_name }}
                                            </label>

                                        </td>
                                        <td>
                                            <p class="right_in_table td_table_price">{{ $table_price->package_price }}</p>
                                        </td>
                                        <td>
                                            <p class="center_in_table">{{ $table_price->package_discount }}</p>
                                        </td>
                                        <td>
                                            <p class="right_in_table td_table_price_dis">{{ $table_price->package_vat }}</p>
                                        </td>
                                        <td>

                                            <a href="{{ route('pay_price') }}?service={{$list_price->service_price_id}}&&service_package={{ $table_price->service_table_price_id }}"
                                               class="res_from_table">Đăng ký ngay <i class="fa fa-caret-right"
                                                                                      aria-hidden="true"></i></a>


                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <p class="text-center"><span class="clRed">(*)</span> : Bạn Click vào gói hồ sơ để xem chi
                                tiết quyền lợi và ưu đãi bên dưới</p>
                        </form>



                        <div class="mbdsBlock text-center">
                            <img width="40px" src="{{ asset('assets/image/down.png') }}">
                        </div>


                        <a href="{{ route('pdf_list_price', $list_price->service_price_id ) }}"
                           class="btn btn-primary pdf_list_price">Xuất bảng giá</a>

                    @endif
                </div>
            </div>
            @if(!empty($table_prices))
                @foreach ($table_prices as $id_b=>$table_price)
                    <div class="hide_mobile list_ql_combo @if($id_b == 0) active_td @endif js_remove_hidden active_td{{$id_b}}"
                         id="href_list_combo">
                        <div class="row">


                            <?php

                            $get_table_price = \App\Entity\Service_comment::get_table_price($table_price->service_table_price_id);
                            ?>

                            {{--@foreach($get_table_price as $id=>$table_price)--}}
                            <div class="col-lg-6 col-md-6">
                                <div class="box_ql_combo maxHeight_box_ql_combo">
                                    <h3 class="text-center"><i class="fa fa-check-circle" aria-hidden="true"></i> QUYỀN
                                        LỢI
                                    </h3>
                                    <div class="ql_combo_left">

                                        {!! !empty($get_table_price['benifit']) ? $get_table_price['benifit'] : '' !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="box_ql_combo maxHeight_box_ql_combo">
                                    <h3 class="text-center"><i class="fa fa-check-circle" aria-hidden="true"></i> ƯU ĐÃI
                                    </h3>
                                    <div class="ql_combo_left">
                                        {!! !empty($get_table_price['endow']) ? $get_table_price['endow'] : '' !!}
                                    </div>
                                </div>
                            </div>
                            {{--@endforeach--}}
                        </div>

                    </div>
                @endforeach
            @endif


        </div>
    </section>


    @include('site.default_site.list_sale')

    <section class="section_box_content mgt20 " style="border: none !important;">
        <div class="container container_w_1200">
            <div class="header_box ">
                <h3 class="title_box  fw6 f20 mgb0 col-f14">
                    Ứng viên nổi bật
                </h3>
            </div>
            <?php
            $list_employee = \App\Entity\Employee::get_employee(10);
            ?>
            <div class="content_box_employee col-xl-12 col-lg-12" style="border: 1px solid lightgray;">
                @foreach($list_employee as $employee)
                    @include('site.employee_site.item_employee_new',['employee' => $employee])
                @endforeach
            </div>
            <div class="text-center" style="display: block; padding: 20px 0px;">
                <a href="{{ route('show_employee') }}" style="color: #fff;
                    background-color: #07aa74;
                    border: none;
                    padding: 10px 15px;
                    border-radius: 7px;
                    font-size: 14px;">
                    Xem thêm</a></div>
        </div>
    </section>

    <section class="list_price_pree">
        <div class="container container_w_1200">
            @include('site.partials_site.box_price_question')
        </div>
    </section>






    <script>
        $(function () {

            $('.js_show_ql').click(function () {
                var data_id_ql = $(this).attr('data_id');
                $('.js_hidden_ql' + data_id_ql).show();
                $('.js_hidden_combo' + data_id_ql).hide();
            });
            $('.js_show_combo').click(function () {
                var data_id_combo = $(this).attr('data_id');
                $('.js_hidden_combo' + data_id_combo).show();
                $('.js_hidden_ql' + data_id_combo).hide();
            });
            $('.list_table_combo_profile tbody tr').click(function () {
                var data_id = $(this).attr('data_id');
                $('.list_table_combo_profile tbody tr').removeClass('active_td');
                $(this).addClass('active_td');
                $('.js_remove_hidden').hide();
                $('.active_td' + data_id).show();
                // alert(data_id);
            });

            // hien an cac tab cua div service_show_on_small
            $('.maxHeight_service_feature').matchHeight();
            $('#d-pills-tab').parent().find('.d-tab-content').find('.tab-pane').addClass('d-none');
            $('#d-pills-tab').parent().find('.d-tab-content .tab-pane:first-child').removeClass('d-none');
            $('#d-pills-tab li:first-child').addClass('service_show_on_small_li');
            $('#d-pills-tab li').click(function () {
                $('#d-pills-tab li').removeClass('service_show_on_small_li');
                $(this).addClass('service_show_on_small_li');
                $id = $(this).attr('data');
                $('#d-pills-tab').parent().find('.d-tab-content').find('.tab-pane').addClass('d-none');
                $('#d-pills-tab').parent().find('.d-tab-content').find('#' + $id).removeClass('d-none');

            })

            // $('.show_price_list .item_price_list').hide();
            $('.item_price_list i.fa-times').click(function () {
                $('.item_price_list').addClass('d-none');
            })
            $('.ct_button_more').click(function () {
                $id = $(this).parent().parent().parent().attr('id');
                $('.item_price_list').addClass('d-none');
                $('.' + $id).removeClass('d-none');
            })


            //service_show_on_small
            // $('#service_show_on_small .fade.show').hide();
            $('#service_show_on_small .content_feature div').hide();
            $('#service_show_on_small .feature p').on('click', function () {
                $class = $(this).attr('class');
                $('#service_show_on_small .feature p').not(this).removeClass('active_price');
                $(this).toggleClass('active_price');
                $('#service_show_on_small .content_feature div').hide();
                $(this).parent().parent().parent().find('.content_feature').find('div.' + $class).fadeToggle();
            })

            //dem so phan tu cua tab to
            // $count = 2;
            $('#service_show_on_small>ul>li').css({"width": "50%"})
            //hien uu dai quyen loi binh luan
            $(".service_table_price_id").change(function () {
                if ($(this).is(':checked')) {

                    $idintable = $(this).attr('id');
                    console.log($idintable)
                    $('.bonus').addClass('d-none')
                    $('.' + $idintable).removeClass('d-none');
                }
                // $(this).parent().parent().css({"background-color":"#333"})
            });
            $('.d-table-respon tr:first-child td input').attr('checked', true);
            $('.parent_bonus .bonus:first-child').removeClass('d-none');

            //an hien nut dang kys tuyen dung thue
            $('.hunter_price_id').find('input').click(function () {
                $id = $(this).attr("data");
                console.log($id);
                $('.' + $id).prop("disabled", false);
            })

            // ajax load binh luan mobile
            $('.tabs3').on('click', function () {
                let service_table_price_id = $(this).attr('data-service-id');
                let content_feature = $(this).parent().parent().parent().find('.content_feature').find('.tabs3');
                $.ajax({
                    'type': 'get',
                    'url': '{{ route("get_comment") }}',
                    'data': {
                        service_table_price_id: service_table_price_id
                    },
                    'success': function (res) {
                        let arr_comments = Object.values(res.comments);
                        let html = '';
                        arr_comments.forEach(ele => {
                            html += `
                                <img class="lazy" style="width: 50px;height:50px; float:left;"
                                        data-src="${ele.service_comment_image}"
                                        class="logo pr-1" alt="">
                                <p> ${ele.service_comment_content}</p>
                                <br>
                            `;
                        });
                        console.log(html)
                        content_feature.html(html);
                    }
                })
            })

        })
    </script>
@endsection