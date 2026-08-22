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

            @include('site.partials_site.box_price_pree')



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

            @include('site.partials_site.box_price_question')

        </div>
    </section>


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
