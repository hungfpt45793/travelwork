@extends('staff_admin.layouts.master')

@section('title', 'Sửa lại tài liệu' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.archives')
            </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting pd15 col-f14 ">
                    <form role="form" action="{{ route('staff_voucher.update',['id_voucher' => $voucher->id_voucher]) }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}

                        <div class="row">
                            <div class="col-xs-12 col-md-8">

                                <!-- Nội dung thêm mới -->
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Nội dung</h3>
                                    </div>
                                    <!-- /.box-header -->

                                    <div class="box-body">

                                        @if (session('error'))
                                            <div class="infoAlert">
                                                <div class="alert alert-warning">
                                                    <span>{{ session('error') }}</span>
                                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên tài liệu</label>
                                            <input type="text" class="form-control" name="name_voucher" placeholder="Tiêu đề"
                                                   required value="{{ $voucher->name_voucher }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">slug</label>
                                            <input type="text" class="form-control" name="slug_voucher"
                                                   placeholder="đường dẫn tĩnh" value="{{ $voucher->slug_voucher }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mô tả</label>
                                            <textarea name="des_voucher" rows="5" style="width: 100%;">{{ $voucher->des_voucher }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                   size="20"/>
                                            <img src="{{ isset($voucher->image_voucher) ? asset($voucher->image_voucher) : '' }}" width="80" height="70"/>
                                            <input name="image_voucher" type="hidden" value="{{ isset($voucher->image_voucher) ? $voucher->image_voucher : ''  }} "/>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nội dung</label><br>
                                            <textarea type="text" id="add_voucher" class="editor" name="content_voucher" rows="10"
                                                      cols="80">{!! $voucher->content_voucher !!}</textarea>

                                        </div>
                                        <div class="form-group">
                                            <iframe src="https://docs.google.com/gview?url={{ asset('upload/'.$voucher->link_dowload_voucher) }}&embedded=true" style="width:100%; height:300px;" frameborder="0"></iframe>
                                            <label>
                                                <input type="checkbox" name="checkUploadFile" value="1">
                                                Chọn nếu muốn thay đổi file tài liệu
                                            </label>
                                            <p></p>
                                            <label for="exampleInputEmail1">Chọn file tài liệu <i class="glyphicon glyphicon-upload" style="font-size: 20px;"></i>(<= 10MB)</label>
                                            <input type="file" name="link_dowload_voucher">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Link dowload tài liệu (từ google driver hoặc linkmedia ....)</label>
                                            <input type="text" class="form-control" name="link_dowload_file"
                                                    placeholder="đường dẫn link" value="{{ isset($voucher['link_dowload_file']) ? $voucher['link_dowload_file'] : '' }}">
                                        </div>
                                        {{-- từ khóa --}}
                                        @php
                                            foreach ($input_tags as $tag) {
                                                $tag_type = $tag['tag_type'];
                                            }
                                        @endphp
                                        @include('admin.layout.themtukhoa')
                                        {{-- END từ khóa --}}
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                                <!-- Bổ sung -->
                                <div class="box box-primary ">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Hỗ trợ seo</h3>
                                    </div>
                                    <!-- /.box-header -->

                                    <div class="box-body">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Thẻ title</label>
                                            <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" value="{{ $voucher->meta_title }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Thẻ description</label>
                                            <textarea type="text" class="form-control" name="meta_description" placeholder="Thẻ description" rows="5">{{ $voucher->meta_description }}</textarea>

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Thẻ keyword</label>
                                            <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" value="{{ $voucher->meta_keyword }}">
                                        </div>


                                    </div>
                                    <!-- /.box-body -->
                                </div>

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Danh mục tài liệu</h3>
                                    </div>
                                    <div class="box-body">
                                        @foreach($lists as $id=>$lists)
                                            <label style="display: block;margin-bottom: 15px;color: green;font-weight: bold;font-size: 16px ">
                                                {{ $lists['name_cate_voucher'] }}
                                            </label>
                                            <?php $category_child = \App\Entity\VoucherChildCategories::getAllCategoryChild($lists['id_cate_voucher']);

                                            ?>
                                            @if(!empty($category_child))
                                                <div class="form-group">
                                                    @foreach($category_child as $cate)
                                                        <label style="display: block;margin-bottom: 15px;">
                                                            <input type="radio" name="id_cate_child" class="flat-red"
                                                                   value="{{ isset($cate->id_cate_child) ? $cate->id_cate_child : '' }}" @if($voucher->id_cate_child == $cate->id_cate_child) checked @endif>
                                                            {{ $cate->name_cate_child }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach





                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="sale_money" value="1" class="flat-red" {{ $cate->sale_money == 1 ? 'checked' : '' }}
                                                /> Chia sẻ tài liệu lên facebook (share bài viết kiếm tiền)
                                            </label>
                                        </div>
                                    </div>
                                </div>
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
