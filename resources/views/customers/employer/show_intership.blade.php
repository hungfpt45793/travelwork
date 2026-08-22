@extends('admin.layout.admin')

@section('title', 'Danh sách ứng viên đăng ký thực tập')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cổng tuyển dụng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cổng tuyển dụng</a></li>

        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @if(session('suscess'))
                    <div class="infoAlert">
                        <div class="alert alert-success">
                            <span>  {{ session('suscess') }}</span>
                            <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                            </button>
                        </div>
                    </div>
                @endif
                @if(session('erorr'))
                    <div class="infoAlert">
                        <div class="alert alert-danger">
                            <span>  {{ session('erorr') }}</span>
                            <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                            </button>
                        </div>
                    </div>
                @endif


                <div class="col-md-12 mgt20">
                    <div class="box">
                        <div class="box-body">
                            <p>Có tất cả <span style="color: red">{{ $total }} </span>ứng viên đăng kí thực tập</p>

                            <table id="employers" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ngày ứng tuyển</th>
                                    <th>Tên ứng viên</th>
                                    <th>Email ứng viên</th>
                                    <th>Số điện thoại ứng viên</th>
                                    <th>Tỉnh / TP</th>
                                    <th>Quận / Huyện</th>
                                    <th>Chi tiết ứng viên</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($intership as $id => $inter)
                                    <tr>
                                        <td>{{ $id + 1 }}</td>
                                        <td><?php
                                            $date = date_create($inter->create_up);
                                            echo date_format($date, "d/m/Y");
                                            ?></td>
                                        <?php
                                        $employee = \App\Entity\Employee::getIdEmployee($inter->employee_id);

                                        ?>
                                        <td>{{ $employee->employee_name }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->phone }}</td>

                                        <td>
                                            <?php $province_star = \App\Entity\Province::getId($employee['province']) ?>
                                            @if(isset($province_star->province_name))
                                                {{ $province_star->province_name }}
                                            @endif
                                        </td>
                                        <td>
                                            <?php $distinct_star = \App\Entity\District::getId($employee['district']) ?>
                                            @if(isset($distinct_star->district_name))
                                                {{ $distinct_star->district_name }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('show_emplooyee',['employee_id'=>$employee->employee_id]) }}"
                                               class="btnOrange">Chi tiết ứng viên</a></td>
                                        <td>
                                            @if($inter->status_intership == 1)
                                                <a data-toggle="modal" data-target="#updateIntership{{$id}}"
                                                   style="background-color: green;color: #fff;padding: 5px 10px"> <i
                                                            class="fas fa-pencil-alt"></i> Đã nhận thực tập</a>
                                            @else
                                                <a data-toggle="modal" data-target="#updateIntership{{$id}}"
                                                   style="background-color: red;color: #fff;padding: 5px 10px"> <i
                                                            class="fas fa-pencil-alt"></i> Chưa nhận thực tập</a>
                                            @endif

                                            {{--{{ route('delete_intership',['intership_id'=>$inter['intership_id']]) }}--}}
                                            <a data-toggle="modal" data-target="#deleteIntership{{$id}}"
                                               title="Xóa"
                                               style="background-color: red;color: #fff;padding: 5px 10px"><i
                                                        class="far fa-trash-alt"></i> Xóa hồ sơ</a>
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    @foreach($intership as $id => $inter)
        <div class="modal fade" id="updateIntership{{$id}}" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ">
                    <form action="{{ route('ad_update_status_intership') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật trạng thái</h5>
                        </div>
                        <div class="modal-body gruopRadio">


                            <label for="exampleFormControlTextarea1">Hồ sơ thực tập : </label>


                            <div class="form-group">
                                <label style="margin-right: 10px">
                                    <input type="radio" name="status_intership" value="1"
                                           class="flat-red" @if($inter->status_intership == 1) checked @endif>
                                    Nhận hồ sơ
                                </label>
                                <p></p>
                                <label>
                                    <input type="radio" name="status_intership" value="0"
                                           class="flat-red" @if($inter->status_intership == 0) checked @endif>
                                    Không nhận hồ sơ
                                </label>
                            </div>

                            <input type="hidden" name="intership_id" value="{{ $inter->intership_id }}">


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu trạng thái</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <style>
        .radio label {
            position: relative;
            margin-left: 25px;
        }

        .radio label input {
            position: absolute;
            left: -25px;
        }
    </style>


    @foreach($intership as $id => $inter)
        <div class="modal fade" id="deleteIntership{{$id}}" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ">
                    <form action="{{ route('ad_delete_intership') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Xóa hồ sơ thực tập</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <input type="hidden" name="intership_id" value="{{ $inter->intership_id }}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Xóa hồ sơ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

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
        })
        //chell all het checkbox
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
    <style>
        input[type=checkbox] {
            width: 15px;
            height: 15px;
        }
    </style>
@endpush



