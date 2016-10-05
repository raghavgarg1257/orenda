<?php @session_start();

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);
	
	if(isset($_SESSION['u_id'])){
		$user_id = $_SESSION['u_id'];
	} else {
		header("Location:index.php");
		die;
	}
	
	$question_id = $_POST['question_id'];
	$assignment_id = $_POST['assignment_id'];
	$course_id = $_POST['course_id'];
	
	$query = "SELECT `id` FROM `assignment_answer` WHERE `user_id`=? AND `question_id`=? AND `assignment_id`=? AND `course_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'dddd', $user_id, $question_id, $assignment_id, $course_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $assignment_answer_id);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	if($assignment_answer_id == ""){
		$query = "INSERT INTO `assignment_answer`(`user_id`, `question_id`, `assignment_id`, `course_id`) VALUES (?,?,?,?)";
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement, 'dddd', $user_id, $question_id, $assignment_id, $course_id);
		mysqli_stmt_execute($statement);
		mysqli_stmt_close($statement);
		echo "answer_saved";
	} else {
		echo "Answer was already saved..!!";
	}
	

	mysqli_close($link);

 ?>