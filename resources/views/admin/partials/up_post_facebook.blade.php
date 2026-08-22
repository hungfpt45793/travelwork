@if (empty(\Illuminate\Support\Facades\Auth::user()->accesstoken))
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="box box-primary">
                <div class="box-body">
                    Bạn chưa đăng nhập facebook, vui lòng truy cập vào 'Thông tin mở rộng' -> 'Cài đặt chung' -> 'Cấu hình facebook'.
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Lấy thông tin đã post facebook -->
    <?php $postFacebook = \App\Entity\PostFacebook::getDetail($postId); ?>
    <form action="{!! route('upload_fanpage') !!}" method="post">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nội dung đẩy lên facebook</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nội dung của bài viết</label>
                            <textarea class="form-control" id="contentFacebook"
                                      name="content" cols="20" rows="30" style="width: 100%;"
                                      placeholder="Nội dung" required>{!! isset($postFacebook->content) ? $postFacebook->content : '' !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Đường dẫn trên bài viết</label>
                            <input type="text" class="form-control" name="link"
                                   placeholder="Đường dẫn bài viết" value="{!! isset($postFacebook->link) ? $postFacebook->link : ''  !!}" required/>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên của album</label>
                            <input type="text" class="form-control" name="name_album"
                                   placeholder="Tên của album" value="{!! isset($postFacebook->name_album) ? $postFacebook->name_album : '' !!}" required/>
                        </div>
                        <div class="form-group">
                            <label>Danh sách hình ảnh</label>
                            <input type="button" onclick="return openKCFinder(this);" value="Chọn ảnh"
                                   size="20"/>
                            <div class="imageList">
                                @if (isset($postFacebook->images))
                                    @foreach (explode(',', $postFacebook->images) as $image)
                                        <img src="{!! asset($image) !!}" width="100"/>
                                    @endforeach
                                @endif
                            </div>
                            <input name="images" type="hidden" value="{!! isset($postFacebook->images) ? $postFacebook->images : '' !!}"/>
                        </div>
                    </div>
                </div>
            </div>
            <?php $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

            <input type="hidden" value="{!! $postId !!}" name="post_id"/>
            <input type="hidden" value="{!! $actual_link !!}" name="current_url"/>
            <div class="col-xs-12 col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Hướng dẫn insert icon vào form nội dung</h3>
                    </div>
                    <div class="box-body">
                        <img src="{{ asset('adminstration/emojionearea/click.jpg') }}" style="width: 100%;" /> <br>
                        <img src="{{ asset('adminstration/emojionearea/show_icon.jpg') }}" style="width: 100%;" />

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lựa chọn đối tượng up lên</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="post_me" value="1" {!! isset($postFacebook->post_me) && ($postFacebook->post_me == 1) ? 'checked' : '' !!} class="flat-red"> Dòng thời gian của bạn
                            </label>
                        </div>
                        <?php $fanpages = \App\Facebook\Fanpage::getAllPage(); ?>
                        @if (empty($fanpages))
                            Hiện tại khoản của bạn không có fanpage
                        @else
                            @foreach ($fanpages as $fanpage)
                                @if (!empty($fanpage['name']))
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="fanpages[]" value="{!! $fanpage['id'] !!}" {!! isset($postFacebook->fanpages) && in_array($fanpage['id'], explode(',', $postFacebook->fanpages)) ? 'checked' : '' !!} class="flat-red">
                                            <img src="http://graph.facebook.com/{!! $fanpage['id'] !!}/picture?type=square" width="70"> {!! $fanpage['name'] !!}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <button type="submit" class="btn btn-primary">Đăng lên facebook</button>
            </div>
        </div>
    </form>
@endif