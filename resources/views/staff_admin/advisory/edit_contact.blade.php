@extends('staff_admin.layouts.master')
@section('title', 'Danh sách liên hệ' )
@section('content')
<div class="container-fluid">
	<div class="row row-content">
		{{-- sitebar --}}
		<div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
			@include('staff_admin.sidebars.order')
		</div>
		<div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
			<section class="jobsInteresting bgrWhite bdLightGray radius5 ">
				<div class="contentJobsInteresting pd15 col-f14 ">
					<h1>

                        <?php $user = \App\Entity\User::getIdUser($contact->user_id);?>
                            @if(!empty($user))
                        Chỉnh sửa liên hệ <span style="color: #fff;background: green;padding: 5px 10px;font-size: 14px">@if($user->role == 1) Ứng viên @endif
                            @if($user->role == 2) Nhà tuyển dụng @endif
                                @if($user->role == 3) Giáo viên @endif </span>
                            @endif

                    </h1>
                    @if (session('error'))
                        <div class="alert alert-info">{{ session('error') }}</div>
                    @endif
					<!-- form start -->
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                        <!-- form start -->
                        <?php $updateView = \App\Entity\Contact::updateView($contact->contact_id)?>
                        <form role="form" action="{{ route('staff_advisory_contact.update', ['contact_id' => $contact->contact_id]) }}" method="POST">
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}


                                <!-- Nội dung thêm mới -->
                                <div class="box box-primary">
                                    <!-- /.box-header -->

                                    <div class="box-body">

                                        @if(!empty($user))

                                        @if($user->role == 1)
                                            <?php $employee =  \App\Entity\Employee::getEmployee_ids($user->id)?>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Họ và tên</label>
                                                <input type="text" class="form-control" name="name" placeholder="Họ và tên"
                                                       value="{{ $employee->employee_name }}" readonly>
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Điện thoại</label>
                                                <input type="text" class="form-control" name="phone" placeholder="Điện thoại" value="{{ $employee->phone }}" readonly/>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Email</label>
                                                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $employee->email }}" readonly />
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Địa chỉ</label>
                                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $employee->address }}" readonly>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Avatar</label>
                                            <br>
                                                <img src="{{ $employee->employee_image }}" />

                                        </div>
                                        @endif
                                            @if($user->role == 2)
                                                <?php $employer =  \App\Entity\Employer::getIdUsers($user->id)?>
                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label for="exampleInputEmail1">Họ và tên</label>
                                                        <input type="text" class="form-control" name="name" placeholder="Họ và tên"
                                                               value="{{ $employer->enterprise_name }}" readonly>
                                                    </div>

                                                    <div class="form-group col-6">
                                                        <label for="exampleInputEmail1">Điện thoại</label>
                                                        <input type="text" class="form-control" name="phone" placeholder="Điện thoại" value="{{ $employer->phone }}" readonly/>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label for="exampleInputEmail1">Email</label>
                                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $employer->email }}" readonly />
                                                    </div>

                                                    <div class="form-group col-6">
                                                        <label for="exampleInputEmail1">Địa chỉ</label>
                                                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $employer->address }}" readonly>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Avatar</label>
                                                    <br>
                                                    <img src="{{ $employer->image }}" />

                                                </div>
                                            @endif
                                            @if($user->role == 3)
                                                <?php $teacher =  \App\Entity\Teacher::getTeacher_ids($user->id)?>
                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label for="exampleInputEmail1">Họ và tên</label>
                                                        <input type="text" class="form-control" name="name" placeholder="Họ và tên"
                                                               value="{{ $teacher->teacher_name }}" readonly>
                                                    </div>

                                                    <div class="form-group col-6">
                                                        <label for="exampleInputEmail1">Điện thoại</label>
                                                        <input type="text" class="form-control" name="phone" placeholder="Điện thoại" value="{{ $teacher->teacher_phone }}" readonly/>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label for="exampleInputEmail1">Email</label>
                                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $teacher->teacher_email }}" readonly />
                                                    </div>

                                                    <div class="form-group col-6">
                                                        <label for="exampleInputEmail1">Địa chỉ</label>
                                                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $teacher->address }}" readonly>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Avatar</label>
                                                    <br>
                                                    <img src="{{ $teacher->teacher_images }}" />

                                                </div>
                                            @endif

                                        @else

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Họ và tên</label>
                                                <input type="text" class="form-control" name="name" placeholder="Họ và tên"
                                                    value="{{ $contact->name }}" readonly>
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Điện thoại</label>
                                                <input type="text" class="form-control" name="phone" placeholder="Điện thoại" value="{{ $contact->phone }}" readonly/>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Email</label>
                                                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $contact->email }}" readonly />
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Địa chỉ</label>
                                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ $contact->address }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Avatar</label>
                                            <br>
                                            <img src="{{ $contact->images }}" />
                                        </div>
                                        @endif


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Message</label>
                                            <textarea rows="14" class="form-control editor" id="editor1" name="message"
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
                        </form>
                    </div>
                    </div>
				</div>
			</section>
			<!-- The Modal -->
		</div>
	</div>
</div>
@endsection
