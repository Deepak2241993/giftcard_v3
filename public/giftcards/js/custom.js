(function ($) {
	"use strict";

	/* ..............................................
	Loader 
    ................................................. */

	$(window).on('load', function () {
		$('.preloader').fadeOut();
		$('#preloader').delay(550).fadeOut('slow');
		$('body').delay(450).css({ 'overflow': 'visible' });
	});

	/* ..............................................
    Navbar Bar
    ................................................. */

	$('.navbar-nav .nav-link').on('click', function () {
		var toggle = $('.navbar-toggler').is(':visible');
		if (toggle) {
			$('.navbar-collapse').collapse('hide');
		}
	});

	/* ..............................................
    Fixed Menu
    ................................................. */

	$(window).on('scroll', function () {
		if ($(window).scrollTop() > 50) {
			$('.top-header').addClass('fixed-menu');
		} else {
			$('.top-header').removeClass('fixed-menu');
		}
	});

	/* ..............................................
    Properties Filter
    ................................................. */
	

	/* ..............................................
    Smooth Scroll
    ................................................. */

	$('a[href*="#"]:not([href="#"])').on('click', function () {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top - 65,
				}, 1000);
				return false;
			}
		}
	});


}(jQuery));