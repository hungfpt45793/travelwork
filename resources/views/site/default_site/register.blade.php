@extends('site.layout_site.site')

@section('title','Đăng ký')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

<link rel="stylesheet" type="text/css" href="/public/assets/web/css/register.css"/>

@section('content')
    <section class="content bg_content_regedit">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline mgt15 ">
                    <div class="link_breakcrum">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <?php
                                $link_url = '#';
                                $link_url = \App\Ultility\Ultility::getUrl();
                                ?>
                                <a href="{{ $link_url }}" class=""> <i class="fas fa-users mgr5"></i>Đăng ký tài
                                    khoản</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 mgt20 ">
                    <div class="main resgister_select mgb20">
                        <div class="notificationBox box_resgister">
                            <h1 class="">
                                Đăng ký tài khoản
                            </h1>
                            <hr>
                            <div class="row">
                                <?php
                                $list_regedit = \App\Entity\SubPost::showSubPostOrderBY('asc', 'banner-dang-ky', $count = 2);
                                ?>
                                @foreach($list_regedit as $id_red=>$res)

                                        <a @if($id_red == 0)
                                           href="{{route('employee_register')}}"
                                           @else
                                           href="{{route('employer_register')}}"
                                           @endif
                                           title="{{ !empty($res->title) ? $res->title : '' }}">
                                    <div class="col-md-6 col-12">
                                        <div class="resgedit">
                                            <div class="res_img">
                                                <img src="{{ !empty($res->image) ? asset($res->image) : '' }}"
                                                     title="{{ !empty($res->title) ? $res->title : '' }}">
                                            </div>
                                            <div class="res_content">
                                                {!! !empty($res->content) ? $res->content : '' !!}
                                            </div>
                                            <div class="res_button text-center">
                                                <a @if($id_red == 0) class="btn_employee_res"
                                                   href="{{route('employee_register')}}"
                                                   @else class="btn_employer_res"
                                                   href="{{route('employer_register')}}"
                                                   @endif title="{{ !empty($res->title) ? $res->title : '' }}">{{ !empty($res->title) ? $res->title : '' }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    </a>


                                @endforeach
                            </div>


                            <hr>
                        </div>
                    </div>
                    @include('site.module_index_site.dang-ky-tu-van')

                    <section class="Support bgrWhite pd40 mgt30 mgb30">
                        <div class="notificationBox formJobLarge mt30" style="background: #f6eecc">
                            <div class="">
                                <p
                                        class="text-center f23 clHome fw6">
                                    TỔNG ĐÀI TƯ VẤN <span class="sm-block">CHĂM SÓC KHÁCH HÀNG</span></p>
                            </div>
                            <div class="row">
                                @foreach(\App\Entity\SubPost::showSubPost('hotline', 3) as $id => $hotline)
                                    <div class="col-lg-4 col-md-4 text-center">
                                        <span class="f20 ">{{$hotline->title}}:</span> <span class="clRed fw7 fw6 f30">&nbsp;{{$hotline->description}}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection
