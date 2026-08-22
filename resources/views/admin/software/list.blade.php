@extends('admin.layout.admin')

@section('title', 'Danh sách Phần mềm văn phòng' )

@section('content')
    <section class="content-header">
        <h1>
            Phần mềm văn phòng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Phầm mềm văn phòng</a></li>
            <li><a href="#">Danh sách Phần mềm</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <a href="{{route('software.create')}}"><button class="btn btn-info" style="float:right;">Thêm mới</button></a>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="software" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="15%">Mã phần mềm</th>
                                <th>Tên phần mềm</th>
                                <th>Trọng số lương</th>
                                <th>Lời khuyên</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th width="15%">Mã phần mềm</th>
                                <th>Tên phần mềm</th>
                                <th>Trọng số lương</th>
                                <th>Lời khuyên</th>
                                <th width="15%">Thao tác</th>
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
    @include('admin.partials.visiable')
@endsection
@push('scripts')
    <script>
        $(function () {
            $('#software').dataTable({
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: '{{route('dt_software')}}',
                columns:[
                    { data: 'software_id', name: 'software_id' },
                    { data: 'software_name', name: 'software_name' },
                    { data: 'software_salary', name: 'software_salary' },
                    { data: 'software_give', name: 'software_give' },
                    { data: 'action', name: 'action', searchable: false, orderable: false }
                ]
            });
        });
    </script>
@endpush