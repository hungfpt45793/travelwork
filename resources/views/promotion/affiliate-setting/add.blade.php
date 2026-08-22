@extends('admin.layout.admin')

@section('title', 'Thêm mới Affiliate cài đặt')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Affiliate cài đặt
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Affiliate cài đặt</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->

                <div class="col-xs-12 col-md-6">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <h2>Khuyến mại theo giá trị hóa đơn</h2>
                            <p>Ví dụ: </p>
                            <p>Hóa đơn từ 100.000 đến 200.000 được triết khấu 5%</p>
                            <p>Hóa đơn từ 200.000 đến 300.000 được triết khấu 10%</p>
                            <a href="{{ route('affiliate_setting_order') }}" class="btn btn-success" style="float:right"><i class="fa fa-plus" aria-hidden="true"></i> Tạo</a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <h2>Khuyến mại theo nhóm affiliate</h2>
                            <p>Ví dụ: </p>
                            <p>Nhóm khách hàng thường chiết khấu 5%</p>
                            <p>Nhóm khách hàng vip chiết khấu 10%</p>
                            <a href="{{ route('affiliate_setting_group') }}" class="btn btn-success" style="float:right"><i class="fa fa-plus" aria-hidden="true"></i> Tạo</a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <h2>Khuyến mại theo từng việc làm</h2>
                            <p>Ví dụ: </p>
                            <p>IPhone 6 Vàng 32 GB giảm 5%</p>
                            <p> IPad Air mini 64 GB giảm 200.000</p>
                            <a href="{{ route('affiliate_setting_job') }}" class="btn btn-success" style="float:right"><i class="fa fa-plus" aria-hidden="true"></i> Tạo</a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                </div>
        </div>
    </section>
@endsection

