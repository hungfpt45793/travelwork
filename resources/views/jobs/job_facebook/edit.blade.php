@extends('admin.layout.admin')
@section('title', 'Chỉnh sửa việc làm '.$jobFacebook->title.'từ Facebook')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa việc làm {{ $jobFacebook->title }} từ Facebook
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Chỉnh sửa việc làm {{ $jobFacebook->title }} từ Facebook</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form"
                  action="{{ route('job-facebook.update', ['job_facebook_id' => $jobFacebook->job_facebook_id]) }}"
                  method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung tuyển dụng</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên Việc Làm</label>
                                <input type="text" class="form-control" name="title" placeholder="Tên Việc Làm"
                                       value="{{ $jobFacebook->title }}" required>
                            </div>

                            {{--<div class="form-group">--}}
                            {{--<label for="exampleInputEmail1">Mô Tả Việc Làm</label>--}}
                            {{--<textarea style="padding: 10px" class="w100" id="" name="des_facebook" rows="4" cols="80" />{{ $jobFacebook->des_facebook }}</textarea>--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung tin tuyển dụng</label>
                                <textarea class="editor" id="content" name="content" rows="5"
                                          cols="80"/>{!! $jobFacebook->content !!}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thông tin tham khảo</label>
                                <textarea name="job_info_contact" class="editor" id="editor2" rows="10" cols="80">{!!  $jobFacebook->job_info_contact !!}</textarea>
                                {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                            </div>

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
                                        <?php
                                        if (!empty($jobFacebook->employer_id)) {
                                            $employer = \App\Entity\Employer::getIdemployer($jobFacebook->employer_id);
                                        }
                                        ?>
                                        <select class="form-control select2" name="employer_id">
                                            <option value="" selected> -- Chọn nhà tuyển dụng --</option>
                                            @if(!empty($jobFacebook->employer_id))
                                                @foreach($employers as $emp)
                                                    <option value="{{$emp['employer_id']}}"
                                                            @if($employer->employer_id == $emp['employer_id']) selected @endif>
                                                        {{ isset($emp['enterprise_name']) ? $emp['enterprise_name'] : '' }}</option>
                                                @endforeach
                                            @else
                                                @foreach($employers as $emp)
                                                    <option value="{{$emp['employer_id']}}"
                                                    >
                                                        {{ isset($emp['enterprise_name']) ? $emp['enterprise_name'] : '' }}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="js-example-basic-single select2" name="career_category_id">
                                    <option value=""> -- Chọn ngành nghề --</option>
                                    @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                        <option value="{{$career->career_category_id}}" {{ $career->career_category_id == $jobFacebook->career_category_id ? 'selected' : ''}}>{{$career->career_category_name}}</option>
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

                            <div class="form-group">
                                <label>Mức lương</label>
                                <select class="form-control " name="salary_id">
                                    <option value=""> -- Chọn mức lương --</option>
                                    @foreach($salaries as $salary)
                                        <option value="{{$salary->salary_id}}"
                                                {{$salary->salary_id == $jobFacebook->salary_id ? 'selected' : ''}}
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




                            <div class="form-group">
                                <label for="exampleInputEmail1">Email nhận hồ sơ</label>
                                <input type="text" class="form-control" name="email" placeholder="Email nhận hồ sơ"
                                       value="{{ $jobFacebook->email }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">SĐT nhận hồ sơ</label>
                                <input type="text" class="form-control" name="phone" placeholder="SĐT nhận hồ sơ"
                                       value="{{ $jobFacebook->phone }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên công ty tuyển dụng</label>
                                <input type="text" class="form-control" name="company_name" placeholder="Tên công ty tuyển dụng"
                                       value="{{ $jobFacebook->company_name }}">
                            </div>

                            {{--<div class="form-group">--}}
                            {{--<label for="exampleInputEmail1">Địa chỉ</label>--}}
                            {{--<input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $jobFacebook->address }}" >--}}
                            {{--</div>--}}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                        <select class="form-control select2" name="province" aria-label="Tỉnh/Thành phố"
                                                id="city">
                                            <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                <option value="{{$province->province_id}}"
                                                        {{$province->province_id == $jobFacebook->province ? 'selected' : ''}}
                                                >{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Quận/Huyện</label>
                                        <select class="form-control select2" name="district" aria-label="Quận/Huyện"
                                                id="county">
                                            <option value="0">-- Chọn Quận/Huyện --</option>
                                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                <option value="{{$district->district_id}}"
                                                        {{$district->district_id == $jobFacebook->district ? 'selected' : ''}}
                                                >{{$district->district_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ</label>
                                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $jobFacebook->address }}" >
                                    </div>

                                </div>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Báo tin sai</label>
                                <input type="text" class="form-control" name="warning_job_fb" placeholder="Email"
                                       value="{{ $jobFacebook->warning_job_fb }}">
                            </div>

                                <div class="form-group">
                                    <label style="margin-right: 20px">
                                        <input type="radio" name="vip" class="flat-red" value="0" @if($jobFacebook->vip == 0) checked @endif  >
                                        Tin thường
                                    </label>
                                    <label>
                                        <input type="radio" name="vip" class="flat-red" value="1" @if($jobFacebook->vip == 1) checked @endif>
                                        Tin víp
                                    </label>

                                </div>

                            <div class="form-group">
                                <?php
                                $date_submit = date_create($jobFacebook['created_at']);
                                $date_end = date_create($jobFacebook['date_end']);

                                ?>
                                <label for="exampleInputEmail1">Thời gian đăng tin</label>
                                <input type="date" id="start" name="created_at"
                                       value="{{ date_format($date_submit, "Y-m-d") }}">
                            </div>
                            <div class="form-group">

                                <label for="exampleInputEmail1">Hạn đăng tin</label>
                                <input type="date" id="start" name="date_end"
                                       value="{{ date_format($date_end, "Y-m-d") }}">
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Cập nhật công việc</button>
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