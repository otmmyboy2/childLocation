<div id="children_list" class="row center">										<!-- Displays directions for the parent to each of the parent's children. -->
	<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
	<h4>Get Directions</h4>

	<?php 												//Gets the parent's children's IDs and locations from the db to populate the dropdown.
		$user_id = get_user_id($username);

		$children_id_list = array();
		$children_id_list = get_children_id($user_id);

		$children_list = array();
		$children_list = get_children_names($children_id_list);

		$children_long_list = array();
		$children_long_list = get_children_long($children_id_list);
		$children_lat_list = array();
		$children_lat_list = get_children_lat($children_id_list);
	?>
	<body onload="locate()">
		<div id="map_canvas" style="width:100%;height:400px;"></div>
	</body>
	<script>
		var myLat;
		var myLong;
		var myLatLng;
		var map;
		var directionsDisplay = new google.maps.DirectionsRenderer();
		function locate(){														//Gets the user's current position.
			navigator.geolocation.getCurrentPosition(initialize,fail);
		}

		function initialize(position) {																	//Initializes the map.
			myLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			myLat = position.coords.latitude;
			myLong = position.coords.longitude;
			var mapOptions = {
				zoom: 15,
				center: myLatLng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);	
			<?php
				echo '
					var userMarker = new google.maps.Marker({
						position: myLatLng,
						map: map,
						animation:google.maps.Animation.BOUNCE
					});
					var infowindow = new google.maps.InfoWindow({});
					google.maps.event.addListener(userMarker, \'click\', (function (userMarker, i) {
		                return function () {
		                    infowindow.setContent("', $username, '");
		                    infowindow.open(map, userMarker);
		                }
	           		})(userMarker)); 
				';		
			?>
		}

		function fail(){
			alert('Please enable your geolocation settings and internet.');
		}

		function directions(value){													//Creates directions from the parent to the child selected.
		    var mapOptions = {
				zoom: 15,
				center: myLatLng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}

		    directionsDisplay.setMap(map); // map should be already initialized.
		    
		    var start = new google.maps.LatLng(myLat, myLong);

		    var request = {
		        origin : start,
		        destination : value,
		        travelMode : google.maps.TravelMode.DRIVING
		    };
		    var directionsService = new google.maps.DirectionsService(); 
		    directionsService.route(request, function(response, status) {
		        if (status == google.maps.DirectionsStatus.OK) {
		            directionsDisplay.setDirections(response);

			        // Display the distance:
			        var dist = response.routes[0].legs[0].distance.value / 1000;
			        document.getElementById('distance').innerHTML = 'Distance: ' +
			        	Math.round(dist) + " kilometers";

			        // Display the duration:
			        var time = response.routes[0].legs[0].duration.value / 60;
			        document.getElementById('duration').innerHTML = 'Duration: ' +
			        	Math.round(time) + " minutes";
		        }
		    });
		}
	</script>
	<h5 id='distance'></h5>
	<h5 id='duration'></h5>
	<div class="container center" style="width: 30%;">
		<div class="input-field col s12" style="padding-top:5%;">
			<?php                															//The code in this php tag will fetch children of the parent logged in and return them in a dropdown.
				$user_id = get_user_id($username);

				echo "<input id='sender_id' name='sender_id' type='hidden' value='", $user_id, "'>";

				$children_id_list = array();
				$children_id_list = get_children_id($user_id);

				$children_list = array();
				$children_list = get_children_names($children_id_list);

				$children_long_list = array();
				$children_long_list = get_children_long($children_id_list);
				$children_lat_list = array();
				$children_lat_list = get_children_lat($children_id_list);


				echo '<select name="recipient_id" onchange="directions(this.options[this.selectedIndex].value)">';													
					echo '<option value="" name="" disabled selected></option>';
					for ($i = 0; $i < count($children_list); $i++) {									//Loops through the children in the array and outputs their names into the dropdown.
						//echo $children_list_array[$i], '<br>';					//DEBUG Statement
					    echo '<option value=', $children_lat_list[$i], ',', $children_long_list[$i], ' name=', $children_id_list[$i], '>', $children_list[$i], '</option>';
					}
				echo '</select>';

				
			?>
			<label style="padding-top:5%;">Directions to Child(Required)</label>
		</div>

		<script>
			$(document).ready(function() {
		    	$('select').material_select();
			});
			$('select').material_select('destroy');
		</script>
	</div>
</div>	
