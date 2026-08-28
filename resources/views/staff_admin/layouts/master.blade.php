<!DOCTYPE html>
<html mlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" class="no-js" xml:lang="vi" lang="vi">

<head>
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('assets/image/new/Logo.png') }}" type="image/png"/>
    <base href="{{ asset('') }}">
    <!-- meta -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv=”content-language” content=”vi” />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8;application/json">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="i5wMjz3Es53TNlMDj3jBM5vHpYLpoQe3nxrfY5aZ">
    <link rel="stylesheet" href="public/assets/css/bootstrap.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="public/assets/css/all.css">
    <link rel="stylesheet" href="public/adminstration/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="public/assets/css/d-public.css">
    <link rel="stylesheet" type="text/css" href="public/assets/css/floatscroll.css">
    <link rel="stylesheet" type="text/css" href="public/assets/css/d-res.css">
    <link rel="stylesheet" href="public/assets/css/cssNghia.css">
    <script src="public/assets/js/umd/jquery-3.3.1.min.js"></script>
    <script src="public/assets/js/umd/popper.min.js"></script>
</head>

<body class="preloading">
    <header class="bgrBlueN d-header pdl40  d-menu_on_desktop pd0 mb-1" style="background-color: #009385">
        <div class="row" style="margin-left:0 ;margin-right: 0;">
            <div class="d-parent col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 block mg">
                <div class="row">
                    <div class="d-flex">
                        <div class="logo">
                            <a href="">
                                <img src="public/library/images/logo/logo2.jpg" alt="" width="100%">
                            </a>
                        </div>
                        <div class="p-3">
                            <span class="toggle-sidebar whiteIm f17"><i
                                    class="d-left-right fas fa-align-left fa-lg text-white"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-THScontent col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9 block mg d-menu_on_desktop_menu">
                <div class="menu THSmenu pdl5">
                    <ul class="nav justify-content-center MenudsBlock">

                        <span class="d-sidebarCollapse custom_a flex-wrap"><i class="bars_scroll fas fa-bars"
                                style="margin-top: 12px"></i>
                            <a href="{{ route('dashboard') }}"
                                class=" {{ (isset($menuTop) && $menuTop == 'employee') ? 'topActive' : '' }}">
                                <li class="nav-item text-center">
                                    <span class="nav-link text-white hvWhite f17 pdt0">UV
                                    </span>
                                </li>
                            </a>
                            <a href="{{ route('dashboard_employer') }}"
                                class=" {{ (isset($menuTop) && $menuTop == 'employer') ? 'topActive' : '' }}">
                                <li class="nav-item text-center">
                                    <span class="nav-link text-white hvWhite f17 pdt0">NTD
                                    </span>
                                </li>
                            </a>
                            <a href="{{ route('dashboard_teacher') }}"
                                class=" {{ (isset($menuTop) && $menuTop == 'teacher') ? 'topActive' : '' }}">
                                <li class="nav-item text-center">
                                    <span class="nav-link text-white hvWhite f17 pdt0 ">GV
                                    </span>
                                </li>
                            </a>
                            <a href="{{ route('staff_article.index') }}"
                                class=" {{ (isset($menuTop) && $menuTop == 'article') ? 'topActive' : '' }}">
                                <li class="nav-item text-center">
                                    <span class="nav-link text-white hvWhite f17 pdt0 ">Bài viết
                                    </span>
                                </li>
                            </a>
                            <a href="{{ route('staff_voucher.index') }}"
                                class=" {{ (isset($menuTop) && $menuTop == 'tailieu') ? 'topActive' : '' }}">
                                <li class="nav-item text-center">

                                    @if(isset($total_no_comment) && $total_no_comment > 0)
                                    <span class="nav-link text-white text-danger hvWhite f17 pdt0 ">Tài liệu</span>
                                    @else
                                    <span class="nav-link text-white hvWhite f17 pdt0 ">Tài liệu</span>
                                    @endif
                                </li>
                            </a>
                            <a href="{{ route('staff_service_order.index') }}"
                                class=" {{ (isset($menuTop) && $menuTop == 'donhang') ? 'topActive' : '' }}">
                                <li class="nav-item text-center">
                                    @if(isset($un_tong_order) && $un_tong_order > 0)
                                    <span class="nav-link text-white text-danger hvWhite f17 pdt0 ">Đơn hàng</span>
                                    @else
                                    <span class="nav-link text-white hvWhite f17 pdt0 ">Đơn hàng</span>
                                    @endif
                                </li>
                            </a>
                            <a href="{{ route('staff_job-ntd.index') }}"
                                class=" {{ (isset($menuTop) && $menuTop == 'vieclam') ? 'topActive' : '' }}">
                                <li class="nav-item text-center">
                                    <span
                                        class="nav-link text-white hvWhite f17 pdt0 {{ ($job_not_active > 0) ? 'text-danger' : '' }} ">Việc
                                        làm
                                    </span>
                                </li>
                            </a>
                            <a href="{{ route('form_email') }}"
                                class=" {{ (isset($menuTop) && $menuTop == 'mauemail') ? 'topActive' : '' }}">
                                <li class="nav-item text-center">
                                    <span class="nav-link text-white hvWhite f17 pdt0">Marketing
                                    </span>
                                </li>
                            </a>
                            <a href="{{ route('coursesStaff.index') }}"
                                class=" {{ (isset($menuTop) && $menuTop == 'khoahoc') ? 'topActive' : '' }}">
                                <li class="nav-item text-center">
                                    <span class="nav-link text-white hvWhite f17 pdt0">Khóa học
                                    </span>
                                </li>
                            </a>
                            <a href="{{ route('dashboard_report') }}"
                                class=" {{ (isset($menuTop) && $menuTop == 'baocao') ? 'topActive' : '' }}">
                                <li class="nav-item text-center">
                                    <span class="nav-link text-white hvWhite f17 pdt0">Báo cáo
                                    </span>
                                </li>
                            </a>
                    </ul>
                </div>
                <div class="login pdt5 d-flex align-items-center">
                    <ul class="nav justify-content-end centerLaptopmini">
                        <div class="dropdown dropdownHorder">
                            <div class="btn-group dropleft">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user fa-lg"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#loginMoney"><i
                                            class="fas fa-id-card mgr5"></i>
                                        Quản lý hồ sơ
                                    </a>
                                    <a class="dropdown-item" href="chia-se-facebook/danh-sach-phan-mem-doi-thuong"><i
                                            class="fas fa-user-circle mgr5"></i>
                                        Đổi mật khẩu
                                    </a>
                                    <a class="dropdown-item" href="{{route('logoutHome')}}"><i
                                            class="fas fa-sign-out-alt mgr5"></i>
                                        Đăng xuất
                                    </a>
                                </div>
                            </div>
                            <!-- <a class="nav-link text-whiteIm f17 dropdown-toggle text-white" href="#" id="dropdownMenuButton"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user fa-lg"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="right:0!important">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#loginMoney"><i
                                        class="fas fa-id-card mgr5"></i>
                                Quản lý hồ sơ
                            </a>
                            <a class="dropdown-item" href="chia-se-facebook/danh-sach-phan-mem-doi-thuong"><i
                                        class="fas fa-user-circle mgr5"></i>
                                Đổi mật khẩu
                            </a>
                            <a class="dropdown-item" href="{{route('logoutHome')}}"><i
                                        class="fas fa-sign-out-alt mgr5"></i>
                                Đăng xuất
                            </a>
                        </div> -->
                        </div>
                        <li class="nav-item cursor button-menu open-res">
                            <a class="nav-link text-whiteIm f17"><i class="fas fa-bars"></i></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- <div class="col-xl-2 col-lg-2 col-md12 block mg"> -->
            <!-- </div> -->
        </div>
    </header>
    <section class="content pdt5" style="font-size:14px;">
        @yield('content')
    </section>
    <section class="recruitmentNewsHandbook" style="width: 100%; height: 15px">
    </section>
    <!-- Load Facebook SDK for JavaScript -->
    <div class="overlay ">
    </div>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/floatscroll.js') }}"></script>
    <script src="{{ asset('adminstration/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('adminstration/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('adminstration/jquery.priceformat.js') }}"></script>
    <script src="public/assets/js/d-public.js"></script>
    <script src="public/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript ">
    //cấu hinh ckfinder chọn image
    function ChangeToSlug()
    {
        var slug;
        //Lấy text từ thẻ input title
        slug = document.getElementById("slug").value;
        slug = slug.toLowerCase();
        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox có id “slug”
        document.getElementById('convert_slug').value = slug;
    }
    $(document).ready(function() {
        $(".pagination-bootstrap .pagination li").addClass("page-item");
        $(".pagination-bootstrap .pagination li a").addClass("page-link");
        $(".pagination-bootstrap .pagination li span").addClass("page-link");
        $('.select2').select2({
            width: '100%',
            dropdownParent: $("#timkiem"),
        });
        $('.select22').select2({
            width: '100%'
        });
        $("#select2_employer").select2({
            width: '100%',
            placeholder: 'Chọn nhà tuyển dụng',
            allowClear: true,
            ajax: {
                url: '{{ route("get_employer_select2") }}',
                dataType: 'json',
                data: function(params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    }
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    let array_result = Object.entries(data.result);
                    let array_result_reverse = array_result.reverse();
                    return {
                        results: array_result_reverse.map(function(item) {
                            return {
                                text: item[1].text,
                                id: item[1].id
                            };
                        }),
                        pagination: {
                            more: data.pagination.more
                        }
                    }
                }
            },
            templateResult: function formatRepo(repo) {
                if (repo.loading) {
                    return repo.text;
                }
                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__title' style='float:left;line-height:35px'></div>" +
                    "</div>"
                );
                $container.find(".select2-result-repository__title").text(repo.text);
                return $container;
            },
            templateSelection: function formatRespoSelection(repo) {
                return repo.full_name || repo.text;
            }
        });
        $("#select2_job").select2({
            width: '100%',
            placeholder: 'Chọn tin tuyển dụng',
            allowClear: true,
            ajax: {
                url: '{{ route("get_job_select2") }}',
                dataType: 'json',
                data: function(params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    }
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    let array_result = Object.entries(data.result);
                    let array_result_reverse = array_result.reverse();
                    return {
                        results: array_result_reverse.map(function(item) {
                            return {
                                text: item[1].text,
                                id: item[1].id
                            };
                        }),
                        pagination: {
                            more: data.pagination.more
                        }
                    }
                }
            },
            templateResult: function formatRepo(repo) {
                if (repo.loading) {
                    return repo.text;
                }
                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__title' style='float:left;line-height:35px'></div>" +
                    "</div>"
                );
                $container.find(".select2-result-repository__title").text(repo.text);
                return $container;
            },
            templateSelection: function formatRespoSelection(repo) {
                return repo.full_name || repo.text;
            }
        });
        $('.editor').each(function(e) {
            CKEDITOR.replace(this.id, {
                filebrowserImageBrowseUrl: '/kcfinder-master/browse.php?type=images&dir=images/public',
            });
        });

        function uploadImage(e) {
            window.KCFinder = {
                callBack: function(url) {
                    window.KCFinder = null;
                    var img = new Image();
                    img.src = url;
                    $(e).next().attr("src", url);
                    $(e).next().next().val(url);
                }
            };
            window.open('/kcfinder-master/browse.php?type=images&dir=images/public',
                'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
                'directories=0, resizable=1, scrollbars=0, width=800, height=600'
            );
        }

        function openKCFinder(e) {
            window.KCFinder = {
                callBackMultiple: function(files) {
                    window.KCFinder = null;
                    var urlFiles = "";
                    $(e).next().empty();
                    for (var i = 0; i < files.length; i++) {
                        $(e).next().append('<img src="' + files[i] +
                            '" width="80" height="" style="margin-left: 5px; margin-bottom: 5px;"/>'
                        );
                        urlFiles += files[i];
                        if (i < (files.length - 1)) {
                            urlFiles += ',';
                        }
                    }
                    $(e).next().next().val(urlFiles);
                }
            };
            window.open('/kcfinder-master/browse.php?type=images&dir=images/public',
                'kcfinder_multiple', 'status=0, toolbar=0, location=0, menubar=0, ' +
                'directories=0, resizable=1, scrollbars=0, width=800, height=600'
            );
        }
    });
    </script>
    @yield('scripts')
