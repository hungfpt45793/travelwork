@extends('site.layout.site')

@section('title', 'Danh sách khóa học')
@section('meta_description', 'Danh sách khóa học')
@section('keywords', 'Danh sách khóa học')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">

                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">

                                <a href="{{ route('post_sale_employee') }}" class="f18 md-f14 blueDN hvBlueDN"> <i
                                            class="fas fa-donate mgr5"></i>Kiếm tiền từ chia sẻ bài</a>
                            </li>
                        </ul>
                    </div>
                    @include('site.employee.item_list_redeem')
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="CV bgrWhite radius5 pd20 mbpd0 mgb20 pdb5">

                                        @include('site.employee.item_total_money')


                                    </div>

                                </div>


                            </div>
                        </div>
                    </section>
                    <section class="categoryPostSale">
                        <div class="container bg-white">
                            <div class="row">
                                <div class="col-lg-12 PostSaleLeft">
                                    <h1 class=" f22 lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb20 mgt20">
                                        Danh sách khóa học chia sẻ kiếm tiền
                                    </h1>
                                    @if(!empty($list_course))
                                        @foreach($list_course as $course)
                                            <div class="row itemPostSale">
                                                <div class="col-lg-3">
                                                    <div class="imagePostSale">
                                                        <a class="z-depth-1"
                                                           href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}"
                                                           title="{{ !empty($course->course_title) ? $course->course_title : '' }}">
                                                            <div class="CropImg CropImg60 CropImgMB60">
                                                                <div class="thumbs">
                                                                    <img class="responsive-img"
                                                                         src="{{ isset($course->course_image) ? asset($course->course_image) : '' }}"
                                                                         alt="{{ !empty($course->course_title) ? $course->course_title : '' }}"
                                                                         title="{{ !empty($course->course_title) ? $course->course_title : '' }}">
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="contentPostSale">
                                                        <a href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}" class=""><h3 class="clorang f20 fw6">{{ !empty($course->course_code) ? $course->course_code : '' }}-{{ !empty($course->course_title) ? $course->course_title : '' }}</h3>
                                                        </a>

                                                        <div class="descriptionPostSale">
                                                            {{ isset($course->course_descript) ? \App\Ultility\Ultility::textLimit($course->course_descript,90) : '' }}
                                                        </div>
                                                        <a href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}" class="link">Xem thêm</a>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="row pagePostSale">
                                        <div class="col-12 text-center">
                                            {{$list_course->links()}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('adminstration/jquery.priceformat.js') }}"></script>
    <script>
        $('.formatPrice').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.'
        });
    </script>
    @include('site.partials.delete')


@endsection