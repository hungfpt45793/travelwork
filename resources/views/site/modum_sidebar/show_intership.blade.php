@if(\Illuminate\Support\Facades\Auth::check()  && (\Illuminate\Support\Facades\Auth::user()->role) == 2)
    <div class="CV bgrWhite radius5 pd20  mgb20 pdb5 UpdateUserTab">
        <div class="title">
            <h5 class="fw6 f120 bdLeftBlueN5x pdl10 blueN mgb0">
               Thông tin tuyển thực tập
            </h5>
        </div>
        <hr class="mgt10 mgb10">
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

                            <div class="form-row mgt20 gruopRadio">
                                <div class="col-md-6">
                                    <label for="inputAddress2" class="fw6" style="display: block;">Tình trạng tuyển thực
                                        tập: <span
                                                class="red">(*)</span></label>
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

                            <div class="form-row mgt20 gruopRadio">
                                <div class="col-md-6">
                                    <label for="inputAddress2" class="fw6" style="display: block;">Trợ cấp <span
                                                class="red">(*)</span></label>
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
                                            class="red">(*)</span></label>
                                <textarea name="des_intership" id="" rows="5" cols="100" class="w100 form-control"
                                          style="width: 100%">{!!   isset($employer->des_intership) ? $employer->des_intership : ''  !!}</textarea>
                            </div>

                            <div class="form-group mgt20">
                                <label for="inputAddress2" class="fw6">Nội dung thực tập : <span class="red">(*)</span></label>
                                <textarea name="content_intership" id="editorintership" rows="5" cols="100"
                                          class="w100 form-control editor"
                                          style="width: 100%">{!!   isset($employer->content_intership) ? $employer->content_intership : ''  !!}</textarea>
                            </div>

                            <div class="form-group">
                                <!-- Google reCaptcha -->
                                <div class="g-recaptcha" id="feedback-recaptcha"
                                     data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                <!-- End Google reCaptcha -->
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

<!-- Modal -->

<style>
    .radio label {
        position: relative;
        margin-left: 25px;
    }

    .radio label input {
        position: absolute;
        left: -25px;
    }
</style>
