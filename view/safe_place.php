<div id="children_list" class="row center">							<!-- Displays directions to the nearest safe place. -->
	<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
	<h4>Nearest Safe Place</h4>
			<?php                															
				$user_id = get_user_id($username);

				$children_lat = array($user_id);						//Get the child currently logged in's latitude.
				$children_lat = get_children_lat($children_lat);

				$children_long = array($user_id);						//Get the child currently logged in's longitude.
				$children_long = get_children_long($children_long);

				$safe_place_names = array();							//Get the child currently logged in's name.
				$safe_place_names = get_nearest_safe_place_names();

				$safe_place_lats = array();
				$safe_place_lats = get_nearest_safe_place_lats();		//Get the safe places's latitude.
				$safe_place_longs = array();
				$safe_place_longs = get_nearest_safe_place_longs();		//Get the safe places's longitude.
				
				// echo 'User ID: ', $user_id, '<br>';								//DEBUG Statement
				// echo 'Child Lat: ', $children_lat[0], '<br>';					//DEBUG Statement
				// echo 'Child Long: ', $children_long[0], '<br>';					//DEBUG Statement

				$closest = 100;
				for ($i = 0; $i < count($safe_place_names); $i++) {									
					// echo 'Place Name: ', $safe_place_names[$i], '<br>';					//DEBUG Statement
					// echo 'Place Lat: ', $safe_place_lats[$i], '<br>';					//DEBUG Statement
					// echo 'Place Long: ', $safe_place_longs[$i], '<br>';					//DEBUG Statement
					$place_lat = $safe_place_lats[$i];
					$place_long = $safe_place_longs[$i];
					$distance = loc_distance($children_lat[0], $children_long[0], $place_lat, $place_long, "K");
					if($distance < $closest){						//If this location is the closest so far to the user then store it.
						$closest = $distance;
						$closest_name = $safe_place_names[$i];
						$closest_lat = $safe_place_lats[$i];
						$closest_long = $safe_place_longs[$i];
					}
					// echo 'Distance: ', $distance, '<br>';					//DEBUG Statement
				    
				}
				// echo '<br>----------------------------------------------<br>Closest: ', $closest_name, '<br>';					//DEBUG Statement
				// echo 'Closest Lat: ', $closest_lat, '<br>';					//DEBUG Statement
				// echo 'Closest Long: ', $closest_long, '<br>';					//DEBUG Statement
				// echo 'Closest Distance: ', $closest, '<br>';					//DEBUG Statement

				function loc_distance($lat1, $lon1, $lat2, $lon2, $unit) {				//Filters the safe places by the closeness to the current location
					$theta = abs($lon1) - abs($lon2);
					$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
					$dist = acos($dist);
					$dist = rad2deg($dist);
					$miles = $dist * 60 * 1.1515;
					$unit = strtoupper($unit);

					if ($unit == "K") {
						return ($miles * 1.609344);
					} else if ($unit == "N") {
						return ($miles * 0.8684);
					} else {
						return $miles;
					}
				}
				
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
		function locate(){
			navigator.geolocation.getCurrentPosition(initialize,fail);
		}

		function initialize(position) {
			var myLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			var mapOptions = {
				zoom: 15,
				center: myLatLng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);	
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
			var directionsDisplay = new google.maps.DirectionsRenderer();
			directionsDisplay.setMap(map); // map should be already initialized.
		    
		    var end = new google.maps.LatLng(<?php echo json_encode($closest_lat); ?>, <?php echo json_encode($closest_long); ?>);

		    var request = {
		        origin : myLatLng,
		        destination : end,
		        travelMode : google.maps.TravelMode.DRIVING
		    };
		    var directionsService = new google.maps.DirectionsService(); 
		    directionsService.route(request, function(response, status) {
		        if (status == google.maps.DirectionsStatus.OK) {
		            directionsDisplay.setDirections(response);
					
					document.getElementById('place').innerHTML = <?php echo json_encode($closest_name); ?>;
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

		function fail(){
			alert('Please enable your geolocation settings and internet.');
		}
	</script>
	<h5 id='place'></h5>
	<h5 id='distance'></h5>
	<h5 id='duration'></h5>
</div>	
