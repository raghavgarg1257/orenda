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


	$update_user_new_name = sanitize($_POST['update_user_new_name']);

	$query = "UPDATE `users` SET `name`=? WHERE `id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'si', $update_user_new_name, $user_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_close($statement);
	
	mysqli_close($link);	//	close the sql connection
 ?>