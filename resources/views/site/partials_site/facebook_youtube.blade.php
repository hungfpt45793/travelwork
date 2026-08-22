<div class="list_re_voucher vouchers mgb20 bdLightGray section_box_content mgt20" >
    <div class="bgrBlueN header_box">
        <h2 class="title_box  fw6 f20 mgb0 col-f14">
            <a>
                Hãy kết nối với chúng tôi <span class="mbdsNone">, để được giải đáp các thắc mắc</span>
            </a>
        </h2>
    </div>
    <div class="slide_page bgrWhite bdBottomGray">
        <div class="mgt15 text-center">
			{!! !empty($information['nhung-nhom-facebook']) ?  $information['nhung-nhom-facebook'] : '' !!}
        </div>
        <div class="mgt15 text-center">
            <div class="fb-page" style="width: 100%;height: 370px"
                 data-href="{{ !empty($information['link-fanpage']) ? $information['link-fanpage'] : '' }}"
                 data-tabs="timeline"
                 data-height="390"
                 data-small-header="false"
                 data-adapt-container-width="true"
                 data-hide-cover="false"
                 data-show-facepile="true">
                <blockquote
                        cite="{{ !empty($information['link-fanpage']) ? $information['link-fanpage'] : '' }}"
                        class="fb-xfbml-parse-ignore">
                    <a href="{{ !empty($information['link-fanpage']) ? $information['link-fanpage'] : '' }}">Tuyển nhân viên du lịch-việc làm du lịch-thực tập du lịch Web: Travelwork.vn</a>
                </blockquote>
            </div>
        </div>
        <div class="mgt15 text-center" >
            <script src="https://apis.google.com/js/platform.js"></script>
            <div style=" margin-top: 10px;padding:0 20px;text-align:left">
                <div
                        class="g-ytsubscribe"
                        data-channelid="{{ !empty($information['id-youtube']) ? $information['id-youtube'] : '' }}"
                        data-layout="full"
                        data-theme="default"
                        data-count="default">
                </div>
            </div>
            <br>
            <div style="margin-top: 5px;padding:0 20px;">
                <iframe style="width: 100%;height: 300px"
                        src="{{ !empty($information['link-video-youtube']) ? $information['link-video-youtube'] : '' }}"
                        frameborder="0"
                        allow="encrypted-media;"
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</div>

