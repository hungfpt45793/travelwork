@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', 'Bảng giá dịch vụ ' . $name)

@section('meta_description', !empty($information_service->title) ? $information_service->title : 'Bảng giá dịch vụ website sanketoan.vn')
@section('keywords', !empty($information_service->title) ? $information_service->title : 'Bảng giá')
@section('meta_image', !empty($information_service->title) ? $information_service->title : '')
@section('meta_url',!empty($information_service->title) ? $information_service->title : '' )
<style>
    .tdhastable table:last-child {
        border-bottom: none !important
    }

    .tdhastable table {
        border-bottom: 2px solid #c06a23 !important;
    }

    .section_box_content {
        background: #fff;
    }

    .section_box_content h3.title_box {
        padding: 15px;
    }

    .section_box_content .item_employee_new:nth-child(2n) {
        background-color: #eee;
    }

    .bgrGray {
        background: #fff !important;
    }

    .icon_sendemail .fa-envelope-open-text {
        position: relative;
        top: 7px;
    }
</style>
<link rel="stylesheet" type="text/css" href="/public/assets/css/list_price.css"/>
<link rel="stylesheet" type="text/css" href="/public/assets/web/css/list_employee.css"/>

@section('content')
    <section class="PagesNewsContent bkxam bgrGray pdb20 pdt20">
        <div class="container container_w_1200">
            <div class="link bg-white mgb20" id="price_list">
                <div id="service_show_on_big">


                    @include('site.module_index_site.quyen_loi_dich_vu')

                    <div class="mbdsNone">
                        @include('site.module_index_site.hotline')
                    </div>
                    <div class="row show_price_list mb_show_price_list" id="scroll_mouse_fixel">
                        @foreach ($list_prices as $list_price)

                            <div id="scroll{{ $list_price->service_price_id }} {{ ($slug==$list_price->service_price_slug) ? 'scrollit' : '' }}"
                                 class="col-12 pt-5 mt-2 item_price_list total_box{{ $list_price->service_price_id }} {{ ($slug!=$list_price->service_price_slug) ? 'd-none' : '' }}">
                                <div class="row">
                                    <div class="col-md-7 col-12">
                                        <div class="table-responsive" style="">
                                            <form action="{{ route('pay_price') }}" method="get">
                                                <table class="table table-bordered table-hover d-table-respon">
                                                    <thead>
                                                    <tr>
                                                        <th>Số tuần</th>
                                                        <th>Giá <span class="mbdsNone">(vnđ)</span></th>
                                                        <th>Chiết khấu</th>
                                                        <th>Giá sau CK <span class="mbdsNone">(vnđ)</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $table_prices = \App\Entity\Service_table_price::getTablePrices($list_price->service_price_id);
                                                    @endphp
                                                    {{--  --}}
