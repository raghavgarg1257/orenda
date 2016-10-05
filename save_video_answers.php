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
	$video_id = $_POST['video_id'];
	$course_id = $_POST['course_id'];
	
	$query = "SELECT `id` FROM `video_answer` WHERE `user_id`=? AND `question_id`=? AND `video_id`=? AND `course_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'dddd', $user_id, $question_id, $video_id, $course_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $video_answer_id);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	if($video_answer_id == ""){
		$query = "INSERT INTO `video_answer`(`user_id`, `question_id`, `video_id`, `course_id`) VALUES (?,?,?,?)";
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement, 'dddd', $user_id, $question_id, $video_id, $course_id);
		mysqli_stmt_execute($statement);
		mysqli_stmt_close($statement);
		echo "Answer_saved";
	} else {
		echo "Answer was already saved..!!";
	}
	

	mysqli_close($link);

 ?>