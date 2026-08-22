<section class="api_mesage_fb_zalo">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="mesage_facbook">
                    {!! !empty($information['facebook-chat-box']) ?  $information['facebook-chat-box'] : '' !!}
                </div>

                <div class="message_zalo">
                    <div class="zalo-chat-widget" data-oaid="385152973551497836"
                         data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="3" data-width="350"
                         data-height="420"></div>

                    <script src="https://sp.zalo.me/plugins/sdk.js"></script>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <a id="back-to-top" href="#" class="back-to-top f20" role="button" title="Lên đầu trang"
               data-toggle="tooltip" data-placement="left"><i class="fas fa-chevron-circle-up"
                                                              style="font-size: 35px;color: green"></i></a>
        </div>
    </div>

</div>
<style>
    .api_mesage_fb_zalo .mesage_facbook .fb_dialog_content iframe {
        bottom: 145px !important;
        z-index: 99999999;
        border-radius: 29px;
        box-shadow: rgba(0, 0, 0, 0.15) 0px 4px 12px 0px;
        background: none;
        display: block;
        right: 0px !important;
    }

    .api_mesage_fb_zalo .message_zalo .zalo-chat-widget {
        bottom: 70px !important;
        z-index: 99999999;
    }

    @media only screen and (max-width: 500px) {
        .back-to-top {
            bottom: 40px;
        }
    }
</style>