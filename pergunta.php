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
	
<!--		<div id="menuContentWrapper">
			<div id="menuContent" class="centralize">
				<ul>
					<a href="index.php"><li class="index selected">Home</li></a>
					<a href="projeto.php"><li class="projeto">Projeto</li></a>
					<a href="sobre.php"><li class="sobre">Equipe</li></a>
					<a href="contato.php"><li class="contato">Contato</li></a>
				</ul>
			</div>
		</div>

		

		<div id="logoContentWrapper">
			<div id="logoContent" class="centralize">

				
				<img src="images/chalkboard.png" class="androidCell" alt="Android" />
				
				<div id="logoContentTextWrapper">
				
					<h1>Projeto Estuda</h1>
					
					<p class="header">Ensino de qualidade com tecnologia de ponta, disponível para todos.</p>
				</div>
			</div>
		</div>
	-->
	
		<div id="leadingContentWrapper">
			<div id="leadingContent" class="centralize">
				<ul class="inquiryMenu">
					<li class="inquiryMenuQuestionOption inquiryMenuSelectedOption">Criar questionário</li>
					<li class="inquiryMenuListOption">Criar lista</li>
				</ul>
			</div>
		</div>
			
			
		<div id="mainContentWrapper">
			<div id="mainContent" class="centralize">
				<div class="userBox"></div>
				
				
				<div class="questionBoxWrapper">
					<!--  QUESTION BOX  -->
					<div class="questionBox inquiryBox">
					
						<div class="inquiryDatabaseList">
							<ul>
								<?php $core->printQuestion(); ?>
							</ul>
						
						</div>
					
						<input type="hidden" name="inquiryID" class="inquiryID" value="0" />
						<div class="inquiryHeaderBox">
							<form method="post" action="#">
								<p><span class="inputTitle">Título</span><input placeholder="Título" type="text" name="title" value="" /></p>
								<p><span class="inputTitle">Tema</span><input placeholder="Tema" type="text" name="theme" value="" /></p>
								<p><span class="inputTitle">Autor</span><input placeholder="Autor" type="text" name="author" value="" /></p>
								<p><span class="inputTitle">Enunciado</span><textarea rows="7" name="statement"></textarea></p>
							</form>
						</div>
						
						<div class="inquiryAlternativeBox questionAlternativeBox">
							<p>Alternativas</p>
							<div class="inquiryAlternativeBoxInside questionAlternativeBoxInside">
								<ul>
									<li title="Altere o texto da sua alternativa." class="inquiryBoxAlternative questionBoxAlternative">Opção 1</li>
								</ul>
							</div>
							
							<ul class="inquiryAlternativeMenu">
								<li class="inquiryAlternativeMenuAdd">Adicionar</li>
								<li class="inquiryAlternativeMenuEdit">Editar</li>
								<li class="inquiryAlternativeMenuRemove">Remover</li>
								<li class="inquiryAlternativeMenuSelectCorrectAnswer">Definir como opção correta</li>
							</ul>
							
							<div class="inquiryAlternativeMenuError"></div>
							
							<div class="inquiryAlternativeEditBox">
								<p>Texto da alternativa</p>
								<textarea rows="7"></textarea>
							</div>
						</div>
						
						<div style="clear: both;"></div>
						
						<div class="inquiryControlBox">
							<li class="inquiryControlBoxSave questionControlBoxSave">Salvar</li>
							<li class="inquiryControlBoxClean">Limpar</li>
						</div>
						
					</div>
	
					<!--  LIST BOX 	-->
					<div class="listBox inquiryBox">
						<input type="hidden" name="inquiryID" class="inquiryID" value="0" />
						<div class="inquiryHeaderBox">
							<form method="post" action="#">
								<p><span class="inputTitle">Título</span><input placeholder="Título" type="text" name="title" value="" /></p>
								<p><span class="inputTitle">Tema</span><input placeholder="Tema" type="text" name="theme" value="" /></p>
								<p><span class="inputTitle">Autor</span><input placeholder="Autor" type="text" name="author" value="" /></p>
								<p><span class="inputTitle">Observação</span><textarea rows="7" name="observation"></textarea></p>
							</form>
						</div>
						
						<div class="inquiryAlternativeBox listAlternativeBox">
							<p>Questões</p>
							<div class="inquiryAlternativeBoxInside listAlternativeBoxInside">
								<ul>
									<li title="Altere o texto da sua alternativa." class="inquiryBoxAlternative listBoxAlternative">Opção 1</li>
								</ul>
							</div>
							
							<ul class="inquiryAlternativeMenu">
								<li class="inquiryAlternativeMenuAdd">Adicionar</li>
								<li class="inquiryAlternativeMenuEdit">Editar</li>
								<li class="inquiryAlternativeMenuRemove">Remover</li>
								<li class="inquiryAlternativeMenuSelectCorrectAnswer">Definir como opção correta</li>
							</ul>
							
							<div class="inquiryAlternativeMenuError"></div>
							
							<div class="inquiryAlternativeEditBox">
								<p>Texto da alternativa</p>
								<textarea rows="7"></textarea>
							</div>
						</div>
						
						<div style="clear: both;"></div>
						
						<div class="inquiryControlBox">
							<li class="inquiryControlBoxSave">Salvar</li>
							<li class="inquiryControlBoxClean">Limpar</li>
						</div>
						
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

	</div>
	
</body>
</html>