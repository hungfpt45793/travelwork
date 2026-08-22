@extends('admin.layout.admin')

@section('title', 'Danh sách giáo viên')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Giáo viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Giáo viên</a></li>
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
                    <form role="search" method="GET" action="">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $career_category_id_get = '';
                                        if (isset($_GET['career_category_id'])) {
                                            $career_category_id_get = $_GET['career_category_id'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="career_category_id">
                                            <option value="">-- Chọn công việc --</option>
                                            <?php
                                            $career = \App\Entity\Career::getAllCareer();
                                            ?>
                                            @foreach($career as $car)
                                                <option value="{{$car->career_category_id}}"
                                                        @if($car->career_category_id == $career_category_id_get) selected @endif
                                                >{{$car->career_category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $province_get = '';
                                        if (isset($_GET['province'])) {
                                            $province_get = $_GET['province'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="province" id="province">
                                            <option value="">-- Tỉnh/Thành phố --</option>
                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                <option value="{{$province->province_id}}"
                                                        @if($province->province_id == $province_get) selected @endif
                                                >{{$province->province_name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $district_get = '';
                                        if (isset($_GET['district'])) {
                                            $district_get = $_GET['district'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="district" id="district">
                                            <option value="">-- Quận/Huyện --</option>
                                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                <option value="{{$district->district_id}}"
                                                        @if($district->district_id == $district_get) selected @endif
                                                >{{$district->district_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                            </div>


                            <div class="row" style="margin-top: 1%">
                                <div class="col-md-4">
                                    <?php
                                    $teacher_name_get = '';
                                    if(isset($_GET['teacher_name']))
                                        {
                                    $teacher_name_get = $_GET['teacher_name'];
                                    }
                                    ?>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Tên giáo viên" class="form-control" style="height: 28px;"
                                               name="teacher_name" value="@if(!empty($teacher_name_get)) {{ $teacher_name_get }} @endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    $email_get ='';
                                    if (isset($_GET['email'])) {
                                        $email_get = $_GET['email'];
                                    }
                                    ?>
                                    <div class="col-md-12">
                                        <input style="height: 28px" type="text"
                                               placeholder="Email giáo viên" class="form-control"
                                               name="email"
                                               value="@if(!empty($email_get)){{$email_get}}@endif">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <?php
                                    $status_accounting_get ='';
                                    if (isset($_GET['status_accounting'])) {
                                        $status_accounting_get = $_GET['status_accounting'];
                                    }
                                    ?>

                                    <div class="col-md-12">
                                        <select class="form-control select2" name="status_accounting" id="">
                                            <option value="" selected>-- Chuyển tài khoản --</option>
                                                <option value="0"
                                                        @if($status_accounting_get == '0') selected @endif
                                                >Chưa chuyển tài khoản</option>
                                            <option value="1"
                                                        @if($status_accounting_get == '1') selected @endif
                                                >Đã chuyển tài khoản</option>

                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                <button class="btn btn-success" type="submit">Tìm Kiếm</button>
                            </div>
                        </div>

                    </form>






                    <div class="box-body">
                        <div style="margin-bottom: 15px">
                            <a href="{{ route('teacher.create') }}"
                               style="color:#fff;background: orange;padding: 5px 10px" class="btnOrang">Thêm mới giáo
                                viên</a>
                        </div>
                        <p>Tổng số : {{ $total }}</p>
                        @if(!empty($teachers))
                            <table id="jobs" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Tên giáo viên</th>
                                    <th>Avatar</th>
                                    <th>Email</th>
                                    <th>Công việc mong muốn</th>

                                    <th>Tỉnh / thành phố</th>
                                    <th>Quận / huyện</th>
                                    <th>Chuyển tài khoản</th>

                                    <th>Thao Tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->teacher_id }}</td>
                                        <td>{{ $teacher->teacher_name }}</td>
                                        <td><img src="{{ $teacher->teacher_images }}" style="width: 50px"></td>
                                        <td>{{ $teacher->teacher_email }} - {{ $teacher->teacher_phone }}</td>
                                        <td>
                                            <?php $career = \App\Entity\Career::getIdCareer($teacher->career_category_id);?>
                                            {{-- {{ $career['career_category_name'] }} --}}
                                        </td>

                                        <td>
                                            <?php
                                            $province = \App\Entity\Province::getId($teacher->province);
                                            ?>
                                            {{ $province['province_name'] }}
                                        </td>
                                        <td>
                                            <?php
                                            $district = \App\Entity\District::getId($teacher->district);
                                            ?>
                                            {{ $district['district_name'] }}
                                        </td>
                                        <td>
                                            @if($teacher->status_accounting == 1)
                                                <span style="color: white;background: green;padding: 5px 10px;">Đã chuyển tài khoản</span>
                                                @else
                                                <span style="color: white;background: red;padding: 5px 10px;">Chưa chuyển tài khoản</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('teacher.edit',['teacher_id' => $teacher->teacher_id]) }}">
                                                <button class="btn btn-primary" type="button"><i class="fa fa-pencil"
                                                                                                 aria-hidden="true"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('teacher.destroy', ['teacher_id' => $teacher->teacher_id]) }}"
                                               class="btn btn-danger btnDelete" data-toggle="modal"
                                               data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>

                            </table>
                            <div class="pull-right">{{ $teachers->links() }}</div>
                        @endif
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
        {{--$('#jobs').DataTable({--}}
        {{--processing: true,--}}
        {{--serverSide: true,--}}
        {{--type: 'GET',--}}
        {{--ajax: '{{route('dt_employee')}}',--}}
        {{--columns: [--}}
        {{--{ data: 'employee_id', name: 'employee_id' },--}}
        {{--{ data: 'employee_code', name: 'employee_code' },--}}
        {{--{ data: 'employee_name', name: 'employee_name' },--}}
        {{--{ data: 'employee_image', name: 'employee_image',--}}
        {{--render: function (data) {--}}
        {{--return '<img src="'+data+'" width="100" />';--}}
        {{--}--}}
        {{--},--}}
        {{--{ data: 'title', name: 'jobs.title' },--}}
        {{--{ data: 'name', name: 'users.name' },--}}
        {{--{ data: 'phone', name: 'phone' },--}}
        {{--{ data: 'email', name: 'email' },--}}
        {{--{ data: 'status', name: 'status' ,--}}
        {{--render: function (data) {--}}
        {{--if(data == 0){--}}
        {{--return 'Chưa đi làm';--}}
        {{--}--}}
        {{--if(data == 1){--}}
        {{--return  'Đã đi làm';--}}
        {{--}--}}
        {{--if (data == 2){--}}
        {{--return  'Đã nộp CV';--}}
        {{--}--}}
        {{--return 'Đã nghỉ làm';--}}
        {{--}},--}}
        {{--{ data: 'enterprise_name', name: 'employer.enterprise_name' },--}}
        {{--{ data: 'created_at', name: 'created_at' },--}}
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
    </script>
@endpush
