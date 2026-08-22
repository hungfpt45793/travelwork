@extends('site.layout.site')


<?php
$title = '';
if(!empty($_GET['p']) or !empty($_GET['q']))
{
    if (!empty($_GET['p'])) {
        $province = \App\Entity\Province::getId($_GET['p']);
        $title .= ' tại '.$province->province_name .'  ';
    }
    if (!empty($_GET['q'])) {
        $district = \App\Entity\District::getId($_GET['q']);
        $title .= $district->district_name;
    }
}
else
{
    if (!empty($_GET['t'])) {
        $type_of_business = \App\Entity\TypeOfBusiness::getIdTypeBusiness($_GET['t']);
        $title .= ' cho ' . $type_of_business->type_of_business_name .' , ';
    }
    if (!empty($_GET['b'])) {
        $business = \App\Entity\Business::getId($_GET['b']);
        $title .= $business['title'];
    }
}
$title = ucwords($title);
?>

<?php
$meta_exam = \App\Entity\Config_meta::getslug('tuyen-thuc-tap-ke-toan/danh-sach-cong-ty');
?>

@section('title', 'Tuyển thực tập về du lịch'.$title)
@section('meta_description', !empty($meta_exam->meta_description) ? $meta_exam->meta_description.$title : 'Thực tập về du lịch')
@section('keywords', !empty($meta_exam->meta_keywords) ? $meta_exam->meta_keywords :'Thực tập về du lịch')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')




