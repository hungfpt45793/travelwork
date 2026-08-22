@extends('staff_admin.layouts.master')

@section('title', 'Thêm mới bài viết' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.news_article')
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
                <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                    <div class="contentJobsInteresting pd15 col-f14 ">
                        <form action="{{ route('staff_article.store') }}" method="POST">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <h4>Nội dung bài viết</h4>
                                    <hr>
                                    <div class="form-group">
                                        <label for="title">Tên bài viết</label>
                                        <input type="text" id="title" class="form-control" placeholder="Tên bài viết" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Nội dung</label>
                                        <textarea id="content" class="editor" name="content" cols="80" rows="10">
                                        </textarea>

                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control" placeholder="Đường dẫn tĩnh" name="slug" id="slug">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <textarea id="description" class="form-control" name="description" cols="80" rows="10">
                                        </textarea>
                                    </div>

                                    {{-- từ khóa --}}
                                    @php
                                        foreach ($input_tags as $tag) {
                                            $tag_type = $tag['tag_type'];
                                        }
                                    @endphp
                                    @include('admin.layout.themtukhoa')
                                    {{-- END từ khóa --}}

                                    <div class="form-group">
                                        <label for="tags">Chọn ảnh</label>
                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                           size="20"/>
                                        <img src="" width="80" height="70"/>
                                        <input name="image" type="hidden" value=""/>
                                    </div>
                                    <hr class="hr">
                                    <h4>Hỗ trợ Seo</h4>
                                    <hr>
                                    <div class="form-group">
                                        <label for="meta_title">Thẻ title</label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Thẻ title">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">Thẻ description</label>
                                        <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Thẻ description">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_keyword">Thẻ keyword</label>
                                        <input type="text" class="form-control" id="meta_keyword" name="meta_keyword" placeholder="Thẻ keyword">
                                    </div>
                                    <hr class="hr">
                                    <h4>Chọn danh mục</h4>
                                    <hr>
                                    <div class="style_company" style="column-count: 3">
                                        @foreach($categories as $cate)
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="parents[]" value="{{ $cate->category_id }}" class="flat-red"
                                                       />
                                                {{ $cate->title }}
                                            </label>
                                        </div>
                                        @foreach($cate['sub_children'] as $child)
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" name="parents[]" value="{{ $child['category_id'] }}" class="flat-red"
                                                           @if(in_array($child['category_id'], $categoryPost)) checked @endif/>
                                                    {{ $child['title'] }}
                                                </label>
                                            </div>
                                        @endforeach
                                        @endforeach
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Chọn template</label>
                                            <select class="form-control" name="template">
                                                <option value="default">Mặc định</option>
                                                {{--@foreach($templates as $template)--}}
                                                    {{--<option value="{{ $template->slug }}">{{ $template->title }}</option>--}}
                                                {{--@endforeach--}}
                                            </select>
                                        </div>

                                    </div>
                                    @foreach ($typeInputs as $typeInput)
                                <div class="form-group">
                                    <label>{{ $typeInput->title }}</label>
                                    @if($typeInput->type_input == 'one_line')
                                        <input type="text" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}" />
                                    @endif

                                    @if($typeInput->type_input == 'multi_line')
                                        <textarea rows="4" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}"></textarea>
                                    @endif

                                    @if($typeInput->type_input == 'image')
                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                               size="20"/>
                                        <img src="" width="80" height="70"/>
                                        <input name="{{$typeInput->slug}}" type="hidden" value=""/>
                                    @endif

                                    @if($typeInput->type_input == 'editor')
                                        <textarea class="editor" id="{{$typeInput->slug}}" name="{{$typeInput->slug}}" rows="10" cols="80"/></textarea>
                                    @endif

                                    @if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor'), true) && strpos($typeInput->type_input, 'listMultil') >= 0)
                                        <?php $slugSubPost = str_replace('listMultil', '', $typeInput->type_input);?>
                                        <select name="{{$typeInput->slug}}[]" class="select22 form-control" multiple="multiple">

                                            @foreach(\App\Entity\SubPost::showSubPost($slugSubPost, 100) as $subPost)
                                                <option value="{{ $subPost->slug }}">{{ $subPost->title }}</option>
                                            @endforeach
                                        </select>
                                    @elseif (!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor'), true))
                                        <select name="{{$typeInput->slug}}" class="form-control">
                                            @foreach(\App\Entity\SubPost::showSubPost($typeInput->type_input, 100) as $subPost)
                                                <option value="{{ $subPost->title }}">{{ $subPost->title }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label>Chọn chiến dịch cho ứng viên</label>
                                <select class="form-control select22" name="campain_getfly">
                                    @if ( isset($campaigns['decode']) )
                                        @foreach ($campaigns['decode'] as $campaign)
                                            <option value="{{ $campaign['token_api'].'-'.$campaign['campaign_id'] }}"
                                                    {{ ( old('campain_candidate') == $campaign['token_api']) ? 'selected' : '' }}
                                            >{{ $campaign['campaign_name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                                    <div class="form-group">
                                        <label for="">Đồng bộ form về</label>
                                        <select class="js-example-basic-single form-control" name="form_status">
                                            <option value="1"> Nhà tuyển dụng</option>
                                            <option value="2"> Ứng viên</option>
                                        </select>
                                    </div>
                                    <div class="style_company">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="sale_money" value="1" name="sale_money" checked>
                                                <label class="form-check-label" for="sale_money">
                                                    Chia sẻ bài viết lên facebook (share bài viết kiếm tiền)
                                                        </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="noti_post" value="1" name="noti_post">
                                                <label class="form-check-label" for="noti_post">
                                                    Thông báo trên App
                                                        </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary">Thêm mới</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
                <!-- The Modal -->
            </div>
    </div>
</div>
@endsection
