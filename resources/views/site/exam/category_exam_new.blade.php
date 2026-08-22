@extends('site.layout_site.site')
<?php
$slug = 'danh-muc/de-thi-thu';
$meta_exam = \App\Entity\Config_meta::getslug($slug);
?>
@section('type_meta', 'website')
@section('title', !empty($meta_exam->meta_title) ? $meta_exam->meta_title :'Tất cả đề thi')
@section('meta_description', !empty($meta_exam->meta_description) ? $meta_exam->meta_description :'Tất cả đề thi')
@section('keywords', !empty($meta_exam->meta_keywords) ? $meta_exam->meta_keywords :'Tất cả đề thi')
@section('meta_image', !empty($meta_exam->image) ? asset($meta_exam->image) : asset($information['logo']) )

@section('show_css')
    <link rel="stylesheet" href="{{ asset('assets/css/style_exam.css') }}">
@endsection

@section('content')

    @include('site.partials.slider_new')
    @include('site.filter_site.filter_category_exam',['active' => 'category_exam_new'] )


    <section class="list_category_exam">
        <div class="container container_w_1200">
            <div class="row">
                @include('site.sidebar.sidebar_exam')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline">
                    <div class="list_box_exam">

                        @if(!empty($exams))
                            @foreach($exams as $exam)
                                {{--<div class="col-lg-6 col-md-6 col-12">--}}
                                @include('site.partials_exam.item_exam_new',['exam' => $exam])
                                {{--</div>--}}
                            @endforeach
                        @endif
                        <div class="col-lg-12 cusPani">
                            <nav aria-label="Page navigation example" class="text-center">

                                @include('site.default.item_pani',['page_link' => $exams])

                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

