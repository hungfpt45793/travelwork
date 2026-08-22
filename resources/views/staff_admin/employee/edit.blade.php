@extends('staff_admin.layouts.master')

@section('title', 'Cập nhật ứng viên' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employee')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <form class="custom-form" role="form" action="{{ route('staff_employee.update',['employee_id'=>$employee->employee_id]) }}" method="POST">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <div class="col-xs-12 col-md-12">
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
                                            <input type="text" class="form-control" name="employee_name" placeholder="Họ và tên ứng viên" value="{{ $employee->employee_name }}" >
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email (đăng nhập)</label>
                                            <input type="email" class="form-control" name="email" placeholder="Email đăng nhập" value="{{ $employee->email }}" readonly >
                                        </div>

                                        <div class="form-group">

                                            <input type="checkbox" name="is_change_password" value="1" class="flat-red"> Chọn nếu muốn thay đổi mật khẩu
                                            <br>
                                            <label for="exampleInputEmail1">Mật khẩu</label>
                                            <input type="password" class="form-control" name="password" placeholder="Mật khẩu" value="{{ isset($staffInCharges->password) ? $staffInCharges->password :'' }}" />
                                        </div>


                                    </div>
                                    <div class="col-xs-12 col-md-6">



                                        <div class="form-group" style="    margin-bottom: 20px;">
                                            <label for="exampleInputEmail1" style="display: block">Giới tính yêu cầu</label>

                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input flat-red" type="radio" name="gender" id="exampleRadios2"
                                                       value="1" @if($employee->gender == 1) checked @endif style="width: 18px;height: 18px;">
                                                <label class="form-check-label" for="exampleRadios2">
                                                    Nữ
                                                </label>
                                            </div>
                                            <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                <input class="form-check-input flat-red" type="radio" name="gender" id="exampleRadios3"
                                                       value="2" @if($employee->gender == 2) checked @endif>
                                                <label class="form-check-label" for="exampleRadios3">
                                                    Nam
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ngày sinh</label>
                                            <input type="date" class="form-control" value="{{$employee->date }}" name="birthday" />
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Chứng minh thư nhân dân</label>
                                            <input type="text" class="form-control" value="{{ $employee->cmt }}" name="cmt" placeholder="Chứng minh thư nhân dân" />
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ngày cấp chứng minh thư</label>
                                            <input type="date" class="form-control" value="{{ $employee->cmt_date }}" name="cmt_date" placeholder="Chứng minh thư nhân dân" />
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Số điện thoại</label>
                                            <input type="number" class="form-control" name="phone" placeholder="Số điện thoại" value="{{ $employee->phone }}" >
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tình trạng hôn nhân</label>
                                            <select class="form-control select22" name="marry">
                                                <option value="0" {{$employee->marry == 0 ? 'selected' : ''}}>Độc thân</option>
                                                <option value="1" {{$employee->marry == 1 ? 'selected' : ''}}>Đã kết hôn</option>
                                            </select>
                                        </div>



                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nơi cấp chứng minh thư</label>
                                            <select class="form-control select22" name="cmt_local" aria-label="Tỉnh/Thành phố" id="">
                                                <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                    <option value="{{$province->province_id}}"
                                                            {{ $province->province_id == $employee->cmt_local ? 'selected' : '' }}
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
                                                <select class="form-control select22" name="province" aria-label="Tỉnh/Thành phố" id="province">
                                                    <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                        <option value="{{$province->province_id}}"
                                                                {{ $province->province_id == $employee->province ? 'selected' : '' }}
                                                        >{{$province->province_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Quận/Huyện</label>
                                                <select class="form-control select22" name="district" aria-label="Quận/Huyện" id="district">
                                                    <option value="0">-- Chọn Quận/Huyện --</option>
                                                    @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                        <option value="{{$district->district_id}}"
                                                                {{ $district->district_id == $employee->district ? 'selected' : '' }}
                                                        >{{$district->district_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Địa chỉ thường trú</label>
                                    <input type="text" class="form-control" name="address" placeholder="Địa chỉ thường trú" value="{{ $employee->address }}" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Logo</label><br>
                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                           size="20"/>
                                    <img src="{{$employee->employee_image}}" width="80" height="70"/>
                                    <input name="image" type="hidden" value="{{$employee->employee_image}}"/>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <div class="box-footer mb-3">
                            <button type="submit" class="btn btn-primary">Lưu lại</button>
                        </div>
                    </div>
                </form>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
<script>
     $(function(){
        $('#province').change(function () {
                $.get('/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });
    })
</script>
@endsection
