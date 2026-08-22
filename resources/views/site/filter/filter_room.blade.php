<section class="quickSearchForJobs mgt20 bgrWhite">
    <div class="formSearch pd0">
        <div class="form-group">
            {{--detail_job_facebook--}}
            <form id="searchBox" action="" method="GET">
                {{ csrf_field() }}
                <div class="content">

                    <div class="searchInput bdLightGray noBorderTopIm" style="border: none">
                        <div class="row mg0">
                            <div class="col-lg-9 pd0" style="border-left: 0px solid #ccc;
    border-radius: 0;">
                                <?php $word_get = isset($_GET['name_room']) ? $_GET['name_room'] : '';?>
                                <input class="w100" type="text" name="name_room" placeholder="Nhập tên phòng thi..." value="{{ $word_get }}" style="height:35px;border: 1px solid #ccc;padding: 0 10px;">
                            </div>
                            <button class="col-lg-3" type="submit" style="background: #009385;color: #fff;height: 35px;border: none;">Tìm kiếm
                            </button>
                        </div>
                    </div>



                </div>
            </form>
        </div>

    </div>
    <!--    --><?php //$province_get = isset($_GET['province']) ? $_GET['province'] : 0;?>

    <script>
        // chon thanh pho ra quan huyen
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-huyen/' + city , function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
    </script>
</section>

