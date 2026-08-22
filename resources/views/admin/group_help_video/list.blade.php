@extends('admin.layout.admin')

@section('title', 'Danh sách nhóm video')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Nhóm Hướng dẫn video
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách nhóm hướng dẫn video</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('group-help-video.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="groupHelpVideo" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên nhóm</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên nhóm</th>
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
            var table = $('#groupHelpVideo').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('datatable_group_help_video') !!}',
                columns: [
                    { data: 'group_id', name: 'group_id' },
                    { data: 'title', name: 'title' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush

