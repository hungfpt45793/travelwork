@if (\Illuminate\Support\Facades\Auth::check())
    <?php $user = \Illuminate\Support\Facades\Auth::user(); ?>
    <div class="userAvatarSlide boxH5">
        <div class="userInfo">
            <img class="lazy" src="{{ (!empty($user->image)) ? asset($user->image) : asset('assets/images/icon_person.png') }}" alt="{{ $user->name }}" width="150"/>
            <h3>{{ $user->name }}</h3>
            <p>Thành viên</p>
            <?php $date=date_create($user->created_at); ?>
            <p>Ngày tham gia: {!! date_format($date,"d/m/Y") !!}</p>
        </div>
        <div class="inforOrder">
            <p>Tổng số đơn hàng: <span class="red">{!! \App\Entity\Order::getTotalOrder($user->id) !!}</span></p>
        </div>
    </div>
    <ul class="userSiderBar">
        <li class="@if($active == 'orderPerson') active @endif">
            <a href="/don-hang-ca-nhan">Đơn đặt hàng</a>
        </li>
        <li class="@if($active == 'inforUser') active @endif">
            <a href="/thong-tin-ca-nhan" >Thông tin cá nhân</a>
        </li>
        <li class="@if($active == 'resetPassword') active @endif">
            <a href="/doi-mat-khau">Đổi mật khẩu</a>
        </li>
    </ul>
@endif
<style type="text/css">
    .userSiderBar li
    {
        margin-right: 0;
        text-align: center;
    }
    .userAvatarSlide .inforOrder {
        text-align: center;
    }
</style>
