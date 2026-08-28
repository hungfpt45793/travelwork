@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Thông tin ứng viên'.isset($employee['employee_name']) ? $employee['employee_name'] : '')
@section('meta_description', 'Thông tin ứng viên'.isset($employee['employee_name']) ? $employee['employee_name'] : '')
@section('keywords','Thông tin ứng viên'.isset($employee['employee_name']) ? $employee['employee_name'] : '')

@section('meta_image', !empty($employee->employee_image) ? asset($employee->employee_image) :
asset($information['logo']) )

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/web/css/list_employee.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/detail_employee.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/preview_pdf.css"/>
@endsection
<style>
    header {
        display: none !important;
    }

    footer {
        display: none !important;
    }

    .call_phone {
        display: none !important;
    }

    .send_email_contact {
        display: none !important;
    }

    .footerContent {
        display: none !important;
    }

    .buildWeb {
        display: none !important;
    }

    .register_user_new {
        display: none !important;
    }

    #page1-div {
        margin: 0 auto;
    }

    #page2-div {
        margin: 0 auto;
    }

    #page3-div {
        margin: 0 auto;
    }

    #page4-div {
        margin: 0 auto;
    }

    #page5-div {
        margin: 0 auto;
    }

    .icon_sendemail a i {
        margin-top: 6px;
    }

    .iframe_cv_employee {
        max-width: 100%;
        width: 100%;
        height: 90vh;
    }

    #appendToThis {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        border-radius: 5px;
    }

    @media (max-width: 500px) {
        .box_mobile_bottom2 .box_mobile_bottom_closed2 {
            display: none !important;
        }

        .show_mobile_bottom {
            display: none !important;
        }

        #appendToThis {
            height: 100vh;
            overflow: inherit !important;
            width: 100% !important;
            margin: auto;
            overflow-x: inherit !important;
        }

        .iframe_cv_employee {
            max-width: 100%;
            width: 100%;
            height: 60vh !important;
        }

        .box_item_cv {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            overflow-x: scroll !important;
            overflow-y: scroll !important;
        }

        .div_append {
            height: 100% !important;
        }
    }
