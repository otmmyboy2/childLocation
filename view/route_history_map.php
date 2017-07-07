<div id="route_history_map" class="row center">										<!-- This page displays the route of the child specified in the route history page. -->
	<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
	<h4>Route History</h4>

	<?php
		// <?php echo json_encode($parent_lat);
		$recipient_id = $_REQUEST["recipient_id"];
		$datePicker = $_REQUEST["datePicker"];
		$time = $_REQUEST["time"]; 
		// echo "<script>console.log('recipient_id: ', $recipient_id);</script>";					//DEBUG Statement
		// echo "<script>console.log('datePicker: ', $datePicker);</script>";						//DEBUG Statement
		// echo "<script>console.log('time: ', $time);</script>";									//DEBUG Statement

		$history_lat_list = array();
		$history_lat_list = get_location_history_lat($recipient_id, $datePicker, $time);
		$history_long_list = array();
		$history_long_list = get_location_history_long($recipient_id, $datePicker, $time);
		$history_time_list = array();
		$history_time_list = get_location_history_time($recipient_id, $datePicker, $time);
		$total = count($history_time_list);

		//echo "<script>console.log('total: ', $total);</script>";									//DEBUG Statement


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
			var waypts = [];
			var wayptsArray = [];		

			<?php
				for ($i = 0; $i < count($history_time_list); $i++) {					
					echo "waypts[", $i, "] = new google.maps.LatLng(", $history_lat_list[$i], ",", $history_long_list[$i], ");";
					echo "wayptsArray.push({location: waypts[", $i, "], stopover: false});";

					echo '
						var wayptLatLng', $i ,' = new google.maps.LatLng(', $history_lat_list[$i], ",", $history_long_list[$i], ');
						var wayptMarker', $i ,' = new google.maps.Marker({
							position: wayptLatLng', $i ,',
							icon: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=', $i ,'|FF0000|000000",
							map: map
						});
						
						var infowindow = new google.maps.InfoWindow({});
						google.maps.event.addListener(wayptMarker', $i ,', \'click\', (function (wayptMarker', $i ,', i) {
			                return function () {
			                    infowindow.setContent("', $history_time_list[$i], '");
			                    infowindow.open(map, wayptMarker', $i ,');
			                }
		           		})(wayptMarker', $i ,', ', $i ,'));
					';	
				}
			?>

		    var mapOptions = {
				zoom: 15,
				center: myLatLng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}

		    directionsDisplay.setMap(map); // map should be already initialized.
			directionsDisplay.setOptions( { suppressMarkers: true } );

		    var last_element = waypts[waypts.length - 1];

		    var request = {
		        origin : waypts[0],
		        destination : last_element,		        
				waypoints: wayptsArray,
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

		function fail(){
			alert('Please enable your geolocation settings and internet.');
		}
	</script>
	<h5 id='distance'></h5>
	<h5 id='duration'></h5>


	<table class="striped centered">
		<thead>
			<tr>
				<th data-field="id">#</th>
				<th data-field="name">Time</th>
				<th data-field="price">Latitude</th>
				<th data-field="price">Longitude</th>
			</tr>
		</thead>

		<tbody>
			<?php 																//Display the id, time, and coordinates of the route displayed.
				for ($i = 0; $i < count($history_time_list); $i++) {			
					echo "<tr>";
						echo "<td>", $i, '</td>';
						echo "<td>", $history_time_list[$i], '</td>';
						echo "<td>", $history_lat_list[$i], '</td>';
						echo "<td>", $history_long_list[$i], '</td>';
					echo "</tr>";
				}
			?>
		</tbody>
	</table>

	<div class="container center" style="padding-top:2%;padding-left:33%;">
		<div class="col s6 m6 l6 center" onClick="window.history.back();">
			<a><input type="submit" value="Back" class="btn waves-effect waves-light center col s12" style="width:100%;"></a>
		</div>
	</div>
</div>	
