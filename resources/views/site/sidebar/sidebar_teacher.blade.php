<div class="col-xl-3 col-lg-4 anotheTeacher dsmbNone sidebar_show_hidden" id="js_toogle_sidebar">
    <div id="dismiss">
        <i class="fas fa-arrow-left"></i>
    </div>
    @if(\Illuminate\Support\Facades\Auth::check())
        <div class="side-bar-left formJobLarge  sidebarJobFacebook">
            <div class="createNew text-center bgrBlueN" style="    padding: 4px 0;">
                <a href="" data-toggle="modal"
                   data-target="@if (!\Illuminate\Support\Facades\Auth::check()) #loginTiva @endif"
                   class="createNewButton white">
                    <i class="fas disInBlock fa-paper-plane "></i>
                    <p class="disInBlock font20 fontBold ">Thông tin</p>
                </a>
            </div>
            @include('site.sidebar.item_info')


        </div>
    @endif

    <?php
    $adv_noti = \App\Entity\Adv_noti::get_adv_noti();
    ?>
    @if(!empty($adv_noti))
        <a href="{{$adv_noti->adv_link  }}" target="_blank" class="content_modal_noti_adv">
            <div class="commitments mgb20">

                <div class="title bgrBlueN pdt15 pdb15 pdl10 radiusTopLeft5 radiusTopRight5">
                    <h3 class="white fw7 textUpper mgb0 text-center f18 ">{{ !empty($adv_noti->adv_title) ? $adv_noti->adv_title : '' }}</h3>
                </div>
                <div class="listTranning content_modal_noti_adv">
                    {!! !empty($adv_noti->adv_content) ? $adv_noti->adv_content : '' !!}
                </div>

            </div>
        </a>
    @endif

    <div class="commitments mgb20">
        <div class="title bgrBlueN pdt15 pdb15 pdl10 radiusTopLeft5 radiusTopRight5">
            <h3 class="white fw7 textUpper mgb0 text-center f18 ">SÀN KẾ TOÁN CAM KẾT</h3>
        </div>
        <div class="listTranning">
            <ul>
                <?php  $public_link = \App\Entity\Category::getDetailCategory('san-ke-toan-cam-ket');
                ?>
                @foreach(\App\Entity\Post::categoryShowAsc('san-ke-toan-cam-ket',5) as $post)
                    <li>
                        <a href="{{ route('detail_new', ['cate' => $public_link->slug, 'post_teacher' => $post->slug]) }}">
                            <span>{{ isset($post->title) ? $post->title : '' }}</span>
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>

    <div class="anotherTeachers">
        <div class="title bgrBlueN pdt15 pdb15 pdl10 radiusTopLeft5 radiusTopRight5">
            <h3 class="white fw7 textUpper mgb0 text-center f18">Giáo viên mới</h3>
        </div>
        <div class="contentAnotherTeachers bgrWhite pd10">
            <div class="teachers">

                <?php $teacher_new = \App\Entity\Teacher::getAllNew() ?>
                @foreach($teacher_new as $tea_new)
                    <a href="{{ route('detailTeacher',['slug'=>$tea_new->slug]) }}" class="black noDecoration">
                        <div class="row">
                            <div class="col-lg-3 pdr0">
                                <img class="lazy"
                                     src="{{ !empty($tea_new->teacher_images) ? $tea_new->teacher_images : asset('assets/image/avatarteacher.png') }}"
                                     alt="{{ isset($tea_new->teacher_name) ? $tea_new->teacher_name : '' }}"
                                     title="{{ isset($tea_new->teacher_name) ? $tea_new->teacher_name : '' }}"
                                     width="100%">
                            </div>
                            <div class="col-lg-9">
                                <p class="names mgb0 CutText101 fw7 blueN">
                                    {{ isset($tea_new->teacher_name) ? $tea_new->teacher_name : '' }}
                                </p>

                                <?php $business_type = \App\Entity\TypeOfBusiness::getIdTypeBusiness($tea_new->business_type_id);?>
                                <p class="workingPosition mgb0 CutText101"><i class="fas fa-certificate mgr5"></i>
                                    <span class="fw6 dsnonelg">Lĩnh vực
                                   : </span> {{ isset($business_type['type_of_business_name']) ? $business_type['type_of_business_name'] : 'Đang cập nhật' }}
                                </p>
                                <p class="mgb0 f12"><i class="fas fa-map-marker-alt mgr5"></i><span
                                            class="fw6 dsnonelg">Địa chỉ : </span>
                                    <?php $district = \App\Entity\District::getId($tea_new->district); ?>
                                    @if(!empty($district))
                                        {{ $district->district_name . ' -' }}
                                    @endif
                                    <?php $province = \App\Entity\Province::getId($tea_new->province);?>
                                    @if(!empty($province))
                                        {{ $province->province_name }}
                                    @endif

                                </p>
                                <?php
                                $countTeacher = \App\Entity\TeacherStar::countTeacher($tea_new->teacher_id);
                                $starAll = \App\Entity\TeacherStar::checkStarTeacher($tea_new->teacher_id);
                                $countStar = \App\Entity\TeacherStar::countTeacher($tea_new->teacher_id);

                                $aumAll = 0;
                                foreach ($starAll as $star) {
                                    $aumAll += $star['qty_stars'];
                                }
                                if ($countStar > 0) {
                                    $avgStar = $aumAll / $countStar;
                                } else {
                                    $avgStar = 0;
                                }
                                ?>
                                <div class="mgt0 mgb10"><span class="fw6 dsnonelg">Đánh giá :</span>
                                    <span
                                            class="rate-product" style=""></span>
                                    <script>
                                        $(".rate-product").starRating({
                                            initialRating: {{ $avgStar }},
                                            useFullStars: true,
                                            starSize: 20,
                                            readOnly: true,
                                            strokeColor: '#894A00',
                                        });
                                    </script>
                                    </span>
                                </div>


                            </div>
                        </div>
                    </a>
                    <hr class="mgt5 mgb5">
                @endforeach
            </div>
        </div>
    </div>

    <div class="w100">
        <a href="{{ route('teacher_register') }}" title="Đăng kí ứng viên">
            <img src="{{ isset($information['background-dang-ki-giao-vien']) ?  $information['background-dang-ki-giao-vien'] : '' }}" class="w100">
        </a>
    </div>

    @include('site.sidebar.list_banner')
</div>
