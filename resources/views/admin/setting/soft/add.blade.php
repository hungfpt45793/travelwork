@extends('admin.layout.admin')

@section('title', 'Thêm mới Kỹ năng mềmp')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Kỹ năng mềm
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li><a href="#">Kỹ năng mềm</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('soft.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-8">
                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề</label>
                                <input type="text" class="form-control" name="soft_name"
                                       placeholder="Tiêu đề" value="{{old('soft_name')}}"
                                       required>
                            </div> <div class="form-group">
                                <label for="exampleInputEmail1">Lời khuyên</label>
                                <input type="text" class="form-control" name="soft_give"
                                       placeholder="Tiêu đề" value="{{old('soft_give')}}"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trọng số lương(thập phân)</label>
                                <input type="number" step="0.01" class="form-control" name="soft_salary" placeholder="đường dẫn tĩnh"
                                       value="0">
                            </div>
                        </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                    </div>
                </div>


            </form>
        </div>
    </section>
@endsection

