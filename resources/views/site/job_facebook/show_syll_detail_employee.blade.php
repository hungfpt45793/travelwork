@extends('site.layout.site')

@section('title', isset($employee->employee_name) ? $employee->employee_name : 'Sơ yếu lý lịch ứng viên')
@section('meta_description', isset($employee->employee_name) ? $employee->employee_name : 'Sơ yếu lý lịch ứng viênn')
@section('keywords', isset($employee->employee_name) ? $employee->employee_name : 'Sơ yếu lý lịch ứng viên')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container ">

            <div class="row">

                <div class="col-xl-12 col-lg-8 col-md-12 col-12 col-12">
                    <div class="link bgrWhite md-mgt20 disOnMobile mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('show_employee') }}" class=" f18 md-f14 mgb0">Danh sách ứng viên</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('show_detail_emplooyee',['employee_id'=> $employee->employee_id]) }}"
                                   class=" f18 md-f14 mgb0">Hồ sơ ứng viên</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Sơ yếu lý lịch ứng viên</a>
                            </li>

                        </ul>
                    </div>

                    <div class="col-md-12 bgrWhite show_info_employee">
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



                            <div class="row">
                                <div class=" col-md-6 mgt5">


                                    <form id="show_info_cv_detail_employee"
                                          action="{{ route('show_info_cv_detail_employee') }}" method="post">
                                        <?php
                                        $view_profile = 2;
                                        $view_apply = 1;
                                        $carra = \App\Entity\Career::check_view_coint($employee->employee_id);
                                        if (!empty($carra)) {
                                            $view_profile = $carra->view_profile;
                                            $view_apply = $carra->view_apply;
                                        }


                                        ?>
                                            <div class="btn_info_employee mgb5">
                                                <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
                                                @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
                                                    <a type="submit" class="clwhite submit_show_info_cv_detail_employee" style="background: none;
    border: none;">
                                                        <i class="fas fa-id-card-alt mgr5"></i> Xem Thông tin liên hệ của ứng viên
                                                        ( {{ $view_profile }} điểm ) <i
                                                                class="fas fa-id-card-alt mgf5"></i>
                                                    </a>
                                                @else
                                                    <a type="submit" class="clwhite" style="background: none;
    border: none;" data-toggle="modal" data-target="#contac_employee">
                                                        <i class="fas fa-id-card-alt mgr5"></i> Xem Thông tin liên hệ của ứng viên
                                                        ( {{ $view_profile }} điểm ) <i
                                                                class="fas fa-id-card-alt mgf5"></i>
                                                    </a>

                                                @endif

                                            </div>



                                    </form>
                                    <script>
                                        $('.submit_show_info_cv_detail_employee').click(function () {
                                            $('#show_info_cv_detail_employee').submit();
                                        })
                                    </script>


                                    <div class="btn_info_employee">
                                        <a class="clwhite"
                                           href="{{ route('invitation_apply_detail_employee',['employee_id'=>$employee->employee_id]) }}">
                                            <i class="fas fa-id-card-alt mgr5"></i> Mời ứng viên ứng tuyển
                                            ( {{ $view_apply }} điểm ) <i
                                                    class="fas fa-id-card-alt mgf5"></i>
                                        </a>
                                    </div>
                                </div>
                                @if(!empty($employer))
                                <div class=" col-md-6 mgt5">
                                    <h3 class="f20 fw6 clgreen"> {{ isset($employer->enterprise_name) ? $employer->enterprise_name : ''}}</h3>
                                    @if(!empty($employer->total_employer_coin))
                                        <p class="mgb0 clgreen">
                                            Điểm : {{ number_format($employer->employer_coin )}} điểm
                                            <span data-toggle="modal" data-target="#create_coin"
                                                  class="btnOrange mg10-0 d-sm-inline-block  bdr3 mgl10"
                                                  style="padding: 5px 15px;cursor: pointer">Nạp điểm <i
                                                        class="fas fa-coins"></i></span>

                                            <a href="{{ route('list_job_face') }}" target="_blank"
                                               class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3 mgl10"
                                               style="padding: 5px 15px;cursor: pointer">Hồ sơ NTD </a>
                                        </p>
                                    @else

                                        <p class="mgb0 clgreen">
                                            <?php
                                            $coin_infomation = \App\Entity\Coin_type_information_employer::get_coin_info();
                                            $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
                                            $coin_money = $coin_infomation['so-diem-mien-phi-theo-ngay'] - $history_coin;
                                            ?>
                                            Điểm miễn phí : {{ isset($coin_money) ? $coin_money : '0' }} điểm

                                            <span data-toggle="modal" data-target="#create_coin"
                                                  class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3 mgl10"
                                                  style="padding: 5px 15px;cursor: pointer">Nạp điểm <i
                                                        class="fas fa-coins"></i></span>

                                            <a href="{{ route('list_job_face') }}" target="_blank"
                                               class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3 mgl10"
                                               style="padding: 5px 15px;cursor: pointer">Hồ sơ NTD </a>

                                        </p>
                                    @endif
                                </div>
                                    @endif
                            </div>



                    </div>

                    @if(\Illuminate\Support\Facades\Auth::user() && \Illuminate\Support\Facades\Auth::user()->role == 2)
                        <?php
                        $employer = \App\Entity\Employer::getIdUser(\Illuminate\Support\Facades\Auth::user()->id);
                        $check_contact_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee->employee_id);
                        ?>
                    @endif


                    <section class="employer_export mgt10">

                                <div class="col-lg-12 bg-white text-center">
                                    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role ==2 )
                                        <a  class="btnOrange mg10-0 d-sm-inline-block mgt10 mgb5 bdr3 dsInline" @if(!empty($check_contact_employee)) href="{{ route('employer_exportpdf_ll',['employee_id'=>$employee->employee_id]) }}" target="_blank" @else  href="#" @endif><i class="fas fa-download mgr5"></i> Tải sơ yếu lý lịch</a>
                                        <p class="mgb10"><i>Bạn phải xem thông tin liên hệ của ứng viên thì mới tải được sơ yếu lý lịch</i></p>
                                    @else
                                        <a  class="btnOrange mg10-0 d-sm-inline-block mgt10 mgb5 bdr3 dsInline" href="#"><i class="fas fa-download mgr5"></i> Tải sơ yếu lý lịch</a>
                                        <p class="mgb10"><i>Bạn phải xem thông tin liên hệ của ứng viên thì mới tải được sơ yếu lý lịch (bạn phải <a data-toggle="modal" class="fw6" data-target="#loginTiva">đăng nhập tài khoản nhà tuyển dụng</a> để xem thông tin liên hệ của ứng viên)</i></p>


                                    @endif
                                </div>

                    </section>


                    @include('site.modum_sidebar.syll_detail_employee')
                </div>
            </div>
        </div>
    </section>
    <script>
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
    </script>

    @include('site.mobile_bottom.fixel_bottom_detail_employer')

@endsection