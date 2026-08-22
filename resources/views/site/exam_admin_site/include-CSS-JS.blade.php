<script src="{{ asset('') }}/adminstration/plugins/iCheck/icheck.min.js"></script>

<script>
    //var sticky = new Sticky('[data-sticky]');
    $(document).ready(function () {
        // Optimalisation: Store the references outside the event handler:
        var $window = $(window);

        var windowsize = $window.width();
        if (windowsize >= 1000) {
            var stickySidebar = new StickySidebar('#sidebar', {
                topSpacing: 60,
                bottomSpacing: 40,
                containerSelector: '#scollProduct',
                innerWrapperSelector: '.sidebar__inner'
            });
        }
    });
</script>