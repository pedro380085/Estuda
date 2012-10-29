<?php include_once("../../includes/loginCheck.php"); ?>
<?php
	
	// Lembre-se de fazer decode do array recebido pelo jquery
	
	if (!function_exists('http_response_code')) {
        function http_response_code($code = NULL) {

            if ($code !== NULL) {

                switch ($code) {
                    case 100: $text = 'Continue'; break;
                    case 101: $text = 'Switching Protocols'; break;
                    case 200: $text = 'OK'; break;
                    case 201: $text = 'Created'; break;
                    case 202: $text = 'Accepted'; break;
                    case 203: $text = 'Non-Authoritative Information'; break;
                    case 204: $text = 'No Content'; break;
                    case 205: $text = 'Reset Content'; break;
                    case 206: $text = 'Partial Content'; break;
                    case 300: $text = 'Multiple Choices'; break;
                    case 301: $text = 'Moved Permanently'; break;
                    case 302: $text = 'Moved Temporarily'; break;
                    case 303: $text = 'See Other'; break;
                    case 304: $text = 'Not Modified'; break;
                    case 305: $text = 'Use Proxy'; break;
                    case 400: $text = 'Bad Request'; break;
                    case 401: $text = 'Unauthorized'; break;
                    case 402: $text = 'Payment Required'; break;
                    case 403: $text = 'Forbidden'; break;
                    case 404: $text = 'Not Found'; break;
                    case 405: $text = 'Method Not Allowed'; break;
                    case 406: $text = 'Not Acceptable'; break;
                    case 407: $text = 'Proxy Authentication Required'; break;
                    case 408: $text = 'Request Time-out'; break;
                    case 409: $text = 'Conflict'; break;
                    case 410: $text = 'Gone'; break;
                    case 411: $text = 'Length Required'; break;
                    case 412: $text = 'Precondition Failed'; break;
                    case 413: $text = 'Request Entity Too Large'; break;
                    case 414: $text = 'Request-URI Too Large'; break;
                    case 415: $text = 'Unsupported Media Type'; break;
                    case 500: $text = 'Internal Server Error'; break;
                    case 501: $text = 'Not Implemented'; break;
                    case 502: $text = 'Bad Gateway'; break;
                    case 503: $text = 'Service Unavailable'; break;
                    case 504: $text = 'Gateway Time-out'; break;
                    case 505: $text = 'HTTP Version not supported'; break;
                    default:
                        exit('Unknown http status code "' . htmlentities($code) . '"');
                    break;
                }

                $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

                header($protocol . ' ' . $code . ' ' . $text);

                $GLOBALS['http_response_code'] = $code;

            } else {

                $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

            }

            return $code;

        }
    }
	
	// First, let's get the method that the user is using (empty by default)
	if (isset ($_GET['method'])) {
		$fullMethod = trim(htmlentities(utf8_decode($_GET['method'])));

		// Then we can split it right in the middle to get the namespace first
		$splitted = explode(".", $fullMethod);

		if (count($splitted) == 2) {
			$namespace = strtolower($splitted[0]);
			$method = $splitted[1];
		} else {
			// If we found an error (the user has provided a wrong method name), we return a bad request status code
			http_response_code(400);
		}
	} else {
		http_response_code(400);
	}

	// If the namespace is not login, we can already set the tokenID (all operations will need them)
	if ($namespace !== "login") {
		// We make sure the user has provided it, otherwise we can already deny the request
		if (isset ($_GET['tokenID'])) {
			$tokenID = trim(htmlentities(utf8_decode($_GET['tokenID'])));

			$resultado = mysql_query("SELECT * FROM $core->tableUser WHERE `password`='$tokenID'");

			if (mysql_num_rows ($resultado) != 0) {
				$core->logado = true;
				
				$core->enterpriseID = mysql_result($resultado, 0, "enterpriseID");
				$core->user = mysql_result($resultado, 0, "user");
				$core->userID = mysql_result($resultado, 0, "id");
				$core->level = mysql_result($resultado, 0, "level");
				$core->group = mysql_result($resultado, 0, "groupID");
			} else {
				// If the tokenID hasn't been found, we just deny the request
				http_response_code(401);
			}
			
		} else {
			http_response_code(400);
		}
	}
	

