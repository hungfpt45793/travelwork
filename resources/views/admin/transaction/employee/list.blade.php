@extends('admin.layout.admin')

@section('title', ' Danh sách ứng viên chia sẻ' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách ứng viên chia sẻ
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#"> Danh sách ứng viên chia sẻ</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">



                    <!-- /.box-header -->

                    <div class="box-body">
                        <form role="search" method="GET" action="">
                            <div class="box-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php
                                            $employee_name_get = '';
                                            if (isset($_GET['employee_name'])) {
                                                $employee_name_get = $_GET['employee_name'];
                                            }
                                            ?>
                                            <label>Tên ứng viên</label>
                                            <input type="text" class="form-control" name="employee_name" value="{{ $employee_name_get }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php
                                            $employee_email_get = '';
                                            if (isset($_GET['employee_email'])) {
                                                $employee_email_get = $_GET['employee_email'];
                                            }
                                            ?>
                                            <label>Email ứng viên</label>
                                            <input type="email" class="form-control" name="employee_email" value="{{ $employee_email_get }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php
                                            $employee_id_get = '';
                                            if (isset($_GET['employee_id'])) {
                                                $employee_id_get = $_GET['employee_id'];
                                            }
                                            ?>
                                            <label>ID ứng viên</label>
                                            <input type="text" class="form-control" name="employee_id" value="{{ $employee_id_get }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php
                                            $myfacebook_get = '';
                                            if (isset($_GET['myfacebook'])) {
                                                $myfacebook_get = $_GET['myfacebook'];
                                            }
                                            ?>
                                            <label>FB ứng viên</label>
                                                <select class="select2" name="myfacebook">
                                                    <option value="">Chọn trạng thái link FB</option>
                                                    <option value="1" @if($myfacebook_get == '1') selected @endif>Có link FB</option>
                                                    <option value="2" @if($myfacebook_get == '2') selected @endif>Không có</option>
                                                </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php
                                            $coints_status_get = '';
                                            if (isset($_GET['coints_status'])) {
                                                $coints_status_get = $_GET['coints_status'];
                                            }
                                            ?>
                                            <label>Trạng thái chia sẻ bài viết</label>
                                                <select class="select2" name="coints_status">
                                                    <option value="">Chọn trạng thái chia sẻ</option>
                                                    <option value="0" @if($coints_status_get == '0') selected @endif>Vẫn chia sẻ</option>
                                                    <option value="1" @if($coints_status_get == '1') selected @endif>Dừng chia sẻ</option>
                                                </select>

                                        </div>
                                    </div>

                                </div>


                                <div class="col-md-12 text-center" style="margin-top: 20px;">
                                    <button class="btn btn-success" type="submit">Tìm Kiếm</button>
                                </div>

                            </div>
                        </form>


                        <p style="color: red">Những ứng viên trống thông tin là đăng nhập bằng tài khoản facebook và chưa cập nhật thông tin</p>
                        <p>
                            Có tất cả {{ $total  }} danh sách ứng viên chia sẻ
                        </p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Mã ứng viên</th>
                                <th>Tên ứng viên</th>
                                <th>Email - Số điện thoại - Link FB</th>

                                <th>số lượt chia sẻ</th>
                                <th>số lượt view</th>
                                <th>Số tiền nhận được</th>
                                <th>Số dư còn lại</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employee_coins  as $id=>$coins)
                                <tr>
                                    <td>{{ $id + 1 }}</td>
                                    <td>{{ $coins->employee_id }}</td>
                                    <td>{{ $coins->employee_name }}</td>
                                    <td>
                                        {{ $coins->email }} - {{ $coins->phone }}
                                        -
                                        @if(!empty($coins->my_facebook))
                                            <a class="green" href="{{ $coins->my_facebook }}">Link FB</a>
                                        @else
                                            <span class="red">Không có</span>
                                        @endif
                                    </td>

                                    <td>{{ number_format($coins->total_sale) }}</td>
                                    <td>{{ number_format($coins->total_view) }}</td>
                                    <td>{{ number_format($coins->total_money) }} VND</td>

                                    <td>{{ number_format($coins->money) }} VND</td>
                                    <td>
                                        @if($coins->coints_status == 0)
                                            <span class="green">Chia sẻ</span>
                                        @else
                                            <span class="red">Đã dừng</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="btn-group dropdown_hover">
                                            <button type="button" class="btn btn-primary btn-box-tool dropdown-toggle " data-toggle="dropdown" style="padding: 5px 9px;
    font-size: 16px;
    color: #fff;">
                                                <i class="fa fa-wrench"></i>Thao tác</button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>  <a class="dsInline" href="{{ route('employee_coints.edit',['coins_id'=> $coins->coins_id]) }}">
                                                        <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Sửa</button>
                                                    </a></li>
                                                <li>   <a class="dsInline" href="{{ route('detail_employee_coints',['employee_id'=>$coins->employee_id ]) }}" >
                                                        <button class="btn btn-success" type="button"><i class="fa fa-eye" aria-hidden="true"> Tin tức</i>
                                                        </button>
                                                    </a></li>

                                                <li><a class="dsInline" href="{{ route('detail_employee_coints_job',['employee_id'=>$coins->employee_id ]) }}" >
                                                            <button class="btn btn-success" type="button"><i class="fa fa-eye" aria-hidden="true"> Tuyển dụng</i>
                                                            </button>
                                                       </a></li>

                                            </ul>
                                        </div>



                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="col-12 pull-right text-right">
                            <nav aria-label="Page navigation example">

                                {{ $employee_coins->links() }}

                            </nav>
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
