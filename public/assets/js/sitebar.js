$(function() {
    $('#js_sidebarCollapse').on('click', function() {
        $('.d-toggle').toggleClass('block');
    });
    $('.overlay').on('click', function() {
        $('.d-toggle').toggleClass('block');
    });
    $('#collapse-icon').addClass('fa-angle-double-left')
    $('[data-toggle=sidebar-colapse]').click(function() {
        $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right')
        $('.menu-collapsed').toggleClass('d-none');
        $('.menu-collaps').toggleClass('d-none');
        // $('.dcontent').removeClass('col-xl-9 col-lg-8 col-md-12')

        $('.dnavnone').toggleClass("d-none");
        $('.ul-span span').toggleClass("d-none");
        $('.dnav').toggleClass("col-xl-3 col-lg-4 col-md-12");
        $('.dnav').toggleClass("col-xl-1 col-lg-1 col-md-12 width-collapse");
        $('.dcontent').toggleClass('col-xl-9 col-lg-8 col-md-12')
        $('.dcontent').toggleClass('col-xl-11 col-lg-11 col-md-12')
    });
    $('[data-toggle="tooltip"]').tooltip();
});