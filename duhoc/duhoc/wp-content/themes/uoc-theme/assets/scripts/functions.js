/* ---------------------------------------------------------------------------
 * Footer Back To Top Function
 * --------------------------------------------------------------------------- */
	jQuery('#backtop, #backtop2').on('click', function(){
		jQuery('html, body').animate({scrollTop : 0},800);
		return false;
	});

/* ---------------------------------------------------------------------------
 * 	FlexSlider Function
 * --------------------------------------------------------------------------- */
	jQuery(window).load(function() {
		 if(jQuery('.flexslider').length != ''){
			jQuery('.flexslider').flexslider({
			    slideshowSpeed: 4000,
			    animationDuration: 1100,
			    animation: 'slide',
			    directionNav: true,
			    controlNav: false,
			    pausePlay: true,
			    pauseText: 'Pause',
			    playText: 'Play',
			    prevText: "<i class='icon-arrow-left10'></i>",
	     		nextText: "<i class='icon-arrow-right10'></i>",
	     		start: function(slider) {
		            jQuery('.flexslider').removeClass('cs-loading');
		            jQuery('.flexslider').find('.loader').remove();
		        } 
			});
		 }
	});

		jQuery(window).load(function() {
		 if(jQuery('#cs-customnav').length != ''){
		jQuery('#cs-customnav').flexslider({
		    slideshowSpeed: 4000,
		    animationDuration: 1100,
		    animation: 'slide',
		    directionNav: true,
		    controlNav: false,

		});
		 }
	});
	// NewsTicker Function
	jQuery(window).load(function() {
		if(jQuery('.news-ticker').length != ''){
		jQuery('.news-ticker').flexslider({
		    slideshowSpeed: 2000,
		    animationDuration: 1100,
		    animation: 'fade',
		    directionNav: true,
		    controlNav: false,
		    pausePlay: false,
		    pauseText: 'Pause',
		    playText: 'Play',
		    prevText: "<i class='icon-arrow-left10'></i>",
     		nextText: "<i class='icon-arrow-right10'></i>",
		});
		}
	});
	// Gallery Slider
	jQuery(window).load(function() {
		if(jQuery('#carousel').length != ''){
        jQuery('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: true,
            slideshow: false,
            itemWidth: 170,
            itemMargin: 8,
            asNavFor: '#slider'
        });    
        jQuery('#slider').flexslider({
           slideshowSpeed: 4000,
            animationDuration: 1100,
            animation: 'slide',
            directionNav: true,
            controlNav: false,
            pausePlay: true,
            pauseText: 'Pause',
            playText: 'Play',
            prevText: "<i class='icon-arrow-left10'></i>",
            nextText: "<i class='icon-arrow-right10'></i>",
            sync: "#carousel"
        });
		}
    });

function cs_mailchimp_submit(theme_url, counter, admin_url) {
  'use strict';
  $ = jQuery;
  //$('#btn_newsletter_' + counter).hide();
  $('#process_' + counter).html('<div id="process_newsletter_' + counter + '"><i class="icon-refresh icon-spin"></i></div>');
  $.ajax({
    type: 'POST',
    url: admin_url,
    data: $('#mcform_' + counter).serialize() + '&action=cs_mailchimp',
    success: function(response) {
      $('#mcform_' + counter).get(0).reset();
      $('#newsletter_mess_' + counter).fadeIn(600);
      $('#newsletter_mess_' + counter).html(response);
      $('#btn_newsletter_' + counter).fadeIn(600);
      $('#process_' + counter).html('');
    }
  });
}


/* ---------------------------------------------------------------------------
 * 	OwlCarousel Function
 * --------------------------------------------------------------------------- */
 jQuery(document).ready(function() { 
 if(jQuery('.owl-carousel').length != ''){
	 jQuery('.owl-carousel').owlCarousel({
	    loop:true,
	    margin:0,
	    nav:true,
	    dots:false,
	    navText: [
			"<i class='icon-arrow-left10'></i>",
			"<i class='icon-arrow-right10'></i>"
		],
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:1
	        },
	        1000:{
	            items:1
	        }
	    }
	});
 }
});	
	jQuery(document).ready(function() {  
	if(jQuery('.cs-partner').length != ''){
	 jQuery('.cs-partner').owlCarousel({
	    loop:true,
	    margin:10,
	    nav:true,
	    dots:false,
	    navText: [
			"<i class='icon-arrow-left10'></i>",
			"<i class='icon-arrow-right10'></i>"
		],
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:3
	        },
	        1000:{
	            items:6
	        }
	    }
	});
	}
  });

/* ---------------------------------------------------------------------------
 * Footer Back To Top Function
 * --------------------------------------------------------------------------- */
	jQuery(document).ready(function(){
		//Click event to scroll to top
		jQuery('#backtop').click(function(){
			jQuery('html, body').animate({scrollTop : 0},800);
			return false;
		});
		
	});
	

/* ---------------------------------------------------------------------------
 * 	Courses Accordian
 * --------------------------------------------------------------------------- */
