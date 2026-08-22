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
                    <form action="">
                        <h4>Nội dung</h4>
                        <hr>
                        <div class="form-group">
                            <label for="name_cate_voucher">Tên kho tài liệu</label>
                            <input id="name_cate_voucher" type="text" class="form-control" name="name_cate_voucher" placeholder="Tiêu đề">
                        </div>
                        <div class="form-group">
                            <label for="slug_cate_voucher">Slug</label>
                            <input id="slug_cate_voucher" type="text" class="form-control" name="slug_cate_voucher" placeholder="Đường dẫn tĩnh">
                        </div>
                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <input id="icon" type="text" class="form-control" name="icon" placeholder="Icon">
                        </div>
                        <hr class="hr">
                        <h4>Hỗ trợ Seo</h4>
                        <div class="form-group">
                            <label for="meta_title">Thẻ title</label>
                            <input id="meta_title" type="text" class="form-control" name="meta_title" placeholder="Thẻ title">
                        </div>
                        <div class="form-group">
                            <label for="meta_description">Thẻ description</label>
                            <textarea id="meta_description" type="text" class="form-control" name="meta_description" placeholder="Thẻ description">
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="meta_keyword">Thẻ keyword</label>
                            <input id="meta_keyword" type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword">
                        </div>
                        <button type="submit" class="btn btn-success">Thêm mới</button>
                    </form>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@endsection
