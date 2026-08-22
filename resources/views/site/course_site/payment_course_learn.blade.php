@extends('site.layout_site.site')
{{--@section('type_meta', 'website')--}}
@section('title','Thanh toán đơn hàng'.!empty($courses->course_title) ? $courses->course_title : '')
@section('meta_description','Thanh toán đơn hàng'.!empty($courses->course_title) ? $courses->course_title : '' )
@section('keywords','Thanh toán đơn hàng'.!empty($courses->course_title) ? $courses->course_title : '')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" href="/public/assets/css/course/teacher.css"/>
    <link rel="stylesheet" href="/public/assets/css/course/course.css"/>
@endsection

@section('content')
    <section class="course_payment my-5">
        <div class="container">
            <h1>Chọn phương thức thanh toán</h1>

            <div class="">

                <div class="nav ">
                    <div class="payment_method pointer mr-3" data-toggle="tab" href="#payment_momo">
                        <div>
                            <img src="https://img.mservice.io/momo-payment/icon/images/logo512.png" style="width: 24px;"
                                 alt="">
                            <span class="pr-3">Ví điện tử MoMo
                            </span>
                        </div>
                        <i class="fas fa-check text-success d-none"></i>

                    </div>
                    <div class="payment_method pointer  mr-3" data-toggle="tab" href="#payment_vnpay">
                        <div>
                            <img style="width: 24px;"
                                 src="https://tekoventures.vn/wp-content/uploads/2018/09/vnpay-logo.jpg" alt="">
                            <span class="pr-3">VNPAY
                            </span>
                        </div>
                        <i class="fas fa-check text-success d-none"></i>

                    </div>
                    <div class="payment_method pointer active mr-3" data-toggle="tab" href="#payment_banking">
                        <div>
                            <i class="fas fa-money-check-alt"></i>
                            <span class="pr-3">Chuyển khoản ngân hàng
                            </span>
                        </div>
                        <i class="fas fa-check text-success"></i>

                    </div>

                </div>
                <div class="">
                    <div class="tab-content" id="nav-tabContent " style="min-height: 40rem;">
                        <div class="tab-pane fade show active" id="payment_banking" role="tabpanel">
                            <div class="payment_detail row">

                                <div class="col-md-5 border_right_pay_price">
                                    <div class="row">



                                        <div class="col-12 mb-4">
                                            <div style="border-top: 1px solid #E0E0E0;"></div>
                                        </div>
                                        <div class="col-12">
                                            <h5 class="font-weight-bold">Thông tin đơn hàng</h5>
                                        </div>



                                        <div class="col-4 mt-3">
                                            <span>Khóa học:</span>
                                        </div>
                                        <div class="col-8 mt-3">
                                    <span><b>
                                            <span class="btngreen">{{ !empty($courses->course_code) ? $courses->course_code : ''  }}</span> - {{ !empty($courses->course_title) ? $courses->course_title : ''  }}
                                        </b></span><br>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <span>Cách học:</span>
                                        </div>
                                        <div class="col-8 mt-3">
                                    <span><b>
                                            <span class="btngreen">{{ !empty($course_min_price->learn_title) ? $course_min_price->learn_title : ''  }}</span>
                                        </b></span><br>
                                        </div>

                                        <div class="col-4 mt-3">
                                            <span>Tổng thanh toán:</span>
                                        </div>
                                        <div class="col-8 mt-3">
                                            <?php
                                            $pay_price = !empty($course_min_price->learn_discount) ? $course_min_price->learn_discount : $course_min_price->learn_price;
                                            ?>
                                            <strong><span class="fw6" style="color:#EB5757; font-size: 1.25rem;" class="js_course_discount">
                                                    {{ !empty($pay_price) ? number_format($pay_price).'đ' : 'Miễn phí' }}
                                                    </span>
                                            </strong>
                                        </div>
                                        <hr>
                                        <div class="col-12">
                                            <p class="mgb0">Nội dung hỗ trợ</p>
                                        </div>
                                        <div class="col-12 ul_list_train_pay_price">
                                            <ul>
                                                @foreach($list_training_1000 as $trai_1000)
                                                    <li>
                                                        - {{ !empty($trai_1000->trai_title) ? $trai_1000->trai_title : '' }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-12 col-md-7">
                                    <div style="border-top: 1px solid #E0E0E0;"></div>
                                    <form method="post" action="{{ route('payment_course') }}" style="width: 100%">
                                        {!! csrf_field() !!}
                                        <div class="col-12 mt-3">
                                            <h5 class="font-weight-bold">Thông tin khách hàng nhận mã kích hoạt</h5>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-4">
                                                <span>Họ và tên:</span> <b class="clRed">(*)</b>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" class="form-control color_plal f14" name="course_name"
                                                       aria-describedby="name" placeholder="Họ và tên" required
                                                       value="{{ !empty(\Illuminate\Support\Facades\Auth::user()->name) ? \Illuminate\Support\Facades\Auth::user()->name : '' }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <div class="col-4 ">
                                                <span>Số điện thoại:</span> <b class="clRed">(*)</b>
                                            </div>
                                            <div class="col-8">
                                                <input type="number" class="form-control color_pla f14" name="course_phone"
                                                       aria-describedby="Số điện thoại" placeholder="Số điện thoại" required
                                                       value="{{ !empty(\Illuminate\Support\Facades\Auth::user()->phone) ? \Illuminate\Support\Facades\Auth::user()->phone : '' }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-4 ">
                                                <span>Email:</span> <b class="clRed">(*)</b>
                                            </div>
                                            <div class="col-8 ">
                                                <input type="email" class="form-control color_pla f14" name="course_email"
                                                       aria-describedby="Email" placeholder="Email" required
                                                       value="{{ !empty(\Illuminate\Support\Facades\Auth::user()->email) ? \Illuminate\Support\Facades\Auth::user()->email : '' }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4 ">
                                                <span>Nội dung</span>
                                            </div>
                                            <div class="col-md-8 mt-md-3 ">
                                    <textarea class="form-control input-custom-gray color_pla f14"
                                              placeholder="Nội dung" rows="2" name="course_messager"
                                              cols="50"></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="course_id"  value="{{ $course_min_price->courses_id }}">
                                        <input type="hidden" name="learn_id" value="{{ $course_min_price->learn_id }}">
                                        @if(!empty($_GET['employee_id']))
                                            <input type="hidden" name="employee_id" value="{{ $_GET['employee_id'] }}">

                                        @endif
                                        <div class="form-group row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-8 text-md-left text-center ">
                                                <button class="button_custom btn text-uppercase"
                                                        id="Cart_Button_ThanhtoanChuyenkhoan">hoàn thành
                                                </button>
                                                <div class="text-left mgt20">
                                        <span>Chúng tôi sẽ gửi mã kích hoạt qua email ngay sau khi bạn chuyển khoản
                                            thành
                                            công</span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment_momo" role="tabpanel">
                            <div class="payment_detail row">
                                <div style="height:20rem;">
                                    <h1>Dịch vụ này hiện chưa hỗ trợ</h1>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment_vnpay" role="tabpanel">
                            <div class="payment_detail row">
                                <div style="height:20rem;">
                                    <h1>Dịch vụ này hiện chưa hỗ trợ</h1>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

@endsection

@section('show_js')

    <script type="text/javascript" src="{{ asset('/public/assets/web/js/numeral.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.js_course_formality_id').change(function () {
                $.ajax({
                    url: "{!! route('get_ajax_formality_id') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là get
                    dateType: "json", // dữ liệu trả về dạng text
                    data: { // Danh sách các thuộc tính sẽ gửi đi
                        course_id: '{{ $courses->course_id }}',
                        course_formality_id: $(this).val(),
                    },
                    success: function (result) {
                        var course = jQuery.parseJSON(result);
                        if (course.course_price.course_discount > 0) {
                            $('.js_course_discount').html(numeral(course.course_price.course_discount).format('0,0') + 'đ');
                        } else {
                            $('.js_course_discount').html(numeral(course.course_price.course_price).format('0,0') + 'đ');
                        }
                        $('.js_course_formality_des').html(course.course_price.course_formality_des);
                        // console.log(Math.ceil(percent));
                        // console.log();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // When AJAX call has failed
                        console.log('Thêm thất bại');
                    },
                });
            });
        });
    </script>

    <script>
        $(".payment_method").on("click", function () {
            $('.payment_method .fa-check').addClass('d-none');
            href = this.getAttribute('href');
            $(`.payment_method[href="${href}"] .fa-check`).removeClass('d-none');
        })

    </script>
@endsection

