<div class="list_redeem row justify-content-md-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="rs_video">
                    <h3>Video hướng dẫn cách chia sẻ bài viết, tài liệu, khóa học.</h3>
                    {!! isset($information['video-huong-dan-chia-se-bai-viet']) ?  $information['video-huong-dan-chia-se-bai-viet'] : '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/qw3B7CUI5PQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' !!}

                </div>
            </div>
        </div>
    </div>
</div>

<div class="list_redeem row justify-content-md-center">
    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('post_sale_employee') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'post_sale_employee') active @endif">
                Thống kê từ chia sẻ bài viết
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('list_post') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'list_post') active @endif">
                Danh sách bài viết chia sẻ
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('job_sale_employee') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'job_sale_employee') active @endif">
                Thống kê từ chia sẻ tin tuyển dụng
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('list_job') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'list_job') active @endif">
                Danh sách tin tuyển dụng chia sẻ
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('course_sale_employee') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'course_sale_employee') active @endif">
                Thống kê từ chia sẻ khóa học
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('list_course') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'list_course') active @endif">
                Danh sách khóa học chia sẻ
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('voucher_sale_employee') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'voucher_sale_employee') active @endif">
                Thống kê từ chia sẻ tài liệu
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('list_voucher') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'list_voucher') active @endif">
                Danh sách tài liệu chia sẻ
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('list_course_order') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'list_course_order') active @endif">
                Đơn hàng khóa học đã giới thiệu
            </a>
        </div>
    </div>


    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('redeem_rewards') }}"
               class="p15 dsInline  @if (\Route::current()->getName() == 'redeem_rewards' or \Route::current()->getName() == 'change_card' or \Route::current()->getName() == 'change_account' or \Route::current()->getName() == 'change_software') active @endif">
                Danh sách đổi thưởng
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('transaction_history') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'transaction_history') active @endif">
                Lịch sử giao dịch
            </a>
        </div>
    </div>


    {{--<div class="col-md-3">--}}
        {{--<div class="item_redeem">--}}
            {{--<a href="{{ route('list_intro_employer') }}"--}}
               {{--class="p15 dsInline @if (\Route::current()->getName() == 'list_intro_employer') active @endif">--}}
                {{--Danh sách nhà tuyển dụng đã giới thiệu--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--</div>--}}

</div>