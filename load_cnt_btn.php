<?php

	$asgnmnt_link = $_POST['asgnmnt_link'];
	
	$link = str_replace('==', '', base64_encode($asgnmnt_link.'virtut'));
	
	echo "<a href='assignment.php?name=$link'><button style='margin-top:8px'>Continue</button></a>";

?>