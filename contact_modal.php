<div class="contact-form">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <img src="images/logo_big.png" alt="Website Logo">
        <h4 class="modal-title" id="myModalLabel">Where knowledge brings real power</h4>
      </div>
      <div class="modal-body">
      	
      	<p style="padding: 0 10px">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.
ata }} {{ sample data }} {{ sample data }} {{ sample data }} {{ sample data }} {{ sample data }} {{ sample data }} {{ sample data }} {{ sample data }} {{ sample data }} {{ sample data }} {{ sample data }} {{ sample data }} {{ sample data }}</p>
        <div class="feedback-body" style="background: transparent; margin-top: 20px; padding-bottom: 10px">
        
				<form method="POST" action="#" name="contact_form" id="contact_form" style="text-align:center">
					<input type="email" name="contact_email" id="contact_email" placeholder="Email" autocomplete="on" class="input-field"><br>
					<input type="text" name="contact_name" id="contact_name" placeholder="Name" autocomplete="on" class="input-field"><br>
					<textarea name="contact_msg" id="contact_msg" placeholder="Enter Your Query" class="input-field" rows="5"></textarea><br>
					<input type="submit" name="contact_form_submit" id="contact_form_submit" value="SUBMIT" class="btn btn-success">
					<div id="contact_response" style="margin:10px;"></div>
				</form>
			</div>

      </div>

    </div>
  </div>
</div>
</div>
<script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
<script>
	$(document).ready(function(){
		$("#contact_form").on("submit",function(e){

				e.preventDefault();// prevent native form submission here

				var formData = {
					'email': $('#contact_email').val(),
					'name': $('#contact_name').val(),
					'msg': $('#contact_msg').val() 
				};
				
				console.log($('#contact_email').val());
				console.log($('#contact_name').val());
				console.log($('#contact_msg').val());
				
				if ( ($('#contact_email').val() != "") && ($('#contact_name').val() != "") && ($('#contact_msg').val() != "") ) {
					$.ajax({
						type: "POST",
						url: "save_contact_msg.php",
						data: formData,
						success: function(data){
							console.log("conntact: " + data);
							if (data == "not_valid") {
								$('#contact_email').val("");
							}
							if (data == "saved") {
								$('#contact_email').val("");
								$('#contact_name').val("");
								$('#contact_msg').val("");
								$("#contact_response").html("Your Response have been saved.");
								setTimeout(function(){
									$("#contact_response").html("");	
								}, 3000)						
							}
						}
					});
				}	else	{
					$("#contact_response").html("Please fill all the fields");
					setTimeout(function(){
						$("#contact_response").html("");	
					}, 3000)
				}	
			});
	});
</script>