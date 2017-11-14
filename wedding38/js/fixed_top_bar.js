$(window).scroll(function(){
    if ($(window).scrollTop() >= 200) {
       $('#page_header').addClass('fixed-header');
    }
    else {
       $('#page_header').removeClass('fixed-header');
    }
});