<!--                                                    --><?php
//                                                    echo '<pre>';
//                                                    print_r($table_prices);die;
//                                                    ?>

                                                    <input value="{{ $list_price->service_price_id }}" type="text"
                                                           name="service" hidden>
                                                    @foreach ($table_prices as $id_b=>$table_price)
                                                        <tr>
                                                            <td class="@if($id_b == 0) active_td @endif">
                                                                <label for="q{{ $table_price->service_table_price_id }}">
                                                                    <input style="transform: scale(1.3)" type="radio"
                                                                           id="q{{ $table_price->service_table_price_id }}"
                                                                           name="service_package"
                                                                           class="mr-1 service_table_price_id select_package_name"
                                                                           value="{{ $table_price->service_table_price_id }}">

                                                                    {{ $table_price->package_name }}
                                                                </label>

                                                            </td>
                                                            <td>
                                                                <p class="right_in_table">{{ $table_price->package_price }}</p>
                                                            </td>
                                                            <td>
                                                                <p class="center_in_table">{{ $table_price->package_discount }}</p>
                                                            </td>
                                                            <td>
                                                                <p class="right_in_table">{{ $table_price->package_vat }}</p>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <i class="dsNone mbdsBlock clRed f12 mgb5">(*) Xem thêm thông tin hồ sơ
                                                    bên dưới</i>
                                                <button type="submit" class="btn btn-warning d-center">Sử dụng dịch vụ
                                                    này
                                                </button>
                                                 <a href="{{ route('pdf_list_price', $list_price->service_price_id ) }}"
                                                   class="btn btn-primary">Xuất bảng giá</a>
                                            </form>
                                            <div class="dsNone mbdsBlock text-center">
                                                <img width="40px" src="{{ asset('assets/image/down.png') }}">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-5 col-12">
                                        <div class="title_right">
                                            <h3>{{ $list_price->service_price_title }}</h3>
                                        </div>
                                        <hr class="hr">
                                        <div class="parent_bonus detail_title_right">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach


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
                                                                        class="btn btn-primary btn{{ $hunter_pos->hunter_pos_id }}">
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
                    </div>
                </div>
            </div>

            <section class="section_box_content mgt20">
                <div class="header_box">
                    <h3 class="title_box  fw6 f20 mgb0 col-f14">
                        Ứng viên nổi bật
                    </h3>
                </div>
                <?php
                $list_employee = \App\Entity\Employee::get_employee(10);
                ?>
                <div class="content_box_employee">
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
            </section>
        </div>
    </section>
    <section class="registerRecruitmentAdvice pd40 bgrGray sm-pdt20 sm-pdb20">
        <div class="choose">
            <p class="text-center md-f15 sm-f13">Để tuyển dụng hiệu quả, vui lòng ĐĂNG KÝ TƯ VẤN để được hỗ
                trợ ngay
            </p>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('employer_register') }}" class="btn btn-block sm-f14 btnHome">Nhà tuyển dụng đăng
                        ký
                        tư vấn
                    </a>

                </div>
            </div>
        </div>
    </section>

    <!-- The Modal -->

    {{--@include('site.module_index.form-dang-ky-tu-van')--}}



    <script>

        $(function ($e) {
            $('.maxHieght_service_feature').matchHeight();
            $(window).on('load', function () {
                var pathArray = window.location.pathname.split('/');
                let last = pathArray.pop();
                $.ajax({
                    url: '{{ route('detail_table_price2') }}',
                    type: 'get',
                    data: {table_price_slug: last},
                    success: function (data) {
                        let obj = jQuery.parseJSON(data);
                        var string_comment = '';
                        $.each(obj.comments, function (index, element) {

                            string_comment += `
                        <div class="block_comment row">
                                <div class="col-md-3 col-md-xs-3">
                                    <img style="width: 50px;height:50px"
                                        src="${element.service_comment_image}" class="logo lazy" alt="">
                                </div>
                                <div class="col-md-9 col-md-xs-9">
                                    <p class="mess_comment">${element.service_comment_content}
                                    </p>
                                </div>
                            </div>
                        `
                        });
                        var html1 = '';

                        html1 += obj.table_prices.benifit;
                        html1 += '<hr class="hr">';
                        html1 += obj.table_prices.endow;
                        html1 += '<hr class="hr">';
                        html1 += string_comment;

                        console.log(html1)
                        $('.detail_title_right').html(html1);
                    }
                })
            });
            $e('body,html').animate({
                scrollTop: 1000
            }, 1000);
            // hien an cac tab cua div service_show_on_small

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
            // $('.ct_button_more').click(function(){
            //     $id = $(this).parent().parent().parent().attr('id');
            //     $('.item_price_list').addClass('d-none');
            //     $('.'+$id).removeClass('d-none');
            // })


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

        })

        $('.select_package_name').on('click', function () {
            let table_price_id = $(this).val();
            $.ajax({
                url: '{{ route('detail_table_price') }}',
                type: 'get',
                data: {table_price_id: table_price_id},
                success: function (data) {
                    let obj = jQuery.parseJSON(data);
                    var string_comment = '';
                    $.each(obj.comments, function (index, element) {

                        string_comment += `
                        <div class="block_comment row">
                                <div class="col-md-3 col-md-xs-3">
                                    <img style="width: 50px;height:50px"
                                        src="${element.service_comment_image}" class="logo lazy" alt="">
                                </div>
                                <div class="col-md-9 col-md-xs-9">
                                    <p class="mess_comment">${element.service_comment_content}
                                    </p>
                                </div>
                            </div>
                        `
                    });
                    var html1 = '';

                    html1 += obj.table_prices.benifit;
                    html1 += '<hr class="hr">';
                    html1 += obj.table_prices.endow;
                    html1 += '<hr class="hr">';
                    html1 += string_comment;

                    console.log(html1)
                    $('.detail_title_right').html(html1);
                }
            })
        })
    </script>
@endsection
