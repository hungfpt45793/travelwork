<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('assets/image/new/Logo.png') }}" type="image/png"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('adminstration/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
          href="{{asset('adminstration/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminstration/font-awesome/css/font-awesome.min.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('adminstration/plugins/iCheck/all.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminstration/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('adminstration/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminstration/css/AdminLTE.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('adminstration/emojionearea/emojionearea.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('adminstration/css/skins/_all-skins.min.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('adminstration/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('adminstration/jvectormap/jquery-jvectormap.css') }}">
    <!-- jquery ui -->
    <link rel="stylesheet" href="{{ asset('adminstration/jquery-ui-1.12.1.custom/jquery-ui.min.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet"
          href="{{ asset('adminstration/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminstration/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('adminstration/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminstration/select2/dist/css/select2.min.css') }}">
    

    <!-- AdminLTE Skins. Choose a skin from the css/skins
      folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('adminstration/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminstration/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('adminstration/css/customStyle.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
    <!-- jQuery 3 -->
    <script src="{{ asset('adminstration/jquery/dist/jquery.min.js') }}"></script>

    <!-- typeahead -->
    <script src="{{ asset('assets/js/bootstrap3-typeahead.min.js') }}"></script>
    <script src="{{ asset('assets/js/selectize.min.js') }}"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminstration/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="{{ asset('js/jquery-sortable-lists.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('adminstration/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminstration/select2/dist/js/select2.full.js') }}"></script>
    <!-- Morris.js charts -->
    <script src="{{ asset('adminstration/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('adminstration/morris.js/morris.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('adminstration/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminstration/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('adminstration/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap -->
    <script src="{{ asset('adminstration/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('adminstration/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('adminstration/jquery-knob/dist/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('adminstration/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('adminstration/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ asset('adminstration/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('adminstration/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('adminstration/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('adminstration/fastclick/lib/fastclick.js') }}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('adminstration/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('adminstration/fastclick/lib/fastclick.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('adminstration/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('adminstration/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('adminstration/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- CK Editor -->
    <script src="{{ asset('adminstration/ckeditor/ckeditor.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminstration/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('adminstration/js/demo.js') }}"></script>
    <script src="{{ asset('adminstration/jquery.priceformat.js') }}"></script>
    <script src="{{ asset('adminstration/emojionearea/emojionearea.js') }}"></script>
    <script src="{{asset('adminstration/js/numeral/numeral.min.js')}}"></script>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        @media (max-width: 1366px) {
            .navbar-nav > li > a {
                padding: 15px 5px;
            }
        }

        .skin-blue .sidebar-menu > li.header {
            color: #4b646f;
            background: #1a2226;
            background: orange;
            color: #fff;
            font-size: 14px;
        }
    </style>

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('admin.partials.nav')

    @if ($menuTop == 'websites')
        @include('admin.partials.slidebar')
    @endif

    @if ($menuTop == 'jobs')
        @include('sidebar.sl_job')
    @endif

    @if ($menuTop == 'sales')
        @include('sidebar.sl_sale')
    @endif

    @if ($menuTop == 'orders')
        @include('sidebar.sl_order')
    @endif

    @if ($menuTop == 'customers')
        @include('sidebar.sl_customer')
    @endif

    @if ($menuTop == 'employer_coin')
        @include('sidebar.sl_employer_coin')
    @endif

    @if ($menuTop == 'promotion')
        @include('sidebar.sl_promotion')
    @endif

    @if ($menuTop == 'setting')
        @include('sidebar.sl_setting')
    @endif

    @if ($menuTop == 'report')
        @include('sidebar.sl_report')
    @endif

    @if ($menuTop == 'voucher')
        @include('sidebar.sl_voucher')
    @endif
    @if ($menuTop == 'exam')
        @include('sidebar.sl_exam')
    @endif
    @if ($menuTop == 'information_service')
        @include('sidebar.sl_infomation_service')
    @endif
    @if ($menuTop == 'transaction')
        @include('sidebar.sl_transaction')
    @endif
    @if ($menuTop == 'template_email')
        @include('sidebar.sl_template_email')
    @endif
    @if ($menuTop == 'teacher_school')
        @include('sidebar.sl_teacher_school')
    @endif
    @if ($menuTop == 'list_price')
        @include('sidebar.sl_list_price')
    @endif
    @if ($menuTop == 'cv_template')
        @include('sidebar.sl_cv_template')
    @endif
    @if ($menuTop == 'educate')
        @include('sidebar.sl_educate')
    @endif


    <div class="content-wrapper">
        <div style="color: red; text-align: center"> {!! \App\Ultility\Error::getErrorMessage() !!}</div>
        @yield('content')
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; <?php echo date("Y") ?><a href="/"> Sàn kế toán</a>.</strong> -
        Hotline: {{ isset($information['hotline']) ?  $information['hotline'] : '' }}
        - {{ isset($information['so-dien-thoai']) ?  $information['so-dien-thoai'] : '' }}
    </footer>
</div>    <!--/.main-->


@stack('scripts')
<script>
    $('.formatPrice').priceFormat({
        prefix: '',
        centsLimit: 0,
        thousandsSeparator: '.'
    });
</script>
<script>
    $(function () {

        // $( "#sortable2" ).sortable();
        // $( "#sortable2" ).disableSelection();
        jQuery("#contentFacebook").emojioneArea({
            pickerPosition: "left",
            tonesStyle: "bullet"
        });

        $('#user').DataTable();

        //Initialize Select2 Elements
        $('.select2').select2({width: '100%'});
        $('.select22').select2();

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
        $('.editor').each(function (e) {
            CKEDITOR.replace(this.id, {
                filebrowserImageBrowseUrl: '/kcfinder-master/browse.php?type=images&dir=images/public',
            });
        });

        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            }
        });

    });


    function uploadImage(e) {
        window.KCFinder = {
            callBack: function (url) {
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
            callBackMultiple: function (files) {
                window.KCFinder = null;
                var urlFiles = "";
                $(e).next().empty();
                for (var i = 0; i < files.length; i++) {
                    $(e).next().append('<img src="' + files[i] + '" width="80" height="70" style="margin-left: 5px; margin-bottom: 5px;"/>')
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
</script>
<script>
    $('.formatPrice').priceFormat({
        prefix: '',
        centsLimit: 0,
        thousandsSeparator: '.'
    });
</script>

{{-- scrip để thêm từ khóa --}}
<script>
    // Initialize tooltip component
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    
    // Initialize popover component
    $(function () {
      $('[data-toggle="popover"]').popover()
    })

    // ajax thêm từ khóa
    $(document).ready(function() {
        $('button.LuuTuKhoa').on('click', function() {
            $.ajax({
                type: 'GET',
                url: "{{ route('them_tu_khoa_ajax') }}",
                data: {
                    tag_type: $('input[name="tag_type"]').val(),
                    tag_title: $('input[name="tag_title"]').val(),
                    tag_description: $('textarea[name="tag_description"]').val()
                },
                success: function(res){
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

@if (!empty($domainUser))
    <?php
    $datetime1 = new DateTime();
    $datetime2 = new DateTime($domainUser->end_at);
    $interval = $datetime1->diff($datetime2);
    ?>
    @if ($interval->format('%a') <= 30)
        <!-- Load Facebook SDK for JavaScript -->
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

        <!-- Your customer chat code -->
        <div class="fb-customerchat"
             attribution="setup_tool"
             page_id="1556924511289480">
        </div>
    @endif
@endif
</body>
</html>
