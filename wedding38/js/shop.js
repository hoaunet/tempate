 jQuery(function($){

	// SEARCH FORMS /////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$(document).on('submit', '.search_form', function(e) {
		var searchQuery = $(this).find('input').val().replace(/ /g, '+');
		var placeHolder = $(this).find('input').attr('placeholder').replace(/ /g, '+');

		if ( !(searchQuery.length && searchQuery != placeHolder) ) {
			e.preventDefault();
			e.stopPropagation();
		};
	});




	// PRODUCT QUANTITY BOX /////////////////////////////////////////////////////////////////////////////////////////////////////
	$(document).on("focusout",".quantity_input",function(){var a=$(this).val();isNaN(parseFloat(a))&&!isFinite(a)||0==parseInt(a)||""==a?$(this).val(1):parseInt(a)<0?$(this).val(parseInt(a)-2*parseInt(a)):$(this).val(parseInt(a))}),$(document).on("click",".quantity_up",function(){var a=$(this).parent().find(".quantity_input");isNaN(parseFloat(a.val()))||!isFinite(a.val())||a.attr("disabled")?a.val(1):a.val(parseInt(a.val())+1)}),$(document).on("click",".quantity_down",function(){var a=$(this).parent().find(".quantity_input");!isNaN(parseFloat(a.val()))&&isFinite(a.val())&&a.val()>1&&!a.attr("disabled")?a.val(parseInt(a.val())-1):a.val(1)});

	// $(document).on('focusout', '.quantity_input', function() {
	// 	var N = $(this).val();

	// 	if ( ( isNaN(parseFloat( N )) && !isFinite( N ) ) || parseInt( N ) == 0 || N == '' ) {
	// 		$(this).val(1);
	// 	}
	// 	else if ( parseInt( N ) < 0 ) {
	// 		$(this).val( parseInt( N ) - parseInt( N )*2 );
	// 	}
	// 	else {
	// 		$(this).val( parseInt( N ) );
	// 	};
	// });

	// $(document).on('click', '.quantity_up', function() {
	// 	var N = $(this).parent().find('.quantity_input');

	// 	if ( !isNaN( parseFloat( N.val() ) ) && isFinite( N.val() ) && !N.attr('disabled') ) {
	// 		N.val( parseInt( N.val() ) + 1 );
	// 	}
	// 	else {
	// 		N.val(1);
	// 	};
	// });

	// $(document).on('click', '.quantity_down', function() {
	// 	var N = $(this).parent().find('.quantity_input');

	// 	if ( !isNaN( parseFloat( N.val() ) ) && isFinite( N.val() ) && ( N.val() > 1 ) && !N.attr('disabled') ) {
	// 		N.val( parseInt( N.val() ) - 1 );
	// 	}
	// 	else {
	// 		N.val(1);
	// 	};
	// });




	// RTE YOUTUBE WRAPPER //////////////////////////////////////////////////////////////////////////////////////////////////////
	$(document).ready(function() {
		if ( $('.rte').length ) {
			$('.rte iframe[src *= youtube]').wrap('<div class="rte_youtube_wrapper"></div>');
		};
	});




	// BACK TO TOP BUTTON ///////////////////////////////////////////////////////////////////////////////////////////////////////
	$(document).ready(function(){
		$(window).on('scroll', function(){
			if ( $(this).scrollTop() > 300 ) {
				$('#back_top').fadeIn("slow");
			}
			else {
				$('#back_top').fadeOut("slow");
			};
		});

		$('#back_top').on('click', function(e) {
			e.preventDefault();
			$('html, body').animate( {scrollTop : 0}, 800 );
			$('#back_top').fadeOut("slow").stop();
		});

	});




	// FORM VALIDATION //////////////////////////////////////////////////////////////////////////////////////////////////////////
	$.fn.formValidation = function() {
		this.find('input[type=text], input[type=email], input[type=password], textarea').after('<p class="alert-inline" style="display: none;"></p>');

		this.on('submit', function(event) {
			$(this).find('input[type=text], input[type=email], input[type=password], textarea').each(function() {

				if ( $(this).val() == '' ) {
					$(this).addClass('alert-inline').next().html('Field can\'t be blank').slideDown();

					$(this).on('focus', function() {
						$(this).removeClass('alert-inline').next().slideUp();
					});

					event.preventDefault();

				};

			});

			if ( $(this).find('input[type=email]').length ) {
				var inputEmail = $(this).find('input[type=email]');

				if ( inputEmail.val().length > 0 && ( inputEmail.val().length < 6 || inputEmail.val().indexOf("@") == -1 || inputEmail.val().indexOf(".") == -1 ) ) {
					inputEmail.addClass('alert-inline').next().html('Incorrect email').slideDown();

					inputEmail.on('focus', function() {
						$(this).removeClass('alert-inline').next().slideUp();
					});

					event.preventDefault();

				};

			};

			if ( $(this).find('input[type=password]').length == 2 ) {
				var pwd1 = $(this).find('input[type=password]:eq(0)');
				var pwd2 = $(this).find('input[type=password]:eq(1)');

				if ( pwd1.val() != pwd2.val() ) {
					pwd1.addClass('alert-inline');
					pwd2.addClass('alert-inline').next().html('Passwords do not match').slideDown();

					pwd1.on('focus', function() {
						pwd1.removeClass('alert-inline');
						pwd2.removeClass('alert-inline').next().slideUp();
					});

					pwd2.on('focus', function() {
						pwd1.removeClass('alert-inline');
						pwd2.removeClass('alert-inline').next().slideUp();
					});

					event.preventDefault();

				};
			};
		});
	};
});



