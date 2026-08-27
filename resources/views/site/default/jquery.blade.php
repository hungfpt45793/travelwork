<script type="text/javascript">
    $(window).on('load', function(event) {
        $('body').removeClass('preloading');
        // $('.load').delay(1000).fadeOut('fast');
        $('.loader').delay(300).fadeOut('fast');
    });
    $('.select2').select2({
        width: '100%',
    });
    $('.select2_auto').select2();
    //câu hình chiều cao bằng nhau
    $('.js_max_height_hotline').matchHeight();
    $('.js_max_height_img').matchHeight();
    $('.itemVoucher').matchHeight();
    $('.imagesss .item').matchHeight();
    $('.maxTitleVoucher').matchHeight();
    $('.maxHeightTitle').matchHeight();
    $('.maxHeightDes').matchHeight();
    $('.maxHeightCourse').matchHeight();
    $('.maxHeightFilter').matchHeight();
    $('.maxHeightSpancate').matchHeight();
    $('.maxtitleJob').matchHeight();
    $('.maxHeightaddress').matchHeight();
    $('.js_maxHeight').matchHeight();
    $('.js_status_service').matchHeight();
    $('.itemsteep').matchHeight();
    $('.maxheight_recrui').matchHeight();
    $('.maxheight_recrui h4').matchHeight();
    $('.maxheight_recrui a').matchHeight();
    $('.maxHieght_content_recrui').matchHeight();
    $('.maxHieght_service').matchHeight();
    $('.maxHieght_service_image').matchHeight();
    $('.maxHieght_service_feature').matchHeight();

    $('.editor').each(function (e) {
        CKEDITOR.replace(this.id, {
            filebrowserImageBrowseUrl: '/kcfinder-master/browse.php?type=images&dir=images/public',
        });
    });
    $('.showHidenMenu').click(function(){
        $('.showOnLaptopMini .menu').toggle(500);
    });

    $('#close_fixel').click(function(){
        $('.js_fixel_mobile_dowload').hide();
    });
    // menu toggle sidebar hiden show
    //     $('#js_toogle_sidebar').mCustomScrollbar({
    //         theme: 'minimal'
    //     });

    $('#dismiss, .overlay').on('click', function () {
        // hide sidebar
        $('#js_toogle_sidebar').removeClass('active_show_sidebar');
        // hide overlay
        $('.overlay').removeClass('active');
    });

    $('#js_sidebarCollapse').on('click', function () {
        // open sidebar
        $('#js_toogle_sidebar').addClass('active_show_sidebar');
        // fade in the overlay
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
    function uploadImage(e) {
        window.KCFinder = {
            callBack: function (url) {
                window.KCFinder = null;
                var img = new Image();
                img.src = url;
                $(e).next().attr("src", url);
                $(e).next().next().val(url);
                $(e).attr("src", url);
                $(e).next().val(url);
                $(e).next().next().val(url);
                $(e).next().next().next().val(url);
                console.log($(e).next());
                console.log($(e).next().next());
            }
        };
        window.open('/kcfinder-master/browse.php?type=images&dir=images/public',
            'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600'
        );
    }
    function openKCFinder(e) {
        window.KCFinder = {
            callBackMultiple: function (files) {
                window.KCFinder = null;
                var urlFiles = "";
                $(e).next().empty();
                for (var i = 0; i < files.length; i++) {
                    $(e).next().append('<img src="' + files[i] + '" width="80" height="" style="margin-left: 5px; margin-bottom: 5px;"/>');
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

    function subcribeEmailSubmit(e) {
        var email = $(e).find('.emailSubmit').val();
        var token = $(e).find('input[name=_token]').val();

        $.ajax({
            type: "POST",
            url: '{!! route('subcribe_email') !!}',
            data: {
                email: email,
                _token: token
            },
            success: function (data) {
                var obj = jQuery.parseJSON(data);

                alert(obj.message);
            }
        });
        return false;
    }


    $(document).ready(function ($e) {

        $('.js_remove_href_a a').removeAttr("href");

        var _0x49cd = ["%c Bản quyền thuộc về sanketoan.vn", "color:red; font-size:22px", "log"];
        console[_0x49cd[2]](_0x49cd[0], _0x49cd[1]);

        $e(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $e('#back-to-top').click(function () {
            $e('#back-to-top').tooltip('hide');
            $e('body,html').animate({
                scrollTop: 0
            }, 1000);
            return false;
        });
        $e('#back-to-top').tooltip('show');
        $e('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
        $e('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            }
        });
        //cau hinh side bar chay theo
        var $window = $e(window);
        var windowsize = $window.width();
        if (windowsize >= 1000) {
            var stickySidebar = new StickySidebar('#sidebarCategory', {
                topSpacing: 0,
                bottomSpacing: 10,
                containerSelector: '#scollExam',
                innerWrapperSelector: '.sidebar__inner'
            });
        }


        //matach chieu cao


    });



    $(document).ready(function () {
        //show nooijj dung cho phép nhận thông báo
        if (!window.Notification)
        {
            console.log('Trình duyệt của bạn không hỗ trợ chức năng này.');
            // alert('Trình duyệt của bạn không hỗ trợ chức năng này.');
        }
        // Ngược lại trình duyệt có hỗ trợ thông báo
        else
        {
            // Gửi lời mời cho phép thông báo
            Notification.requestPermission(function (p) {
                // Nếu không cho phép
                if (p === 'denied')
                {
                    console.log('Bạn đã không cho phép thông báo trên trình duyệt.');
                    // $('#show_notification').modal('show');
                }
                // Ngược lại cho phép
                else
                {
                    console.log('Bạn đã cho phép thông báo trên trình duyệt, hãy bắt đầu thử Hiển thị thông báo.');
                    // $('#show_notification').modal('show');
                }
            });
        }

        //hiển thị thông tin hỗ trợ
        $('.showsupport').click(function () {
            $('.dropSupport').addClass('show');
        });
        $('.removeSupport').click(function () {
            $('.dropSupport').removeClass('show');
        });
        $('.DropContent a').click(function () {
            var dataid = $(this).attr('data-id');
            $('.DropContentItem .DropItem').empty();
            $.ajax({
                type: "get",
                url: '{!! route('ajax_post_content') !!}',
                data: {
                    dataid: dataid,
                },
                success: function (result) {
                    var obj = jQuery.parseJSON(result);
                    $('.DropContentItem .DropItem').empty();
                    var html = '<div class="DropItem">';
                    html += '<h3 class="f20 mgt15 fw6">' + obj.post.title + '</h3>';
                    html += obj.post.content;
                    html += ' </div>';
                    html += '<a href="/ho-tro/' + obj.post.slug + '" class="dropItemTitle" target="_blank">';
                    html += 'Mở trong cửa số mới <i class="fas fa-caret-right"></i><a>';
                    $('.DropContentItem').append(html);

                    $('.DropContent').hide();
                    $('.DropContentItem').show();
                    $('.showAjax').show();
                    $('.search .bodySearch ').append('<button class="btn btn-danger" onclick="return submitSearch(this);">Xem tất cả</button>')
                }
            });
        });
        var time = 1000;
        // Example usage:

        $('.searchAjax').keyup(function () {
            var word = $(this).val();
            $('.ContentSearch').hide();
            $.ajax({
                type: "get",
                url: '{!! route('search_post_ajax') !!}',
                data: {
                    word: word,
                },
                success: function (data_search) {
                    var obj = jQuery.parseJSON(data_search);
                    $('.ContentSearch').empty();
                    $.each(obj.posts, function (index, element) {
                        var html = '<a target="_blank" href="/tin-tuc/' + element.slug + '" data-id="' + element.post_id + '">';
                        html += '<span> <i class="fas fa-caret-right"></i> ';
                        html += element.title;
                        html += '</span>';
                        html += '</a>';
                        $('.ContentSearch').append(html);
                        // route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug])
                    });
                    $('.ContentSearch').show();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('.ContentSearch').empty();
                }
            });
        });


        $('.js-button').click(function () {
            var id_location = $(this).attr('js-data-localtion');
            var id_input = $(this).parent().find('input').val();

            var content = $(this).attr('js-content');
            if (id_input != '') {
                // alert(3);
                //       var contenthtml = $(this).parent().parent().find('ul').html('');

                $('.' + content).empty();
                $.ajax({
                    type: "get",
                    url: '{!! route('search_branch') !!}',
                    data: {
                        id_location: id_location,
                        id_input: id_input,
                    },
                    success: function (data_location) {
                        var obj = jQuery.parseJSON(data_location);
                        $.each(obj.local_barnch, function (index, element) {

                            var html = ' <li>';
                            html += '<a href="' + element.link + '" target="_blank"';
                            html += 'title="' + element.title + '">';
                            html += ' <i class="fas fa-circle">';
                            html += '</i> ';
                            html += '<span><b>';
                            html += element.title;
                            html += '</b></span>';
                            html += ' : ' + element.address + ' - ' + element.phone;
                            html += '</a></li>';
                            $('.' + content).append(html);
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {

                    }
                });
            }
        });
        $('.js-search-name').keyup(function () {
            var id_location = $(this).attr('js-data-localtion');
            var id_input = $(this).val();

            var content = $(this).attr('js-content');
            if (id_input != '') {
                // alert(3);
                //       var contenthtml = $(this).parent().parent().find('ul').html('');

                $('.' + content).empty();
                $.ajax({
                    type: "get",
                    url: '{!! route('search_branch') !!}',
                    data: {
                        id_location: id_location,
                        id_input: id_input,
                    },
                    success: function (data_localtion) {
                        $('.' + content).empty();
                        var obj = jQuery.parseJSON(data_localtion);
                        $.each(obj.local_barnch, function (index, element) {

                            var html = ' <li>';
                            html += '<a href="' + element.link + '" target="_blank"';
                            html += 'title="' + element.title + '">';
                            html += ' <i class="fas fa-circle">';
                            html += '</i> ';
                            html += '<span><b>';
                            html += element.title;
                            html += '</b></span>';
                            html += ' : ' + element.address + ' - ' + element.phone;
                            html += '</a></li>';
                            $('.' + content).append(html);
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('.' + content).empty();
                    }
                });
            }
        })
        $('.showAjax').click(function () {
            $('.DropContentItem .DropItem').remove();
            $('.DropContentItem .dropItemTitle').remove();
            $('.DropContent').show();
            $('.DropContentItem').hide();
            $('.showAjax').hide();
        });


        //cuộn trang header chay theo
        $(this).scrollTop(0);
        var s1 = $("header");
        var s2 = $(".submenu1");
        var pos = s1.position();
        var posheight = s1.height();
        var heightbody = $('body').height();
        var heightwindow = $(window).height();
        // alert('body ' + heightbody +'---------' + 'window' + heightwindow + '+++++++' + posheight);

        $(window).scroll(function () {
            var windowpos = $(window).scrollTop();
            if (windowpos > pos.top && ((heightbody - posheight) > heightwindow)) {
                s1.addClass("stickyhome");
                $('.top ').css('display', 'none')
            } else {
                s1.removeClass("stickyhome");
                $('.top ').css('display', 'block')
            }
            if (windowpos > (pos.top)) {
                s2.addClass("ds-none");
                $('.submenuPC').click(function () {
                    s2.removeClass("ds-none");
                });

                $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '0');
            } else {
                s2.removeClass("ds-none");
                $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '50px');


            }
        });

        $('.submenuPC').click(function () {
            $('.submenu1').toggle();
        });

        //thông báo đăng nhập thất bại




    });


    //thông báo modal
    $(document).ready(function () {
        //validate
//validate check email
        jQuery.validator.addMethod("checkEmail", function(value, element) {
            var result = false;
            $.ajax({
                async: false,
                url: '{!! route('check_email_employee') !!}',
                type: 'get',
                dataType: 'json',
                data: {
                    email: value
                }
            }).done(function(response) {
                result = response && response.status === 200;
            });
            return result;
        }, 'Email đã tồn tại.');
// validate check phone
        jQuery.validator.addMethod("checkPhone", function(value, element){
            var result = false;
            var checkPhone = $("input[name=phone]").val().split('');
            var dem = checkPhone.length;
            if (checkPhone[0]==0 && dem==10 || dem==15) {
                result = true;
            }else{

            }
            return result;
        }, 'Số điện thoại không hợp lệ.');
// validate năm sinh
        jQuery.validator.addMethod("checkBirthday", function(value, element) {
            var result = false;
            var now = new Date().getFullYear();
            var birthday = $(element).val();
            birthday = birthday.split("-");
            var check = now - birthday[0];
            if (check>=18) {
                result = true;
            }
            return result;
        }, 'Bạn chưa đủ 18 tuổi.');
        jQuery.validator.addMethod("checkBirthday_hople", function(){
            var result = false;
            var now = new Date().getFullYear();
            var birthday = $("input[name=birthday]").val();
            birthday = birthday.split("-");
            var check = now - birthday[0];
            if (check>=0) {
                result = true;
            }else{

            }
            return result;
        }, 'Năm sinh không hợp lệ.');

        // function checkExtensionFile(e) {
        //     let fileName = $(e).val();
        //     if (fileName.search('.doc') == -1 && fileName.search('.docx') == -1 && fileName.search('.pdf') == -1) {
        //         $('.js_error_cv').html('Bạn chỉ được tải CV với đuôi .doc, .docx hoặc .pdf')
        //         console.log('Bạn chỉ được tải CV với đuôi .doc, .docx hoặc .pdf');
        //     } else {
        //         $('.js_error_cv').html('');
        //     }
        // }
        jQuery.validator.addMethod("checkCV", function(){
            var result = false;
            var fileName = $("input[name=employee_cv]").val();
            if (fileName.search('.doc') == -1 && fileName.search('.docx') == -1 && fileName.search('.pdf') == -1) {
                return false;
            } else {
                return true;
            }
            return result;
        }, 'Bạn chỉ được tải CV với đuôi .doc, .docx hoặc .pdf.');

// vaidate tên
        jQuery.validator.addMethod("checkName", function(value, element){

            // var result = false;
            // var checkName = $(element).val();
            //   var regex = /[^a-zA-Z]+$/;
            //  if (checkName.search(regex)==-1) {
            //      result = true;
//}else{
            //    }

            return true;
        }, 'Họ và tên không hợp lệ.');
        //vai date ngày nộp hồ sơ
        $.validator.addMethod("minDate", function(value, element) {
            var curDate = '{{ date('Y-m-d') }}';
            var inputDate = $(element).val();
            if (curDate < inputDate)
            {
                return true;
            }
            else
            {
                return false;
            }
        }, "Ngày nộp hồ sở phải lớn hơn ngày hiện tại");   // error message

        @if(session('error_login'))
        $('#loginTiva').modal('show');
        @endif

        @if(session('error_employee'))
        $('#loginTiva').modal('show');
        $('#InfoWarning').html('{{ session('error_employee') }}');
        @endif
        //thong bao dang nhap that bai //dang nhap kiem tien
        @if(session('error_login_money'))
        $('#loginMoney').modal('show');
        @endif
        //kiểm tra đề thi tạo câu hỏi
        @if(session('errorQuestion'))
        $('#message').modal('show');
        $('.contentMessage').html('Đề thi này chưa được tạo câu hỏi');
        @endif
        @if(session('errorExam'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('errorExam') }}');
        @endif

        @if(session('success_dvisory'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('success_dvisory') }}');
        @endif
        //thong bao đăng nhập thành công
        @if(session('success_login'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('success_login') }}');
        @endif
        @if(session('erorr_submit'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('erorr_submit') }}');
        @endif
        //thông báo lỗi ứng viên đã nộp hồ sơ
        @if(session('error_job'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('error_job') }}');
        @endif
        @if(session('success_email'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('success_email') }}');
        @endif

        @if(session('status_card'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('status_card') }}');
        @endif
        @if(session('error'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('error') }}');
        @endif
        @if(session('success_apply_intership'))
        $('#message').modal('show');
        $('.contentMessage').html('{{ session('success_apply_intership') }}');
        @endif
    });
</script>
