<?php

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$email = $_POST['email']; 

	function sanitize($data)
	{
		global $link;
		$data = trim($data);
		$data = mysqli_real_escape_string($link, $data);
		return $data;
	}
	
	function regularemail($email)
	{
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

	if (regularemail($email)) {

		$query = " SELECT `id` FROM `users` WHERE `email`=? AND `g_id`=0 AND `fb_id`=0 ";
		$email = sanitize($email);
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement,'s',$email);
		mysqli_stmt_execute($statement);
		mysqli_stmt_bind_result($statement, $user_id);
		mysqli_stmt_fetch($statement);
		
		if($user_id == ""){
			echo "signin";
		} else {
			echo "login";
		}
			
		mysqli_stmt_close($statement);	//	close the prepared statement



	} else {
		echo "not_valid";
	}

	mysqli_close($link);	//	close the sql connection	

 ?>