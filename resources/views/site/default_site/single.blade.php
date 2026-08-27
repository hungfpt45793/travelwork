<?php  $public_link = \App\Entity\Category::getDetailCategory($cate_slug);
?>
@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', !empty($post->meta_title) ? $post->meta_title : $post->title)

@section('canonical',  route('post',['cate_slug'=>'tin-tuc','post_slug'=>$post->slug]) )
@section('meta_description', !empty($post->meta_description) ? $post->meta_description : $post->description)
@section('keywords', !empty($post->meta_keyword) ? $post->meta_keyword : $post->title  )
@section('meta_image', !empty($post->image) ?asset($post->image) : asset($information['og_image']))
@section('meta_url', !empty($post->slug) ? route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]) : ''  )

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/post.css"/>
@endsection

@section('content')
    @include('site.partials.slider_new')
    <section class="PagesNewsContent bkxam pdb20 pdt20">
        <div class="container container_w_1200">

            <div class="link_breakcrum mbdsNone">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>
                    @if(!empty($public_link))
                        <li class="nav-item ">
                            <span><i class="fas fa-chevron-right"></i></span>
                        </li>

                        <li class="nav-item pd8">
                            <a href="{{ route('site_category_post',['slug_cate'=>$public_link['slug']]) }}">{{ isset($public_link->title) ? $public_link->title : '' }}</a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="row mgt20">
                <div class="col-lg-9">
                    <div class="contentInfoNews bkwhite pd20 bdLightGray">
                        <h1 class="title fontBold mgb10 blueN f18">{{ isset($post->title) ? $post->title : '' }}</h1>
                        @if(!empty($public_link))
                            @if($public_link['slug'] == 'bai-viet-ve-san-ke-toan')
                            @else
                                <p class="pd5">
                                    <?php
                                    $date = date_create($post->updated_at);
                                    ?>
                                    Ngày đăng tin : {{ date_format($date,"d/m/Y") }}
                                </p>
                            @endif
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
                                         data-href="{{ route('post',['cate_slug'=>$cate,'post_slug'=>$post->slug ]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif" data-layout=""
                                         data-size=""><a target="_blank"
                                                         href="https://www.facebook.com/sharer/sharer.php?u={{ route('post',['cate_slug'=>$cate,'post_slug'=>$post->slug ]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif&amp;src=sdkpreparse"
                                                         class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                                </div>
                                <div class="btn_share_zalo">
                                    <div class="zalo-share-button"
                                         data-href="{{ route('post',['cate_slug'=>$cate,'post_slug'=>$post->slug ]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif"
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
                                           value="{{ route('post',['cate_slug'=>$cate,'post_slug'=>$post->slug ]) }}@if(!empty($employee->employee_id))?user_id_sale={{$employee->employee_id}}@endif"
                                           id="myInput"
                                           class="form-control js_add_employee_money css_no_copy"
                                           placeholder="copy link chia sẻ"
                                           readonly style="">


                                </div>
                            </div>
                        </div>

                        <div class="ContentPost">
                            <?php
                            $content_reomove_script = '';
                            if (!empty($post->content)) {
                                $content_reomove_script = App\Ultility\Ultility::preg_replace_script($post->content);
                            }
                            ?>
                            {!! !empty($content_reomove_script) ? $content_reomove_script : '' !!}
                            <div style="display: inline-block;">
                                {{-- danh sách từ khóa --}}
                                <div class="" style="font-size: 17px !important;">
                                    <i class="fa fa-tags blueN"></i>
                                    <a class="tag-title fw6" href="{{ route('list_type_post') }}" target="_blank"
                                       style="color:black;">
                                        Danh sách từ khóa:
                                    </a>
                                    @if (!empty($post->tags))
                                        <ul class="tags">
                                            @php
                                                $tags = explode(',',$post->tags)
                                            @endphp
                                            @foreach ($tags as $tag)
                                                @php
                                                    $tag_slug = str_slug($tag, '-');
                                                @endphp
                                                <li style="padding: 5px;">
                                                    <a href="{{ route('detail_type_post',['tag_slug'=>$tag_slug]) }}">
                                                        {{ $tag }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            @include('site.default_site.list_pod_cart')
                        </div>
                    </div>
                </div>
                {{--//Sider bar--}}
                @include('site.sidebar_site.sidebar_course_new')
            </div>
        </div>
    </section>

    <section class="recruitmentNews pd15 pdt20 pdb0 bgrGray">
        <div class="container container_w_1200 bg-white pdt20 pdb20 ">
            <div class="row ">
                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="title">
                        <h4 class="title_recrui">Tin tức liên quan</h4>
                    </div>
                    <div>
                        <ul>
                            @foreach (\App\Entity\Post::show_relative_Product($post->slug) as $id => $post_re)
                                <li>
                                    <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_re->slug]) }}"
                                       class="thumbs f16">
                                        {{ isset($post_re['title']) ? $post_re['title'] : '' }}
                                    </a>
                                    @if(!empty($post_re['description']))
                                        <p>{{ isset($post_re['description']) ? $post_re['description'] : '' }}</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </section>
    @include('site.partials_site.fixel_mobile_bottom')
    <div class="noti_mobile_show">
        <div class="modal fade" id="message_noti_mobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="contentNoti">
                        <div class="close_modal" data-dismiss="modal">Đóng <i class="far fa-times-circle mgl5"></i>
                        </div>
                        <img class=""
                             src="{{ !empty($information['anh-tai-app-ve-chai']) ? asset($information['anh-tai-app-ve-chai']) : asset('assets/images/1024x577.png') }}">
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

@endsection
@section('show_js')
    <script>
        $('.js_show_search_job').click(function () {
            $('.js_filter_job_face').toggle();
        });
        $('.js_show_sidebar').click(function () {
            $('#js_toogle_sidebar').toggle();
            $('.js_closed_open').toggle();
        });
    </script>
    <script>
        $(document).ready(function () {
            var user = getCookie("modal_noti");
            console.log(user);
            if (user != 'modal_noti_hide') {
                if ($(window).width() <= 500) {
                    setTimeout(function () {
                        $('#message_noti_mobile').modal('show');
                        $('.close_modal').click(function () {
                            setCookie("modal_noti", 'modal_noti_hide', 30);
                            $('#message_noti_mobile').modal('hide');
                        });
                    }, 4000);

                }
            }
        })
        ;

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
    @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && $post->sale_money == 1)
        <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id); ?>
        <script>
            $(document).ready(function () {
                $('.js_add_employee_money').click(function () {
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
                    type: "get", // chọn phương thức gửi là post
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
