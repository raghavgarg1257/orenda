<?php 
	@session_start();
	if (session_destroy()) {
		$_SESSION['u_id'] = "";
		$_SESSION['fb_id'] = "";
		$_SESSION['g_id'] = "";
		header("Location:index.php");
	//	header("Location:$_SERVER['HTTP_REFERER']");
	}	else	{
		echo "<div>Some Problem Occured</div>";
	}
?>