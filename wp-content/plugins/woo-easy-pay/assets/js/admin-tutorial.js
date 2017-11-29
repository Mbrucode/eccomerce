jQuery(document).ready(function(){
	jQuery(document.body).on('click', '.div--tutorialHeader ul li a', function(e){
		e.preventDefault();
		var id = jQuery(this).attr('tutorial-container');
		jQuery('.onlineworldpay-explanation-container').each(function(index){
			jQuery(this).slideUp(400);
		});
		jQuery('#' + id).slideDown(400);
	});
});