<?php

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	function sanitize ($data) {
		global $link;
		$data = trim($data);
		$data = mysqli_real_escape_string($link, $data);
		return $data;
	}

	$email = sanitize($_POST['email']);
	$name = sanitize($_POST['name']);
	$msg = sanitize($_POST['msg']);

	function regularemail ($email) {
		if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $email))
			return true;
		else
			return false;
	}

	if (regularemail($email)) {

		$query = "INSERT INTO `contact_us`(`email`, `name`, `message`) VALUES (?,?,?)";
		$email = sanitize($email);
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement,'sss', $email, $name, $msg);
		mysqli_stmt_execute($statement);
		mysqli_stmt_close($statement);	//	close the prepared statement
		
		$to      = "shubh_jain94@yahoo.in,kartikbansal945@gmail.com";
		$subject = "Orenda Contact Message";
		$message = "From: $email\r\nName: $name\r\nMessage: $msg\r\n\r\nRegards,\r\nRaghav Garg\r\nBack End Developer";
		$headers = 'From: help@techorenda.com' . "\r\n" .
		    'Reply-To: help@techorenda.com' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		
		mail($to, $subject, $message, $headers);
		
		echo "saved";
	} else {
		echo "not_valid";
	}

	mysqli_close($link);	//	close the sql connection	
 ?>