<?php

	class Core {
        public $now;
        public $monday;
        
        public $tableAlternative = "alternative";
		public $tableQuestion = "question";
		
		
        public $logado = false;
        public $user = "";
        public $level = 0;
		public $group = 0;
        
        public $weekFromNow = 0;
        
        public $authenticatedMAC = false;
        private $allowedMAC = array("f4:6d:4:d6:7f:f");
        
        public function __construct() {
        	$this->now = getdate();
        	$this->monday = date("c", mktime(8, 0, 0, $this->now["mon"], $this->now["mday"] - $this->now["wday"] + 1, $this->now["year"]));
        	
        	//$this->authenticatedMAC = $this->getMac();
        }
        
        public function getMac(){

	        $ipAddress = $_SERVER['REMOTE_ADDR'];
	        $macAddress = "33";
	        
	        if ($ipAddress == "::1") { // This is the localhost
	        	return true;
	        }
	        
	        #run the external command, break output into lines
	        //$arp = exec("arp $ipAddress");
	        $lines = explode("\n", $arp);
	        //print_r($lines);
	        
	        #look for the output line describing our IP address
	        foreach($lines as $line) {
	           $cols = preg_split('/\s+/', trim($line));
	           $macAddress = $cols[3];	           
	        }
	        
	     	return (in_array($macAddress, $this->allowedMAC));
        }
        
        public function userForId($id) {
        	$result = mysql_query("SELECT * FROM $this->tableUser WHERE id='$id'");
        	return mysql_result($result, 0, "user");
        }
        
        public function idForUser($user) {
        	$result = mysql_query("SELECT * FROM $this->tableUser WHERE user='$user'");
        	return mysql_result($result, 0, "id");
        }
        
// -------------------------------------- PRESENCA -------------------------------------- //	

// -------------------------------------- -------- -------------------------------------- //	

// -------------------------------------- -------- -------------------------------------- //	
		
		public function printQuestion() {
		
			$result = mysql_query("SELECT * FROM $this->tableQuestion");
			
			for ($i = 0; $i < mysql_num_rows($result); $i++) {
				
				$id = mysql_result($result, $i, "id");
				$title = mysql_result($result, $i, "title");
				$author = mysql_result($result, $i, "author");
				$theme = mysql_result($result, $i, "theme");
				$statement = mysql_result($result, $i, "statement");

			?>
			
			<li value="<?php echo $id ?>">
				<div class="inquiryDatabaseListMetaWrapperLeft">
					<p class="inquiryDatabaseListTitle"><?php echo $title ?></p>
					<p class="inquiryDatabaseListAuthor"><?php echo $author ?></p>
					<p class="inquiryDatabaseListTheme"><?php echo $theme ?></p>
				</div>
				<div class="inquiryDatabaseListMetaWrapperRight">
					<p class="inquiryDatabaseListDescription"><?php echo $statement ?></p>
				</div>
			</li>
			
			
			<?php
			
			}
		}
		
		public function jsonQuestion($id = null) {
			
			$result = 0;
			
			if ($id == null) {
				$result = mysql_query("SELECT * FROM $this->tableQuestion");
			} else {
				$result = mysql_query("SELECT * FROM $this->tableQuestion WHERE `id`=$id");
			}

			$data = array();
			
			// We loop through all the rows
			for ($i = 0; $i < mysql_num_rows($result); $i++) {
				// Getting the results as arrays
				$row = mysql_fetch_row($result);
				// And then creating bindings by their variable name
				for ($j = 0; $j < mysql_num_fields($result); $j++) {
					$field = mysql_field_name($result, $j);
					$data[$i][$field] = utf8_encode($row[$j]);
				}
				
				// Now we must select the alternatives
				
				$id = mysql_result($result, $i, "id");

				$resultAlternative = mysql_query("SELECT * FROM $this->tableAlternative WHERE `questionID` = '$id'");
				
				for ($j = 0; $j < mysql_num_rows($resultAlternative); $j++) {
					$rowAlternative = mysql_result($resultAlternative, $j, "text");
					
					$data[$i]["alternative"][$j] = utf8_encode($rowAlternative);
				}
				
			}
			
			echo json_encode($data);
		}
   		
		
    }

	// Instantiate the var
	$core = new Core();
	

	

?>