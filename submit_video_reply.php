<?php 
	@session_start();

	if (isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	}

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	function sanitize($data) {
		global $link;
		$data = trim($data);
		$data = mysqli_real_escape_string($link, $data);
		return $data;
	}

	$reply_cmnt_id = sanitize($_POST['reply_cmnt_id']);
	$reply_written = sanitize($_POST['reply_written']);
	$reply_timestamp = date("Y-m-d H:i:s");

	$query = "INSERT INTO `video_reply`(`time`, `user_id`, `comment_id`, `detail`) VALUES (?,?,?,?)";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'siis', $reply_timestamp, $user_id , $reply_cmnt_id, $reply_written);
	mysqli_stmt_execute($statement);
	mysqli_stmt_close($statement);

	$query = "SELECT `id` FROM `video_reply` WHERE `time`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 's', $reply_timestamp);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $reply_id);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);

	$query = "SELECT `name`, `profile_pic`, `fb_id`, `g_id` FROM `users` WHERE `id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $user_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $replyr_user_name, $replyr_user_profile_pic, $replyr_user_fb_id, $replyr_user_g_id);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	mysqli_close($link);

	echo "
		<div id='reply_$reply_id' class='indv_reply welldone text-left' style='background-color:#DADADA;'>
			<div>
				<img 
			";	
					if ($replyr_user_fb_id != 0) {	
						echo "src='http://graph.facebook.com/$replyr_user_fb_id/picture'";
					} else if($replyr_user_g_id != 0){
						echo "src=$replyr_user_profile_pic";
					} else {
						echo "src='images/users/$replyr_user_profile_pic'";
					}
			echo "	width='50px'
				class=''
				style='float:left'
				/>
				<span class='disp_name'>$replyr_user_name</span>
				<span class='disp_time_stamp'>at $reply_timestamp</span>
			</div>
			<div>
				<span class='disp_details'>".nl2br($reply_written)."</span>
			</div>
			<div id='clr_reply_$reply_id' class='clr_reply disp_del' style='display:none; margin:-20px 0; color:#808080; font-size:12px;'>delete</div>
		</div>
	";

	
?>