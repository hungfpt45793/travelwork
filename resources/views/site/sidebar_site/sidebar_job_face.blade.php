<?php  $public_link_employee = \App\Entity\Category::getDetailCategory('ke-toan-di-tim-viec'); ?>
<div class="dnav col-xl-3 col-lg-4 col-md-12 sidebar_job active_show_sidebar" id="js_toogle_sidebar">
    <div class="d-toggle">
        <div id="body-row" class="side-bar-left formJobLarge  sidebarJobFacebook">
            <div class="sidebar_job_title text-center clWhite bgHome">
               <p class="f20 mgb0"><i class="fas disInBlock fa-paper-plane mgr5 "></i> Thông tin</p>
            </div>
            @include('site.sidebar_site.item_info')
        </div>
        @include('site.sidebar_site.list_banner')
    </div>
</div>
