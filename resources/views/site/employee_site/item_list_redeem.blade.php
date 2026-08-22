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
            <a href="{{ route('job_sale_employee') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'job_sale_employee') active @endif">
                Thống kê từ chia sẻ tin tuyển dụng
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
            <a href="{{ route('list_job') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'list_job') active @endif">
                Danh sách tin tuyển dụng chia sẻ
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="item_redeem">
            <a href="{{ route('list_intro_employer') }}"
               class="p15 dsInline @if (\Route::current()->getName() == 'list_intro_employer') active @endif">
                Danh sách nhà tuyển dụng đã giới thiệu
            </a>
        </div>
    </div>
</div>