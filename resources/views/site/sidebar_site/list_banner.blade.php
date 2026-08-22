@foreach(\App\Entity\SubPost::showSubPost('danh-sach-banner-quang-cao', 15) as $id => $bannerqc)
    @if(!empty($bannerqc['link-hien-thi-baner']))
        @if(url()->current() == $bannerqc['link-hien-thi-baner'])
            @if(!empty($bannerqc['link-banner-anh-dong']))
                <a target="_blank"
                       href="{{ !empty($bannerqc['link-quang-cao']) ? $bannerqc['link-quang-cao'] : '' }}"
                       title="{{ isset($bannerqc['title']) ? $bannerqc['title'] : '' }}">
                    <div class="BannerQc mgt10 mgb10 formJobLarge bg-white pd15 text-center">
                        <iframe style="border: none" width="100%" height="620px" data_herf="{{ !empty($bannerqc['link-quang-cao']) ? $bannerqc['link-quang-cao'] : '' }}"
                                src="{{ !empty($bannerqc['link-banner-anh-dong']) ? $bannerqc['link-banner-anh-dong'] : '' }}"></iframe>
								
								 <a target="_blank" style="background: #009385;
    color: #fff;
    padding: 10px 24px;
    font-size: 16px;"
                       href="{{ !empty($bannerqc['link-quang-cao']) ? $bannerqc['link-quang-cao'] : '' }}"
                       title="{{ isset($bannerqc['title']) ? $bannerqc['title'] : '' }}">Xem chi tiết
					   </a>
                    </div>
					
                    <div class="desBanner white clred mgt10">
                        <div style="color: #000">{{ isset($bannerqc['description']) ? $bannerqc['description'] : '' }}</div>
                    </div>
                </a>
				
            @else
                <div class="BannerQc mgt10 mgb10 formJobLarge bg-white pd15">
                    <div class="w100">
                        <a target="_blank"
                           href="{{ !empty($bannerqc['link-quang-cao']) ? $bannerqc['link-quang-cao'] : '' }}"
                           title="{{ isset($bannerqc['title']) ? $bannerqc['title'] : '' }}">
                            <img class="w100 lazy"
                                 src="{{ !empty(asset($bannerqc['image'])) ? asset($bannerqc['image']) : '' }}"
                                 alt="{{ isset($bannerqc['title']) ? $bannerqc['title'] : '' }}">
                        </a>

                    </div>

                    <div class="desBanner white clred mgt10">
                        <div style="color: #000">{{ isset($bannerqc['description']) ? $bannerqc['description'] : '' }}</div>
                    </div>

                </div>
            @endif
        @endif
    @endif
@endforeach
<script>
    $('.BannerQc iframe').click(function(){
         var data_hrel = $(this).attr('data_herf');
		 console.log(data_hrel);
        $(location).attr('href', data_hrel);
    });
</script>


