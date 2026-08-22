@extends('admin.layout.admin')

@section('title', 'Phát triển fanapge và trang cá nhân')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Phát triển fanapge và trang cá nhân
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Phát triển fanapge và trang cá nhân</a></li>
        </ol>
    </section>

    <section class="content">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#post" aria-controls="post" role="tab" data-toggle="tab">Bài viết tốt nhất về chủ đề của bạn</a>
                </li>
                <li role="presentation" >
                    <a href="#setting" aria-controls="facebook" role="tab" data-toggle="tab">Cấu hình</a>
                </li>
                <li role="presentation" >
                    <a href="#settingGroups" aria-controls="facebook" role="tab" data-toggle="tab">Nhóm facebook</a>
                </li>
                <li role="presentation" >
                    <a href="#settingId" aria-controls="facebook" role="tab" data-toggle="tab">Fanpage hoặc trang cá nhân</a>
                </li>
            </ul>

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="post">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Bài viết đang được ưu chuộng</h3>
                            </div>

                            @if (empty($feeds))
                                <p>HIện tại chúng tôi đang không tìm thấy bất kỳ bài viết nào.</p>

                            @else
                                <div class="row">
                                    <div class="col-xs-12 col-md-5">
                                        @foreach($feeds as $feed)
                                            <div class="box box-primary">
                                                <div class="box-body">
                                                    <h4><img src="http://graph.facebook.com/{!! $feed['page']->id !!}/picture?type=square" width="70"> {{ $feed['page']->name }}</h4>
                                                    <p>{{ $feed['message'] }}</p>
                                                    <p><img src="{!! $feed['picture'] !!}" style="width: 100%"/></p>
                                                    <p style="background: #e5e5e5;color: #365899;"><i class="fa fa-thumbs-up" aria-hidden="true"></i> {{ $feed['likes'] }}<br>
                                                        Có tất cả {{ $feed['comments'] }} bình luận
                                                    </p>
                                                    <p>Link: <a href="https://facebook.com/{{ $feed['id'] }}" target="_blank">https://facebook.com/{{ $feed['id'] }}</a></p>
                                                    <br>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <h4><i>Hướng dẫn sử dụng:</i></h4>
                            <p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <i>Phần cấu hình: bổ sung mã truy cập, điền số lượng like tối thiểu, comment tối thiểu.</i></p>
                            <p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <i>Phần nhóm facebook: bổ sung thêm những group mà bạn đã tham gia.</i></p>
                            <p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <i>Fanpage hoặc trang cá nhân: Điền thêm id, hoặc trang cá nhân của người dùng.</i></p>

                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="setting">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cấu hình sử dụng</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <form action="{{ route('update_setting_face') }}" method="post">
                                        {!! csrf_field() !!}
                                        <div class="form-group col-xs-12 ">
                                            <label>Mã truy cập</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="access_token" placeholder="mã truy cập"
                                                       value="{{ isset($facebook->accesstoken) ? $facebook->accesstoken : '' }}" required>
                                                <span class="input-group-addon" id="basic-addon1" data-toggle="collapse" data-target="#helpSetting" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fa fa-question-circle" aria-hidden="true"></i> Hướng dẫn lấy mã truy cập
                                            </span>
                                            </div>

                                        </div>
                                        <div class="collapse" id="helpSetting">
                                            <div class="well">
                                                <p>Bước 1: Truy cập vào facebook cá nhân theo đường dẫn <a href="https://facebook.com">facebok.com</a>, sau đó đăng nhập.</p>
                                                <p>Bước 2: Bạn phải chắc chắn rằng bạn đã đăng nhập thành công.</p>
                                                <p>Bước 3: Vẫn ở cửa sổ facebook, ấn f12 => hiện ra cửa sổ lệnh bên dưới như hình.</p>
                                                <img src="{{ asset('assets/facebook/show_window.jpg') }}" style="width: 70% !important;"/><br>
                                                <p>Bước 4: Tại cửa sổ dòng lệnh chọn sang tab console.</p><br>
                                                <img src="{{ asset('assets/facebook/console.jpg') }}" style="width: 70% !important;"/><br>
                                                <p>Bước 5: Sao chép đoạn mã sau và coppy vào: <br>
                                                    javascript:(function(a){if(null===location.hostname.match(".facebook.com"))return alert("Ch\u1ec9 s\u1eed d\u1ee5ng tr\u00ean Facebook");var b=a.getElementsByName("fb_dtsg")?a.getElementsByName("fb_dtsg")[0].value:"";a=a.cookie.match(/c_user=(\d+)/)?a.cookie.match(/c_user=(\d+)/)[1]:"";fetch("/dialog/oauth/confirm",{body:"fb_dtsg="+b+"&app_id=165907476854626&redirect_uri="+encodeURIComponent("fbconnect://success")+"&display=popup&access_token=&sdk=&from_post=1&private=&login=&read=&write=&readwrite=&extended=&social_confirm=&confirm=&seen_scopes=&auth_type=&auth_token=&auth_nonce=&default_audience=&ref=Default&return_format=access_token&domain=&sso_device=ios&__CONFIRM__=1&__user="+
                                                    a+"&__a=1",method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},credentials:"include"}).then(function(a){return a.text()}).then(function(a){(a=a.match(/access_token=(.*?)&expires_in/i))&&a[1]?prompt("Access Token",a[1]):alert("X\u1ea3y ra l\u1ed7i khi l\u1ea5y token")})})(document);
                                                </p>
                                                <p>
                                                    Bước 6: ấn Enter, lúc này sẽ có cửa sổ hiện lên mã truy cập, coppy và page vào ô mã truy cập là được.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-12">
                                            <label>Số Like tối thiểu</label>
                                            <input type="number" class="form-control" name="like_minimum" placeholder="Số Like tối thiểu"
                                                   value="{{ isset($facebook->like_minimum) ? $facebook->like_minimum : '' }}" />
                                        </div>
                                        <div class="form-group col-xs-12">
                                            <label>Số comment(bình luận) tối thiểu</label>
                                            <input type="number" class="form-control" name="comment_minimum" placeholder="Số comment tối thiểu"
                                                   value="{{ isset($facebook->comment_minimum) ? $facebook->comment_minimum : '' }}" />
                                        </div>
                                        <div class="form-group col-xs-12">
                                            <button type="submit" class="btn btn-primary">Lưu cấu hình</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="settingGroups">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nhóm facebook</h3>
                        </div>
                        <div class="box-body">
                            <label>Chọn những group bạn đã tham gia: </label>
                            <form action="{{ route('update_groups') }}" method="post">
                                {!! csrf_field() !!}
                                <div class="formGroupsFacebook" >
                                    @foreach ($groups as $group)
                                        @if (isset($group->id))
                                            <div class="form-group col-xs-12">
                                                <label style="cursor: pointer;">
                                                    <input type="checkbox"  name="groups[]" value="{{ $group->id }}" class="flat-red"
                                                            {{ isset($facebook->groups) && in_array($group->id, explode(',', $facebook->groups)) ? 'checked' : '' }} />
                                                    {!! $group->name !!}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="form-group col-xs-12">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="settingId">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Fanpage và trang cá nhân</h3>
                            <p><i>Lấy thông tin từ trang cá nhân và fanpage bạn quan tâm</i></p>
                        </div>
                        <div class="box-body">
                            <form action="{{ route('update_facebook_id') }}" method="post">
                                {!! csrf_field() !!}
                                <div class="form-group col-xs-12 ">
                                    <label>Nhập vào ID facebook</label>

                                    <div class="input-group">
                                        <input type="number" class="form-control" name="face_id" placeholder="faceId" required>
                                        <span class="input-group-addon" id="basic-addon1" data-toggle="collapse" data-target="#helpGetId" aria-expanded="false" aria-controls="helpGetId">
                                        <i class="fa fa-question-circle" aria-hidden="true"></i> Hướng dẫn lấy id
                                    </span>
                                    </div>
                                    <div class="collapse" id="helpGetId">
                                        <div class="well">
                                            ...
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <button type="submit" class="btn btn-primary">Thêm ID</button>
                                </div>
                            </form>

                            <label>Danh sách id đã chọn: </label>
                            <div class="formGroupsFacebook" >

                                @foreach ($faceInforByIds as $faceInforById)
                                    <div class="form-group col-xs-12">
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i> <img src="http://graph.facebook.com/{!! $faceInforById['id'] !!}/picture?type=square" width="70"> {!! $faceInforById['name'] !!}
                                        <a href="{{ route('delete_facebook_id', ['face_id' => $faceInforById['id'] ]) }}" class="btn btn-danger">xóa</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

