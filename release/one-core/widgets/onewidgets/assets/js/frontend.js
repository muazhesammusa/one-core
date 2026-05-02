// Fundocean compatibility for learnpress
jQuery(document).ready(function($) {
	$('.newsletter-submit').on('click', function(e){
		var _that = $(this);
		e.preventDefault();
		var mail = _that.parent().find('input.newsletter-submit-form-mail').val();
		if( mail !== '' ){
			_that.addClass('mc-loading');
			$.ajax({
				url: One_JS.ajaxurl,
				type: 'POST',
				data: {
					'action' : 'mailchimpsubscribe',
					'email' : mail,
				},
				success : function( res ){
					_that.parents('.newsletter-submit-form').next().html(res);
					_that.removeClass('mc-loading');
				},
				error: function(xhr, ajaxOptions, thrownError){
					console.log(xhr.responseText);
		        }
			})
		}
	});
});