(function($) {
    'use strict';

    jQuery(document).ready(function() {
    	
    	//Load all posts
    	sow_ajax_get_postdata(-1);

    	$('.sow_texonomy').on('click',function(){
    		var term_id = $(this).attr('data_id');
    		$(this).addClass('active').siblings().removeClass('active');

    		//console.log(term_id);
    		sow_ajax_get_postdata(term_id);

    	});

    	//ajax filter function
    	function sow_ajax_get_postdata(term_ID){
    		$.ajax({
    			type: 'post',
    			url: sow_ajax_params.sow_ajax_url,
    			data: {
    				action: 'sow_filter_posts',
    				sow_ajax_nonce: sow_ajax_params.sow_ajax_nonce,
    				term_ID: term_ID,
    			},
    			beforeSend: function(data){
    				$('.sow-loader').show();
    			},
    			complete: function(data){
    				$('.sow-loader').hide();
    			},    			
    			success: function(data){
    				$('.special-offers-filter-result').fadeOut(300, function() {
						$(this).html(data).fadeIn(300);
					});
    			},
    			error: function(data){
    				console.log(data);
    			},

    		});
    	}


    });

})(jQuery);