// -------------------------------------- LOGIN --------------------------------------- //	
	
	if ($namespace === "login") {

		if ($method === "signIn") {
		
			if (isset ($_GET['username']) && isset ($_GET['password'])) {
				$username = trim(htmlentities(utf8_decode($_GET['username'])));
				$password = trim(htmlentities(utf8_decode($_GET['password'])));
				
				$resultado = mysql_query("SELECT * FROM $core->tableUser WHERE user='$username'");
					
				if (mysql_num_rows ($resultado) != 0) {
					
					$hash = mysql_result($resultado, 0, "password");
			
					if (Bcrypt::check($password, $hash)) {	
						echo $hash;
					} else {
						http_response_code(401);
					}
				} else {
					// If the tokenID hasn't been found, we just deny the request
					http_response_code(401);
				}
			} else {
				http_response_code(400);
			}
		} else 
		
		if ($method === "signIn") {
			
			$userName = trim(htmlentities(utf8_decode($_GET['userName'])));
			$password = trim(htmlentities(utf8_decode($_GET['password'])));
			
			$resultado = mysql_query("SELECT * FROM $core->tableUser WHERE user='$userName'");
				
			if (mysql_num_rows ($resultado) != 0) {
				
				$hash = mysql_result($resultado, 0, "password");
		
				if (Bcrypt::check($password, $hash)) {	
					echo $hash;
				}
			}
		} else
	
	{}} else
	
// ------------------------------------------------------------------------------------------- //


// -------------------------------------- CLIENTS --------------------------------------- //

	if ($namespace === "client") {
	
		if ($method === "getNumberOfClients") {

			echo $core->informationCountForEnterpriseID($core->tableClient, $core->enterpriseID);
			
		} else
		
		if ($method === "getClients") {

			echo $core->informationForEnterpriseID($core->tableClient, $core->enterpriseID);
			
		} else 
		
		if ($method === "getSingleClient") {
			if (isset ($_GET['clientID'])) {
				$clientID = trim(htmlentities(utf8_decode($_GET['clientID'])));
						
				echo $core->informationForEnterpriseIDForUniqueID($core->tableClient, $core->enterpriseID, $clientID);
			} else {
				http_response_code(400);
			}

		} else 
		
		if ($method === "createMember") {
			if (isset ($_GET['seconds'])) {
				$delay = trim(htmlentities(utf8_decode($_GET['seconds'])));
				
				echo $core->notificationsForIDWithDelay($core->userID, $delay);
			} else {
				http_response_code(400);
			}
			
		} else 
		
		if ($method === "updateMember") {
			
			if (isset ($_GET['seconds'])) {
				$delay = trim(htmlentities(utf8_decode($_GET['seconds'])));
			
				echo $core->newNotificationsForIDWithDelay($core->userID, $delay);
			} else {
				http_response_code(400);
			}
			
		} else
		
	{ http_response_code(501); }} else
	
// ------------------------------------------------------------------------------------------- //

// ----------------------------------------- CONSULTANTS ----------------------------------------- //

	if ($namespace === "consultant") {
		
		if ($method === "getNumberOfConsultants") {

			echo $core->informationCountForEnterpriseID($core->tableConsultant, $core->enterpriseID, "&& `user`!='-'");
			
		} else
		
		if ($method === "getConsultants") {

			echo $core->informationForEnterpriseID($core->tableConsultant, $core->enterpriseID, "&& `user`!='-'");
			
		} else 
		
		if ($method === "getSingleConsultant") {
			if (isset ($_GET['consultantID'])) {
				$consultantID = trim(htmlentities(utf8_decode($_GET['consultantID'])));
						
				echo $core->informationForEnterpriseIDForUniqueID($core->tableConsultant, $core->enterpriseID, $consultantID, "&& `user`!='-'");
			} else {
				http_response_code(400);
			}

		} else 
		
		if ($method === "createMember") {
			if (isset ($_GET['seconds'])) {
				$delay = trim(htmlentities(utf8_decode($_GET['seconds'])));
				
				echo $core->notificationsForIDWithDelay($core->userID, $delay);
			} else {
				http_response_code(400);
			}
			
		} else 
		
		if ($method === "updateMember") {
			
			if (isset ($_GET['seconds'])) {
				$delay = trim(htmlentities(utf8_decode($_GET['seconds'])));
			
				echo $core->newNotificationsForIDWithDelay($core->userID, $delay);
			} else {
				http_response_code(400);
			}
			
		} else
		
		
	{ http_response_code(501); }} else
	
