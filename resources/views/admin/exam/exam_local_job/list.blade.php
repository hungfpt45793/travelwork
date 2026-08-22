@extends('admin.layout.admin')

@section('title', 'Vị trí công việc')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>

            Vị trí công việc
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Vị trí công việc</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('exam_local_job.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>

                        


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="category_exam" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên vị trí công việc</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($exam_locals as $id => $exam_local )
                                <tr>
                                    <td>{{ $exam_local->exam_local_job_id }}</td>
                                    <td>{{ $exam_local->exam_local_job }}</td>

                                    <td>
                                        <a href="{{ route('exam_local_job.edit', ['exam_local_job_id' => $exam_local->exam_local_job_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('exam_local_job.destroy', ['exam_local_job_id' => $exam_local->exam_local_job_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#category_exam').DataTable( {
                                    "language": {
                                        "url": "{{ asset('tracnghiem') }}/js/Vietnamese.json"
                                    }
                                } );
                            } );
                        </script>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection

