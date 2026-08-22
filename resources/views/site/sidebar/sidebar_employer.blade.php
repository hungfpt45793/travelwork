<div class="col-xl-3 col-lg-4 col-md-12 dsmbNone sidebar_show_hidden" id="js_toogle_sidebar">
    <div id="dismiss">
        <i class="fas fa-arrow-left"></i>
    </div>

    <div class="side-bar-left formJobLarge ">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                   role="tab" aria-controls="nav-home" aria-selected="true">Thông tin</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                   role="tab" aria-controls="nav-profile" aria-selected="false">Bộ lọc</a>
            </div>
        </nav>
        @include('site.sidebar.item_info')
    </div>
    @include('site.sidebar.list_banner')
</div>