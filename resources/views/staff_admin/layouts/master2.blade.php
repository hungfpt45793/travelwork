<!DOCTYPE html>
<html mlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" class="no-js" xml:lang="vi" lang="vi">

<head>
    <title>@yield('title')</title>
    <base href="{{ asset('') }}">
    <!-- meta -->
    <meta name="ROBOTS" content="index, follow">
    <meta name="google" content="nositelinkssearchbox">
    <meta http-equiv=”content-language” content=”vi” />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8;application/json">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="google-site-verification" content="v5i-wa8W0iZnl34HrLGjcsA-LqujLrS_cRdEuyEOPSk">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Danh sách tin tuyển dụng kế toán từ  các Group kế toán trên facebook  gồm kế toán thuế , kế toán công nợ, kế toán tổng hợp, kế toán học việc...
			">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="i5wMjz3Es53TNlMDj3jBM5vHpYLpoQe3nxrfY5aZ">
    <!-- facebook gooogle -->
    <!-- <meta property="fb:app_id" content="" />
			<meta property="fb:admins" content=""> -->
    <link rel="icon" href="public/library/images/logo/ico.ico" type="image/x-icon">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:locale" content="vi_VN">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Việc làm kế toán cập nhật mới nhất">
    <meta property="og:description" content="Danh sách tin tuyển dụng kế toán từ  các Group kế toán trên facebook  gồm kế toán thuế , kế toán công nợ, kế toán tổng hợp, kế toán học việc...
			">
    <meta property="og:url" content="https://sanketoan.vn:443/viec-lam/viec-lam-facebook">
    <meta property="og:image" content="public/library/images/logo/logo2.jpg">
    <meta property="og:image:secure_url" content="public/library/images/logo/logo2.jpg">
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="300">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link rel="stylesheet" href="public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/assets/css/all.css">
    <link rel="stylesheet" type="text/css" media="screen" href="public/assets/css/main.css">
    <link rel="stylesheet" type="text/css" media="screen" href="public/assets/css/extra.css">
    <link rel="stylesheet" type="text/css" media="screen" href="public/assets/css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="public/assets/css/hover-min.css">
    <link href="public/assets/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/css/pretty-checkbox.min.css">
    <link rel="stylesheet" type="text/css" href="public/assets/css/slick.css">
    <link rel="stylesheet" type="text/css" href="public/assets/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="public/assets/css/customStyle.css">
    <link rel="stylesheet" href="tracnghiem/css/star-rating-svg.css" type="text/css">
    <link rel="stylesheet" href="tracnghiem/css/styles.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="public/adminstration/plugins/iCheck/all.css">
    <link rel="stylesheet" type="text/css" href="public/assets/css/form.css">
    <link rel="stylesheet" href="/public/select2/dist/select2-bootstrap4.css">
    <script src="public/assets/js/umd/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
    <script src="public/assets/js/umd/popper.min.js"></script>
    <script src="public/assets/js/bootstrap.min.js"></script>
    <script src="public/assets/js/jquery.validate.min.js"></script>
    <script src="public/assets/js/main.js"></script>
    <script src="public/assets/js/select2.min.js"></script>
    <script src="public/assets/js/jquery.matchHeight-min.js"></script>
    <script src="adminstration/ckeditor/ckeditor.js"></script>



    <script src="public/assets/js/d-public.js"></script>
    <link rel="stylesheet" type="text/css" href="public/assets/css/d-public.css">
    <link rel="stylesheet" type="text/css" href="public/assets/css/d-res.css">
    <script src="public/assets/ckeditor/ckeditor.js"></script>
</head>

