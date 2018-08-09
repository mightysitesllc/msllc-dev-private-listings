jQuery(document).ready(function($) {
	$( '.owl-carousel' ).each(function( index ) {
		
		var slider_id = $(this).attr('id');
		
		$('#'+slider_id).owlCarousel({
		    loop:true,
		    nav:true,
		    center:true,
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
	});
});