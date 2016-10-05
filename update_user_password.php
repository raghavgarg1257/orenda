<?php  
	@session_start();

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	if (isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	}

	function sanitize($data) {
		global $link;
		$data = trim($data);
		$data = mysqli_real_escape_string($link, $data);
		return $data;
	}

	function regularpassword($password)
	{
		if (preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password))
			return true;
		else
			return false;
	}

	function update($id, $password) {
		global $link;

		$password = sanitize($password);
		$password = md5($password."lairotut");	//	salt word 

		$query = "UPDATE `user_auth` SET `password`=? WHERE `id`=?";
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement,'si', $password, $id);
		mysqli_stmt_execute($statement);
		mysqli_stmt_close($statement);
	}

	$user_new_pass = sanitize($_POST['user_new_pass']);

	if (regularpassword($user_new_pass)) {
		update($user_id,$user_new_pass);
		echo "go";
	} else {
		echo "halt";
	}

	mysqli_close($link);	//	close the sql connection
 ?>