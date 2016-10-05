<?php 
	@session_start();

	if (isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	} else {
		die;
	}

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$course_id = $_POST['course_id'];

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
		mysqli_close($link);
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
	
	$query = "SELECT `title` FROM `courses` WHERE `id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $course_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $course_title);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	$course_link = "course.php?name=".str_replace('==', '', base64_encode($course_id.'virtut'));
	
	$total_user_course_answer = $total_user_assignment_answer + $total_user_video_answer;
	
	$perc_prog = floor(100*$total_user_course_answer/$total_course_question);
	
	if($perc_prog == 0) {
		mysqli_close($link);
		die;
	} else if($perc_prog == 100){
		echo "
			<div class='row'>
				<div class='col-sm-4 c-title'><p>$course_title</p></div>
				<div class='col-sm-5 status'><p>Completed</p></div>
				<div class='fa fa-angle-right arrow'></div>
				<a href='$course_link'></a>
			</div>
		";
		mysqli_close($link);
		die;
	} else {	
		echo "
			<div class='row'>
				<div class='col-sm-4 c-title col-xs-11'><p>$course_title</p></div>
				<div class='col-sm-5 col-xs-11'> 
					<div class='progress-info'>
						<div class='progress'>
							<div 
								class='progress-bar' 
								role='progressbar' 
								aria-valuenow='$perc_prog' 
								aria-valuemin='0' 
								aria-valuemax='100' 
								style='width:$perc_prog%;'>
							</div>
						</div>
						<p>$perc_prog%</p>
					</div>
				</div>
				<div class='fa fa-angle-right arrow'></div>
				<a href='$course_link'></a>
			</div>
		";
	}

	mysqli_close($link);
?>