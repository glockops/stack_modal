$(document).ready(function(e) {

	$(".stack-modal").each(function(index,value){
		$(this).remove();
		$(this).appendTo('body');
	});
	
    $(".modal").on('show',function() {
		//$("iframe").hide();
		$("iframe").css("margin-left","-9999px");
		$(".modal").find("iframe").css("margin-left",0);
	});
	$(".modal").on('hide',function() {
		$("iframe").css("margin-left",0);
	});
});