@extends('staff_admin.layouts.master')

@section('title', 'Quản lý thông tin' )

@section('content')
    <div class="container-fluid">
        <div class="row row-content">
            {{-- sitebar --}}
            <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
                @include('staff_admin.sidebars.category')
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
                <div class="CV bgrWhite radius5 pd20 mgt20 mgb20 pdb5 UpdateUserTab">
                    <div class="title">
                        <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                           Thay đổi thông tin
                        </h5>
                    </div>
                    <hr class="mgt10 mgb10">
                    <div class="content">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 left">
                                @if (session('success'))
                                    <div class="infoAlert" style="width: 100%">
                                        <div class="alert alert-success">
                                            <span>{{ session('success') }}</span>
                                            <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="infoAlert" style="width: 100%">
                                        <div class="alert alert-warning">
                                            <span>{{ session('error') }}</span>
                                            <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-xl-12 col-lg-12 left">
                                <form role="form" action="{{ route('update_staff_info') }}" method="POST" enctype="multipart/form-data">
                                    {!! csrf_field() !!}

                                    <div class="col-xs-12 col-md-12">
                                        <div class="box box-primary">
                                            @if($errors->any())
                                                @foreach ($errors->all() as $error)
                                                    <div class="alert alert-danger" role="alert"
                                                         style="padding: 5px;margin: 2px;display: inline-block;">
                                                        <strong>{{ $error }}</strong>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Thông tin Nhân viên</h3>
                                            </div>

                                            <div class="box-body">

                                                <div class="row">
                                                    <div class="col-xs-12 col-md-12">

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Họ và tên nhân viên</label>
                                                            <input type="text" class="form-control" name="staff_name" placeholder="Họ và tên ứng viên" value="{{ $staff->staff_name }}" >
                                                        </div>



                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">SĐT</label>
                                                            <input type="text" class="form-control" name="staff_phone"
                                                                   placeholder="Số điện thoại" value="{{ $staff->staff_phone }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Ảnh đại diện</label><br>
                                                            <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                                   size="20" />
                                                            <img src="{{ $staff->staff_image }}" width="80" height="70"/>
                                                            <input name="staff_image" type="hidden" value="{{ $staff->staff_image }}"/>
                                                        </div>




                                                    </div>

                                                </div>


                                            </div>
                                            <!-- /.box-body -->
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                            </div>
                                        </div>


                                    </div>
                                </form>
                            </div>

                        </div>


                    </div>
                </div>




            </div>
        </div>
    </div>
@endsection



