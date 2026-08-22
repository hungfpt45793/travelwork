@extends('admin.layout.admin')

@section('title', 'Thêm mới bank' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Thêm mới bank
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

            <form action="{{ route('service_bank.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="service_bank_name">Tên bank</label>
                    <input type="text" id="service_bank_name" name="service_bank_name"
                        value="{{ old('service_bank_name') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="service_bank_own">Tên chủ bank</label>
                    <input type="text" id="service_bank_own" name="service_bank_own"
                        value="{{ old('service_bank_own') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="service_bank_branch">Chi nhánh</label>
                    <input type="text" id="service_bank_branch" name="service_bank_branch"
                        value="{{ old('service_bank_branch') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Chọn ảnh</label>
                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh" size="20" />
                    <img src="" width="80" height="70" />
                    <input name="service_bank_image" type="hidden" />
                </div>
                <div class="form-group">
                    <label for="service_bank_content">Nội dung bank</label>
                    <textarea id="service_bank_content" class="editor" name="service_bank_content" cols="80"
                        rows="10">
                          {{ old('service_bank_content') }}  </textarea>
                </div>
                <div class="form-group">
                    <label for="service_bank_number">Số tài khoản</label>
                    <input type="number" id="service_bank_number" name="service_bank_number"
                        value="{{ old('service_bank_number') }}" class="form-control">
                </div>
                
                <button type="submit" class="btn btn-success">Thêm</button>
                <div id="test"></div>
            </form>
        </div>
    </div>
</section>

@endsection