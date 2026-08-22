@extends('admin.layout.admin')

@section('title', 'Cập nhật nhà tuyển dụng' . $employer->enterprise_name)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật nhà tuyển dụng {{$employer->enterprise_name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Nhà tuyển dụng</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('employer.update',['employer_id'=>$employer->employer_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
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
                            <h3 class="box-title">Thông tin doanh nghiệp</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputEmail1">Mã doanh nghiệp</label>--}}
                                {{--<input type="text" class="form-control" name="enterprise_id" placeholder="Mã doanh nghiệp"--}}
                                       {{--value="{{isset($employer->employer_id) ? $employer->employer_id : $employer->id }}" >--}}
                            {{--</div>--}}

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
                                            <select class="form-control select2" name="province" aria-label="Tỉnh/Thành phố" id="province">
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
                                            <select class="form-control select2" name="district" aria-label="Quận/Huyện" id="district">
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
                                <select class="form-control select2" name="status" aria-label="Trạng thái">
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
                                <img class="lazy" src="{{$employer->image}}" width="80" height="70"/>
                                <input name="image" type="hidden" value="{{$employer->image}}"/>
                            </div>

                            <div class="form-group">
                                <label for="inputAddress2" class="fw6">Hình ảnh công ty : <span
                                            class="red">(*)</span></label>

                                <div class="form-group">
                                    <label>Danh sách hình ảnh</label>
                                    <input type="button" onclick="return openKCFinder(this);" value="Chọn ảnh"
                                           size="20"/>

                                    <div class="images_list">
                                        @if(!empty($employer->images_list))
                                            @foreach(explode(',',$employer->images_list) as $image)
                                                <img class="lazy" src="{{$image}}" width="80" height="" style="margin-left: 10px; margin-bottom: 5px;"/>
                                            @endforeach
                                        @endif
                                    </div>
                                    <input name="images_list" type="hidden" value="{{$employer->images_list}}"/>


                                </div>


                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cổng thực tập</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body ">
                            <div class="form-group">
                                <label style="margin-right: 10px">
                                    <input type="radio" name="status_intership" value="0"
                                           class="flat-red" @if($employer->status_intership == 0)checked @endif>
                                    Không tuyển thực tập
                                </label>
                                <label>
                                    <input type="radio" name="status_intership" value="1"
                                           class="flat-red" @if($employer->status_intership == 1)checked @endif>
                                    Đang tuyển thực tập
                                </label>
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Banner tuyển thực tập</label><br>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img class="lazy" src="{{$employer->banner_intership}}" width="80" height=""/>
                                <input name="banner_intership" type="hidden" value="{{$employer->banner_intership}}"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả thực tập</label><br>
                                <textarea rows="4" class="form-control" name="des_intership"
                                          placeholder="">{{ isset($employer->des_intership) ?$employer->des_intership : '' }}</textarea>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung thực tập</label>
                                <textarea class="editor" id="content2_intership" name="content_intership" rows="10" cols="80"/>{!! isset($employer->content_intership) ? $employer->content_intership : ''  !!}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nhà tuyển dụng Víp</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body ">
                            <div class="form-group">
                                <label style="margin-right: 10px">
                                    <input type="radio" name="employer_vip" value="0"
                                           class="flat-red" @if($employer->employer_vip == 0)checked @endif>
                                    Không Víp
                                </label>
                                <label>
                                    <input type="radio" name="employer_vip" value="1"
                                           class="flat-red" @if($employer->employer_vip == 1)checked @endif>
                                    Víp
                                </label>
                            </div>



                        </div>
                    </div>

                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Phụ cấp</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body ">
                            <div class="form-group">
                                <label style="margin-right: 10px">
                                    <input type="radio" name="status_allowance" value="0"
                                           class="flat-red" @if($employer->status_allowance == 0)checked @endif>
                                    Không có phụ câp
                                </label>
                                <label>
                                    <input type="radio" name="status_allowance" value="1"
                                           class="flat-red" @if($employer->status_allowance == 1)checked @endif>
                                    Có phụ cấp
                                </label>
                            </div>



                        </div>
                    </div>

                    {{--<div class="box box-primary">--}}
                        {{--<div class="box-header with-border">--}}
                            {{--<h3 class="box-title">Thông tin người đại diện</h3>--}}
                        {{--</div>--}}
                        {{--<div class="row">--}}
                            {{--@if($representatives->count() == 1)--}}
                                {{--@foreach($representatives as $representative)--}}
                                {{--<div class="col-md-6" style="border-right: 2px solid">--}}
                                    {{--<div class="box-body">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="exampleInputEmail1">Họ và tên</label>--}}
                                            {{--<input type="text" class="form-control" name="representative_name_1" placeholder="Họ và tên"--}}
                                                   {{--value="{{$representative->representative_name}}" >--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label for="exampleInputEmail1">Số điện thoại</label>--}}
                                            {{--<input type="text" class="form-control" name="phone_number_1" placeholder="Số điện thoại"--}}
                                                   {{--value="{{$representative->phone}}" >--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label for="exampleInputEmail1">Email</label>--}}
                                            {{--<input type="email" class="form-control" name="representative_email_1" placeholder="Email"--}}
                                                    {{--value="{{$representative->email}}" >--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label for="exampleInputEmail1">Địa chỉ</label>--}}
                                            {{--<input type="text" class="form-control" name="representative_address_1" placeholder="Địa chỉ"--}}
                                                   {{--value="{{$representative->address}}" >--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group" style="color: red;">--}}
                                            {{--@if ($errors->has('title'))--}}
                                                {{--<label for="exampleInputEmail1">{{ $errors->first('title') }}</label>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--@endforeach--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<div class="box-body">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="exampleInputEmail1">Họ và tên</label>--}}
                                            {{--<input type="text" class="form-control" name="representative_name_2" placeholder="Họ và tên">--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label for="exampleInputEmail1">Số điện thoại</label>--}}
                                            {{--<input type="text" class="form-control" name="phone_number_2" placeholder="Số điện thoại">--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label for="exampleInputEmail1">Email</label>--}}
                                            {{--<input type="text" class="form-control" name="representative_email_2" placeholder="Email">--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label for="exampleInputEmail1">Địa chỉ</label>--}}
                                            {{--<input type="text" class="form-control" name="representative_address_2" placeholder="Địa chỉ">--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group" style="color: red;">--}}
                                            {{--@if ($errors->has('title'))--}}
                                                {{--<label for="exampleInputEmail1">{{ $errors->first('title') }}</label>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--@else--}}
                                {{--@foreach($representatives as $representative)--}}
                                    {{--<div class="col-md-6" style="border-right: 2px solid">--}}
                                        {{--<div class="box-body">--}}
                                            {{--<div class="form-group">--}}
                                                {{--<label for="exampleInputEmail1">Họ và tên</label>--}}
                                                {{--<input type="text" class="form-control" name="representative_name_1" placeholder="Họ và tên"--}}
                                                       {{--value="{{$representative->representative_name}}" >--}}
                                            {{--</div>--}}

                                            {{--<div class="form-group">--}}
                                                {{--<label for="exampleInputEmail1">Số điện thoại</label>--}}
                                                {{--<input type="text" class="form-control" name="phone_number_1" placeholder="Số điện thoại"--}}
                                                       {{--value="{{$representative->phone}}" >--}}
                                            {{--</div>--}}

                                            {{--<div class="form-group">--}}
                                                {{--<label for="exampleInputEmail1">Email</label>--}}
                                                {{--<input type="email" class="form-control" name="representative_email_1" placeholder="Email"--}}
                                                       {{--value="{{$representative->email}}" >--}}
                                            {{--</div>--}}

                                            {{--<div class="form-group">--}}
                                                {{--<label for="exampleInputEmail1">Địa chỉ</label>--}}
                                                {{--<input type="text" class="form-control" name="representative_address_1" placeholder="Địa chỉ"--}}
                                                       {{--value="{{$representative->address}}" >--}}
                                            {{--</div>--}}

                                            {{--<div class="form-group" style="color: red;">--}}
                                                {{--@if ($errors->has('title'))--}}
                                                    {{--<label for="exampleInputEmail1">{{ $errors->first('title') }}</label>--}}
                                                {{--@endif--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="box box-primary">--}}
                        {{--<div class="box-header with-border">--}}
                            {{--<h3 class="box-title">Đánh giá</h3>--}}
                        {{--</div>--}}
                        {{--<div class="box-body">--}}
                            {{--<table class="table table-bordered">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>Ứng viên</th>--}}
                                    {{--<th>Ứng viên đánh giá</th>--}}
                                    {{--<th>Ngày đánh giá</th>--}}
                                    {{--<th>Phê duyệt</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--<tr>--}}
                                    {{--<td><i class="fa fa-star" aria-hidden="true"></i>--}}
                                        {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                                        {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                                        {{--<i class="fa fa-star-o" aria-hidden="true"></i>--}}
                                        {{--<i class="fa fa-star-o" aria-hidden="true"></i>--}}
                                    {{--</td>--}}
                                    {{--<td><div class="form-group">--}}
                                            {{--<select class="form-control">--}}
                                                {{--<option>Nguyên Văn A</option>--}}
                                                {{--<option>Nguyễn Văn B</option>--}}
                                                {{--<option>Nguyễn Văn C</option>--}}
                                            {{--</select>--}}
                                        {{--</div></td>--}}
                                    {{--<td><div class="form-group">--}}
                                            {{--<div class="input-group date">--}}
                                                {{--<div class="input-group-addon">--}}
                                                    {{--<i class="fa fa-calendar"></i>--}}
                                                {{--</div>--}}
                                                {{--<input type="text" class="form-control pull-right" id="datepicker">--}}
                                            {{--</div>--}}
                                            {{--<!-- /.input group -->--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    {{--<td style="text-align: center;"><div class="form-group">--}}
                                            {{--<label>--}}
                                                {{--<input type="checkbox" name="parents[]" value="" class="flat-red" >--}}
                                            {{--</label>--}}
                                        {{--</div></td>--}}
                                {{--</tr>--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                            {{--<br>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                    <!-- /.box -->

                </div>

                <div class="col-xs-12 col-md-4">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Loại Hình Doanh Nghiệp</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            @foreach($typeBusinessList as $typeBusiness)
                                <div class="form-group">
                                    <label>
                                        <input type="radio" name="business" value="{{$typeBusiness->type_of_business_id}}"
                                               class="flat-red" @if($typeBusiness->type_of_business_id == $employer->business) checked @endif>
                                        {{$typeBusiness->type_of_business_name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Loại Hình Kinh Doanh</h3>
                        </div>

                        <div class="box-body scrollGroup">
                            @foreach($businessList as $business)
                                <div class="form-group">
                                    <label>
                                        <input type="radio" name="type_of_business_id" value="{{$business->business_type_id}}" class="flat-red"
                                               @if($business->business_type_id == $employer->type_of_business_id) checked @endif>
                                        {{$business->business_type_name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tags <i>(mỗi tag cách nhau bằng dấu ,)</i></label>
                                <input type="text" class="form-control" name="tags" placeholder="Ví dụ: cntt, kỹ thuật, ..."
                                       value="{{$employer->tags}}" >
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nhân viên phụ trách</label>
                                <select class="form-control select2" name="user_id" id="staff">
                                    <option value="0">-- Chọn nhân viên phụ trách --</option>
                                    @foreach($staff as $user)
                                        <option value="{{$user->id}}"
                                         {{($user->id == $employer->user_id) ? 'selected' : ''}}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="detail">
								@if (isset($staffCharge))
                                <label>Họ và tên: {{$staffCharge->name}} </label>
                                <p>Địa chỉ: {{$staffCharge->address}}</p>
                                <p>Hotline: {{$staffCharge->phone}}</p>
                                <p>Email: {{$staffCharge->email}}</p>
								@endif
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hỗ trợ Seo</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ title</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" value="{{$employer->meta_title}}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <input type="text" class="form-control" name="meta_description" placeholder="Thẻ description" value="{{$employer->meta_description}}"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" value="{{$employer->meta_keyword}}"/>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>

                    <div class="box box-primary">
                        <!-- Đoạn này làm bằng ajax để lưu thông tin ghi chú -->
                        <div class="box-body">
                            @foreach(\App\Entity\NoteEmployer::where('employer_id', $employer->employer_id)->get() as $note)
                                <div class="form-group">
                                    <p>- {{$note->note}} .</p>
                                </div>
                            @endforeach
                            <div class="form-group" id="noteContent">
                            </div>
                            <div class="form-group">
                                <label>Ghi chú</label>
                                <textarea rows="4" class="form-control" name="note"
                                          id="note-employer" placeholder="Ghi chú"></textarea>

                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="note">Ghi</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="margin-right: 10px">
                            <input type="radio" name="is_admin" value="0"
                                   class="flat-red" @if($employer->is_admin == 0)checked @endif>
                            Không quản lý
                        </label>
                        <label>
                            <input type="radio" name="is_admin" value="1"
                                   class="flat-red" @if($employer->is_admin == 1)checked @endif>
                            Quản lý đăng tin facebook
                        </label>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
                    </div>
                    <!-- /.box -->
                </div>
            </form>
        </div>
    </section>
    <script type="text/javascript">
        $('#datepicker').datepicker({
            autoclose: true
        });

        var reason_row = 0;

        function addReasonRow() {
            html  = '<tr id="reason-row' + reason_row + '">';
            html += '  <td class="text-left" style="width: 90%;">';
            html += '  <div class="form-group">';
            html += '<input type="text" name="reasons[]" value="" class="form-control" placeholder="Lý do chọn chúng tôi" >'
            html += '  </div>';
            html += '  </td>';
            html += '  <td ><button type="button" onclick="$(\'#reason-row' + reason_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#reason tbody').append(html);

            reason_row++;
        }

        var endow_row = 0;
        function addEndowRow() {
            html  = '<tr id="endow-row' + endow_row + '">';
            html += '  <td class="text-left" style="width: 90%;">';
            html += '  <div class="form-group">';
            html += '<input type="text" name="endows[]" value="" class="form-control" placeholder="Chế độ đãi ngộ" >'
            html += '  </div>';
            html += '  </td>';
            html += '  <td ><button type="button" onclick="$(\'#endow-row' + endow_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#endow tbody').append(html);

            endow_row++;
        }
    </script>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#staff').change(function () {
                var staff = $(this).val();
                $.get('/admin/ajax-staff/' + staff, function (data) {
                    $('#detail').html(data);
                });
            });

            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                });
            });

            $('#note').click(function () {
                $.ajax({
                    url: '{{route('note-employer')}}',
                    method: 'GET',
                    data: {
                        content : $('#note-employer').val()
                    },
                    success: function (data) {
                        $('#noteContent').html(data);
                        $('#note-employer').val('')
                    }
                });
            });

            $('#note-employer').keypress(function (event) {
                if((event.keyCode ? event.keyCode : event.which) == 13){
                    $.ajax({
                        url: '{{route('note-employer')}}',
                        method: 'GET',
                        data: {
                            content : $(this).val()
                        },
                        success: function (data) {
                            $('#noteContent').html(data);
                            $('#note-employer').val('')
                        }
                    });
                }
            });
        })
    </script>
        <script>  
        $('#location-input').mouseout(function(e){
         geocode(e)
       })
      //  var locationForm = document.getElementById('location-form');
      //    locationForm.addEventListener('submit', geocode);
         function geocode(e){
            e.preventDefault();

            var location = document.getElementById('location-input').value;

            axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
            params:{
               address: location,
               key:'AIzaSyDfMhsscTwP4UQh0H03FhsD_FisKDO1iBo'
            }
            })
            .then(function(response){
             console.log(response);        
            // Geometry
            var lat = response.data.results[0].geometry.location.lat;
            var lng = response.data.results[0].geometry.location.lng;
            // Output to app
               document.getElementById('lat').value = lat;
               document.getElementById('lng').value = lng;
            })
            .catch(function(error){
            console.log(error);
            });
         }
      </script>

@endpush