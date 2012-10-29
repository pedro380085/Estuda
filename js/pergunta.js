$(document).ready(function() {
	

// ----------------------------------------- MENU -------------------------------------- //

	$(".inquiryMenu li").live("click", function () {
	
		var indexMenu = $(this).index();
		var indexBox = $(".inquiryBox:visible").index();
		
		// Only change if the user has selected other button
		if (indexMenu != indexBox) {
			
			$(".inquiryBox").eq(indexBox).fadeOut(500, function () {
				$(".inquiryBox").eq(indexMenu).fadeIn(500);
			});
			
			$(".inquiryMenu li").eq(indexBox).removeClass("inquiryMenuSelectedOption").end().eq(indexMenu).addClass("inquiryMenuSelectedOption");
		}
		
	});
	
// --------------------------------------- QUESTION -------------------------------------- //

	$(".inquiryBox .inquiryDatabaseList li").live("click", function () {
	
		var inquiryID = $(this).val();
		
		var $parent = $(this).parents(".inquiryBox");

		$.post('ajax.php',
		{	
			jsonQuestion: "jsonQuestion",
			questionID: inquiryID
		}, 
		function(data) {
			
			var object = JSON.parse(data)[0];
			
			$elem = $("<div></div>");
			
			$parent.find(".inquiryID").val(object.id);
			$parent.find("input[name='title']").val($elem.html(object.title).text());
			$parent.find("input[name='theme']").val($elem.html(object.theme).text());
			$parent.find("input[name='author']").val($elem.html(object.author).text());
			$parent.find("textarea[name='statement']").val($elem.html(object.statement).text());
			
			// We see if more at least one option has been set
			//if (object.alternative.length > 0) {
				$parent.find(".questionAlternativeBoxInside").html('');
			//}
			
			for (var i = 0; i < object.alternative.length; i++) {
				var size = $parent.find(".questionBoxAlternative").size()+1;

				$parent.find(".questionAlternativeBoxInside").append($("<li></li>").attr("title", object.alternative[i]).addClass('inquiryBoxAlternative').addClass('questionBoxAlternative').text("Opção "+size));
			}
			
			if (object.correctAlternative >= 0 && object.correctAlternative < $parent.find(".questionBoxAlternative").size()) {
				$parent.find(".questionBoxAlternative").eq(object.correctAlternative).addClass("inquiryBoxAlternativeCorrect");
			}

		}, 'html' );
		
	});
	

// -------------------------------------- ALTERNATIVE -------------------------------------- //

	// Cancel form submission (we will do it by ajax)
	$(".inquiryBox").submit(function () {
		return false;
	});
	
	// Change the currently selected item
	$(".inquiryBoxAlternative").live("click", function() {
		// We gotta see if the user is clicking on an already selected element
		if ($(this).hasClass("inquiryBoxAlternativeSelected")) {
			// So we can deselect it
			$(this).removeClass("inquiryBoxAlternativeSelected");
		} else {
			// Or if the user is clicking on another option and we have to change the selection
			$(".inquiryBoxAlternativeSelected").removeClass("inquiryBoxAlternativeSelected");
			$(this).addClass("inquiryBoxAlternativeSelected");	
			
			// And then load the option content on the text box
			$(".inquiryAlternativeEditBox textarea").val($(this).attr("title"));
		}

	});
	
	// Cancel any error messages
	$(".inquiryBox .inquiryAlternativeMenu li").live("click", function() {
		$(".inquiryAlternativeMenuError").text("");	
	});
	
	// Add a new item to the list
	$(".inquiryAlternativeMenuAdd").live("click", function() {
		var $parent = $(this).parents(".inquiryBox");
		// We get the size to make a nice counter
		var size = $parent.find(".inquiryBoxAlternative").size()+1;
		// Just append some text to the element ul
		$parent.find(".inquiryAlternativeBoxInside").append($("<li></li>").attr("title", 'Altere o texto da sua alternativa.').addClass('inquiryBoxAlternative').text("Opção "+size));
	});
	
	
	// Edit an item on the list
	$(".inquiryAlternativeMenuEdit").live("click", function() {
		// See if we have any selected alternative to be edited
		if ($(".inquiryBoxAlternativeSelected").size() == 0) {
			// If not, we give the user a very explanatory error
			$(".inquiryAlternativeMenuError").text("Escolha uma alternativa para editar.");	
		}
	});
	
	// Remove an item from the list
	$(".inquiryAlternativeMenuRemove").live("click", function() {
	
		if ($(".inquiryBoxAlternativeSelected").size() != 0) {
			// If we have some to delete, we just delete it!
			$(".inquiryBoxAlternativeSelected").fadeOut(200).remove();
			
			// And then we gotta filter the text for possible numeration errors
			$(".inquiryBoxAlternative").each(function (index) {
				$(this).text("Opção "+(index+1));
			});	
		} else {
			$(".inquiryAlternativeMenuError").text("Escolha uma alternativa para remover.");
		}
	});
	
	// Define the correct alternative for the question
	$(".inquiryAlternativeMenuSelectCorrectAnswer").live("click", function() {
		if ($(".inquiryBoxAlternativeSelected").size() == 1) {
			$(".inquiryBoxAlternative").removeClass("inquiryBoxAlternativeCorrect");
			$(".inquiryBoxAlternativeSelected").addClass("inquiryBoxAlternativeCorrect");
		} else {
			$(".inquiryAlternativeMenuError").text("Escolha uma alternativa como correta.");	
		}
	});
	
	// Save alternative's text changes on the go
	$(".inquiryAlternativeEditBox textarea").live("keyup", function() {
		$(".inquiryBoxAlternativeSelected").attr("title", $(this).val());
	});

	
// ---------------------------------- COMMAND --------------------------------------- //

	$(".inquiryControlBoxClean").live("click", function() {
		$(".inquiryBox input").val('');
		$(".inquiryBox textarea").text('');
		$(".inquiryBox .inquiryAlternativeBoxInside li").not(":eq(0)").remove().end().eq(0).attr("title", 'Altere o texto da sua alternativa.');
	});
	
	$(".questionControlBoxSave").live("click", function() {
		
		// Get the parent
		$parent = $(this).parents(".inquiryBox");
	
		// Serialize the data
		var vetor = $parent.find(".inquiryHeaderBox form").serializeArray();
		var inquiryID = $parent.find(".inquiryID").val();

		// And start to append the data of the components that cannot be serialized
		
		// Make a reference to all the alternatives
		$ref = $parent.find(".inquiryBoxAlternative");
		
		// Loop through them and append the result into an object
		for (var i = 0; i < $ref.size(); i++) {
			vetor[vetor.length] = {
				"name": "alternative",
				"value": $ref.eq(i).attr("title")
			}
		}
		
		// Inform the correct alternative
		vetor[vetor.length] = {
			"name": "correctAlternative",
			"value": $(".inquiryBoxAlternativeSelected").index()
		}

		// Send the requisition
		$.post('ajax.php',
		{	
			questionSubmit: "questionSubmit",
			questionID: inquiryID,
			data: vetor
		}, 
		function(data) {
			// Go to the top (if not already there)
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			// And write the content
			$(".userBox").html(data).fadeIn(1000).delay(2000).fadeOut(1000);
			
			$.post('ajax.php',
			{	
				printQuestion: "printQuestion"
			}, 
			function(data) {
				$parent.find(".inquiryDatabaseList ul").html(data);
			});
			
		}, 'html' );
	});


});