@extends('admin.layout.admin')

@section('title', 'Danh sách chuyển khoản' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách chuyển khoản
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách chuyển khoản</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

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

                    <form role="search" method="GET" action="">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <label>Trạng thái giao dịch</label>
                                        <select class="form-control select2" name="transaction_status">

                                            <?php
                                            $transaction_status_get = '';

                                            if (isset($_GET['transaction_status'])) {
                                                $transaction_status_get = $_GET['transaction_status'];
                                            }
                                            ?>
                                            <option value="" selected>-- Trạng thái--</option>
                                            <option value="0"
                                                    @if($transaction_status_get == '0') selected @endif
                                            >Chưa giao dịch
                                            </option>
                                            <option value="1"
                                                    @if($transaction_status_get == '1') selected @endif
                                            >Đã hủy giao dịch
                                            </option>
                                            <option value="2"
                                                    @if($transaction_status_get == '2') selected @endif
                                            >Đã giao dịch
                                            </option>

                                        </select>
                                    </div>
                                </div>
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

                            </div>


                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <button class="btn btn-success" type="submit">Tìm Kiếm</button>
                            </div>

                        </div>
                    </form>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <span style="color: red">Lưu ý : Ứng viên nào chưa có email là đăng nhập bằng facebook</span>
                        <p>
                            Có tất cả {{ $total  }} danh sách chuyển khoản
                        </p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>ID - Tên ứng viên</th>
                                <th>Email ứng viên</th>
                                <th>Tên ngân hàng</th>
                                <th>Số tiền chuyển khoản</th>
                                <th>Số tài khoản</th>
                                <th>Tên chủ tài khoản</th>
                                <th>Nội dung</th>
                                <th>Trạng thái</th>
                                <th>Ngày giao dịch</th>
                                <th>Ngày duyệt</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transaction_bank  as $id=>$bank)
                                <tr>
                                    <td>{{ $id + 1 }}</td>
                                    <td> {{ isset($bank->employee_id) ? $bank->employee_id : ''  }}
                                        - {{ isset($bank->employee_name) ? $bank->employee_name : ''  }}</td>
                                    <td> {{ isset($bank->email) ? $bank->email : ''  }}</td>
                                    <td> {{ isset($bank->transaction_bank_name) ? $bank->transaction_bank_name : ''  }}</td>
                                    <td> {{ isset($bank->transaction_bank_price) ? number_format($bank->transaction_bank_price) : ''  }}
                                        VND
                                    </td>
                                    <td> {{ isset($bank->transaction_bank_number) ? $bank->transaction_bank_number : ''  }}</td>
                                    <td> {{ isset($bank->transaction_home_name) ? $bank->transaction_home_name : ''  }}</td>
                                    <td> {{ isset($bank->transaction_content) ? $bank->transaction_content : ''  }}</td>
                                    <td>
                                        @if($bank->transaction_status == 0)
                                            <span style="background: orange;color: #fff;display: inline-block;padding: 3px 5px">Chưa giao dich</span>
                                        @endif
                                        @if($bank->transaction_status == 1)
                                            <span style="background: red;color: #fff;display: inline-block;padding: 3px 5px">Đã hủy giao dịch</span>
                                        @endif
                                        @if($bank->transaction_status == 2)
                                            <span style="background: green;color: #fff;display: inline-block;padding: 3px 5px">Đã giao dịch</span>
                                        @endif
                                    </td>
                                    <td>
                                        <?php
                                        $date = date_create($bank->created_at);
                                        echo date_format($date, 'd/m/Y H:i:s');
                                        ?>
                                    </td>
                                    <td>
                                        @if(!empty($bank->updated_at))
                                            <?php
                                            $date = date_create($bank->updated_at);
                                            echo date_format($date, 'd/m/Y H:i:s');
                                            ?>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('transaction_bank.edit',['transaction_bank_id'=> $bank->transaction_bank_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('restore_trannsaction_bank',['employee_id'=>$bank->employee_id]) }}">  <span style="background: green;color:#fff;display: inline-block;padding: 3px 5px">Khôi phục</span></a>
                                        {{--<a href="{{ route('transaction_card.destroy',['transaction_card_id'=> $bank->transaction_card_id]) }}"--}}
                                        {{--class="btn btn-danger btnDelete" data-toggle="modal"--}}
                                        {{--data-target="#myModalDelete" onclick="return submitDelete(this);">--}}
                                        {{--<i class="fa fa-trash-o" aria-hidden="true"></i>--}}
                                        {{--</a>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $transaction_bank->links() }}
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
