@extends('admin.layout.admin')

@section('title', 'Thêm mới cài đặt hoa hồng bán hàng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới cài đặt hoa hồng bán hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">cài đặt hoa hồng bán hàng</a></li>
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
                            <h2>Cài đặt hoa hồng gói bán hàng</h2>
                            <p>Ví dụ: </p>
                            <p>Hóa đơn từ 100.000 đến 200.000 được triết khấu 5%</p>
                            <p>Hóa đơn từ 200.000 đến 300.000 được triết khấu 10%</p>
                            <a href="{{ route('rose_setting_order') }}" class="btn btn-success" style="float:right"><i class="fa fa-plus" aria-hidden="true"></i> Tạo</a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <h2>Cài đặt hoa hồng đơn hàng</h2>
                            <p>Ví dụ: </p>
                            <p>IPhone 6 Vàng 32 GB giảm 5%</p>
                            <p>IPad Air mini 64 GB giảm 200.000</p>
                            <a href="{{ route('rose_setting_employer') }}" class="btn btn-success" style="float:right"><i class="fa fa-plus" aria-hidden="true"></i> Tạo</a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>


        </div>
    </section>
@endsection

