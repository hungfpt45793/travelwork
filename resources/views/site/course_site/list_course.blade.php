@extends('site.layout_site.site')
<?php
$slug = '/khoa-hoc/danh-sach-khoa-hoc';
$config_meta = \App\Entity\Config_meta::getslug($slug);
?>
@section('title',!empty($config_meta->meta_title) ? $config_meta->meta_title : 'Danh sách giáo viên dạy về du lịch')
@section('meta_description',!empty($config_meta->meta_description) ? $config_meta->meta_description : 'Danh sách giáo viên tại travelwork.vn')
@section('keywords', !empty($config_meta->meta_keywords) ? $config_meta->meta_keywords :'Danh sách giáo viên dạy về du lịch')
@section('meta_image', !empty($config_meta->image) ?  asset($config_meta->image) : $information['logo'] )
@section('show_css')
    {{--//sao danh  gias--}}
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" href="/assets/css/course/teacher.css"/>
    <link rel="stylesheet" href="/assets/css/course/course.css"/>
@endsection
@section('content')
    <section class="courses ">
        @include('site.partials_site.video_course_youtube')
        <div class="course_proof">
            <div class="container container_w_1200">
                <div class="course_proof_slick">
                    @foreach(\App\Entity\SubPost::showSubPost('loi-ich-khi-su-dung-san-ke-toan',4,'asc') as $subpost)
                        <div class="course_proof_slick_item" style="height: fit-content">

                            <img src="{{ \App\Ultility\Ultility::assetUrl(data_get($subpost, 'image'), 'assets/image/course/course_target.png') }}"
                                 alt="{{ isset($subpost['description'])?$subpost['description']:'sanketoan' }}"
                                 class="">
                            <div class="note_proof">
                                <span>{{ isset($subpost['title'])?$subpost['title']:'' }}</span>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="course_categories py-4 container container_xxl">
        </div>
        <div id="" class="course_list_course container-fluid container_xl container_xxl style_tab_course">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                       aria-controls="home" aria-selected="true">Tất cả</a>
                </li>
                @if(!empty($course_categorise))
                    @foreach($course_categorise as $cou_cate)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab"
                               href="#{{$cou_cate['category_course_slug']}}" role="tab" aria-controls="profile"
                               aria-selected="false">{{$cou_cate['category_course_title']}}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
            <div class="tab-content" id="myTabContent">
                @if(!empty($list_course))
                    <?php
                    $id = 0;
                    ?>
                    @foreach($list_course as $cat_slug => $cous)
                        <div class="tab-pane fade show @if($id == 0) active @endif" @if($id == 0) id="home" @else id="{{$cat_slug}}" @endif
                        role="tabpanel" aria-labelledby="home-tab">
                            <?php
                            $id = 1;
                            ?>
                            <div class="row mx-auto ">
                                @if(empty($cous))
                                    <div class="col-12  col-md-6 col-lg-3 my-3 d-flex flex-column justify-content-center ">
                                        <h1>Khóa học</h1>
                                        <p class="text-secondary">Hãy cùng hơn 100,000 học viên lựa chọn khóa học tốt
                                            nhất tại
                                            Travelwork.vn
                                        </p>
                                    </div>
                                @else
                                    @foreach($cous as $cou)
                                        @include('site.course_site.item_course',['course' =>$cou])
                                    @endforeach
                                @endif
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{ route('course_categoryCourse',['category_slug'=>$cat_slug]) }}"
                                   class="mx-auto btn-viewmore cust_link">Xem Thêm</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="course_feedback mt-5 ">
            <div class="course_feedback_background pt-5">
                <h2 class="text-white text-center display-4" style="font-size:2.5rem">Phản Hồi Về Khóa Học</h2>
            </div>
            <div class="course_feedback_content">
                <div class="row mx-auto feedback_list container-fluid container_xl container_xxl">
                    @foreach(\App\Course\Course_feedback::getAllCourseFeedback() as $feedback)
                        @include('site.course_site.item_course_feedback')
                    @endforeach

                </div>
            </div>
        </div>
    </section>
    @include('site.course_site.item_list_teacher')
@endsection
@section('show_js')
    {{--//saoo danh gia--}}
    <script>
        $(document).ready(function () {
            $('.courses_cate_slick').slick({
                slidesToShow: 8,
                slidesToScroll: 1,
                autoplaySpeed: 2000,
                arrows: false,
                infinite: false,
                responsive: [
                    {
                        breakpoint: 800,
                        settings: {
                            slidesToShow: 5
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 3
                        }
                    }
                ]

            });

            $('.course_proof_slick').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: false,
                centerMode: true,
                responsive: [
                    {
                        breakpoint: 800,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]

            });


            $('.feedback_list').slick({
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: true,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 900,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }

                ]
            });

            $('.slick-track').css('min-width', '1400px');

            $('.slick-prev').html('<i class="fas fa-chevron-left"></i>');
            $('.slick-next').html('<i class="fas fa-chevron-right"></i>');
        });
        $('.content_modal_noti_adv').remove();
        $('.anotheTeacher #dismiss').remove();
    </script>
@endsection