</body>
<script>
    $('.formatPrice').priceFormat({
        prefix: '',
        centsLimit: 0,
        thousandsSeparator: '.'
    });
</script>
<script>
$(".hover_show").hover(function() {
    $('body').addClass("show_ul");
}, function() {
    $('body').removeClass("show_ul")
})
$('.editor').each(function(e) {
    CKEDITOR.replace(this.id, {
        filebrowserImageBrowseUrl: '/kcfinder-master/browse.php?type=images&dir=images/public',
    });
});

function uploadImage(e) {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            var img = new Image();
            img.src = url;
            $(e).next().attr("src", url);
            $(e).next().next().val(url);
        }
    };
    window.open('/kcfinder-master/browse.php?type=images&dir=images/public',
        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
        'directories=0, resizable=1, scrollbars=0, width=800, height=600'
    );
}
</script>
<script>
bindings();

function bindings() {
    var locker = $('#locker');
    $(document).on('click', 'button.lockButton', function() {

        var that = $(this),
            lidClass = '',
            parent = that.parents('td[class^="lid"]');
        if (parent.length) {
            lidClass = getColumnLidClass(parent);
            lockings = $('td.' + lidClass);
            lockings.addClass('locked');
            that.text('U');
            var fixedColumn = $(getLockedWrapper(lockings, lidClass));
            var index = parent.index();
            fixedColumn.data('index', index);

            if (index === 0) {
                locker.prepend(fixedColumn);
            } else {
                var lockedWraps = $('div.lockedWrap', locker),
                    lwrap = null,
                    indx, appended = false;
                if (!lockedWraps.length) locker.append(fixedColumn);
                lockedWraps.each(function() {
                    lwrap = $(this);
                    indx = lwrap.data('index') * 1;
                    if (!appended && (index < indx)) {
                        lwrap.before(fixedColumn);
                        appended = true;
                        return;
                    }
                });
                if (!appended) locker.append(fixedColumn);
            }
            that.text('L');
        } else {
            parent = that.parents('div.lockedWrap');
            lidClass = getColumnLidClass(parent);
            lockings = $('td.' + lidClass);
            lockings.removeClass('locked');
            parent.remove();
        }
    });
}


