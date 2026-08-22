<div class="Statistical mgt70">
    <div class="row">
        @foreach (\App\Entity\SubPost::showSubPost('so-lieu-ung-vien') as $analysis)
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 textCenter mgt20">
                <h2 class="fontBold font32 Tim mgb15">{{ $analysis->title }}</h2>
                <p>{{ $analysis->description }}</p>
            </div>
        @endforeach
    </div>
    <div class="buttonCalls mgt70 textCenter">
        <p>Vậy còn lý do gì để không khởi đầu công việc ước mơ cùng TIVA</p>
        <a href="" class="btn btnCalls">ĐĂNG KÝ NGAY</a>
    </div>
</div>