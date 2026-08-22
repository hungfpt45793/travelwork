@extends('admin.layout.admin')

@section('title', 'Thêm mới nội dung quyền lợi' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Thêm mới nội dung quyền lợi
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

            <form action="{{ route('service_name_benifit.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="service_name_benifit">Nôi dung</label>
                    <textarea id="service_name_benifit_title" class="editor" name="service_name_benifit_title" cols="80" rows="10">
                           {{ old('service_name_benifit_title') }} </textarea>
                </div>
                <div>
                    @php
                        $service_benifits = \App\Entity\Service_benifit::get();
                    @endphp
                    <label for="service_benifit_id">Nôi dung</label>
                    <select name="service_benifit_id" id="service_benifit_id">
                        <option value="">--Chọn tên quyền lợi--</option>
                        @foreach ($service_benifits as $service_benifit)
                        <option value="{{ $service_benifit->service_benifit_id }}">{{ $service_benifit->service_benifit_name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Thêm</button>
                <div id="test"></div>
            </form>
        </div>
    </div>
</section>

@endsection