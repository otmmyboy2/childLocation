<div id="warning" class="row center">															<!-- Send an warning message from the parent to the child. -->
	<form method='POST' action='controller/messageBackend.php' id='warningForm'>
		<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
		<h4>Send Warning</h4>
			
		<div class="container center" style="width: 30%;">
			<div class="input-field col s12" style="padding-top:5%;">
				<?php                															//The code in this php tag will fetch children of the parent logged in and return them in a dropdown.
					$user_id = get_user_id($username);

					echo "<input id='sender_id' name='sender_id' type='hidden' value='", $user_id, "'>";

					$children_id_list = array();
					$children_id_list = get_children_id($user_id);

					$children_list = array();
					$children_list = get_children_names($children_id_list);


					echo '<select name="recipient_id" required>';								//Which child to send the message to.
						echo '<option value="" name="" disabled selected></option>';
						for ($i = 0; $i < count($children_list); $i++) {									//Loops through the children in the array and outputs their names into the dropdown.
							//echo $children_list_array[$i], '<br>';					//DEBUG Statement
						    echo '<option value=', $children_id_list[$i], ' name=', $children_id_list[$i], '>', $children_list[$i], '</option>';
						}
					echo '</select>';
				?>

				<label style="padding-top:5%;">Recipient(Required)</label>
			</div>

			<div class="input-field col s12" style="padding-top:10%;">				<!-- Which message to send. -->
				<select name="message_option" required>
					<option value="" name="" disabled selected></option>
					<option value="1" name="1" id="activate_internet">Activate Internet</option>
					<option value="2" name="2" id="check_up">Check-up</option>
					<option value="3" name="3" id="call_me">Call Me</option>
				</select>
				<label style="padding-top:10%;">Choose Message(Required)</label>
			</div>
			
			<input id="message_type" name="message_type" type="hidden" value="warning">		<!-- Message type. -->

			<script>
				$(document).ready(function() {
			    	$('select').material_select();
				});
				$('select').material_select('destroy');
			</script>
		</div>

		<div class="container center" style="padding-top:49%;padding-left:33%;">
			<div class="col s6 m6 l6 center" onClick="checkValidation();">
				<a><input type="submit" value="Submit" class="btn waves-effect waves-light center col s12" style="width:100%;"></a>
			</div>
		</div>
	</form>
</div>

<script>
	function checkValidation() {
	    var isValidForm = document.forms['warningForm'].checkValidity();
	    if (isValidForm)
	    {
			alert("Message sent.");
	        document.forms['warningForm'].submit();
	    }
	    else
	    {
	        return false;
	    }
	}
</script>
