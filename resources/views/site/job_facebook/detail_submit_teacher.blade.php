@extends('site.layout.site')

@section('title', 'hồ  sơ ứng viên giáo viên')
@section('meta_description', 'ứng viên giáo viên')
@section('keywords', 'hồ  sơ ứng viên giáo viên')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 col-12 col-12">
                    @include('site.modum_sidebar.detail_user_teacher')
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