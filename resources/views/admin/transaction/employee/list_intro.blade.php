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
                                            $status_intro = '';
                                            if (isset($_GET['status_intro'])) {
                                                $status_intro = $_GET['status_intro'];
                                            }
                                            ?>
                                            <label>FB ứng viên</label>
                                            <select class="select2" name="status_intro">
                                                <option value="">Chọn trạng thái tin</option>
                                                <option value="0" @if($status_intro == '0') selected @endif>Chưa duyệt</option>
                                                <option value="1" @if($status_intro == 1) selected @endif>Đã duyệt</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                                        <button class="btn btn-success" type="submit">Tìm Kiếm</button>
                                    </div>

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

                                <th>Tên công ty đã giới thiệu</th>
                                <th>Tin đã đăng</th>
                                <th>Ngày giới thiệu</th>
                                <th>Trạng thái</th>
                                <th>Số tiền nhận được</th>
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
                                        --
                                        @if(!empty($coins->my_facebook))
                                            <a class="green" href="{{ $coins->my_facebook }}">Link FB</a>
                                        @else
                                            <span class="red">Không có</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('detail_employer',['slug'=>$coins->slug]) }}" target="_blank">
                                            {{ !empty($coins->enterprise_name) ? $coins->enterprise_name : '' }}
                                            -- {{ $coins->employer_email }} -- {{ $coins->employer_phone }}
                                        </a>


                                    </td>
                                    <td>
                                        <?php
                                            $total_job = 0;
                                        $total_job = \App\Entity\Job::total_job_employer($coins->employer_id);
                                        ?>
                                        {{ $total_job }} tin
                                    </td>
                                    <td>
                                        <?php
                                        $date_created=date_create($coins->created_at);
                                        echo date_format($date_created,"d/m/Y");
                                        ?>
                                    </td>
                                    <td>
                                        @if($coins->status_intro == 0)
                                            <span class="green">Chưa xử lý</span>
                                        @else
                                            <span class="red">Đã xử lý</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($coins->money_status) }} VND</td>



                                    <td>
                                        @if($coins->status_intro == 0)
                                            <a class="dsInline" data_intro="{{ $coins->intro_id }}" href="{{ route('update_status_employee_intro',['intro_id'=>$coins->intro_id]) }}" >
                                                Duyệt
                                            </a>
                                        @endif

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