// ------------------------------------------------------------------------------------------- //

// ----------------------------------------- GROUPS ----------------------------------------- //

	if ($namespace === "group") {
		
		if ($method === "getNumberOfGroups") {

			echo $core->informationCountForEnterpriseID($core->tableGroup, $core->enterpriseID);
			
		} else
		
		if ($method === "getGroups") {

			echo $core->informationForEnterpriseID($core->tableGroup, $core->enterpriseID);
			
		} else 
		
		if ($method === "getSingleGroup") {
			if (isset ($_GET['groupID'])) {
				$groupID = trim(htmlentities(utf8_decode($_GET['groupID'])));
						
				echo $core->informationForEnterpriseIDForUniqueID($core->tableGroup, $core->enterpriseID, $groupID);
			} else {
				http_response_code(400);
			}

		} else 
		
		if ($method === "createGroup") {
			if (isset ($_GET['seconds'])) {
				$delay = trim(htmlentities(utf8_decode($_GET['seconds'])));
				
				echo $core->notificationsForIDWithDelay($core->userID, $delay);
			} else {
				http_response_code(400);
			}
			
		} else 
		
		if ($method === "updateGroup") {
			
			if (isset ($_GET['seconds'])) {
				$delay = trim(htmlentities(utf8_decode($_GET['seconds'])));
			
				echo $core->newNotificationsForIDWithDelay($core->userID, $delay);
			} else {
				http_response_code(400);
			}
			
		} else
		
		
	{ http_response_code(501); }} else
	
// ------------------------------------------------------------------------------------------- //

// -------------------------------------- NOTIFICATIONS --------------------------------------- //

	if ($namespace === "notification") {
	
		/**
		 * Number of notifications
		 * @var string
		 */	
		if ($method === "getNumberOfNotifications") {

			echo $core->notificationCountForID($core->userID);
			
		} else

		/**
		 * Get new notifications
		 * @var string
		 */
		if ($method === "getNewNotifications") {

			echo $core->newNotificationsForUserID($core->userID);
			
		} else 
		
		/**
		 * Get new notifications since notification
		 * @var string
		 */
		if ($method === "getNotificationsSinceNotification") {
			if (isset ($_GET['lastNotificationID'])) {
				$lastNotificationID = trim(htmlentities(utf8_decode($_GET['lastNotificationID'])));
						
				echo $core->notificationsForUserIDSinceNotification($core->userID, $lastNotificationID);
			} else {
				http_response_code(400);
			}

		} else 
		
		/**
		 * Get notifications within time
		 * @var string
		 */
		if ($method === "getNotificationsWithinTime") {
			if (isset ($_GET['seconds'])) {
				$seconds = trim(htmlentities(utf8_decode($_GET['seconds'])));
						
				echo $core->notificationsForIDWithDelay($core->userID, $seconds);
			} else {
				http_response_code(400);
			}

		} else 
		
		
		/**
		 * Get new notifications within time
		 * @var string
		 */
		if ($method === "getNewNotificationsWithinTime") {
			if (isset ($_GET['seconds'])) {
				$seconds = trim(htmlentities(utf8_decode($_GET['seconds'])));
						
				echo $core->newNotificationsForIDWithDelay($core->userID, $seconds);
			} else {
				http_response_code(400);
			}

		} else 
		
		/**
		 * Get notifications with offset
		 * @var string
		 */
		if ($method === "getNotificationsWithOffset") {
			if (isset ($_GET['offset'])) {
				$offset = trim(htmlentities(utf8_decode($_GET['offset'])));
						
				echo $core->newNotificationsForIDWithDelay($core->userID, $offset);
			} else {
				http_response_code(400);
			}

		} else
				
		/**
		 * Get single notification
		 * @var string
		 */
		if ($method === "getSingleNotification") {
			if (isset ($_GET['notificationID'])) {
				$notificationID = trim(htmlentities(utf8_decode($_GET['notificationID'])));
						
				echo $core->notificationsForNotificationID($core->userID, $notificationID);
			} else {
				http_response_code(400);
			}
	
		} else		

	{ http_response_code(501); }} else
	
