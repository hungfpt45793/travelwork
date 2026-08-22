@extends('site.layout.site')

@section('title','Đăng ký')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
    <section class="main bgUser">
        <div class="container">
            <div class="row">
                @include('site.admin_site.sidebar')

                <div class="col-lg-9 col-md-9 categoryQuestion userRight">
                    <div class="row">
                        <div class="col-lg-12" style="padding: 0;">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb ">
                                    <li class="breadcrumb-item"><a class="clHome"  href="#">Tài khoản </a></li>
                                    {{--<li class="breadcrumb-item"><a class="clHome" href="{{ route('site_exam.edit',['id_exam' => $exam->id_exam]) }}">Đề thi {{ $exam->code_exam }}</a></li>--}}
                                    <li class="breadcrumb-item active" aria-current="page">Đổi mật khẩu</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <h2>Thông tin cá nhân</h2>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $value = session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('erorr'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $value = session('erorr') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form  action="{{ route('changPassword') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        {{ method_field('POST') }}

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label"><span class="text-b700">Mật khẩu cũ</span><span class="clred pd-05">(*)</span></label>
                            <div class="col-sm-9">
                                <input id="password_old" type="password" class="form-control" name="password_old" required>
                            </div>
                            @if (session('faidOldPassword'))
                                <span class="help-block">
                                                <strong> {{ session('faidOldPassword') }}</strong>
                                            </span>
                            @endif
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label"><span class="text-b700">Mật khẩu mới</span><span class="clred pd-05">(*)</span></label>
                            <div class="col-sm-9">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label"><span class="text-b700">Nhập lại mật khẩu mới</span><span class="clred pd-05">(*)</span></label>
                            <div class="col-sm-9">
                                <input id="password-confirm"  type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>Mật khẩu xác nhận lại không đúng.</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 pdtop30">
                                <button type="submit" class="btn btn-primary">Lưu mật khẩu</button>

                            </div>
                        </div>
                    </form>



                </div>

            </div>
        </div>
    </section>



@endsection
