@extends('site.layout_site.site')

@section('title', 'Quản lý hồ sơ ứng viên')
@section('meta_description', 'Quản lý hồ sơ ứng viên')
@section('keywords', 'Quản lý hồ sơ ứng viên')


@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/intership.css"/>
@endsection

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 col-12 col-12 user_submit_intership">
                    <div class="from_user_submit_intership">
                        <div class="col-xl-12 col-lg-12 left">
                            <div class="title_submut_intership">
                                <h1>Thông tin nộp hồ sở thực tập</h1>
                            </div>
                            @if(session('suscess'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                     style="margin-top: 15px;width: 100%">
                                    <strong>{{ session('suscess') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if(session('erorr'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                     style="margin-top: 15px;width: 100%">
                                    <strong>{{ session('erorr') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <form action="{{ route('updateEmployeeSubmitIntership') }}" method="post"  class="mbformUpdateEmployee"
                                  enctype="multipart/form-data" id="form_update_user">
                                {!! csrf_field() !!}
                                <input type="hidden" name="slug" value="{{ $slug }}">

                                <div class="form-group row mgb5">
                                    <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                        Thời gian thực tập <span class="clRed fw5" id="">(*)</span>
                                    </label>
                                    <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                        <div class="col-md-12 pd0">
                                            <select class="form-control select2" id="" name="internship_time">
                                                <option value="0"
                                                        @if(!empty($inter_ship) && $inter_ship->internship_time == 0) selected @endif >
                                                    Part time
                                                </option>
                                                <option value="1"
                                                        @if(!empty($inter_ship) && $inter_ship->internship_time == 1) selected @endif>
                                                    Full time
                                                </option>
                                                <option value="2"
                                                        @if(!empty($inter_ship) && $inter_ship->internship_time == 2) selected @endif>
                                                    Part time && Full time
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mgb5">
                                    <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">
                                        Mô tả thời gian thực tập <span class="clRed fw5" id="">(*)</span>
                                    </label>
                                    <div class="col-sm-9 gruopRadio mgt5 pdLeft0 borderSelect2">
                                           <textarea class="textarea w100 form-control editor_basic" name="des_time"
                                                     id="editor_des_time"
                                                     style="width: 50%;">{!!   isset($inter_ship->des_time) ? $inter_ship->des_time : ''  !!}</textarea>

                                        <div class="error_message">
                                            <div class="mess_notice_information_verifier clearfix note_text_information_verifier"></div>
                                            <div class="error_reg_mess clearfix error_text_information_verifier"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mgb5">
                                    <label for="staticEmail" class="col-sm-3 col-form-label fw6 text-right">

                                    </label>
                                    <div class="col-sm-9 gruopRadio mgt5 pdLeft0">
                                        <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5"
                                                style="border:none" id="js_btnRegidit"> Nộp hồ sơ thực tập
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
@section('show_js')
    <script src="/public/assets/ckeditor_full/ckeditor.js"></script>
    <script src="/public/assets/js/jquery.validate.min.js"></script>
    @include('site.layout_site.from')
    <script>

        $('.editor_basic').each(function (e) {
            CKEDITOR.replace(this.id);
        });
        // CKEDITOR.instances.description.updateElement('1111111111111111111');
        $('.select2').select2({
            width: '100%',
        });
        $(document).ready(function () {
            //validate
            $("#form_update_user").validate({
                ignore: [],
                onkeyup: false,
                rules: {
                    internship_time: {
                        required: true,
                    },
                    des_time: {
                        required: true,
                    },
                },
                messages: {
                    internship_time: {
                        required: 'Vui lòng chọn thời gian thực tập',
                    },
                    des_time: {
                        required: 'Mô tả thời gian thực tập không được để trống',
                    },

                },
                onfocusout: function (element) {
                    $(element).valid();
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("name");
                    $('.note_text_' + name).hide();
                    $('.error_text_' + name).html('<i class="error"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
                    $('.error_border_' + name).css("cssText", "border: 1px solid #ff0000  !important;");
                    $('.btn-loading').button('reset');
                },
                success: function (label, element) {
                    var name = $(element).attr("name");
                    $('.note_text_' + name).show();
                    $('.error_text_' + name).html('');
                    $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                    $('#js_btnRegidit').attr('disabled', false);

                },
                submitHandler: function (form) {
                    form.submit();
                }

            });
        });
    </script>


@endsection

