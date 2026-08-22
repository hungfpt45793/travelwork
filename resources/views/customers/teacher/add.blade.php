@extends('admin.layout.admin')

@section('title', 'Thêm mới giáo viên')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới giáo viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">giáo viên</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('teacher.store') }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-8">
                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert"
                                     style="padding: 5px;margin: 2px;display: inline-block;">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin giáo viên</h3>
                        </div>

                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Họ và tên giáo viên</label>
                                        <input type="text" class="form-control" name="teacher_name"
                                               placeholder="Họ và tên giáo viên" value="{{ old('teacher_name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email (đăng nhập)</label>
                                        <input type="email" class="form-control" name="email"
                                               placeholder="Email đăng nhập" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mật khẩu (đăng nhập)</label>
                                        <input type="password" class="form-control" name="password"
                                               placeholder="Mật khẩu (đăng nhập)" value="{{ old('password') }}">
                                    </div>


                                </div>
                                <div class="col-xs-12 col-md-6">


                                    <div class="form-group" style="    margin-bottom: 20px;">
                                        <label for="exampleInputEmail1" style="display: block">Giới tính yêu cầu</label>

                                        <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                            <input class="form-check-input flat-red" type="radio" name="gender"
                                                   id="exampleRadios2"
                                                   value="1" @if(old('gender') == 1) checked
                                                   @endif style="width: 18px;height: 18px;">
                                            <label class="form-check-label" for="exampleRadios2">
                                                Nữ
                                            </label>
                                        </div>
                                        <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                            <input class="form-check-input flat-red" type="radio" name="gender"
                                                   id="exampleRadios3"
                                                   value="2" @if(old('gender') == 2) checked @endif>
                                            <label class="form-check-label" for="exampleRadios3">
                                                Nam
                                            </label>
                                        </div>
                                    </div>




                                </div>






                            </div>
                            <div class="col-xs-12 col-md-6" style="padding-left: 0">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày sinh</label>
                                <input type="date" class="form-control" value="{{ old('birthday') }}"
                                       name="birthday"/>
                            </div>
                            </div>
                            <div class="col-xs-12 col-md-6" style="padding-right: 0">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại</label>
                                <input type="number" class="form-control" name="teacher_phone"
                                       placeholder="Số điện thoại" value="{{ old('teacher_phone') }}">
                            </div>
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh đại diện</label><br>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{old('teacher_images')}}" width="80" height="70"/>
                                <input name="teacher_images" type="hidden" value="{{old('teacher_images')}}"/>
                            </div>


                        </div>
                        <!-- /.box-body -->
                    </div>



                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Giới thiệu bản thân </h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <textarea class="editor" id="content" name="information_verifier"
                                      placeholder="Giới thiệu bản thân" cols="80" rows="10">

                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="box box-primary row">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin hồ sơ</h3>
                        </div>
                        <div class="col-md-12">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Công việc mong muốn</label>

                                    <select class="form-control select2" name="career_category_id">
                                        <option value="">-- Chọn công việc --</option>
                                        <?php
                                        $career = \App\Entity\Career::getAllCareer();
                                        ?>
                                        @foreach($career as $car)
                                            <option value="{{$car->career_category_id}}"
                                                    @if($car->career_category_id == old('career_category_id')) selected @endif
                                            >{{$car->career_category_name}}</option>
                                        @endforeach
                                    </select>


                                </div>




                            <div class="form-group">
                                <label for="exampleInputEmail1">Quê quán</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                            <select class="form-control select2" name="province"
                                                    aria-label="Tỉnh/Thành phố" id="province">
                                                <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                    <option value="{{$province->province_id}}"
                                                            {{ $province->province_id == old('province') ? 'selected' : '' }}
                                                    >{{$province->province_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Quận/Huyện</label>
                                            <select class="form-control select2" name="district" aria-label="Quận/Huyện"
                                                    id="district">
                                                <option value="0">-- Chọn Quận/Huyện --</option>
                                                @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                    <option value="{{$district->district_id}}"
                                                            {{ $district->district_id == old('district') ? 'selected' : '' }}
                                                    >{{$district->district_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Lưu lại</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script type="text/javascript">
        $('#datepicker').datepicker({
            autoclose: true
        })
    </script>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#staff').change(function () {
                var staff = $(this).val();
                $.get('/admin/ajax-staff/' + staff, function (data) {
                    $('#detail').html(data);
                })
            });

            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });

            $('#note').click(function () {
                $.ajax({
                    url: '{{route('note-employee')}}',
                    method: 'GET',
                    data: {
                        content: $('#note-employee').val()
                    },
                    success: function (data) {
                        $('#noteContent').html(data);
                        $('#note-employee').val('')
                    }
                });
            });

            $('#note-employee').keypress(function (event) {
                if ((event.keyCode ? event.keyCode : event.which) == 13) {
                    $.ajax({
                        url: '{{route('note-employee')}}',
                        method: 'GET',
                        data: {
                            content: $(this).val()
                        },
                        success: function (data) {
                            $('#noteContent').html(data);
                            $('#note-employee').val('')
                        }
                    });
                }
            });

            $('#career').keyup(function () {
                if ($(this).val() == '') {
                    $.ajax({
                        url: '{{route('ajax-career-list')}}',
                        type: 'GET',
                        data: {},
                        success: function (result) {
                            $('#careerList').html(result);
                        }
                    });
                }

                $.get('/admin/ajax-career/' + $(this).val(), function (data) {
                    $('#careerList').html(data);
                })
            })
        });
    </script>
@endpush