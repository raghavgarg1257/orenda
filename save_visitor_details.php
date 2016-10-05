<?php
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
	$client_user_agent = $u_agent;
			
	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);		
	
	$query = "SELECT `id` FROM `visitor_details` WHERE `client_ip`=? AND `client_user_agent`=?";
	$statement = mysqli_prepare($link,$query);
	mysqli_stmt_bind_param($statement,'ss', $client_ip, $client_user_agent);
	mysqli_stmt_execute($statement);
	mysqli_stmt_store_result($statement);
	$record_found = mysqli_stmt_num_rows($statement);
	mysqli_stmt_close($statement);

	if(!$record_found){
		$query = "INSERT INTO `visitor_details`(`client_ip`, `client_browser`, `client_machine`, `client_user_agent`) VALUES (?,?,?,?)";
		$statement = mysqli_prepare($link,$query);
		mysqli_stmt_bind_param($statement,'ssss', $client_ip, $client_browser, $client_machine, $client_user_agent);
		mysqli_stmt_execute($statement);
		mysqli_stmt_close($statement);	
	}

	mysqli_close($link);	//	close the connection

 ?>