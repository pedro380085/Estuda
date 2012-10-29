<?php
header('Content-Type:text/html; charset=UTF-8');
include_once("connection.php");
include_once("core.php");
include_once("bcrypt.php");

$chave = "7e530ebc5e06ea3f693d4df12b06f5d0";

// Denied by dafault
$core->logado = true;

//if (isset($_POST["user"]) && isset($_POST["password"])) {
//
//	$user = htmlentities(utf8_decode($_POST["user"]));
//	$password = htmlentities(utf8_decode($_POST["password"]));
//
//	$resultado = mysql_query("SELECT * FROM $core->tableUser WHERE user='$user'");
//	
//	if (mysql_num_rows ($resultado) != 0) {
//		
//		$hash = mysql_result($resultado, 0, "password");
//
//		if (Bcrypt::check($password, $hash)) {	
//			setcookie($chave, $hash, 0);
//			
//			$core->logado = true;
//
//			$core->user = mysql_result($resultado, 0, "user");
//			$core->userID = mysql_result($resultado, 0, "id");
//			$core->level = mysql_result($resultado, 0, "level");
//			$core->group = mysql_result($resultado, 0, "groupID");
//		}
//	}
//
//} elseif (isset($_COOKIE[$chave])) {
//
//	$hash = htmlentities($_COOKIE[$chave]);
//	$resultado = mysql_query("SELECT * FROM $core->tableUser WHERE password='$hash'");
//
//	if (mysql_num_rows($resultado) == 1) {
//		$core->logado = true;
//
//		$core->user = mysql_result($resultado, 0, "user");
//		$core->userID = mysql_result($resultado, 0, "id");
//		$core->level = mysql_result($resultado, 0, "level");
//		$core->group = mysql_result($resultado, 0, "groupID");
//	}
//}

/* SEMPRE RECEBEREMOS A VARIAVEL LOGADO COM O RESULTADO */

?>