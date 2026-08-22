@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', 'Dịch vụ cần hỗ trợ với gia sư '.!empty($user_advise->name) ? $user_advise->name : '')
@section('meta_description','Dịch vụ cần hỗ trợ với gia sư '.!empty($user_advise->name) ? $user_advise->name : '')
@section('keywords', 'Dịch vụ cần hỗ trợ với gia sư '.!empty($user_advise->name) ? $user_advise->name : '')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('canonical', 'https://sanketoan.vn/')
@section('meta_url', 'https://sanketoan.vn/')

<link rel="stylesheet" href="{{ asset('assets/css/style_user_support.css') }}">
@section('content')

    {{--@include('site.partials.slider_new')--}}

    {{--@include('site.filter_site.filter_new')--}}

    <section class="res_user_advise">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-12">


                    <div class="row box_res_user_advise">
                        <div class="col-md-12 title_box_res_user text-center">
                            <h1>Dịch vụ cần hỗ trợ với gia sư : {{ !empty($user_advise->name) ? $user_advise->name : '' }} </h1>
                        </div>
                        <?php
                        $list_support_input = \App\Entity\List_support::get();
                        ?>
                        @if(!empty($list_support_input))
                            @foreach($list_support_input as $combo)
                                <div class="col-md-4 col-12">
                                    <form action="{{ route('user_advise_submit') }}" method="post">
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
                                            <input type="hidden" name="user_id" value="{{ $user_advise->id }}">

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

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="messgae_modal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content text-center">
                {{--<div class="modal-header">--}}
                {{--<h5 class="modal-title" id="exampleModalLabel">Đăng ký cần hỗ trợ</h5>--}}
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                {{--<span aria-hidden="true">&times;</span>--}}
                {{--</button>--}}
                {{--</div>--}}
                <div class="modal-body">
                    <div class="body_header">
                        <a href="/">
                            <img class="lazy" src="{{ isset($information['logo']) ?  $information['logo'] : '' }}" alt="" width="100%">
                            {{--<img class="lazy" src="https://sanketoan.vn/public/library/images/home_new/Logo.png" alt="" width="100%">--}}
                        </a>
                    </div>
                    <div class="body_content">
                        <a data-toggle="modal" title="Đăng nhập" data-target="#loginTiva" class="text_body_message" id="text_body_message">Bạn cần đăng nhập để sử dụng dịch vụ này</a>
                    </div>
                    <div class="body_footer">
                        <a data-toggle="modal" title="Đăng nhập" data-target="#loginTiva">Đăng nhập</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Để sau</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('show_js')
    <script>
        @if(session('mesage_modal_advise'))
        $('#messgae_modal').modal('show');
        $('.text_body_message').html('{!! session('mesage_modal_advise') !!}');
        @endif
    </script>
    @if(!empty($errors->all()))
        <script>
            $('#res_advise').modal('show');
        </script>
    @endif
@endsection
