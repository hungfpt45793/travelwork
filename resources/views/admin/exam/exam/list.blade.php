@extends('admin.layout.admin')

@section('title', 'Danh sách dề thi')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Đề thi
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Đề thi</a></li>
            <li><a href="#">Danh sách đề thi</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">

            {{--thong bao alert--}}
            {{--<div class="col-xs-12">--}}
                {{--<div class="box-body">--}}
                    {{--<div class="alert alert-danger alert-dismissible">--}}
                        {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
                        {{--<h4><i class="icon fa fa-ban"></i> Alert!</h4>--}}
                        {{--Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my entire--}}
                        {{--soul, like these sweet mornings of spring which I enjoy with my whole heart.--}}
                    {{--</div>--}}
                    {{--<div class="alert alert-info alert-dismissible">--}}
                        {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
                        {{--<h4><i class="icon fa fa-info"></i> Alert!</h4>--}}
                        {{--Info alert preview. This alert is dismissable.--}}
                    {{--</div>--}}
                    {{--<div class="alert alert-warning alert-dismissible">--}}
                        {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
                        {{--<h4><i class="icon fa fa-warning"></i> Alert!</h4>--}}
                        {{--Warning alert preview. This alert is dismissable.--}}
                    {{--</div>--}}
                    {{--<div class="alert alert-success alert-dismissible">--}}
                        {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
                        {{--<h4><i class="icon fa fa-check"></i> Alert!</h4>--}}
                        {{--Success alert preview. This alert is dismissable.--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
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
                        @if (session('delete'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>Bạn đã xóa đề thi thành công</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                        @if (session('error_delete'))
                            <div class="infoAlert">
                                <div class="alert alert-danger">
                                    <span>Bạn đã xóa đề thi thất bại</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="list_exam" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Mã đề thi</th>
                                <th>Tên đề thi</th>
                                <th>Link Slug</th>
                                <th>Thời gian thi(phút)</th>
                                <th>User ra đề</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            {{--<tfoot>--}}
                            {{--<th width="5%">ID</th>--}}
                            {{--<th>Tiêu đề</th>--}}
                            {{--<th>Đường dẫn</th>--}}
                            {{--<th>Danh mục</th>--}}
                            {{--<th>Hình ảnh</th>--}}
                            {{--<th>Thao tác</th>--}}
                            {{--</tfoot>--}}
                        </table>
                    </div>
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
    <script>
        $(function() {
            var table = $('#list_exam').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('examDatatables') !!}',
                {{--ajax: '{!! route('datatable_post') !!}',--}}
                columns: [
                    { data: 'id_exam', name: 'id_exam'},
                    { data: 'code_exam', name: 'code_exam' },
                    { data: 'name_exam', name: 'name_exam' },
                    { data: 'slug_exam', name: 'slug_exam' },
                    { data: 'time_exam', name: 'time_exam' },
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                "language": {
                    "url": "{{ asset('tracnghiem') }}/js/Vietnamese.json"
                }
            });
        });
    </script>
@endpush

