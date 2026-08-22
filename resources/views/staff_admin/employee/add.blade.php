@extends('staff_admin.layouts.master')

@section('title', 'Thêm mới ứng viên' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employee')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <form class="custom-form" action="{{ route('staff_employee.store') }}" method="POST">
                    <div class="contentJobsInteresting pd15 col-f14">
                        <h5 class="text-info">Thêm mới ứng viên</h5>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group">
                                    <label for="employee_name">Họ và tên ứng viên</label>
                                    <input type="text" class="form-control" id="employee_name"
                                        placeholder="Họ và tên ứng viên" name="employee_name"
                                        >

                                    @if ($errors->has('employee_name'))
                                    <span class="text-danger">{{ $errors->first('employee_name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email đăng nhập</label>
                                    <input type="email" class="form-control" id="email" placeholder="Email đăng nhập"name="email">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password">Mật khẩu (Đăng nhập)</label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Mật khẩu (Đăng nhập)" name="password">
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="sex">Giới tính</label>
                                            <div id="sex" style="display:flex;justify-content: left;">
                                                <div class="form-check mgr20">
                                                    <input class="form-check-input" value="0" type="radio" id="male"
                                                        name="gender">
                                                    <label class="form-check-label" for="male">
                                                        Nam
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="1" type="radio" id="female"
                                                        name="gender">
                                                    <label class="form-check-label" for="female">
                                                        Nữ
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Điện thoại</label>
                                            <input type="number" class="form-control" id="phone" name="phone">
                                            @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="birthday">Ngày sinh</label>
                                            <input type="date" class="form-control" id="birthday" name="birthday">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="marry">Tình trạng hôn nhân</label>
                                            <select class="js-example-basic-single form-control select22" id="marry"
                                                name="marry">
                                                <option value="0">Độc thân</option>
                                                <option value="1">Đã kết hôn</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="cmt">Chứng minh thư nhân dân</label>
                                            <input type="text" class="form-control" id="cmt" name="cmt">
                                            @if ($errors->has('cmt'))
                                            <span class="text-danger">{{ $errors->first('cmt') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="cmt_local">Nơi cấp chứng minh thư</label>
                                            <select class="js-example-basic-single form-control select22" id="cmt_local"
                                                name="cmt_local">
                                                <option value="">--Chọn Tỉnh/Thành phố--</option>
                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                    <option value="{{$province->province_id}}"
                                                    >{{$province->province_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="cmt_date">Ngày cấp chứng minh thư nhân dân</label>
                                            <input type="date" class="form-control" id="cmt_date" name="cmt_date">
                                            @if ($errors->has('cmt_date'))
                                            <span class="text-danger">{{ $errors->first('cmt_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="province">Tỉnh/Thành phố</label>
                                            <select class="js-example-basic-single form-control select22" id="province"
                                                name="province">
                                                <option value="">--Chọn Tỉnh/Thành phố--</option>
                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                        <option value="{{$province->province_id}}"
                                                        >{{$province->province_name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="district">Quận/huyện</label>
                                            <select class="js-example-basic-single form-control select22" id="district"
                                                name="district">
                                                <option value="">--Chọn Quận/huyện--</option>
                                                @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                        <option value="{{$district->district_id}}"
                                                        >{{$district->district_name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">Địa chỉ thường trú</label>
                                    <input type="text" class="form-control" id="address"
                                        placeholder="Địa chỉ thường trú" name="address"

                                        >
                                    @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Logo</label><br>
                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                           size="20"/>
                                    <img src="" width="80" height="70"/>
                                    <input name="image" type="hidden" value=""/>
                                </div>
                                <!--thông tin ứng viên  -->
                                <button type="submit" class="btn btn-primary">Lưu lại</button>
                            </div>
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
