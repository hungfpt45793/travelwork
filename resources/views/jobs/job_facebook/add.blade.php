@extends('admin.layout.admin')
@section('title', 'Thêm mới việc làm từ Facebook')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới công việc từ Facebook
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc lấy từ Facebook</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('job-facebook.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung tuyển dụng</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên Việc Làm</label>
                                <input type="text" class="form-control" name="title" placeholder="Tên Việc Làm" value="{{old('title')}}" required>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputEmail1">Mô Tả Việc Làm</label>--}}
                                {{--<textarea style="padding: 10px" class="w100" id="" name="des_facebook" rows="4" cols="80" />{{old('des_facebook')}}</textarea>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung tin tuyển dụng</label>
                                <textarea class="editor" id="content" name="content" rows="5" cols="80" />{{old('content')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Thông tin tham khảo</label>
                                <textarea name="job_info_contact" class="editor" id="editor2" rows="10" cols="80">{!!  old('job_info_contact') !!}</textarea>
                                {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                            </div>
                            {{-- từ khóa --}}
                            @php
                                foreach ($input_tags as $tag) {
                                    $tag_type = $tag['tag_type'];
                                }
                            @endphp
                            @include('admin.layout.themtukhoa')
                            {{-- END từ khóa --}}
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin bổ sung</h3>
                        </div>
                        <!-- /.box-header -->


                        <div class="box-body">
                            <div class="row detail-employer">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nhà tuyển dụng</label>

                                        <select class="form-control select2" name="employer_id">
                                            <option value="" selected> -- Chọn nhà tuyển dụng --</option>
                                            @foreach($employers as $emp)
                                                <option value="{{$emp['employer_id']}}">
                                                    {{ isset($emp['enterprise_name']) ? $emp['enterprise_name'] : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="box box-primary boxCateScoll">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Chọn ngành nghề</h3>
                                    </div>

                                    <div class="box-body scrollGroup">
                                        <div class="form-group" id="careerList">

                                                <div class="form-group">
                                                    <select class="js-example-basic-single select2" name="career_category_id">
                                                        <option value=""> -- Chọn ngành nghề --</option>
                                                        @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                                        <option value="{{$career->career_category_id}}">{{$career->career_category_name}}</option>
                                                        @endforeach
                                                    </select>


                                                    {{--<label>--}}
                                                        {{--<input type="radio" name="careers" class="flat-red" value="{{$career->career_category_id}}" >--}}
                                                        {{--{{$career->career_category_name}}--}}
                                                    {{--</label>--}}

                                                </div>
                                            @if ($errors->has('career_category_id'))
                                                <div class="form-group">
                                                    <div class="alert alert-danger">
                                                        <i>Vui lòng chọn ngành nghề !</i>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label >Mức lương</label>
                                <select class="form-control " name="salary_id">
                                    <option value=""> -- Chọn mức lương --</option>
                                    @foreach($salaries as $salary)
                                        <option value="{{$salary->salary_id}}"
                                                {{$salary->salary_id == old('salary') ? 'selected' : ''}}
                                        >{{$salary->description}}</option>
                                    @endforeach
                                </select>


                                @if ($errors->has('salary_id'))
                                    <div class="form-group">
                                        <div class="alert alert-danger">
                                            <i>Vui lòng chọn mức lương !</i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputEmail1">Tên nhà tuyển dụng</label>--}}
                                {{--<input type="text" class="form-control" name="employer" placeholder="Tên nhà tuyển dụng" value="{{old('employer')}}" >--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputEmail1">link facebook</label>--}}
                                {{--<input type="text" class="form-control" name="link" placeholder="Số điện thoại" value="{{old('link')}}" >--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputEmail1">Số diện thoại</label>--}}
                                {{--<input type="text" class="form-control" name="phone" placeholder="Số điện thoại" value="{{old('phone')}}" >--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email nhận hồ sơ</label>
                                <input type="text" class="form-control" name="email" placeholder="Email nhận hồ sơ" value="{{old('email')}}" >
                            </div>  <div class="form-group">
                                <label for="exampleInputEmail1">SDT nhận hồ sơ</label>
                                <input type="text" class="form-control" name="phone" placeholder="SĐT nhận hồ sơ" value="{{old('phone')}}" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên công ty tuyển dụng</label>
                                <input type="text" class="form-control" name="company_name" placeholder="Tên công ty tuyển dụng" value="{{old('company_name')}}" >
                            </div>

                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputEmail1">Địa chỉ</label>--}}
                                {{--<input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{old('address')}}" >--}}
                            {{--</div>--}}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                        <select class="form-control select2" name="province" aria-label="Tỉnh/Thành phố" id="city">
                                            <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                <option value="{{$province->province_id}}"
                                                        {{$province->province_id == old('province') ? 'selected' : ''}}
                                                >{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Quận/Huyện</label>
                                        <select class="form-control select2" name="district" aria-label="Quận/Huyện" id="county">
                                            <option value="0">-- Chọn Quận/Huyện --</option>
                                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                <option value="{{$district->district_id}}"
                                                        {{$district->district_id == old('district') ? 'selected' : ''}}
                                                >{{$district->district_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ</label>
                                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{old('address')}}" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label style="margin-right: 20px">
                                            <input type="radio" name="vip" class="flat-red" value="0" @if(old('vip') == 0) checked @endif @if(!old('vip')) checked @endif>
                                            Tin thường
                                        </label>
                                        <label>
                                            <input type="radio" name="vip" class="flat-red" value="1" @if(old('vip') == 1) checked @endif>
                                            Tin víp
                                        </label>

                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới công việc</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>
        <script>
            $('#city').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#county').html(data);
                });
            });
        </script>

@endsection