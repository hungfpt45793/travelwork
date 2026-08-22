@extends('staff_admin.layouts.master')

@section('title', 'Tương tác giáo viên' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.teacher')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            @if (session('error'))
                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                    <div class="alert alert-danger mg-b-0 " role="alert">
                        {{ session('error') }}
                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                    </div>
                </div>
            @endif
            @if (session('success'))
                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                    <div class="alert alert-success mg-b-0 ">
                        {{session('success')}}
                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                    </div>
                </div>
            @endif
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting pd15 col-f14 ">
                    <h5 class="text-info" style="display: inline-block">Danh sách lịch sử tương tác giáo viên &nbsp;
                    </h5>
                    {{-- <h5 style="display: inline-block" class="text-success"> {{ $teacher->teacher_name }}</h5> --}}
                    <form action="{{ route('interactive_update',['id'=>$interactive->id] ) }}" method="POST" class="row">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="col-8">
                            <div class="form-group">
                                <label for="">Nội dung tương tác</label>
                                <textarea name="content" class="form-control" rows="4" required>{{ $interactive->content }}</textarea>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Ngày tương tác</label>
                                <input type="date" class="form-control" name="interactive_day">
                            </div>
                            <button type="submit" class="btn btn-success float-right">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
