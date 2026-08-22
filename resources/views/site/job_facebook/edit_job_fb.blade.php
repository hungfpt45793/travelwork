@extends('site.layout.site')

@section('title', 'Chỉnh sửa việc làm trên Facebook')
@section('meta_description', 'Chỉnh sửa việc làm trên Facebook')
@section('keywords', 'Chỉnh sửa  việc làm trên Facebook')

@section('content')
    <section class="content bgrGray pdt5 UpdateUserTab">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_job_face') }}" class=" f18 md-f14 mgb0">Danh sách việc làm facebook</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <span href="#" class="f18 md-f14 mgb0 clorange"> Cập nhật việc làm facebook</span>

                            </li>
                        </ul>
                    </div>
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="arror bgrWhite radius5 pd5 bdLightGray textCenter">
                                        <p class="mg0 fw6 red">Để đảm bảo bản đăng tin hợp lệ, Quý khách vui lòng nhập đầy đủ thông tin </p>
                                    </div>

                                    <div class="CV bgrWhite radius5 pd20 mgt20 mgb20 pdb5">
                                        <div class="title">
                                            <h5 class="lt-f18 textUpper fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                                                SỬA TIN TUYỂN DỤNG
                                            </h5>
                                        </div>
                                        <hr class="mgt10 mgb10">
                                        <div class="supporter textCenter radius5 pd5 bdLightGray mgb40">
                                            <p class="mg0">Nếu gặp bất kỳ khó khăn nào vui lòng liên hệ Hotline hỗ trợ
                                            </p>
                                        </div>
                                        <div class="content">

                                            <form role="form" action="{{ route('job-face-user.update',['job_facebook_id'=> $jobFacebook->job_facebook_id]) }}" method="POST" class="">
                                                {!! csrf_field() !!}
                                                {{ method_field('PUT') }}
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Tên Việc Làm</label>
                                                    <input type="text" class="form-control" name="title" placeholder="Tên Việc Làm" value="{{ $jobFacebook->title }}" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Mô tả việc Làm</label>
                                                    <textarea name="content" id="editor1" rows="10" cols="80">{!!  $jobFacebook->content  !!} </textarea>

                                                    <script>   CKEDITOR.replace('editor1');</script>

                                                </div>



                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Tên Công ty</label>
                                                    <input type="text" class="form-control" name="company_name" placeholder="Tên Công ty" value="{{ $jobFacebook->company_name }}" >
                                                </div>

                                              


                                                <div class="form-group borderSelect2 row">
                                                    <div class="col-md-6">
                                                        <label for="exampleInputEmail1">Chọn ngành nghề</label>
                                                        <select class="js-example-basic-single select2 form-control " name="career_category_id">
                                                            <option value=""> -- Chọn ngành nghề --</option>
                                                            @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                                                <option value="{{$career->career_category_id}}" @if($career->career_category_id == $jobFacebook->career_category_id)  selected @endif>{{$career->career_category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('career_category_id'))
                                                            <div class="form-group">
                                                                <div class="alert alert-danger">
                                                                    <i>Vui lòng chọn ngành nghề !</i>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group borderSelect2">
                                                            <label >Mức lương</label>
                                                            <select class="js-example-basic-single select2 form-control " name="salary_id">
                                                                <option value=""> -- Chọn mức lương --</option>
                                                                @foreach($salaries as $salary)
                                                                    <option value="{{$salary->salary_id}}"
                                                                            @if($salary->salary_id == $jobFacebook->salary_id)  selected @endif
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
                                                    </div>

                                                </div>






                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group borderSelect2">
                                                            <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                                            <select class="form-control select2 " name="province" aria-label="Tỉnh/Thành phố" id="city">
                                                                <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                                    <option value="{{$province->province_id}}"
                                                                            @if($province->province_id == $jobFacebook->province)  selected @endif
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
                                                                            @if($district->district_id == $jobFacebook->district)  selected @endif
                                                                    >{{$district->district_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Địa chỉ cụ thể</label>
                                                    <input type="text" class="form-control" name="address" placeholder="Địa chỉ cụ thể" value="{{ isset($jobFacebook->address) ? $jobFacebook->address  : '' }}" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email nhận hồ sơ</label>
                                                    <input type="text" class="form-control" name="email" placeholder="Email nhận hồ sơ" value="{{ isset($jobFacebook->email) ? $jobFacebook->email  : '' }}" >
                                                </div> <div class="form-group">
                                                    <label for="exampleInputEmail1">SĐT liên hệ</label>
                                                    <input type="text" class="form-control" name="phone" placeholder="SĐT liên hệ" value="{{ isset($jobFacebook->phone) ? $jobFacebook->phone  : '' }}" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Thông tin tham khảo)</label>

                                                    <textarea name="job_info_contact" class="editor" id="editor2" rows="10" cols="80">{!!  $jobFacebook->job_info_contact !!}</textarea>



                                                    {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                                                </div>
                                                <div class="form-group">
                                                    <!-- Google reCaptcha -->
                                                    <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                                    <!-- End Google reCaptcha -->
                                                </div>
                                                @if ($errors->has('g-recaptcha-response'))
                                                    <div class="form-group">
                                                        <div class="alert alert-danger">
                                                            <i>Vui lòng xác minh tôi không phải người máy !</i>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btnOrange">Lưu thay đổi </button>
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