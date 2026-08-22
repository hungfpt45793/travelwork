
@extends('site.layout.site')

@section('title', 'Việc làm '.( isset($province->province_name) ? 'thành phố '.$province->province_name : 'tỉnh thành khác' ))
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
    @include('site.general.search_job')

    @include('site.module_index.province')

    <section class="contentIndex">
        <div class="container">
            <div class="row">
                <!-- BÊN PHẢI -->
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 righcont pdl0Im">

                    @include('site.jobs.filter_job')
                </div>
                <!-- BÊN TRÁI -->
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 leftcont pdl0">
                    <!-- BANNER -->
                    <!-- LIST-JOB -->
                    <ul class="listjobs borderRadius5 borderLight mgt0Im">
                        @foreach ($jobs as $job)
                            @include('site.jobs.job_item', ['job' => $job ])
                        @endforeach

                    </ul>
                {{ $jobs->links() }}
                <!-- KHÁCH HÀNG NHẬN XÉT -->
                </div>
            </div>
        </div>
    </section>
@endsection
