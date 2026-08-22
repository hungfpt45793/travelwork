@extends('admin.layout.admin')

@section('title', 'Thêm mới Mức lương')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật mức lương
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Mức lương</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('salary.update',['salary_id'=> $salary->salary_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">Mức lương mong muốn</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <input type="text" class="form-control" name="description" value="{{$salary->description}}" placeholder="Mô tả">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mức lương trong khoảng</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Từ</label>
                                            <input type="number" class="form-control" name="salary_from" value="{{$salary->salary_from}}" placeholder="Mức lương từ" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Đến</label>
                                            <input type="number" class="form-control" name="salary_to" value="{{$salary->salary_to}}" placeholder="Mức lương đến" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="form-check">
								
								<label class="form-check-input" for="" style="margin-right:20px">
								<input type="radio" class="form-check-input" name="status_salary" value="0" @if($salary->status_salary == 0)checked @endif>sử dụng
								</label>
								<label class="form-check-input" for="">
								<input type="radio" class="form-check-input" name="status_salary" value="1" @if($salary->status_salary == 1)checked @endif>không sử dụng
								</label>
							</div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection