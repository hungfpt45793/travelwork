@extends('admin.layout.admin')

@section('title', 'Sửa thông tin giáo viên '.$teacher->teacher_name)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sửa giáo viên {{ $teacher->teacher_name }}
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
            <form role="form" action="{{ route('teacher.update',['teacher_id'=>$teacher->teacher_id]) }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
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
                                               placeholder="Họ và tên giáo viên" value="{{ $teacher->teacher_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email (đăng nhập)</label>
                                        <input type="email" class="form-control" name="email"
                                               placeholder="Email đăng nhập" value="{{ $teacher->teacher_email }}" readonly>
                                    </div>
                                    <div class="form-group">

                                        <input type="checkbox" name="is_change_password" value="1" class="flat-red"> Chọn nếu muốn thay đổi mật khẩu
                                        <br>
                                        <label for="exampleInputEmail1">Mật khẩu</label>
                                        <input type="password" class="form-control" name="password" placeholder="Mật khẩu" value="{{ isset($staffCharge->password) ? $staffCharge->password :'' }}" />
                                    </div>


                                </div>
                                <div class="col-xs-12 col-md-6">


                                    <div class="form-group" style="    margin-bottom: 20px;">
                                        <label for="exampleInputEmail1" style="display: block">Giới tính yêu cầu</label>

                                        <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                            <input class="form-check-input flat-red" type="radio" name="gender"
                                                   id="exampleRadios2"
                                                   value="1" @if($teacher->gender == 1) checked
                                                   @endif style="width: 18px;height: 18px;">
                                            <label class="form-check-label" for="exampleRadios2">
                                                Nữ
                                            </label>
                                        </div>
                                        <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                            <input class="form-check-input flat-red" type="radio" name="gender"
                                                   id="exampleRadios3"
                                                   value="2" @if($teacher->gender == 2) checked @endif>
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
                                    <input type="date" class="form-control" value="{{$teacher->birthday }}"
                                           name="birthday"/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6" style="padding-right: 0">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số điện thoại</label>
                                    <input type="number" class="form-control" name="teacher_phone"
                                           placeholder="Số điện thoại" value="{{ $teacher->teacher_phone }}">
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh đại diện</label><br>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ $teacher->teacher_images }}" width="80" height="70"/>
                                <input name="teacher_images" type="hidden" value="{{ $teacher->teacher_images }}"/>
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
                                {!! $teacher->information_verifier !!}

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
                                                @if($car->career_category_id == $teacher->career_category_id) selected @endif
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
                                                            {{ $province->province_id == $teacher->province ? 'selected' : '' }}
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
                                                            {{ $district->district_id == $teacher->district ? 'selected' : '' }}
                                                    >{{$district->district_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="clgreen" style="color: green;font-weight: bold">Chuyển tài khoản</label>
                                            <p></p>
                                            <a target="_blank" href="{{ env('API_TEACHER') }}api/copy-tai-khoan-giao-vien/{{ $teacher->teacher_id }}">Chuyển tài khoản sang kế toán thuế</a>


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

            // $status_accounting = $request->input('status_accounting');
            // if ($status_accounting == 1) {
            //     $data = ';
            // }


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