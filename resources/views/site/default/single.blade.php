<?php  $public_link = \App\Entity\Category::getDetailCategory($cate_slug);
?>
@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', !empty($post->meta_title) ? $post->meta_title : $post->title)

@section('canonical',  route('post',['cate_slug'=>'tin-tuc','post_slug'=>$post->slug]) )
@section('meta_description', !empty($post->meta_description) ? $post->meta_description : '')
@section('keywords', !empty($post->meta_keyword) ? $post->meta_keyword : ''  )
@section('meta_image', !empty($post->image) ?asset($post->image) : ''  )
@section('meta_url', !empty($post->slug) ? route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]) : ''  )


@section('content')

    <section class="PagesNewsContent bkxam pdb20 pdt20">
        <div class="container">
            <div class="link bgrWhite mgb20">
                <ul class="nav">
                    <li class="nav-item pd8">

                        <a href="#" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>
                    @if(!empty($public_link))
                        <li class="nav-item pd8">
                            <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                        </li>
                        <li class="nav-item pd8">
                            <a class="f18 md-f14 mgb0 clorange"
                               href="{{ route('site_category_post',['slug_cate'=>$public_link['slug']]) }}">{{ isset($public_link->title) ? $public_link->title : '' }}</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="contentInfoNews bkwhite pd20 bdLightGray">
                        <h1 class="title fontBold mgb10 blueN f18">{{ isset($post->title) ? $post->title : '' }}</h1>
                        @if($public_link['slug'] == 'bai-viet-ve-san-ke-toan')
                        @else
                            <p class="pd5">
                                <?php
                                $date = date_create($post->updated_at);
                                ?>
                                Ngày đăng tin : {{ date_format($date,"d/m/Y") }}
                            </p>
                        @endif

                        {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                        <?php
                        $cate = 'tin-tuc';
                        if (isset($cate_slug)) {
                            $cate = $cate_slug;
                        }
                        ?>

                        @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && $post->sale_money == 1)
                            <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id); ?>
                            <div class="mgb15">
                                <div id="fb-root"></div>
                                <script async defer crossorigin="anonymous"
                                        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0"></script>
                                <div class="fb-share-button"
                                     data-href="{{ route('post',['cate_slug'=>$cate,'post_slug'=>$post->slug ]) }}?user_id_sale={{$employee->employee_id}}"
                                     data-layout="button" data-size="large"><a target="_blank"
                                                                               href="https://www.facebook.com/sharer/sharer.php?u={{ route('post',['cate_slug'=>$cate,'post_slug'=>$post->slug ]) }}?user_id_sale={{$employee->employee_id}}&amp;src=sdkpreparse"
                                                                               class="fb-xfbml-parse-ignore js_add_employee_money share_facebook"><i class="fas fa-dollar-sign"></i> Chia sẻ lên
                                        facebook</a>
                                </div>

                                <div class="input-group mb-3 copy_link_post">
                                    <input type="text"
                                           value="{{ route('post',['cate_slug'=>$cate,'post_slug'=>$post->slug ]) }}?user_id_sale={{$employee->employee_id}}"
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
                            {!! isset($post->content) ? $post->content : '' !!}
                            <div style="display: inline-block;">
                                <script src="https://sp.zalo.me/plugins/sdk.js"></script>
                                <div class="zalo-share-button" data-href="{{ \App\Ultility\Ultility::getUrl() }}"
                                     data-oaid="579745863508352884" data-layout="2" data-color="blue"
                                     data-customize=true style="background: #03a3fb;color: #fff;padding: 1px 10px;"><img class="lazy"
                                     data-src="{{ asset('assets/image/logozalo.jpg') }}"
                                            title="Chia sẻ zalo trên sanketoan.vn" alt="Chia sẻ zalo trên sanketoan.vn"
                                            style="width: 30px;">Chia sẻ Zalo
                                </div>
                            </div>
                        </div>

                        <?php
                        $category_tag = \App\Entity\Category_tag::get_tag($post->title,1);
                        ?>
                        @if(!empty($category_tag))

                            <div class="category_tag mgt20">
                                <a class="tag-title fw6" href="{{ route('list_type_post') }}" target="_blank"><i class="fa fa-tag" aria-hidden="true"></i>Danh sách từ khóa : </a>
                                <ul>
                                    @foreach($category_tag as $cate_tag)
                                        <li>
                                            <i><a class="clback" href="{{ route('detail_type_post',['tag_slug'=>$cate_tag->tag_slug]) }}" target="_blank"
                                                  rel="tag"><i class="fas fa-hashtag"></i>{{ isset($cate_tag->tag_title) ? $cate_tag->tag_title : '' }}</a>
                                            </i>
                                        </li>
                                        <li>,</li>
                                    @endforeach
                                </ul>


                            </div>
                        @endif

                    </div>
                </div>
                {{--//Sider bar--}}
                @include('site.sidebar.sidebar_new')
            </div>
        </div>
    </section>

    <section class="recruitmentNewsHandbook pd15 pdt20 pdb0 bgrGray">
        <div class="container bg-white pdt20 pdb20 ">
            <div class="row ">


                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="title">
                        <h4 class="textUpper text-center fw7 f32 xl-f28 lg-f23 red mgb20"> Tin tức liên quan</h4>
                    </div>
                    <div class="slideNews">
                        @foreach (\App\Entity\Post::relativeProduct($post->slug) as $id => $post_re)
                            <div class="News pd20">
                                <div class="CropImg">
                                    <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_re->slug]) }}"
                                       class="thumbs">
                                        <img class="lazy" data-src="{{$post_re->image}}"
                                             alt="{{ isset($post_re['title']) ? $post_re['title'] : '' }}"
                                             title="{{ isset($post_re['title']) ? $post_re['title'] : '' }}"
                                             width="100%">
                                    </a>
                                </div>
                                <div class="info">
                                    <h5>
                                        <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_re->slug]) }}"
                                           class="f18 hvBlueDN blueDN"
                                           title="{{ isset($post_re['title']) ? $post_re['title'] : '' }}">{{ isset($post_re['title']) ? \App\Ultility\Ultility::textLimit($post_re['title'], 10) : '' }}</a>
                                    </h5>

                                    <p>{{ isset($post_re['description']) ? \App\Ultility\Ultility::textLimit($post_re['description'], 25) : '' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </section>
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
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });
    </script>
    <section class="recruitmentNewsHandbook pd15 pdt20 pdb0 bgrGray">
        <div class="container bg-white pdt20 pdb20 ">
            <div class="row ">


                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="title">
                        <h4 class="textUpper text-center fw7 f32 xl-f28 lg-f23 red mgb20"> Tin tức chia sẻ nhận tiền</h4>
                    </div>
                    <div class="slideNewMoney">
                        @foreach (\App\Entity\Post::relativeMoney() as $id => $post_money)
                            <div class="News pd20">
                                <div class="CropImg">
                                    <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_money->slug]) }}"
                                       class="thumbs">
                                        <img class="lazy" data-src="{{$post_money->image}}"
                                             alt="{{ isset($post_money['title']) ? $post_money['title'] : '' }}"
                                             title="{{ isset($post_money['title']) ? $post_money['title'] : '' }}"
                                             width="100%">
                                    </a>
                                </div>
                                <div class="info">
                                    <h5>
                                        <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_money->slug]) }}"
                                           class="f18 hvBlueDN blueDN"
                                           title="{{ isset($post_money['title']) ? $post_money['title'] : '' }}">{{ isset($post_money['title']) ? \App\Ultility\Ultility::textLimit($post_money['title'], 10) : '' }}</a>
                                    </h5>

                                    <p>{{ isset($post_money['description']) ? \App\Ultility\Ultility::textLimit($post_money['description'], 25) : '' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </section>
    <script type="text/javascript">
        $('.slideNewMoney').slick({
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
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        });
    </script>
    {{--tao cau hoi trong search tim kiem cua google--}}
    @if(!empty($post->post_id))
    <?php
    $mainEntity = \App\Entity\Post_question::get_question($post->post_id);
    $count_mainEntity = 0;
    $count_mainEntity = \App\Entity\Post_question::get_total_question($post->post_id)
    //ham tra ve ket qua cuoi cung cua mang
    //            echo $count_mainEntity;
    ?>
    @endif

    @if(!empty($mainEntity) && $post->post_question == 1)
        <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [@foreach($mainEntity as $id_main=>$main)<?php if($id_main < ($count_mainEntity - 1)){?>{
     "@type": "Question",
     "name": "{{ isset($main->post_ques) ? $main->post_ques : '' }}",
     "acceptedAnswer": {
      "@type": "Answer",
      "text": "{!!  isset($main->post_answer) ? $main->post_answer : '' !!}"
     }
  },<?php }else {?> {
      "@type": "Question",
      "name": "{{ isset($main->post_ques) ? $main->post_ques : '' }}",
      "acceptedAnswer": {
      "@type": "Answer",
      "text": "{!!  isset($main->post_answer) ? $main->post_answer : '' !!}"
     }
  }<?php }?>@endforeach]
  }
        </script>
    @endif

    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            document.execCommand("copy");
            // alert("Copied the text: " + copyText.value);
        }
    </script>
    <script type="text/javascript">
        $('.slideNews').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
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

    @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && $post->sale_money == 1)
        <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id); ?>
    <script>
        $(document).ready(function () {
            $('.js_add_employee_money').click(function(){
                $.ajax({
                    url: "{!! route('create_employee_share') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là get
                    dateType: "json", // dữ liệu trả về dạng text
                    data: { // Danh sách các thuộc tính sẽ gửi đi
                        employee_id: {{ $employee->employee_id }},
                        post_id: {{ $post->post_id }},
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
                    url: "{!! route('add_ajax_sale_money') !!}", // gửi ajax đến file result.php
                    type: "post", // chọn phương thức gửi là post
                    dateType: "json", // dữ liệu trả về dạng text
                    data: { // Danh sách các thuộc tính sẽ gửi đi
                        post_id: '{{ $post->post_id }}',
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
                    url: "{!! route('delete_post_sale_money') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là post
                    dateType: "json", // dữ liệu trả về dạng text
                    data: {
                    },
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

    <div class="noti_mobile_show">
        <div class="modal fade" id="message_noti_mobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">


                    <div class="contentNoti">
                        <div class="close_modal" data-dismiss="modal" >Đóng <i class="far fa-times-circle mgl5"></i></div>
                        <img class="lazy" data-src="{{ asset('assets/image/thongbao.png') }}">
                        <div class="modal_dowload_title">
                            <h3>Tải ứng dụng Travelwork</h3>
                            <p>Để tìm việc , nhận tin mới nhất</p>
                        </div>
                        <div class="modal_dowload">
                            <a class="d-sm-inline" href="{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}"><img class="lazy" data-src="{{ asset('assets/image/android.png') }}"></a>
                            <a class="d-sm-inline" href="{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}"><img class="lazy" data-src="{{ asset('assets/image/ios.png') }}"></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <script>

        $(document).ready(function () {

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
@endsection
