function equalheight(){
	
	jQuery('.address_details').each(function(){
		var had = jQuery(this).height();
		jQuery(this).parent().parent().css('padding-bottom',had+10+'px');
	})
	
	var elementHeights = jQuery('.two_column_image').map(function() {
	  return jQuery(this).height();
	})
	var maxHeight = Math.max.apply(null, elementHeights);
	jQuery('.two_column_image').height(maxHeight);
	
}

function load_more_list_view(status,page_no){
	
	new_page = parseInt(page_no)+1;
	jQuery(".load_more").attr("onclick", "load_more_list_view('"+status+"',"+new_page+");");
	
	var data = {
		action: "load_list_view_more_posts",
		page: new_page,
		status: status,
	};
	jQuery.post(ajaxurl, data, function(response) {
		if( response ) {
			
			split_value = response.split('{total}');
			jQuery(".property_list_view.non-mls-grid .load_more_container").append(split_value[0]);
			if(new_page == split_value[1]){
				jQuery(".load-more").hide();
			}
			setTimeout(function(){
				var winwidth = jQuery(window).width();
				if(winwidth > 767){
					equalheight();
				}
			},50);
		}
	});
}

jQuery(function($){
	
	
	/* For iOS touch hover effect */
	document.addEventListener("touchstart", function() {},false);
	
});
jQuery(window).load(function(){
	var winwidth = jQuery(window).width();
	if(winwidth > 767){
		equalheight();
	}
});

jQuery(window).on('load resize', function () {
   
});