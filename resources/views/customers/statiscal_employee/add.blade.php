@extends('admin.layout.admin')

@section('title', 'Thêm mới ứng viên')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới ứng viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Ứng viên</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('statiscal.store') }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin ứng viên</h3>
                        </div>

                        <div class="box-body">

                            <div class="row">

                                <div class="col-xs-12 col-md-12">
                                    <div class="form-group">
                                        <div style="margin-bottom: 15px;">
                                        @if($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger" role="alert"
                                                     style="padding: 5px;margin: 2px;display: inline-block;">
                                                    <strong>{{ $error }}</strong>
                                                </div>
                                            @endforeach
                                        @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Thống kê ứng viên </label>
                                        <select class="form-control select2" name="employees_id">
                                            <option value="" selected>Danh sách ứng viên</option>
                                            @foreach($employees as $emplo)
                                                <option value="{{$emplo->employee_id }}"
                                                @if(old('employees_id') == $emplo->employee_id ) selected @endif
                                                >{{$emplo->employee_name }}
                                                    <span> - </span> {{$emplo->email }}
                                                    <span> - </span> {{$emplo->phone }}
                                                    <span> - </span> {{$emplo->employee_id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số tiền ứng trước </label>
                                        <input type="text" class="form-control formatPrice" name="money"
                                               placeholder="Số tiền ứng trước" value="{{ old('money') }}">
                                        <script>
                                            $('.formatPrice').priceFormat({
                                                prefix: '',
                                                centsLimit: 0,
                                                thousandsSeparator: '.'
                                            });
                                        </script>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số giáo viên đã học </label>
                                        <input type="number" class="form-control formatPrice" name="total_teacher"
                                               placeholder="Số giáo viên đã học" value="{{ old('total_teacher') }}">
                                    </div>
                                    <div class="form-group">Số lần thi trắc nghiệm </label>
                                        <input type="number" class="form-control " name="total_exam"
                                               placeholder="Số lần thi trắc nghiệm" value="{{ old('total_exam') }}">
                                    </div>
                                    <div class="form-group">Số lần tải tài liệu </label>
                                        <input type="number" class="form-control " name="total__dowload_voucher"
                                               placeholder="Số lần tải tài liệu" value="{{ old('total__dowload_voucher') }}">
                                    </div>
                                    <div class="form-group">Số lần xem tài liệu </label>
                                        <input type="number" class="form-control " name="total_view_voucher"
                                               placeholder="Số lần xem tài liệu" value="{{ old('total_view_voucher') }}">
                                    </div>
                                    <div class="form-group">Số lần xem tin tuyển dụng </label>
                                        <input type="number" class="form-control " name="total_view_job"
                                               placeholder="Số lần xem tin tuyển dụng" value="{{ old('total_view_job') }}">
                                    </div>
                                    <div class="form-group">Tỉ lệ hoàn thành CV </label>
                                        <input type="number" class="form-control " name="total_cv"
                                               placeholder="Tỉ lệ hoàn thành CV" value="{{ old('total_cv') }}">
                                    </div>

                                </div>

                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu lại</button>
                        </div>
                    </div>

                </div>


            </form>
        </div>
    </section>
    <script type="text/javascript">
        $('#datepicker').datepicker({
            autoclose: true
        })
    </script>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#staff').change(function () {
                var staff = $(this).val();
                $.get('/admin/ajax-staff/' + staff, function (data) {
                    $('#detail').html(data);
                })
            });

            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });

            $('#note').click(function () {
                $.ajax({
                    url: '{{route('note-employee')}}',
                    method: 'GET',
                    data: {
                        content: $('#note-employee').val()
                    },
                    success: function (data) {
                        $('#noteContent').html(data);
                        $('#note-employee').val('')
                    }
                });
            });

            $('#note-employee').keypress(function (event) {
                if ((event.keyCode ? event.keyCode : event.which) == 13) {
                    $.ajax({
                        url: '{{route('note-employee')}}',
                        method: 'GET',
                        data: {
                            content: $(this).val()
                        },
                        success: function (data) {
                            $('#noteContent').html(data);
                            $('#note-employee').val('')
                        }
                    });
                }
            });

            $('#career').keyup(function () {
                if ($(this).val() == '') {
                    $.ajax({
                        url: '{{route('ajax-career-list')}}',
                        type: 'GET',
                        data: {},
                        success: function (result) {
                            $('#careerList').html(result);
                        }
                    });
                }

                $.get('/admin/ajax-career/' + $(this).val(), function (data) {
                    $('#careerList').html(data);
                })
            })
        });
    </script>
@endpush