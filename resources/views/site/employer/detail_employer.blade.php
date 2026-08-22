<?php
$meta = \App\Entity\Config_meta::getslug('chi-tiet-nha-tuyen-dung');
?>
@extends('site.layout.site')
@section('title', $employer->enterprise_name.' tuyển làm việc du lịch')
<?php
$meta_description = $employer->enterprise_name . ' tuyển làm việc du lịch';
if ($employer->address) {
    $meta_description .= ' có địa chỉ tại ' . $employer->address;
}
if ($employer->email) {
    $meta_description .= ' có email liên hệ ' . $employer->email;
}
$meta_description = ucwords($meta_description);
?>
@section('meta_description'){{ $meta_description }}@endsection
@section('keywords', $employer->enterprise_name)
@if(strlen($employer['image']) > 250)
    @section('meta_image', isset($employer->image) ? asset($employer->image) : asset('/CV/noimage.png'))
@else
    @if(file_exists(public_path().$employer['image']))
        @section('meta_image', isset($employer->image) ? asset($employer->image) : asset('/CV/noimage.png'))
@else
    @section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@endif
@endif
@section('content')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_employer') }}" class=" f18 md-f14 mgb0">Danh sách nhà tuyển
                                    dụng</a>
                            </li>
                        </ul>
                    </div>

                    <div class="InfoCompanyJob mgt20">
                        <div class="main">
                            <div class="notificationBox bkwhite formJobLarge ">
                                <div class="bodyBox row">
                                    <div class="col-xl-3">
                                        <div class="CropImg CropImg60 CropImgMB60">
                                            <div class="thumbs">

                                                <img class="responsive-img"
                                                     src="{{ isset($employer['image']) ? asset($employer['image']) : asset('assets/image/avatarEmployer.png')}}"
                                                     alt="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}"
                                                     title="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}">

                                            </div>
                                        </div>

                                        @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
                                            <?php
                                            $employee = '';
                                            $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);

                                            $check_follow = \App\Entity\Employee_follow_employer::check_employee_follow_employer($employee->employee_id, $employer->employer_id)
                                            ?>
                                        @endif
                                        @if(empty($check_follow))
                                            <div class="text-l mbdsNone">
                                                <span class="btnGreen js_employee_follow_employer mgt15"
                                                      style="padding: 8px 15px;cursor: pointer;display: inline-block">Theo dõi nhà tuyển dụng </span>
                                            </div>

                                            <div class="text-center dsNone mbdsBlock">
                                                <span class="btnGreen js_employee_follow_employer mgt15"
                                                      style="padding: 5px 10px;cursor: pointer;display: inline-block">Theo dõi nhà tuyển dụng </span>
                                            </div>
                                        @else
                                            <div class="text-center mbdsNone">
                                                <span class="btnGreen mgt15"
                                                      style="padding: 8px 15px;cursor: pointer;display: inline-block">Đã theo dõi nhà tuyển dụng </span>
                                            </div>

                                            <div class="text-center dsNone mbdsBlock">
                                                <span class="btnGreen mgt15"
                                                      style="padding: 5px 10px;cursor: pointer;display: inline-block">Đã theo dõi nhà tuyển dụng</span>
                                            </div>
                                        @endif


                                    </div>
                                    <div class="col-xl-9">

                                        <?php
                                        $email = 'name@example.com';
                                        $domain = strstr($email, '@@');
                                        echo $domain; // prints @example.com

                                        //                                        $user = strstr($email, '@', true); // As of PHP 5.3.0
                                        //                                        echo $user; // prints name
                                        ?>


                                        <h1 class="fontBold f20"> {{$employer->enterprise_name}}</h1>
                                        <p class="mgb5"><i class="fas fa-map-marker-alt"></i> Địa
                                            chỉ:{{$employer->address}}</p>

                                        <p class="mgb5">
                                            <span class=" dsInline">
                                                <i class="fab fa-internet-explorer f16"></i> Website :

                                        <span class="dsInline">
                                            <span class="green  f14 dsInline mgr10"> {{ $employer['website'] }}</span>
                                        </span></span>
                                        </p>


                                        {{--<p class="mgb5"><i class="far fa-envelope"></i> Email: {{$employer->email}}</p>--}}
                                        <p class="mgb5">
                                        @if($employer['status_intership'] == 1)
                                            <div class="text-left mbdsNone">
                                                <a href="{{ route('detail_intership',['slug' => $employer['slug']]) }}"
                                                   class="btnGreen js_employee_follow_employer"
                                                   style="padding: 5px 10px;cursor: pointer;display: inline-block;color: #fff">Xem
                                                    tin tuyển thực tập</a>
                                            </div>

                                            <div class="text-center dsNone mbdsBlock">
                                                <a href="{{ route('detail_intership',['slug' => $employer['slug']]) }}"
                                                   class="btnGreen js_employee_follow_employer"
                                                   style="padding: 5px 10px;cursor: pointer;display: inline-block;color: #fff">Xem
                                                    tin tuyển thực tập</a>
                                            </div>
                                            @endif

                                            </p>
                                            <div class="jsSocial mgb10">
                                                <script type="text/javascript"
                                                        src="https://s7.addthis.com/js/300/addthis_widget.js"></script>
                                                <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                                                    <a class="addthis_button_facebook"></a>
                                                    <a class="addthis_button_twitter"></a>
                                                    <a class="addthis_button_email"></a>
                                                    <a class="addthis_button_pinterest_share"></a>
                                                    <a class="addthis_button_compact"></a>
                                                    <a class="addthis_counter addthis_bubble_style"></a>
                                                </div>
                                            </div>
                                            <div class="ContentPost">
                                                <div style="display: inline-block;">
                                                    <script src="https://sp.zalo.me/plugins/sdk.js"></script>
                                                    <div class="zalo-share-button"
                                                         data-href="{{ \App\Ultility\Ultility::getUrl() }}"
                                                         data-oaid="579745863508352884" data-layout="2"
                                                         data-color="blue"
                                                         data-customize=true
                                                         style="background: #03a3fb;color: #fff;padding: 1px 10px;"><img
                                                                src="{{ asset('assets/image/logozalo.jpg') }}"
                                                                title="Chia sẻ zalo tại sanketoan.vn"
                                                                alt="Chia sẻ zalo tại sanketoan.vn"
                                                                style="width: 30px;">Chia sẻ Zalo
                                                    </div>
                                                </div>
                                            </div>


                                    </div>
                                    <div class="col-xl-12 mgt25">

                                        <div class="mg0 ContentEmployer">
                                            <?php
                                            $content_reomove_script = '';
                                            if (!empty($employer->introduction)) {
                                                $content_reomove_script = App\Ultility\Ultility::preg_replace_script($employer->introduction);
                                            }
                                            ?>
                                            {!! !empty($content_reomove_script) ? $content_reomove_script : '' !!}
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <section class="jobsSimilar bgrWhite bdLightGray radius5 mgt20">
                            <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                                <h2 class="textUpper fw7 f18 white bgrBlueN mgb0">
                                    VIỆC LÀM CÙNG NHÀ TUYỂN dụng
                                </h2>
                            </div>
                            <div class="contentJobsSimilar pdl10 pdr10 col-f14">
                                <?php
                                $allJobRelatives = App\Entity\Job::showJobWithEmployerId($employer->employer_id, 20);
                                ?>
                                @if(!empty($allJobRelatives))
                                    @foreach( $allJobRelatives as $allJobRelative)
                                        <div class="bdBottomGray hvbgrClick">
                                            <a href="{{ route('job_detail',['slug'=>$allJobRelative->slug]) }}"
                                               class="noDecoration block  pdl10 pdr10 hvBoxShadow">
                                                <div class="row pdt10 lg-pd10 col-f12">
                                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="infoSimilar inBlock CutText101 pdl6p xl-pdl8p sm-pdl12p">
                                                            <p class="fontBold textCap black mgb0"><i
                                                                        class="far fa-star f28 col-f15 blueN  mgr5"></i> {{isset($allJobRelative->title) ? $allJobRelative->title :''}}
                                                            </p>
                                                            <?php
                                                            $empoyer = \App\Entity\Employer::getIdemployer($allJobRelative->employer_id)
                                                            ?>
                                                            <p class="nameCompany mgb5 gray">
                                                                <i>{{isset($empoyer->enterprise_name) ? $empoyer->enterprise_name :''}}</i>
                                                            </p>

                                                            {{--<div class="infoSimilar inBlock CutText101 pdl6p xl-pdl8p sm-pdl12p w88">--}}
                                                            {{--<p class="fontBold textCap black mgb0"> {{ $jobFacebookRelative->title }}</p>--}}
                                                            {{--<p class="nameCompany mgb5 gray"><i>--}}
                                                            {{--{{ $jobFacebookRelative->employer }}</i></p>--}}
                                                            {{--</div>--}}
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 black textCenter lg-textLeft lg-mg lg-block">
                                                        <span class="lg-inBlockIm"><i
                                                                    class="fas fa-hand-holding-usd money"></i> Lương</span>
                                                        <?php
                                                        $salary = \App\Entity\Salary::getIdSalary($allJobRelative->salary_id);
                                                        ?>
                                                        <span class="block lg-inBlockIm">{{isset($salary->description) ? $salary->description :'Đang cập nhật'}}</span>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 black textCap textCenter lg-textLeft lg-mg lg-block">
                                                        <?php
                                                        $district = \App\Entity\District::getId($allJobRelative->district);
                                                        $province = \App\Entity\Province::getId($allJobRelative->province);
                                                        ?>
                                                        <span class="block lg-inBlockIm">{{$district['district_name']}}
                                                            <span class="block lg-inBlockIm">{{$province['province_name']}}</span></span>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 black textCenter lg-textLeft lg-mg lg-block">
                                                        <span class="lg-inBlockIm clorang"><i class="fas fa-clock"></i> Ngày đăng tin </span>


                                                        <span class="block lg-inBlockIm clorang"><?php
                                                            $date_facebook = \App\Ultility\Ultility::getdateFacebook($allJobRelative['updated_at']);
                                                            echo $date_facebook;
                                                            ?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="col-12 text-center hvbgrBlueN">
                                    <a href="{{route('list_job_face')}}" class="block hvWhite pd10">Xem tất cả việc
                                        làm</a>
                                </div>
                            </div>
                        </section>


                        @include('site.module_index.dang-ky-tu-van')

                    </div>
                </div>

            </div>
        </div>
    </section>
    @include('site.module_index.hotline')

    <div class="modal fade bd-example-modal-lg" id="employee_follow_employer" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="js_alert_success">

                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary js_employee_folow_employer" data-dismiss="modal">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
    @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
        <script>

            $('.js_employee_follow_employer').click(function () {
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: '{!! route('ajax_employee_follow_employer') !!}',
                    data: {
                        employee_id: '{{ $employee['employee_id'] }}',
                        employer_id: '{{ $employer['employer_id'] }}',
                    },
                    success: function (result) {
                        $('#employee_follow_employer').modal('show');
                        $('.js_alert_success').html('Theo dõi nhà tuyển dụng thành công ! Bạn sẽ nhận được thông báo mỗi khi nhà tuyển dụng dăng tin tuyển dụng');
                    },
                    error: function (result) {
                        $('#employee_follow_employer').modal('show');
                        $('.js_alert_success').html('Theo dõi nhà tuyển dụng thất bại ! Vui lòng thử lại');
                    }
                });
            });
        </script>
    @endif
    <script>
        $('.js_remove_href_a a').removeAttr("href");
    </script>
@endsection

