@extends('site.layout.site')

@section('title', isset($employee->employee_name) ? $employee->employee_name : 'hồ  sơ ứng viên')
@section('meta_description', isset($employee->employee_name) ? $employee->employee_name : 'hồ  sơ ứng viên')
@section('keywords', isset($employee->employee_name) ? $employee->employee_name : 'hồ  sơ ứng viên')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row">
                <?php $user = \Illuminate\Support\Facades\Auth::user() ?>
                @include('site.sidebar.sidebar_job',['user'=>$user])
                <div class="col-xl-9 col-lg-8 col-md-12 col-12 col-12">

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

                        </ul>
                    </div>
                    @include('site.modum_sidebar.contact_detail_employee')
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