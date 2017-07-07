<div id="directions_home" class="row center">															<!-- Gives the child directions to the parent. -->
	<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
	<h4>Directions To Parent</h4>

	<?php 												//Gets the parent's id and location from the db.
		$user_id = get_user_id($username);

		$parent_id = get_parent_id($user_id);

		$parent_lat = get_parent_lat($parent_id);
		$parent_long = get_parent_long($parent_id);
		
	?>
	<body onload="locate()">
		<div id="map_canvas" style="width:100%;height:400px;"></div>
	</body>
	<script>
		
		function locate(){																//Gets the current geolocation of the user.
			navigator.geolocation.getCurrentPosition(initialize,fail);
		}

		function initialize(position) {													//Gets passed the current position of the user and displays directions from the users to the parent.
			var myLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			var mapOptions = {
				zoom: 15,
				center: myLatLng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);	
			
			var directionsDisplay = new google.maps.DirectionsRenderer();
			directionsDisplay.setMap(map); // map should be already initialized.
		    
		    var end = new google.maps.LatLng(<?php echo json_encode($parent_lat); ?>, <?php echo json_encode($parent_long); ?>);

		    var request = {
		        origin : myLatLng,
		        destination : end,
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
</div>	
