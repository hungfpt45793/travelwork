@extends('staff_admin.layouts.master') @section('title', 'Danh sách liên hệ' ) @section('content')
<div class="container-fluid">
    <div class="row row-content">
		{{-- sitebar --}}
		<div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
			@include('staff_admin.sidebars.order')
		</div>
		<div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5">
                <div class="contentJobsInteresting pd15 col-f14">
                    @if (session('error'))
                    <div class="alert alert-info">{{ session('error') }}</div>
                    @endif
                    @if (session('msg'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ session('msg') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <!-- form start -->
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-12">

                                {!! csrf_field() !!}
                                <!-- Nội dung thêm mới -->
                                <div class="box box-primary">
                                    <!-- /.box-header -->
                                    <h5 class="text-info" style="display: inline-block;">Danh sách lịch sử tương tác ntd &nbsp;</h5>
                                    <h5 style="display: inline-block;" class="text-success"></h5>
                                    <form role="form" action="{{ route('staff_employee_interactive.store') }}" method="POST">
                                        <div class="row">
                                            <div class="col-12">
                                            @php
                                            $user_id = Auth::id();
                                            $staff_id = App\Entity\Staff::where('user_id', $user_id)->value('staff_id');
                                            @endphp
                                            <input type="hidden" name="advisory_id" value="{{ $id_res }}">
                                            <input type="hidden" name="staff_id" value="{{ $staff_id }}"></div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">Nội dung tương tác</label>
                                                    <textarea name="content" class="form-control" rows="4" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">Ngày tương tác</label>
                                                    <input type="date" value="{{ date('Y-m-d') }}" name="interactive_day" class="form-control" />
                                                </div>
                                                <button type="submit" class="btn mt-1 btn-success">Lưu</button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr class="hr" />
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive" style="padding-bottom: 20px;">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col ">id</th>
                                                            <th scope="col ">Ngày tương tác</th>
                                                            <th scope="col ">Người tt</th>
                                                            <th scope="col ">Nội dung</th>
                                                            <th scope="col ">Thao tác</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($interactives as $interactive)
                                                        <tr>
                                                        @php
                                                        $staff_name = App\Entity\Staff::where('staff_id', $interactive->staff_id)->value('staff_name');
                                                        $user_id = App\Entity\Staff::where('staff_id', $interactive->staff_id)->value('user_id');
                                                        @endphp
                                                            <td>{{$interactive->id}}</td>
                                                            <td>{{$interactive->created_at}}</td>
                                                            <td>{{$staff_name}}</td>
                                                            <td>{{$interactive->content}}</td>
                                                            @if($user_id==Auth::id())
                                                            <td>
                                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sua">Sửa</button>
                                                                <div class="modal fade" id="sua" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                        <div class="modal-body">
                                                                        <form method="post" action="{{ route('staff_employee_interactive.update',$interactive->id) }}">
                                                                            {!! csrf_field() !!}
                                                                            {!! method_field('put') !!}
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="">Nội dung tương tác</label>
                                                                                    <textarea name="content" class="form-control" rows="4" required>{{$interactive->content}}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                                            </form>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#xoa">Xóa</button>
                                                                <div class="modal fade" id="xoa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Chắc chắn xóa chứ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <form method="post" action="{{ route('staff_employee_interactive.destroy',$interactive->id) }}">
                                                                            {!! csrf_field() !!}
                                                                            {!! method_field('delete') !!}
                                                                            <button type="submit" class="btn btn-primary">Delete</button>
                                                                            </form>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="hr" />
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Họ và tên</label>
                                                <input type="text" class="form-control" name="name_res" placeholder="Họ và tên" value="{{ $res->name_res }}" />
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Điện thoại</label>
                                                <input type="text" class="form-control" name="phone_res" placeholder="Điện thoại" value="{{ $res->phone_res }}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Email</label>
                                                <input type="email" class="form-control" name="email_res" placeholder="Email" value="{{ $res->email_res }}" />
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Địa chỉ</label>
                                                <input type="text" class="form-control" name="address_res" placeholder="Địa chỉ" value="{{ $res->address_res }}" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Message</label>
                                            <textarea rows="14" class="form-control editor" id="editor1" rows="10" name="message_res" placeholder="">{!! $res->message_res !!}</textarea>
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
