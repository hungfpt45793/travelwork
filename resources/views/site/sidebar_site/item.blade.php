@if(!empty($sidebar_employer) && $sidebar_employer == 'employer')
    {{--đổ danh mục tin tức trong admin--}}
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
                <i class="fas fa-stream"></i><span>Trắc nghiệm về du lịch</span>
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

                    <a href="#"
                    >
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
@else
    <?php  $public_link_employee = \App\Entity\Category::getDetailCategory('ke-toan-di-tim-viec'); ?>
    @if(!empty($public_link_employee))
    <ul class="list_item_sidebar">


            <li>
                <a href="{{ route('support', ['cate_slug' => $public_link_employee->slug, 'post_slug' => 'ung-dung-thong-bao-cho-ung-vien']) }}"  data-toggle="tooltip" data-placement="right" title="Thông báo" class="list_item_title_noti">
                    <i class="far fa-bell"></i><span>Thông báo</span></a>
            </li>

            <li>
                <a class="list_item_sidebar_title" data-toggle="tooltip" data-placement="right" title="Thông tin việc làm ">
                    <i class="far fa-file-alt"></i><span>Thông tin việc làm </span>
                </a>

                <ul class="sub_list_item">
                    <li>
                        <a href="{{ route('support', ['cate_slug' => $public_link_employee->slug, 'post_slug' => 'huong-dan-thao-tac-trong-chuc-nang-viec-lam-da-nop-ho-so']) }}"  data-toggle="tooltip" data-placement="right" title="Việc làm đã nộp hồ sơ ">
                            <i class="far fa-share-square"></i><span>Việc làm đã nộp hồ sơ </span>

                        </a>
                    </li>

                    <li>
                        <a href="{{ route('support', ['cate_slug' => $public_link_employee->slug, 'post_slug' => 'huong-dan-thao-tac-trong-chuc-nang-viec-lam-da-luu']) }}"  data-toggle="tooltip" data-placement="right" title="Việc làm đã lưu">
                            <i class="fas fa-download"></i><span>Việc làm đã lưu  </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('support', ['cate_slug' => $public_link_employee->slug, 'post_slug' => 'huong-dan-thao-tac-trong-chuc-nang-viec-lam-theo-doi-nha-tuyen-dung']) }}"  data-toggle="tooltip" data-placement="right" title="Việc làm theo dõi từ nhà tuyển dụng">
                            <i class="fab fa-stack-overflow"></i><span>Việc làm theo dõi từ nhà tuyển dụng</span>

                        </a>
                    </li>

                    <li>
                        <a href="{{ route('support', ['cate_slug' => $public_link_employee->slug, 'post_slug' => 'huong-dan-thao-tac-trong-chuc-nang-viec-lam-theo-doi-nha-tuyen-dung']) }}"  data-toggle="tooltip" data-placement="right" title="Việc làm mong muốn">
                            <i class="far fa-heart"></i><span>Việc làm mong muốn</span>

                        </a>
                    </li>

                </ul>
            </li>
            <li class="">
                <a class="list_item_sidebar_title" data-toggle="tooltip" data-placement="right" title="Khóa học">
                    <i class="fas fa-chalkboard-teacher"></i><span>Khóa học </span>
                </a>

                <ul class="">
                    <li>
                        <a href="{{ route('support', ['cate_slug' => $public_link_employee->slug, 'post_slug' => 'huong-dan-thao-tac-trong-chuc-nang-dang-ky-khoa-hoc']) }}"  data-toggle="tooltip" data-placement="right" title="Khoá học đã đăng ký">
                            <i class="fas fa-chalkboard-teacher"></i><span>Khoá học đã đăng ký</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="">
                <a class="list_item_sidebar_title"  data-toggle="tooltip" data-placement="right" title="Kiếm tiền từ chia sẻ bài">
                    <i class="fas fa-donate"></i><span>Kiếm tiền từ chia sẻ bài</span>
                </a>
                <ul class="">

                    <li>
                        <a href="{{ route('support', ['cate_slug' => $public_link_employee->slug, 'post_slug' => 'huong-dan-thao-tac-trong-chuc-nang-kiem-tien-tu-chia-se-bai-viet']) }}"  data-toggle="tooltip" data-placement="right" title="Kiếm tiền từ chia sẻ bài">
                            <i class="fas fa-donate"></i><span>Kiếm tiền từ chia sẻ bài</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('redeem_rewards')}}"  data-toggle="tooltip" data-placement="right" title="Danh sách đổi thưởng">
                            <i class="fas fa-bars"></i><span>Danh sách đổi thưởng</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('transaction_history')}}"  data-toggle="tooltip" data-placement="right" title="Lịch sử giao dịch">
                            <i class="fas fa-history"></i><span>Lịch sử giao dịch</span></a>
                    </li>
                    <li>
                        <a href="{{route('list_post')}}"  data-toggle="tooltip" data-placement="right" title="Danh sách bài viết kiếm tiền">
                            <i class="fas fa-bars"></i><span>Danh sách bài viết kiếm tiền</span></a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a class="list_item_sidebar_title"   data-toggle="tooltip" data-placement="right" title="Thông tin tài khoản">
                    <i class="fas fa-users"></i><span>Thông tin tài khoản</span>
                </a>
                <ul class="">
                    <li>
                        <a href="#"  data-toggle="tooltip" data-placement="right" title="Thông tin">
                            <i class="fas fa-info"></i><span>Thông tin</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('support', ['cate_slug' => $public_link_employee->slug, 'post_slug' => 'huong-dan-thao-tac-trong-chuc-nang-quan-ly-ho-so']) }}"  data-toggle="tooltip" data-placement="right" title="Quản lý hồ sơ">
                            <i class="fas fa-id-card "></i><span>Quản lý hồ sơ</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"  data-toggle="tooltip" data-placement="right" title="Đổi mật khẩu">
                            <i class="fas fa-user-circle "></i><span>Đổi mật khẩu</span>
                        </a>
                    </li>

                    <li>
                        <a href="#"  data-toggle="tooltip" data-placement="right" title="Thoát tài khoản">
                            <i class="fas fa-sign-out-alt"></i><span>Thoát tài khoản</span></a>
                    </li>
                </ul>
            </li>


    </ul>
        @endif
@endif




