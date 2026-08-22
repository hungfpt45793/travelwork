@extends('staff_admin.layouts.master')
@section('title', 'Dashboard' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull mt-1 col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.news_article')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content col-content">
            <div class="content">
                <div class="container-fluid px-0 pt-4">
                    <div class="row">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('staff_admin.dashboard.js.index')
@endsection
