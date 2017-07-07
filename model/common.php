<?php	
	function get_user_id($username) {											//Get the user id for the username passed in.
		$id_query = "SELECT id FROM users WHERE username = '".$username."'";	//Statement to get the id of the user logged in.

		if ($result = dbq($id_query)) {											//Fetches the parent ID found by the query.
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row[0]);
				$user_id = $row[0];
			}
			/* free result set */

			$result->close();
		}
		//echo '<br>Parent ID: ', $user_id, '<br>';					//DEBUG Statement
		return $user_id;
	}	

	function get_parent_id($child_id) {											//Gets the id of the parent of the user logged in.
		$id_query = "SELECT parent_id FROM family WHERE child_id = '".$child_id."'";		

		if ($result = dbq($id_query)) {											//Fetches the parent ID found by the query.
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row[0]);
				$child_id = $row[0];
			}
			/* free result set */

			$result->close();
		}
		//echo '<br>Parent ID: ', $user_id, '<br>';					//DEBUG Statement
		return $child_id;
	}	

	function get_username($uid) {												//Get the username for the user id passed in.
		$name_query = "SELECT username FROM users WHERE id = '".$uid."'";		//Statement to get the id of the user logged in.

		if ($result = dbq($name_query)) {										//Fetches the parent ID found by the query.
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row[0]);
				$username = $row[0];
			}
			/* free result set */

			$result->close();
		}
		//echo '<br>Parent ID: ', $user_id, '<br>';					//DEBUG Statement
		return $username;
	}	

	function get_children_id($user_id) {														//Get the children's IDs for the parent's ID passed in.
	
		$children_id_query = "SELECT child_id FROM family WHERE parent_id = '".$user_id."'";	//Statement to get the children's IDs for the parent who is logged in.

		if ($result = dbq($children_id_query)) {												//Fetches the results of the query.
			/* fetch object array */
			$child_id = array();
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row);
				$child_id[] = $row;
			}
			/* free result set */

			$result->close();
		}

		$child_id_array = array();
		for ($i = 0; $i < count($child_id); $i++) {					//Loops through the results and inserts the entries into an array.
			$child_id_array[$i] = current($child_id[$i]);
		}

		// for ($i = 0; $i < count($child_id); $i++) {
		// 	echo $child_id_array[$i], '<br>';
		// }
		return $child_id_array;
	}

	function get_children_names($child_id_array) {														//Get the children's names for the children's ID array passed in.
		$children_list = array();	
		
		for ($i = 0; $i < count($child_id_array); $i++) {
			//echo $child_id_array[$i], '<br>';					//DEBUG Statement
			
			$children_list_query = "SELECT username FROM users WHERE id = '".$child_id_array[$i]."'";	//Statement that get's all of the children's usernames for the child IDs found previously.

			if ($result = dbq($children_list_query)) {													//Fetches the results of the query.
				/* fetch object array */
				while ($row = $result->fetch_row()) {
					//printf ("%s", $row);
					$children_list[] = $row;
				}
				/* free result set */

				$result->close();
			}
		}
		
		$children_list_array = array();		
		for ($i = 0; $i < count($children_list); $i++) {					//Loops through the results and inserts the entries into an array.
			$children_list_array[$i] = current($children_list[$i]);
		}
		return $children_list_array;
	}

	function get_children_locations($child_id_array) {													//Get the children's locations for the children's ID array passed in.
		$children_loc_list = array();	
		
		for ($i = 0; $i < count($child_id_array); $i++) {
			//echo $child_id_array[$i], '<br>';					//DEBUG Statement
			
			$children_loc_list_query = "SELECT latitude, longitude FROM location WHERE creator_id = '".$child_id_array[$i]."'";	

			if ($result = dbq($children_loc_list_query)) {					//Fetches the results of the query.
				/* fetch object array */
				while ($row = $result->fetch_row()) {
					//printf ("%s", $row);
					$children_loc_list[] = $row;
				}
				/* free result set */

				$result->close();
			}
		}
		
		$children_location_array = array();		
		for ($i = 0; $i < count($children_loc_list); $i++) {					//Loops through the results and inserts the entries into an array.
			$children_location_array[$i] = current($children_loc_list[$i]);
		}
		return $children_location_array;
	}

	function get_children_lat($child_id_array) {														//Get the children's latitudes for the children's ID array passed in.
		$children_loc_list = array();	
		
		for ($i = 0; $i < count($child_id_array); $i++) {
			//echo $child_id_array[$i], '<br>';					//DEBUG Statement
			
			$children_loc_list_query = "SELECT latitude FROM location WHERE creator_id = '".$child_id_array[$i]."'";	

			if ($result = dbq($children_loc_list_query)) {					//Fetches the results of the query.
				/* fetch object array */
				while ($row = $result->fetch_row()) {
					//printf ("%s", $row);
					$children_loc_list[] = $row;
				}
				/* free result set */

				$result->close();
			}
		}
		
		$children_location_array = array();		
		for ($i = 0; $i < count($children_loc_list); $i++) {					//Loops through the results and inserts the entries into an array.
			$children_location_array[$i] = current($children_loc_list[$i]);
		}
		return $children_location_array;
	}

	function get_children_long($child_id_array) {														//Get the children's longitudes for the children's ID array passed in.
		$children_loc_list = array();	
		
		for ($i = 0; $i < count($child_id_array); $i++) {
			//echo $child_id_array[$i], '<br>';					//DEBUG Statement
			
			$children_loc_list_query = "SELECT longitude FROM location WHERE creator_id = '".$child_id_array[$i]."'";	

			if ($result = dbq($children_loc_list_query)) {					//Fetches the results of the query.
				/* fetch object array */
				while ($row = $result->fetch_row()) {
					//printf ("%s", $row);
					$children_loc_list[] = $row;
				}
				/* free result set */

				$result->close();
			}
		}
		
		$children_location_array = array();		
		for ($i = 0; $i < count($children_loc_list); $i++) {					//Loops through the results and inserts the entries into an array.
			$children_location_array[$i] = current($children_loc_list[$i]);
		}
		return $children_location_array;
	}

	function send_message($sender, $recipient, $option, $type){											//Sends the message passed in to the recipient passed in from the sender specified and typed.
		if($type == 'warning'){
			switch ($option):
				case 1:
					$message = "I cannot see your location. Make sure your location settings are on.";
				break;	

				case 2:	
					$message = "Are you ok?";
				break;	

				case 3:	
					$message = "Call me.";
				break;	
				
				default:
					$message = "Error, please contact the system administrator.";
			endswitch;

		}elseif($type == "sos"){
			switch ($option):
				case 1:
					$message = "SOS, I need help now.";
				break;	

				case 2:
					$message = "SOS, I need help now. I am going to the nearest safe place.";		//Future dev, include the safe place they are going to.
				break;	

				case 3:	
					$message = "Please call me now.";
				break;	
				
				default: 
					$message = "Error, please contact the system administrator.";
			endswitch;

		}

		$sql = "SELECT * FROM  message WHERE recipient_id = '".$recipient."'";
		$exists = dbqn($sql);

		if($exists > 0){
		    $sql = "UPDATE message SET sender_id = '".$sender."', recipient_id = '".$recipient."', message = '".$message."'  WHERE recipient_id = '".$recipient."'";
		}
		else
		{
		   	$sql = "INSERT INTO message(sender_id, recipient_id, message) VALUES ('".$sender."','".$recipient."','".$message."')";
		}	

		

		$result = dbq($sql);
		return $result;
	}

	function check_messages($recipient){													//Check if there are any unread messages for the user passed in.
		$sql = "SELECT sender_id FROM  message WHERE recipient_id = '".$recipient."'";

		$exists = dbqn($sql);

		if($exists > 0){
			$sender_id = "SELECT sender_id FROM  message WHERE recipient_id = '".$recipient."'";
			if ($result = dbq($sender_id)) {					//Fetches the parent ID found by the query.
				/* fetch object array */
				while ($row = $result->fetch_row()) {
					//printf ("%s", $row[0]);
					$sender_id = $row[0];
				}
				/* free result set */

				$result->close();
			}

			$message = "SELECT message FROM  message WHERE recipient_id = '".$recipient."'";
			if ($result = dbq($message)) {					//Fetches the parent ID found by the query.
				/* fetch object array */
				while ($row = $result->fetch_row()) {
					//printf ("%s", $row[0]);
					$message = $row[0];
				}
				/* free result set */

				$result->close();
			}
			
			$sender_name = get_username($sender_id);
			$recieved_message = "".$sender_name." sent you:<br>$message";

			$delete = "DELETE FROM message WHERE recipient_id = '".$recipient."' AND message = '".$message."'";
			$execute = dbq($delete);

			return $recieved_message;
		}
		else{
			$message = '';
			return $message;
		}
	}

	function get_nearest_safe_place_names(){										//Gets the safe place's names.

		$safe_locations = array();	
		
		$safe_locations_query = "SELECT name FROM safe_places";	

		if ($result = dbq($safe_locations_query)) {					//Fetches the results of the query.
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row);
				$safe_locations[] = $row;
			}
			/* free result set */

			$result->close();
		}
		
		$safe_locations_name_array = array();		
		for ($i = 0; $i < count($safe_locations); $i++) {					//Loops through the results and inserts the entries into an array.
			$safe_locations_name_array[$i] = current($safe_locations[$i]);
			//echo $safe_locations_name_array[$i];
		}

		return $safe_locations_name_array;

	}

	function get_nearest_safe_place_lats() {										//Gets the safe place's latitudes.

		$safe_locations = array();	
		
		$safe_locations_query = "SELECT latitude FROM safe_places";	

		if ($result = dbq($safe_locations_query)) {					//Fetches the results of the query.
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row);
				$safe_locations[] = $row;
			}
			/* free result set */

			$result->close();
		}
		
		$safe_locations_lat_array = array();		
		for ($i = 0; $i < count($safe_locations); $i++) {					//Loops through the results and inserts the entries into an array.
			$safe_locations_lat_array[$i] = current($safe_locations[$i]);
			//echo $safe_locations_lat_array[$i];
		}

		return $safe_locations_lat_array;

	}

	function get_nearest_safe_place_longs() {										//Gets the safe place's longitudes.

		$safe_locations = array();	
		
		$safe_locations_query = "SELECT longitude FROM safe_places";	

		if ($result = dbq($safe_locations_query)) {					//Fetches the results of the query.
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row);
				$safe_locations[] = $row;
			}
			/* free result set */

			$result->close();
		}
		
		$safe_locations_long_array = array();		
		for ($i = 0; $i < count($safe_locations); $i++) {					//Loops through the results and inserts the entries into an array.
			$safe_locations_long_array[$i] = current($safe_locations[$i]);
			//echo $safe_locations_long_array[$i];
		}

		return $safe_locations_long_array;

	}
	function delete_user($user_id){											//Delete the user where the user id passed in matches the user in the db.
		$location_sql = "DELETE FROM location WHERE creator_id = '".$user_id."'";
		$family_sql = "DELETE FROM family WHERE child_id = '".$user_id."'";
		$message_sql = "DELETE FROM message WHERE recipient_id = '".$user_id."'";
		$message2_sql = "DELETE FROM message WHERE sender_id = '".$user_id."'";
		$users_sql = "DELETE FROM users WHERE id = '".$user_id."'";

		$exists = dbq($location_sql);
		$exists = dbq($family_sql);
		$exists = dbq($message_sql);
		$exists = dbq($message2_sql);
		$exists = dbq($users_sql);
	}

	function get_location_history_lat($user_id, $datePicked, $time){					//Gets the location history table's latitudes.
		switch ($time):
			case 1:
				$timeStart = "00:00";
				$timeEnd = "02:00";
			break;

			case 2:
				$timeStart = "02:00";
				$timeEnd = "04:00";
			break;

			case 3:
				$timeStart = "04:00";
				$timeEnd = "06:00";
			break;

			case 4:
				$timeStart = "06:00";
				$timeEnd = "08:00";
			break;

			case 5:
				$timeStart = "08:00";
				$timeEnd = "10:00";
			break;

			case 6:
				$timeStart = "10:00";
				$timeEnd = "12:00";
			break;

			case 7:
				$timeStart = "12:00";
				$timeEnd = "14:00";
			break;

			case 8:
				$timeStart = "14:00";
				$timeEnd = "16:00";
			break;

			case 9:
				$timeStart = "16:00";
				$timeEnd = "18:00";
			break;

			case 10:
				$timeStart = "18:00";
				$timeEnd = "20:00";
			break;

			case 11:
				$timeStart = "20:00";
				$timeEnd = "22:00";
			break;

			case 12:
				$timeStart = "22:00";
				$timeEnd = "00:00";
			break;
			
			default:
				$timeStart = "00:00";
				$timeEnd = "02:00";
		endswitch;

		$lats = array();
		$datePicked = str_replace('"', '', $datePicked);	
		
		$lats_query = "SELECT latitude FROM location_history WHERE creator_id = '".$user_id."' and date = '".$datePicked."' and time between '".$timeStart."' and '".$timeEnd."'";	

		if ($result = dbq($lats_query)) {					//Fetches the results of the query.
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row);
				$lats[] = $row;
			}
			/* free result set */

			$result->close();
		}
		
		$safe_locations_lat_array = array();		
		for ($i = 0; $i < count($lats); $i++) {					//Loops through the results and inserts the entries into an array.
			$safe_locations_lat_array[$i] = current($lats[$i]);
			//echo $safe_locations_lat_array[$i];
		}

		return $safe_locations_lat_array;

	}

	function get_location_history_long($user_id, $datePicked, $time){					//Gets the location history table's longitudes.
		switch ($time):
			case 1:
				$timeStart = "00:00";
				$timeEnd = "02:00";
			break;

			case 2:
				$timeStart = "02:00";
				$timeEnd = "04:00";
			break;

			case 3:
				$timeStart = "04:00";
				$timeEnd = "06:00";
			break;

			case 4:
				$timeStart = "06:00";
				$timeEnd = "08:00";
			break;

			case 5:
				$timeStart = "08:00";
				$timeEnd = "10:00";
			break;

			case 6:
				$timeStart = "10:00";
				$timeEnd = "12:00";
			break;

			case 7:
				$timeStart = "12:00";
				$timeEnd = "14:00";
			break;

			case 8:
				$timeStart = "14:00";
				$timeEnd = "16:00";
			break;

			case 9:
				$timeStart = "16:00";
				$timeEnd = "18:00";
			break;

			case 10:
				$timeStart = "18:00";
				$timeEnd = "20:00";
			break;

			case 11:
				$timeStart = "20:00";
				$timeEnd = "22:00";
			break;

			case 12:
				$timeStart = "22:00";
				$timeEnd = "00:00";
			break;
			
			default:
				$timeStart = "00:00";
				$timeEnd = "02:00";
		endswitch;

		$longs = array();	
		$datePicked = str_replace('"', '', $datePicked);
		
		$longs_query = "SELECT longitude FROM location_history WHERE creator_id = '".$user_id."' and date = '".$datePicked."' and time between '".$timeStart."' and '".$timeEnd."'";	

		if ($result = dbq($longs_query)) {					//Fetches the results of the query.
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row);
				$longs[] = $row;
			}
			/* free result set */

			$result->close();
		}
		
		$safe_locations_long_array = array();		
		for ($i = 0; $i < count($longs); $i++) {					//Loops through the results and inserts the entries into an array.
			$safe_locations_long_array[$i] = current($longs[$i]);
			//echo $safe_locations_long_array[$i];
		}

		return $safe_locations_long_array;

	}

	function get_location_history_time($user_id, $datePicked, $time){					//Gets the location history table's times.
		switch ($time):
			case 1:
				$timeStart = "00:00";
				$timeEnd = "02:00";
			break;

			case 2:
				$timeStart = "02:00";
				$timeEnd = "04:00";
			break;

			case 3:
				$timeStart = "04:00";
				$timeEnd = "06:00";
			break;

			case 4:
				$timeStart = "06:00";
				$timeEnd = "08:00";
			break;

			case 5:
				$timeStart = "08:00";
				$timeEnd = "10:00";
			break;

			case 6:
				$timeStart = "10:00";
				$timeEnd = "12:00";
			break;

			case 7:
				$timeStart = "12:00";
				$timeEnd = "14:00";
			break;

			case 8:
				$timeStart = "14:00";
				$timeEnd = "16:00";
			break;

			case 9:
				$timeStart = "16:00";
				$timeEnd = "18:00";
			break;

			case 10:
				$timeStart = "18:00";
				$timeEnd = "20:00";
			break;

			case 11:
				$timeStart = "20:00";
				$timeEnd = "22:00";
			break;

			case 12:
				$timeStart = "22:00";
				$timeEnd = "00:00";
			break;
			
			default:
				$timeStart = "20:00";
				$timeEnd = "22:00";
		endswitch;

		$location_time = array();	
		$datePicked = str_replace('"', '', $datePicked);

		$location_time_query = "SELECT time FROM location_history WHERE creator_id = '".$user_id."' and date = '".$datePicked."' and time between '".$timeStart."' and '".$timeEnd."'";	

		if ($result = dbq($location_time_query)) {					//Fetches the results of the query.
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row);
				$location_time[] = $row;
			}
			/* free result set */

			$result->close();
		}
		
		$safe_locations_time_array = array();		
		for ($i = 0; $i < count($location_time); $i++) {					//Loops through the results and inserts the entries into an array.
			$safe_locations_time_array[$i] = current($location_time[$i]);
			//echo $safe_locations_time_array[$i];
		}

		return $safe_locations_time_array;

	}

	function get_parent_lat($parent_id) {														//Get the parent's latitude for the parent's ID passed in.													
		$lat_query = "SELECT latitude FROM location WHERE creator_id = '".$parent_id."'";

		if ($result = dbq($lat_query)) {										
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row[0]);
				$lat = $row[0];
			}
			/* free result set */

			$result->close();
		}
		//echo '<br>Parent ID: ', $user_id, '<br>';					//DEBUG Statement
		return $lat;
	}

	function get_parent_long($parent_id) {														//Get the parent's longitude for the parent's ID array passed in.		
		$long_query = "SELECT longitude FROM location WHERE creator_id = '".$parent_id."'";

		if ($result = dbq($long_query)) {										
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row[0]);
				$long = $row[0];
			}
			/* free result set */

			$result->close();
		}
		//echo '<br>Parent ID: ', $user_id, '<br>';					//DEBUG Statement
		return $long;
	}
?>
