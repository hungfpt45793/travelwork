@extends('admin.layout.admin')

@section('title', 'Danh sách nhóm việc làm')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Nhóm Việc Làm
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc Làm</a></li>
            <li class="active"><a href="#">Nhóm Việc Làm</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <a href="{{route('job-group.create')}}"><button class="btn btn-info" style="float:right;">Thêm mới</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="box-body">
                        <table id="job_group" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên nhóm việc làm</th>
                                <th>Hình ảnh</th>
                                <th>Tổng số việc làm</th>
                                <th>Cần tuyển</th>
                                <th>Đã tuyển</th>
                                <th>Tồn</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên nhóm việc làm</th>
                                <th>Hình ảnh</th>
                                <th>Tổng số việc làm</th>
                                <th>Cần tuyển</th>
                                <th>Đã tuyển</th>
                                <th>Tồn</th>
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
            $('#job_group').DataTable({
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: '{{route('dt_job_group')}}',
                columns: [
                    { data: 'job_group_id', name:'job_group_id' },
                    { data: 'job_group_name', name:'job_group_name' },
                    { data: 'image', name: 'image', orderable: false,
                        render: function ( data, type, row, meta ) {
                            return '<img src="'+data+'" width="100" />';
                        },
                        searchable: false  },
                    { data: 'total_jobs', name:'total_jobs' ,
                        render: function (data) {
                            return numeral(data).format('0,0');
                        }
                    },
                    { data: 'recruit', name:'recruit' ,
                        render: function (data) {
                            return numeral(data).format('0,0');
                        }
                    },
                    { data: 'recruited', name: 'recruited' ,
                        render: function (data) {
                            return numeral(data).format('0,0');
                        }
                    },
                    { data: 'inventory', name: 'inventory' ,
                        render: function (data) {
                            return numeral(data).format('0,0');
                        }
                    },
                    { data: 'action', name: 'action', searchable: false, orderable: false }
                ]
            });
        });
    </script>
@endpush
