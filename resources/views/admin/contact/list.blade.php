@extends('admin.layout.admin')

@section('title', 'Danh sách liên hệ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Liên hệ
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách liên hệ</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('contact.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Ngày liên hệ</th>
                                <th style="width: 150px">Chức vụ</th>
                                <th>Họ và tên</th>
                                <th>Hình ảnh</th>
                                <th>Thông tin liên hệ</th>
                                <th>Nội dung liên hệ</th>
                                <th style="width: 100px">Trạng thái</th>

                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contacts as $id => $contact )
                                <tr>
                                    <td>{{ $contact->contact_id }}</td>
                                    <td><?php
                                        $date=date_create($contact->created_at);
                                        echo date_format($date,"d/m/Y");
                                        ?>
                                        <?php
                                        echo date_format($date,"H:i:s");
                                        ?></td>
                                    <?php
                                        $user = \App\Entity\User::getIdUser($contact->user_id);
                                    ?>
                                    @if(!empty($user))

                                        @if($user->role == 1)
                                            <td><span style="color: #fff;background: green;padding: 5px 10px">Ứng viên</span></td>
                                            <?php $employee = \App\Entity\Employee::getEmployee_id($user->id)?>
                                            <td>{{ $employee->employee_name }}</td>
                                            <td><img src="{{ $employee->employee_image }}" width="50px"></td>
                                            <td>
                                                <p>SĐT : {{ $employee->phone }}</p>
                                                <p>Email : {{ $employee->email }}</p>
                                                <p>Địa chỉ :{{ $employee->address }}</p>
                                            </td>
                                        @endif 
                                        @if($user->role == 2)
                                            <td><span style="color: #fff;background: orange;padding: 5px 10px">Nhà tuyển dụng</span></td>
                                            <?php $employer = \App\Entity\Employer::getIdUser($user->id)?>
                                            <td>{{ $employer->enterprise_name }}</td>
                                            <td><img src="{{ $employer->image }}" width="50px"></td>
                                            <td>
                                                <p>SĐT : {{ $employer->phone }}</p>
                                                <p>Email :{{ $employer->email }}</p>
                                                <p>Địa chỉ :{{ $employer->address }}</p>

                                            </td>

                                        @endif
                                        @if($user->role == 3)
                                            <td><span style="color: #fff;background: #0b43c6;padding: 5px 10px">Giáo viên</span></td>
                                            <?php $teacher = \App\Entity\Teacher::getTeacher_id($user->id)?>
                                            <td>{{ $teacher->teacher_name }}</td>
                                            <td><img src="{{ $teacher->teacher_images }}" width="50px"></td>
                                            <td>
                                                <p>SĐT :{{ $teacher->teacher_phone }}</p>
                                                <p>Email :{{ $teacher->teacher_email }}</p>
                                                <p>Địa chỉ :{{ $teacher->address }}</td></p>

                                            </td>
                                        @endif

                                    @else
                                        <td>User cũ không xác định</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                        @endif
                                    <td>
                                        {!! $contact->message !!}
                                    </td>

                                    <td>
                                        @if($contact->status_view == 0)
                                            <span style="color: #fff;background: red;padding: 5px 10px">Chưa xem</span>
                                           @else
                                            <span style="color: #fff;background: green;padding: 5px 10px">Đã xem</span>
                                        @endif

                                    </td>
                                    <td>

                                        <a href="{{ route('contact.edit', ['contact_id' => $contact->contact_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('contact.destroy', ['contact_id' => $contact->contact_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $contacts->links() }}
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

