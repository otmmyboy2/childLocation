<div id="warning" class="row center">															<!-- Send an SOS message from the child to the parent. -->
	<form method='POST' action='controller/messageBackend.php' id='sosForm'>
		<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
		<h4>Send SOS</h4>
			
		<div class="container center" style="width: 30%;">
			<div class="input-field col s12" style="padding-top:10%;">							<!-- Which message to send. -->
				<select name="message_option" required>
					<option value="" name="" disabled selected></option>
					<option value="1" name="1" id="help">Help</option>
					<option value="2" name="2" id="safe_place">Help, Safe Place</option>
					<option value="3" name="3" id="call_me">Please call me now.</option>
				</select>
				<label style="padding-top:10%;">Choose Message(Required)</label>
			</div>
			<?php
				$user_id = get_user_id($username);
				$child_id = get_parent_id($user_id);

				echo "<input id='sender_id' name='sender_id' type='hidden' value='", $user_id, "'>";				//User sending the message.
				echo "<input id='recipient_id' name='recipient_id' type='hidden' value='", $child_id, "'>";			//Child receiving the message.
			?>

			<input id="message_type" name="message_type" type="hidden" value="sos">		<!-- Message type. -->

			<script>
				$(document).ready(function() {
			    	$('select').material_select();
				});
				$('select').material_select('destroy');
			</script>
		</div>

		<div class="container center" style="padding-top:40%;padding-left:33%;">
			<div class="col s6 m6 l6 center" onClick="checkValidation();">
				<a><input type="submit" value="Submit" class="btn waves-effect waves-light center col s12" style="width:100%;"></a>
			</div>
		</div>
	</form>
</div>

<script>
function checkValidation() {
    var isValidForm = document.forms['sosForm'].checkValidity();
    if (isValidForm)
    {
		alert("SOS message sent.");
        document.forms['sosForm'].submit();
    }
    else
    {
        return false;
    }
}
</script>
