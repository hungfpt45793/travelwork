@extends('admin.layout.admin')

@section('title', 'Trình độ học vấn')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Trình độ học vấn
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Trình độ học vấn</a></li>
            <li><a href="#" class="active">Danh sách</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <a href="{{route('literacy.create')}}"><button class="btn btn-info" style="float:right;">Thêm mới</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="box-body">
                        <table id="literacy" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="15%">Mã trình độ</th>
                                <th>Trình độ học vấn</th>
                                <th>Trọng số lương</th>
                                <th>Mô tả</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th width="15%">Mã trình độ</th>
                                <th>Trình độ học vấn</th>
                                <th>Trọng số lương</th>
                                <th>Mô tả</th>
                                <th>Thao Tác</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#literacy').dataTable({
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: '{{route('dt_literacy')}}',
                columns: [
                    { data: 'literacy_id', name: 'literacy_id' },
                    { data: 'literacy_name', name: 'literacy_name' },
                    { data: 'literacy_salary', name: 'literacy_salary' },
                    { data: 'description', name: 'description' },
                    { data: 'action', name: 'action', searchable: false, orderable: false }
                ]
            });
        });
    </script>
@endpush
