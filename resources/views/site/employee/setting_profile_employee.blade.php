@extends('site.layout.site')

@section('title', 'Cài đặt hồ sơ')
@section('meta_description', 'Cài đặt hồ sơ')
@section('keywords', 'Cài đặt hồ sơ')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                <script>
                    // location.reload();
                </script>
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent col-12 col-12">
                    <div class="link bgrWhite md-mgt20">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Cài đặt hồ sơ</a>
                            </li>

                        </ul>
                    </div>
                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                            <i class="fas fa-cogs mgr5"></i>Cài đặt hồ sơ
                        </div>
                        <div class="bgrWhite pd15">



                            <h5 class="lt-f20  fw7 bdLeftBlueN5x pdl10 blueN mgb0 dsInline">
                                Cài đặt hồ sơ để nhà tuyển dụng tìm kiếm
                            </h5>
                            <div class="row mgt15">
                                <div class="col-md-12">
                                    <form action="{{ route('update_setting_profile_employee') }}" method="post" class="mbformUpdateEmployee"
                                          enctype="multipart/form-data" id="form_update_user">
                                        {!! csrf_field() !!}



                                        @if(session('suscess'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert"
                                                 style="margin-top: 15px;width: 100%">
                                                <strong>{{ session('suscess') }}</strong>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        @if(session('erorr'))
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                                 style="margin-top: 15px;width: 100%">
                                                <strong>{{ session('erorr') }}</strong>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <div class="form-group row mgt20 gruopRadio">
                                            <div class="col-md-12 text-center">
                                                <a href="{{  route('show_employee') }}?email={{isset($employee->email) ? $employee->email : ''}}"
                                                   class="btnOrange" style="padding: 5px 20px;">Xem vị trí hồ sơ</a>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row mgb5">
                                            <label for="staticEmail" class="col-sm-4 col-form-label fw6 text-right">
                                                Trạng thái ứng viên :
                                            </label>
                                            <div class="col-sm-8 gruopRadio pdLeft0">
                                                <div class="cus_check_radio form-check">
                                                    <label>
                                                    <input class="form-check-input " type="radio" name="status"
                                                           
                                                           value="0" @if($employee->status == 0) checked @endif>

                                                        Đang tìm việc
                                                    </label>
                                                </div>
                                                <div class="cus_check_radio form-check">
                                                    <label>
                                                    <input class="form-check-input" type="radio" name="status"
                                                           
                                                           value="1" @if($employee->status == 1) checked @endif>

                                                        Đã đi làm
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row mgb5">
                                            <label for="staticEmail" class="col-sm-4 col-form-label fw6 text-right">
                                                Cho phép NTD tìm kiếm hồ sơ :
                                            </label>
                                            <div class="col-sm-8 gruopRadio pdLeft0">
                                                <div class="cus_check_radio form-check">
                                                    <label>
                                                    <input class="form-check-input " type="radio" name="show_hidden_profile"
                                                           
                                                           value="0" @if($employee->show_hidden_profile == 0) checked @endif>

                                                       Cho phép
                                                    </label>
                                                </div>
                                                <div class="cus_check_radio form-check">
                                                    <label>
                                                    <input class="form-check-input" type="radio" name="show_hidden_profile"
                                                           
                                                           value="1" @if($employee->show_hidden_profile == 1) checked @endif>

                                                       Không cho phép
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mgb5">
                                            <label for="staticEmail" class="col-sm-4 col-form-label fw6 text-right">
                                               Hiển thị sơ yếu lý lịch với NTD :
                                            </label>
                                            <div class="col-sm-8 gruopRadio pdLeft0">
                                                <div class="cus_check_radio form-check">
                                                    <label>
                                                    <input class="form-check-input " type="radio" name="show_hidden_syll"
                                                           
                                                           value="0" @if($employee->show_hidden_syll == 0) checked @endif>

                                                      Hiển thị
                                                    </label>
                                                </div>
                                                <div class="cus_check_radio form-check">
                                                    <label>
                                                    <input class="form-check-input" type="radio" name="show_hidden_syll"
                                                           
                                                           value="1" @if($employee->show_hidden_syll == 1) checked @endif>
                                                     Không hiển thị
                                                    </label>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-group row mgb5">
                                            <label for="staticEmail" class="col-sm-4 col-form-label fw6 text-right">


                                            </label>
                                            <div class="col-sm-8 gruopRadio mgt5 pdLeft0">


                                                <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5" value="btn_save"
                                                        style="border:none" id="btnloading" name="submit_form"> Lưu cài đặt
                                                </button>



                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>


                </div>
            </div>
        </div>
    </section>
    <script>
        // chon thanh pho ra quan huyen

    </script>

@endsection