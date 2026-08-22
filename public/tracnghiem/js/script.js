/* ============================================================
 
 Template Name: Maro-News - News and Blog HTML Template.
 Author: Marwa El-Manawy -- https://elmanawy.info
 Description: Maro-News - News and Blog HTML Template.
 Version: 1.0
 
 ===============================================================
 */

jQuery(document).ready(function () {
  
    //Responsive Header
    $('.responsive-menu li.menu-item-has-children > i').on('click', function () {
        var parent = $(this).parent();
        var parent_sibling = $(this).parent().siblings();
        parent_sibling.children('ul').slideUp();
        parent_sibling.removeClass('active');
        parent.children('ul').slideToggle();
        parent.toggleClass('active');
        return false;
    });

    $('#nav-icons-head').on('click', function () {
        $('.responsive-menu').toggleClass('slidein');
        return false;
    });

    // Seraching Responsive
    $('.res-search').on('click', function () {
        $('.search-insite').addClass('open');
        return false;
    });
    $('.search-insite > i').on('click', function () {
        $('.search-insite').removeClass('open');
        return false;
    });

    //for open and close button rotation
    $('#nav-icons-head').on('click', function () {
        $(this).toggleClass('open');
        return false;
    });


    //Header Search Desktop
    $('.header-search > a').on('click', function () {
        $('.search-here').addClass('active');
        return false;
    });
    $('.search-here > i').on('click', function () {
        $('.search-here').removeClass('active');
        return false;
    });

    //Login dropdown	
    $('.login-register a').on('click', function () {
        $('.login-wraper').addClass('active');
        return false;
    });

//    $('.close').on('click', function () {
//        $('.login-wraper').removeClass('active');
//        return false;
//    });
//    $('.login-responsive a').on('click', function () {
//        $('.login-wraper').addClass('active');
//        return false;
//    });

    //Dropdown
    var drop = $('nav > ul > li > ul > li')
    $('nav > ul > li').each(function () {
        var delay = 0;
        $(this).find(drop).each(function () {
            $(this).css({transitionDelay: delay + 'ms'});
            delay += 50;
        });
    });
    var drop2 = $('nav  > ul > li > ul > li >  ul > li')
    $('nav > ul > li > ul > li').each(function () {
        var delay2 = 0;
        $(this).find(drop2).each(function () {
            $(this).css({transitionDelay: delay2 + 'ms'});
            delay2 += 50;
        });
    });
 
    

});
