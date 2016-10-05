<?php 
	@session_start();

	if (isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	} else {
		echo "<div class='strt-btn'><button>Start Now</button></div>";
		die;
	}

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$course_id = $_POST['course_id'];
	
	if ($course_id == 3) {
		echo "<div class='strt-btn'><button>Coming Soon</button></div>";
		die;
	}

	$query = "SELECT count(`id`) FROM `assignment_question` WHERE `course_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $course_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $total_assignment_question);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	$query = "SELECT count(`id`) FROM `video_question` WHERE `course_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $course_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $total_video_question);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	$total_course_question = $total_assignment_question + $total_video_question;
	
	if($total_course_question == 0){
		echo "<div class='strt-btn'><button>Start Now</button></div>";
		die;
	}

	$query = "SELECT count(`id`) FROM `assignment_answer` WHERE `course_id`=? AND `user_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'ii', $course_id, $user_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $total_user_assignment_answer);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	$query = "SELECT count(`id`) FROM `video_answer` WHERE `course_id`=? AND `user_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'ii', $course_id, $user_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $total_user_video_answer);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	$total_user_course_answer = $total_user_assignment_answer + $total_user_video_answer;
	
	$perc_prog = floor(100*$total_user_course_answer/$total_course_question);
	
	if($perc_prog == 0) {
		echo "<div class='strt-btn'><button>Start Now</button></div>";
		die;
	} else if($perc_prog == 100){
		echo "<div class='complete'><i class='fa fa-check-circle' style='font-weight: 600'>&nbsp;</i><p>Completed</p></div>";
		die;
	} else {
		echo "<div class='strt-btn'><button>Continue</button></div>";
	}

	mysqli_close($link);
?>