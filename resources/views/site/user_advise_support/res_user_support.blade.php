@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', 'Đăng ký dịch vụ hỗ trợ')
@section('meta_description', 'Đăng ký dịch vụ hỗ trợ')
@section('keywords', 'Đăng ký dịch vụ hỗ trợ')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('canonical', 'https://sanketoan.vn/')
@section('meta_url', 'https://sanketoan.vn/')

<link rel="stylesheet" href="{{ asset('assets/css/style_user_support.css') }}">
@section('content')

    {{--@include('site.partials.slider_new')--}}

    {{--@include('site.filter_site.filter_new')--}}
    @include('site.partials_site.video_course_youtube')
    <section class="res_user_advise">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-12">


                    <div class="row box_res_user_advise">
                        <div class="col-md-12 title_box_res_user text-center">
                            <h1>Dịch vụ cần hỗ trợ là gì ? </h1>
                        </div>
                        <?php
                        $list_support_input = \App\Entity\List_support::get();
                        ?>
                        @if(!empty($list_support_input))
                            @foreach($list_support_input as $combo)
                                <div class="col-md-4 col-12">
                                    <form action="{{ route('res_support') }}" method="post">
                                        {!! csrf_field() !!}
                                        <div class="item_box_res_user">
                                            <div class="header_item_box_res_user text-center">
                                                {{ !empty($combo->title_support) ? $combo->title_support : '' }}
                                            </div>
                                            {{--<div class="content_item_box_res_user">--}}
                                                {{--{!! !empty($combo->combom_des) ? $combo->combom_des : '' !!}</li>--}}
                                            {{--</div>--}}
                                            {{--<div class="price_item_box_res_user text-center">--}}
                                                {{--<span><i class="fas fa-dollar-sign"></i></span> Chi phí--}}
                                                {{--: {{ !empty($combo->combo_price) ? number_format($combo->combo_price) : '' }}--}}
                                                {{--VNĐ / tháng--}}
                                            {{--</div>--}}
                                            <input name="support_id" type="hidden"
                                                   value="{{ !empty($combo->support_id) ? $combo->support_id : '' }}">
                                            <div class="footer_item_box_res_user text-center">
                                                <button type="submit">Đăng ký ngay <i class="fas fa-caret-right"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        @endif


                    </div>
                </div>
            </div>

        </div>
    </section>



@endsection
@section('show_js')
    @if(!empty($errors->all()))
        <script>
            $('#res_advise').modal('show');
        </script>
    @endif
@endsection
