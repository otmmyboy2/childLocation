<div id="children_list" class="row center">
	<form method='POST' action='' id=''>
		<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
		<h4>Locate Child</h4>
			
		<div class="container center" style="width: 30%;">
			<div class="input-field col s12" style="padding-top:10%;">
				<?php                															//The code in this php tag will fetch children of the parent logged in and return them in a dropdown.
					$user_id = get_user_id($username);

					$children_id_list = array();
					$children_id_list = get_children_id($user_id);

					$children_list = array();
					$children_list = get_children_names($children_id_list);


					echo '<select>';													
						echo '<option value="" disabled selected></option>';
						for ($i = 0; $i < count($children_list); $i++) {									//Loops through the children in the array and outputs their names into the dropdown.
							//echo $children_list_array[$i], '<br>';					//DEBUG Statement
						    echo "<option value = '{$children_list[$i]}'>{$children_list[$i]}</option>";
						}
					echo '<label>Children</label>';
					echo '</select>';
				?>

				<label style="padding-top:10%;">Children</label>
			</div>

			<!--<div class="input-field row s12 m6 l3">previous layout--> 
			<div class="input-field col s12" style="padding-top:10%;">
				<select>
					<option value="" disabled selected></option>
					<option value="1" id="locate_child">Locate Child</option>
					<option value="2" id="delete_child">Delete Child</option>
				</select>
				<label style="padding-top:10%;">Available Actions</label>
			</div>

			<script>
				$(document).ready(function() {
			    	$('select').material_select();
				});
				$('select').material_select('destroy');
			</script>
		</div>


		<div class="container center" style="padding-top:40%;">
			<div class="col s6 m6 l6 center">
				<a><button onclick='window.history.back();' class="btn waves-effect waves-light center col s12">Back</button></a>
			</div>
			<div class="col s6 m6 l6 center">
				<a><button type='submit' value='go' class="btn waves-effect waves-light center col s12">Go</button></a>
			</div>
		</div>
	</form>
</div>

