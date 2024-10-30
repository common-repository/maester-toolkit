(function ($) {

	$(document).on('click', '.course-bookmark-icon', function (e) {
		e.preventDefault();

		var $that = $(this);
		var course_id = $that.attr('data-course-id');

		$.ajax({
			url: _tutorobject.ajaxurl,
			type: 'POST',
			data: {course_id : course_id, 'action': 'tutor_course_add_to_wishlist'},
			beforeSend: function () {
				$that.addClass('loading');
			},
			success: function (data) {
				if (data.success){
					if (data.data.status === 'added'){
						$that.addClass('wishlisted');
					}else{
						$that.removeClass('wishlisted');
					}
				}else{
					window.location = data.data.redirect_to;
				}
			},
			complete: function () {
				$that.removeClass('loading');
			}
		});
	});



	/**
	 * User Modal - Since: 1.0.0
	 */
	function openUserModal() {
		$('a[href="#open_user_modal"]').on('click', function(e) {
			e.preventDefault();
			$('#open-user-modal').fadeIn();
		});
		$('.user-modal-overlay').on('click', function () {
			$('#open-user-modal').fadeOut();
		});
		$(document).keyup(function(e) {
			if (e.key === "Escape") {
				$('#open-user-modal').fadeOut();
			}
		});
	}


	jQuery(document).ready(function() {
		openUserModal();
	});


}(jQuery))