$(document).ready(function() {

	
// -------------------------------------- AJAX -------------------------------------- //

	var contentTag = "#mainContent", fileType = ".php";
	var loadingHtml = '<img src="images/128-loading.gif" class="loadingBike" alt="Carregando..." />';
	
	var newHash = "";
	var $mainContent = $(contentTag), $document = $(document), $loadingContent = $(loadingHtml);
	
	$(window).delegate("a", "click", function() {
		if ($(this).attr("href").substr(0, 7) == "http://") {
			return true;
		}
		
		if ($(this).attr("href").substr(0, 8) == "https://") {
			return true;
		}
		
		if ($(this).attr("href").substr(0, 7) == "mailto:") {
			return true;
		}
		
		if ($(this).attr("href") == "logout.php") {
			return true;
		}
		
	    window.location.hash = $(this).attr("href").replace(fileType, "");
		
	    return false;
	});
	
	$(window).bind('hashchange', function(){
		
		window.location.hash = window.location.hash.replace(fileType, "");
	
	    newHash = window.location.hash.substring(1);
	    
	    if (newHash) {
	        $mainContent.fadeOut(300, function() {
	        	$mainContent.after($loadingContent);
                $mainContent.hide().load(newHash + fileType + " " + contentTag, function() {
                    $mainContent.fadeIn(300);
                    $loadingContent.remove();
                    hashChangeWrapper(newHash);
                });
            });
	    }
	    
	});
	
	$(window).trigger('hashchange');
	
	function hashChangeWrapper(newHash) {
		$("#menuContent li.selected").removeClass("selected");
		$("." + newHash).addClass("selected");
	}
	
	
// ------------------------------------------------------------------------------------ //

// -------------------------------------- SELECT -------------------------------------- //

	var selectBoxOpen = false;

	$(document).on("click", function () {
		if (selectBoxOpen == true) {
			$(document).find(".selectBox .selectOptions").slideUp(0); // Close all open selected boxes
		}
	});

	$(".selectBox .selectSelected").live("click", function () {
		if ($(this).siblings(".selectOptions").is(":visible")) {
			$(this).siblings(".selectOptions").slideUp(0);
			selectBoxOpen == false;
		} else {
			$(document).find(".selectBox .selectOptions").slideUp(0); // Close all open selected boxes
			$(this).siblings(".selectOptions").slideDown(0); // Open the clicked select box
			selectBoxOpen == true;
		}
	});
	
	$(".selectBox .selectOptions li").live("click", function () {
		$(this).parents(".selectOptions").slideToggle(0).parents(".selectBox").find(".selectSelected li").removeClass("placeholder").replaceWith($(this).clone()[0]); // we close the select box and then load the selected option on the correspoding div
	});
	
// ------------------------------------------------------------------------------------ //

// -------------------------------------- PROJECT LIST -------------------------------- //


	$(".projectListType li").live("click", function () {
	
		var boxIndex = $(this).index();
		var other = ($(this).index() == 1) ? 0 : 1;
		
		if (!($(".projectList").eq(boxIndex).is(":visible"))) {
			$(".projectListType li").removeClass("projectListTypeSelected");
			$(this).addClass("projectListTypeSelected");
		
			$(".projectList").eq(other).fadeToggle(400, function () {
				$(".projectList").eq(boxIndex).fadeToggle(400);
			});
		}
	
	
	
	});
	
// ------------------------------------------------------------------------------------ //

});