@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Danh sách tư vấn du lịch')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
               <div class="col-xl-9 col-lg-8 col-md-12">
                   <p>Chức năng này đang được xây dựng</p>
               </div>
            </div>
        </div>
    </section>



@endsection
