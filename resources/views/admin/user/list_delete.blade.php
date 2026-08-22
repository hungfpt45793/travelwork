@extends('admin.layout.admin')

@section('title', 'Danh sách thành viên' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thành viên đã xóa
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách thành viên</a></li>
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



                    <form role="search" action="" method="GET" id="submitForm">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $role = '';
                                        if(isset($_GET['role']))
                                        {
                                            $role = $_GET['role'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="role">
                                            <option value="">-- Thông tin thành viên --</option>
                                            <option value="1" @if($role == '1') selected @endif>-- 1.Ứng viên --</option>
                                            <option value="2" @if($role == '2') selected @endif>-- 2.Nhà tuyển dụng --</option>
                                            <option value="3" @if($role == '3') selected @endif>-- 3.Giáo viên --</option>
                                            <option value="4" @if($role == '4') selected @endif>-- 4.Quản trị viên --</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $status_email_account = '';
                                        if(isset($_GET['status_email_account']))
                                        {
                                            $status_email_account = $_GET['status_email_account'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="status_email_account">
                                            <option value="">-- Xác thực email --</option>
                                            <option value="0" @if($status_email_account == '0') selected @endif>-- 0.Chưa xác thực email --</option>
                                            <option value="1" @if($status_email_account == '1') selected @endif>-- 1.Đã xác thực email --</option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $email= '';
                                        if(isset($_GET['email']))
                                        {
                                            $email = $_GET['email'];
                                        }
                                        ?>
                                        <input style="height: 28px;" type="text" placeholder="Nhập email" class="form-control" name="email" value="@if(!empty($email)) {{$email}} @endif">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center" style="margin-top: 20px">
                                <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                            </div>


                        </div>
                    </form>



                    <div style="padding-left: 20px">

                        <p style="margin-right: 20px">Tống số thành viên : {{ number_format($total_user) }}</p>

                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th width="5%">ID</th>
                                <th>Email</th>
                                <th>Họ và tên</th>
                                <th>Thông tin</th>
                                <th>Xác thực email</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $id => $user )
                                <tr>
                                    <td>{{ ($id+1) }}</td>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @if($user->role == 1)
                                            <span style="color: #fff;background: green;padding: 3px 7px;display: inline-block">
                                                <span style="color: red"></span>1.Ứng viên
                                            </span>
                                        @endif
                                        @if($user->role == 2)
                                            <span style="color: #fff;background: orange;padding: 3px 7px;display: inline-block">
                                               2.Nhà tuyển dụng
                                            </span>
                                        @endif
                                        @if($user->role == 3)
                                            <span style="color: #fff;background: #009385;padding: 3px 7px;display: inline-block">
                                                3.Giáo viên
                                            </span>
                                        @endif
                                        @if($user->role == 4)
                                            <span style="color: #fff;background: red;padding: 3px 7px;display: inline-block">
                                                4.Quản trị viên
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($user->status_email_account == 0)
                                            <span style="color: #fff;background: red;padding: 3px 7px;display: inline-block">
                                                Chưa xác thực
                                            </span>
                                        @else
                                            <span style="color: #fff;background: green;padding: 3px 7px;display: inline-block">
                                                        Đã xác thực
                                                    </span>
                                        @endif

                                    </td>
                                    {{--<td><img src="{{ $user->image }}" width="150"/></td>--}}

                                    <td>
                                        <a href="{{ route('UserRestore', ['id' => $user->id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-share xoayicon mgr5" aria-hidden="true"></i> Khôi phục</button>
                                        </a>
                                        <a  href="{{ route('UserForceDelete', ['id' => $user->id]) }}" class="">
                                            <button class="btn btn-danger btnDelete"> <i class="fa fa-trash-o mgr5" aria-hidden="true"></i> Xóa vĩnh viễn</button>



                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <style>
        .mgr5
        {
            margin-right: 5px;
        }
        .xoayicon {
            -webkit-transform: rotateY(180deg);
            -moz-transform: rotateY(180deg);
            -o-transform: rotateY(180deg);
            -ms-transform: rotateY(180deg);
            transform: rotateY(180deg);
        }
    </style>
    @include('admin.partials.popup_delete')
@endsection

