@extends('admin.layout.admin')

@section('title', 'Danh sách thành viên' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thành viên
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
                    <form role="search" action="" method="GET" id="submitForm">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $role_get = '';
                                        if (isset($_GET['role'])) {
                                            $role_get = $_GET['role'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="role">
                                            <option value="">-- Thông tin thành viên --</option>
                                            <?php
                                            $list_role = \App\Entity\Role::get_role();
                                            ?>
                                            @foreach($list_role as $id=>$l_role)
                                                <option value="{{ $l_role->role }}"
                                                        @if($l_role->role == $role_get) selected @endif>{{ $l_role->role }}
                                                    .----{{ $l_role->name_role }} ----
                                                </option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $status_email_account = '';
                                        if (isset($_GET['status_email_account'])) {
                                            $status_email_account = $_GET['status_email_account'];
                                        }
                                        ?>
                                        <select class="form-control select2" name="status_email_account">
                                            <option value="">-- Xác thực email --</option>
                                            <option value="0" @if($status_email_account == '0') selected @endif>--
                                                0.Chưa xác thực email --
                                            </option>
                                            <option value="1" @if($status_email_account == '1') selected @endif>-- 1.Đã
                                                xác thực email --
                                            </option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <?php
                                        $email = '';
                                        if (isset($_GET['email'])) {
                                            $email = $_GET['email'];
                                        }
                                        ?>
                                        <input style="height: 28px;" type="text" placeholder="Nhập email"
                                               class="form-control" name="email"
                                               value="@if(!empty($email)) {{$email}} @endif">
                                    </div>
                                </div>


                            </div>


                            <div class="col-md-12 text-center" style="margin-top: 20px">
                                <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                            </div>


                        </div>
                    </form>


                    <div class="box-header">
                        <div class="row text-center">
                            @foreach($list_role as $id=>$l_role)
                                <div class="col-md-3 text-center">


                                    <?php

                                    $total_user = 0;
                                    $total_user = \App\Entity\User::get_count($l_role->role);

                                    ?>

                                    <span style="margin-right: 20px">Tống số {{ $l_role->name_role }} : -- User : {{ number_format($total_user) }}</span>
                                </div>
                            @endforeach


                        </div>


                    </div>
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
                                        <?php
                                        $name_role = \App\Entity\Role::get_name($user->role);
                                        ?>
                                        <span style="color: #fff;background: #009385;padding: 3px 7px;display: inline-block">
                                                {{ $name_role->name_role }}
                                            </span>


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
                                        <a href="{{ route('users.edit', ['id' => $user->id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('users.destroy', ['id' => $user->id]) }}"
                                           class="btn btn-danger btnDelete" data-toggle="modal"
                                           data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
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
    @include('admin.partials.popup_delete')
@endsection

