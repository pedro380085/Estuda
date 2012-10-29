$(document).ready(function() {

// -------------------------------------- DANGEROUS -------------------------------------- //

	$(".menuDocumentation li").live("click", function () {
		
		var index = $(this).index();
		
		if ($(".optionMenuDocumentationSelected").index() != index) {
			$(".optionMenuDocumentationSelected").removeClass("optionMenuDocumentationSelected");
			$(this).addClass("optionMenuDocumentationSelected");
			
			$(".documentationBoxSelected").fadeOut(300, function () {
				$(this).removeClass("documentationBoxSelected");
				$(".documentationBox").eq(index).fadeIn(300).addClass("documentationBoxSelected");
			
			});
		}
	
	});

	
// ------------------------------------------------------------------------------------ //

});