if(jQuery('.cs-course-table').length != ''){
 jQuery('.cs-course-table').find('.cs-courses').hide();
 jQuery('.cs-course-table .active').find('.cs-courses').show();
 jQuery('.cs-course-table .active').find('.opener a').html('-');

 jQuery('.cs-course-table .title-bar').on('click', '.opener a', function(e){
 	e.preventDefault();
 	var active = jQuery(this).parents('article').hasClass('active')
 	if( !active ){
 		jQuery('.cs-course-table').find('article').removeClass('active');
 		jQuery(this).parents('article').addClass('active');

 		jQuery('.cs-course-table').find('.cs-courses').slideUp();
 		jQuery('.cs-course-table .active').find('.cs-courses').slideDown();

 		jQuery('.cs-course-table .title-bar').find('.opener a').html('+');
 		jQuery(this).html('-');
 	}else{
 		jQuery(this).parents('article').removeClass('active');
 		jQuery('.cs-course-table').find('.cs-courses').slideUp();
 		jQuery('.cs-course-table .title-bar').find('.opener a').html('+');
 	}
 });
}

 /* ---------------------------------------------------------------------------
 * 	Courses Tabs
 * --------------------------------------------------------------------------- */
 
if(jQuery('.cs-tabs').length != ''){
var preActive = jQuery('.cs-tabs').find('.tab-nav .active a').attr('href');
jQuery('.cs-tabs .tab-content').find('.tabs').hide();
jQuery('.cs-tabs .tab-content').find(preActive).show();

jQuery('.cs-tabs .tab-nav').on('click', 'a', function(e){
	e.preventDefault();
 	var activeCheck = jQuery(this).parents('li').hasClass('active');
 	if( !activeCheck ){
 		jQuery('.cs-tabs .tab-nav').find('li').removeClass('active');
 		jQuery(this).parents('li').addClass('active');

 		var active = jQuery('.cs-tabs').find('.tab-nav .active a').attr('href');

 		jQuery('.cs-tabs .tab-content').find('.tabs').hide();
 		jQuery('.cs-tabs .tab-content').find(active).show();
 	}
});
}



/* ---------------------------------------------------------------------------
 * 	Widget Tabs
 * --------------------------------------------------------------------------- */

if(jQuery('.widget_tabs').length != ''){
var preActive = jQuery('.widget_tabs').find('.tab-nav .active a').attr('href');
jQuery('.widget_tabs .tab-content').find('.tabs').hide();
jQuery('.widget_tabs .tab-content').find(preActive).show();

jQuery('.widget_tabs .tab-nav').on('click', 'a', function(e){
	e.preventDefault();
 	var activeCheck = jQuery(this).parents('li').hasClass('active');
 	if( !activeCheck ){
 		jQuery('.widget_tabs .tab-nav').find('li').removeClass('active');
 		jQuery(this).parents('li').addClass('active');

 		var active = jQuery('.widget_tabs').find('.tab-nav .active a').attr('href');

 		jQuery('.widget_tabs .tab-content').find('.tabs').hide();
 		jQuery('.widget_tabs .tab-content').find(active).show();
 	}
});
}

/* ---------------------------------------------------------------------------
 * 	Header Responsive
 * --------------------------------------------------------------------------- */
jQuery(document).ready(function() {
 jQuery(".navigation ul ul") .parent('li') .addClass('parentIcon');
 jQuery(".navigation ul ul") .parent('li') .prepend( "<span class='responsive-btn'><i class='icon-plus8'></i></span>" );

	 jQuery(".navigation ul a").click(function(e){

	 	var a = jQuery(window).width();
		 var b = 1000
		 if (a <= b) {

		  var dropCheck = jQuery(this).parent('li').find('.sub-dropdown');

		  if(dropCheck.length != ''){
		   e.preventDefault();
		   if(jQuery(this).parent('li').hasClass('active')){
		    jQuery(this).parent('li').find('.responsive-btn').html("<i class='icon-plus8'></i>");
		    jQuery(this).parent('li').removeClass('active');
		    jQuery(this).parent('li').children('ul').hide();
		   }else{
		    jQuery(".navigation .responsive-btn").html("<i class='icon-plus8'></i>");
		    jQuery(this).parent('li').find('.responsive-btn').html("<i class='icon-minus8'></i>");
		    jQuery(this).parent('li').parent('ul').find('li').removeClass('active');
		    jQuery(this).parent('li').addClass('active');
		    jQuery(this).parent('li').parent('ul').find('li>ul').hide();
		    jQuery(this).parent('li').children('ul').show();
		   }
		  }
	 }
 });

 jQuery('.cs-click-menu').on('click', function(e) {
	  e.preventDefault();
	  jQuery(this).siblings('ul').slideToggle();
	  jQuery(".navigation ul ul") .hide();
	 });
	});
jQuery(window).resize(function() {
 var a = jQuery(window).width();
 var b = 1000
 if (a >= b) {
  jQuery(".navigation ul ul,.navigation ul") .show();
 }else{
  jQuery(".navigation ul ul,.navigation ul") .hide();
 }
});

