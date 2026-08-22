

<script>
    $(document).ready(function ($e) {

//hiển thị thông báo
        function showNoti(title, body, icon, tag) {
            var notify;
// Nếu chưa cho phép thông báo
            if (Notification.permission == 'default') {
                console.log('Bạn phải cho phép thông báo trên trình duyệt mới có thể hiển thị nó.');
            }
// Ngược lại đã cho phép
            else {
// Tạo thông báo
                notify = new Notification(
                    title, // Tiêu đề thông báo
                    {
                        body: body, // Nội dung thông báo vd : SAnketoan vừa đăng một bài viết mới
                        icon: icon, // Hình ảnh vd http://sanketoan.local/public/library/images/logo/logo2.png
                        tag: tag // Đường dẫn vd http://sanketoan.local/
                    }
                );
// Thực hiện khi nhấp vào thông báo
                notify.onclick = function () {
                    window.location.href = this.tag; // Di chuyển đến trang cho url = tag
                }
                console.log('Gửi thông báo thành công.');
            }
        }

//hiển thị thông báo khi đăng nhập

                @if(\Illuminate\Support\Facades\Auth::check())
            <?php
            $user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $lists = \App\Entity\NotificationWindow::showNoti($user_id);
            ?>
                @if(!empty($lists))
                @foreach($lists as $list)
        var notify;
        var title = '{{ $list->title_noti }}';
        var body = '{{ $list->des_noti }}';
        var icon = '{{ isset($information['logo']) ?  asset($information['logo']) : '' }}';
        var tag = '{{ $list->link_noti }}';
        // Nếu chưa cho phép thông báo
        if (Notification.permission == 'default') {
            console.log('Bạn phải cho phép thông báo trên trình duyệt mới có thể hiển thị nó.');
        }
        // Ngược lại đã cho phép
        else {
            // Tạo thông báo
            notify = new Notification(
                title, // Tiêu đề thông báo
                {
                    body: body, // Nội dung thông báo vd : SAnketoan vừa đăng một bài viết mới
                    icon: icon, // Hình ảnh vd http://sanketoan.local/public/library/images/logo/logo2.png
                    tag: tag // Đường dẫn vd http://sanketoan.local/
                }
            );
            // Thực hiện khi nhấp vào thông báo
            notify.onclick = function () {
                window.location.href = this.tag; // Di chuyển đến trang cho url = tag
            }
            <?php
            $view_noti = \App\Entity\NotificationWindow::update_view_window($list->id_noti)
            ?>
        }
        console.log('Đã gửi thông báo window thành công');
        @endforeach
        @endif
        //cứ 1p thì hiển thị thông báo 1 lần
        setInterval(function(){
            var id_user = '{{ $user_id }}';
            var notify5s;
            $.ajax({
                type: "get",
                url: '{!! route('ajax_checkNoti') !!}',
                data: {
                    user_id: id_user,
                },
                success: function (data_noti) {
                    var obj = jQuery.parseJSON(data_noti);
                    $.each(obj.list_noti, function (index, noti) {
                        notify5s = new Notification(
                            noti.title_noti, // Tiêu đề thông báo
                            {
                                body: noti.des_noti, // Nội dung thông báo vd : SAnketoan vừa đăng một bài viết mới
                                icon: '{{ isset($information['logo']) ?  asset($information['logo']) : '' }}', // Hình ảnh vd http://sanketoan.local/public/library/images/logo/logo2.png
                                tag: noti.link_noti // Đường dẫn vd http://sanketoan.local/
                            }
                        );
                        // Thực hiện khi nhấp vào thông báo
                        notify5s.onclick = function () {
                            window.location.href = this.tag; // Di chuyển đến trang cho url = tag
                        };

                        {{--$.ajax({--}}
                        {{--type: "get",--}}
                        {{--url: '{!! route('ajax_update_view_window) !!}',--}}
                        {{--data: {--}}
                        {{--id_noti: noti.id_noti,--}}
                        {{--},--}}
                        {{--success: function (result) {--}}
                        {{--},--}}
                        {{--error: function (xhr, ajaxOptions, thrownError) {--}}
                        {{--}--}}
                        {{--});--}}
                        console.log(noti.id_noti);
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                }
            });

        },60000);
        @endif
        //hiển thị thông báo
        function showNoti(title, body, icon, tag) {
            var notify;
// Nếu chưa cho phép thông báo
            if (Notification.permission == 'default') {
                console.log('Bạn phải cho phép thông báo trên trình duyệt mới có thể hiển thị nó.');
            }
// Ngược lại đã cho phép
            else {
// Tạo thông báo
                notify = new Notification(
                    title, // Tiêu đề thông báo
                    {
                        body: body, // Nội dung thông báo vd : SAnketoan vừa đăng một bài viết mới
                        icon: icon, // Hình ảnh vd http://sanketoan.local/public/library/images/logo/logo2.png
                        tag: tag // Đường dẫn vd http://sanketoan.local/
                    }
                );
// Thực hiện khi nhấp vào thông báo
                notify.onclick = function () {
                    window.location.href = this.tag; // Di chuyển đến trang cho url = tag
                }
                console.log('Gửi thông báo thành công.');
            }
        }

//hiển thị thông báo khi đăng nhập

                @if(\Illuminate\Support\Facades\Auth::check())
            <?php
            $user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $lists = \App\Entity\NotificationWindow::showNoti($user_id);
            ?>
                @if(!empty($lists))
                @foreach($lists as $list)
        var notify;
        var title = '{{ $list->title_noti }}';
        var body = '{{ $list->des_noti }}';
        var icon = '{{ isset($information['logo']) ?  asset($information['logo']) : '' }}';
        var tag = '{{ $list->link_noti }}';
        // Nếu chưa cho phép thông báo
        if (Notification.permission == 'default') {
            console.log('Bạn phải cho phép thông báo trên trình duyệt mới có thể hiển thị nó.');
        }
        // Ngược lại đã cho phép
        else {
            // Tạo thông báo
            notify = new Notification(
                title, // Tiêu đề thông báo
                {
                    body: body, // Nội dung thông báo vd : SAnketoan vừa đăng một bài viết mới
                    icon: icon, // Hình ảnh vd http://sanketoan.local/public/library/images/logo/logo2.png
                    tag: tag // Đường dẫn vd http://sanketoan.local/
                }
            );
            // Thực hiện khi nhấp vào thông báo
            notify.onclick = function () {
                window.location.href = this.tag; // Di chuyển đến trang cho url = tag
            }
            <?php
            $view_noti = \App\Entity\NotificationWindow::update_view_window($list->id_noti)
            ?>
        }
        console.log('Đã gửi thông báo window thành công');
        @endforeach
        @endif
        //cứ 1p thì hiển thị thông báo 1 lần
        setInterval(function(){
            var id_user = '{{ $user_id }}';
            var notify5s;
            $.ajax({
                type: "get",
                url: '{!! route('ajax_checkNoti') !!}',
                data: {
                    user_id: id_user,
                },
                success: function (data_noti) {
                    var obj = jQuery.parseJSON(data_noti);
                    $.each(obj.list_noti, function (index, noti) {
                        notify5s = new Notification(
                            noti.title_noti, // Tiêu đề thông báo
                            {
                                body: noti.des_noti, // Nội dung thông báo vd : SAnketoan vừa đăng một bài viết mới
                                icon: '{{ isset($information['logo']) ?  asset($information['logo']) : '' }}', // Hình ảnh vd http://sanketoan.local/public/library/images/logo/logo2.png
                                tag: noti.link_noti // Đường dẫn vd http://sanketoan.local/
                            }
                        );
                        // Thực hiện khi nhấp vào thông báo
                        notify5s.onclick = function () {
                            window.location.href = this.tag; // Di chuyển đến trang cho url = tag
                        };

                        {{--$.ajax({--}}
                        {{--type: "get",--}}
                        {{--url: '{!! route('ajax_update_view_window) !!}',--}}
                        {{--data: {--}}
                        {{--id_noti: noti.id_noti,--}}
                        {{--},--}}
                        {{--success: function (result) {--}}
                        {{--},--}}
                        {{--error: function (xhr, ajaxOptions, thrownError) {--}}
                        {{--}--}}
                        {{--});--}}
                        console.log(noti.id_noti);
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                }
            });

        },60000);
        @endif


    });
</script>