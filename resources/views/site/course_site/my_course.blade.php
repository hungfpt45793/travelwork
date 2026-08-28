@extends('site.layout_site.site')

{{--@section('type_meta', 'website')--}}
@section('title','Danh sách giáo viên dạy về du lịch')
@section('meta_description','Danh sách giáo viên tại travelwork.vn')
@section('keywords','Danh sách giáo viên dạy về du lịch')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" href="/assets/css/course/teacher.css"/>
    <link rel="stylesheet" href="/assets/css/course/course.css"/>
@endsection
@section('content')



    <section class="my_course_list my-5">

        <div id="" class="course_list_course container container_w_1200">
            <div class="row mx-auto ">
                <div class="col-12  col-md-6 col-lg-3 my-3 d-flex flex-column justify-content-center ">
                    <h1>Khóa học đã đăng ký</h1>
                    <p class="text-secondary">
                        Hoàn thành khóa học để nhận chứng chỉ tại travelwork.vn
                    </p>
                </div>

                @foreach($courses as $cou)
                    @include('site.course_site.item_course_own')
                @endforeach


            </div>
        </div>

        <div id="" class="course_list_course container container_w_1200" style="margin-top:4rem">
            <h1 class="ml-3 mb-4">Khóa học mới xuất bản</h1>
            <div class="row mx-auto ">
                @foreach(\App\Course\Courses::getCourse_category_slug('tat-ca-khoa-hoc',4) as $cou)
                    @include('site.course_site.item_course',['course' =>$cou])
                @endforeach
            </div>
        </div>

    </section>


@endsection

@section('show_js')
    <script>


    </script>
@endsection

