@extends('admin.layout.admin')

@section('title', 'Lấy số điện thoại, và email từ uid')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lấy số điện thoại, và email từ uid
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Lấy số điện thoại, và email từ uid</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box-header with-border">
                    <h3 class="box-title">Lấy số điện thoại, và email từ uid</h3>

                </div>
                @if ($countMember > 0)
                    <a href="{{ route('download-member') }}" class="btn btn-warning">Download tập member vừa lấy</a>
                    <p><i>Lưu ý: Chỉ có thể tải về tối đa là 10000 uid, nếu nhiều hơn thì sau mỗi lần tải bạn phải f5 (load lại trang) và tiếp tục tải</i></p>
                @endif
                <form action="{!! route('get_uid_from_excel') !!}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="box-content">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nhập lên danh sách uid</label>
                            <input type="file" name="file" required><br>
                            <input type="hidden" name="route" value="0" />
                            <button type="submit" class="btn btn-primary">Lưu danh sách uid</button>
                        </div>
                    </div>
                </form>
                <div class="box-footer">
                    <button class="btn btn-primary " onclick="return convertUid(this);" data-loading-text="Cập nhật...">Lấy email và số điện thoại</button>
                    <div class="progress uidGroup col-xs-6" style="display: none">
                        <div class="progress-bar uidGroup-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
                            0%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function convertUid(e) {
            var btn = $(e).button('loading');
            $('.uidGroup').show();
            var start = 0;
            var limit = 100;
            update();
            function update() {
                $.ajax({
                    type: "get",
                    url: '{!! route('convert_uid') !!}',
                    data: {
                        start: start,
                        limit: limit
                    },
                    success: function(result){
                        var obj = jQuery.parseJSON( result);
                        $('.uidGroup-bar').attr('style', 'width: '+ obj.percent +'%;');
                        $('.uidGroup-bar').empty();
                        $('.puidGroup-bar').append(obj.percent+'%');
                        start += limit;

                        if (obj.success == 1) {
                            $('.uidGroup-bar').attr('style', 'width: 100%;');
                            $('.uidGroup-bar').empty();
                            $('.uidGroup-bar').append('100%');

                            alert('Bạn đã cập nhật thành công');
                            btn.button('reset')
                            $('.uidGroup').hide();
                            // location.reload();
                        } else {
                            update();
                        }
                    }
                });
            }
        }
    </script>
@endsection

