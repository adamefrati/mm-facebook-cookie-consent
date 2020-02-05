jQuery(document).ready(function($){
	$('.colorpicker').wpColorPicker();
	$('.expandContent').click(function(){
        $('.showMe').toggle();
    });
});