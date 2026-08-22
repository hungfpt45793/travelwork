@extends('admin.layout.admin')

@section('title', 'Danh sách Quận huyện' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Quận / huyện
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách Quận / huyện</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <form role="search" action="" method="GET">
                        <div class="box-body">
                            <div class="row">




                            </div>

                            <div class="row" style="margin-top: 1%">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <?php
                                        $province_get = '';
                                        if(isset($_GET['province_id']))
                                        {
                                            $province_get = $_GET['province_id'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="province_id" id="province">
                                            <option value="">-- Tỉnh/Thành phố --</option>
                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                <option value="{{$province->province_id}}"
                                                        @if($province->province_id == $province_get) selected @endif
                                                >{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                            </div>




                            <div class="col-md-12 text-center" style="margin-top: 20px">
                                <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                            </div>


                        </div>
                    </form>
                    <div class="box-header">
                        <a href="{{ route('district.create') }}"><button class="btn btn-primary" style="float: right">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        Tổng số : {{ $total }}
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">Mã quận /huyện</th>
                                <th>Tên quận / huyện</th>
                                <th>Slug quận / huyện</th>
                                <th>Tên thành phố</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($district  as $dis)
                                <tr>
                                    <td>{{ $dis->district_id }}</td>
                                    <td>{{ $dis->district_name }}</td>
                                    <td>{{ $dis->district_slug }}</td>
                                    <td>{{ $dis->province_name }}</td>
                                    <td>
                                        <a href="{{ route('district.edit',['district_id'=> $dis->district_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('district.destroy',['district_id'=> $dis->district_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $district->links() }}
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
