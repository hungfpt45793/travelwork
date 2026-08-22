@extends('admin.layout.admin')

@section('title', 'Lấy id của facebook')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lấy id của facebook
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Lấy id của facebook</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box-header with-border">
                    <h3 class="box-title">Lấy id của facebook</h3>
                </div>
                    <div class="box-content">
                        @if ($countMember > 0)
                            <a href="{{ route('download-member') }}" class="btn btn-warning">Download tập member vừa lấy</a>
                            <p><i>Lưu ý: Chỉ có thể tải về tối đa là 10000 uid, nếu nhiều hơn thì sau mỗi lần tải bạn phải f5 (load lại trang) và tiếp tục tải</i></p>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputEmail1">Id nhóm, id trang cá nhân, id fanpage</label>
                            <input type="text" id="face_id" class="form-control" name="face_id" placeholder="Id nhóm, id trang cá nhân, id fanpage" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Lựa chọn hình thức lấy id, id fanpage</label>
                            <label class="col-xs-12">
                                <input type="radio" class="select_get_id" name="select_get_id" value="0" checked> thành viên trong nhóm <br>
                            </label>
                            <label class="col-xs-12">
                                <input type="radio" class="select_get_id" name="select_get_id" value="1"> người like và comment bài viết (từ trang cá nhân người dùng) <br>
                            </label>
                            <label class="col-xs-12">
                                <input type="radio" class="select_get_id" name="select_get_id" value="2"> Danh sách bạn bè (từ trang cá nhân người dùng)<br>
                            </label>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <button class="btn btn-primary " onclick="return getUid(this);" data-loading-text="Cập nhật...">Lấy userid</button>
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
        function getUid(e) {
            var btn = $(e).button('loading');
            $('.uidGroup').show();
            var start = null;
            var count = 0;
			var after = null;
            update();
            function update() {
                $.ajax({
                    type: "get",
                    url: '{!! route('get_uid') !!}',
                    data: {
                        face_id: $('#face_id').val(),
                        select_get_id: $('input[name=select_get_id]:checked').val(),
						after: after
                    },
                    success: function(result){
                        var obj = jQuery.parseJSON( result);
                        count++;
                        $('.uidGroup-bar').attr('style', 'width: '+ count +'%;');
                        $('.uidGroup-bar').empty();
                        $('.puidGroup-bar').append(count+'%');
                        console.log(start);


                        if (obj.success == 1) {
                            $('.uidGroup-bar').attr('style', 'width: 100%;');
                            $('.uidGroup-bar').empty();
                            $('.uidGroup-bar').append('100%');

                            alert('Bạn đã cập nhật thành công');
                            btn.button('reset')
                            $('.uidGroup').hide();
                            // location.reload();
                        } else {
                            after = obj.after;
                            update();
                        }
                    }
                });
            }
        }
    </script>
@endsection

