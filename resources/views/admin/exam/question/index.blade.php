@extends('admin.layout.admin')

@section('title', 'Danh sách dề thi')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Đề thi
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Câu hỏi</a></li>
            <li><a href="#">Danh sách câu hỏi</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('exam.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                        @if (session('suscees'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('suscees') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-danger">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif

                    </div>

                    <!-- /.box-header -->

                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection

@push('scripts')

@endpush

