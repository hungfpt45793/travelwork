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

            <form action="{{ route('service_name_benifit.update', $service_name_benifit->service_name_benifit_id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="service_name_benifit">Nôi dung</label>
                    <textarea id="service_name_benifit_title" class="editor" name="service_name_benifit_title" cols="80"
                        rows="10">
                           {{ old('service_name_benifit_title',$service_name_benifit->service_name_benifit_title) }} </textarea>
                </div>
                <div class="form-group">
                    <label for="service_benifit_id">Chọn tên quyền lợi</label>
                    <select name="service_benifit_id" class="select2" id="service_benifit_id">
                        <option value="">--Chọn tên quyền lợi--</option>
                        @php
                        $service_benifits = \App\Entity\Service_benifit::get();
                    @endphp
                        @foreach ($service_benifits as $service_benifit)
                        <option value="{{ $service_benifit->service_benifit_id }}"
                            {{ ($service_benifit->service_benifit_id==$service_name_benifit->service_benifit_id) ? 'selected' : '' }}>
                            {{ $service_benifit->service_benifit_name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Lưu thông tin</button>
                <div id="test"></div>
            </form>
        </div>
    </div>
</section>

@endsection