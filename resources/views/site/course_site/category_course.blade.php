@extends('site.layout_site.site')

{{--@section('type_meta', 'website')--}}
@section('title','Danh sách giáo viên dạy về du lịch')
@section('meta_description','Danh sách giáo viên tại travelwork.vn')
@section('keywords','Danh sách giáo viên dạy về du lịch')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('show_css')
    {{--//sao danh  gias--}}
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" href="/public/assets/css/course/teacher.css"/>
    <link rel="stylesheet" href="/public/assets/css/course/course.css"/>
@endsection
@section('content')
    <section class="courses ">


        <div id="" class="course_list_course container-fluid container_xl container_xxl">

            <h1 class="text-center display-4 my-5"
                style="font-size:2.5rem">{{ !empty($course_categorise['category_course_title'])?$course_categorise['category_course_title']:'' }}</h1>

            <div class="row  mx-auto">


                @if(empty($courses))
                    <div
                            class="col-12  col-md-6 col-lg-3 my-3 d-flex flex-column justify-content-center ">
                        <h1>Danh mục này hiện chưa có khóa học nào</h1>
                        <p class="text-secondary">Hãy cùng hơn 100,000 học viên lựa chọn khóa học tốt
                            nhất tại
                            Sanketoan.vn
                        </p>
                    </div>
                @else
                    @foreach($courses as $cou)
                        @include('site.course_site.item_course',['course' =>$cou])
                    @endforeach
                @endif
            </div>
        </div>
        @if(!empty($courses))
        <div class="d-flex justify-content-end mt-3">
            {{ $courses->links() }}
        </div>
        @endif
    </section>
@endsection
@section('show_js')
    {{--//saoo danh gia--}}
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection

