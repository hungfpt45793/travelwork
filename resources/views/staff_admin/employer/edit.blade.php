@extends('staff_admin.layouts.master')

@section('title', 'Danh sách nhà tuyển dụng' )

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
                <form class="custom-form" action="{{ route('employer_update_with_staff_admin',['employer_id'=>$employer->employer_id]) }}" method="POST">
                    <div class="contentJobsInteresting pd15 col-f14">
                        <div class="row">
                            <div class="col-md-12 col-xs-12 box-body">
                                <h4>Thông tin doanh nghiệp</h4>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên doanh nghiệp</label>
                                    <input type="text" class="form-control" name="employer_name" placeholder="Tên doanh nghiệp"
                                           value="{{$employer->enterprise_name}}" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số điện thoại</label>
                                    <input type="number" class="form-control" name="phone" placeholder="Số điện thoại"
                                           value="{{$employer->phone}}" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email(đăng nhập)</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email"
                                           value="{{$employer->email}}" readonly>
                                </div>
                                <div class="form-group">

                                    <input type="checkbox" name="is_change_password" value="1" class="flat-red"> Chọn nếu muốn thay đổi mật khẩu
                                    <br>
                                    <label for="exampleInputEmail1">Mật khẩu</label>
                                    <input type="password" class="form-control" name="password" placeholder="Mật khẩu" value="{{ isset($staffCharge->password) ? $staffCharge->password :'' }}" />
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Địa chỉ</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                                <select class="form-control select22" name="province" aria-label="Tỉnh/Thành phố" id="province">
                                                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                        <option value="{{$province->province_id}}"
                                                        {{$province->province_id == $employer->province ? 'selected' : ''}}>{{$province->province_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Quận/Huyện</label>
                                                <select class="form-control select22" name="district" aria-label="Quận/Huyện" id="district">
                                                    <option value="">-- Chọn Quận/Huyện --</option>
                                                    @foreach(\App\Entity\District::where('province_id', $employer->province)->orderBy('district_name')->get() as $district)
                                                        <option value="{{$district->district_id}}"
                                                        {{$district->district_id == $employer->district ? 'selected' : ''}}>{{$district->district_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Địa chỉ chi tiết</label>
                                    <input type="text"  id="location-input" class="form-control" name="address" placeholder="Địa chỉ chi tiết" value="{{$employer->address}}" >

                                    <input type="text" id='lat' name='latitude' value="" class="form-control mgb10" style="display:none" placeholder="">
                                    <input type="text" id='lng' name='longitude' value=""  class="form-control mgb10" style="display:none" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Trạng thái</label>
                                    <select class="form-control select22" name="status" aria-label="Trạng thái">
                                        <option value="0" {{$employer->status == 0 ? 'selected' : ''}}>Chưa có nhu cầu</option>
                                        <option value="1" {{$employer->status == 1 ? 'selected' : ''}}>Có nhu cầu</option>
                                        <option value="2" {{$employer->status == 2 ? 'selected' : ''}}>Đã lên đơn hàng</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giới thiệu về công ty NTD</label>
                                    <textarea class="editor" id="content" name="introduction" rows="10" cols="80"/>{{$employer->introduction}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Logo</label><br>
                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                           size="20"/>
                                    <img src="{{$employer->image}}" width="80" height="70"/>
                                    <input name="image" type="hidden" value="{{$employer->image}}"/>
                                </div>
                                <!--thông tin ứng viên  -->
                                <button type="submit" class="btn btn-primary">Lưu</button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
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
