@extends('site.layout.site')

@section('title', isset($employee->employee_name) ? $employee->employee_name : 'hồ  sơ ứng viên')
@section('meta_description', isset($employee->employee_name) ? $employee->employee_name : 'hồ  sơ ứng viên')
@section('keywords', isset($employee->employee_name) ? $employee->employee_name : 'hồ  sơ ứng viên')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 col-12 col-12">
                    @include('site.modum_sidebar.detail_user_employee_intership')
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