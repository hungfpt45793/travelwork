@extends('site.layout.site')

<?php
$meta_exam = \App\Entity\Config_meta::getslug('danh-sach-phong-thi');
?>
@section('type_meta', 'website')
@section('title', !empty($meta_exam->meta_title) ? $meta_exam->meta_title :'Danh sách phòng thi')
@section('meta_description', !empty($meta_exam->meta_description) ? $meta_exam->meta_description :'Danh sách phòng thi')
@section('keywords', !empty($meta_exam->meta_keywords) ? $meta_exam->meta_keywords :'Danh sách phòng thi')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )
@section('content')


    <style>
        .linkListRoom
        {
            display: inline-block;
            vertical-align: middle;
            -webkit-transform: perspective(1px) translateZ(0);
            transform: perspective(1px) translateZ(0);
            box-shadow: 0 0 1px transparent;
            position: relative;
            overflow: hidden;
        }
        .menuHeader nav ul li .linkListRoom:before {
            content: "";
            position: absolute;
            z-index: -1;
            left: 0;
            right: 0;
            top: 0;
            background: #fff;
            height: 2px;
        }

    </style>
    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline" style="margin-top:0px">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8 mgt7">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Danh sách phòng thi</a>
                            </li>
                        </ul>
                    </div>





                    <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14 mgt30">
                        Danh sách phòng thi do giảng viên '{{ $teacher->teacher_sc_name }}' tạo
                    </div>
                    <div class="categoryQuestion">
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge sm-f14">
                                <div class="bodyBox ">
                                    <div class="row ListRoom">


                                        @if(!empty($list_teacher_school))
                                            @foreach($list_teacher_school as $teacher_room)
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    @include('site.partials_exam.item_student_room')
                                                </div>
                                            @endforeach
                                        @else
                                            <p>Chưa có phòng thi nào được tạo !</p>
                                        @endif


                                        <div class="col-lg-12">
                                            <nav aria-label="Page navigation example" class="text-center">
                                                {{ $list_teacher_school->links() }}
                                            </nav>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                    @include('site.module_index.dang-ky-tu-van')
                </div>
            </div>
        </div>
    </section>
    @include('site.module_index.hotline')








    @if(session('errorRoom'))
        <script>
            var errorExam = '{{ session('errorRoom') }}';
            alert(errorExam);
        </script>
    @endif
    @if(session('error_id_room'))
        <script>
            var id = '';
            id = {{ session('error_id_room') }};
            $('#'+id +'').modal('show');
        </script>
    @else
    @endif



@endsection

