@extends('site.layout.site')

@section('title', 'Việc làm trên Facebook')
@section('meta_description', 'Việc làm trên Facebook')
@section('keywords', 'Việc làm trên Facebook')

@section('content')
    <section class="content bgrGray pdt5 UpdateUserTab">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="arror bgrWhite radius5 pd5 bdLightGray textCenter">
                                        <p class="mg0 fw6 red">Để đảm bảo bản đăng tin hợp lệ, Quý khách vui lòng nhập đầy đủ thông tin </p>
                                    </div>
                                    <div class="CV bgrWhite radius5 pd20 mgt20 mgb20 pdb5">
                                        <a href="{{ route('getAllUser') }}" class="btnOrange mgb15 d-sm-inline-block">Danh sách tin tuyển dụng đã tạo</a>
                                        <div class="title">
                                            <h5 class="f20 fw6 bdLeftBlueN5x pdl10 blueN mgb0">
                                                Tạo tin tuyển dụng facebook
                                            </h5>
                                        </div>
                                        <hr class="mgt10 mgb10">
                                        <div class="supporter textCenter radius5 pd5 bdLightGray mgb40">
                                            <p class="mg0">Nếu gặp bất kỳ khó khăn nào vui lòng liên hệ Hotline hỗ trợ
                                            </p>
                                        </div>
                                        <div class="content">
                                            @if(!empty($errors->all()))
                                                @foreach($errors->all() as $erorr)
                                                    <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                                @endforeach
                                            @endif
                                            <form role="form" action="{{ route('job-face-user.store') }}" method="POST" class="">
                                                {!! csrf_field() !!}
                                                {{ method_field('POST') }}
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Tên Việc Làm</label>
                                                    <input type="text" class="form-control" name="title" placeholder="Tên Việc Làm" value="{{old('title')}}" >
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Mô tả việc Làm</label>

                                                    <textarea name="content" class="editor" id="editor1" rows="10" cols="80">{!!  old('content') !!}</textarea>



                                                    {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Tên Công ty</label>
                                                    <input type="text" class="form-control" name="company_name" placeholder="Tên Công ty" value="{{old('company_name')}}" >
                                                </div>

                                                {{--<div class="form-group">--}}
                                                    {{--<label for="exampleInputEmail1">Phúc lợi xã hội</label>--}}

                                                    {{--<textarea name="welfare" class="editor" id="editor_welfare" rows="10" cols="80">{!!  old('welfare') !!}</textarea>--}}



                                                    {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                                                {{--</div>--}}

                                                <div class="form-group borderSelect2 row">
                                                    <div class="col-md-6">
                                                        <label for="exampleInputEmail1">Chọn ngành nghề</label>
                                                        <select class="js-example-basic-single select2 form-control " name="career_category_id">
                                                            <option value=""> -- Chọn ngành nghề --</option>
                                                            @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                                                <option value="{{$career->career_category_id}}"
                                                                        @if($career->career_category_id == old('career_category_id')) selected @endif
                                                                >{{$career->career_category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group borderSelect2">
                                                            <label >Mức lương</label>
                                                            <select class="js-example-basic-single select2 form-control " name="salary_id">
                                                                <option value=""> -- Chọn mức lương --</option>
                                                                @foreach($salaries as $salary)
                                                                    <option value="{{$salary->salary_id}}"
                                                                            {{$salary->salary_id == old('salary') ? 'selected' : ''}}

                                                                    >{{$salary->description}}</option>
                                                                @endforeach
                                                            </select>


                                                        </div>
                                                    </div>

                                                </div>






                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group borderSelect2">
                                                            <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                                            <select class="form-control select2 " name="province" aria-label="Tỉnh/Thành phố" id="city">
                                                                <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                                                @foreach(\App\Entity\Province::getAllProvince() as $province)
                                                                    <option value="{{$province->province_id}}"
                                                                            {{$province->province_id == old('province') ? 'selected' : ''}}
                                                                    >{{$province->province_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group borderSelect2">
                                                            <label for="exampleInputEmail1">Quận/Huyện</label>
                                                            <select class="form-control select2 " name="district" aria-label="Quận/Huyện" id="county">
                                                                <option value="0">-- Chọn Quận/Huyện --</option>
                                                                @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                                    <option value="{{$district->district_id}}"
                                                                            {{$district->district_id == old('district') ? 'selected' : ''}}
                                                                    >{{$district->district_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Địa chỉ cụ thể</label>
                                                    <input type="text" class="form-control" name="address" placeholder="Địa chỉ cụ thể" value="{{old('address')}}" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email nhận hồ sơ</label>
                                                    <input type="text" class="form-control" name="email" placeholder="Email nhận hồ sơ" value="{{old('email')}}" >
                                                </div> <div class="form-group">
                                                    <label for="exampleInputEmail1">SĐT liên hệ</label>
                                                    <input type="text" class="form-control" name="phone" placeholder="SĐT liên hệ" value="{{old('phone')}}" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Thông tin tham khảo (Cập nhật địa chỉ , thông tin  website công ty)</label>

                                                    <textarea name="job_info_contact" class="editor" id="editor2" rows="10" cols="80">{!!  old('job_info_contact') !!}</textarea>



                                                    {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                                                </div>
                                                <div class="form-group">
                                                    <!-- Google reCaptcha -->
                                                    <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                                    <!-- End Google reCaptcha -->
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btnOrange">Lưu công việc</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </section>

                    @include('site.module_index.dang-ky-tu-van')

                </div>
            </div>
            @include('site.module_index.hotline')
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