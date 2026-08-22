<?php  $public_link = \App\Entity\Category::getDetailCategory($cate_slug);
?>
@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', !empty($post->meta_title) ? $post->meta_title : $post->title)
@section('meta_description', !empty($post->meta_description) ? $post->meta_description : $post->description) @section('keywords', $post->meta_keyword ) @section('meta_image', asset($post->image) )
@section('meta_url', route('post', ['cate_slug' => $cate_slug, 'post_slug' => $post->slug]) )
@section('meta_image', asset($post->image) ? $post->image : '' )
@section('meta_url', route('post', ['cate_slug' =>  $cate_slug, 'post_slug' => $post->slug]) )
@section('content')
    <section class="teacher" style='background: url("{{ asset('assets/image/bgr.jpg') }}") no-repeat;'>

        <div class="bannerTeacher white">
            <div class="bgread">
                <div class="name pdl40 pdt15">
                    <p class="fw7 mgb0">
                        {{ $post->title }}
                    </p>
                    <p class="mgb0">
                        <span>{{ $public_link->title }} / {{ $post->title }} </span>
                    </p>
                </div>
            </div>
        </div> <!-- bannerTeacher white -->

        <div class="contentTeacher bgrGray pdt20 pdb20">
            <div class="infoTeacher container-fluid">
                <div class="row">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <?php $user = \Illuminate\Support\Facades\Auth::user()?>
                            @include('site.sidebar.sidebar_teacher',['user'=>$user])
                    @endif
                    <div class="col-xl-9 col-lg-8 infomartionTeacher">
                        @include('site.filter.filter_teacher')
                        <div class="bgrWhite radius10">
                            <div class="row">

                            </div>
                            <!-- row -->
                        </div>
                        <div class="contentInfoNews bkwhite pd20 bdLightGray">
                            <h1 class="title fontBold mgb10 blueN f18">{{ isset($post->title) ? $post->title : '' }}</h1>
                            <div class="ContentPost">
                                {!! isset($post->content) ? $post->content : 'Đang cập nhật' !!}
                            </div>

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
