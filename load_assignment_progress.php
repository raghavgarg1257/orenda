<?php 
	@session_start();

	if (isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	}

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$assignment_id = $_POST['assignment_id'];

	$query = "SELECT count(`id`) FROM `assignment_question` WHERE `assignment_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $assignment_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $total_assignment_question);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	$query = "SELECT count(`id`) FROM `assignment_answer` WHERE `assignment_id`=? AND `user_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'ii', $assignment_id, $user_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $total_user_assignment_answer);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	if(total_assignment_question  == 0) {
		echo "<div class='check-sign'><i class='fa fa-angle-right'></i></div>";
	} else if ($total_assignment_question == $total_user_assignment_answer) {
		echo "<div class='check-sign'>✓</div>";
	} else {
		echo "<div class='check-sign'><i class='fa fa-angle-right'></i></div>";
	}

	mysqli_close($link);
?>