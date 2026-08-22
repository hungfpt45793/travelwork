@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', !empty($vouchers->meta_title) ? $vouchers->meta_title : $vouchers->name_voucher)
<?php
$meta_description = '';
if (!empty($vouchers->des_voucher)) {
    $meta_description = $vouchers->des_voucher;
} else {
    $meta_description = (isset($vouchers->name_voucher) ? $vouchers->name_voucher : '') . ' trong ' . (isset($cate_child_voucher->name_cate_child) ? $cate_child_voucher->name_cate_child : '');
}
$meta_description = ucwords($meta_description);
?>
@section('meta_description') {{ $meta_description }} @endsection
@section('keywords', !empty($vouchers->meta_keyword) ? $vouchers->meta_keyword : $vouchers->name_voucher)
@section('meta_image', !empty($vouchers->image_voucher) ?asset($vouchers->image_voucher) : ''  )

@section('content')
    <div class="link bgrWhite md-mgt20 LinkVoucher">
        <div class="container">
            <ul class="nav">
                <ul class="nav">
                    <li class="nav-item pd8">
                        <a href="/" class="md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>
                    <li class="nav-item pd8">
                        <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                    </li>
                </ul>
            </ul>
        </div>
    </div>
    <section class="infoCT pdt20 bgrGray detailVoucher">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12">

                    <div class="info bgrWhite pd20 radius10">
                        <div class="searchVoucher bgrWhite">
                            <form method="GET" action="{{ route('searchVoucher') }}">
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <input type="text" class="form-control" id="inputEmail4"
                                               placeholder="Nhập tên tài liệu" name="name_voucher" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <button type="submit" class="btn btn-primary w100 bgrBlueN">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                            <div class="mgb15">
                                <div id="fb-root"></div>
                                <script async defer crossorigin="anonymous"
                                        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0"></script>
                                <div class="fb-share-button"
                                     data-href="{{ route('getVoucher',['slug_voucher'=>$vouchers->slug_voucher]) }}?user_id_sale={{$employee->employee_id}}"
                                     data-layout="button" data-size="large"><a target="_blank"
                                                                               href="https://www.facebook.com/sharer/sharer.php?u={{ route('getVoucher',['slug_voucher'=>$vouchers->slug_voucher]) }}?user_id_sale={{$employee->employee_id}}&amp;src=sdkpreparse"
                                                                               class="fb-xfbml-parse-ignore js_add_employee_money share_facebook"><i class="fas fa-dollar-sign"></i> Chia sẻ lên
                                        facebook</a>
                                </div>

                                <div class="input-group mb-3 copy_link_post">
                                    <input type="text"
                                           value="{{ route('getVoucher',['slug_voucher'=>$vouchers->slug_voucher]) }}?user_id_sale={{$employee->employee_id}}"
                                           id="myInput" class="form-control js_add_employee_money css_no_copy" placeholder="copy link chia sẻ" readonly
                                           style="width: 100%;">

                                    <div class="input-group-append">
                                        <button onclick="myFunction()" class="btn btn-outline-secondary copylink js_add_employee_money">Copy
                                            link bài viết
                                        </button>

                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="content">
                            <p>
                                {{ isset($vouchers->des_voucher) ? $vouchers->des_voucher : '' }}
                            </p>
                            <div class="contentVoucher">

                                {!! isset($vouchers->content_voucher) ? $vouchers->content_voucher : '' !!}
                            </div>

                            <hr>

                            @if(empty($vouchers->link_dowload_file))
                                <a href="https://docs.google.com/gview?url={{ asset('upload/'.$vouchers->link_dowload_voucher) }}&embedded=true"
                                   target="_blank" class="mgb15 clwhite bgrGreen"
                                   style="padding: 5px 10px;display: inline-block;float: right">Xem chi tiết biểu
                                    mẫu</a>


                                <iframe src="https://docs.google.com/gview?url={{ asset('upload/'.$vouchers->link_dowload_voucher) }}&embedded=true" frameborder="0"></iframe>
                                <hr>


                                <div style="display: inline-block;margin-right: 20px;">
                                    <a target="_blank"
                                       href="https://www.facebook.com/sharer/sharer.php?u={{ route('getVoucher',['slug_voucher'=>$vouchers->slug_voucher]) }}&ampsrc=sdkpreparse"class="fb-xfbml-parse-ignore js_add_employee_money share_facebook  js_click_href" ><i class="fas fa-share"></i> Chia sẻ tài liệu</a>
                                    <i class="mgf5">(Vui lòng chia sẻ tài liệu để hiện nút tải xuống)</i>
                                    </br>


                                    <a href="{{ asset('upload/'.$vouchers->link_dowload_voucher) }}"
                                       data-id="{{ $vouchers->id_voucher }}"
                                       download="{{ $vouchers->slug_voucher }}.{{ isset($vouchers->name_voucher) ? $vouchers->type_voucher : '' }}"
                                       class="pd10 radius5 white noDecoration hvWhite bgrDownload mgt10 dsInline js_add_upload_href"
                                       style="background-color: orange;margin-top: 6px;padding: 6px 10px;vertical-align: text-bottom;color: #fff"
                                       id="dowloadVoucher"><i
                                                class="fas fa-cloud-download-alt"></i> Tải xuống </a>
                                </div>
                            @else
                                <div style="display: inline-block;margin-right: 20px;">
                                    <a target="_blank"
                                       href="https://www.facebook.com/sharer/sharer.php?u={{ route('getVoucher',['slug_voucher'=>$vouchers->slug_voucher]) }}&ampsrc=sdkpreparse" class="fb-xfbml-parse-ignore js_add_employee_money share_facebook  js_click_href" ><i class="fas fa-share"></i> Chia sẻ tài liệu</a><i class="mgf5">(Vui lòng chia sẻ tài liệu để hiện nút tải xuống)</i>

                                    </br>
                                    <a href="{{ $vouchers->link_dowload_file }}" target="_blank"
                                       data-id="{{ $vouchers->id_voucher }}"
                                       class="pd10 radius5 white noDecoration hvWhite bgrDownload mgt10 dsInline js_add_dowload_href"
                                       style="background-color: orange;margin-top: 6px;padding: 6px 10px;vertical-align: text-bottom;color: #fff"
                                       id="dowloadVoucher"><i
                                                class="fas fa-cloud-download-alt"></i> Tải xuống </a>
                                </div>
                            @endif

                            @if(!empty($tag_child_voucher))
                                <div class="tagVoucher">
                                    <div class="post-tags">
                                        <span class="tag-title fw6"><i class="fa fa-tag" aria-hidden="true"></i> Nhóm tài liệu khác : </span>
                                        @foreach($tag_child_voucher as $tag)
                                            <a href="{{ route('getChildVoucher',['slugChildVoucher'=>$tag->slug_cate_child]) }}"
                                               rel="tag">{{ isset($tag->name_cate_child) ? $tag->name_cate_child : '' }}</a>
                                        @endforeach


                                    </div>
                                </div>
                            @endif

                            <?php
                            $category_tag = \App\Entity\Category_tag::get_tag($vouchers->name_voucher,2);
                            ?>
                            @if(!empty($category_tag))

                                <div class="category_tag">
                                    <a class="tag-title fw6" href="{{ route('list_type_voucher') }}" target="_blank"><i class="fa fa-tag" aria-hidden="true"></i>Danh sách từ khóa : </a>
                                    <ul>
                                        @foreach($category_tag as $cate_tag)
                                            <li>
                                                <i><a class="clback" href="{{ route('detail_type_voucher',['tag_slug'=>$cate_tag->tag_slug]) }}" target="_blank"
                                                      rel="tag"><i class="fas fa-hashtag"></i>{{ isset($cate_tag->tag_title) ? $cate_tag->tag_title : '' }}</a>
                                                </i>
                                            </li>
                                            <li>,</li>
                                        @endforeach
                                    </ul>


                                </div>
                            @endif

                            <div class="jsSocial mgt10">
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


                            <div class="CommentVoucher" id="CommentVoucher">
                                <label><h3>Bình luận ({{ $total_comment }})</h3></label>
                                <form method="GET" action="{{ route('addComment') }}" id="submitForm">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                           <textarea class="form-control w100 pd10" rows="4" required
                                                     placeholder="Mời bạn nhập bình luận ... "
                                                     name="content_comment"></textarea>
                                            <input type="hidden" name="id_voucher" value="{{ $vouchers->id_voucher }}">
                                        </div>
                                        <div class="form-group col-md-12 pull-right text-right">
                                            <button type="submit" class="btn btn-primary  btnComment"
                                                    id-user={{ isset(\Illuminate\Support\Facades\Auth::user()->id) ? \Illuminate\Support\Facades\Auth::user()->id : '0' }}  id="CheckUser">
                                                Gửi bình luận
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div class="listComment">
                                    @foreach($voucher_comment as $comment)
                                        <div class="itemComment" id="{{ $comment['id_voucher_cm'] }}">
                                            <div class="titleComent">
                                                <div class="avatarComment">
                                                    <img src="{{ isset($comment['image']) ? asset($comment['image']) : asset('assets/image/user.jpg')  }}"
                                                         title="avatar user" alt="avatar user">
                                                </div>
                                                <div class="TimeComment">
                                                    <span><strong>{{ isset($comment['name']) ? $comment['name'] : '' }}</strong></span>
                                                    <?php
                                                    $date = date_create($comment['day_comment']);
                                                    ?>

                                                    <span><i class="far fa-calendar-times"></i> <?php echo date_format($date, "d/m/Y")?></span>

                                                    <div class="contentComment">
                                                        <p class="f15"
                                                           style="margin-bottom: 5px">{{ $comment['content_voucher_cm'] }}</p>
                                                        <?php
                                                        $anserComment = \App\Entity\VoucherComment::getPanentId($comment['id_voucher_cm']);
                                                        ?>
                                                        @if(!empty($anserComment))
                                                            <span><strong>Trả lời :</strong> </span>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>


                                            @if(!empty($anserComment))
                                                <div class="anserComment">
                                                    <div class="avatarComment">
                                                        <img src="{{ isset($anserComment['image']) ? asset($anserComment['image']) : asset('assets/image/admin.jpg') }}"
                                                             title="hình ảnh admin" alt="hình ảnh admin">
                                                    </div>
                                                    <div class="TimeComment">
                                                        <span><strong>{{ isset($anserComment['name']) ? $anserComment['name'] : 'Admin' }}</strong></span>


                                                        <div class="contentComment">
                                                            <p class="f15"
                                                               style="margin-bottom: 5px">{{ $anserComment['content_voucher_cm'] }}</p>

                                                        </div>

                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach


                                </div>

                            </div>
                            {{--<a href="">Download Text</a>--}}
                        </div>
                    </div>


                </div>
                <div class="col-lg-3 col-md-12 sideBarVoucher">
                    <div class="infos bgrWhite radius10 ">
                        <p class="title bgrBlueN white textCenter radiusTopLeft10 radiusTopRight10 f16 fw7 pd10 mgb0">
                            QUY TRÌNH TUYỂN DỤNG SÀN KẾ TOÁN</p>
                        <div class="infox">

                            <div class="educate boxShadowBlue radius10 pd30 pdb5">
                                @foreach(\App\Entity\SubPost::showSubPost('thuc-tap', 2) as $id => $post_intership)
                                    <h4 class="text-center mgb20 textUpper fw7 blueDN f20">{{ !empty($post_intership->title) ? $post_intership->title : 'Đang cập nhật'}}</h4>
                                    <p class="check">
                                        {!! !empty($post_intership->content) ? $post_intership->content : 'Đang cập nhật' !!}
                                    </p>
                                    <p class="text-center bgrBlueN pd10"><a
                                                href="@if(!empty($post_intership['link-mo-ta-quy-trinh-tuyen-chon-ke-toan']))  {{ $post_intership['link-mo-ta-quy-trinh-tuyen-chon-ke-toan'] }} @else {{ route('intership') }} @endif"
                                                class="white hvWhite fw7 f18">{{ !empty($post_intership->description) ? $post_intership->description : 'Đang cập nhật'}}</a>
                                    </p>
                                @endforeach
                            </div>

                            <div class="text-center mgt5 mgb5"><img src="/public/assets/image/down.png" alt=""
                                                                    width="50px"></div>
                            <div class="employerJobs boxShadowBlue radius10 pd30 pdb5">
                                @foreach(\App\Entity\SubPost::showSubPost('viec-lam', 2) as $id => $jobs_ketoan)
                                    <h4 class="text-center mgb20 textUpper fw7 blueDN f20">{{ !empty($jobs_ketoan->title) ? $jobs_ketoan->title : 'Đang cập nhật'}}</h4>
                                    <p class="check">
                                        {!! !empty($jobs_ketoan->content) ? $jobs_ketoan->content : 'Đang cập nhật' !!}
                                    </p>
                                    <p class="text-center bgrBlueN pd10"><a
                                                href="@if(!empty($jobs_ketoan['link-mo-ta-quy-trinh-tuyen-chon-ke-toan']))  {{ $jobs_ketoan['link-mo-ta-quy-trinh-tuyen-chon-ke-toan'] }} @else {{ route('list_job_face')}} @endif"
                                                class="white hvWhite fw7 f18">{{ !empty($jobs_ketoan->description) ? $jobs_ketoan->description : 'Đang cập nhật'}}</a>
                                    </p>
                                @endforeach
                            </div>
                            <div class="text-center mgt5 mgb5"><img src="/public/assets/image/down.png" alt=""
                                                                    width="50px"></div>

                            <div class="employerJobs boxShadowBlue radius10 pd30 pdb5">
                                @foreach(\App\Entity\SubPost::showSubPost('trac-nghiem', 2) as $id => $tracnghiem)
                                    <h4 class="text-center mgb20 textUpper fw7 blueDN f20">{{$tracnghiem->title}}</h4>
                                    <p class="check">
                                        {!!$tracnghiem->content!!}
                                    </p>
                                    <p class="text-center bgrBlueN pd10"><a
                                                href="@if(isset($daotao['link-mo-ta-quy-trinh-tuyen-chon-ke-toan']))  {{ $daotao['link-mo-ta-quy-trinh-tuyen-chon-ke-toan'] }} @else {{ route('getTestAllExam') }} @endif "
                                                class="white hvWhite fw7 f18">{{$tracnghiem->description}}</a></p>
                                @endforeach
                            </div>
                            <div class="text-center mgt5 mgb5"><img src="/public/assets/image/down.png" alt=""
                                                                    width="50px"></div>

                            <div class="educate boxShadowBlue radius10 pd30 pdb5">

                                @foreach(\App\Entity\SubPost::showSubPost('dao-tao', 2) as $id => $daotao)
                                    <h4 class="text-center mgb20 textUpper fw7 blueDN f20">{{$daotao->title}}</h4>
                                    <p class="check">
                                        {!! $daotao->content !!}
                                    </p>
                                    <p class="text-center bgrBlueN pd10"><a
                                                href="@if(isset($daotao['link-mo-ta-quy-trinh-tuyen-chon-ke-toan']))  {{ $daotao['link-mo-ta-quy-trinh-tuyen-chon-ke-toan'] }} @else {{ route('showTeacher') }} @endif"
                                                class="white hvWhite fw7 f18">{{$daotao->description}}</a></p>
                                @endforeach

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <section class="content pdt20 bgrGray">
        <div class="container">
            <div class="vouchers mgb20 bdLightGray">
                <div class="bgrBlueN">
                    <h2 class="white pd10 fw7 f20 mgb0">CÁC MẪU TƯƠNG TỰ</h2>
                </div>
                <div class="slideNews bgrWhite bdBottomGray">
                    @foreach($relate_voucher as $relate_vh)
                        @include('site.voucher.item_voucher',['voucher' => $relate_vh])
                    @endforeach
                </div>
                <script type="text/javascript">
                    $('.slideNews').slick({
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        responsive: [
                            {
                                breakpoint: 1600,
                                settings: {
                                    slidesToShow: 4,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 1200,
                                settings: {
                                    slidesToShow: 3,
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
            </div>

            <div class="vouchers mgb20 bdLightGray">
                <div class="bgrBlueN">
                    <h3 class="white pd10 fw7 mgb0 f20">CÁC MẪU MỚI NHẤT</h3>
                </div>
                <div class="slideNews2 bgrWhite bdBottomGray">
                    @foreach($voucher_news as $voucher_new)
                        @include('site.voucher.item_voucher',['voucher' => $voucher_new])
                    @endforeach
                </div>
                <script type="text/javascript">
                    $('.slideNews2').slick({
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        responsive: [
                            {
                                breakpoint: 1600,
                                settings: {
                                    slidesToShow: 4,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 1200,
                                settings: {
                                    slidesToShow: 3,
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
            </div>
        </div>
    </section>

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
            }
            else {
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

    <!-- Phần nội dung -->
    <!-- Phần nội dung -->
    <div class="noti_mobile_show">
        <div class="modal fade" id="message_noti_mobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">


                    <div class="contentNoti">
                        <div class="close_modal" data-dismiss="modal" >Đóng <i class="far fa-times-circle mgl5"></i></div>
                        <img src="{{ asset('assets/image/thongbao.png') }}">
                        <div class="modal_dowload_title">
                            <h3>Tải ứng dụng Travelwork</h3>
                            <p>Để tìm việc , nhận tin mới nhất</p>
                        </div>
                        <div class="modal_dowload">
                            <a class="d-sm-inline" href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}"><img src="{{ asset('assets/image/android.png') }}"></a>
                            <a class="d-sm-inline" href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}"><img src="{{ asset('assets/image/ios.png') }}"></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <script>



        $(document).ready(function () {
            $('.js_add_upload_href').hide();
            $('.js_add_dowload_href').hide();
            $('.js_click_href').click(function(){
                $('.js_add_upload_href').show();
                $('.js_add_dowload_href').show();
            });

            var user=getCookie("modal_noti");
            console.log(user);
            if (user != 'modal_noti_hide') {
                if ($(window).width() <= 500) {
                    $('#message_noti_mobile').modal('show');
                    $('.close_modal').click(function(){
                        setCookie("modal_noti", 'modal_noti_hide', 30);

                        $('#message_noti_mobile').modal('hide');
                    });
                }
            }
        });

        function setCookie(cname,cvalue,exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i < ca.length; i++) {
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
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            document.execCommand("copy");
            // alert("Copied the text: " + copyText.value);
        }

    </script>

@endsection
