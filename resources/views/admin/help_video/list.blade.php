@extends('admin.layout.admin')

@section('title', 'Danh sách video hướng dẫn')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Video hướng dẫn
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách Video Hướng Dẫn</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('help-video.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="helpVideo" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Hình ảnh</th>
                                <th>Video</th>
                                <th>Nhóm</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Hình ảnh</th>
                                <th>Video</th>
                                <th>Nhóm</th>
                                <th>Thao tác</th>
                            </tr>
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
            var table = $('#helpVideo').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('datatable_help_video') !!}',
                columns: [
                    { data: 'help_video_id', name: 'help_video_id' },
                    { data: 'title', name: 'title' },
                    { data: 'image', name: 'image', orderable: false,
                        render: function ( data, type, row, meta ) {
                            return '<img src="'+data+'" width="100" />';
                        },
                        searchable: false  },
                    { data: 'embbed_video', name: 'embbed_video', orderable: false,
                        render: function ( data, type, row, meta ) {
                            return '<div>'+data +'</div>';
                        },
                        searchable: false  },
                    { data: 'title_group', name: 'title_group' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush
