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
                                    <li class="breadcrumb-item active" aria-current="page">Thông tin cá nhân</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <h2>Thông tin cá nhân</h2>

                    @if(session('suscess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $value = session('suscess') }}
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

                    <form  action="{{ route('editUser') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        {{ method_field('POST') }}
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label"><span class="text-b700">Họ và tên</span><span class="clred pd-05">(*)</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control f14" name="name" placeholder="Họ và tên" value="{{ isset($user['name']) ? $user['name'] : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label"><span class="text-b700">Điện thoại</span><span class="clred pd-05">(*)</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control f14" name="phone" placeholder="Điện thoại" value="{{ isset($user['phone']) ? $user['phone'] : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3  control-label">Hình ảnh<span class="red">(*)</span></label>
                            <div class="col-sm-9">

                                <div id="uploadImage" style="display: inline-block">

                                    <img src="{{  $user['image'] }}" class="image" style="width: 70px">
                                    <input type="hidden" value="{{  $user['image'] }}" name="images"  />
                                </div>

                                <div style="display: inline-block;align-items: center; "><button class="btn btn-default addAvatar" style="height: 40px;margin-left: 30px;">Ảnh Avatar</button></div>

                                <input type='file' id="imgInp" accept="image/*" onchange="readURL(this)" style="display: none" multiple/>


                                <script>
                                    function readURL(input) {
                                        $('#uploadImage').empty();
                                        if (input.files && input.files[0]) {
                                            for(var i = 0; i< input.files.length; i++)
                                            {
                                                var file = input.files[i];
                                                var picReader = new FileReader();
                                                picReader.addEventListener("load",function(event){
                                                    var picFile = event.target;
                                                    $('#uploadImage').append("<img class='thumbnail' src='" + picFile.result + "'" +
                                                        "title='" + picFile.name + "' width='70' style='float: left' />");
                                                    $('#uploadImage').append('<input type="hidden" value="'+ picFile.result +'" name="images" />');
                                                });
                                                //Read the image
                                                picReader.readAsDataURL(file);
                                            }
                                        }
                                    }
                                    $('.addAvatar').click(function() {
                                        $('#imgInp').click();
                                        return false;
                                    });
                                </script>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label"><span class="text-b700">Địa chỉ</span><span class="clred pd-05">(*)</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control f14" name="address" placeholder="Địa chỉ" value="{{ isset($user['address']) ? $user['address'] : '' }}" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-9 pdtop30">
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>

                            </div>
                        </div>
                    </form>



                </div>

            </div>
        </div>
    </section>



@endsection
