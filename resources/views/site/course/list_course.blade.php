@extends('site.layout.site')

<?php
    $slug = '/khoa-hoc/danh-sach-khoa-hoc';
    $config_meta = \App\Entity\Config_meta::getslug($slug);
    $link_url =  \App\Ultility\Ultility::getUrl();

    echo '<pre>';
    print_R($config_meta);die;
?>
{{--@section('type_meta', 'website')--}}
@section('title',!empty($config_meta->meta_title) ? $config_meta->meta_title : 'Đào tạo về du lịch')
@section('meta_description',!empty($config_meta->meta_description) ? $config_meta->meta_description : 'Đào tạo về du lịch')
@section('keywords', !empty($config_meta->meta_keywords) ? $config_meta->meta_keywords :'Đào tạo về du lịch')
@section('meta_image', !empty($config_meta->image) ?  asset($config_meta->image) : $information['logo'] )
@section('meta_url', $link_url)
@section('content')


    <section class="teacher" style='background: url("{{ asset('assets/image/bgr.jpg') }}") no-repeat;'>
        <div class="bannerTeacher white">
            <div class="bgread">
                <div class="name pdl40 pdt15">
                    <p class="fw7 mgb0">
                        Đào tạo khóa học
                    </p>
                    <p class="mgb0"><span>Trang chủ /  Đào tạo khóa học</span></p>
                </div>
            </div>
        </div> <!-- bannerTeacher white -->

        <div class="contentTeacher bgrGray pdt20 pdb20">
            <div class="infoTeacher mgl40 mgr40">
                <div class="row">
                    <div class="col-xl-9 col-lg-9 infomartionTeacher">
                        {{--//bo loc--}}
                        @include('site.filter.filter_teacher')

                        <div class="classOfTeacher">
                            <div class="Class">
                                <div class="title bgrBlueN pdt15 pdb15 pdl10 radiusTopLeft5 radiusTopRight5">
                                    <p class="white fw7 textUpper mgb0">DANH SÁCH KHóa học</p>
                                </div>
                                <div class="listTeachers bgrWhite pdl20 pdr20 pdb5">
                                    <div class="row pdt20">
                                        @if(!empty($list_course))
                                            @foreach($list_course as $course)
                                                <div class="col-lg-3 mgb20">
                                                    @include('site.course.item_course')
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="linkPage">
                                        <nav aria-label="Page navigation example" class="text-right">
                                            {{ $list_course->links() }}
                                        </nav>
                                    </div>


                                </div>

                                <!-- Class -->
                            </div>
                            <!-- classOfTeacher -->
                        </div>
                        <!-- col-lg-8 infomartionTeacher -->
                    </div>
                    {{--//sidebar khóa hoc--}}
                    @include('site.sidebar.sidebar_teacher');
                    <!-- row -->
                </div>
                <!-- infoTeacher -->
            </div>
            <!-- contentTeacher -->
        </div>
    </section>
@endsection

