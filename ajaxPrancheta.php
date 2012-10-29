<?php include_once("includes/loginCheck.php"); ?>
<?php

	if (!$core->logado) {
		header("Location: login.php");
		exit("Monkeys are on the way to solve this problem!");
	}
	
	// Lembre-se de fazer decode do array recebido pelo jquery


// -------------------------------------- DOCUMENTS --------------------------------------- //
	
	/**
	 * 	Saving a document (insertion and update)
	 */
	if (isset ($_POST['saveForm']) && isset ($_POST['documentID'])) {
		
		// We receive ther data
		$data = trim(htmlentities(utf8_decode($_POST['data']))); // We still gotta filter it
		$documentID = trim(htmlentities(utf8_decode($_POST['documentID'])));
		
		$insert = false;

		// Update card
		if ($documentID != "0") {

			$sql = sprintf("UPDATE document SET json = '%s' WHERE id = '%s'",
    							mysql_real_escape_string($data),
    							mysql_real_escape_string($documentID)
			);

			$insert = mysql_query($sql);

		// New card			
		} else {

			$query = "INSERT INTO document (`json`) VALUES ('$data')";
			$insert = mysql_query($query) or trigger_error(mysql_error()." ".$query);

			$documentID = mysql_insert_id();

		}
		
		// And we confirm the insertion
		if ($insert) {
			echo $documentID;
		} else {
			echo 0;
		}
		
	} else 

	/**
	 * 	Get all documents on the database
	 */
	if (isset ($_POST['showDocuments'])) {

		$query = "SELECT * FROM document";
		$result = mysql_query($query) or trigger_error(mysql_error()." ".$query);

		echo "<ul>";

		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$id = mysql_result($result, $i, "id");

			echo "<li class='documentBadge' value='$id'>$id</li>";
		}

		echo "</ul>";

	} else

	/**
	 * 	Load one specific document
	 */
	if (isset ($_POST['loadDocument']) && isset ($_POST['documentID'])) {

		$documentID = trim(htmlentities(utf8_decode($_POST['documentID'])));

		$query = "SELECT * FROM document WHERE `id` = $documentID";
		$result = mysql_query($query) or trigger_error(mysql_error()." ".$query);


		echo mysql_result($result, 0, "json");
		
	} else  
	
// ----------------------------------------------------------------------------------- //	
	{}


?>