// set do dai ngang nhau cho hai phan lock va khong lock
var arrayheight = [];
var arrayheight1 = [];
$('.custom-table tr').each(function() {
    arrayheight.push($(this).height() + 2);
    arrayheight1.push($(this).height());
})
$('.lockedWrap-first .cellWrap').each(function(index, element) {
    $(this).height(arrayheight1[index] + 1);
    $(this).css("line-height", (arrayheight1[index] + "px"));
})
$('.custom-table tr').each(function(index, element) {
    $(this).height(arrayheight1[index]);
})
//

console.log(arrayheight);

function getLockedWrapper(lockings, lidClass) {
    var fixedColumn = [],
        cont;
    lockings.each(function(index, element) {
        cont = $(this).html();
        if(index == 0){
            fixedColumn.push('<div class="cellWrap" style="position:sticky;top:0;background:#53b55a;height:' + arrayheight[index] + 'px;line-height:' +
            arrayheight[index] + 'px">' + cont + '</div>');
        }
        else{
            fixedColumn.push('<div class="cellWrap" style="height:' + arrayheight[index] + 'px;line-height:' +
            arrayheight[index] + 'px">' + cont + '</div>');
        }
    });
    fixedColumn = '<div class="' + lidClass + ' lockedWrap">' + fixedColumn.join('') + '</div>';
    return fixedColumn;
}

