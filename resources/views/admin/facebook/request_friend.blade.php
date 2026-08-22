@extends('admin.layout.admin')

@section('title', 'Tự động gửi kết bạn')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tự động gửi kết bạn
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tự động gửi kết bạn</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box-header with-border">
                    <h3 class="box-title">Tự động gửi kết bạn</h3>
                </div>
                <form action="{!! route('get_uid_from_excel') !!}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="box-content">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nhập lên danh sách uid</label>
                            <input type="file" name="file" required><br>
                            <input type="hidden" name="route" value="1" />
                            <button type="submit" class="btn btn-primary">Lưu danh sách uid</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box-header with-border">
                    <h3 class="box-title">Tự động gửi lời mời kết bạn</h3>
                </div>
                <div class="box-content">
                    <div class="form-group">
                        <button class="btn btn-primary " onclick="return requestFriend(this);" data-loading-text="Cập nhật...">Tự động gửi lời mời kết bạn</button>
                        <div class="progress uidGroup col-xs-6" style="display: none">
                            <div class="progress-bar uidGroup-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
                                0%
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script>
        function requestFriend(e) {
            var btn = $(e).button('loading');
            $('.uidGroup').show();
            var start = 0;
            var limit = 1;
            update();
            function update() {
                $.ajax({
                    type: "get",
                    url: '{!! route('request_friend') !!}',
                    data: {
                        start: start,
                        limit: limit
                    },
                    success: function(result){
                        var obj = jQuery.parseJSON( result);
                        $('.uidGroup-bar').attr('style', 'width: '+ obj.percent +'%;');
                        $('.uidGroup-bar').empty();
                        $('.puidGroup-bar').append(obj.percent + '%');
                        console.log(start);
                        start = obj.start;
                        console.log(obj.success);
                        if (obj.success == 1) {
                            if (obj.delay == 1) {
                                alert('Bạn đã request 1 lúc nhiều người, vui lòng đợi 2 tiếng nữa quay lại và thực hiện lại bước này.');
                                location.reload();

                                return false;
                            }
                            $('.uidGroup-bar').attr('style', 'width: 100%;');
                            $('.uidGroup-bar').empty();
                            $('.uidGroup-bar').append('100%');

                            alert('Bạn đã cập nhật thành công');
                            btn.button('reset')
                            $('.uidGroup').hide();
                            location.reload();
                        } else {
                            setTimeout(function(){
                                update();
                            }, 60000);
                        }
                    }
                });
            }
        }
    </script>
@endsection

