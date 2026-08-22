@extends('site.layout.site')
@section('title', ' Danh sách khóa học của bạn')
@section('content')

    <section class="content" style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline bg-white">

                    <div class="title">
                        <h5 class="lt-f18 textUpper fw7 bdLeftBlueN5x pdl10 blueN mgb0 mgTop30">
                            DANH SÁCH KHÓA HỌC
                        </h5>
                    </div>
                    <div class="mgt15 mgb15">
                        @if(!empty(session('suscess')))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {!! $value = session('suscess') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(!empty(session('erorr')))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $value = session('erorr') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    {{--list_course--}}
                    <div class="">
                        <a href="{{ route('course.create') }}" class="btnOrange mgb15 dsInline mgt15">Thêm mới khóa
                            học</a>
                    </div>

                    <div class="clearfix"></div>


                    <div class="">
                        <table id="jobfb" class="table table-hover table-bordered">
                            <thead>
                            <tr>

                                <th>Mã khóa học</th>
                                <th>Tên khóa học</th>
                                <th>Ảnh khóa học</th>
                                <th>Giá khóa học</th>
                                <th>Thời gian khóa học</th>
                                <th>Ngày tạo</th>

                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_course as $course)
                                <tr>
                                    <td>
                                        <span class="btnGreen btn-small">{{ isset($course['course_code']) ? $course['course_code'] : '' }}</span>
                                    </td>
                                    <td>
                                        {{ isset($course['course_name']) ? $course['course_name'] : '' }}
                                    </td>
                                    <td>
                                        <img class="lazy" data-src="{{ isset($course['course_image']) ? $course['course_image'] : '' }}"
                                             width="50px">
                                    </td>
                                    <td>
                                        {{ isset($course['course_price']) ? number_format($course['course_price']) : '' }}
                                        đ
                                    </td>
                                    <td>
                                        {{ isset($course['course_time']) ? $course['course_time'] : '' }}
                                    </td>
                                    <td>
                                        <?php
                                        $date = date_create($course['created_at']);
                                        echo date_format($date, "d/m/Y");
                                        ?></td>
                                    <td>
                                        <div class="EditDelete">
                                            <button>
                                                <a href="{{ route('course.edit',['course_id'=>$course['course_id']]) }}"
                                                   title="Sửa"><i class="far fa-edit clorange"></i></a></button>
                                            <button>
                                                <a href="{{ route('course.destroy',['course_id'=>$course['course_id']]) }}"
                                                   title="Xóa" data-toggle="modal" data-target="#myModalDelete"
                                                   onclick="return submitDelete(this);"><i
                                                            class="fas fa-trash-alt clorange"></i></a></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>

                        </table>

                    </div>
                    <div class="linkPage">
                        <nav aria-label="Page navigation example" class="text-right">
                            {{ $list_course->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('site.exam_admin_site.delete')
    <script>
        $('#changeCategory').change(function () {
            $('#submitFormSearchRoom').submit();
        });
    </script>
@endsection



