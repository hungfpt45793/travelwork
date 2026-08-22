
@foreach(\App\Entity\SubPost::showSubPost('danh-sach-banner-quang-cao', 15) as $id => $bannerqc)
    @if(!empty($bannerqc['link-hien-thi-baner']))
        @if(url()->current() == $bannerqc['link-hien-thi-baner'])
            <div class="BannerQc mgt10 mgb10 formJobLarge bg-white pd15">
                <div class="w100">
                    <div class="w100">
                        <a target="_blank" href="{{ !empty($bannerqc['link-banner-anh-dong']) ? $bannerqc['link-banner-anh-dong'] : $bannerqc['link-quang-cao'] }}" title="{{ isset($bannerqc['title']) ? $bannerqc['title'] : '' }}">
                            <img class="w100 lazy" src="{{ !empty($bannerqc['banner-anh-dong']) ? asset($bannerqc['banner-anh-dong']) : asset($bannerqc['image']) }}" alt="{{ isset($bannerqc['title']) ? $bannerqc['title'] : '' }}">
                        </a>
                    </div>
                </div>
                <div class="desBanner white clred mgt10">
                    <div style="color: #000">{{ isset($bannerqc['description']) ? $bannerqc['description'] : '' }}</div>
                </div>
            </div>
        @endif
    @endif
@endforeach
