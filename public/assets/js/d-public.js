$(function() {
    $('.showsupport').on('click', function() {
        $('.dropSupport').toggleClass('show');
    });
    $('.removeSupport').on('click', function() {
        $('.dropSupport').removeClass('show');
    });
    //hiển thị thông báo
    $('.shownotification').on('click', function() {
        $('.dropnotification').toggleClass('show');
    });

    //cuộn trang header chay theo
    $(this).scrollTop(0);
    var s1 = $("header ");
    var s2 = $(".submenu1 ");
    var pos = s1.position();
    var posheight = s1.height();
    var heightbody = $('body').height();
    var heightwindow = $(window).height();

    $(window).on('scroll', function() {
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
            $('.submenuPC').on('click', function() {
                s2.removeClass("ds-none ");
            });

            $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '0');
        } else {
            s2.removeClass("ds-none ");
            $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '50px');


        }
    });
    // an hiện sidebar
    $('.bars_scroll').on('click', function() {

        $('.d-parent').toggleClass('col-xl-3 col-lg-3');
        $('.d-parent').toggleClass('col-xl-1 col-lg-1');
        $('.d-THScontent').toggleClass('col-xl-9 col-lg-9');
        $('.d-THScontent').toggleClass('col-xl-11 col-lg-11');
        $('.d-sidebar').toggleClass('active');
    });
    $('.bars_scroll').on('click', function() {
        localStorage.setItem('activeTab', 'ok');
    });
    $('.bars_scroll').on('click', function() {
        localStorage.removeItem('activeTab');
    });
    if (localStorage.getItem('activeTab') != null) {
        $('.d-parent').removeClass('col-xl-3 col-lg-3');
        $('.d-parent').addClass('col-xl-1 col-lg-1');
        $('.d-THScontent').removeClass('col-xl-9 col-lg-9');
        $('.d-THScontent').addClass('col-xl-11 col-lg-11');
        $('.d-sidebar').toggleClass('active');
    }

    // if ($('.d-sidebarCollapse i.d-left-right').hasClass('fa-angle-double-right')) {
    //     localStorage.setItem('activeTab', 'ok');
    // }
    // form select2
    // mở rộng co vào hạng mục ở sidebar
    $('.d-expand').parent().parent().find('ul').hide();
    $('.d-expand.d-show').parent().parent().find('ul').show();
    $('.d-expand').parent().on('click', function() {
        $(this).toggleClass('d-bco2');
        $(this).parent().find('ul').slideToggle("slow");
        $(this).find('.d-expand').toggleClass('fa-chevron-left fa-chevron-down');
    });
    $('.fa-chevron-left').parent().parent().find('ul').show()

    // co dãn menu màn ảnh nhỏ
    $(".d-THScontent .open-res").on('click', function() {
        $(".d-THScontent .THSmenu").slideToggle();
    });
    // mở sidebar màn ảnh nhỏ
    $(".d-menu_on_desktop .d-parent .toggle-sidebar i").on('click', function() {
        $(".d-parent.d-sidebarfull").toggle("fast");
    });

    $("#checkAll").on('click', function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('.idexpand').on('click', function() {
        $(this).parent().parent().toggleClass('setlenght');
    });

    function myFunction() {
        var copyText = document.getElementById("my-copy");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Copied the text: " + copyText.value);
    }

    window.onload = function(){
        var a = sessionStorage.getItem("pass_day")
        if(a==1){

            $('.pass_date').val("Chọn ngày");
            $(".myDatetime").css('opacity',0);
            $(".myDatetime").attr("disabled", true);
        }
        else if(a==2){
            $(".myDatetime").css('opacity',1);
            $(".myDatetime").attr("disabled", false);
        }

        $('.pass_date').on('click', function(){
            if($(".myDatetime").prop("disabled") == false){
                $(this).val("Chọn ngày");
                $(".myDatetime").css('opacity',0);
                sessionStorage.setItem("pass_day", 1);
                $(".myDatetime").attr("disabled", true);
            }
            else if($(".myDatetime").prop("disabled") == true){
                $(this).val("Bỏ qua ngày");
                $(".myDatetime").css('opacity',1);
                sessionStorage.setItem("pass_day", 2);
                $(".myDatetime").attr("disabled", false);

            }
        })
    };

    let offset_active = $('.d-sidebarfull li.d-hvbgrBlueN a.activeTHS').offset();
    console.log(offset_active);
    $('.d-sidebarfull.d-sidebarfull').scrollTop(offset_active.top - 200);

});