// ------------------------------------------------------------------------------------------- //

// -------------------------------------- MEMBER --------------------------------------- //

	if ($namespace === "member") {
	
		if ($method === "getNumberOfMembers") {

			echo $core->informationCountForEnterpriseID($core->tableUser, $core->enterpriseID, "&& `user`!='-'");
			
		} else
		
		if ($method === "getMembers") {

			echo $core->informationForEnterpriseID($core->tableUser, $core->enterpriseID, "&& `user`!='-'");
			
		} else 
		
		if ($method === "getSingleMember") {
			if (isset ($_GET['memberID'])) {
				$memberID = trim(htmlentities(utf8_decode($_GET['memberID'])));
						
				echo $core->informationForEnterpriseIDForUniqueID($core->tableUser, $core->enterpriseID, $memberID, "&& `user`!='-'");
			} else {
				http_response_code(400);
			}

		} else 
		
		if ($method === "createMember") {
			if (isset ($_GET['seconds'])) {
				$delay = trim(htmlentities(utf8_decode($_GET['seconds'])));
				
				echo $core->notificationsForIDWithDelay($core->userID, $delay);
			} else {
				http_response_code(400);
			}
			
		} else 
		
		if ($method === "updateMember") {
			
			if (isset ($_GET['seconds'])) {
				$delay = trim(htmlentities(utf8_decode($_GET['seconds'])));
			
				echo $core->newNotificationsForIDWithDelay($core->userID, $delay);
			} else {
				http_response_code(400);
			}
			
		} else
		
	{ http_response_code(501); }} else
	
// ------------------------------------------------------------------------------------------- //

// -------------------------------------- PROJECT --------------------------------------- //

	if ($namespace === "project") {
	
		if ($method === "getNumberOfProjects") {

			echo $core->informationCountForEnterpriseID($core->tableProject, $core->enterpriseID);
			
		} else
		
		if ($method === "getProjects") {

			echo $core->informationForEnterpriseID($core->tableProject, $core->enterpriseID);
			
		} else 
		
		if ($method === "getSingleProject") {
			if (isset ($_GET['projectID'])) {
				$projectID = trim(htmlentities(utf8_decode($_GET['projectID'])));
						
				echo $core->informationForEnterpriseIDForUniqueID($core->tableProject, $core->enterpriseID, $projectID);
			} else {
				http_response_code(400);
			}

		} else 

		if ($method === "getStates") {

			echo $core->informationForTable($core->tableProjectStatus);

		} else 
		
		if ($method === "createMember") {
			if (isset ($_GET['seconds'])) {
				$delay = trim(htmlentities(utf8_decode($_GET['seconds'])));
				
				echo $core->notificationsForIDWithDelay($core->userID, $delay);
			} else {
				http_response_code(400);
			}
			
		} else 
		
		if ($method === "updateMember") {
			
			if (isset ($_GET['seconds'])) {
				$delay = trim(htmlentities(utf8_decode($_GET['seconds'])));
			
				echo $core->newNotificationsForIDWithDelay($core->userID, $delay);
			} else {
				http_response_code(400);
			}
			
		} else
		
	{ http_response_code(501); }} else
	
// ------------------------------------------------------------------------------------------- //

	{
		http_response_code(501);
	}


?>