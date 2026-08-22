@extends('admin.layout.admin')

@section('title', ' Lượng tiền quy đổi trong tháng' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách lượng tiền quy đổi trong tháng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#"> Danh sách lượng tiền quy đổi trong tháng</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @if (session('success'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('money_month.create') }}"><button class="btn btn-primary" style="float: left;margin-right: 10px;">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">



                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Lượng tiền tối đa trong tháng</th>
                                <th>Số dư còn lại trong tháng</th>
                                <th>Sử dụng trong tháng</th>
                                <th>Thao tác</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($money_month_pay  as $money)
                                <tr>
                                    <td>{{ $money->money_id }}</td>
                                    <td>{{ number_format($money->total_money_month ) }}</td>
                                    <td>{{ number_format($money->money_surplus ) }}</td>
                                    <td>{{ $money->money_month_year  }}</td>

                                    <td>
                                        <a href="{{ route('money_month.edit',['money_id'=> $money->money_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('money_month.destroy',['money_id'=> $money->money_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{--<div>--}}
                            {{--{{ $money_month->links() }}--}}
                        {{--</div>--}}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
