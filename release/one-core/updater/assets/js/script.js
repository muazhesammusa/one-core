
jQuery(document).ready(function( $ ){
	if( th_theme_updater_ajax.update_available ){
		if( $('.tophive-admin-tabs .update')[0] ){
			$('.tophive-admin-tabs .update').append('<span class="updater-warning">!</span>');
		}
	}
	$('.tophive-update-theme').on('click', function(e){
		var _that = $(this);
		e.preventDefault();
		_that.text(th_theme_updater_ajax.updating);
		$.ajax({
	    	type: 'POST',
	        url: th_theme_updater_ajax.ajaxurl,
	        data: {
	            'action': 'update_theme',
	            'nonce': th_theme_updater_ajax.nonce
	        },
	        success:function(data) {
	        	console.log(data);
	        	if( data ){
	        		$('.tophive-messages').html('<p class="ec-text-success">' + th_theme_updater_ajax.update_success + '</p>');
	        	}else{
	        		$('.tophive-messages').html('<p class="ec-text-danger">' + th_theme_updater_ajax.update_failed + '</p>');
	        	}
	        	_that.slideUp(200);
	        	location.reload();
	        },
	        error: function(xhr, ajaxOptions, thrownError){
	        	console.log(xhr);
	        }
	    });
	});
});