@extends('admin.layout.admin')

@section('title', 'Danh sách domain')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Domains
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách domains</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('domains.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="domains" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên domain</th>
                                <th>email su dung</th>
                                <th>Đường dẫn</th>
                                <th>Ngày hết hạn</th>
                                <th>Theme</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên domain</th>
                                <th>email su dung</th>
                                <th>Đường dẫn</th>
                                <th>Ngày hết hạn</th>
                                <th>Theme</th>
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
            var table = $('#domains').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('datatable_domain') !!}',
                columns: [
                    { data: 'domain_id', name: 'domain_id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'url', name: 'url' },
                    { data: 'end_at', name: 'end_at' },
                    { data: 'theme_name', name: 'theme_name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush

