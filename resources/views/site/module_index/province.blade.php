<section class="selectJobCity">
    <div class="filjob">
        <div class="container">
            <p class="titlefil font28 pdb25 textCenter">Xem việc làm tại:</p>
            <div class="row">
                @foreach (\App\Entity\SubPost::showSubPost('tinh-thanh-hien-thi-trang-chu', 6) as $province)
                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-4 pd0-5">
                    <div class="tgdd pd5">
                        <a href="{{ $province['link-tinh-thanh'] }}" title="{{ $province->title }}">
                            <img class="hoverBgrTimn" src="{{ asset($province->image) }}" alt="{{ $province->title }}" width="100%">
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>