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
            <h3 class="white fw7 textUpper mgb0 text-center f18 ">TRAVELWORK CAM KẾT</h3>
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


    <div class="w100">
        <a href="{{ route('course_becomeTeacher') }}" title="Đăng kí ứng viên">
            <img src="{{ isset($information['background-dang-ki-giao-vien']) ?  $information['background-dang-ki-giao-vien'] : '' }}" class="w100">
        </a>
    </div>

    @include('site.sidebar.list_banner')
</div>
