@extends('staff_admin.layouts.master')

@section('title', 'Tạo mới mẫu email' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.marketing')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting  col-f14 ">
                    <div class="row ">
                        <div class="col-md-12">
                            <form role="form" action="{{ route('store_email') }}" method="POST">
                                {!! csrf_field() !!}
                                {{ method_field('POST') }}
                                <div class="col-xs-12 col-md-12">
                                    <!-- Nội dung thêm mới -->
                                    <div class="box box-primary">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tên danh mục mẫu emal</label>
                                                <input type="text" class="form-control" name="name_cate_tem" placeholder="Tên danh mục mẫu emal">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Biến truyền vào mẫu email</label>
                                                <textarea class="form-control editor" id="note_tem_var" name="note_tem_var"></textarea>

                                            </div>
                                        </div>

                                        {{-- <div class="form-group error">
                                            @if(!empty($errors->all()))
                                                @foreach($errors->all() as $erorr)
                                                    <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                                @endforeach
                                            @endif
                                        </div> --}}
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@include('site.partials.popup_delete')
@push('custom-scripts')
@endpush
@endsection
