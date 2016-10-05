<?php 
	$assignment_details = $_POST['assignment_details'];
?>
<div class="text-center video-head"><h2>Instructions</h2></div>
<br>
<div class="description"><p>
	<?php 
		$assignment_details = htmlspecialchars($assignment_details, ENT_QUOTES);
		$assignment_details = str_replace("[br]","<br>",$assignment_details);
		$assignment_details = str_replace("[em]","<em>",$assignment_details);
		$assignment_details = str_replace("[/em]","</em>",$assignment_details);
		$assignment_details = str_replace("[strong]","<strong>",$assignment_details);
		$assignment_details = str_replace("[/strong]","</strong>",$assignment_details);
		$assignment_details = str_replace("[code]","<code style='display:block; white-space:pre-wrap'>",$assignment_details);
		$assignment_details = str_replace("[/code]","</code>",$assignment_details);
		$assignment_details = str_replace("[space]","&nbsp;",$assignment_details);
		$assignment_details = nl2br($assignment_details); 
		echo $assignment_details;
	?>
</p></div>