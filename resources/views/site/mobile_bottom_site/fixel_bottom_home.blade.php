<link rel="stylesheet" type="text/css" href="/assets/css/thang_job_reponsive.css"/>
<div class="container-fluid dsNone show_mobile_job_500">
    <div class="row ">
        <div class="col-4">
            <div class="item_job_mobile text-center">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <a href="{{ route('show_step_profile_employee') }}">
                        <i class="fas fa-paper-plane"></i>
                        <p class="mgb0">Tạo hồ sơ</p>
                    </a>
                @else
                    <a data-toggle="modal" data-target="#loginTiva">
                        <i class="fas fa-paper-plane"></i>
                        <p class="mgb0">Tạo hồ sơ</p>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-4">
            <div class="item_job_mobile text-center" id="js_show_search_home">
                <a>
                    <i class="fas fa-search"></i>
                    <p class="mgb0">Tìm kiếm</p>
                </a>
            </div>
        </div>
        <div class="col-4">
            <div class="item_job_mobile text-center">
                <a data-toggle="modal" data-target="#modal_dowload_app">
                    <i class="fas fa-download"></i>
                    <p class="mgb0">Tải App</p>
                </a>
            </div>
        </div>
    </div>
</div>