@extends('site.layout.site')

@section('title', 'Quản lý hồ sơ giáo viên')
@section('meta_description', 'Quản lý hồ sơ giáo viên')
@section('keywords', 'Quản lý hồ sơ giáo viên')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 col-12 col-12">

                    @include('site.modum_sidebar.update_user_teacher2')
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