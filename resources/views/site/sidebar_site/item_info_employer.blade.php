<div class="tab-content mgb20" id="nav-tabContent">
    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="account dnavnone mgb5 mbdsNone">
            <div class="employee dnavnone">
                @if(!\Illuminate\Support\Facades\Auth::check())
                    <form action="{{ route('login_home') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email đăng ký <span
                                            class="clRed">(*)</span></label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Nhập vào email của bạn">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mật khẩu <span class="clRed">(*)</span></label>
                                <input type="password" name="password" class="form-control"
                                       id="exampleInputPassword1" placeholder="Nhập mật khẩu của bạn">
                            </div>
                            @if($errors->any() && $errors->has('loginFail') )
                                <div class="alert alert-danger" role="alert">
                                    <strong>Mật khẩu hoặc Email đăng nhập không đúng.</strong>
                                </div>
                            @endif
                            @if (\Request::is('/'))
                                <input type="hidden" name="home" class="form-control" id="exampleInputPassword1"
                                       placeholder="" value="home">
                            @endif
                            @if(session('error_login'))
                                <div class="form-group mgb0" style="margin-bottom: 10px">
                                    <p class="red mgb0" style="margin-bottom: 10px">{{ session('error_login') }}</p>
                                </div>
                            @endif
                            @if($errors->any() && $errors->has('loginFail') )
                                <div class="alert alert-danger" role="alert">
                                    <strong>Mật khẩu hoặc Email đăng nhập không đúng.</strong>
                                </div>
                            @endif
                            <div class="form-group mgb0">
                                <label class="mgb0" for="exampleInputPassword1"> <a
                                            href="{{ route('reset_passwrod') }}">Quên
                                        mật
                                        khẩu</a></label>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Chưa có tài khoản?
                                    <a href="{{route('register')}}"> Đăng ký tài khoản</a>
                                </label>
                            </div>
                            <button type="submit" class="btn bgHome clWhite">ĐĂNG NHẬP</button>
                        </div>

                    </form>
                @endif
            </div>
        </div>

        <div class="item">

            <ul class="list_item_sidebar">
                <?php  $public_link_employer = \App\Entity\Category::getDetailCategory('nha-tuyen-dung-ke-toan');
                ?>

                <li>
                    <a href="{{ route('support', ['cate_slug' => $public_link_employer->slug, 'post_slug' => 'huong-dan-su-dung-chuc-nang-thong-bao-cho-nha-tuyen-dung' ]) }}" class="list_item_title_noti">
                        <i class="far fa-bell"></i>
                        <span class="dnavnone">Thông báo</span>
                    </a>
                </li>
                <li>
                    <a>
                        <i class="far fa-list-alt"></i><span>Danh sách tin tuyển dụng</span>
                    </a>
                    <ul class="sub_list_item">
                        <li>
                            <a href="{{ route('support', ['cate_slug' => $public_link_employer->slug, 'post_slug' => 'huong-dan-su-dung-chuc-nang-thong-tin-nha-tuyen-dung' ]) }}"
                               class="">
                                <i class="fas fa-info"></i>
                                <span class="dnavnone">Thông tin tuyển dụng</span>
                            </a>

                        </li>
                        <li>
                            <a href="{{ route('support', ['cate_slug' => $public_link_employer->slug, 'post_slug' => 'huong-dan-su-dung-chuc-nang-ho-so-tuyen-dung' ]) }}"
                            >
                                <i class="far fa-file"></i>
                                <span class="dnavnone">Hồ sơ tuyển dụng</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a  class="list_item_sidebar_title">
                        <i class="fas fa-user-graduate"></i><span>Cổng thực tập</span>
                    </a>

                    <ul class="">
                        <li>

                            <a href="{{ route('support', ['cate_slug' => $public_link_employer->slug, 'post_slug' => 'huong-dan-su-dung-chuc-nang-thong-tin-tuyen-thuc-tap' ]) }}"
                            >
                                <i class="fas fa-info"></i>
                                <span class="dnavnone">Thông tin tuyển thực tập</span>
                            </a>


                        </li>
                        <li>
                            <a href="{{ route('support', ['cate_slug' => $public_link_employer->slug, 'post_slug' => 'huong-dan-su-dung-chuc-nang-ho-so-thuc-tap' ]) }}"
                            >
                                <i class="far fa-file"></i>
                                <span class="dnavnone">Hồ sơ thực tập</span>
                            </a>

                        </li>
                    </ul>
                </li>
                <li class="">
                    <a  class="list_item_sidebar_title">
                        <i class="fas fa-stream"></i><span>Trắc nghiệm du lịch</span>
                    </a>

                    <ul class="">
                        <li>

                            <a href="{{ route('support', ['cate_slug' => $public_link_employer->slug, 'post_slug' => 'huong-dan-su-dung-chuc-nang-de-thi-cua-ban' ]) }}"
                            >
                                <i class="far fa-question-circle"></i>
                                <span class="dnavnone">Đề thi của bạn</span>
                            </a>

                        </li>
                        <li>

                            <a href="{{ route('support', ['cate_slug' => $public_link_employer->slug, 'post_slug' => 'huong-dan-su-dung-chuc-nang-ngan-hang-de-thi' ]) }}"
                            >
                                <i class="fas fa-university"></i>
                                <span class="dnavnone">Ngân hàng đề thi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('support', ['cate_slug' => $public_link_employer->slug, 'post_slug' => 'huong-dan-su-dung-chuc-nang-danh-sach-phong-thi' ]) }}"
                            >
                                <i class="fab fa-chromecast"></i>
                                <span class="dnavnone">Danh sách phòng thi</span>
                            </a>

                        </li>
                        <li>

                            <a href="#">
                                <i class="fas fa-crown"></i>
                                <span class="dnavnone">Kết quả phòng thi</span>
                            </a>

                        </li>
                    </ul>
                </li>
                <li class="">
                    <a class="list_item_sidebar_title"  >
                        <i class="fas fa-users"></i><span>Thông tin tài khoản</span>
                    </a>
                    <ul class="">
                        <li>
                            <a href="#" >
                                <i class="fas fa-info"></i><span>Thông tin</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" >
                                <i class="fas fa-id-card "></i><span>Quản lý hồ sơ</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" >
                                <i class="fas fa-user-circle "></i><span>Đổi mật khẩu</span>
                            </a>
                        </li>

                        <li>
                            <a href="#" >
                                <i class="fas fa-sign-out-alt"></i><span>Thoát tài khoản</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
