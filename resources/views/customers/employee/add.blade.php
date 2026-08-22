@extends('admin.layout.admin')

@section('title', 'Thêm mới ứng viên')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới ứng viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Ứng viên</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-8">
                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin ứng viên</h3>
                        </div>

                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Họ và tên ứng viên</label>
                                        <input type="text" class="form-control" name="employee_name" placeholder="Họ và tên ứng viên" value="{{ old('employee_name') }}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email (đăng nhập)</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email đăng nhập" value="{{ old('email') }}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mật khẩu (đăng nhập)</label>
                                        <input type="password" class="form-control" name="password" placeholder="Mật khẩu (đăng nhập)" value="{{ old('password') }}" >
                                    </div>


                                </div>
                                <div class="col-xs-12 col-md-6">



                                    <div class="form-group" style="    margin-bottom: 20px;">
                                        <label for="exampleInputEmail1" style="display: block">Giới tính yêu cầu</label>

                                        <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                            <input class="form-check-input flat-red" type="radio" name="gender" id="exampleRadios2"
                                                   value="1" @if(old('gender') == 1) checked @endif style="width: 18px;height: 18px;">
                                            <label class="form-check-label" for="exampleRadios2">
                                                Nữ
                                            </label>
                                        </div>
                                        <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                            <input class="form-check-input flat-red" type="radio" name="gender" id="exampleRadios3"
                                                   value="2" @if(old('gender') == 2) checked @endif>
                                            <label class="form-check-label" for="exampleRadios3">
                                                Nam
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngày sinh</label>
                                        <input type="date" class="form-control" value="{{ old('date') }}" name="birthday" />
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Chứng minh thư nhân dân</label>
                                        <input type="text" class="form-control" value="{{ old('cmt') }}" name="cmt" placeholder="Chứng minh thư nhân dân" />
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngày cấp chứng minh thư</label>
                                        <input type="date" class="form-control" value="{{ old('cmt_date') }}" name="cmt_date" placeholder="Chứng minh thư nhân dân" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số điện thoại</label>
                                        <input type="number" class="form-control" name="phone" placeholder="Số điện thoại" value="{{ old('phone') }}" >
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tình trạng hôn nhân</label>
                                        <select class="form-control select2" name="marry">
                                            <option value="0" {{old('marry') == 0 ? 'selected' : ''}}>Độc thân</option>
                                            <option value="1" {{old('marry') == 1 ? 'selected' : ''}}>Đã kết hôn</option>
                                        </select>
                                    </div>



                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nơi cấp chứng minh thư</label>
                                        <select class="form-control select2" name="cmt_local" aria-label="Tỉnh/Thành phố" id="">
                                            <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                <option value="{{$province->province_id}}"
                                                        {{ $province->province_id == old('cmt_local') ? 'selected' : '' }}
                                                >{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                            <select class="form-control select2" name="province" aria-label="Tỉnh/Thành phố" id="province">
                                                <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                    <option value="{{$province->province_id}}"
                                                    {{ $province->province_id == old('province') ? 'selected' : '' }}
                                                    >{{$province->province_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Quận/Huyện</label>
                                            <select class="form-control select2" name="district" aria-label="Quận/Huyện" id="district">
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

                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ thường trú</label>
                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ thường trú" value="{{ old('address' )}}" >
                            </div>




                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh đại diện</label><br>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{old('image')}}" width="80" height="70"/>
                                <input name="image" type="hidden" value="{{old('image')}}"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tải CV</label>
                                <input type="file" class="form-control" name="fileCV" value="{{old('fileCV')}}" >
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin hồ sơ</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
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




                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> Mức lương mong muốn </label>
                                        <select class="form-control select2" name="salary_id">
                                            <option value="0">-- Chọn mức lương mong muốn --</option>
                                            @foreach($salaries as $salary)
                                                <option value="{{$salary->salary_id}}"
                                                        {{$salary->salary_id == old('salary_id') ? 'selected' : ''}}
                                                >{{$salary->salary_from}} - {{$salary->salary_to}}</option>
                                            @endforeach
                                        </select>
                                    </div>






                                </div>
                            </div>

                            <div class="form-group row">
                                <!-- <div class="col-lg-6 borderSelect2">
                                    <label for="inputZip" class="fw6">Trình độ </label>
                                    <select name='employee_level_id' id="ddlQualificationType"
                                            class="selectbox requiredbox form-control select2">
                                        <option value="0" selected>-- Chọn Bằng cấp --</option>
                                        @foreach(\App\Entity\Literacy::get() as $literacy)
                                            <option value="{{$literacy->literacy_id}}">{{$literacy->literacy_name}}</option>
                                        @endforeach
                                    </select>
                                </div> -->
                                <div class="col-lg-6 borderSelect2">
                                    <label for="inputZip" class="fw6">Kinh nghiệm làm việc </label>
                                    <select class="form-control select2" name='experience_id'>
                                        <?php
                                        $experience = \App\Entity\Experience::getAllEx();
                                        ?>
                                        <option value="0" selected>Không yêu cầu</option>
                                        @foreach ($experience as $ex)

                                            <option value="{{ $ex->experience_id }}">{{ $ex->experience_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Giới thiệu bản thân </h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <textarea class="editor" id="content" name="information" placeholder="Bố, mẹ, lãnh đạo cty cũ" cols="80" rows="10">

                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <!-- <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tags <i>(mỗi tag cách nhau bằng dấu ,)</i></label>
                                <input type="text" class="form-control" name="tags" placeholder="Ví dụ: cntt, kỹ thuật, ..." value="{{old('tags')}}" >
                            </div>
                        </div>
                    </div> -->

                    {{--<div class="box box-primary boxCateScoll">--}}
                        {{--<div class="box-header with-border">--}}
                            {{--<h3 class="box-title">Ngành nghề</h3>--}}
                        {{--</div>--}}

                        {{--<div class="box-body scrollGroup scrollGroup">--}}
                            {{--<input type="text" placeholder="Ngành nghề" aria-label="Ngành nghề" class="form-control"--}}
                                   {{--style="margin-bottom: 2%" id="career">--}}
                            {{--<div class="form-group" id="careerList">--}}
                                {{--@foreach($careers as $career)--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label>--}}
                                            {{--<input class="flat-red" type="radio" name=careers" value="{{$career->career_category_id}}"--}}
                                                {{--{{$career->career_category_id === old('careers') ? 'checked' : ''}}--}}
                                            {{-->--}}
                                            {{--{{$career->career_category_name}}--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--@endforeach--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <!-- <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Trạng thái đi làm</label>
                                <select class="form-control select2" name="status">
                                    <option value="0" {{old('status') === 0 ? 'selected' : ''}}>Chưa đi làm</option>
                                    <option value="1" {{old('status') === 1 ? 'selected' : ''}}>Đã đi làm</option>
                                    <option value="2" {{old('status') === 2 ? 'selected' : ''}}>Đã nộp cv</option>
                                    <option value="3" {{old('status') === 3 ? 'selected' : ''}}>Đã nghỉ làm</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nhân viên phụ trách</label>
                                <select class="form-control select2" name="user_id" id="staff">
                                    <option value="0">-- Chọn nhân viên phụ trách --</option>
                                    @foreach($staffInCharges as $staff)
                                        <option value="{{$staff->id}}"
                                        {{$staff->id === old('user_id') ? 'selected' : ''}}
                                        >{{$staff->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="detail">
                                <?php $oldStaff = \App\Entity\User::where('id',old('user_id'))->first() ?>
                                <label>Họ và tên : {{ !empty($oldStaff) ? $oldStaff->name : ''}}</label>
                                <p>Địa chỉ : {{!empty($oldStaff) ? $oldStaff->address : ''}}</p>
                                <p>Hotline : {{!empty($oldStaff) ? $oldStaff->phone : ''}}</p>
                                <p>Email : {{!empty($oldStaff) ? $oldStaff->email : ''}}</p>
                            </div>
                        </div>
                    </div>
 -->
                    <!-- <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hỗ trợ Seo</h3>
                        </div>

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ title</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" value="{{old('meta_title')}}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <input type="text" class="form-control" name="meta_description" placeholder="Thẻ description" value="{{old('meta_description')}}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" value="{{old('meta_keyword')}}"/>
                            </div>
                        </div>
                    </div> -->

                    <div class="box box-primary">
                        <!-- Đoạn này làm bằng ajax để lưu thông tin ghi chú -->
                        <div class="box-header"><h3 class="box-title">Thông tin CSKH</h3></div>
                        <div class="box-body">
                            <div class="form-group" id="noteContent">
                            </div>
                            <div class="form-group">
                                <label>Ghi chú</label>
                                <textarea rows="4" class="form-control" name="note"
                                          id="note-employee" placeholder="Ghi chú"></textarea>

                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="note">Ghi</button>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Lưu lại</button>
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
                        content : $('#note-employee').val()
                    },
                    success: function (data) {
                        $('#noteContent').html(data);
                        $('#note-employee').val('')
                    }
                });
            });

            $('#note-employee').keypress(function (event) {
                if((event.keyCode ? event.keyCode : event.which) == 13){
                    $.ajax({
                        url: '{{route('note-employee')}}',
                        method: 'GET',
                        data: {
                            content : $(this).val()
                        },
                        success: function (data) {
                            $('#noteContent').html(data);
                            $('#note-employee').val('')
                        }
                    });
                }
            });

            $('#career').keyup(function () {
                if($(this).val() == ''){
                    $.ajax({
                        url: '{{route('ajax-career-list')}}',
                        type: 'GET',
                        data:{

                        },
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