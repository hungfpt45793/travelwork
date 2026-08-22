@extends('admin.layout.admin')

@section('title', 'Sửa tên quyền lợi' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sửa tên quyền lợi
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

            <form action="{{ route('service_benifit.update', $service_benifit->service_benifit_id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="service_benifit_name">Tên benifit</label>
                    <input type="text" id="service_benifit_name" name="service_benifit_name"
                        value="{{ old('service_benifit_name', $service_benifit->service_benifit_name ?? '') }}" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Lưu thông tin</button>
                <div id="test"></div>
            </form>
        </div>
    </div>
</section>

@endsection