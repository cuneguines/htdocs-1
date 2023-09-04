$(document).ready(function(){
	$('button.button_group').click(function(){
		$('button.button_group').not($(this)).removeClass('active');
		$(this).addClass('active');
		$('.page_buttons button').hide().each(function(){
			($(this).attr('class').split(' ')).slice(1).forEach(element => element === $('button.button_group.active').attr('id') ?  $(this).show() : null)
		});
	});

	
});
