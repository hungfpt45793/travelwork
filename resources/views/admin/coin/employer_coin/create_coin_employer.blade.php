@extends('admin.layout.admin')
@section('title', ' Nạp xu cho nhà tuyển dụng')
@section('content')
 
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Nạp xu cho nhà tuyển dụng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Nạp xu cho nhà tuyển dụng</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('store_coin_employer') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-6">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert"
                                     style="padding: 5px;margin: 2px;display: inline-block;">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin nạp xu</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            {{--<div class="form-group">--}}
                            {{--<label for="exampleInputEmail1">Mã doanh nghiệp</label>--}}
                            {{--<input type="text" class="form-control" name="enterprise_id" placeholder="Mã doanh nghiệp" value="{{old('enterprise_id')}}" >--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <label for="exampleInputEmail1">Số tiền nạp (VNĐ)</label>
                                <input type="text" class="form-control formatPrice" name="coint_money" placeholder="Số tiền nạp"  >
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số xu nhận được</label>
                                <input type="text" class="form-control formatPrice" name="coint" placeholder="Số xu nhận được" >
                                <input type="hidden" class="form-control" name="employer_id" value="{{ $employer->employer_id  }}" >
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả nội dung nập tiền</label>
                               <textarea class="w-100 editor" id="content_coin" name="coin_content"></textarea>
                                <!-- /.input group -->
                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- Nội dung thêm mới -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Nạp tiền</button>
                    </div>

                </div>


                <div class="col-xs-12 col-md-6">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin công ty</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body scrollGroup fw6">
                            <div class="form-group ">
                                <label for="exampleInputEmail1">Tên công ty :</label>
                                <span> <strong>{{ isset($employer->enterprise_name) ? $employer->enterprise_name : '' }}</strong></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email liên hệ :</label>
                                <span> <strong>{{ isset($employer->email) ? $employer->email : '' }}</strong></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại liên hệ :</label>
                                <span> <strong>{{ isset($employer->phone) ? $employer->phone : '' }}</strong></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tỉnh / thành phố :</label>
                                <span> <strong><?php $provice = \App\Entity\Province::getId($employer['province']) ?>
                                        {{ isset($provice['province_name']) ? $provice['province_name'] : '' }}</strong></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Quận / huyện :</label>
                                <span> <strong> <?php $district = \App\Entity\District::getId($employer['district']) ?>
                                        {{ isset($district['district_name']) ? $district['district_name'] : '' }}</strong></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ :</label>
                                <span> <strong>{{ isset($employer->address) ? $employer->address : '' }}</strong></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số tiền đã nạp :</label>
                                <span> <strong class="red">{{ isset($employer->total_money_coin) ? number_format($employer->total_money_coin) : '' }} VNĐ</strong></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tổng số xu :</label>
                                <span> <strong class="red">{{ isset($employer->total_employer_coin) ? number_format($employer->total_employer_coin) : '' }} xu</strong></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số dư xu :</label>
                                <span> <strong class="red">{{ isset($employer->employer_coin) ? number_format($employer->employer_coin) : '' }} xu</strong></span>
                            </div>


                        </div>
                    </div>


                    <!-- /.box -->
                </div>
            </form>
        </div>
    </section>
    <script>
        $('.formatPrice').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.'
        });
    </script>
@endsection

