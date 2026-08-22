<div class="CustomerReviews">
    <div class="title textCenter">
        <h5 class="titleTiva pdb25 lineHeight25">NHÀ TUYỂN DỤNG NÓI VỀ TIVA</h5>
    </div>
    <div class="customerss owl-carousel owl-theme">
        @foreach (\App\Entity\SubPost::showSubPost('nha-tuyen-dung-noi-tiva', 10) as $employer)
            <div class="item bgrWhite borderRadius5 borderLight pd10">
                <div class="top row">
                    <div class="col-xl-3 col-lg-4 col-md-12 col-sm-3">
                        <img src="{{ asset($employer->image) }}" alt="{{ $employer->title }}" width="100%">
                    </div>
                    <div class="col-xl-9 col-lg-8 col-md-12 col-sm-9 marginAuto namexCustomerss">
                        <h5 class="fontBold Tim mg0">{{ $employer->title }}</h5>
                        <p>{{ $employer['chuc-vu'] }}</p>
                    </div>
                </div>
                <div class="bot pdt10">
                    <p>{{ $employer['noi-dung'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>