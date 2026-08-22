@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', !empty($edu_categories->edu_cate_title) ? $edu_categories->edu_cate_title : '')
@section('meta_description', isset($edu_categories['edu_cate_des']) ? $edu_categories['edu_cate_des'] : '' )
@section('keywords', isset($edu_categories['edu_cate_title']) ? $edu_categories['edu_cate_title'] : '')
@section('meta_image', ''  )

@section('content')
    <section class="content pdt20 bgrGray">
        <section class="container">
            <div class="link bgrWhite md-mgt20">
                <ul class="nav">
                    <li class="nav-item pd8">
                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>
                    <li class="nav-item pd8">
                        <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                    </li>
                    <li class="nav-item pd8">
                        <a href="{{ route('list_edu_categories') }}" class=" f18 md-f14 mgb0"><h1 class="f16"
                                                                                                  style="margin-bottom: 3px;">
                                Đào tạo du lịch</h1></a>
                    </li>
                    <li class="nav-item pd8 mbds_none_770">
                        <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                    </li>
                    <li class="nav-item pd8 mbds_none_770">
                        <a href="{{ route('edu_categories',['slug'=>$edu_categories->edu_cate_slug]) }}"
                           class=" f18 md-f14 mgb0"><h1 class="f16"
                                                        style="margin-bottom: 3px;">{{ isset($edu_categories->edu_cate_title) ? $edu_categories->edu_cate_title : '' }}</h1>
                        </a>
                    </li>
                </ul>
            </div>
        </section>
        <section class="content pdt20 bgrGray">
            <div class="container">
                <div class="bgrWhite pdl15 pdr15">
                    <div class="row" style="padding-bottom: 30px">
                        <div class="col-12">
                            <h1 class="white fw7 mgb0 f24"
                                style="color: #009385;padding: 15px 0">{{ isset($edu_categories->edu_cate_title) ? $edu_categories->edu_cate_title : '' }}</h1>
                        </div>

                        <div class="col-md-12">
                            <div class="content_edu_categories">
                                {!! isset($edu_categories->edu_cate_content) ?  $edu_categories->edu_cate_content : ''  !!}
                            </div>
                        </div>
                        @foreach($list_edu_class as $cate_class)
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 pd0">
                                @include('site.educate.item_categories')
                            </div>
                        @endforeach


                    </div>
                    <div class="row">
                        <div class="col-12 pull-right text-right">
                            <nav aria-label="Page navigation example">

                                {{ $list_edu_class->links() }}

                            </nav>
                        </div>
                    </div>


                </div>

            </div>
        </section>
    </section>

    @include('site.module_index.hotline')
@endsection

