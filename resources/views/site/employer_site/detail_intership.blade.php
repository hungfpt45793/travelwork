@extends('site.layout_site.site')
@section('title', isset($employer->enterprise_name) ? 'Thực tập về du lịch tại '.$employer->enterprise_name : 'Công ty thực tập')
<?php
$listtype = \App\Entity\TypeOfBusiness::getIdTypeBusiness($employer->type_of_business_id);
$meta_description = 'Thực tập về du lịch ' . $employer->enterprise_name;
if (!empty($employer->address)) {
    $meta_description .= ' tại ' . $employer->address;
}if (!empty($listtype->type_of_business_name)) {
    $meta_description .= ' trong loại hình doanh nghiệp ' . $listtype->type_of_business_name;
}
$meta_description = ucwords($meta_description);
?>
@section('meta_description') {{ $meta_description }} @endsection
@section('keywords', isset($employer->enterprise_name) ? 'Thực tập về du lịch tại '.$employer->enterprise_name : 'Công ty thực tập')
@section('meta_image', !empty($employer->image) ? asset($employer->image) : ''  )

@section('show_css')

    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/intership.css"/>
    {{--<link rel="stylesheet" type="text/css" href="/public/assets/web/css/detail_job.css"/>--}}
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/input_sale.css"/>
@endsection

@section('content')
    <?php $listStar = \App\Entity\StarEmployer::listStar($employer->employer_id);
    ?>
    <link rel="stylesheet" href="/public/assets/css/jquery.fancybox.min.css">
    <script type="text/javascript" src="/public/assets/js/jquery.fancybox.min.js"></script>

    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                <div class="col-xl-9 col-lg-9 col-md-12 createProfileOnline ">

                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('intership') }}" class=""> <i class="fas fa-link white mgr5"></i> Thực
                                    tập về du lịch</a>
                            </li>
                        </ul>
                    </div>


                    <div class="detailCompany bg-white mgt20 pd20" id="detailCompany">
                        <div class="row">

                            <div class="col-lg-2 col-md-3 col-12 mbdsNone">
                                <div class="logo mgb10">
                                    <div class="img_">
                                        <div class="CropImg CropImg70 CropImgMB60">
                                            <a class="thumbs" href=""
                                               title="{{ isset($employer->enterprise_name) ? $employer->enterprise_name : 'Công ty thực tập' }}">
                                                <img class=""
                                                     src="{{ isset($employer['image']) ? $employer['image'] : ''}}"
                                                     alt="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}"/>
                                            </a>
                                        </div>
                                    </div>
                                    <p class="mgb5 text-center mgt10"><span
                                                class="fw6">Lượt xem : </span>{{ isset($employer->view) ? $employer->view : '' }}
                                    </p>
                                    @if($employer->status_intership == 1)
                                        <div class="mgt10 text-center">
                                        <span class="bdr3" style="    padding: 6px 5px;
    font-size: 12px;
    color: #fff;
    width: 100%;
    background: green;
display: block">
                                           Tuyển thực tập
                                        </span>
                                        </div>
                                    @else
                                        <div class="mgt10 text-center">
                                        <span class="bdr3" style="    padding: 6px 5px;
    font-size: 12px;
    color: #fff;
    width: 100%;
    background: green;
