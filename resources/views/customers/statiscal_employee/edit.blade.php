@extends('admin.layout.admin')

@section('title', 'cập nhật thống kê ứng viên ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật cập nhật thống kê ứng viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Ứng viên</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('statiscal.update',['id_statistical'=>$statiscal->id_statistical]) }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <div class="box box-primary">
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
                                                    <select class="form-control select2" name="employee_id">
                                                        <option value="" selected>Danh sách ứng viên</option>
                                                        @foreach($employees as $emplo)
                                                            <option value="{{$emplo->employee_id }}" @if($statiscal->employees_id == $emplo->employee_id) selected @endif disabled>{{$emplo->employee_name }}
                                                                <span> - </span> {{$emplo->email }}
                                                                <span> - </span> {{$emplo->phone }}
                                                                <span> - </span> {{$emplo->employee_id }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Số tiền ứng trước </label>
                                                    <input type="text" class="form-control formatPrice" name="money"
                                                           placeholder="Số tiền ứng trước" value="{{ isset($statiscal->money) ? $statiscal->money : '0' }}" />
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
                                                           placeholder="Số giáo viên đã học" value="{{ isset($statiscal->total_teacher) ? $statiscal->total_teacher : '0' }}">
                                                </div>
                                                <div class="form-group">Số lần thi trắc nghiệm </label>
                                                    <input type="number" class="form-control " name="total_exam"
                                                           placeholder="Số lần thi trắc nghiệm" value="{{ isset($statiscal->total_exam) ? $statiscal->total_exam : '0' }}">
                                                </div>
                                                <div class="form-group">Số lần tải tài liệu </label>
                                                    <input type="number" class="form-control " name="total__dowload_voucher"
                                                           placeholder="Số lần tải tài liệu" value="{{ isset($statiscal->total__dowload_voucher) ? $statiscal->total__dowload_voucher : '0' }}">
                                                </div>
                                                <div class="form-group">Số lần xem tài liệu </label>
                                                    <input type="number" class="form-control " name="total_view_voucher"
                                                           placeholder="Số lần xem tài liệu" value="{{ isset($statiscal->total_view_voucher) ? $statiscal->total_view_voucher : '0' }}">
                                                </div>
                                                <div class="form-group">Số lần xem tin tuyển dụng </label>
                                                    <input type="number" class="form-control " name="total_view_job"
                                                           placeholder="Số lần xem tin tuyển dụng" value="{{ isset($statiscal->total_view_job) ? $statiscal->total_view_job : '0' }}">
                                                </div>
                                                <div class="form-group">Tỉ lệ hoàn thành CV </label>
                                                    <input type="number" class="form-control " name="total_cv"
                                                           placeholder="Tỉ lệ hoàn thành CV" value="{{ isset($statiscal->total_cv) ? $statiscal->total_cv : '0' }}">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Lưu thay đổi </button>
                                    </div>
                                </div>

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

@endpush