/**
 * Cherry WooCommerce package scripts
 */

jQuery(document).ready(function($) {

	//Dropdown account in header
	$('.cherry-wc-account_title').click(function(event){
		event.preventDefault();
		event.stopPropagation();
		if( $(this).hasClass('cherry-dropdown-opened') ) {
			$(this).removeClass('cherry-dropdown-opened')
			$(this).parent().find('.cherry-wc-account_content').slideUp(300).removeClass('opened');
		} else {
			$(this).addClass('cherry-dropdown-opened')
			$(this).parent().find('.cherry-wc-account_content').slideDown(300).addClass('opened');
		}
	});

	$(document).on('click', 'body', function(event) {
		$(this).find('.cherry-wc-account_content.opened').slideUp(300).removeClass('opened');
		$(this).find('.cherry-dropdown-opened').removeClass('cherry-dropdown-opened');
	});

	$(document).on('click', '.cherry-wc-account_content', function(event) {
		event.stopPropagation();
	})

	$('.sf-menu > li > .cherry-badge').each(function(){
		$(this).append('<b class="cherry-badge-content">' + $(this).data('badge-text') + '</b>');
	});


	// product carousel init
	$('.cherry_wc_product_carousel').each(function(index, el) {
		var params = $(this).data('params');
		$(this).find('>ul').owlCarousel(params);
	});

	// quick view
	$(document).on('click', '.cherry-quick-view', function(event) {

		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		var product_id = $(this).data('product'),
			item = $(this).parents('li.product'),
			current_popup = 'cherry-quick-view-popup-' + product_id;

		var send_ajax_request = function() {
			jQuery.ajax({
				type : "post",
				dataType : "json",
				url : cherry_wc_data.ajax_url,
				data : {
					action: 'cherry_wc_quick_view',
					_wpnonce: cherry_wc_data.nonce,
					product: product_id
				},
				success: function(response) {
					$('#'+current_popup).find('.cherry-quick-view-popup-content').html(response.content);
					$(".cherry-quick-view-images a.zoom").prettyPhoto({
						hook: 'data-rel',
						social_tools: false,
						theme: 'pp_woocommerce',
						horizontal_padding: 20,
						opacity: 0.8,
						deeplinking: false
					});
				}
			})
		}

		if ( !item.find('.cherry-quick-view-popup').length ) {
			item.append('<div id="' + current_popup + '" class="cherry-quick-view-popup mfp-hide"><span href="#" class="mfp-close">&times;</span><div class="cherry-quick-view-popup-content"><div class="cherry-quick-view-load">' + cherry_wc_data.loading + '</div></div></div>');
			send_ajax_request();
		}

		$.magnificPopup.open({
			items: {
				src: '#' + current_popup
			},
			type: 'inline'
		}, 0);

		return false;

	});

});