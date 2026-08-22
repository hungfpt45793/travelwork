<section class="contentIndex mgb40">
    <div class="title">
        <h1 class="text-center fw7 f32 xl-f28 lg-f23 sm-pdt25 red pdt40 mgb40 mbf18 tile_home_index">QUY TRÌNH TUYỂN DỤNG SÀN KẾ TOÁN</h1>

    </div>
    <div class="recruitmentProcess recruitmentProcess_Ipad pdl40 pdr40">
        <div class="row relative">
            @foreach(\App\Entity\SubPost::showSubPost('thuc-tap', 2) as $id => $post_intership)

                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 pdr60 md-pdr15 md-mgb30 recruitmentProcessItem">
                    <a href="@if(!empty($post_intership['link-mo-ta-quy-trinh-tuyen-chon-ke-toan']))  {{ $post_intership['link-mo-ta-quy-trinh-tuyen-chon-ke-toan'] }} @else {{ route('intership') }} @endif">
                        <div class="educate boxShadowBlue radius10 pd30 pdb5 maxheight_recrui clblack">

                            <h4 class="text-center mgb20 textUpper fw7 blueDN mbf18">{{ !empty($post_intership->title) ? $post_intership->title : 'Đang cập nhật'}}</h4>
                            <div class="maxHieght_content_recrui">
                                <p class="check">
                                    {!! !empty($post_intership->content) ? $post_intership->content : 'Đang cập nhật' !!}
                                </p>
                            </div>
                            <p class="text-center bgrBlueN pd10">
                                <span class="white hvWhite fw7 f18 clwhite ">{{ !empty($post_intership->description) ? $post_intership->description : 'Đang cập nhật'}}</span>
                            </p>

                        </div>
                    </a>
                </div>

            @endforeach
            @foreach(\App\Entity\SubPost::showSubPost('viec-lam', 2) as $id => $jobs_ketoan)
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 pdl60 md-pdl15 md-mgb30 recruitmentProcessItem">
                    <a href="@if(!empty($jobs_ketoan['link-mo-ta-quy-trinh-tuyen-chon-ke-toan']))  {{ $jobs_ketoan['link-mo-ta-quy-trinh-tuyen-chon-ke-toan'] }} @else {{ route('list_job_face')}} @endif"
                       class="">
                        <div class="employerJobs boxShadowBlue radius10 pd30 pdb5 maxheight_recrui clblack">

                            <h4 class="text-center mgb20 textUpper fw7 blueDN mbf18">{{ !empty($jobs_ketoan->title) ? $jobs_ketoan->title : 'Đang cập nhật'}}</h4>
                            <div class="maxHieght_content_recrui">
                                <p class="check">
                                    {!! !empty($jobs_ketoan->content) ? $jobs_ketoan->content : 'Đang cập nhật' !!}
                                </p>
                            </div>
                            <p class="text-center bgrBlueN pd10">
                                <span class="white hvWhite fw7 f18">{{ !empty($jobs_ketoan->description) ? $jobs_ketoan->description : 'Đang cập nhật'}}</span>
                            </p>

                        </div>
                    </a>
                </div>
            @endforeach
            {{--<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 pdr60 md-pdr15 md-mgb30">--}}
            {{--<div class="educate boxShadowBlue radius10 pd30 pdb5">--}}

            {{--</div>--}}
            {{--</div>--}}


            <div class="arrowLeft text-center absolute top45 left46 xl-left45 lg-left43 hideOnTable">
                <img class="lazy" data-src="/public/assets/image/right.png" alt="" width="40%">
            </div>
        </div>
        <div class="arrowUpDown h100x relative hideOnTable">
            <div class="arrowLeft inBlock absolute left23 top20 xl-left21 lg-left20">
                <img class="lazy" data-src="/public/assets/image/up.png" alt="" width="40%">
            </div>

            <div class="arrowLeft inBlock absolute right19 top20 xl-right16 lg-right12">
                <img class="lazy" data-src="/public/assets/image/down.png" alt="" width="40%">
            </div>
        </div>
        <div class="row relative">
            @foreach(\App\Entity\SubPost::showSubPost('dao-tao', 2) as $id => $daotao)
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 pdr60 md-pdr15 md-mgb30 recruitmentProcessItem">

                    <a href="{{ route('course_index') }}">
                        <div class="educate boxShadowBlue radius10 pd30 pdb5 maxheight_recrui clblack">


                            <h4 class="text-center mgb20 textUpper fw7 blueDN mbf18">{{$daotao->title}}</h4>
                            <div class="maxHieght_content_recrui">
                                <p class="check">
                                    {!! $daotao->content !!}
                                </p>
                            </div>
                            <p class="text-center bgrBlueN pd10">
                                <span class="white hvWhite fw7 f18">{{$daotao->description}}</span>
                            </p>

                        </div>
                    </a>
                </div>
            @endforeach
            @foreach(\App\Entity\SubPost::showSubPost('trac-nghiem', 2) as $id => $tracnghiem)
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 pdl60 md-pdl15 recruitmentProcessItem">
                    <a href="@if(isset($daotao['link-mo-ta-quy-trinh-tuyen-chon-ke-toan']))  {{ $daotao['link-mo-ta-quy-trinh-tuyen-chon-ke-toan'] }} @else {{ route('getTestAllExam') }} @endif ">
                        <div class="employerJobs boxShadowBlue radius10 pd30 pdb5 maxheight_recrui clblack">

                            <h4 class="text-center mgb20 textUpper fw7 blueDN mbf18">{{$tracnghiem->title}}</h4>
                            <div class="maxHieght_content_recrui">
                                <p class="check">
                                    {!!$tracnghiem->content!!}
                                </p>
                            </div>
                            <p class="text-center bgrBlueN pd10">
                                <span class="white hvWhite fw7 f18">{{$tracnghiem->description}}</span>
                            </p>

                        </div>
                    </a>
                </div>
            @endforeach
            <div class="arrowLeft text-center absolute top45 left46 xl-left45 lg-left42 hideOnTable">
                <img class="lazy" data-src="/public/assets/image/left.png" alt="" width="40%">
            </div>


        </div>
    </div>
</section>
<div class="underLineY h10x bgrGray"></div>
