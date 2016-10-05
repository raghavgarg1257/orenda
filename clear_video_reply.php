<?php 

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$reply_id = $_POST['reply_id'];

	$query = "DELETE FROM `video_reply` WHERE `id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $reply_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_close($statement);

	mysqli_close($link);

 ?>