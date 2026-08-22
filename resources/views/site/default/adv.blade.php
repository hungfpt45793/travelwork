<?php
$adv_noti = \App\Entity\Adv_noti::get_adv_noti();
?>
@if(!empty($adv_noti))
    <div class="noti_mobile_show">
        <div class="modal fade bd-example-modal-lg" id="message_noti_adv" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <a href="{{$adv_noti->adv_link  }}" target="_blank" class="blueDN">
                        <h5 class="modal-title">{{ !empty($adv_noti->adv_title) ? $adv_noti->adv_title : '' }}</h5>
                        </a>
                        <button type="button" class="close close_modal_hiden" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <a href="{{$adv_noti->adv_link  }}" target="_blank" class="close_modal_hiden">
                    <div class="modal-body content_modal_noti_adv">
                        {!! !empty($adv_noti->adv_content) ? $adv_noti->adv_content : '' !!}
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            var user_adv = getCookie_home("modal_noti_adv");
            if (user_adv != 'modal_noti_hide_adv') {
                setTimeout(function(){
                    $('#message_noti_adv').modal('show');
                    $('.close_modal_hiden').click(function () {
                        var time_uot_cookie = '{{ $adv_noti->adv_time }}';
                        setCookie_home("modal_noti_adv", 'modal_noti_hide_adv', time_uot_cookie);

                        $('#message_noti_adv').modal('hide');
                    });
                },4000)
            }
        });
        function setCookie_home(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays));
            var expires = "expires=" + d.toGMTString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie_home(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

    </script>
@endif