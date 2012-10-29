<?php
	include_once("includes/loginCheck.php");
	
	if (!$core->logado) {
		header("Location: login.php");
		exit("Monkeys are on the way to solve this problem!");
	}
?>

<?php include_once("includes/header.php") ?>
<body>

	<div id="content">			
			
		<div id="pranchetaContentWrapper">
			<div id="pranchetaContent" class="">
				
				<div class="toolBoxWrapper">
					<div class="toolBoxOptions toolBoxOptionsScreen">
						<div class="screenRatio screenRatio-4-3 screenRatioSelected">4:3</div>
						<div class="screenRatio screenRatio-16-9">16:9</div>				
					</div>
					
					<div class="toolBoxOptions toolBoxOptionsExport">
						<pre class="brush: js"></pre>
					</div>
					
					<div class="toolBoxOptions toolBoxOptionsSave">
						<p>Your data is being saved.</p>
					</div>
					
					<div class="toolBoxOptions toolBoxOptionsOpen">
						<p>Your data is being saved.</p>
					</div>
					
					<div class="toolBox">
						<div class="toolBoxLeft">
							<img src="images/48-letter-t.png" alt="Text" class="toolText"/>
							<img src="images/48-chart.png" alt="Chart" class="toolChart"/>
							<img src="images/48-list-num.png" alt="Question" class="toolQuestion toolSmall"/>
						</div>

						<div class="toolBoxRight">
							<img src="images/48-folder-open.png" alt="Open document from server" class="toolOpen toolSmall"/>
							<img src="images/48-save.png" alt="Save document on server" class="toolSave toolSmall"/>
							<img src="images/48-eye.png" alt="Preview content on device" class="toolPreview"/>
							<img src="images/48-monitor.png" alt="Screen sizes" class="toolScreen"/>
							<img src="images/48-export.png" alt="Export data" class="toolExport toolSmall"/>
						</div>
					</div>
				</div>
				
				<div class="userBox"></div>
				
				<div class="boardContent">
					<input type="hidden" id="documentID" value="0" />
					<div class="lateralContent previewMode">
						<img src="images/48-refresh.png" alt="Refresh" class="toolRefresh">
						<img src="images/iphone.png" alt="iPhone image" class="iPhoneDevice">
						<div class="deviceContent"></div>
					</div>
				</div>
				
			</div>
		</div>
		
		<div style="clear: both;"></div>
		
		<div id="wrapper">
			<p>&reg;<a target="_blank" href="http://pedrogoes.info">Pedro Góes 2012</a> &nbsp;&nbsp;&nbsp; Todos os direitos reservados</p>
			
<!--			<ul>
				<li><a target="_blank" href="https://twitter.com/estudiotrilha">Twitter</a></li> |
				<li><a target="_blank" href="https://www.facebook.com/pages/Est%C3%BAdio-Trilha/140298506110984">Facebook</a></li> |
				<li><a target="_blank" href="https://plus.google.com/b/106431955369339447800/106431955369339447800/about">Google+</a></li>
			</ul>-->
		</div>
		
		<script type="text/javascript">
		     SyntaxHighlighter.all();
		</script>

	</div>
	
</body>
</html>