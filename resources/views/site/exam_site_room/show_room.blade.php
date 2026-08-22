@extends('site.layout.site')

<?php
$slug = 'danh-sach-phong-thi';
$meta_exam= \App\Entity\Config_meta::getslug($slug);
?>
@section('type_meta', 'website')
@section('title', !empty($meta_exam->meta_title) ? $meta_exam->meta_title :'Danh sách phòng thi')
@section('meta_description', !empty($meta_exam->meta_description) ? $meta_exam->meta_description :'Danh sách phòng thi')
@section('keywords', !empty($meta_exam->meta_keywords) ? $meta_exam->meta_keywords :'Danh sách phòng thi')
@section('meta_image', !empty($meta_exam->image) ? asset($meta_exam->image) : asset($information['logo']) )
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

                    <div class="subsctibe text-center">
                        <h3 class="f20">Đăng kí email nhận thông tin mới nhất về phòng thi</h3>
                        <form id="searchBox" action="{{ route('addEmail') }}" method="post" class="w75">
                            {{ csrf_field() }}
                            <div class="content">

                                <div class="searchInput bdLightGray noBorderTopIm" style="border: none">
                                    <div class="row mg0">
                                        <div class="col-lg-9 pd0" style="border-left: 0px solid #ccc;
    border-radius: 0;">
                                            <input class="w100" type="email" name="email" placeholder="Đăng kí nhận email..." style="height:35px;border: 1px solid #ccc;padding: 0 10px;"  required>
                                            <input class="w100" type="hidden" name="slug_gruop" placeholder="Đăng kí nhận email..." value="dang-ki-phong-thi">
                                        </div>
                                        <button class="col-lg-3" type="submit" style="background: orange;color: #fff;height: 35px;border: none;">Đăng kí
                                        </button>
                                    </div>
                                </div>



                            </div>
                        </form>
                    </div>

                    @include('site.filter.filter_room')

                    <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14 mgt30">
                        Danh sách phòng thi do giảng viên trường Đại Học tạo
                    </div>
                    <div class="categoryQuestion">
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge sm-f14">
                                <div class="bodyBox ">
                                    <div class="row ListRoom">


                                        @if(!empty($list_teacher_school))
                                            @foreach($list_teacher_school as $teacher_room)
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    @include('site.partials_exam.item_teacher_room')
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

                    <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14 ">
                        Danh sách phòng thi chưa thi
                    </div>
                    <div class="categoryQuestion">
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge sm-f14">
                                <div class="bodyBox ">
                                    <div class="row ListRoom">


                                            @if(!empty($listroom))
                                                @foreach($listroom as $room)
                                                    <div class="col-lg-6 col-md-6 col-12">
                                                    @include('site.partials_exam.item_room')
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>Chưa có phòng thi nào được tạo !</p>
                                            @endif


                                        <div class="col-lg-12">
                                            <nav aria-label="Page navigation example" class="text-center">
                                            {{ $listroom->links() }}
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






    @if(\Illuminate\Support\Facades\Auth::check())
        @foreach($listroom as $room)
        <div class="modal fade" id="room{{ $room->id_room }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('submitRoomPassword') }}" method="POST">
                        {!! csrf_field() !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nhập mật khẩu cho phòng thi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <div class="form-group">
                           @if(session('erorrRoomPassword'))
                               <p style="color: red;margin-bottom: 0">{{ session('erorrRoomPassword') }} </p>
                           @endif
                           <label for="recipient-name" class="col-form-label">Mật khẩu phòng thi</label>
                           <input type="password" class="form-control" name="password_room" placeholder="Nhập mật khẩu ...">
                           <input type="hidden"  name="id_room" value="{{ $room->id_room }}">
                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Vào thi luôn</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endif


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

