@extends('admin.layout.admin')

@section('title', 'Lịch sử giao dịch nhà tuyển dụng'. $employer->enterprise_name)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lịch sử giao dịch NTD {{$employer->enterprise_name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Nhà tuyển dụng</a></li>
            <li class="active"><a href="#">Lịch sử giao dịch</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <h3><b> Tổng số tiền : <span id="quantity" style="color: red">{{$employer->total_money}}</span>VNĐ </b></h3>
                            </div>
                        </div>

                    </div>

                    <div class="box-body">
                        <table id="transaction" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nhà tuyển dụng</th>
                                    <th>Ngày giao dịch</th>
                                    <th>Số tiền giao dịch</th>
                                    <th>Lý do giao dịch</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{$employer->enterprise_name}}</td>
                                    <td>{{$transaction->created_at}}</td>
                                    <td>{{$transaction->money}}  VNĐ</td>
                                    <td>{{$transaction->reason}} ứng viên <a href="{{route('employee.edit',['employee_id'=>$transaction->employee_id])}}">{{$transaction->employee_name}}</a>
                                     cho công việc <a href="{{route('job.edit',['job'=>$transaction->job_id])}}">{{$transaction->title}}</a> .</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nhà tuyển dụng</th>
                                    <th>Ngày giao dịch</th>
                                    <th>Số tiền giao dịch</th>
                                    <th>Lý do giao dịch</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            var quantity =$('#quantity').text();
            $('#quantity').text(numeral(quantity).format('0,0'));

            {{--$('#transaction').dataTable({--}}
            {{--    processing : true,--}}
            {{--    serverSide : true,--}}
            {{--    type : 'GET',--}}
            {{--    ajax : '{{route('dt_transaction')}}',--}}
            {{--    columns:[--}}
            {{--        { data: 'enterprise_name', name: 'enterprise_name' },--}}
            {{--        { data: 'created_at', name: 'employer_transaction.created_at' },--}}
            {{--        { data: 'money', name: 'money' },--}}
            {{--        { data: 'reason', name: 'reason' }--}}
            {{--    ]--}}
            {{--});--}}
        });
    </script>
@endpush
