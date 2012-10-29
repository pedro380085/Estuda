$(document).ready(function() {

	var windowWidth = 0;
	
// ------------------------------------ JQUERY EXTEND -------------------------------------- //
	
	// Code by Paul Irish
	(function($,sr){

		// debouncing function from John Hann
		// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
		var debounce = function (func, threshold, execAsap) {
			var timeout;

			return function debounced () {
				var obj = this, args = arguments;
				function delayed () {
					if (!execAsap)
						func.apply(obj, args);
					timeout = null; 
				};

				if (timeout)
					clearTimeout(timeout);
				else if (execAsap)
					func.apply(obj, args);

				timeout = setTimeout(delayed, threshold || 100); 
			};
		}
		// smartresize 
		jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

	})(jQuery,'smartresize');

	/**
	 * For every window resize, we must be able to analyze all the windows within the board and resize them too
	 * @return {object} this
	 */
	$.fn.windowRatio =  function () {
		
//		New ratio is calculated
		var ratio = windowWidth / this.width();
		var newWidth = this.width();
		
		// We update the board itself
		this.each(function (index) {

			var width = windowWidth / ratio;
			
			// Attention to the new ratios being calculated and applied
			if ($(".screenRatioSelected").hasClass("screenRatio-4-3")) {
				$(this).animate({
					height: (width * 3 / 4)
				});
			} else if ($(".screenRatioSelected").hasClass("screenRatio-16-9")) {
				$(this).animate({
					height: (width * 9 / 16)
				});
			}
		});

		// And then all its children
		this.find(".objectWrapper").each(function (index) {
		
			var width = $(this).width() / ratio;
	
			if ($(".screenRatioSelected").hasClass("screenRatio-4-3")) {
				$(this).animate({
					height: (width * 3 / 4),
					width: width
				});
			} else if ($(".screenRatioSelected").hasClass("screenRatio-16-9")) {
				$(this).animate({
					height: (width * 9 / 16),
					width: width
				});
			}
		});
		
		windowWidth = newWidth;

		if ($(".lateralContent").hasClass("previewMode")) {
			$(this).printDataOnDevice();
		}


		return this;
	};

	/**
	 * Export data as JSON
	 * @param  {Function} fn Code to be called on complete
	 * @return {object}      this
	 */
	$.fn.exportData =  function (fn) {
		
		var output = {};

		output.ratio = this.height() / this.width();

		output.size = {
			width: this.width(),
			height: this.height()
		};

		output.items = [];


		this.find(".objectWrapper").each(function () {
			
			var outputSize = output.items.length;
			var position = $(this).position();

			// We must define it as an object
			output.items[outputSize] = {};

			output.items[outputSize].origin = {
				x: position.left,
				y: position.top
			};

			output.items[outputSize].size = {
				width: $(this).width(),
				height: $(this).height()
			};

			output.items[outputSize].type = "text";
			output.items[outputSize].content = $(this).find("textarea").wysiwyg("getContent");
			output.items[outputSize].zIndex = parseInt($(this).css("z-index"));

		});

		// Then we can call the callback
		fn.call(this, JSON.stringify(output, null, '\t'));
	
		return this;
	};
	
	/**
	 * Load JSON as data
	 * @param  {string}      data     Json string 
	 * @return {object}      this
	 */
	$.fn.loadData =  function (data) {

		var json = JSON.parse(data);
		
		this.height(json.size.height);
		this.width(json.size.width);

		for (var i = 0; i < json.items.length; i++) {
			$(".toolBox .toolText").trigger("click");
		}

		var $object = $(".objectWrapper");

		for (var i = 0; i < json.items.length; i++) {
			$object.eq(i).css({
				width: json.items[i].size.width,
				height: json.items[i].size.height,
				left: json.items[i].origin.x,
				top: json.items[i].origin.y,
				"z-index": json.items[i].zIndex,
			}).find("textarea").wysiwyg("setContent", json.items[i].content);
		}
	
		return this;
	};

	/**
	 * Highlight our code
	 * @return {object} this
	 */
	$.fn.highLight =  function () {
		SyntaxHighlighter.highlight();
		
		return this;
	};

	/**
	 * Print data (content) of the board on the device 	
	 * @return {object}      this
	 */
	$.fn.printDataOnDevice = function () {

		$device = $(".deviceContent");
		$board = $(".boardContent");

		// We first get our ratios
		var widthRatio = $device.width() / $board.width();
		var heightRatio = $device.height() / $board.height();

		// Delete any elements inside the screen
		$device.find("*").remove();

		// Then we can loop through the elements and append them on the device screen
		$board.find(".objectWrapper").each(function () {

			// We make a deep copy of it and append to the device screen
			$copy = $(document.createElement("p")).html($(this).find("textarea").wysiwyg("getContent")).appendTo($device).css("position", "absolute");
			
			var position = $(this).position();

			$copy.css("left", position.left * widthRatio);
			$copy.css("top", position.top * heightRatio);

			$copy.css("width", $(this).width() * widthRatio);
			$copy.css("height", $(this).height() * heightRatio);

			$copy.css("font-size",  widthRatio * 100 + "%");
		});



		return this;

	};

	/**
	 * Call the function upon start
	 * @return {null}
	 */
	$(window).load(function () {
		windowWidth = $(".boardContent").width();
		$(".boardContent").windowRatio();
	});

// ----------------------------------------- MENU -------------------------------------- //

	/**
	 * Recalculates the window size after the resizing has ended
	 * @param  {object} event
	 * @return {null}
	 */
	$(window).smartresize(function (event) {
		// Only bubbles if target is the same as origin
		if (this === event.target) {
			$(".boardContent").windowRatio();	
		}
	});

	/**
	 * Update device screen everytime the user change some on the board
	 * @return {null}
	 */
	$(".boardContent").live("click", function () {
     	console.log("oi");
     });
	
	/**
	 * Tool to export data as JSON
	 * @return {null}
	 */
	$(".toolBox .toolExport").live("click", function () {
     	$(".boardContent").exportData(function (text) {
     		var $pre = $(document.createElement("pre")).addClass("brush: js").text(text);
     		$(".toolBoxOptionsExport").html($pre).highLight().slideToggle(400);
     	});
     });

	/**
	 * Tool to select screen size
	 * @return {null}
	 */
	$(".toolBox .toolScreen").live("click", function () {
		$(".toolBoxOptionsScreen").slideToggle(400);
	});

	/**
	 * Tool to preview content on device
	 * @return {null}
	 */
	$(".toolBox .toolPreview").live("click", function () {
	
		var smallShift = 0.05, bigShift = 1.1;

		// Toogle board mode
		$lateral = $(".lateralContent").toggleClass("previewMode");

		if (!($lateral.hasClass("previewMode"))) {
			// We shift it a bit to the left
			$lateral.animate({
				right: $lateral.outerWidth() * smallShift
			}, 250, function() {
				// And then completely hide it 
				$lateral.animate({
					right: - $lateral.outerWidth() * bigShift
				}, 300);
			});
		} else {
			// We shift it to the right
			$lateral.animate({
				right: $lateral.outerWidth() * smallShift
			}, 300, function() {
				// And then adjust the position
				$lateral.animate({
					right: 0
				}, 250);
			});
		}

		$(this).printDataOnDevice();
		
	});

	/**
	 * Tool to save the document
	 * @return {null}
	 */
	$(".toolBox .toolSave").live("click", function () {
		$(".boardContent").exportData(function (text) {
     		$ref = this;

     		// Get the documentID
     		var documentID = this.find("#documentID").val();

     		// After we have saved, we can successfully send it to our server
     		$.post('ajaxPrancheta.php',
				{	// We are gonna roll it down according to the badge content flow (so if the flow changes, the code has to change)
					saveForm: "saveForm",
					documentID: documentID,
					data: text
				},
				function(data) {

					var $options = $(".toolBoxOptionsSave").stop(true, true);

					if (data == "0") {
						$options.html("<p>Seu documento infelizmente não foi salvo.").slideDown(400);
					} else {
						$options.html("<p>Seu documento foi salvo com id <b>" + data + "</b>.").slideDown(400);
						$ref.find("#documentID").val(data);
					}

					// Slide it back after 6s
					$options.delay(6000).slideUp(400);
					
				}, 'html' );
     	});
	});

	/**
	 * Tool to open the documents
	 * @return {null}
	 */
	$(".toolBox .toolOpen").live("click", function () {
 		$board = $("boardContent");

 		// Get the documentID
 		var documentID = $board.find("#documentID").val();

 		// After we have saved, we can successfully send it to our server
 		$.post('ajaxPrancheta.php',
			{	// We are gonna roll it down according to the badge content flow (so if the flow changes, the code has to change)
				showDocuments: "showDocuments",
			},
			function(data) {
				$(".toolBoxOptionsOpen").html(data).slideDown(400);
			}, 'html' );

	});


	/**
	 * Tool to load the documents from the server
	 * @return {null}
	 */
	$(".toolBoxWrapper .documentBadge").live("click", function () {

 		// Get the documentID
 		var documentID = $(this).val();

 		// After we have saved, we can successfully send it to our server
 		$.post('ajaxPrancheta.php',
			{	// We are gonna roll it down according to the badge content flow (so if the flow changes, the code has to change)
				loadDocument: "loadDocument",
				documentID: documentID
			},
			function(data) {
				$(".toolBoxOptionsOpen").html(data).slideDown(400);
				$(".boardContent").loadData($("<p></p>").html(data).text()).find("#documentID").val(documentID);
			}, 'html' );
	});
	

	/**
	 * New screen ratio has been clicked
	 * @return {null}
	 */
	$(".toolBoxWrapper .screenRatio").live("click", function () {
	
		if ( ! ($(this).hasClass("screenRatioSelected"))) {
			$(this).siblings(".screenRatioSelected").removeClass("screenRatioSelected");
			$(this).addClass("screenRatioSelected");

			var $boardContent = $(".boardContent");
			var width = $boardContent.width();

			if ($(this).hasClass("screenRatio-4-3")) {
				$boardContent.animate({
					height: (width * 3 / 4)
				});
			} else if ($(this).hasClass("screenRatio-16-9")) {
				$boardContent.animate({
					height: (width * 9 / 16)
				});
			}

			$(".toolBox .toolScreen").trigger("click");
		}
		
	});

	/**
	 * Tool to add text
	 * @return {null}
	 */
	$(".toolBox .toolText").live("click", function () {
	
	
		var $textarea = $(document.createElement("textarea"))
			.addClass("objectBox objectTool")
			.attr("rows", 5)
			.attr("cols", 20);
			
		var $objectWrapper = $(document.createElement("div"))
			.addClass("objectWrapper")
			.html($textarea)
			.draggable({
				containment: ".boardContent",
				scroll: false 
			}).resizable({
				start: function(event, ui) { 	
					$(ui.item).addClass("isResizing");
				},
				stop: function(event, ui) { 	
					$(ui.item).removeClass("isResizing");
				}
			});
			
		$(".boardContent").append($objectWrapper);
		
		$textarea.wysiwyg({
			resizeOptions: false,
			initialContent: "<p>Insira o texto aqui</p>",
//			events: {
//			    resize: function(event) {
//			        alert("f");
//			    }
//			},

			controls: {
				html: { visible: false },
				insertImage: { visible: false },
				indexUp: { visible: true, css: { class: 'icon-hand-up'}, tooltip: "Aumentar index", groupIndex: 567, exec: function () {
					$(this.element).parents(".objectWrapper").css("z-index", parseInt($(this.element).parents(".objectWrapper").css("z-index"), 10) + 1);
					//alert(this.getContent());
				} },
				indexDown: { visible: true, css: { class: 'icon-hand-down'}, tooltip: "Diminuir index", groupIndex: 567, exec: function () {
					$(this.element).parents(".objectWrapper").css("z-index", parseInt($(this.element).parents(".objectWrapper").css("z-index"), 10) - 1);
				} }
			}
		});
		
		
		$objectWrapper.find(".wysiwyg").css("width", "100%").css("height", "100%").css("overflow", "hidden");
		$objectWrapper.find("iframe").css("width", "100%").css("height", "95%");
//		$objectWrapper.find("iframe").attr("disabled", "true");
	});

	/**
	 * Tool to reload the device content
	 * @return {null}
	 */
	$(".toolRefresh").live("click", function () {
		$(this).printDataOnDevice();
	});
	

});