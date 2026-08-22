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
                    <div class="row">
                        <div class="mgt10" style="padding:0 20px;background: #fff;margin-top: 20px">
                            <div class="col-md-4">
                                <label class="mgt10 mgb10 green f16"> Thông tin ứng viên</label>
                                <p>ID ứng viên : <span
                                            style="font-weight: bold">{{ isset($employee_coints->employee_id) ? $employee_coints->employee_id : 'Chưa có thông tin' }}</span>
                                </p>
                                <p>Tên : <span
                                            style="font-weight: bold">{{ isset($employee_coints->employee_name) ? $employee_coints->employee_name : 'Chưa có thông tin' }}</span>
                                </p>
                                <p>Email : <span
                                            style="font-weight: bold"> {{ isset($employee_coints->email) ? $employee_coints->email : 'Chưa có thông tin' }} </span>
                                </p>
                                <p>Số điện thoại : <span
                                            style="font-weight: bold">  {{ isset($employee_coints->phone) ? $employee_coints->phone : 'Chưa có thông tin' }} </span>
                                </p></div>
                            <div class="col-md-4">
                                <label class="mgt10 mgb10 green f16">Thông kế chia sẻ tin tuyển dụng</label>

                                <?php
                                $employee_total_sale = \App\Entity\Job_sale_statistical::Employee_TotalShare($employee_coints->employee_id);
                                $employee_total_view = \App\Entity\Job_sale_statistical::Employee_TotalView($employee_coints->employee_id);
                                $employee_total_view_money = \App\Entity\Job_sale_statistical::Employee_TotalMoney($employee_coints->employee_id);
                                ?>

                                <p>Tổng số lượt chia sẻ bài viết: <span
                                            style="font-weight: bold">  {{ isset($employee_total_sale) ? $employee_total_sale : 'Chưa có thông tin' }} </span>
                                </p>
                                <p>Tổng số lượt xem : <span
                                            style="font-weight: bold">  {{ isset($employee_total_view) ? $employee_total_view : 'Chưa có thông tin' }} </span>
                                </p>
                                <p>Tổng số tiền : <span style="font-weight: bold;color: red">  {{ isset($employee_total_view_money) ? number_format($employee_total_view_money) : 0 }} VND</span>
                                </p>
                                <p>
                                    <span>Trạng thái : </span>
                                    @if($employee_coints->coints_status == 0)
                                        <span class="green fw6">Đang chia sẻ</span>
                                    @endif
                                    @if($employee_coints->coints_status == 1)
                                        <span class="red fw6">Dừng chia sẻ</span>
                                    @endif
                                    <a class="btnRed" data-toggle="modal" data-target="#chang_status_coints">Thay đổi
                                        trạng thái</a>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="mgt10 mgb10 green f16">Lịch sử rút tiền</label>
                                <p>Số tiền đã đổi qua thẻ cào : <span
                                            style="font-weight: bold;color: red">  {{ isset($employee_coints->total_change_crad) ? number_format($employee_coints->total_change_crad) : 0 }} VND</span>
                                </p>
                                <p>Số tiền đã đổi qua chuyển khoản : <span style="font-weight: bold;color: red">  {{ isset($employee_coints->total_change_bank) ? number_format($employee_coints->total_change_bank) : 0 }} VND</span>
                                </p>
                                <p>Số tiền đã đổi qua phần mềm : <span style="font-weight: bold;color: red">  {{ isset($employee_coints->total_change_product) ? number_format($employee_coints->total_change_product) : 0 }} VND</span>
                                </p>
                                <p>Số dư hiện tại : <span style="font-weight: bold;color: red">  {{ isset($employee_coints->money) ? number_format($employee_coints->money) : 0 }} VND</span>
                                </p>
                                <input type="hidden" name="employee_id"
                                       value="{{ isset($employee_coints->employee_id) ? $employee_coints->employee_id : 'Chưa có thông tin' }}">
                            </div>
                            <div class="col-md-12 text-center mgt10">
                                <p style="font-size: 20px;
    font-weight: 600;">Tổng số tiền : <span style="font-weight: bold;color: red">  {{ isset($employee_coints->total_money) ? number_format($employee_coints->total_money) : 0 }} VND</span> (gồm chia sẻ bài viết + tin tuyển dụng)
                                </p>
                            </div>
                        </div>


                    </div>

                    <!-- /.box-header -->

                    <div class="box-body">
                        <form role="search" method="GET" action="">
                            <div class="box-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php
                                            $title_get = '';
                                            if (isset($_GET['title'])) {
                                                $title_get = $_GET['title'];
                                            }
                                            ?>
                                            <label>Tên tin tuyển dụng</label>
                                            <input type="text" class="form-control" name="title"
                                                   value="{{ $title_get }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center" style="margin-top: 20px;">
                                        <button class="btn btn-success" type="submit">Tìm Kiếm</button>
                                    </div>


                                </div>


                            </div>
                        </form>


                        <p style="color: red">Những ứng viên trống thông tin là đăng nhập bằng tài khoản facebook và
                            chưa cập nhật thông tin</p>
                        <p>
                            Chia sẻ tất cả {{ $total  }} tin tuyển dụng
                        </p>
                        <p>Lưu ý : Số tiền có thể thay đổi theo giá trị lúc cài đặt (Tổng tiền chỉ mang tính chất tham
                            khảo thời điểm lúc cộng tiền)</p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tin tuyển dụng - Link</th>
                                <th>số lượt chia sẻ</th>
                                <th>số lượt view</th>
                                <th>Tổng tiền</th>
                                <th>Ngày tạo - cập nhật lần cuối</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_post_sale  as $id=>$post_sale)
                                <tr>
                                    <td>{{ $id + 1 }}</td>
                                    <td>
                                        <a href="{{ route('post',['tin-tuc','post_slug'=>$post_sale->slug]) }}"
                                           title="{{ $post_sale->title }}">{{ $post_sale->title }}</a>

                                    </td>


                                    <td>{{ number_format($post_sale->total_share) }}</td>
                                    <td>{{ number_format($post_sale->total_view_sale) }}</td>
                                    <td>{{ number_format($post_sale->total_money_view) }} VNĐ</td>
                                    <td>
                                        <?php
                                        $date_create = date_create($post_sale->created_at);
                                        echo date_format($date_create, "d-m-Y");
                                        ?> -
                                        @if(!empty($post_sale->updated_at))
                                            <?php
                                            $date_update = date_create($post_sale->updated_at);
                                            echo date_format($date_update, "d-m-Y");
                                            ?>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="col-12 pull-right text-right">
                            <nav aria-label="Page navigation example">

                                {{ $list_post_sale->links() }}

                            </nav>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="chang_status_coints" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content_1">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thay đổi trạng thái</h4>
                </div>
                <form action="{{ route('update_status_employee_coints') }}" class="submitDelete" method="post">
                    <div class="modal-content">
                        <div class="form-group" style="padding: 20px">
                            <label>Chọn trạng thái</label>
                            <select class="select2" name="coints_status">
                                <option value="0" @if($employee_coints->coints_status == 0) selected @endif>
                                    Đang chia sẻ
                                </option>
                                <option value="1" @if($employee_coints->coints_status == 1) selected @endif>
                                    Dừng chia sẻ
                                </option>
                            </select>
                            <input type="hidden" name="coins_id" value="{{ $employee_coints->coins_id }}">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function submitDelete(e) {
            var url = $(e).attr('href');
            console.log(url);
            $('.submitDelete').attr('action', url);
            return false;
        }
    </script>
    <style>
        .modal-content_1 {
            background: #fff;
        }
    </style>

    @include('admin.partials.popup_delete')
@endsection
