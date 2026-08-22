@extends('site.layout_site.site')
<?php
$meta_description = '';
if (!empty($vouchers->des_voucher)) {
    $meta_description = $vouchers->des_voucher;
} else {
    $meta_description = (isset($vouchers->name_voucher) ? $vouchers->name_voucher : '') . ' trong ' . (isset($cate_child_voucher->name_cate_child) ? $cate_child_voucher->name_cate_child : '');
}
$meta_description = ucwords($meta_description);
?>
@section('title', !empty($vouchers->meta_title) ? $vouchers->meta_title : $vouchers->name_voucher)
@section('canonical',  !empty($vouchers->slug_voucher) ? route('getVoucher', ['slug_voucher' => $vouchers->slug_voucher]) : '')
@section('meta_description', !empty($meta_description) ? $meta_description : '')
@section('keywords', !empty($vouchers->meta_title) ? $vouchers->meta_title : $vouchers->name_voucher)
@section('meta_image', !empty($vouchers->image_voucher) ?asset($vouchers->image_voucher) : asset($information['og_image']))
@section('meta_url', !empty($vouchers->slug_voucher) ? route('getVoucher', ['slug_voucher' => $vouchers->slug_voucher]) : ''  )

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/voucher.css"/>
    <style>
        a.linkCourseInVoucher:hover > div {
            background: #dbefa9b3;
            transition: .2s;
        }

        a.NoDecoration:hover {
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    @include('site.partials.slider_new')
    <section class="content pdt20 bgrGray detailVoucher">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            @if(!empty($cate_voucher->slug_cate_voucher))
                                <li class="nav-item ">
                                    <span><i class="fas fa-chevron-right"></i></span>
                                </li>
                                <li class="nav-item pd8">
                                    <a href="{{ route('getAllCategoryVoucher',['slugCategoryVoucher'=>$cate_voucher->slug_cate_voucher]) }}">{{ $cate_voucher->name_cate_voucher }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="info bgrWhite pd20 radius10">
                        <div class="title">
                            <h1 class="blueN f24">{{ isset($vouchers->name_voucher) ? $vouchers->name_voucher : '' }}</h1>
                            <p class="f17"><span class="f17 clFile">Loại file: <b><i
                                                class="fas fa-file-archive"></i> .{{ isset($vouchers->name_voucher) ? $vouchers->type_voucher : '' }}</b></span>
                                &nbsp; | &nbsp; <span class="f17">Lượt xem: <i
                                            class="far fa-eye"></i> {{ isset($vouchers->view_voucher) ? $vouchers->view_voucher : '0' }}</span>
                                &nbsp; | &nbsp; <span class="f17">Lượt tải: <i
                                            class="fas fa-download"></i> {{ isset($vouchers->dowload_voucher) ? $vouchers->dowload_voucher : '0' }}</span>
                                &nbsp;
                                &nbsp; <span class="f17" style="display: inline-block">

                                </span>


                            </p>
                        </div>


                        @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && $vouchers->sale_money == 1)
                            <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id); ?>

                        @endif

                        <div class="lib_btn_share">
                            <div class="box_btn_share js_box_btn_share">
                                <i class="fas fa-share"></i>
                                Chia sẻ bài viết hữu ích
                            </div>
                            <div class="show_hidden_btn_share js_show_hidden_btn_share">
                                <div class="click_show_hiden js_click_show_hiden">
                                    <i class="fas fa-times"></i>
                                </div>
                                <p class="text_fb_zalo">Chia sẻ thông tin hữu ích</p>
                                <div class="btn_share_facebook">
                                    <div id="fb-root"></div>
                                    <script async defer crossorigin="anonymous"
                                            src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v18.0&appId=423707121644549&autoLogAppEvents=1"
                                            nonce="eJnkMwgL"></script>
                                    <div class="fb-share-button"
                                         data-href="{{ route('getVoucher',['slug_voucher'=>$vouchers->slug_voucher]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif" data-layout=""
                                         data-size=""><a target="_blank"
                                                         href="https://www.facebook.com/sharer/sharer.php?u={{ route('getVoucher',['slug_voucher'=>$vouchers->slug_voucher]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif&amp;src=sdkpreparse"
                                                         class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                                </div>
                                <div class="btn_share_zalo">
                                    <div class="zalo-share-button"
                                         data-href="{{ route('getVoucher',['slug_voucher'=>$vouchers->slug_voucher]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif"
                                         data-oaid="579745863508352884" data-layout="3" data-color="blue"
                                         data-customize="false" style="height: 40px;
    vertical-align: top;">
                                    </div>
                                </div>

                                <div class="input-group-append">
                                    <button onclick="myFunction()"
                                            class="btn btn-outline-secondary copylink js_add_employee_money">
                                        Copy link
                                    </button>
                                </div>
                                <div class="input-group mb-3 copy_link_post">
                                    <input type="text"
                                           value="{{ route('getVoucher',['slug_voucher'=>$vouchers->slug_voucher]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif"
                                           id="myInput"
                                           class="form-control js_add_employee_money css_no_copy"
                                           placeholder="copy link chia sẻ"
                                           readonly style="">


                                </div>
                            </div>
                        </div>



                        <div class="content">
                            <p>
                                {{ isset($vouchers->des_voucher) ? $vouchers->des_voucher : '' }}
                            </p>
                            <div class="contentVoucher">
                                <?php
                                $content_reomove_script = '';
                                if (!empty($vouchers->content_voucher)) {
                                    $content_reomove_script = App\Ultility\Ultility::preg_replace_script($vouchers->content_voucher);
                                }
                                ?>
                                {!! !empty($content_reomove_script) ? $content_reomove_script : '' !!}
                            </div>

                            <hr class="mbdsNone dsBlock">

                            @if(empty($vouchers->link_dowload_file))
                                <div>
                                    <div class="mbdsNone dsBlock">
                                        <a href="https://docs.google.com/gview?url={{ asset('upload/'.$vouchers->link_dowload_voucher) }}&embedded=true"
                                           target="_blank" class="btnGreen"
                                           style="padding: 5px 10px;display: inline-block;float: right">Xem chi tiết
                                            biểu
                                            mẫu</a>
                                        <iframe src="https://docs.google.com/gview?url={{ asset('upload/'.$vouchers->link_dowload_voucher) }}&embedded=true"
                                                frameborder="0"></iframe>
                                    </div>
                                    <hr class="mbdsNone dsBlock">

                                    <div class="dsNone mbdsBlock">
                                       <img style="width: 100%;max-width: 100%;margin-bottom: 20px" src="{{ !empty($vouchers->image_voucher) ? asset($vouchers->image_voucher) : '' }}">
                                    </div>
                                    <a href="{{ asset('upload/'.$vouchers->link_dowload_voucher) }}"
                                       data-id=" {{ $vouchers->id_voucher }}"
                                       download="{{ $vouchers->slug_voucher }}.{{ isset($vouchers->name_voucher) ? $vouchers->type_voucher : '' }}"
                                       class="pd10 radius5 white noDecoration hvWhite bgrDownload mgt10 dsInline js_add_upload_href"
                                       style="background-color: orange;margin-top: 6px;padding: 6px 10px;vertical-align: text-bottom;color: #fff"
                                       id="dowloadVoucher"><i
                                                class="fas fa-cloud-download-alt"></i> Tải xuống</a>

                                </div>
                            @else
                                <div style="display: inline-block;margin-right: 20px;">

                                    <a target="_blank"
                                       href="https://www.facebook.com/sharer/sharer.php?u={{ route('getVoucher',['slug_voucher'=>$vouchers->slug_voucher]) }}&ampsrc=sdkpreparse"
                                       class="fb-xfbml-parse-ignore js_add_employee_money share_facebook  js_click_href"><i
                                                class="fas fa-share"></i> Chia sẻ tài liệu</a><i class="mgf5">(Vui lòng
                                        chia sẻ tài liệu để hiện nút tải xuống)</i>
                                    <br>
                                    <a href="{{ $vouchers->link_dowload_file }}" target="_blank"
                                       data-id=" {{ $vouchers->id_voucher }}"
                                       class="pd10 radius5 white noDecoration hvWhite bgrDownload mgt10 dsInline js_add_dowload_href"
                                       style="background-color: orange;margin-top: 6px;padding: 6px 10px;vertical-align: text-bottom;color: #fff"
                                       id="dowloadVoucher"><i
                                                class="fas fa-cloud-download-alt"></i> Tải xuống</a>
                                </div>
                            @endif

                            @if(!empty($tag_child_voucher))
                                <div class="tagVoucher">
                                    <div class="post-tags">
                                        <span class="tag-title fw6" style="color: black !important;"><i
                                                    class="fas fa-copy"></i> Nhóm tài liệu khác : </span>
                                        @foreach($tag_child_voucher as $tag)
                                            <a href="{{ route('getChildVoucher',['slugChildVoucher'=>$tag->slug_cate_child]) }}"
                                               rel="tag">{{ isset($tag->name_cate_child) ? $tag->name_cate_child : '' }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="mgb10 DetailJobListCareer" style="font-size: 17px !important;">
                                <i class="fa fa-tags blueN"></i>
                                <a class="tag-title fw6" href="{{ route('list_type_voucher') }}" target="_blank"
                                   style="color:black;">
                                    Danh sách từ khóa:
                                </a>
                                @if (!empty($vouchers->tags))
                                    <ul class="tags mbdsNone mb-5">
                                        @php
                                            $tags = explode(',',$vouchers->tags)
                                        @endphp
                                        @foreach ($tags as $tag)
                                            @php
                                                $tag_slug = str_slug($tag, '-');
                                            @endphp
                                            <li>
                                                <a href="{{ route('detail_type_voucher',['tag_slug'=>$tag_slug]) }}">
                                                    {{ $tag }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            {{--<a href="">Download Text</a>--}}


                            <div>
                                @include('site.default_site.list_pod_cart')
                            </div>
                        </div>
                    </div>
                </div>
                @include('site.sidebar_site.sidebar_course_new')
            </div>
            <div class="row">
                <div class="col-12">
                    <section class="attractiveJobs pt-5 pb-5" style="background:#ffffff">
                        <div class="infoAttractiveJobs">
                            <div class="row">

                                @foreach (App\Entity\Job::showJobVip() as $id => $job)
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 item_job_home">
                                        <a href=" {{ route('job_detail',['slug'=>$job->slug]) }}"
                                           class=" hvBlueDN textCap fw6 blueDN noDecoration">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3 class="f18 cutTitle">{{$job->title}}</h3>
                                                    <p class="item_job_enterprise_name fw6 cutTitle">{{$job->enterprise_name}}</p>
                                                </div>

                                                <div class="col-lg-12">
                                                    <p class="CutTextW300 item_job_address"><i
                                                                class="fas fa-map-marker-alt address"></i>

                                                        @if(isset($job->district_name))
                                                            {{ $job->district_name }}
                                                        @endif
                                                        @if(!empty($job->district_name))
                                                            -
                                                        @endif
                                                        @if(isset($job->province_name))
                                                            {{ $job->province_name }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-lg-12">
                                                    <p><span class="item_job_salary">
                                                            <i class="fas fa-hand-holding-usd money"></i>
                                                            <span class="mbdsNone">   Lương: </span>
                                                            {{$job->salary_description}}
                                                        </span>
                                                        <?php
                                                        $date = date_create($job->deadline_submit_profile);
                                                        ?>
                                                        <span class="item_job_date">
                                                            <i class="fas fa-calendar-times clorange"></i>
                                                            <span class="mbdsNone">  Hạn nộp: </span>
                                                            {{ date_format($date,"d/m/Y") }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                                <div class="col-12 text-center pd10">
                                    {{--<a class="f18" href="{{route('list_cate_job')}}"><i class="fas fa-arrow-right"></i> 5.000 + việc làm khác</a>--}}
                                    <a class="f18" href="{{route('list_job_face')}}"><i class="fas fa-arrow-right"></i>
                                        1.000 + việc làm
                                        khác</a>
                                </div>


                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>


    <!-- <section class="content pdt20 bgrGray ">
        <div class="container container_w_1200">
            <div class="list_re_voucher vouchers mgb20 bdLightGray section_box_content">
                <div class="bgrBlueN header_box">
                    <h2 class="title_box  fw6 f20 mgb0 col-f14">
                        <a>
                            Các mẫu tương tự
                        </a>
                    </h2>
                </div>
                <div class="slideNews bgrWhite bdBottomGray ">
                    <div class="mgt15">
                        <ul>
                            relate_voucher as $relate_vh
                                <li> -->
    {{--<a href="route('getVoucher',['slug_voucher'=> $relate_vh['slug_voucher']])" class="thumbs f16"
       title="isset($relate_vh['name_voucher']) ? $relate_vh['name_voucher'] : '' " >
        isset($relate_vh['name_voucher']) ? $relate_vh['name_voucher'] : ''
    </a>--}}
    <!-- </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section> -->



    <!-- Phần nội dung -->
    <!-- Phần nội dung -->
    <div class="noti_mobile_show">
        <div class="modal fade" id="message_noti_mobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="contentNoti">
                        <div class="close_modal" data-dismiss="modal">Đóng <i class="far fa-times-circle mgl5"></i>
                        </div>
                        <img class="" src="{{ !empty($information['anh-tai-app-ve-chai']) ? asset($information['anh-tai-app-ve-chai']) : asset('assets/images/1024x577.png') }}">
                        <div class="modal_dowload">
                            <a class="d-sm-inline"
                               href="{{ isset($information['link-tai-app-android-ve-chai']) ?  $information['link-tai-app-android-ve-chai'] : '' }}"><img
                                        class="" src="{{ asset('assets/image/android.png') }}">
                            </a>
                            <a class="d-sm-inline"
                               href="{{ isset($information['link-tai-app-ios-ve-chai']) ?  $information['link-tai-app-ios-ve-chai'] : '' }}"><img
                                        class="" src="{{ asset('assets/image/ios.png') }}"></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    @include('site.partials_site.fixel_mobile_bottom')
@endsection

@section('show_js')
    <script>

        $(document).ready(function () {
            $('.js_matchHeight_title_voucher').matchHeight();
            var user = getCookie("modal_noti");
            console.log(user);
            if (user != 'modal_noti_hide') {
                if ($(window).width() <= 500) {
                    $('#message_noti_mobile').modal('show');
                    $('.close_modal').click(function () {
                        setCookie("modal_noti", 'modal_noti_hide', 30);

                        $('#message_noti_mobile').modal('hide');
                    });
                }
            }
        });

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

    </script>
    {{--//copy đường dẫn chia sẻ--}}
    <script>
        $('.js_click_show_hiden').click(function(){
            $('.show_hidden_btn_share').hide();
        });
        $('.js_box_btn_share').click(function(){
            $('.show_hidden_btn_share').show();
        });
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            document.execCommand("copy");
        }

    </script>
    <script>
        $('#dowloadVoucher').click(function () {
            var id = $(this).attr('data-id');
            console.log(id);
            $.ajax({
                type: "get",
                url: '{{ route('dowload_total',['id'=>$vouchers->id_voucher]) }}',
                data: {
                    id: id,
                },
                success: function (result) {
                }

            });

            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
            $.ajax({
                type: "get",
                dataType: 'json',
                url: '{!! route('updateStatiscal_view_job',['val' => 'total__dowload_voucher']) !!}',
                data: {
                    val: 'total__dowload_voucher'
                },
                success: function (result) {
                    console.log("Thêm thành công");
                },
                error: function (result) {
                    console.log("Thêm thất bại  ");
                }
            });
            @endif
                return true;


            // alert(id);
        });

        $('#CheckUser').click(function () {
            var idcheck = $(this).attr('id-user');
            if (idcheck == 0) {
                alert('Vui lòng đăng nhập để bình luận');
                return false;
            } else {
                $('#submitForm').submit();
                return true;
            }
        });
    </script>
    @if(session('error_login'))
        <script>
            alert({{ session('error_login') }})
        </script>
    @endif

    <script>
        $(document).ready(function () {
            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
            $.ajax({
                type: "get",
                dataType: 'json',
                url: '{!! route('updateStatiscal_view_job',['val' => 'total_view_voucher']) !!}',
                data: {
                    val: 'total_view_voucher'
                },
                success: function (result) {
                    console.log("Thêm thành công");
                },
                error: function (result) {
                    console.log("Thêm thất bại  ");
                }
            });
            @endif
        })
    </script>
    <div class="clearfix"></div>
    {{--$check_entity--}}
    <?php
    $mainEntity = \App\Entity\SubPost::showSubPost('mainentity', 4);
    $count_mainEntity = 0;
    $count_mainEntity = \App\Entity\SubPost::countSubPost('mainentity', 4);
    //ham tra ve ket qua cuoi cung cua mang
    //            echo $count_mainEntity;
    ?>

    @if(!empty($mainEntity))
        <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [@foreach($mainEntity as $id_main=>$main)<?php if($id_main < ($count_mainEntity - 1)){?>{
     "@type": "Question",
     "name": "{{ isset($main->title) ? $main->title : '' }}",
     "acceptedAnswer": {
      "@type": "Answer",
      "text": "{!!  isset($main->content) ? $main->content : '' !!} "
     }
  },<?php }else {?> {
      "@type": "Question",
      "name": "{{ isset($main->title) ? $main->title : '' }}",
      "acceptedAnswer": {
      "@type": "Answer",
      "text": "{!!  isset($main->content) ? $main->content : '' !!} "
     }
  }<?php }?>@endforeach]
  }


        </script>
    @endif

    @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && $vouchers->sale_money == 1)
        <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id); ?>
        <script>
            $(document).ready(function () {
                $('.js_add_employee_money').click(function () {
                    $.ajax({
                        url: "{!! route('create_employee_share_voucher') !!}", // gửi ajax đến file result.php
                        type: "get", // chọn phương thức gửi là get
                        dateType: "json", // dữ liệu trả về dạng text
                        data: { // Danh sách các thuộc tính sẽ gửi đi
                            employee_id: '{{ $employee->employee_id }}',
                            voucher_id: '{{ $vouchers->id_voucher }}',
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
                {{--console.log("{{  $post->post_id }}");--}}
                {{--console.log("{{ $employee_id }}");--}}
                {{--console.log("{{ $ip }}");--}}

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{!! route('add_ajax_sale_money_voucher') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là post
                    dateType: "json", // dữ liệu trả về dạng text
                    data: { // Danh sách các thuộc tính sẽ gửi đi
                        voucher_id: '{{ $vouchers->id_voucher }}',
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
                    url: "{!! route('delete_post_sale_money_voucher') !!}", // gửi ajax đến file result.php
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
@endsection
