<div class="col-lg-3 pdl0 mh76-mgl15 dsmbNone sidebar_show_hidden" id="js_toogle_sidebar">
    <div id="dismiss">
        <i class="fas fa-arrow-left"></i>
    </div>
    <div class="UvNew bgrWhite">
        <div class="title textCenter textUpper bgrBlueN white fw7 pdt10 pdb10">
            Danh sách tin hỗ trơ
        </div>
        <div class="contentsUvNew bdLightGray">
            @if(!empty($post->slug))
                @foreach (\App\Entity\Post::relativeProduct($post->slug,10) as $id => $post_relati)
                    <a href="{{ route('support', ['cate_slug' => $cate_slug, 'post_slug' => $post_relati->slug]) }}" class="NoDecoration ">
                        <div class="pd10 pdl20 pdr20 bdBottomGray hvbgrClick ">
                            <h3 class="textCap   CutTextW250 f14 clHome mgb5" style="color: #009385"><i class="fas fa-caret-right"></i> {{ isset($post_relati->title) ? \App\Ultility\Ultility::textLimit($post_relati->title, 12) : '' }}</h3>
                            <i>
                                <p style="margin-bottom: 0" class="f14 clblack">{{ isset($post_relati->description) ? \App\Ultility\Ultility::textLimit($post_relati->description, 30) : '' }}</p>
                            </i>
                        </div>
                    </a>
                @endforeach
                <a href="{{ route('site_category_post',['slug_cate'=>$public_link['slug']]) }}" title="{{ isset($public_link->title) ? $public_link->title : '' }}" class="text-center bgrBlueN clwhite" style="display: block;padding: 5px 0;">Xem thêm</a>
            @endif
        </div>

    </div>

    @include('site.sidebar.list_banner')


</div>
