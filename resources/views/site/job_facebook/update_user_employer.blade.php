@extends('site.layout.site')

@section('title', 'Quản lý hồ sơ nhà tuyển dụng')
@section('meta_description', 'Quản lý hồ sơ nhà tuyển dụng')
@section('keywords', 'Quản lý hồ sơ nhà tuyển dụng')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent">
                @include('site.modum_sidebar.update_user_employer')
                </div>
            </div>
        </div>
    </section>
    <script>
        // chon thanh pho ra quan huyen
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-huyen/' + city , function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });
    </script>



@endsection