function getColumnLidClass(td) {
    for (var i = 0; i < 100; i++) {
        if (td.hasClass('lid_' + i))
            break;
    }
    return 'lid_' + i;
}
// $('.custom-table tr').css('height', '34px');
// $('#locker .cellWrap').css('height', '34px');
// $('#locker .cellWrap').css('line-height', '34px');
$('.table-scroll').on('scroll', function() {
    $('#locker').scrollTop($(this).scrollTop());
});

$('.d-hvbgrBlueN a.x-anchor').click(function(e) {
    $('a').removeClass('activeTHS');
    $(this).addClass('activeTHS');
});
$('#locker').addClass('tableFixHead');


//can chinh scrollbar
$(".table-wrapper.tableFixHead").floatingScroll();
$(".table-wrapper.tableFixHead").floatingScroll("update");
</script>


{{-- scrip để thêm từ khóa --}}
<script>
// Initialize tooltip component
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})

// Initialize popover component
$(function() {
    $('[data-toggle="popover"]').popover()
})

// ajax thêm từ khóa
$(document).ready(function() {
    $('button.LuuTuKhoa').on('click', function() {
        console.log('asds')
        $.ajax({
            type: 'GET',
            url: "{{ route('them_tu_khoa_ajax') }}",
            data: {
                tag_type: $('input[name="tag_type"]').val(),
                tag_title: $('input[name="tag_title"]').val(),
                tag_description: $('textarea[name="tag_description"]').val()
            },
            success: function(res) {
                let html = '';
                let tags = res.input_tags_reload;
                tags.forEach(element => {
                    html += `<option value="${element.tag_title}">
                                        ${element.tag_title}
                                    </option>`
                });
                $('#select-tag').html(html);
                alert('Thêm từ khóa thành công');
            }
        })
    })
})
</script>
{{-- END scrip để thêm từ khóa --}}
@stack('custom-scripts')

</html>
