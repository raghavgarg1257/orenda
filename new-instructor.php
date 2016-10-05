<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/png" href="images/logo_small.png">
	<title>Orenda | New Instructor</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/applyAsInstructor.min.css">
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	
	<script type="text/javascript">
		paceOptions = {
			elements: true,
			restartOnRequestAfter:false,
			restartOnPushState:false
		};
	</script>
	<script type="text/javascript" src="js/pace.min.js"></script>
	<link rel="stylesheet" href="css/pace-theme.css" />
</head>
<body>

	<div class="application-form">
		
		<div class="header">
			<div class="container">
				<div style="text-align: center; display: block">		
					<h3 style="margin: 0 auto; text-align: left; max-width: 699px"><a href="index.php" style="display: inline-block; margin: 10px 0"><img src="images/logo_big.png"></a></h3>									
				</div>
			</div>
		</div>

		<div style="background: rgb(249,249,249); padding: 100px 0 80px" >
		<div class="container">
			
		<div class="instructor-form" id="thank_response">
			<form method="POST" action="#" enctype="multipart/form-data" name="apply_instructor_form" id="apply_instructor_form">
			
			<h4>Submit Your Application</h4>
			<ul>
				<li class="upload-resume" style="text-align: left">
					<label style="margin-bottom:0px; vertical-align:middle" class="labels">Resume/CV*</label>
					<div style="display: inline-block">
						<a href="#" style="width: 250px; height: 40px">	
							<input type="file" name="instrctr_resume" id="instrctr_resume" class="inputfile" data-multiple-caption="{count} flies selected" accept=".txt,.pdf,.doc,.docx,.odt,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.sxw,.rtf" required>
							<label class="upload-cv">	
								<i class="glyphicon glyphicon-paperclip" style="vertical-align: middle; font-weight: 700; margin-right: 10px"></i>
								<span>Attach Resume/CV</span>
							</label>
						</a>
						<label id="input_file_error_box" style="display:inline; font-size:13px;" class="labels"></label>
					</div>					
				</li>
			  	<li>
					<label class="labels">Full Name*</label>
					<input type="text" onkeypress="return isName(event)" name="instrctr_name" id="instrctr_name" class="input-field" value="" autocomplete="on" required>
				</li>
				<li>
					<label class="labels">Email*</label>
					<input type="email" onkeyup="isEmail(this)" name="instrctr_email" id="instrctr_email" class="input-field" value="" autocomplete="on" required>
				</li>
				<li>
					<label class="labels">Phone</label>
					<input 
						type="text" 
						onkeypress="return isNumeric(event)" 
						oninput="maxLengthCheck(this)" 
						max="0000000000" 
						name="instrctr_phone" 
						id="instrctr_phone" 
						class="input-field" 
						value="" 
						autocomplete="on" 
					/>
				</li>
				<li>
					<label class="labels">Course Name*</label>
					<input type="text" onkeypress="return isName(event)" name="course_name" id="course_name" class="input-field" value="" autocomplete="on" required>
				</li>
			</ul>
				
			<h4>Links</h4>
			<ul>
				<li>
					<label class="labels">LinkedIn URL</label>
					<input type="text" onkeyup="isUrl(this)" name="linkedin_uri" id="linkedin_uri" class="input-field" value="">
				</li>
				<li>
					<label class="labels">Facebook URL</label>
					<input type="text" onkeyup="isUrl(this)" name="facebook_uri" id="facebook_uri" class="input-field" value="">
				</li>
				<li>
					<label class="labels">Portfolio URL</label>
					<input type="text" onkeyup="isUrl(this)" name="portfolio_uri" id="portfolio_uri" class="input-field" value="">
				</li>
				<li>
					<label class="labels">Other Website</label>
					<input type="text" onkeyup="isUrl(this)" name="others_uri" id="others_uri" class="input-field" value="">
				</li>
			</ul>

			<h4>Additional Information</h4>
			<ul>
				<li>
					<label  class="labels" style="vertical-align: top; margin-top: 17.5px; margin-bottom: 17.5px">
						<div>Describe your strategy here in less than 200 words about how you will teach the course</div>
					</label>
					<textarea type="text" oninput="maxWords(this)" name="course_details" id="course_details" class="input-field" rows="6" style="height:auto; max-width:489px;" value=""></textarea>
				</li>
				<li>
					<textarea type="text" name="personal_details" id="personal_details" placeholder="Add a cover letter or anything else you want to share." rows="6" style="max-width:703px;" value=""></textarea>
				</li>
			</ul>

			<input type="submit" value="Submit Application">

			</form>
		</div>
		
		</div>
		</div>


		<?php require("footer.php"); ?>

	</div>	
	
	<?php require("contact_modal.php"); ?>

	<script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript">
		function maxWords(object) {
			if (object.value.length > 200)
				object.value = object.value.slice(0, 200);
		}	
		function maxLengthCheck(object) {
			if (object.value.length > object.max.length)
				object.value = object.value.slice(0, object.max.length);
		}
		function isNumeric (evt) {
			var theEvent = evt || window.event;
			var key = theEvent.keyCode || theEvent.which;
			key = String.fromCharCode (key);
			$(evt.target).css("border-color","");
			if ( !/[0-9]|\./.test(key) ) {
				theEvent.returnValue = false;
				if(theEvent.preventDefault)
					theEvent.preventDefault();
			}
		}
		function isName (evt) {
			var theEvent = evt || window.event;
			var key = theEvent.keyCode || theEvent.which;
			key = String.fromCharCode (key);
			$(evt.target).css("border-color","");
			if ( !/^[A-Za-z0-9-''\s]+$/.test(key) ) {
				theEvent.returnValue = false;
				if(theEvent.preventDefault)
					theEvent.preventDefault();
			}
		}
		function isEmail(element) {
			if ( /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test($(element).val()) )
				$(element).css("border-color","");
			else if ($(element).val() == "")
				$(element).css("border-color","");
			else
				$(element).css("border-color","red");
		}
		function isUrl(element) {
			if ( /^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test($(element).val()) )
				$(element).css("border-color","");
			else if ($(element).val() == "")
				$(element).css("border-color","");
			else
				$(element).css("border-color","red");
		}
		
		$(document).ready(function() {	
			var input = $("#instrctr_resume"),
			    label = input.next(),
			    labelVal = label.html(),
			    file_ready = false,
			    fileName;
			    
			$("#instrctr_resume").on("change", function(e) {		
				$("#input_file_error_box").html("");
				file_ready = false;
				
				if(this.files){
					if (this.files.length > 1) {
						label.find("span").html("max 1 file");
						input.val("");
						e.preventDefault();
					} else {
						var file_ext = input.val(),
						    fileExt;
						    fileExt = (file_ext.split('.').pop() != "") ? file_ext.split('.').pop().toLowerCase() : "";
						
						if (fileExt != "txt" &&
						    fileExt != "pdf" &&
						    fileExt != "odt" &&
						    fileExt != "sxw" &&
						    fileExt != "rtf" &&
						    fileExt != "doc" &&
						    fileExt != "docx" &&
						    fileExt != "") {
							label.find("span").html("document file only");
							input.val("");
							e.preventDefault();	    
						} else {
							
							if(this.files[0].size > 1048576) {
								label.find("span").html("max size 1mb");
								input.val("");
								e.preventDefault();
							} else {
								fileName = (this.files) ? e.target.value.split("\\").pop() : "";
									
								if(!fileName) {
									label.html(labelVal);
								} else {
									label.find("span").html(fileName);
									file_ready = true;
								}
							}  //  size of file
						}  //  extension of file
					}  //  number of file	
				}
				
			});  //  input change event end
			
			$("#instrctr_resume").on("focus", function(){ input.addClass("has-focus"); });
			$("#instrctr_resume").on("blur", function(){ input.removeClass("has-focus"); });
			$("#instrctr_resume").hover(function(){ $(".upload-cv").toggleClass("changebg");});
			
			//  FORM SUBMIT
			$("#apply_instructor_form").on("submit",function(e){
				e.preventDefault();
				
				if(!file_ready) {
					$("#input_file_error_box").html("Select one document file under 1MB");
					input.val("");
				} else {
					$("#input_file_error_box").html("");
					
					var inst_name = $("input[name=instrctr_name]").val(),
					    inst_email = $("input[name=instrctr_email]").val(),
					    crs_name = $("input[name=course_name]").val();
					    
					var name_regex = /^[A-Za-z0-9-''\s]+$/,
					    email_regex = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/,
					    num_regex = /([1-9]{1})([0-9]{9})/,
					    url_regex = /^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;
					    
					if( !name_regex.test(inst_name) || 
					    !email_regex.test(inst_email) || 
					    !name_regex.test(crs_name) ) {
					
						if(!name_regex.test(inst_name))
							$("input[name=instrctr_name]").css("border-color","red");
						if(!email_regex.test(inst_email))
							$("input[name=instrctr_email]").css("border-color","red");
						if(!name_regex.test(crs_name))
							$("input[name=course_name]").css("border-color","red");
						
					} else {
						
						var errors = false;
						
						if($("input[name=instrctr_phone]").val() != "")
							if(!num_regex.test($("input[name=instrctr_phone]").val())) {
								$("input[name=instrctr_phone]").css("border","red"); 
								errors = true;
							}
						
						if($("input[name=linkedin_uri]").val() != "")	
							if(!url_regex.test($("input[name=linkedin_uri]").val())) {
								$("input[name=linkedin_uri]").css("border","red");
								errors = true;
							}
						
						if($("input[name=facebook_uri]").val() != "")
							if(!url_regex.test($("input[name=facebook_uri]").val())) {
								$("input[name=facebook_uri]").css("border","red");
								errors = true;
							}
						
						if($("input[name=portfolio_uri]").val() != "")
							if(!url_regex.test($("input[name=portfolio_uri]").val())) {
								$("input[name=portfolio_uri]").css("border","red");
								errors = true;
							}
						
						if($("input[name=others_uri]").val() != "")
							if(!url_regex.test($("input[name=others_uri]").val())) {
								$("input[name=others_uri]").css("border","red");
								errors = true;
							}
							
						if(!errors) { 
							var formData = new FormData(this);
							
							$.ajax({
								url: "save_new_instructor.php",
								type: "POST",
								data: formData,
								processData: false,
								contentType: false,
								success: function(data) {
									    	
									var input = $("#instrctr_resume"),
									    label = input.next();
									    
									if(data == "halt") {
										alert("Please Fill all the mandotry(*) fields.");
									} else if(data == "ext_halt") {
										label.find("span").html("document file only");
										input.val("");
									} else if(data == "size_halt") {
										label.find("span").html("max size 1mb");
										input.val("");
									} else if(data == "inst_name_halt") {
										$("input[name=instrctr_name]").val("");
									} else if(data == "inst_email_halt") {
										$("input[name=instrctr_email]").val("");
									} else if(data == "crs_name_halt") {
										$("input[name=course_name]").val("");
									} else if(data == "inst_phone_halt") {
										$("input[name=instrctr_phone]").val("");
									} else if(data == "linkedin_uri_halt") {
										$("input[name=linkedin_uri]").val("");
									} else if(data == "facebook_uri_halt") {
										$("input[name=facebook_uri]").val("");
									} else if(data == "portfolio_uri_halt") {
										$("input[name=portfolio_uri]").val("");
									} else if(data == "others_uri_halt") {
										$("input[name=others_uri]").val("");
									} else if(data == "go") {
										var thnk_msg = "<h4 class='text-center'>Thank You, "+$("input[name=instrctr_name]").val()+"</h4><div style='line-height:1.4; letter-spacing:1px; margin:20px auto; text-align:left; max-width:699px;'>We will contact you soon regarding the course <strong>\""+$("input[name=course_name]").val()+"\"</strong> on email id - <strong>"+$("input[name=instrctr_email]").val()+"</strong>.</div>";
										$("#thank_response").html(thnk_msg);
									}
									
								},
							});
						}

						
					}  //  if-else end: all fields are filled or not
					
				}  //  if-else end: input file ready or not
				
			});  //  form submit end
			
		});  //  doucment ready end
	</script>
</body>
</html>