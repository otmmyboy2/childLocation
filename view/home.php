<?php 															//This page is the default page every user sees when they initially log in.
	$icons = array("http://maps.google.com/mapfiles/ms/icons/blue-dot.png", 		//Array containing custom markers for the children.
				"http://maps.google.com/mapfiles/ms/icons/purple-dot.png", 
				"http://maps.google.com/mapfiles/ms/icons/orange-dot.png", 
				"http://maps.google.com/mapfiles/ms/icons/green-dot.png", 
				"http://maps.google.com/mapfiles/ms/icons/pink-dot.png");

	$colors = array("#6991FD", "#8E67FD", "#FF9900", "#00E64D", "#E661AC");			//Colors for the children's names corresponding to the custom marker's in the array above.

	$user_id = get_user_id($username);

	$children_id_list = array();
	$children_id_list = get_children_id($user_id);

	$children_list = array();
	$children_list = get_children_names($children_id_list);

	$children_long_list = array();
	$children_long_list = get_children_long($children_id_list);
	$children_lat_list = array();
	$children_lat_list = get_children_lat($children_id_list);
	// for ($i = 0; $i < count($children_id_list); $i++) {					//DEBUG statement
	// 	echo $children_id_list[$i], '<br>';
	// 	echo $children_list[$i], '<br>';
	// 	echo $children_long_list[$i], '<br>';
	// 	echo $children_lat_list[$i], '<br>';
	// }
?>
<div id="directions_home" class="row center">
	<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
</div>
<h3 class="header center orange-text" id='main_title'>Children Location Map</h3>
<body onload="locate()">
	<div id="map_canvas" style="width:100%;height:400px;"></div>
</body>
<script>
	var isChild = <?php echo json_encode("$isChild"); ?>;			//Gets the $isChild param from php and puts it into an isChild variable in javascript.
		
	if(isChild == 'Y'){			
		document.getElementById('main_title').innerHTML = 'Your Location';
	}

	function locate(){																//Gets the current geolocation of the user.
		navigator.geolocation.getCurrentPosition(initialize,fail);
	}

	function initialize(position) {													//Gets passed the current position of the user and displays directions from the user to the parent.
		var myLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		var mapOptions = {
			zoom: 15,
			center: myLatLng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

		<?php	
			for ($i = 0; $i < count($children_id_list); $i++) {					//Loops through the children and adds a marker with their name at their location.
				echo '
				var childLatLng', $i ,' = new google.maps.LatLng(', $children_lat_list[$i], ',', $children_long_list[$i], ');
				var childMarker', $i ,' = new google.maps.Marker({
					position: childLatLng', $i ,',
					icon: "', $icons[$i], '",
					map: map
				});
				
				var infowindow = new google.maps.InfoWindow({});
				google.maps.event.addListener(childMarker', $i ,', \'click\', (function (childMarker', $i ,', i) {
	                return function () {
	                    infowindow.setContent("', $children_list[$i], '");
	                    infowindow.open(map, childMarker', $i ,');
	                }
           		})(childMarker', $i ,', ', $i ,')); 
				';
			}

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
	
</script>

<form action="#">
	<div class="row center" style="margin-top:2%;">
		<?php 										//Displays the children of the current user below the map.
			for ($i = 0; $i < count($children_id_list); $i++) {					
				// echo '
				// 	<input type="checkbox" onclick="toggle(\'', $i ,'\')" checked="checked" class="filled-in" style="color:', $colors[$i] ,' !important;background-color:', $colors[$i] ,' !important;" id="', $i ,'" />
				// ';
				echo '
			    	<label for="', $i ,'" style="font-size: 150%;margin-right:2%;color:', $colors[$i] ,' !important;">', $children_list[$i], '</label>
				';
			}
		?>
	</div>
</form>

<!--	Future development
<input type="checkbox" onclick="toggle(\'', $i ,'\')" checked="checked" class="filled-in" style="color:', $colors[$i] ,' !important;background-color:', $colors[$i] ,' !important;" id="', $i ,'" />
<label for="', $i ,'" style="margin-right:2%;color:', $colors[$i] ,' !important;">', $children_list[$i], '</label>

<script>
	function toggle(type) {
		if(document.getElementById("', $i ,'").checked) {
	    	childMarker', $i,'.setVisible(true);
		} else {
	    	childMarker', $i,'.setVisible(false);
	    }
	}
</script> -->