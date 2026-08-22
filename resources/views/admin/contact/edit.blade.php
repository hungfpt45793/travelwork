@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa liên hệ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>

            <?php $user = \App\Entity\User::getIdUser($contact->user_id);?>
                @if(!empty($user))
            Chỉnh sửa liên hệ <span style="color: #fff;background: green;padding: 5px 10px;font-size: 14px">@if($user->role == 1) Ứng viên @endif
                @if($user->role == 2) Nhà tuyển dụng @endif
                    @if($user->role == 3) Giáo viên @endif </span>
                @endif

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Liên hệ</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <?php $updateView = \App\Entity\Contact::updateView($contact->contact_id)?>
            <form role="form" action="{{ route('contact.update', ['contact_id' => $contact->contact_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-6">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            @if(!empty($user))

                            @if($user->role == 1)
                                <?php $employee =  \App\Entity\Employee::getEmployee_ids($user->id)?>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Họ và tên</label>
                                <input type="text" class="form-control" name="name" placeholder="Họ và tên"
                                       value="{{ $employee->employee_name }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Điện thoại</label>
                                <input type="text" class="form-control" name="phone" placeholder="Điện thoại" value="{{ $employee->phone }}" readonly/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $employee->email }}" readonly />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $employee->address }}" readonly>
                            </div>


							<div class="form-group">
                                <label for="exampleInputEmail1">Avatar</label>
                                <br>
									<img src="{{ $employee->employee_image }}" />

                            </div>
                            @endif
                                @if($user->role == 2)
                                    <?php $employer =  \App\Entity\Employer::getIdUsers($user->id)?>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Họ và tên</label>
                                        <input type="text" class="form-control" name="name" placeholder="Họ và tên"
                                               value="{{ $employer->enterprise_name }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Điện thoại</label>
                                        <input type="text" class="form-control" name="phone" placeholder="Điện thoại" value="{{ $employer->phone }}" readonly/>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $employer->email }}" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ</label>
                                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $employer->address }}" readonly>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Avatar</label>
                                        <br>
                                        <img src="{{ $employer->image }}" />

                                    </div>
                                @endif
                                @if($user->role == 3)
                                    <?php $teacher =  \App\Entity\Teacher::getTeacher_ids($user->id)?>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Họ và tên</label>
                                        <input type="text" class="form-control" name="name" placeholder="Họ và tên"
                                               value="{{ $teacher->teacher_name }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Điện thoại</label>
                                        <input type="text" class="form-control" name="phone" placeholder="Điện thoại" value="{{ $teacher->teacher_phone }}" readonly/>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $teacher->teacher_email }}" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ</label>
                                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $teacher->address }}" readonly>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Avatar</label>
                                        <br>
                                        <img src="{{ $teacher->teacher_images }}" />

                                    </div>
                                @endif
                            @endif

							
                            <div class="form-group">
                                <label for="exampleInputEmail1">Message</label>
                                <textarea rows="4" class="form-control editor" id="editor1" name="message"
                                          placeholder="">{!! $contact->message !!}</textarea>
                            </div>


                            <div class="form-group" style="color: red;">
                                @if ($errors->has('name'))
                                    <label for="exampleInputEmail1">{{ $errors->first('name') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                    <!-- /.box -->

                </div>
                
            </form>
        </div>
    </section>
@endsection

