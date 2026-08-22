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

            {{--@include('site.partials_site.box_price_pree')--}}
            @include('site.partials_site.box_price')


            <div class="row box_benefit">

                <div class="col-md-12  text-center title_benefit">
                    <h2>Lợi ích khi sử dụng gói miễn phí tại Travelwork</h2>
                </div>

                {{--loi-ich-khi-su-dung-goi-mien-phi-tai-sanketoan--}}
                @foreach(\App\Entity\SubPost::showSubPost('loi-ich-khi-su-dung-goi-mien-phi-tai-sanketoan',4,'asc') as $id => $benefit)
                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                        <div class="item_benefit text-center ">
                            {!! !empty($benefit['icon'])?$benefit['icon']:'' !!}
                            <p>{{ !empty($benefit['title'])?$benefit['title']:'' }}</p>
                            <div class="des_benefit"> {{ !empty($benefit['description'])?$benefit['description']:'' }}</div>
                        </div>
                    </div>
                @endforeach

                {{--cac-cau-hoi-thuong-gap-dang-tin-mien-phi--}}

            </div>
            <div class="row table_price">
                <div class=" col-md-12 text-center title_table_price">
                    <h2>
                        Bảng giá Travelwork
                    </h2>
                </div>
                <?php
                $list_prices = App\Entity\Service_price::get_all();
                ?>
                @foreach ($list_prices as $id=>$list_price)
                    <div class="col-md-3 mb-3  col-sm-3 total_box @if($id == 0) active_table @endif"
                         id="total_box{{ $list_price->service_price_id }}">
                        <div class="item_table_price maxHeight_service_feature">
                            <div class="maxHeight_service">
                                <div class="img_item_table">
                                    {{--<img src="{{ !empty($list_price->image) ? asset($list_price->image) : '' }}">--}}
                                    <img src="https://sanketoan.vn/public/library/images/img_bang_gia/ic2.png">
                                </div>
                                <div class="title_goi_tin text-center">
                                    <h3 class="name_box text-center text-uppercase">
                                        {{ $list_price->service_price_title }}
                                    </h3>
                                </div>
                                <div class="detail_box pl-2 ">
                                    <span style="line-height: 1em">{!! $list_price->feature !!}</span>
                                </div>
                            </div>
                            <div class="button_more text-center">
                                <a href="{{ route('detail_list_price',['slug'=>$list_price->service_price_slug]) }}#scroll_mouse_fixel"
                                   class="ct_button_more text-center">Xem
                                    chi tiết</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{--<div id="service_show_on_big">--}}
                    {{--<div class="row title_price_list">--}}
                       {{----}}
                    {{--</div>--}}
                    {{--@if(url()->current() == route('detail_list_price', ['slug'=> $price->service_price_slug])) style="background:#ff9200" @endif--}}
                {{--</div>--}}
            </div>



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




    {{--<section class="PagesNewsContent bkxam bgrGray pdb20 pdt20">--}}
    {{--<div class="container container_w_1200">--}}
    {{--<div class="link bg-white mgb20 pd10" id="price_list">--}}
    {{--<div id="service_show_on_big">--}}
    {{--@include('site.module_index_site.quyen_loi_dich_vu')--}}
    {{--</div>--}}
    {{--</div>--}}


    {{--</div>--}}

    {{--@include('site.module_index_site.hotline')--}}
    {{--</section>--}}

    {{--<section class="content bgrGray pdt5">--}}
    {{--<div class="container container_w_1200">--}}
    {{--<div class="row">--}}

    {{--</div>--}}
    {{--</div>--}}
    {{--</section>--}}





    {{--<section class="registerRecruitmentAdvice pd40 bgrGray sm-pdt20 sm-pdb20">--}}
    {{--<div class="choose">--}}

    {{--<p class="text-center md-f15 sm-f13">Để tuyển dụng hiệu quả, vui lòng ĐĂNG KÝ TƯ VẤN để được hỗ--}}
    {{--trợ ngay--}}
    {{--</p>--}}


    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
    {{--<a href="{{ route('employer_register') }}" class="btn btn-block sm-f14 btnHome" data-toggle="modal"--}}
    {{--data-target="#myModal1">Nhà tuyển dụng đăng ký--}}
    {{--tư vấn--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</section>--}}

    <!-- The Modal -->


    {{--@include('site.module_index.form-dang-ky-tu-van')--}}




    <script>
        $(function () {

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
