$(document).ready(function(e) {
    $(".linkOption").hide();
	//alert($("input[name=linkType]").val());
	if($("input[name=linkType]:checked").val() == 'text') { 
		$("#linkOptionText").show();
	} else {
		$("#linkOptionImage").show();
	}	
	
	$("input[name=linkType]").bind('change',function(e){
		$(".linkOption").hide();
		if($("input[name=linkType]:checked").val() == 'text') { 
			$("#linkOptionText").show();
		} else {
			$("#linkOptionImage").show();
		}
	});
	
});

ccmValidateBlockForm = function() {
	if($("input[name=linkType]:checked").val() == 'text') {
		if($("#linkText").val() == '') {
			ccm_addError(ccm_t('text-required'));
		}
	} else if($("#linkImage-fm-value").val() == '' || $("#linkImage-fm-value").val() == 0) {
		ccm_addError(ccm_t('image-required'));
	}
	
	if ($("input[name=stack]").val() == 0 || $("input[name=stack]").val() == '') { 
		ccm_addError(ccm_t('stack-required'));
	}
	return false;
}