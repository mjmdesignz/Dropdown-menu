jQuery(document).ready( function($) {	
	$('.like-it').on('click', function() {	
		if($(this).hasClass('liked')) {
			return false;
		}
		$(this).fadeOut(50, function() { $(this).html(like_it_vars.thanks_message); }).delay(300).fadeIn(50);
		var post_id = $(this).data('post-id');
		var user_id = $(this).data('user-id');
		var post_data = {
			action: 'like_it',
			item_id: post_id,
			user_id: user_id,
			like_it_nonce: like_it_vars.nonce
		};
		$.post(like_it_vars.ajaxurl, post_data, function(response) {
			if(response == 'liked') {
				$('.like-it').addClass('liked');
				var count_wrap = $('.like-count');
				var count = count_wrap.text();
				count_wrap.text(parseInt(count) + 1);		
			} else {
				alert(like_it_vars.error_message);
			}
		});
		return false;
	});
});