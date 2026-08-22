@extends('admin.layout.admin')

@section('title', 'Danh sách trang')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách bài viết</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('pages.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="posts" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Đường dẫn</th>
                                <th>Hình ảnh</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tfoot>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Đường dẫn</th>
                                <th>Hình ảnh</th>
                                <th>Thao tác</th>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
     @include('admin.partials.popup_delete')
@endsection

@push('scripts')
<script>
    $(function() {
        var table = $('#posts').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('show_page') !!}',
            columns: [
                { data: 'post_id', name: 'post_id' },
                { data: 'title', name: 'title' },
                { data: 'slug', name: 'slug' },
                { data: 'image', name: 'image', orderable: false,
                    render: function ( data, type, row, meta ) {
                        return '<img src="'+data+'" width="100" />';
                    },
                    searchable: false  },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush

