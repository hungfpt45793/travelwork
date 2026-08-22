@extends('admin.layout.admin')

@section('title', 'Danh sách liên hệ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ứng viên đăng kí tư vấn
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"> Ứng viên đăng kí tư vấn</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('res-dvisory.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Ngày liên hệ</th>
                                <th>Họ và tên</th>
                                <th>Thông tin liên hệ</th>
                                <th>Nội dung liên hệ</th>
                                <th style="width: 100px">Trạng thái</th>

                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($res_ads as $id => $res )
                                <tr>
                                    <td>{{ $res->id_res }}</td>
                                    <td><?php
                                        $date=date_create($res->created_at);
                                        echo date_format($date,"d/m/Y");
                                        ?>
                                        <br>
                                        <?php
                                        echo date_format($date,"H:i:s");
                                        ?></td>
                                    <td>{{ $res->name_res }}</td>
                                    <td>
                                        <p>SĐT : {{ $res->name_res }}</p>
                                        <p>Email : {{ $res->phone_res }}</p>
                                        <p>Địa chỉ :{{ $res->address_res }}</p>
                                    </td>

                                    <td>
                                        {!! $res->message_res !!}
                                    </td>

                                    <td>
                                        @if($res->status_view == 0)
                                            <span style="color: #fff;background: red;padding: 5px 10px">Chưa xem</span>
                                        @else
                                            <span style="color: #fff;background: green;padding: 5px 10px">Đã xem</span>
                                        @endif

                                    </td>
                                    <td>

                                        <a href="{{ route('res-dvisory.edit', ['id_res' => $res->id_res]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('res-dvisory.destroy', ['id_res' => $res->id_res]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $res_ads->links() }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection

