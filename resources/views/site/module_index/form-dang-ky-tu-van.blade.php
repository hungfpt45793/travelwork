<div class="modal fade" id="myModal1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="margin-top:60px">

            <div class="modal-content ">
                <button type="button" class="close" data-dismiss="modal"
                    style="position:absolute;right:10px;z-index:999;top:5px;">&times;
                </button>
                <div class="col-xl-12 col-lg-12 col-md-12 JobSeeker EmployerRegistration mgb20 pd15-0">
                    <div class="main">
                        <form class="wpcf7-form dangkiform d-dangkiform" method="post" action="{{route('createResAdvisory')}} ">
                            {!! csrf_field() !!}

                            <p class="text-title font15Im mgt0Im mbf16">
                                Nhà tuyển dụng đăng ký nhận tư vấn
                            </p>
                            <hr>
                            <div class="bodyBox">
                                <div class="accountInfo">
                                    <div class="form-group row">
                                        <label class="col-md-2 col-12 text-left lable">Họ và tên<span>*</span> </label>
                                        <div class="col-md-10 col-12">
                                            <input type="text" name="name_res" class="form-control"
                                                placeholder="Họ và tên"  required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-md-2 col-12 text-left lable">Email<span>*</span>
                                        </label>
                                        <div class="col-md-10 col-12">
                                            <input type="email" name="email_res" class="form-control"
                                                placeholder="Email" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-md-2 col-12 text-left lable">Số điện
                                            thoại<span>*</span> </label>
                                        <div class="col-md-10 col-12">
                                            <input type="number" name="phone_res" class="form-control"
                                                placeholder="Số điện thoại" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 col-12 text-left lable">Lời nhắn <span>*</span></label>
                                        <div class="col-md-10 col-12">
                                            <textarea class="form-control" name="message_res" rows="3"
                                                required></textarea>
                                            <input type="hidden" name="status_res" value="0">
                                        </div>
                                    </div>

                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="form-group row">
                                        <div class="col-12 text-ct">
                                            <button type="submit" class="btn dangkytuvan">ĐĂNG KÝ</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                    <style>
                        .error label {
                            background: #ef5050;
                            color: #fff;
                            padding: 5px;
                            margin-right: 5px;
                        }
                    </style>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="myModal2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"  style="margin-top:60px">

            <div class="modal-content ">
                <button type="button" class="close" data-dismiss="modal"
                    style="position:absolute;right:10px;z-index:999;top:5px;">&times;
                </button>
                <div class="col-xl-12 col-lg-12 col-md-12 JobSeeker EmployerRegistration mgb20 pd15-0">
                    <div class="main">
                        <form class="wpcf7-form dangkiform d-dangkiform" method="post" action="{{route('createResAdvisory')}} ">
                            {!! csrf_field() !!}

                            <p class="text-title font15Im mgt0Im">
                                Người tìm việc đăng ký nhận tư vấn
                            </p>
                            <hr>
                            <div class="bodyBox">
                                <div class="accountInfo">
                                    <div class="form-group row">
                                        <label class="col-md-2 col-12 text-left lable">Họ và tên<span>*</span> </label>
                                        <div class="col-md-10 col-12">
                                            <input type="text" name="name_res" class="form-control"
                                                placeholder="Họ và tên"  required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-md-2 col-12 text-left lable">Email<span>*</span>
                                        </label>
                                        <div class="col-md-10 col-12">
                                            <input type="email" name="email_res" class="form-control"
                                                placeholder="Email" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-md-2 col-12 text-left lable">Số điện
                                            thoại<span>*</span> </label>
                                        <div class="col-md-10 col-12">
                                            <input type="number" name="phone_res" class="form-control"
                                                placeholder="Số điện thoại" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 col-12 text-left lable">Lời nhắn <span>*</span></label>
                                        <div class="col-md-10 col-12">
                                            <textarea class="form-control" name="message_res" rows="3"
                                                required></textarea>
                                            <input type="hidden" name="status_res" value="1">
                                        </div>
                                    </div>



                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="form-group row">
                                        <div class="col-12 text-ct">
                                            <button type="submit" class="btn dangkytuvan">ĐĂNG KÝ</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                    <style>
                        .error label {
                            background: #ef5050;
                            color: #fff;
                            padding: 5px;
                            margin-right: 5px;
                        }
                    </style>

                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    // @if (count($errors) > 0)
    //     $('#myModal1').modal('show');
    // @endif

</script>