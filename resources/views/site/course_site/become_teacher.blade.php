@extends('site.layout_site.site')

{{--@section('type_meta', 'website')--}}
@section('title','Danh sách giáo viên dạy kế toán')
@section('meta_description','Danh sách giáo viên tại sanketoan.vn')
@section('keywords','Danh sách giáo viên dạy kế toán')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" href="/assets/css/course/teacher.css"/>
    <link rel="stylesheet" href="/assets/css/course/course.css"/>
@endsection
@section('content')


    <section class="bc_teacher ourses">
        <div class="banner" style="
            background:url({{asset('assets/image/course/background_city.jpg')}});
            background-size:cover;
            background-position:center;
            background-repeat: no-repeat;">
            <div class="banner_content text-center text-white ">
                <h1 class="mb-4">Hợp tác giảng dạy cùng Sanketoan</h1>
                <p class="mb-1">‘A teacher is one who makes himself progressively unnecessary.’</p>
                <p>–Thomas Carruthers–</p>
                <a href="{{ route('teacher_register') }}" title="Đăng kí giáo viên" class="btn btn-lg btn-danger text-uppercase cust_button">
                    Đăng ký ngay
                </a>
            </div>
        </div>

        <div class="video text-center container">
            <div class='video_top '>Bạn sẽ nhận được gì khi trở thành giáo viên tại sàn kế toán</div>
            <div class="video_body">
                <iframe width="100%" height="100%"
                        src="{{ isset($information['video-tro-thanh-giao-vien']) ?$information['video-tro-thanh-giao-vien']: 'https://www.youtube.com/embed/lJUxd6_4yKc' }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            </div>
        </div>
        <div class="about_us text-center ">
            <div class="container">

                {!! isset($information['mo-ta-website-trong-tro-thanh-giao-vien'])?$information['mo-ta-website-trong-tro-thanh-giao-vien']:'' !!}
                <div class="row mt-5">
                    @foreach(\App\Entity\SubPost::showSubPost('gioi-thieu-ve-san-ke-toan') as $subpost)
                        <div class="col-12 col-md-4 my-3">
                            <img style="width: 100%;" src="{{ \App\Ultility\Ultility::assetUrl(data_get($subpost, 'image'), 'assets/image/course/course_target.png') }}"/>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="why_choose_us">
            <div class="container text-center">
                <h4>Lý do nên chọn giảng dạy trên Sàn Kế Toán
                </h4>

                <div class="row mt-3">
                    @foreach(\App\Entity\SubPost::showSubPost('ly-do-nen-chon-san-ke-toan',4,'asc') as $subpost)
                        <div class="col-6 col-md-3 my-3 text-center">
                            <img src="{{ \App\Ultility\Ultility::assetUrl(data_get($subpost, 'image'), 'assets/image/course/course_target.png') }}"
                                 alt="{{ isset($subpost['description'])?$subpost['description']:'sanketoan' }}"
                                 style="width: 200px;height: 200px;"/>
                            {!! isset($subpost['content'])?$subpost['content']:'' !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="top_teacher mt-3">
            <div class="container text-center">
                <h4>Top giáo viên tại Sàn Kế Toán
                </h4>


                <div class="row mt-5">
                    <?php
                    $list_teacher = \App\Entity\Teacher::get_teacher_course(8)
                    ?>
                    @if(!empty($list_teacher))
                        @foreach($list_teacher as $tea)
                            <div class="col-6 col-md-4 col-lg-3 teacher_info">
                                <img class="rounded-pill"
                                     src="{{ !empty($tea->teacher_images) ? $tea->teacher_images : asset('assets/image/avatarteacher.png') }}"
                                     alt="{{ $tea->teacher_name }}" title="{{ $tea->teacher_name }}">
                                <div>

                                    <p class="teacher_name"><a class=" f16" style="color:inherit;text-decoration: none;" href="{{ route('detailTeacher',['slug'=>$tea->slug]) }}"
                                                                    title="{{ $tea->teacher_name }}">{{ $tea->teacher_name }}  </a></p>

                                </div>
                            </div>
                        @endforeach
                    @endif


                </div>
            </div>
        </div>
    </section>


@endsection

@section('show_js')
    <script>

    </script>
@endsection
