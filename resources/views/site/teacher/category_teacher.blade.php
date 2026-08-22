@extends('site.layout.site')
<?php
$meta_exam = \App\Entity\Config_meta::getslug('giao-vien/danh-sach-giao-vien');
?>
@section('type_meta', 'website')
@section('title', !empty($meta_exam->meta_title) ? $meta_exam->meta_title :'Danh sách giáo viên')
@section('meta_description', !empty($meta_exam->meta_description) ? $meta_exam->meta_description :'Danh sách giáo viên')
@section('keywords', !empty($meta_exam->meta_keywords) ? $meta_exam->meta_keywords :'Danh sách giáo viên')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : ''  )

@section('content')


    <section class="teacher" style='background: url("{{ asset('assets/image/bgr.jpg') }}") no-repeat;'>
        <div class="bannerTeacher white">
            <div class="bgread">
                <div class="name pdl40 pdt15">
                    <p class="fw7 mgb0">
                        Danh sách giáo viên
                    </p>
                    <p class="mgb0"><span>Trang chủ /  Danh sách giáo viên</span></p>
                </div>
            </div>
        </div> <!-- bannerTeacher white -->


        <div class="row">
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
                            <?php
                            $link_url ='#';
                            $link_url = \App\Ultility\Ultility::getUrl();
                            ?>
                            <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN">Danh sách giáo viên</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        
        <div class="contentTeacher bgrGray pdt20 pdb20">
            <div class="infoTeacher container-fluid">
                <div class="row">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <?php $user = \Illuminate\Support\Facades\Auth::user(); ?>
                            @include('site.sidebar.sidebar_teacher',['user'=>$user])
                    @endif

                    <div class="col-xl-9 col-lg-8 infomartionTeacher">
                        {{--//bo loc--}}
                        @include('site.filter.filter_teacher')
                        <div class="classOfTeacher">
                            <div class="Class">
                                <div class="title bgrBlueN pdt15 pdb15 pdl10 radiusTopLeft5 radiusTopRight5 text-center">
                                    <p class="white fw7 textUpper mgb0">DANH SÁCH giáo viên</p>
                                </div>
                                <div class="listTeachers bgrWhite pdl20 pdr20 pdb5">
                                    <div class="row" style="border-top: 1px solid #ccc;
    border-left: 1px solid #ccc;">
                                        @if(!empty($list_teacher))
                                            @foreach($list_teacher as $tea)
                                                <div class="col-xl-3 col-lg-3 pd0 bdBottomGray bdRightGray hvbgrClick">
                                                    @include('site.teacher.item_teacher')
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="linkPage">
                                        <nav aria-label="Page navigation example" class="text-right">
                                            {{ $list_teacher->links() }}
                                        </nav>
                                    </div>


                                </div>

                                <!-- Class -->
                            </div>
                            <!-- classOfTeacher -->
                        </div>
                        <!-- col-lg-8 infomartionTeacher -->
                    </div>
                    {{--//sidebar khóa hoc--}}

                    @if(!\Illuminate\Support\Facades\Auth::check())
                        @include('site.sidebar.sidebar_teacher');
                        @endif


                    <!-- row -->
                </div>
                <!-- infoTeacher -->
            </div>
            <!-- contentTeacher -->
        </div>
    </section>
@endsection

