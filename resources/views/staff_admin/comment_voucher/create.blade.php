@extends('staff_admin.layouts.master')

@section('title', 'Danh sách ứng viên đăng ký tư vấn' )

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
                    <form role="form" action="{{ route('staff_comment_voucher.store') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        {{ method_field('POST') }}

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
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">slug</label>
                                        <input type="text" class="form-control" name="slug_voucher"
                                               placeholder="đường dẫn tĩnh">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mô tả</label>
                                        <textarea name="des_voucher" rows="5" style="width: 100%;"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                               size="20"/>
                                        <img src="" width="80" height="70"/>
                                        <input name="image_voucher" type="hidden" value=""/>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nội dung</label>
                                        <textarea class="editor" id="add_voucher" name="content_voucher" rows="10"
                                                  cols="80"/></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Chọn file tài liệu <i class="glyphicon glyphicon-upload" style="font-size: 20px;"></i>(<= 10MB)</label>
                                        <input type="file" name="link_dowload_voucher">
                                    </div>
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
                                        <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Thẻ description</label>
                                        <textarea type="text" class="form-control" name="meta_description" placeholder="Thẻ description" rows="5"></textarea>

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Thẻ keyword</label>
                                        <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword">
                                    </div>


                                </div>
                                <!-- /.box-body -->
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Danh mục tài liệu</h3>
                                </div>
                                <div class="box-body">
                                    @php
                                        $lists = \App\Entity\VoucherCategories::get();
                                    @endphp
                                    @foreach($lists as $id=>$list)
                                        <label style="display: block;margin-bottom: 15px;">
                                            {{ $list['name_cate_voucher'] }}
                                        </label>
                                        <?php $category_child = \App\Entity\VoucherChildCategories::getAllCategoryChild($list['id_cate_voucher']);

                                        ?>
                                        @if(!empty($category_child))
                                            <div class="form-group">
                                                @foreach($category_child as $cate)
                                                    <label style="display: block;margin-bottom: 15px;">
                                                        <input type="radio" name="id_cate_child" class="flat-red"
                                                               value="{{ isset($cate->id_cate_child) ? $cate->id_cate_child : '' }}">
                                                        {{ $cate->name_cate_child }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
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
