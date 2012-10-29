<?php include_once("../includes/loginCheck.php"); ?>
<?php 

//	$url = explode(".", $_SERVER["SERVER_NAME"]);
//	$position = array_search("negociopresente", $url);
//	
//	
//	if ($position) {
//		if ($url[$position-1] != "developer") {
//			header("Location: http://developer.negociopresente.com/");
//		}
//	}
 ?><!--

	SISTEMA CRIADO POR PEDRO GÓES (pedrogoes.info)
	
	COMO SEMPRE, DEDICADO A MEMÓRIA DO MEU AMADO AVÔ

-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Estuda Developer - Acessar seus dados nunca foi tão fácil!</title>
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<?php if ($globalDev == 1) { ?>
	
	<script src="../js/jquery-1.7.2.min.js" type="text/javascript"></script>
	<script src="../js/jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script>
	
	<script src="../js/default.js" type="text/javascript"></script>
	<script src="../js/developer.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../css/default.css" type="text/css" />
	<link rel="stylesheet" href="../css/developer.css" type="text/css" />
	
	<?php } else { ?>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="../js/jquery-1.7.2.min.js"%3E%3C/script%3E'))</script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script>!window.jQuery.ui && document.write(unescape('%3Cscript src="../js/jquery-ui-1.8.21.custom.min.js"%3E%3C/script%3E'))</script>
	
	<script src="../js/default.min.js" type="text/javascript"></script>
	<script src="../js/developer.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../css/default.min.css" type="text/css" />
	<link rel="stylesheet" href="../css/developer.css" type="text/css" />
	
	<?php } ?>
	
	<link rel="stylesheet" href="../css/jquery-ui-1.8.21.custom.min.css" type="text/css" />
	<script src="../js/analytics.js" type="text/javascript"></script>
	
	<link href="../favicon.ico" rel="icon" type="image/x-icon" />

</head>
<body>

	<div class="bar top">
		<div class="barWrapper">
			<ul class="leftBar">
				<a href="../index.php" target="_blank"><li>Estuda</li></a>
			</ul>
			
			<ul class="rightBar">
			
				<li onclick="" class="userLoginLeading first">Developer</li>
				
			</ul>
		</div>
	</div>
	
	<div class="content">
		
		<div class="features">
		
			<div class="featureBox header">
				<p class="headline">Sua API. Nossa API.</p>
				<p class="sub">Acessar seus dados nunca foi tão fácil.</p>
			</div>
						
			<div style="clear: both;"></div>
	
		</div>
		
		<div class="documentation">
			<div class="menuDocumentation">
				<ul>
<!--					<li>Início</li>-->
					<li class="optionMenuDocumentationSelected"><b>Como usar</b></li>
					<li>Login</li>
					<li>Documento</li>
				</ul>
			</div>
			<div class="contentDocumentation">


<!--				COMO USAR-->
				<div class="documentationBox documentationBoxSelected">
					<h2>Uso</h2>

					<p>Para utilizar a API do Negócio Presente, basta consultar nossa documentação disponível a esquerda. Abaixo temos um exemplo que será utilizado posteriormente para explicar o envio de requisições.</p>
					
					<h3>URL oficial</h3>
					<pre>https://negociopresente.com.br/developer/api/</pre>
					<br />
					
					<h3>Exemplo de documentação</h3>
					<div class="documentationFunctionBox">
						<p class="documentFunctionName">login.signIn(<b>enterpriseID</b>)</p>

						<p class="documentFunctionDescription">Loga um usuário no sistema e retorna um <i>tokenID</i> que será utilizado para todas as outras operações no sistema.</p>

						<div class="documentationFunctionParametersBox">
							<p><b>enterpriseID</b><sub>GET</sub> : id da empresa</p>
							<p><b>username</b><sub>GET</sub> : nome de usuário</p>
							<p><b>password</b><sub>GET</sub> : senha do usuário</p>

						</div>

					</div>
					
					<h3>Exemplo de requisição</h3>
					<pre>https://negociopresente.com.br/developer/api/?method=login.signIn&username=Fulano&password=123456</pre>	
					<br />
					
					<h3>Explicação</h3>
					<p>Existem três seções demarcadas: <b>cabeçalho, retorno e parâmetros</b>, cada qual sendo explicada separadamente:</p>
						<ul>
							<li>O <b>cabeçalho</b> (login.signIn) apresenta a chamada, composto de um <u>namespace</u> (login) e seu <u>método</u> (signIn). A chamada deve ser enviada ao servidor através do parâmetro method via GET, para que seja identificada o tipo de informação que o cliente deseja.</li>
							<li>O <b>retorno</b> explica quais dados serão retornados, podendo o usuário sempre pode fazer uma requisição de teste para ver quais serão os dados de retorno.</li>
							<li>Os <b>parâmetros</b> (enterpriseID, username, password) mostram seu significado e por qual método devem ser enviados, variando sempre entre GET e POST.</li>
						</ul>
					<h3>Notas</h3>
					<p>A API do Negócio Presente utiliza um RPC-REST híbrido, utilizando o POST carregado como forma de enviar dados que necessitem de mais espaço. Além disso, todas as requisições são encriptadas em 256 bit por padrão.</p>
					
				</div>

<!--				LOGIN-->
				<div class="documentationBox">
					<h2>Login</h2>

					<p>O conteúdo abaixo é referente as ferramentas de login.</p>

					<div class="documentationFunctionBox">
						<p class="documentFunctionName">login.signIn(<b>enterpriseID</b>)</p>

						<p class="documentFunctionDescription">Loga um usuário no sistema e retorna um <i>tokenID</i> que será utilizado para todas as outras operações no sistema.</p>

						<div class="documentationFunctionParametersBox">
							<p><b>enterpriseID</b><sub>GET</sub> : id da empresa</p>
							<p><b>username</b><sub>GET</sub> : nome de usuário</p>
							<p><b>password</b><sub>GET</sub> : senha do usuário</p>

						</div>

					</div>

					<div class="documentationFunctionBox">
						<p class="documentFunctionName">login.getEnterprises()</p>

						<p class="documentFunctionDescription">Retorna uma lista das empresas cadastradas no sistema.</p>

					</div>

				</div>

<!--				HOMEPAGE-->
				<div class="documentationBox">
					<h2>HomePage</h2>
					
					<p>O conteúdo abaixo é referente aos documentos.</p>

					<div class="documentationFunctionBox">
						<p class="documentFunctionName">document.getAllDocuments()</p>

						<p class="documentFunctionDescription">Retorna todos os <i>documentID</i> dos arquivos presentes no servidor.</p>


					</div>
					
					<div class="documentationFunctionBox">
						<p class="documentFunctionName">document.getSingleDocument(<b>documentID</b>)</p>

						<p class="documentFunctionDescription">Retorna um objeto JSON para o <i>documentID</i>.</p>

						<div class="documentationFunctionParametersBox">
							<p><b>documentID</b><sub>GET</sub> : id do documento</p>

						</div>

					</div>

				</div>


				<div class="demoDocumentation"></div>

			</div>
		</div>

		<div id="wrapper">
			<p>&reg;<a target="_blank" href="http://estudiotrilha.com.br">Estúdio Trilha 2012</a> &nbsp;&nbsp;&nbsp; Todos os direitos reservados</p>
		</div>
	</div>

</body>
</html>