</style>
@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                <div class="col-lg-12 div_width pr-0" style="background-color: #fff;position:relative" id="">

                    <?php
                    $check_show_employee = '';
                    //xem co upload cv khong
                    $check_show_cv = \App\Entity\Employee_upload_cv::check_employee_cv_status($employee->employee_id); //kiểm tra trạng thái upload của cv xem có dung cv hay dùng cv đã tạo
                    //lay link cv upload
                    $link_html = '';
                    $cv_upload = \App\Entity\Employee_upload_cv::get_employee_link_cv($employee->employee_id);
                    if (!empty($cv_upload->employee_link_cv)) {
                        $link_cv_upload = str_replace('/public', '', $cv_upload->employee_link_cv);
                        $array = explode('/', $link_cv_upload);
                        $array1 = explode('/', $link_cv_upload);
                        $array_delete = array_pop($array1);  //xoa phan tu cuoi cung trong mang
                        $pre_link = implode('/', $array1);//lay ve duong dan thu muc luu cv
                        $name = end($array); //lấy về tên file
                        $array_name = explode('.', $name);
                        $name_file = current($array_name) . '-html';//lay đường dẫn html đến ẩn đi email phone
                        $link_html = $pre_link . '/' . $name_file . '.html'; //đường dẫn dùng js
                        if (!empty($cv_upload->employee_link_html)) {
                            $link_html = str_replace('/public', '', $cv_upload->employee_link_html);
                        }
                    }
                    $employer_id = !empty($_GET['employer_id']) ? $_GET['employer_id'] : 0;
                    if (!empty($employer_id)) {
                        $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer_id, $employee->employee_id);
                    }

                    ?>
                    {{--//có cv upload--}}
                    @if(!empty($check_show_cv))
                        @if(!empty($check_show_employee))

                            <?php




                            $link_cv_upload_public = str_replace('/public', '', $cv_upload->employee_link_cv);
                            $link_cv_upload = asset($link_cv_upload_public);
                            ?>
                            {{--//nếu có cv upload thì show nếu k thì hiện cv mã hóa--}}
                            @if(file_exists(public_path($link_cv_upload_public)))
                                <iframe class="iframe_cv_employee"
                                        src="https://docs.google.com/gview?url={{ asset($link_cv_upload) }}&embedded=true"
                                        frameborder="0"></iframe>
                            @else
                                <img class="img_cv_employee" src="/image_cv_upload/cv_upload.jpg" alt=""
                                     style="width: 100%;">
                            @endif
                        @else
                            @if(file_exists(public_path($link_html)))
                                <p class="text-center text-danger text_code">Đây là CV đã được số hóa, Để xem CV đầy đủ
                                    mời mua điểm.
                                </p>
                                <div id="appendToThis"></div>
                                <!-- <iframe id="myFrame"  src="javascript:;" style="width: 100%; height: 90vh; "></iframe> -->
                            @else
                                <img class="img_cv_employee" src="/image_cv_upload/cv_upload.jpg" alt=""
                                     style="width: 100%;">
                            @endif
                        @endif
                    @else
                        <div id="appendToThis">
                            @if(!empty($check_show_employee))
                                <?php
                                $link_cv_upload = route('employer_exportpdf_cv_user_id', ['user_id' => $employee->user_id]) . '?employer_id=' . $employer_id;
                                ?>
                                <iframe class="iframe_cv_employee"
                                        src="https://docs.google.com/gview?url={{ asset($link_cv_upload) }}&embedded=true"
                                        frameborder="0"></iframe>
                            @else
                                <p class="text-center text-danger text_code">
                                    Đây là CV đã được số hóa, Để xem CV đầy đủ mời mua điểm.
                                </p>
                                @include('site.employee_site.partials.item_cv_template_employee', ['employee' =>$employee ,'check_show_employee'=>$check_show_employee])
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
<script type="text/javascript" src="/assets/js/sweetalert.min.js"></script>
@section('show_js')

    <script>
        // A $( document ).ready() block.
        $(document).ready(function () {
            console.log("ready!");
            var userAgent = navigator.userAgent || navigator.vendor || window.opera;
            var link_mobile_android = '{{ isset($information['link-tai-app-androi']) ?  $information['link-tai-app-androi'] : '' }}';
            var link_mobile_ios = '{{ isset($information['link-tai-app-ios']) ?  $information['link-tai-app-ios'] : '' }}';
            // iOS detection from: http://stackoverflow.com/a/9039885/177710
            if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                //console.log( "ready! 2222" );
                $('#appendToThis').css("zoom", "1");
                $('#appendToThis').css("height", "45vh");
            }
        });
    </script>
    <script>
        @if(!empty($link_html) && file_exists(public_path($link_html)))
        var replacement = `<b style="background: #d03737;font-weight: 400;color: #f3f32f;">Thông tin này đã được ẩn.</b>`;
        function replaceText(i, el) {
            if (el.nodeType === 3) {
                        @foreach(\App\Entity\Regex::get_regexs() as $key => $regex)
                var regex{{$key}} = {{ $regex->content }};
                if (regex{{$key}}.test(el.data)) {
                    $(el).replaceWith(el.data.replace(regex{{$key}}, replacement));
                }
                @endforeach
            } else {
                $(el).contents().each(replaceText);
            }
        }
        @endif
        @if(!empty($check_show_cv) && file_exists(public_path($link_html)))
        $.get("{{$link_html}}", function (data) {
            // doc du lieu trang html
            $("#appendToThis").append(`<div class="div_append">${data}</div>`);
            var iContentBody = $("#appendToThis");
            $("#appendToThis").find('p:contains("facebook.com")').remove();
            $("#appendToThis").find('p:contains("fb.com")').remove();
            $("#appendToThis").find('p:contains("linkedin.com")').remove();
            $("#appendToThis").find('a[href^="mailto:"]').remove();
            $("#appendToThis").each(replaceText);
            let src_html = '<?php echo $link_html; ?>';
            let array_src_html = src_html.split('/');
            const lastItem = array_src_html[array_src_html.length - 1]
            arr_width = [];
            $('#appendToThis img').map(function () {
                let width = $(this).width();
                arr_width.push(width);
                let src = $(this).attr('src')
                if (src.indexOf('base64') == -1) {
                    let true_src = src_html.replace(lastItem, src);
                    $(this).attr('src', true_src);
                }
            });
            let max_width = Math.max(...arr_width)
            let min_width = $(".div_width").width()
            let zoom = min_width / max_width;
            if (min_width > 1100) {
                $("#appendToThis").css('zoom', '1.0');
            } else {
                $("#appendToThis").css('zoom', zoom);
            }
            $('#page1-div').css('margin', '0 auto');
            // $("*").not("i").css('font-family', 'Arial')
            // $("*").not("i").css('font-size', '14px')
        });
        @endif
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
    <script>
        var myState = {
            pdf: null,
            currentPage: 1,
            zoom: 1
        }
        @if(!empty($check_show_cv))
        @if(!empty($check_show_employee))
        pdfjsLib.getDocument('{{ $link_cv_upload }}').then((pdf) => {
            myState.pdf = pdf;
            myState.pdf.getPage(myState.currentPage).then((page) => {
                var viewport = page.getViewport(myState.zoom);
                var viewport_width = viewport.width;
                var div_width = $('.div_width').width();

                var zoom_num = div_width / viewport_width;
            });
            render();
            $('.loading_cv').css('display', 'none')
        });
        @endif
        @else
        pdfjsLib.getDocument('{{ route('employer_exportpdf_cv_user_id',['user_id '=> $employee->user_id]) }}').then((pdf) => {
            myState.pdf = pdf;
            myState.pdf.getPage(myState.currentPage).then((page) => {
                var viewport = page.getViewport(myState.zoom);
                var viewport_width = viewport.width;
                var div_width = $('.div_width').width();
                var zoom_num = div_width / viewport_width;
                myState.zoom = zoom_num;
            });
            render();
            $('.loading_cv').css('display', 'none')
        });

        @endif

        function render() {
            myState.pdf.getPage(myState.currentPage).then((page) => {

                var canvas = document.getElementById("pdf_renderer");
                var ctx = canvas.getContext('2d');

                var viewport = page.getViewport(myState.zoom);

                canvas.width = viewport.width;
                canvas.height = viewport.height;

                page.render({
                    canvasContext: ctx,
                    viewport: viewport
                });
            });
        }
        document.getElementById('go_previous').addEventListener('click', (e) => {
            if (myState.pdf == null || myState.currentPage == 1)
                return;
            myState.currentPage -= 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
        });
        document.getElementById('go_next').addEventListener('click', (e) => {
            if (myState.pdf == null || myState.currentPage > myState.pdf._pdfInfo.numPages)
                return;
            myState.currentPage += 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
        });
        document.getElementById('zoom_in').addEventListener('click', (e) => {
            if (myState.pdf == null) return;
            myState.zoom += 0.2;
            render();
        });

        document.getElementById('zoom_out').addEventListener('click', (e) => {
            if (myState.pdf == null) return;
            myState.zoom -= 0.2;
            render();
        });
    </script>

@endsection

