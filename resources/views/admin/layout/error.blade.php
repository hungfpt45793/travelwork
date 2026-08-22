<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('adminstration/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{asset('adminstration/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
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
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('adminstration/css/skins/_all-skins.min.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('adminstration/jvectormap/jquery-jvectormap.css') }}">
    <!-- jquery ui -->
    <link rel="stylesheet" href="{{ asset('adminstration/jquery-ui-1.12.1.custom/jquery-ui.min.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('adminstration/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminstration/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('adminstration/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminstration/select2/dist/css/select2.min.css') }}">


    <!-- AdminLTE Skins. Choose a skin from the css/skins
      folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('adminstration/css/skins/_all-skins.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
    <!-- jQuery 3 -->
    <script src="{{ asset('adminstration/jquery/dist/jquery.min.js') }}"></script>
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
    <script src="{{ asset('adminstration/select2/dist/js/select2.full.min.js') }}"></script>
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
    <!-- thời gian hiển thị thông báo -->
    {{--push notification--}}
   
    <script data-cfasync="false">
        $(document).ready(function () {
            window.OneSignal = window.OneSignal || [];

            /* In milliseconds, time to wait before prompting user. This time is relative to right after the user presses <ENTER> on the address bar and navigates to your page */
            var notificationPromptDelay = 30000;

            /* Why use .push? See: http://stackoverflow.com/a/38466780/555547 */
            window.OneSignal.push(function () {
                /* Use navigation timing to find out when the page actually loaded instead of using setTimeout() only which can be delayed by script execution */
                var navigationStart = window.performance.timing.navigationStart;

                /* Get current time */
                var timeNow = Date.now();

                /* Prompt the user if enough time has elapsed */
                setTimeout(promptAndSubscribeUser, Math.max(notificationPromptDelay - (timeNow - navigationStart), 0));
            });

            function promptAndSubscribeUser() {
                window.OneSignal.isPushNotificationsEnabled(function (isEnabled) {
                    if (!isEnabled) {
                        /* Want to trigger different permission messages? See: https://documentation.onesignal.com/docs/permission-requests#section-onesignal-permission-messages */
                        window.OneSignal.showHttpPrompt();
                    }
                });
            }
        });
    </script>
    <!-- Khởi tạo oneSignal và cái chuông oneSinal -->
    <script>
        $(document).ready(function () {
            var OneSignal = window.OneSignal || [];
            OneSignal.push(["init", {
                appId: "5304fc87-a68b-461f-b9b9-da51dfdd0ce4",
                autoRegister: true, /* Set to true to automatically prompt visitors */
                httpPermissionRequest: {
                    enable: true
                },
                notifyButton: {
                    enable: true, /* Required to use the Subscription Bell */
                    /* SUBSCRIPTION BELL CUSTOMIZATIONS START HERE */
                    size: 'medium', /* One of 'small', 'medium', or 'large' */
                    theme: 'default', /* One of 'default' (red-white) or 'inverse" (white-red) */
                    position: 'bottom-right', /* Either 'bottom-left' or 'bottom-right' */
                    offset: {
                        bottom: '0px',
                        left: '0px', /* Only applied if bottom-left */
                        right: '0px' /* Only applied if bottom-right */
                    },
                    prenotify: true, /* Show an icon with 1 unread message for first-time site visitors */
                    showCredit: false, /* Hide the OneSignal logo */
                    text: {
                        'tip.state.unsubscribed': 'Subscribe to notifications',
                        'tip.state.subscribed': "You're subscribed to notifications",
                        'tip.state.blocked': "You've blocked notifications",
                        'message.prenotify': 'Click to subscribe to notifications',
                        'message.action.subscribed': "Thanks for subscribing!",
                        'message.action.resubscribed': "You're subscribed to notifications",
                        'message.action.unsubscribed': "You won't receive notifications again",
                        'dialog.main.title': 'Manage Site Notifications',
                        'dialog.main.button.subscribe': 'SUBSCRIBE',
                        'dialog.main.button.unsubscribe': 'UNSUBSCRIBE',
                        'dialog.blocked.title': 'Unblock Notifications',
                        'dialog.blocked.message': "Follow these instructions to allow notifications:"
                    },
                    colors: { // Customize the colors of the main button and dialog popup button
                        'circle.background': 'rgb(84,110,123)',
                        'circle.foreground': 'white',
                        'badge.background': 'rgb(84,110,123)',
                        'badge.foreground': 'white',
//                        'badge.bordercolor': 'white',
                        'pulse.color': 'white',
                        'dialog.button.background.hovering': 'rgb(77, 101, 113)',
                        'dialog.button.background.active': 'rgb(70, 92, 103)',
                        'dialog.button.background': 'rgb(84,110,123)',
                        'dialog.button.foreground': 'white'
                    },
                    /* HIDE SUBSCRIPTION BELL WHEN USER SUBSCRIBED */
                    displayPredicate: function() {
                        return OneSignal.isPushNotificationsEnabled()
                            .then(function(isPushEnabled) {
                                return !isPushEnabled;
                            });
                    }
                }
            }]);

            setInterval(function () {
                $.ajax({
                    type: "GET",
                    url: '{!! route('pushNotify') !!}',
                    success: function(result){
                        var obj = jQuery.parseJSON(result);
                        var message = obj.message;
                        var url = obj.url;
                        OneSignal.sendSelfNotification(
                            /* Title (defaults if unset) */
                            'Thông báo',
                            /* Message (defaults if unset) */
                            message,
                            /* URL (defaults if unset) */
                            url,
                            /* Icon */
                            'https://onesignal.com/images/notification_logo.png',
                            {
                                /* Additional data hash */
                                notificationType: 'news-feature'
                            }
                        );
                    },
                    error: function(error) {
                        console.log(error);
                    }

                });
            }, 30000)
        });
        // Hiển thị thông báo
        //        function showNotification(title, message){
        //            OneSignal.sendSelfNotification(
        //                /* Title (defaults if unset) */
        //                title,
        //                /* Message (defaults if unset) */
        //                message,
        //                /* URL (defaults if unset) */
        //                'https://example.com/?_osp=do_not_open',
        //                /* Icon */
        //                'https://onesignal.com/images/notification_logo.png',
        //                {
        //                    /* Additional data hash */
        //                    notificationType: 'news-feature'
        //                },
        //                [{ /* Buttons */
        //                    /* Choose any unique identifier for your button. The ID of the clicked button is passed to you so you can identify which button is clicked */
        //                    id: 'like-button',
        //                    /* The text the button should display. Supports emojis. */
        //                    text: 'Like',
        //                    /* A valid publicly reachable URL to an icon. Keep this small because it's downloaded on each notification display. */
        //                    icon: 'http://i.imgur.com/N8SN8ZS.png',
        //                    /* The URL to open when this action button is clicked. See the sections below for special URLs that prevent opening any window. */
        //                    url: 'https://example.com/?_osp=do_not_open'
        //                },
        //                    {
        //                        id: 'read-more-button',
        //                        text: 'Read more',
        //                        icon: 'http://i.imgur.com/MIxJp1L.png',
        //                        url: 'https://example.com/?_osp=do_not_open'
        //                    }]
        //            );
        //        }
    </script>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @yield('content')


</div>    <!--/.main-->

<footer class="main-footer" style="position: fixed; bottom: 0; margin-left:0; width: 100%;">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2018 <a href="https://vn3c.com">Công ty cổ phần công nghệ VN3C Việt Nam</a>.</strong> - Hotline: 093 455 3435 - 097 456 1735
</footer>
@stack('scripts')

<script>
    $(function () {
        // $( "#sortable2" ).sortable();
        // $( "#sortable2" ).disableSelection();

        $('#user').DataTable();

        //Initialize Select2 Elements
        $('.select2').select2()

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })
        $('.editor').each(function(e){
            CKEDITOR.replace( this.id, {
                filebrowserImageBrowseUrl : '/kcfinder-master/browse.php?type=images&dir=images/public',
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
            callBack: function(url) {window.KCFinder = null;
                var img = new Image();
                img.src = url;
                $(e).next().attr("src",url);
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
                for (var i = 0; i < files.length; i++){
                    $(e).next().append('<img src="'+ files[i] +'" width="80" height="70" style="margin-left: 5px; margin-bottom: 5px;"/>')
                    urlFiles += files[i] ;
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

</body>
</html>
