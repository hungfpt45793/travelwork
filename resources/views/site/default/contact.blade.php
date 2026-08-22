@extends('site.layout.site')

@section('title','Liên hệ')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
    @if (\Illuminate\Support\Facades\Auth::check())
    <section class="Contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="f24 clhome fw6 mgt20 mgb20">Hòm thư góp ý</h1>
                    <form id="frm_contact" method="post" action="{{ route('sub_contact') }}" onSubmit="return contact(this);">
                        {!! csrf_field() !!}
                        <input type="hidden" name="is_json" class="form-control captcha" value="1" placeholder="">
                        <div style="display: none;">
                            <div class="form-group">
                                <label>Họ tên <span class="required">*</span></label>
                                <input type="text" class="form-control" id="" name="name" >
                            </div>
                            <div class="form-group">
                                <label>Điện thoại <span class="required">*</span></label>
                                <input type="text" class="form-control" id="" name="phone" >
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" id="" name="email" >
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" id="" name="email" >
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" class="form-control" id="" name="email-gop-y" value="{{ !empty($information['email-gop-y']) ? $information['email-gop-y'] : 'longmt2207@gmail.com' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nội dung góp ý</label>
                            <textarea cols="7" name="message" class="editor" id="contact" style="">

                         </textarea>

                        </div>
                        <div class="form-group">
                            <button class="btn btn-custom" id="btnModel" style="    padding: 9px 22px;
    background: #eaa722;
    border-radius: 3px;
    border: none;
    color: #fff;
    font-size: 16px;
    font-weight: 600;">Gửi góp ý </button>
                        </div>
                    </form>

                    <script type="text/javascript">
                        function contact(e) {
                            var $btn = $(e).find('button').text('Đang tải ...');
                            var data = $(e).serialize();

                            $.ajax({
                                type: "POST",
                                url: '{!! route('sub_contact') !!}',
                                data: data,
                                success: function(result) {
                                    var obj = jQuery.parseJSON(result);
                                    // gửi thành công
                                    if (obj.status == 200) {
                                        alert(obj.message);
                                        $btn.text('Đăng ký ngay');

                                        return;
                                    }

                                    // gửi thất bại
                                    if (obj.status == 500) {
                                        alert(obj.message);
                                        $btn.text('Đăng ký ngay');

                                        return;
                                    }
                                },
                                error: function(error) {
                                    //alert('Lỗi gì đó đã xảy ra!')
                                }
                            });
                            return false;
                        }
                    </script>
                </div>
            </div>
        </div>

    </section>
    @else
        <p>Vui lòng đăng nhập để gửi góp ý</p>
    @endif

@endsection
