@extends('site.layout.site')

@section('title', 'Cổng thực tập')
@section('meta_description', 'Cổng thực tập')
@section('keywords', 'Cổng thực tập')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent">
                    @include('site.modum_sidebar.show_intership')
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