
@extends('staff_admin.layouts.master')

@section('title', 'Đổi mật khẩu' )

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
                            Đổi mật khẩu
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
                                <form action="{{ route('post_change_password') }}" method="post" enctype="multipart/form-data" id="validateForm">
                                    {!! csrf_field() !!}
                                    {{--<div class="form-row mgt20">--}}
                                    {{--<div class="form-group col-lg-12 pdr2p lg-pd0Im">--}}
                                    {{--<label for="inputZip" class="fw6">Email (tài khoản đăng nhập)<span--}}
                                    {{--class="red"></span></label>--}}
                                    {{--<input type="text" class="form-control" id="inputZip" placeholder=" Email" readonly--}}
                                    {{--value="{{ $user->email }}">--}}
                                    {{--</div>--}}

                                    {{--</div>--}}
                                    <input type="hidden" class="form-control" id="inputZip" placeholder=" Email" readonly
                                           value="{{ $user->email }}">

                                    <div class="form-row">
                                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                            <label for="inputZip" class="fw6">Nhập mật khẩu cũ <span
                                                        class="red">(*)</span></label>
                                            <input type="password" class="form-control error_border_password_old" id="inputZip"
                                                   placeholder="Nhập mật khẩu cũ" name="password_old" required>


                                            <div class="mess_notice_password_old clearfix note_text_password_old"></div>
                                            <div class="error_reg_mess clearfix error_text_password_old"></div>


                                            @if (session('faidOldPassword'))
                                                <span class="help-block">
                                               <i> <span class="red"> {{ session('faidOldPassword') }}</span></i>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                            <label for="inputZip" class="fw6">Nhập mật khẩu mới <span
                                                        class="red">(*)</span></label>
                                            <input type="password" class="form-control error_border_password" id="password"
                                                   placeholder="Nhập mật khẩu mới" name="password" required>
                                        </div>

                                        <div class="mess_notice_password clearfix note_text_password"></div>
                                        <div class="error_reg_mess clearfix error_text_password"></div>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-12 pdr2p lg-pd0Im">
                                            <label for="inputZip" class="fw6">Nhập lại mật khẩu mới <span class="red">(*)</span></label>
                                            <input type="password" class="form-control error_border_password_confirmation" id="inputZip"
                                                   placeholder="Nhập lại mật khẩu mới" required name="password_confirmation">

                                            <div class="mess_notice_password_confirmation clearfix note_text_password_confirmation"></div>
                                            <div class="error_reg_mess clearfix error_text_password_confirmation"></div>
                                            @if ($errors->has('password_confirmation'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group textCenter sm-mgt35">
                                        <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5" style="border: none" id="btnLoadding">Lưu mật khẩu mới</button>
                                        <a href="{{ route('management_account') }}" class="pd10-30 clHome bgrBlueN fw7 radius5 dsInline" style="background: #ccc">Hủy đổi mật khẩu</a>

                                    </div>
                                </form>
                            </div>

                        </div>


                    </div>
                </div>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $( "#validateForm" ).validate({
                            ignore: [],
                            onkeyup: false,
                            rules: {
                                password_old: {
                                    required: true,
                                },

                                password: {
                                    required: true,
                                    minlength: 8,
                                },
                                password_confirmation: {
                                    required: true,
                                    minlength: 8,
                                    equalTo: "#password"
                                },
                            },
                            messages: {
                                password_old: {
                                    required: 'Vui lòng nhập mật khẩu',
                                },
                                password: {
                                    required: 'Vui lòng nhập vào mật khẩu.',
                                    minlength: 'Mật khẩu tối thiểu 8 ký tự'
                                },
                                password_confirmation: {
                                    required: 'Vui lòng nhập lại mật khẩu.',
                                    minlength: 'Mật khẩu tối thiểu 8 ký tự',
                                    equalTo: 'Mật khẩu nhập lại không đúng'
                                },
                            },
                            onfocusout: function(element) {
                                $(element).valid();
                            },
                            errorPlacement: function (error, element) {
                                var name = $(element).attr("name");
                                $('.note_text_' + name).hide();
                                $('.error_text_' + name).html('<i class="error"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
                                $('.error_border_' + name).css("cssText", "border: 1px solid #ff0000  !important;");
                                $('.btn-loading').button('reset');
                                // $('.btn-loading').attr('disabled', true)

                            },
                            success: function(label, element) {
                                var name = $(element).attr("name");
                                $('.note_text_' + name).show();
                                $('.error_text_' + name).html('');
                                $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                            },
                        });
                    });

                    //tao jquery load button
                    $('#btnLoadding').click(function() {
                        if ($('#validateForm').valid()) {
                            $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu thay đổi...');
                            $btn.attr('disabled', false);
                        }
                        else {
                        }
                    });


                </script>
            </div>
        </div>
    </div>
@endsection

