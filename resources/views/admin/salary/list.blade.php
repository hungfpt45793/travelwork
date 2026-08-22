@extends('admin.layout.admin')

@section('title', 'Danh sách Mức lương' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thành viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Mức lương</a></li>
            <li><a href="#">Danh sách mức lương</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('salary.create') }}"><button class="btn btn-primary" style="float: right">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Từ</th>
                                <th>Đến</th>
                                <th>Mô tả</th>
								<th>trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
								@foreach($salary as $sl)
								<tr>
									<td width="5%">{{ $sl->salary_id}}</td>
									<td>{{!empty($sl->salary_from) ? number_format($sl->salary_from) : 0}} VNĐ</td>
									<td>{{!empty($sl->salary_to) ? number_format($sl->salary_to) : 0}} VNĐ</td>
									<td>{{!empty($sl->description) ? $sl->description : ''}} VNĐ</td>
									<td>{{!empty($sl->status_salary) ? 'không sử dụng' : 'sử dụng'}}</td>
									<td>
									<a href="{{ route('salary.edit',['salary_id' => $sl->salary_id]) }}">
									<button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
								   </a>
								   <a href="{{route('salary.destroy', ['salary_id' => $sl->salary_id])}}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
										<i class="fa fa-trash-o" aria-hidden="true"></i>
									</a>
									</td>
								</tr>
								@endforeach
							</tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Từ</th>
                                <th>Đến</th>
                                <th>Mô tả</th>
								<th>trạng thái</th>
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
        $(document).ready(function () {
            $('#salaries').DataTable();
        });
    </script>
@endpush