<body class="preloading">
    <header class="bgrBlueN d-header pdl40  d-menu_on_desktop pd0 ">
        <div class="row" style="margin-left:0 ;margin-right: 0;">
            <div class="d-parent col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 block mg">
                <div>
                    <span class="toggle-sidebar whiteIm f17"><i class="d-left-right fas fa-align-left"></i></span>
                </div>
                <div class="logo">
                    <a href="">
                        <img src="public/library/images/logo/logo2.jpg" alt="" width="100%">
                    </a>
                </div>
            </div>
            <div class="d-THScontent col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11 block mg d-menu_on_desktop_menu">
                <div class="menu THSmenu pdl5">
                    <ul class="nav justify-content-center MenudsBlock">
                        <span class="d-sidebarCollapse"><i class="d-left-right fas fa-angle-double-left"></i></span>
                        <a href="{{ route('staff_employee.index') }}" class="THSactive">
                            <li class="nav-item THSactive text-center">
                                <span class="nav-link white hvWhite f17 pdt0 ">Danh Mục
                                </span>
                            </li>
                        </a>
                        <a href="{{ route('staff_article.index') }}">
                            <li class="nav-item text-center">
                                <span class="nav-link white hvWhite f17 pdt0 ">Tin bài viết
                                </span>
                            </li>
                        </a>
                        <a href="{{ route('staff_advisory_contact') }}">
                            <li class="nav-item text-center">
                                <span class="nav-link white hvWhite f17 pdt0 ">ĐK tư vấn
                                </span>
                            </li>
                        </a>
                        <a href="{{ route('staff_archives.index') }}">
                            <li class="nav-item text-center">
                                <span class="nav-link white hvWhite f17 pdt0 ">Kho tài liệu
                                </span>
                            </li>
                        </a>
                    </ul>
                </div>
                <div class="login pdt5">
                    <ul class="nav justify-content-end centerLaptopmini">
                        <div class="dropdown dropdownHorder">
                            <a class="nav-link whiteIm f17 dropdown-toggle " href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user f20 "></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#loginMoney"><i
                                        class="fas fa-id-card mgr5"></i>
                                    Quản lý hồ sơ
                                </a>
                                <a class="dropdown-item" href="chia-se-facebook/danh-sach-phan-mem-doi-thuong"><i
                                        class="fas fa-user-circle mgr5"></i>
                                    Đổi mật khẩu
                                </a>
                                <a class="dropdown-item" href="huong-dan-chia-se-bai-viet/tin-tuc"><i
                                        class="fas fa-sign-out-alt mgr5"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </div>
                        <li class="nav-item cursor">
                            <a class="nav-link whiteIm f17 shownotification" data-toggle="modal" data-target="#loginTiva"><i class="fas fa-bell f20"></i></a>
                        </li>
                        <div class="dropdown-menu dropdown-menu-right dropSupport dropnotification">
                            <div class="dropTitle">
                                <h3>Thông báo</h3>
                            </div>
                            <div>
                                <ul>
                                    <li>sadsadasdas</li>
                                    <li>sadsadasdas</li>
                                    <li>sadsadasdas</li>
                                </ul>
                            </div>
                        </div>
                        <li class="nav-item cursor">
                            <button type="button" class="btn btn-secondary showsupport" style="background: none;border: none;font-size: 17px;margin-top: 2px;" id="showsupport">
                                <i class="fas fa-question-circle f20"></i>
                            </button>
                        </li>
                        <div class="dropdown-menu dropdown-menu-right dropSupport">
                            <div class="dropTitle">
                                <span class="hiddenAjax showAjax"><i class="fas fa-arrow-left"></i></span>
                                <h3> Hỗ trợ</h3>
                                <div class="searchAjaxNew">
                                    <form class="" method="get" action="ho-tro/tin-tuc">
                                        <div class="form-group row mgb0">
                                            <div class="col-sm-12">
                                                <button type="submit"><i class="fas fa-search"></i></button>
                                                <input type="text" class="form-control searchAjax" name="word" placeholder="Tìm kiếm hỗ trợ ..." autocomplete="off">
                                            </div>
                                        </div>
                                    </form>
                                    <div class="ContentSearch">
                                    </div>
                                </div>
                            </div>
                            <div class="DropContent">
                                <a href="#" data-id="303">
                                    <span><i class="fas fa-caret-right"></i> Hướng dẫn đăng ký / đăng nhập tài khoản ứng
                                        viên</span>
                                </a>
                                <a href="#" data-id="304">
                                    <span><i class="fas fa-caret-right"></i> Hướng dẫn đăng ký / đăng nhập tài khoản nhà
                                        tuyển dụng</span>
                                </a>
                                <a href="#" data-id="305">
                                    <span><i class="fas fa-caret-right"></i> Hướng dẫn đăng ký / đăng nhập tài khoản
                                        giáo viên</span>
                                </a>
                                <a href="#" data-id="318">
                                    <span><i class="fas fa-caret-right"></i> Hướng dẫn tải ảnh đại diện vào hồ sơ: giáo
                                        viên, ứng viên, nhà tuyển dụng</span>
                                </a>
                                <a href="#" data-id="348">
                                    <span><i class="fas fa-caret-right"></i> Hướng dẫn sử dụng chức năng : Thông tin
                                        tuyển dụng</span>
                                </a>
                                <a href="#" data-id="349">
                                    <span><i class="fas fa-caret-right"></i> Hướng dẫn sử dụng chức năng : Hồ sơ tuyển
                                        dụng</span>
                                </a>
                                <a href="#" data-id="350">
                                    <span><i class="fas fa-caret-right"></i> Hướng dẫn sử dụng chức năng : Thông tin
                                        tuyển thực tập</span>
                                </a>
                                <a href="#" data-id="351">
                                    <span><i class="fas fa-caret-right"></i> Hướng dẫn sử dụng chức năng : Hồ sơ thực
                                        tập</span>
                                </a>
                            </div>
                            <div class="DropContentItem hiddenAjax">
                            </div>
                        </div>
                        <li class="nav-item cursor button-menu open-res">
                            <a class="nav-link whiteIm f17"><i class="fas fa-bars"></i></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- <div class="col-xl-2 col-lg-2 col-md12 block mg"> -->
            <!-- </div> -->
        </div>
    </header>
    <section class="content bgrGray pdt5" style="padding-bottom: 500px;">
        @yield('content')
    </section>
    <section class="recruitmentNewsHandbook bgrGray " style="width: 100%;height: 15px ">
    </section>
    <!-- Load Facebook SDK for JavaScript -->
    <div class="overlay ">
    </div>
    <div class="container ">
        <div class="row ">
            <div class="col-lg-12 ">
                <a id="back-to-top " href="# " class="back-to-top f20 " role="button " title="Lên đầu trang " data-toggle="tooltip " data-placement="left "><i class="fas fa-chevron-circle-up "
                        style="font-size: 35px;color: green "></i></a>
            </div>
        </div>
    </div>

    {{-- <script type="text/javascript ">
        $(document).ready(function() {
            $('.showsupport').click(function() {
                $('.dropSupport').toggleClass('show');
            });
            $('.removeSupport').click(function() {
                $('.dropSupport').removeClass('show');
            });
            $('.shownotification').click(function() {
                $('.dropnotification').toggleClass('show');
            });
            $(this).scrollTop(0);
            var s1 = $("header ");
            var s2 = $(".submenu1 ");
            var pos = s1.position();
            var posheight = s1.height();
            var heightbody = $('body').height();
            var heightwindow = $(window).height();
            $(window).scroll(function() {
                var windowpos = $(window).scrollTop();
                if (windowpos > pos.top && ((heightbody - posheight) > heightwindow)) {
                    s1.addClass("stickyhome ");
                    $('.top ').css('display', 'none')
                } else {
                    s1.removeClass("stickyhome ");
                    $('.top ').css('display', 'block')
                }
                if (windowpos > (pos.top)) {
                    s2.addClass("ds-none ");
                    $('.submenuPC').click(function() {
                        s2.removeClass("ds-none ");
                    });

                    $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '0');
                } else {
                    s2.removeClass("ds-none ");
                    $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '50px');
                }
            });
        });
    </script> --}}
</body>

</html>