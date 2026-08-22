@extends('admin.layout.admin')

@section('title', 'Thêm mới tên quyền lợi' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Thêm mới tên quyền lợi
    </h1>
</section>
<section class="content">
    <div class="row box">
        <div class="col-md-12">
            @if($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                <strong>{{ $error }}</strong>
            </div>
            @endforeach
            @endif

            <form action="{{ route('service_benifit.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="service_benifit_name">Tên quyền lợi</label>
                    <input type="text" id="service_benifit_name" name="service_benifit_name"
                        value="{{ old('service_benifit_name') }}" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Thêm</button>
                <div id="test"></div>
            </form>
        </div>
    </div>
</section>

@endsection