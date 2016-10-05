<?php
	@session_start();

	if( isset($_POST['id']) ) {

		require "db.php";
		$link = mysqli_connect($_srvr, $_user, $_pass, $_db); 
		
		$g_id = $_POST['id'];
		$g_name = $_POST['name'];
		$g_email = $_POST['email'];
		$g_pic = $_POST['pic'];
		
		$g_id = 1;

		$query = "SELECT `id` FROM `users` WHERE `email`=? AND `g_id`=?";
		$statement = mysqli_prepare($link,$query);
		mysqli_stmt_bind_param($statement, 'si', $g_email, $g_id);
		mysqli_stmt_execute($statement);
		mysqli_stmt_bind_result($statement, $uid);
		mysqli_stmt_fetch($statement);
		mysqli_stmt_close($statement);

		if ($uid == "") {
		//	if want - add Google ID here
			$query = " INSERT INTO `users`(`email`,`name`,`profile_pic`,`g_id`) VALUES (?,?,?,?) ";
			$statement = mysqli_prepare($link,$query);
			mysqli_stmt_bind_param($statement,'sssi', $g_email, $g_name, $g_pic, $g_id);
			mysqli_stmt_execute($statement);
			mysqli_stmt_close($statement);
			
			$query = " INSERT INTO `user_auth`(`email`) VALUES (?) ";
			$statement = mysqli_prepare($link,$query);
			mysqli_stmt_bind_param($statement,'s', $g_email);
			mysqli_stmt_execute($statement);
			mysqli_stmt_close($statement);
	
			$query = " SELECT `id` FROM `user_auth` WHERE `email`=? ";
			$statement = mysqli_prepare($link,$query);
			mysqli_stmt_bind_param($statement, 's', $g_email);
			mysqli_stmt_execute($statement);
			mysqli_stmt_bind_result($statement, $uid);
			mysqli_stmt_fetch($statement);
			mysqli_stmt_close($statement);
		}
		
		$_SESSION['u_id'] = $uid;
//		$_SESSION['g_id'] = $g_id;
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
		
		$method_used = "Google Login";
		
		$query = "INSERT INTO `login_details`(`email`, `client_ip`, `client_browser`, `client_machine`, `method_used`) VALUES (?,?,?,?,?)";
		$statement = mysqli_prepare($link,$query);
		mysqli_stmt_bind_param($statement,'sssss', $g_email, $client_ip, $client_browser, $client_machine, $method_used);
		mysqli_stmt_execute($statement);
		mysqli_stmt_close($statement);

		mysqli_close($link);

	} else {
		echo "halt";
	}

?>