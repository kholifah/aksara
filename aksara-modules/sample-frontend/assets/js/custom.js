jQuery(document).ready(function($) {
	$('.search-toggle').on('click', function(e) {
		var target = $('#header-search');

		$(target).slideToggle().toggleClass('active');
		$(this).toggleClass('active');
		$(this).children().toggleClass('fa-search fa-times');
		$(target).find('input').focus();
		e.preventDefault();
	});
});
