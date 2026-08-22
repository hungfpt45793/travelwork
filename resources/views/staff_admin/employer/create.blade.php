@extends('staff_admin.layouts.master')

@section('title', 'Thêm mới nhà tuyển dụng' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employer')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                @if (session('error'))
                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                    <div class="alert alert-danger mg-b-0 " role="alert">
                        {{ session('error') }}
                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                    </div>
                </div>
                @endif
                @if (session('success'))
                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                    <div class="alert alert-success mg-b-0 ">
                        {{session('success')}}
                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                    </div>
                </div>
                @endif
                <form class="custom-form" action="{{ route('staff_employer.store') }}" method="POST">
                    <div class="contentJobsInteresting pd15 col-f14">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <h4>Thông tin doanh nghiệp</h4>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="employer_name">Tên doanh nghiệp</label>
                                    <input type="text" class="form-control" id="employer_name"
                                        placeholder="Tên doanh nghiệp" name="employer_name">
                                    @if ($errors->has('employer_name'))
                                    <span class="text-danger">{{ $errors->first('employer_name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="number" class="form-control" id="phone" placeholder="Số điện thoại"
                                        name="phone">
                                    @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email đăng nhập</label>
                                    <input type="email" class="form-control" id="email" placeholder="Email đăng nhập"
                                        name="email">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="pasword">Mật khẩu (Đăng nhập)</label>
                                    <input type="pasword" class="form-control" id="pasword"
                                        placeholder="Mật khẩu (Đăng nhập)" name="password">
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Logo</label><br>
                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                        size="20" />
                                    <img src="" width="80" height="70" />
                                    <input name="image" type="hidden" value="" />
                                </div>
                                <!--thông tin ứng viên  -->
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="province">Tỉnh/Thành phố</label>
                                            <select class="js-example-basic-single form-control select22" id="province"
                                                name="province">
                                                <option value="">--Chọn Tỉnh/Thành phố--</option>
                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as
                                                $province)
                                                <option value="{{$province->province_id}}"
                                                    {{$province->province_id == old('province') ? 'selected' : ''}}>
                                                    {{$province->province_name}}</option>
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
                                                @foreach(\App\Entity\District::orderBy('district_name')->get() as
                                                $district)
                                                <option value="{{$district->district_id}}"
                                                    {{$district->district_id == old('district') ? 'selected' : ''}}>
                                                    {{$district->district_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">Địa chỉ chi tiết</label>
                                    <input type="text" class="form-control" id="address" placeholder="Địa chỉ chi tiết"
                                        name="address">
                                    @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select class="js-example-basic-single form-control select22" name="status">
                                        <option value="0">Chưa có nhu cầu</option>
                                        <option value="1">Có nhu cầu</option>
                                        <option value="2">Đã lên đơn hàng</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="introduction">Giới thiệu về công ty NTD</label>
                                    <textarea id="introduction" class="editor" name="introduction" cols="80" rows="10">
                                        @if ($errors->has('introduction'))
                                        <span class="text-danger">{{ $errors->first('introduction') }}</span>
                                        @endif
                                        </textarea>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<script>
$(function() {
    $('#province').change(function() {
        $.get('/ajax-district/' + $(this).val(), function(data) {
            $('#district').html(data);
        })
    });
})
</script>
@endsection