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
                                <a href="{{ route('show_emplooyee',['employee_id'=> $employee->employee_id]) }}" class=" f18 md-f14 mgb0">Hồ sơ ứng viên</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Sơ yếu lý lịch  ứng viên</a>
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
                           <div class="col-md-12 ">
                               @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)

                               @else
                                   <p>Vui lòng đăng nhập tài khoản để xem thông tin liên lạc của ứng viên</p>
                               @endif
                           </div>
                        </div>

                    </div>


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



@endsection