display: block">
                                           Dừng tuyển
                                        </span>
                                        </div>
                                    @endif
                                    @if($employer->status_agency == 1)
                                        <?php
                                        $code_agency = '';
                                        $code_agency = \App\Entity\EmployerAgency::get_code_intro($employer->employer_id)
                                        ?>
                                        <div class="text-center bgorang clwhite"><span
                                                    class="f12">Mã giới thiệu : {{ $code_agency['code_intro'] }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="col-lg-7 col-md-6 col-12">
                                @if($employer->status_intership == 0)
                                    <p class="clred">
                                        Công ty này đã dừng tuyển thực tập
                                    </p>
                                @endif
                                <h1 class="companyTitle f20 fw6 clhome mgb15 mbf18">{{ isset($employer->enterprise_name) ? $employer->enterprise_name : 'Công ty thực tập' }}</h1>

                                <div class="dsNone mbdsBlock mgb5">
                                    @if($employer->status_agency == 1)
                                        <?php
                                        $code_agency = '';
                                        $code_agency = \App\Entity\EmployerAgency::get_code_intro($employer->employer_id)
                                        ?>
                                        <div class="text-center bgorang clwhite"><span
                                                    class="f12">Mã giới thiệu : {{ $code_agency['code_intro'] }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="mgb15 companyDes">
                                    <div class="w100"><p class="mgb5"><span
                                                    class="fw6">Địa chỉ : </span>{{ isset($employer->address) ? $employer->address : 'Đang cập nhật' }}
                                        </p></div>
                                    <div class="w49 mbw100">
                                        <p class="mgb5"><span
                                                    class="fw6">Số điện thoại :</span> **********
                                        </p>
                                    </div>
                                    <div class="w49 mbw100">
                                        <p class="mgb5"><span
                                                    class="fw6">Mã số thuế : </span> {{ isset($employer->tax_code) ? $employer->tax_code : 'Đang cập nhật' }}
                                        </p>


                                    </div>
                                    <div class="w100 mbw100">
                                        <p class="mgb5"><span
                                                    class="fw6"
                                                    style="color: black">Website : </span> {{ isset($employer->website) ? $employer->website : 'Đang cập nhật' }}

                                        </p></div>
                                    <div class="w100">
                                        <?php
                                        $listtype = \App\Entity\TypeOfBusiness::getIdTypeBusiness($employer->type_of_business_id);
                                        ?>
                                        <p class="mgb5 mbdsNone"><span
                                                    class="fw6">Loại hình doanh nghiệp : </span>{{ isset($listtype->type_of_business_name) ? $listtype->type_of_business_name : 'Đang cập nhật thông tin' }}
                                        </p>
                                        <p class="mgb5 dsNone mbdsBlock"><span
                                                    class="fw6">Loại hình DN : </span>{{ isset($listtype->type_of_business_name) ? $listtype->type_of_business_name : 'Đang cập nhật thông tin' }}
                                        </p>

                                    </div>
                                    <div class="w100">
                                        <?php
                                        $business = \App\Entity\Business::getId($employer->business);
                                        ?>
                                        <p class="mgb5 mbdsNone"><span
                                                    class="fw6">Loại hình kinh doanh : </span> {{ isset($business->title) ? $business->title : 'Đang cập nhật thông tin' }}
                                        </p>
                                        <p class="mgb5 dsNone mbdsBlock"><span
                                                    class="fw6">Lĩnh vực KD : </span> {{ isset($business->title) ? $business->title : 'Đang cập nhật thông tin' }}
                                        </p>
                                    </div>

                                    <div class="w49 mbw49 dsInline">
                                        <p class="mgb5"><span class="fw6">Hồ sơ đã nhận : </span>
                                            <?php
                                            $total_save = 0;
                                            $total_save = App\Entity\EmployerIntership::totalCvSave($employer->employer_id)

                                            ?>
                                            {{ isset($total_save) ? $total_save : '' }}

                                        </p>
                                    </div>
                                    <div class="w49 mbw49 dsInline">
                                        <p class="mgb5 clRed"><span class="fw6">Phụ cấp : </span>
                                            @if(!empty($employer->status_allowance))
                                                Có
                                            @else

                                            @endif

                                        </p>
                                    </div>
                                    <div class="w32 mbw49 dsInline dsNone mbdsBlock">
                                        <span class="fw6">Lượt xem : </span>{{ isset($employer->view) ? $employer->view : '' }}
                                    </div>



                                </div>

                            </div>
                            <div class="col-lg-3 col-md-3 col-12 applyIntership">
                                <div class="logo w100">
                                    <div class="img_ text-right float-right">
                                        @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
                                            <?php
                                            $employer_id = $employer->employer_id;
                                            $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                                            $employee_id = $employee->employee_id;

                                            $intership = \App\Entity\EmployerIntership::checkIntership($employer_id, $employee_id)
                                            ?>
                                            @if(empty($intership))
                                                <a href="{{ route('apply_intership',['slug'=>$employer->slug]) }}"
                                                   id="js_applyNow" class="btnOrange f14 bdr5" style="display: block"><i
                                                            class="far fa-paper-plane"></i> Gửi hồ sơ thực tập
                                                </a>
                                            @else
                                                <a href="#" id="" data-toggle="modal" data-target="#js_applyNow_profile"
                                                   class="btnOrange f14 bdr5"
                                                   style="display: block"><i class="far fa-paper-plane"></i> Đã gửi hồ
                                                    sơ
                                                    thực tập
                                                </a>
                                            @endif

                                        @else
                                            <a href="#"
                                               data-toggle="modal" data-target="#loginTiva" class="btnOrange f14 bdr5"
                                               style="display: block"><i
                                                        class="far fa-paper-plane"></i> Gửi hồ sơ thực tập
                                            </a>

                                        @endif

                                        <img class="chuaxathuc pdt10" src="/assets/image/xacthuc.jpg"
                                             style="width: 100px;display: inline-block">
                                    </div>

                                </div>
                                <div class="clearfix"></div>
                                <div class="w100 text-right mgt15 mbtext-center ">
                                    <a class="" href="#" data-toggle="modal" data-target="#btnmodal_benefit">
                                        Hướng dẫn gửi hồ sơ
                                    </a>
                                </div>

                            </div>

                            <div style="width: 100%;text-align: center">
                                @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && $employer->status_intership == 1)
                                    <?php
                                    $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                                    ?>
                                    <div class="mgb15 input_sale">
                                        <div id="fb-root"></div>
                                        <script async defer crossorigin="anonymous"
                                                src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0">
                                        </script>
                                        <div class="fb-share-button"
                                             data-href="{{ route('detail_intership',['slug'=>$employer['slug'] ]) }}?user_id_sale={{$employee->employee_id}}"
                                             data-layout="button" data-size="large">
                                            <a target="_blank"
                                               href="https://www.facebook.com/sharer/sharer.php?u={{ route('detail_intership',['slug'=>$employer['slug'] ]) }}?user_id_sale={{$employee->employee_id}}&amp;src=sdkpreparse"
                                               class="fb-xfbml-parse-ignore js_add_employee_money share_facebook">
                                                <i class="fas fa-dollar-sign"></i> Chia sẻ lên facebook
                                            </a>
                                        </div>

                                        <div class="zalo-share-button" data-href="{{ route('detail_intership',['slug'=>$employer['slug'] ]) }}?user_id_sale={{$employee->employee_id}}"
                                             data-oaid="579745863508352884" data-layout="3" data-color="blue" data-customize="false" style="height: 40px;
    vertical-align: top;">
                                        </div>

                                        <div class="input-group mb-3 copy_link_post">
                                            <input type="text"
                                                   value="{{ route('detail_intership',['slug'=>$employer['slug'] ]) }}?user_id_sale={{$employee->employee_id}}"
                                                   id="myInput"
                                                   class="form-control js_add_employee_money css_no_copy"
                                                   placeholder="copy link chia sẻ"
                                                   readonly style="width: 100%;">

                                            <div class="input-group-append">
                                                <button onclick="myFunction()"
                                                        class="btn btn-outline-secondary copylink js_add_employee_money">
                                                    Copy link thực tập
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>


                    </div>

                    <div class="detailCompany bg-white mgt20 pd20 detailCompany_sticky">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="title">
                                    <h4 class="companyTitle f20 fw6 clhome text-center"><span
                                                class="pdl10 pdr10">Giới thiệu công ty</span></h4>
                                </div>
                                <div class="mgt20 mgb20 contentDetail js_remove_href_a">
                                    <article>
                                        <?php
                                        $content_reomove_script = '';
                                        if (!empty($employer->introduction)) {
                                            $content_reomove_script = App\Ultility\Ultility::preg_replace_script($employer->introduction);
                                        }
                                        ?>
                                        {!! !empty($content_reomove_script) ? $content_reomove_script : 'Đang cập nhật' !!}
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detailCompany bg-white mgt20 pd20">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title">
                                    <h4 class="companyTitle f20 fw6 clhome text-center">
                                        <span class="pdl10 pdr10">
                                            Hình ảnh công ty
                                        </span>
                                    </h4>
                                </div>
                                <div class="mgt20 mgb20 contentDetail">
                                    <div class="ListProductImg">


                                        @if(!empty($employer->images_list))
                                            <div class="slideImage" id="slideImage">
                                                @foreach(explode(',', $employer->images_list) as $idImage => $imageProduct)
                                                    <div class="News pd10">
                                                        <div class="CropImg">
                                                            <a class="thumbs" href="{{ $imageProduct }}"
                                                               data-fancybox="images"
                                                               data-caption="{{ isset($product['title']) ? $product['title'] : '' }}">
                                                                <img class="" src="{{ $imageProduct }}"
                                                                     alt="{{ isset($employer->enterprise_name) ? $employer->enterprise_name : '' }}"
                                                                     width="">
                                                            </a>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>

                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="detailCompany bg-white mgt20 pd20">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title">
                                    <h4 class="companyTitle f20 fw6 clhome text-center"><span
                                                class="pdl10 pdr10">Nội dung thực tập</span></h4>
                                </div>

                                <div class="mgt20 mgb20 contentDetail fw6">
                                    {{--<article>--}}
                                    {{--{!! isset($employer->des_intership) ? $employer->des_intership : 'Đang cập nhật' !!}--}}
                                    {{--</article>--}}
                                </div>
                                <div class="mgt20 mgb20 contentDetail js_remove_href_a">
                                    <article>
                                        <?php
                                        $content_intership_reomove_script = '';
                                        if (!empty($employer->content_intership)) {
                                            $content_intership_reomove_script = App\Ultility\Ultility::preg_replace_script($employer->content_intership);
                                        }
                                        ?>
                                        {!! !empty($content_intership_reomove_script) ? $content_intership_reomove_script : 'Đang cập nhật' !!}
                                    </article>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="detailCompany bg-white mgt20 pd20 starEmployer">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="title text-center">
                                    <h4 class="companyTitle f20 fw6 clhome text-center"><span
                                                class="pdl10 pdr10">Đánh giá công ty</span></h4>

                                    <form role="form" action="{{ route('star_employer') }}" method="POST"
                                          id="star_form_teacher">
                                        {!! csrf_field() !!}
                                        {{ method_field('POST') }}
                                        <div class="row text-left">
                                            <div class=" col-lg-3 col-md-4">
                                                <div class="form-group">
                                                    <label>Sao đánh giá : </label>
                                                    <div class="rate-product text-left"></div>
                                                    <script>
                                                        $(".rate-product").starRating({
                                                            initialRating: 5,
                                                            useFullStars: true,
                                                            starSize: 40,
                                                            disableAfterRate: false,
                                                            strokeColor: '#894A00',
                                                            callback: function (currentRating, $el) {
                                                                $('#rate').val(currentRating);
                                                            }
                                                        });
                                                    </script>
                                                    <input type="hidden" value="" id="rate" name="qty_stars"
                                                           class="star_rate">


                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-md-8">
                                                <div class="form-group">
                                                    <label>Nội dung đánh giá : </label>
                                                    <textarea class="form-control error_border_password"
                                                              placeholder="Nhận xét" rows="4" name="content_star"
                                                              id="content_star" required></textarea>
                                                    <?php  ?>
                                                    <input type="hidden" value="{{ $employer->employer_id }}"
                                                           name="employer_id">
                                                    <input type="hidden"
                                                           value="@if(\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->role) == 1) 1 @else 0 @endif"
                                                           name="checkEmployee" id="checkEmployee">
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <div class="form-group"><i class="clred">
                                                        <div class="mess_notice_content_qty_stars clearfix note_text_qty_stars"></div>
                                                    </i>
                                                    <i class="clred">
                                                        <div class="mess_notice_content_star clearfix note_text_content_star"></div>
                                                    </i>
                                                    <i class="clred">
                                                        <div class="mess_notice_content_star clearfix note_text_checkEmployee"></div>
                                                    </i>
                                                    <button class="btnOrange text-center bdr5" id="btnsubmitStar"
                                                            type="submit">
                                                        Đánh giá công ty
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @if(!empty($listStar))
                                    <h5 class="mgt20 mbb15"> Nội dung đánh giá
                                        <i>({{ isset($totalcount) ? $totalcount : '0' }} đánh giá ) </i></h5>
                                    <div class="rateCustomer">
                                        @foreach($listStar as $lists)
                                            <div class="item">

                                                <div class="row">
                                                    <div class="col-md-3 col-7">
                                                        {{--<p><img src="{{ $product->image }}" width="150"/></p>--}}
                                                        <p class="name">
                                                            @if(!empty($lists['id_user']))
                                                                <?php
                                                                $name = '';
                                                                $user = \App\Entity\User::getIdUser($lists['id_user']);
                                                                if ($user['role'] == 1) {
                                                                    $employee = \App\Entity\Employee::getEmployee_id($lists['id_user']);
                                                                    $name = !empty($employee['employee_name']) ? $employee['employee_name'] : '';
                                                                }
                                                                if ($user['role'] == 2) {
                                                                    $employer = \App\Entity\Employer::getIdUser($lists['id_user']);
                                                                    $name = !empty($employer['enterprise_name']) ? $employer['enterprise_name'] : '';
                                                                }
                                                                if ($user['role'] == 3) {
                                                                    $teacher = \App\Entity\Teacher::getTeacher_id($lists['id_user']);
                                                                    $name = !empty($teacher['teacher_name']) ? $teacher['teacher_name'] : '';
                                                                }
                                                                ?>
                                                            @endif
                                                            {{ isset($name) ? $name : '' }}
                                                        </p>
                                                        <p class="date">
                                                            <?php
                                                            $datefacebook = \App\Ultility\Ultility::getdateFacebook($lists['created_at']);
                                                            echo $datefacebook;
                                                            ?>

                                                        </p>
                                                    </div>
                                                    <div class="col-md-9 col-5">
                                                        <div class="rate-product-comment"></div>
                                                        <script>
                                                            $(".rate-product-comment").starRating({
                                                                initialRating: '{{ isset($lists['qty_stars']) ? $lists['qty_stars'] : '' }}',
                                                                disableAfterRate: false,
                                                                starSize: 20,
                                                                readOnly: true,
                                                                strokeColor: '#894A00'

                                                            });
                                                        </script>
                                                        <div class="hidenMB">
                                                            <p class="question">{{ isset($lists['content_star']) ? $lists['content_star'] : '' }} </p>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    @include('site.module_index_site.dang-ky-tu-van')

                </div>


                {{--//sidebar_intership--}}
                @include('site.sidebar_site.sidebar_intership')

            </div>
        </div>
    </section>

    @include('site.employer_site.item_post_intership_new')
    @include('site.module_index.hotline')

    <div class="modal fade" id="btnmodal_benefit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hướng dẫn gửi hồ sơ thực tập</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! !empty($information['huong-dan-gui-ho-so']) ?  $information['huong-dan-gui-ho-so'] : 'Đang cập nhật thông tin' !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnOrang" data-dismiss="modal">Đóng</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="js_applyNow_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn đã gửi hồ sơ thực tập
                        cho {{ isset($employer->enterprise_name) ? $employer->enterprise_name : 'Công ty thực tập' }}
                        rồi !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ isset($employer->enterprise_name) ? $employer->enterprise_name : 'Công ty thực tập' }} đang
                        xét duyệt hồ sơ của bạn ! <a href="{{ route('list_Jobs_Submit_Employee') }}">chi tiết xem tại
                            đây</a></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnOrang" data-dismiss="modal">Đóng</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="contentMessage">
                        Vui lòng đăng nhập tài khoản ứng viên để ứng tuyển
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('show_js')
    <script>
        $(document).ready(function () {
            $('.js_remove_href_a a').removeAttr("href");

            // alert(stopticky + windowpos);
            // alert('body ' + heightbody +'---------' + 'window' + heightwindow + '+++++++' + posheight);

            $('.submenuPC').click(function () {
                $('.submenu1').toggle();
            });

            $("#star_form_teacher").submit(function (event) {
                var content = $('#content_star').val()
                if (content == null) {
                    $('.note_text_content_star').html('Vui lòng nhập nội dung đánh giá');
                    return false;
                }
                if ($('#rate').val() == '') {
                    $('.note_text_qty_stars').html('Vui lòng chọn sao đánh giá');
                    return false;
                }
                if ($('#checkEmployee').val() == 0) {
                    $('.note_text_checkEmployee').html('Vui lòng đăng nhập tài khoản ứng viên để đánh giá công ty');
                    return false;

                }
                $('#btnsubmitStar').html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang tải đánh giá ...');
                $btn.attr('disabled', false);
                return true;

            });


        });
    </script>
    <script type="text/javascript">
        $('[data-fancybox="images"]').fancybox({
            buttons: [
                'slideShow',
                'share',
                'zoom',
                'fullScreen',
                'close'
            ],
            thumbs: {
                autoStart: true
            }
        });
    </script>
    <script type="text/javascript">
        $('#slideImage').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 450,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });
    </script>

    <script src="/assets/js/ajax_redmore_jquery.min.js"></script>
    <script src="/assets/js/readmore.js"></script>
    <script>
        $('article').readmore({
            speed: 1000,
            moreLink: '<a title="Xem thêm" class="redmore" href="#"> <span> Xem thêm <i class="fas fa-angle-double-down"></i> </span></a>',
            lessLink: '<a title="Thu gọn" class="redmore" href="#">   <span> Thu gọn <i class="fas fa-angle-double-up"></i> </span> </a>',
        });
    </script>
    {{--<script src="/public/assets/js/jquery-3.3.1.min.js"></script>--}}

    <script type="text/javascript">
        @if(session('success_apply_intership'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('success_apply_intership') }}')
        @endif
    </script>

    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            document.execCommand("copy");
            // alert("Copied the text: " + copyText.value);
        }
    </script>
    @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && $employer->status_intership == 1)
        <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id); ?>
        <script>
            $(document).ready(function () {
                $('.js_add_employee_money').click(function () {
                    $.ajax({
                        url: "{!! route('create_employee_share_job') !!}", // gửi ajax đến file result.php
                        type: "get", // chọn phương thức gửi là get
                        dateType: "json", // dữ liệu trả về dạng text
                        data: { // Danh sách các thuộc tính sẽ gửi đi
                            employee_id: '{{ $employee->employee_id }}',
                            employer_id: '{{ $employer->employer_id }}',
                        },
                        success: function (result) {
                            // Sau khi gửi và kết quả trả về thành công thì gán nội dung trả về
                            // đó vào thẻ div có id = result
                            console.log("Thêm thành công");
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            // When AJAX call has failed
                            console.log('Thêm thất bại');
                        },
                    });
                });
            });
        </script>
    @endif

    {{--$post_id,$employee_id,$ip_sale--}}
    @if(!empty($_GET['user_id_sale']))
        <?php
        $employee_id = $_GET['user_id_sale'];
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        ?>
        <script>
            $(document).ready(function () {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{!! route('add_ajax_sale_money_employer') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là post
                    dateType: "text", // dữ liệu trả về dạng text
                    data: { // Danh sách các thuộc tính sẽ gửi đi
                        employer_id: '{{ $employer->employer_id }}',
                        employee_id: '{{ $employee_id }}',
                        ip_sale: "{{ $ip }}"
                    },
                    success: function (result) {
                        // Sau khi gửi và kết quả trả về thành công thì gán nội dung trả về
                        // đó vào thẻ div có id = result
                        console.log("Thêm thành công");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // When AJAX call has failed
                        console.log('Thêm thất bại');
                    },
                });
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{!! route('delete_post_sale_money_employer') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là post
                    dateType: "json", // dữ liệu trả về dạng text
                    data: {},
                    success: function (result) {
                        // Sau khi gửi và kết quả trả về thành công thì gán nội dung trả về
                        // đó vào thẻ div có id = result
                        console.log("Xóa thành công");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // When AJAX call has failed
                        console.log('Xóa thất bại');
                    },
                });
            });
        </script>
    @endif
    <script>
        $('.js_itemsteep').matchHeight()
    </script>
@endsection
