<div id="route_history" class="row center">	                <!-- This page allows the user to submit the child, date and time they wish to view the route of. -->
	<form method='POST' action='index.php?p=route_history_map' id='routeForm'>
	<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
	<h4>Route History</h4>

	<script>
		function checkValidation() {
		    var isValidForm = document.forms['routeForm'].checkValidity();
		    if (isValidForm)
		    {
				// console.log(document.getElementById('recipient_id').value);
				// console.log(document.getElementById('datePicker').value);
				// console.log(document.getElementById('time').value);
	      		document.forms['routeForm'].submit();
		    }
		    else
		    {
		        return false;
		    }
		}
	</script>
	<div class="container center" style="width: 30%;">
		<div class="input-field col s12" style="padding-top:5%;">
			<?php                															//The code in this php tag will fetch children of the parent logged in and return them in a dropdown.
				$user_id = get_user_id($username);

				$children_id_list = array();
				$children_id_list = get_children_id($user_id);

				$children_list = array();
				$children_list = get_children_names($children_id_list);

				echo '<select required name="recipient_id" id="recipient_id">';													
					echo '<option value="" name="" disabled selected></option>';
					for ($i = 0; $i < count($children_list); $i++) {									//Loops through the children in the array and outputs their names into the dropdown.
						//echo $children_list_array[$i], '<br>';					//DEBUG Statement
					    echo '<option value=', $children_id_list[$i], ' name=', $children_id_list[$i], '>', $children_list[$i], '</option>';
					}
				echo '</select>';

				
			?>
			<label style="padding-top:5%;">Child (Required)</label>
		</div>

		<div class="input-field col s12" style="padding-top:5%;">
			<select name="datePicker" id="datePicker" required>
				<option value="" name="" disabled selected></option>
				<option value="1" name="day0" id="day0"></option>
				<option value="2" name="day1" id="day1"></option>
				<option value="3" name="day2" id="day2"></option>
				<option value="4" name="day3" id="day3"></option>
				<option value="5" name="day4" id="day4"></option>
				<option value="6" name="day5" id="day5"></option>
				<option value="7" name="day6" id="day6"></option>
			</select>
			<label style="padding-top:5%;">Date (Required)</label>
		</div>

		<div class="input-field col s12" style="padding-top:5%;">
			<select name="time" id="time" required>
				<option value="" name="" disabled selected></option>
				<option value="1" name="1" id="">12AM - 2AM</option>
				<option value="2" name="2" id="">2AM - 4AM</option>
				<option value="3" name="3" id="">4AM - 6AM</option>
				<option value="4" name="4" id="">6AM - 8AM</option>
				<option value="5" name="5" id="">8AM - 10AM</option>
				<option value="6" name="6" id="">10AM - 12PM</option>
				<option value="7" name="7" id="">12PM - 2PM</option>
				<option value="8" name="8" id="">2PM - 4PM</option>
				<option value="9" name="9" id="">4PM - 6PM</option>
				<option value="10" name="10" id="">6PM - 8PM</option>
				<option value="11" name="11" id="">8PM - 10PM</option>
				<option value="12" name="12" id="">10PM - 12AM</option>
			</select>
			<label style="padding-top:5%;">Time Period (Required)</label>
		</div>
	</div>
	<div class="container center" style="padding-top:22%;padding-left:33%;">
		<div class="col s6 m6 l6 center" onClick="checkValidation();">
			<a><input type="submit" value="Submit" class="btn waves-effect waves-light center col s12" style="width:100%;"></a>
		</div>
	</div>

	<script>
		var today = new Date();
		today = today.toJSON().slice(0,10);
		document.getElementById('day0').innerHTML = today;
		today = JSON.stringify(today)
		document.getElementById('day0').value = today;
		

		var day1 = new Date();
		day1.setDate(day1.getDate() - 1);
		day1 = day1.toJSON().slice(0,10);
		document.getElementById('day1').innerHTML = day1;
		day1 = JSON.stringify(day1)
		document.getElementById('day1').value = day1;
		

		var day2 = new Date();
		day2.setDate(day2.getDate() - 2);
		day2 = day2.toJSON().slice(0,10);
		document.getElementById('day2').innerHTML = day2;
		day2 = JSON.stringify(day2)
		document.getElementById('day2').value = day2;
		

		var day3 = new Date();
		day3.setDate(day3.getDate() - 3);
		day3 = day3.toJSON().slice(0,10);
		document.getElementById('day3').innerHTML = day3;
		day3 = JSON.stringify(day3)
		document.getElementById('day3').value = day3;
		

		var day4 = new Date();
		day4.setDate(day4.getDate() - 4);
		day4 = day4.toJSON().slice(0,10);
		document.getElementById('day4').innerHTML = day4;
		day4 = JSON.stringify(day4)
		document.getElementById('day4').value = day4;
		

		var day5 = new Date();
		day5.setDate(day5.getDate() - 5);
		day5 = day5.toJSON().slice(0,10);
		document.getElementById('day5').innerHTML = day5;
		day5 = JSON.stringify(day5)
		document.getElementById('day5').value = day5;
		

		var day6 = new Date();
		day6.setDate(day6.getDate() - 6);
		day6 = day6.toJSON().slice(0,10);
		document.getElementById('day6').innerHTML = day6;
		day6 = JSON.stringify(day6)
		document.getElementById('day6').value = day6;
		
		// console.log(today);
		// console.log(day1);
		// console.log(day2);
		// console.log(day3);
		// console.log(day4);
		// console.log(day5);
		// console.log(day6);

		$(document).ready(function() {
	    	$('select').material_select();
		});
		$('select').material_select('destroy');
	</script>
</form>
</div>	
