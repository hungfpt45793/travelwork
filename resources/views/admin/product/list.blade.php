@extends('admin.layout.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách sản phẩm</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @if (\App\Entity\SettingGetfly::checkSettingGetfly())
                <div class="box " id="getCateProductGetFly" style="display: none;">
                    <div class="box-header">
                        <h1>Lựa chọn danh mục tải về</h1>
                    </div>
                    <form action="{{ route('getProductGetfly') }}" method="post" >
                        {!! csrf_field() !!}
                        <div class="box-body">
                            <label>Chọn danh mục lấy về</label>
                            <div class="formCateProduct" style="overflow: scroll; height: 300px; overflow-x: hidden;">
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" data-loading-text="Đang lấy dữ liệu">Lấy dữ liệu về</button>
                        </div>
                    </form>
                </div>
                @endif
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('products.create') }}"><button class="btn btn-primary">Thêm mới</button></a>
                        @if (\App\Entity\SettingGetfly::checkSettingGetfly())
                        <button class="btn btn-primary " onclick="return getCateProductGetfly(this);" data-loading-text="Cập nhật...">Đồng bộ sản phẩm từ getfly</button>
                        @endif
                        <form action="{{ route('importProducts')}}" method="POST" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            {{ method_field('POST')}}
                            <div class="form-group">
                                <br>
                                <input type="file" name="file" required><br>
                                <button type="submit" class="btn btn-info">Nhập file Excel</button>
                                <a href="{{ route('exportProducts') }}" class="btn btn-success">Xuất file Excel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="products" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Đường dẫn</th>
                                <th>Danh mục</th>
                                <th width="20%">Hình ảnh</th>
                                <th>Mã sản phẩm</th>
                                <th>Giá</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection
@push('scripts')
<script>
    $(function() {
        $('#products').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatable_product') !!}',
            columns: [
                { data: 'post_id', name: 'posts.post_id' },
                { data: 'title', name: 'posts.title' },
                { data: 'slug', name: 'posts.slug' },
                { data: 'category_string', name: 'category_string' },
                { data: 'image', name: 'posts.image', orderable: false,
                    render: function ( data, type, row, meta ) {
                        return '<div class=""><img src="'+data+'" width="50" /></div>';
                    },
                    searchable: false  },
                { data: 'code', name: 'products.code' },
                { data: 'price', name: 'products.price' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });

    function getCateProductGetfly(e) {
        var btn = $(e).button('loading');
        $.ajax({
            type: "get",
            url: '{!! route('getCateProductGetfly') !!}',
            success: function(result){
                $('#getCateProductGetFly').show();
                var obj = jQuery.parseJSON( result);
                // nếu có lỗi xảy ra
                if (obj.httpCode == 500) {
                    alert('Đã có lỗi xảy ra vui lòng liên hệ với chúng tôi, để chúng tôi hỗ trợ.');
                    btn.button('reset');

                    return true;
                }
                // nếu thành công
                if (obj.httpCode == 200) {
                    $(e).hide();
                    btn.button('reset');
                    var categories = obj.categories;
                    $.each(categories, function(index, element) {
                        var html = '<div class="form-group col-xs-12">';
                        html += '<label style="cursor: pointer;"><input type="checkbox"  name="cate_getfly[]" value="'+element.category_id+', '+element.category_name+', '+ element.parent_id + '" class="flat-red" /> '+ element.cate_name_show +'</label>';
                        html += '</div>';

                        $('#getCateProductGetFly').find('.formCateProduct').append(html);
                    });

                    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                        checkboxClass: "icheckbox_flat-green",
                        radioClass   : "iradio_flat-green"
                    })

                }
            }
        });
    }
</script>
@endpush
