@extends('site.layout.site')
@section('title', 'Danh sách từ khóa bài viết' )
@section('meta_description', 'Danh sách từ khóa bài viết' )
@section('keywords',  'Danh sách từ khóa bài viết' )



@section('content')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container">
            <div class="row ">
                {{--@include('site.sidebar.sidebar_job',['sidebar_jobs'=>'sidebar_jobs'])--}}
                <div class="col-xl-12 createProfileOnline">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_type_post') }}" class=" f18 md-f14 mgb0">Danh sách từ khóa bài viết</a>
                            </li>
                        </ul>
                    </div>

                    <div class="List_cateegory_tag">
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge sm-f14">
                                <div class="bodyBox">
                                    <div class="row">
                                        <div class="col-12">
                                            <h1 class="f22 fw6 clhome mgb20">Danh sách từ khóa bài viết</h1>
                                        </div>
                                        <div class="col-12">
                                            <form class="needs-validation" novalidate>
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-3">
                                                        <?php
                                                        $tag_title_get = isset($_GET['tag_title']) ? $_GET['tag_title'] : '';
                                                        ?>
                                                        <input type="text" class="form-control" 
                                                            name="tag_title" id="validationTooltip01" 
                                                            value="{{ $tag_title_get }}" 
                                                            required placeholder="Nhập từ khóa">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if(!empty($category_tag))
                                            @foreach($category_tag as $tag)
                                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 item_tag">
                                                    <a title="{{ isset($tag->tag_title) ? $tag->tag_title : '' }}" 
                                                        target="_blank" 
                                                        href="{{ route('detail_type_post',['tag_slug'=>$tag->tag_slug]) }}" 
                                                        class="text_black cutTitle">
                                                        <i class="fas fa-hashtag mgr5"></i>
                                                        {{ isset($tag->tag_title) ? $tag->tag_title : '' }}                      
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-12">
                                                <p>Đang cập nhật thông tin</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row pagePostSale">
                                        <div class="col-12 text-center">

                                            @include('site.default.item_pani',['page_link' => $category_tag])

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
        @include('site.module_index.hotline')
        </div>
    </section>

@endsection


