<?php 

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$comment_id = $_POST['comment_id'];

	$query = "DELETE FROM `video_comment` WHERE `id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $comment_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_close($statement);

	$query = "DELETE FROM `video_reply` WHERE `comment_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $comment_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_close($statement);

	mysqli_close($link);

 ?>