;(function ($) {
	$(document).ready(function(){
		var theme = $('#gl_path').text(),
		el, scheme, switcher = '#style_switcher';
		$('#style_switcher .toggler').on('click touchstart', function(){
			$(this).parent().toggleClass('shown');
		});
		$('body').on('click touchstart', function(e){
			if (!$(e.target).is(switcher) && $(e.target).parents(switcher).length === 0 && $(switcher).hasClass('shown')) {
				$(switcher).removeClass('shown');
			}
		});
		$('.color_scheme').on('click touchstart', function(){
			scheme = $(this).data('scheme');
			el = $(this);
			if ($('link#color_scheme').length) {
				$('link#color_scheme').attr({href: 'catalog/view/theme/' + theme + '/stylesheet/color_schemes/' + scheme + '.css'});
			}
			else {
				$('body').append('<link id="color_scheme" rel="stylesheet" href="catalog/view/theme/' + theme + '/stylesheet/color_schemes/' + scheme +'.css">');
			}
			$('#color-box li').removeClass('active');
			el.closest('li').addClass('active');
			createCookie('tm_color_switcher_scheme', scheme, '', '');
		});
	});
	$(document).on('change', '#skin', function(){
		window.location = $(this).val();
	});
})(jQuery);