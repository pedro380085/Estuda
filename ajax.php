<?php include_once("includes/loginCheck.php"); ?>
<?php

	if (!$core->logado) {
		header("Location: login.php");
		exit("Monkeys are on the way to solve this problem!");
	}
	
	// Lembre-se de fazer decode do array recebido pelo jquery

	// Default message
	$mensagem = "<h1 style='color:red'>Ops, algum erro ocorreu. Tente novamente!</h1>";
	
// -------------------------------------- GENERAL -------------------------------------- //
	
	if ((isset ($_POST['cellText'])) && (isset ($_POST['date']))) {
	 	$mensagem = $core->printTextForDate(htmlentities($_POST['date']));
	} else
	
// ----------------------------------------------------------------------------------- //

// -------------------------------------- MENU --------------------------------------- //
	
	if (isset ($_POST['jsonQuestion'])) {
	 	
	 	$questionID = trim(htmlentities(utf8_decode($_POST['questionID'])));
	 	
	 	$mensagem = $core->jsonQuestion($questionID);
	} else
	
	if (isset ($_POST['printQuestion'])) {
	 	
	 	$mensagem = $core->printQuestion();
	} else
	
	
	// SAVE ALL THE MEMBER DATA //
	if (isset ($_POST['questionSubmit'])) {

		// We receive ther data
		$data = $_POST['data']; // We still gotta filter it
		$questionID = trim(htmlentities(utf8_decode($_POST['questionID'])));
//		var_dump($data);
		
		$insert = false;
		
		
		$dataArray = array();
		$dataAlternative = array();
		
		// Loop through it
		for ($i = 0; $i < count($data); $i++) {
			$object = $data[$i];
			// Retrieve the values of each one
			$name = htmlentities(utf8_decode($object['name']));
			$value = htmlentities(utf8_decode($object['value']));	
			
			// There may be more than one alternative, so we must set an independent array for it
			if ($name == "alternative") {
				$dataAlternative[] = $value; // No $name because this array only refers to alternatives
			} else {
				$dataArray[$name] = $value;
			}
		}
		

		// Insert mode
		if ($questionID == "0") {
		
			$query = ("INSERT INTO $core->tableQuestion (`title`, `theme`, `author`, `statement`, `correctAlternative`) VALUES ('" . $dataArray["title"] . "', '" . $dataArray["theme"] . "', '" . $dataArray["author"] . "', '" . $dataArray["statement"] . "', '" . $dataArray["correctAlternative"] . "')");

			$insert = mysql_query($query);
			
			$id = mysql_insert_id();

	
			if ($insert) {
				for ($i = 0; $i < count($dataAlternative); $i++) {
					$insert = mysql_query("INSERT INTO $core->tableAlternative (`questionID`, `text`) VALUES ('$id', '$dataAlternative[$i]')");
				}
			}
		
			if ($insert) {
				$mensagem = "<img src='images/48-check.png'>";
			} else {
				$mensagem = "<img src='images/48-cross.png'>";
			}
		// Or update mode
		} else {
			$query = ("UPDATE $core->tableQuestion SET `title`='" . $dataArray["title"] . "', `theme`='" . $dataArray["theme"] . "', `author`='" . $dataArray["author"] . "', `statement`='" . $dataArray["statement"] . "', `correctAlternative`='" . $dataArray["correctAlternative"] . "' WHERE `id`=$questionID");

			$update = mysql_query($query);
			
			if ($update) {
				// We gotta delete before we re-insert the data
				mysql_query("DELETE FROM $core->tableAlternative WHERE `questionID`='$questionID'");

				for ($i = 0; $i < count($dataAlternative); $i++) {
					$insert = mysql_query("INSERT INTO $core->tableAlternative (`questionID`, `text`) VALUES ('$questionID', '$dataAlternative[$i]')");
				}
			
				$mensagem = "<img src='images/48-check.png'>";
			} else {
				$mensagem = "<img src='images/48-cross.png'>";
			}
		}

	} else 
	
	
// ----------------------------------------------------------------------------------- //	

	{}
	
	
	

	echo $mensagem;

?>