@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                <div class="col-xl-9 col-lg-9 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20">
                        <ul class="nav">

                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <?php
                                $link_url ='#';
                                $link_url = \App\Ultility\Ultility::getUrl();
                                ?>
                                <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> <i class="fas fa-link white mgr5"></i> Tìm kiếm</a>
                            </li>
                        </ul>
                    </div>
                    @include('site.filter.filter_intership')
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14 text-center">
                            <h1 class="f18 mgb0 fw7">Danh sách các công ty nhận thực tập về du lịch</h1>
                            {{--( {{ isset($total) ? $total : '0'  }} việc làm)--}}
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @foreach ($employers as $employer)
                                    @include('site.employer.item_employer')
                                @endforeach
                            </div>
                        </div>
                    </section>


                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="row">
                            <div class="col-12 text-center">
                                {{ $employers->links() }}
                            </div>
                        </div>
                    </section>
                    <section class="tabfillter bgrWhite mgt20 mgb20 mbdsNone">
                        <div class="row">

                            <div class="col-lg-12">
                                <ul class="nav nav-tabs mbdsNone" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Thực tập theo loại hình doanh nghiệp</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Thực tập theo tỉnh thành</a>
                                    </li>



                                </ul>
                                <ul class="nav nav-tabs dsNone mbdsBlock" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Doanh nghiệp</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Tỉnh thành</a>
                                    </li>



                                </ul>
                                <div class="tab-content pd20" id="myTabContent">

                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                        <div class="row">
                                            <?php
                                            $type_of_business_get = !empty($_GET['t']) ? $_GET['t'] : 0;
                                            $listtype = \App\Entity\TypeOfBusiness::getAllTypeBusiness();
                                            ?>
                                            @foreach($listtype as $type)
                                                {{--<option value="{{ $type->type_of_business_slug }}"--}}
                                                {{--@if($type_of_business_id_get == $type->type_of_business_id) selected @endif--}}
                                                {{-->{{ $type->type_of_business_name }}</option>--}}

                                                <div class="col-lg-4 col-md-6 col-6">


                                                    <?php
                                                    $text = 'tuyen-thuc-tap-ke-toan-cho-'.$type->type_of_business_slug.'?&t='.$type->type_of_business_id;

                                                    $total_type_of_business_id = 0;
                                                    $total_type_of_business_id = \App\Entity\Employer::getTotalEmployerTypeBusiness($type->type_of_business_id);
                                                    ?>

                                                    <a class="linkFillter @if($type_of_business_get == $type->type_of_business_id) active_get @endif" href="{{ route('search_intership',['slug'=> $text]) }}"> <p class=" mgb10"><i class="far fa-building f14 mgr5"></i>{{ $type->type_of_business_name }} ({{ $total_type_of_business_id }})</p>
                                                    </a>
                                                </div>

                                            @endforeach
                                        </div>

                                    </div>
                                    <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="remoreBusiness">
                                            <div class="row">
                                                <?php
                                                $province_get = !empty($_GET['p']) ? $_GET['p'] : 0;
                                                $getAllProvince = \App\Entity\Province::GetAllProvinces();
                                                ?>
                                                @foreach($getAllProvince as $province)
                                                    {{--<option @if($province->province_id == $province_get) selected--}}
                                                    {{--@endif value="{{$province->province_slug}}">{{$province->province_name}}</option>--}}

                                                    {{--<option value="{{ $type->type_of_business_slug }}"--}}
                                                    {{--@if($type_of_business_id_get == $type->type_of_business_id) selected @endif--}}
                                                    {{-->{{ $type->type_of_business_name }}</option>--}}

                                                    <div class="col-lg-3 col-md-4 col-6">
                                                        <?php
                                                        $text_province = 'tuyen-thuc-tap-ke-toan-tai-'.$province->province_slug.'?&p='.$province->province_id;

                                                        $total_province = 0;
                                                        $total_province = \App\Entity\Employer::getTotalEmployerProvince($province->province_id);
                                                        ?>
                                                        <a class="linkFillter @if($province_get == $province->province_id) active_get @endif" href="{{ route('search_intership',['slug'=> $text_province]) }}">
                                                            <p class=" mgb10"><i class="fas fa-map-marker-alt f14 mgr5"></i>{{$province->province_name}} ({{ $total_province }})</p>
                                                        </a>
                                                    </div>

                                                @endforeach


                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>

                    </section>

                    @include('site.module_index.dang-ky-tu-van')

                </div>


                {{--//sidebar_intership--}}
                @include('site.sidebar.sidebar_intership')

            </div>

        </div>
    </section>

    <section class="recruitmentNewsHandbook pd15 pdt20 pdb0 bgrGray ">
        <div class="container-fluid bg-white pdt20 pdb20">
            <div class="row ">


                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="title">
                        <?php  $public_link = \App\Entity\Category::getDetailCategory('thuc-tap-ke-toan');
                        ?>
                        <h2 class="textUpper text-center fw7 f22 xl-f22 lg-f22 red mgb20">Tin thực tập về du lịch</h2>
                    </div>
                    <div class="slideNews">
                        @foreach(\App\Entity\Post::categoryShow('thuc-tap-ke-toan',15) as $post)
                            <div class="News pd20">
                                <div class="CropImg">
                                    <a href="{{ route('detail_new_intership', ['cate_slug_intership' => 'tin-thuc-tap-ke-toan' , 'post_slug' => $post->slug]) }}" title="{{ isset($post['title']) ? $post['title'] : '' }}"
                                       class="thumbs">
                                        <img class="lazy" src="{{$post->image}}"
                                             alt="{{ isset($post['title']) ? $post['title'] : '' }}" title="{{ isset($post['title']) ? $post['title'] : '' }}"
                                             width="100%">
                                    </a>
                                </div>
                                <div class="info">
                                    <h5>
                                        <a href="{{ route('detail_new_intership', ['cate_slug_intership' => 'tin-thuc-tap-ke-toan' , 'post_slug' => $post->slug]) }}"
                                           class="f18 hvBlueDN blueDN "
                                           title="{{ isset($post['title']) ? $post['title'] : '' }}">{{ isset($post['title']) ? \App\Ultility\Ultility::textLimit($post['title'], 10) : '' }}</a>
                                    </h5>

                                    <p>{{ isset($post['description']) ? \App\Ultility\Ultility::textLimit($post['description'], 25) : '' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script type="text/javascript">
        $('.slideNews').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 450,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });
    </script>

    @include('site.module_index.hotline')



@endsection
