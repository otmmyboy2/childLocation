<div id="children_list" class="row center">														<!-- This file allows the parent to delete a child. -->
	<form method='POST' action='controller/deleteBackend.php' id='deleteForm'>
		<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
		<h4>Delete Child</h4>
			
		<div class="container center" style="width: 30%;">
			<div class="input-field col s12" style="padding-top:8%;">
				<?php                															//The code in this php tag will fetch children of the parent logged in and return them in a dropdown.
					$user_id = get_user_id($username);

					$children_id_list = array();
					$children_id_list = get_children_id($user_id);

					$children_list = array();
					$children_list = get_children_names($children_id_list);

					echo '<select name="delete_id" required>';													
						echo '<option value="" name="" disabled selected></option>';
						for ($i = 0; $i < count($children_list); $i++) {									//Loops through the children in the array and outputs their names into the dropdown.
							//echo $children_list_array[$i], '<br>';					//DEBUG Statement
						    echo '<option value=', $children_id_list[$i], ' name=', $children_id_list[$i], '>', $children_list[$i], '</option>';
						}
					echo '</select>';

				?>
				
				<label>Child to delete (Required)</label>
			</div>
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
function checkValidation() {													//This function checks whether all of the form's required fields are filled in and if so submits the form.
    var isValidForm = document.forms['deleteForm'].checkValidity();
    if (isValidForm)
    {
		alert("Child deleted.");
        document.forms['deleteForm'].submit();
    }
    else
    {
        return false;
    }
}
</script>