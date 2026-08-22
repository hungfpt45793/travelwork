@extends('site.layout_site.site')
<?php
$title = 'Danh sách đề thi du lịch ';
if (!empty($_GET['t'])) {
    $type_of_business = \App\Entity\TypeOfBusiness::getIdTypeBusiness($_GET['t']);
    $title .= 'cho ' . $type_of_business->type_of_business_name .' ';
}
if (!empty($_GET['c'])) {
    $career = \App\Entity\Career::getIdCareer($_GET['c']);
    $title .= 'với vị trí '. $career['career_category_name'];
}

$title = ucwords($title);
?>
{{--@section('type_meta', 'website')--}}
@section('title', $title)
@section('meta_description','Tổng hợp '. $title.' tại sanketoan.vn')
@section('keywords', $title)
@section('meta_image', !empty($category->image) ?  asset($category->image) : asset($information['logo']) )

@section('show_css')
    <link rel="stylesheet" href="{{ asset('assets/css/style_exam.css') }}">
@endsection

@section('content')

    @include('site.partials.slider_new')
    @include('site.filter_site.filter_category_exam',['active' => 'category_test'] )


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

