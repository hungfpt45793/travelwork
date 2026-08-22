@extends('admin.layout.admin')

@section('title', 'Trình độ ngoại ngữ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Trình độ ngoại ngữ
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc Làm</a></li>
            <li><a href="#">Trình độ ngoại ngữ</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <a href="{{route('lang.create')}}"><button class="btn btn-info" style="float:right;">Thêm mới</button></a>

                            </div>
                        </div>
                        @if(!empty(session('error')))
                            <div class="alert alert-warning" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(!empty(session('success')))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="job_career" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Trọng số lương</th>
                                <th>Lời khuyên</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <th width="5%">ID</th>
                            <th>Tiêu đề</th>
                            <th>Trọng số lương</th>
                            <th>Lời khuyên</th>
                            <th>Thao Tác</th>
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
            $('#job_career').DataTable({
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: '{{route('dt_type_lang')}}',
                columns: [
                    { data: 'lang_id', name:'lang_id' },
                    { data: 'lang_name', name:'lang_name' },
                    { data: 'lang_salary', name:'lang_salary' },
                    { data: 'lang_give', name:'lang_give' },
                    { data: 'action', name: 'action', searchable: false, orderable: false }
                ]
            });
        });
    </script>
@endpush
