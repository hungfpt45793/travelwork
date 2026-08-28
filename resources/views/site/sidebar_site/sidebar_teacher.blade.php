{{--<div class="col-xl-3 col-lg-4 anotheTeacher dsmbNone sidebar_show_hidden" id="js_toogle_sidebar">--}}

    <div class="dnav col-xl-3 col-lg-4 col-md-12 sidebar_job active_show_sidebar" id="js_toogle_sidebar">
    <div class="d-toggle">
        <div id="body-row" class="side-bar-left formJobLarge  sidebarJobFacebook">
            <div class="sidebar_job_title text-center clWhite bgHome">
                <p class="f20 mgb0"><i class="fas disInBlock fa-paper-plane mgr5 "></i> Thông tin</p>
            </div>
            @include('site.sidebar_site.item_info')
        </div>


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
                <img src="{{ \App\Ultility\Ultility::assetUrl(data_get($information, 'background-dang-ki-giao-vien'), 'assets/image/course/banner-preview.png') }}" class="w100">
            </a>
        </div>



        {{--//include giaovienvien--}}
{{--        @include('site.teacher_site.item_teacher_new_sidebar')--}}
    </div>
</div>
