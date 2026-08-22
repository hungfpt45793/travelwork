@extends('site.layout.site')

@section('title', isset($employee->employee_name) ? $employee->employee_name : 'CV ứng viên')
@section('meta_description', isset($employee->employee_name) ? $employee->employee_name : 'CV ứng viên')
@section('keywords', isset($employee->employee_name) ? $employee->employee_name : 'CV ứng viên')

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
                                <a href="#" class=" f18 md-f14 mgb0">CV ứng viên</a>
                            </li>

                        </ul>
                    </div>
                    @include('site.modum_sidebar.cv_detail_employee_no_login')
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