<?php 
	@session_start();
	
	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$email = $_POST['email']; 
	$password = $_POST['password'];

	function sanitize($data) {
		global $link;
		$data = trim($data);
		$data = mysqli_real_escape_string($link, $data);
		return $data;
	}
	function regularemail($email) {
		if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $email)) {
			list($user_name, $mail_domain) = split("@", $email);
			if (checkdnsrr($mail_domain,"MX"))
				return true;
			else
				return false;
		}
		else
			return false;
	}
	function checkuser($email,$password) {
		global $link;

		$email = sanitize($email);
		$password = sanitize($password);
		$password = md5($password."lairotut");	//	salt word

		$query = " SELECT `id`, `auth_tkn_sts` FROM `user_auth` WHERE `email`=? AND `password`=? ";
		$statement = mysqli_prepare($link,$query);
		mysqli_stmt_bind_param($statement,'ss', $email, $password);
		mysqli_stmt_execute($statement);
		mysqli_stmt_bind_result($statement, $uid, $auth_tkn_sts);
		mysqli_stmt_fetch($statement);
		mysqli_stmt_close($statement);	//	close the prepared statement
		
		if ($uid != '') { 
			if($auth_tkn_sts == "1") {
				return $uid;
			} else {
				return -1;	// Account is not authentic
			}
		} else {
			return 0;	// ID - Password didn't match to any account
		}
	}
	
	if (regularemail($email)) {
		$uid = checkuser($email,$password);
		
		if ( ($uid == 0) || ($uid == -1) ) {
			if ($uid == -1) {
				echo "auth_prb";
			} else if ($uid == 0) {
				echo "halt";
			}
		} else {
			$_SESSION['u_id'] = $uid;
			echo $_SERVER['HTTP_REFERER'];
			
			
			if(isset($_SERVER['REMOTE_ADDR']))
			        $client_ip = $_SERVER['REMOTE_ADDR'];
			else
				$client_ip = "unkown";
				
			require ('lib/Browser.php');
			$browser = new Browser();
			$client_browser = $browser->getBrowser()."/".$browser->getVersion();
			
			$u_agent = $_SERVER['HTTP_USER_AGENT'];
			$client_machine = 'Unknown';
			if (preg_match('/windows/i', $u_agent))
				$client_machine = 'Windows';
			else if (preg_match('/macintosh|mac os x/i', $u_agent))
				$client_machine = 'Macintosh';
			else if (preg_match('/linux/i', $u_agent))
				if (preg_match('/android/i', $u_agent))
					$client_machine = 'Android(linux)';
				else if (preg_match('/ubuntu/i', $u_agent))
					$client_machine = 'Ubuntu(linux)';
				else if (preg_match('/fedora/i', $u_agent))
					$client_machine = 'Fedora(linux)';
				else
					$client_machine = 'Linux';
			
			$method_used = "Integrated Login";
			
			$query = "INSERT INTO `login_details`(`email`, `client_ip`, `client_browser`, `client_machine`, `method_used`) VALUES (?,?,?,?,?)";
			$statement = mysqli_prepare($link,$query);
			mysqli_stmt_bind_param($statement,'sssss', $email, $client_ip, $client_browser, $client_machine, $method_used);
			mysqli_stmt_execute($statement);
			mysqli_stmt_close($statement);
			
		}
	} else {
		echo "halt";
	}

	mysqli_close($link);	//	close the connection

 ?>