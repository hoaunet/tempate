(function($) {
    $(function(){
    	//Dropdown cart in header
		$('.cart-holder > h3').click(function(){
			if($(this).hasClass('cart-opened')) {
				$(this).removeClass('cart-opened').next().slideUp(300);
			} else {
				$(this).addClass('cart-opened').next().slideDown(300);
			}
		});
		//Popup rating content
		$('.star-rating').each(function(){
			rate_cont = $(this).attr('title');
			$(this).append('<b class="rate_content">' + rate_cont + '</b>');
		});

		//Disable cart selection
		(function ($) {
			$.fn.disableSelection = function () {
				return this
					.attr('unselectable', 'on')
					.css('user-select', 'none')
					.on('selectstart', false);
			};
			$('.cart-holder h3').disableSelection();
		})(jQuery);

		//Fix contact form not valid messages errors
		jQuery(window).load(function() {
			jQuery('.wpcf7-not-valid-tip').live('mouseover', function(){
				jQuery(this).fadeOut();
			});

			jQuery('.wpcf7-form input[type="reset"]').live('click', function(){
				jQuery('.wpcf7-not-valid-tip, .wpcf7-response-output').fadeOut();
			});
		});

		// compare trigger
		$(document).on('click', '.cherry-compare', function(event) {
			event.preventDefault();
			button = $(this);
			$('body').trigger( 'yith_woocompare_open_popup', { response: compare_data.table_url, button: button } )
		});

    });
    
    $.fn.splitWords = function(index) {
        /*
            If index is specified the sentence will split at that point
            (minus index counts from end). Otherwise sentence is split in two.
        */

        return this.each(function() {

            var el = $(this),
                i, first, words = el.text().split(/\s/);


            if (typeof index === 'number') {
                i = (index > 0) ? index : words.length + index;
            }
            else {
                i = Math.floor(words.length / 2);
            }

            first = words.splice(0, i);

            el.empty().
                append(makeWrapElem(1, first)).
                append(makeWrapElem(2, words));
        });
    };
    function makeWrapElem(i, wordList) {
  if (i != 1) {
         return $('<span class="wrap-' + i + '">' + wordList.join('') + ' </span>');
  } else {
   return $('<b>' + wordList.join(' ') + '</b> ');
  }
    }
    
    $('ul.products li.product').each(function(){
       _this = $(this);
       _this.find('.price').after(_this.find('h3'));
       _this.find('ins').after(_this.find('del'));
       _this.find('.product-link-wrap').after(_this.find('.onsale'));
    });
    $('.product_list_widget li').each(function(){
       _this = $(this);
       _this.find('ins').after(_this.find('del'));
    });
    
    //Animation  
    /*$(".banner-box .span3:first-child").addClass("fadeInLeft wow").attr( 'data-wow-delay', '0.2s' );
    $(".banner-box .span3:first-child+.span3").addClass("fadeInLeft wow");
    $(".banner-box .span3:first-child+.span3+.span3").addClass("fadeInRight wow");
    $(".banner-box .span3:first-child+.span3+.span3+.span3").addClass("fadeInRight wow").attr( 'data-wow-delay', '0.2s' );
    
    $(".tab-content .products").addClass("fadeInUp wow");
    
    $(".brand_box li:first-child").addClass("fadeInLeft wow").attr( 'data-wow-delay', '0.3s' );
    $(".brand_box li:first-child+li").addClass("fadeInLeft wow").attr( 'data-wow-delay', '0.15s');
    $(".brand_box li:first-child+li+li").addClass("fadeInLeft wow");
    $(".brand_box li:first-child+li+li+li").addClass("fadeInRight wow");
    $(".brand_box li:first-child+li+li+li+li").addClass("fadeInRight wow").attr( 'data-wow-delay', '0.15s' );
    $(".brand_box li:first-child+li+li+li+li+li").addClass("fadeInRight wow").attr( 'data-wow-delay', '0.3s' );
    
    $(".footer-widgets .span3:first-child").addClass("fadeInLeft wow").attr( 'data-wow-delay', '0.2s' );
    $(".footer-widgets .span3:first-child+.span3").addClass("fadeInLeft wow");
    
    $(".footer-widgets .span6").addClass("fadeInRight wow");
    
    $(".newslatter_foo_box .span6:first-child").addClass("fadeInLeft wow");
    $(".newslatter_foo_box .span6:first-child+.span6").addClass("fadeInRight wow");*/
    
    
    
})(jQuery);

jQuery(".logo .logo_h__txt .logo_link").splitWords(1);

jQuery('.product-list-buttons a').wrapInner('<b/>');
jQuery('.add_to_cart_button').wrapInner('<b/>');
jQuery('ul.products li.product .btn').wrapInner('<b/>');