@extends('site.layout_site.site')

@section('title', 'Cổng thực tập')
@section('meta_description', 'Cổng thực tập')
@section('keywords', 'Cổng thực tập')


@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/intership.css"/>
@endsection

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 employer_show_intership">
                    @if(\Illuminate\Support\Facades\Auth::check()  && (\Illuminate\Support\Facades\Auth::user()->role) == 2)
                        <div class="from_employer_show_intership">
                            <div class="title_show_intership">
                                <h1 class="">
                                    Thông tin tuyển thực tập
                                </h1>
                            </div>

                            <div class="content">
                                <div class="row">
                                    <div class="col-md-12">
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

                                        @if(!empty($errors->all()))
                                            @foreach($errors->all() as $erorr)
                                                <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                            @endforeach
                                        @endif
                                        <div class="col-xl-12 col-lg-12 left">

                                            <form action="{{ route('update_intership') }}" method="post" enctype="multipart/form-data">
                                                {!! csrf_field() !!}

                                                <div class="form-row mgt10 gruopRadio">
                                                    <div class="col-md-6">
                                                        <label for="inputAddress2" class="fw6" style="display: block;">Tình trạng tuyển thực
                                                            tập: <span class="clRed">(*)</span></label>
                                                        <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                            <input class="form-check-input" type="radio" name="status_intership"
                                                                   id="exampleRadios2"
                                                                   value="0" @if(isset($employer->status_intership) && $employer->status_intership == 0) checked @else checked @endif >
                                                            <label class="form-check-label" for="exampleRadios2">
                                                                Không tuyển thực tập
                                                            </label>
                                                        </div>
                                                        <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                            <input class="form-check-input" type="radio" name="status_intership"
                                                                   id="exampleRadios3"
                                                                   value="1" @if(isset($employer->status_intership) && $employer->status_intership == 1) checked @endif>
                                                            <label class="form-check-label" for="exampleRadios3">
                                                                Đang tuyển thực tập
                                                            </label>
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="form-row mgt10 gruopRadio">
                                                    <div class="col-md-6">
                                                        <label for="inputAddress2" class="fw6" style="display: block;">Trợ cấp <span
                                                                    class="clRed">(*)</span></label>
                                                        <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                            <input class="form-check-input" type="radio" name="status_allowance"
                                                                   id="exampleRadios2"
                                                                   value="0" @if(isset($employer->status_allowance) && $employer->status_allowance == 0) checked @else checked @endif>
                                                            <label class="form-check-label" for="exampleRadios2">
                                                                Không có phụ câp
                                                            </label>
                                                        </div>
                                                        <div class="form-check" style="display: inline-block; margin-right: 15px;">
                                                            <input class="form-check-input" type="radio" name="status_allowance"
                                                                   id="exampleRadios3"
                                                                   value="1" @if(isset($employer->status_allowance) && $employer->status_allowance == 1) checked @endif>
                                                            <label class="form-check-label" for="exampleRadios3">
                                                                Có phụ cấp
                                                            </label>
                                                        </div>
                                                    </div>


                                                </div>



                                                <div class="form-group mgt20">
                                                    <label for="inputAddress2" class="fw6">Mô tả thực tập : <span
                                                                class="clRed">(*)</span></label>
                                                    <textarea name="des_intership" id="des_intership" rows="5" cols="100" class="w100 form-control editor_basic"
                                                              style="width: 100%">{!!   isset($employer->des_intership) ? $employer->des_intership : ''  !!}</textarea>
                                                </div>

                                                <div class="form-group mgt20">
                                                    <label for="inputAddress2" class="fw6">Nội dung thực tập : <span class="clRed">(*)</span></label>
                                                    <textarea name="content_intership" id="editorintership" rows="5" cols="100"
                                                              class="w100 form-control editor_basic"
                                                              style="width: 100%">{!!   isset($employer->content_intership) ? $employer->content_intership : ''  !!}</textarea>
                                                </div>

                                                <div class="form-row mgt20">
                                                    <button type="submit" class="pd10-30 whiteIm bgrBlueN fw7 radius5" style="border:none">
                                                        Lưu thông tin
                                                    </button>

                                                </div>
                                            </form>
                                        </div>



                                    </div>


                                </div>
                            </div>
                        </div>
                @else


                @endif





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

