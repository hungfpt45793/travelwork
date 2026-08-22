@extends('admin.layout.admin')

@section('title', 'Danh sách lịch sử nạp tiền nạp nhà tuyển dụng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách lịch sử nạp tiền nạp nhà tuyển dụng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Danh sách lịch sử nạp tiền nạp nhà tuyển dụng</a></li>
            <li class="active"><a href="#">Danh sách</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                @if (session('success'))
                    <div class="infoAlert">
                        <div class="alert alert-success">
                            <span>{{ session('success') }}</span>
                            <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="infoAlert">
                        <div class="alert alert-warning">
                            <span>{{ session('error') }}</span>
                            <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                        </div>
                    </div>
                @endif


                <div class="box">
                    <div class="box-body  fw6">
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

                    <a href="{{ route('create_coin_employer',['employer_id'=>$employer->employer_id]) }}" style="color:#fff;background: orange;padding: 5px 10px;margin-left: 20px" class="btnOrang">Nạp tiền</a>
                    <div>

                    </div>
                    <div class="box-body">
                        <p>Tổng số giao dịch : {{ $total }}</p>

                        {{--<form role="search" action="" method="GET">--}}
                        {{--<div style="margin-bottom: 10px;">--}}
                        {{--<label style="margin-right: 20px;display: inline-block"><input type="checkbox" id="checkAll">Check All</label> <button type="submit" style="background: red;color: #fff;border: none;padding: 3px 10px;">Xóa hết</button>--}}
                        {{--</div>--}}
                        @if(!empty($list_coin_money))
                            <table id="employers" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    {{--<th>Check All</th>--}}
                                    <th>ID</th>
                                    <th>Số tiền nạp</th>
                                    <th>Số xu nhận được</th>
                                    <th>User giao dịch</th>
                                    <th>Ngày giao dịch</th>
                                    <th>Thao tác</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($list_coin_money as $coin)
                                    <tr>
                                        <td>{{ isset($coin['coin_money_id']) ? $coin['coin_money_id'] : '' }}</td>
                                        <td>
                                            {{ isset($coin['coint_money']) ? number_format($coin['coint_money']) : '0' }} VNĐ

                                        </td>
                                        <td> {{ isset($coin['coint']) ? number_format($coin['coint']) : '0' }} Xu</td>
                                        <td>
                                            <?php
                                            $user_transaction = \App\Entity\User::getIdNameUser($coin['user_id']);
                                            ?>
                                            {{ isset($user_transaction['name']) ? $user_transaction['name'] : '' }} - {{ isset($user_transaction['email']) ? $user_transaction['email'] : '' }} -  {{ isset($user_transaction['phone']) ? $user_transaction['phone'] : '' }}
                                        </td>
                                        <td>
                                            <?php
                                            $date=date_create($coin['created_at']);
                                            echo date_format($date,"d-m-Y  H:i");
                                            ?>
                                        </td>

                                        <td style="width: 120px;text-align: left">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>Thao tác
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('edit_coin_employer',['coin_money_id'=>$coin->coin_money_id]) }}">Sửa</a></li>
                                                    <li><a href="{{ route('delete_coin_employer',['coin_money_id'=>$coin->coin_money_id]) }}">Xóa</a></li>
                                                </ul>
                                            </div>

                                            {{--<a href="{{ route('employer.edit',['employer_id' => $employer->employer_id]) }}">--}}
                                            {{--<button class="btn btn-primary" type="button"><i class="fa fa-pencil" aria-hidden="true"></i></button>--}}
                                            {{--</a>--}}
                                            {{--<a href="{{ route('employer.destroy',['employer_id' => $employer->employer_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">--}}
                                            {{--<i class="fa fa-trash-o" aria-hidden="true"></i>--}}
                                            {{--</a>--}}
                                            {{--<a class="mgt5" href="{{ route('list_intership',['employer_id' => $employer->employer_id]) }}" style="display: block">--}}
                                            {{--<button style="margin-top: 5px;" class="btn btn-success" type="button"><i class="fa fa-list" aria-hidden="true"></i>--}}
                                            {{--thực tập</button>--}}
                                            {{--</a>--}}

                                            {{--<a class="mgt5" href="{{ route('show_employer_angency',['employer_id' => $employer->employer_id]) }}" style="display: block">--}}
                                            {{--<button style="margin-top: 5px;background: orange;color: #fff" class="btn btn-orange" type="button"><i class="fa fa-list" aria-hidden="true"></i>--}}
                                            {{--Đại lý</button>--}}
                                            {{--</a>--}}
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                            <div class="pull-right">{{ $list_coin_money->links() }}</div>
                        @endif

                        <h3>Danh sách nạp xu đã xóa</h3>

                        @if(!empty($list_coin_money_delete))
                            <table id="employers" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    {{--<th>Check All</th>--}}
                                    <th>ID</th>
                                    <th>Số tiền nạp</th>
                                    <th>Số xu nhận được</th>
                                    <th>User giao dịch</th>
                                    <th>Ngày giao dịch</th>


                                </tr>
                                </thead>
                                <tbody>

                                @foreach($list_coin_money_delete as $coin)
                                    <tr>
                                        <td>{{ isset($coin['coin_money_id']) ? $coin['coin_money_id'] : '' }}</td>
                                        <td>
                                            {{ isset($coin['coint_money']) ? number_format($coin['coint_money']) : '0' }} VNĐ

                                        </td>
                                        <td> {{ isset($coin['coint']) ? number_format($coin['coint']) : '0' }} Xu</td>
                                        <td>
                                            <?php
                                            $user_transaction = \App\Entity\User::getIdNameUser($coin['user_id']);
                                            ?>
                                            {{ isset($user_transaction['name']) ? $user_transaction['name'] : '' }} - {{ isset($user_transaction['email']) ? $user_transaction['email'] : '' }} -  {{ isset($user_transaction['phone']) ? $user_transaction['phone'] : '' }}
                                        </td>
                                        <td>
                                            <?php
                                            $date=date_create($coin['deleted_at']);
                                            echo date_format($date,"d-m-Y  H:i");
                                            ?>
                                        </td>



                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                            <div class="pull-right">{{ $list_coin_money_delete->links() }}</div>
                        @endif

                        {{--</form>--}}

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection
@push('scripts')
    <script>
        {{--$(function() {--}}
        {{--$('#employers').dataTable({--}}
        {{--processing: true,--}}
        {{--serverSide: true,--}}
        {{--type: 'GET',--}}
        {{--ajax: '{{route('dt_employer')}}',--}}
        {{--columns :[--}}
        {{--{ data: 'id', name: 'employer.id',render:function (data) {--}}
        {{--return '<input type="checkbox" id="checkItem" name="delete_id[]" value="'+data+'">';--}}
        {{--}--}}
        {{--},--}}
        {{--{ data: 'employer_id', name: 'employer.employer_id' },--}}
        {{--{ data: 'enterprise_name', name: 'enterprise_name' },--}}
        {{--{ data: 'image', name: 'image' ,--}}
        {{--render: function (data) {--}}
        {{--return '<img src="'+data+'" width="100" alt="NTD" />';--}}
        {{--}--}}
        {{--},--}}
        {{--{ data: 'type_of_business_name', name: 'type_of_business.type_of_business_name' },--}}
        {{--{ data: 'business_type_name', name: 'business_type.business_type_name' },--}}
        {{--{ data: 'status', name: 'status',--}}
        {{--render: function (data) {--}}
        {{--if(data == 0){--}}
        {{--return 'Chưa có nhu cầu';--}}
        {{--}else if (data == 1){--}}
        {{--return 'Có nhu cầu';--}}
        {{--}else if (data == 2){--}}
        {{--return 'Đã lên đơn hàng';--}}
        {{--}--}}
        {{--}--}}
        {{--},--}}
        {{--{ data: 'total_money', name: 'total_money' ,--}}
        {{--render: function (data) {--}}
        {{--return '<b>' + numeral(data).format('0,0') + " VNĐ </b>";--}}
        {{--}--}}
        {{--},--}}
        {{--{ data: 'number_recruit_require', name: 'number_recruit_require' ,--}}
        {{--render: function (data) {--}}
        {{--return numeral(data).format('0,0');--}}
        {{--}--}}
        {{--},--}}
        {{--{ data: 'recruited', name: 'recruited' ,--}}
        {{--render: function (data) {--}}
        {{--return numeral(data).format('0,0');--}}
        {{--}--}}
        {{--},--}}
        {{--{ data: 'action', name: 'action', searchable: false, orderable: false }--}}
        {{--]--}}
        {{--});--}}
        {{--});--}}

        $(document).ready(function () {
            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            })
            {{--$('#exportExcel').click(function(){--}}
            {{--$('#submitForm').attr('action','{{ route('exportToExcel') }}')--}}
            {{--return false;--}}
            {{--})--}}
        })
        //chell all het checkbox
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
    <style>
        input[type=checkbox]
        {
            width: 15px;
            height: 15px;
        }
    </style>
@endpush
