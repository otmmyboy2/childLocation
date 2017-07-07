<?php 															//This file is the main file. Every other page that is displayed is included in this file. This means that all the helper files, stylesheets, etc only have to be included in this file.
	session_start(); 
	//echo a single entry from the array
	//echo $_SESSION['uid'], '<br>', $_SESSION['isChild'];		//Gets the session variables uid(username) and isChild(Y for child, N for parent).
	
	if( !isset($_SESSION["uid"]) ){
	    echo '<script>window.location = "view/login_page.html"</script>';
	    exit();
	}

	error_reporting(E_ALL);									//Uncomment for db related error messages.
	ini_set('display_errors', TRUE);						//Makes a lot of whitespace appear under the navbar
	ini_set('display_startup_errors', TRUE);				//even if there are no errors. Also makes the navbar elements disappear.
	include("model/common.php");
?>
<!DOCTYPE html>
<html ng-app = "ngMap">
<head>
	<script src="controller/angular.min.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<title>LMC</title>

	<!-- CSS  -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="resources/materialize/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="resources/materialize/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

	<script src="http://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>			<!-- Google maps API link. -->
	<script src="bower_components/angular-route/angular-route.js"> </script>													<!-- Include the routing directive for angular. -->
	<script src="controller/ng-map.js"></script>																				<!-- The angular map plugin. -->
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>															<!-- JQuery link, allows items to process in real time. -->
	<script src="resources/materialize/js/materialize.js"></script>																<!-- Materialize CSS framework link. -->

	<link rel="icon" href="resources/images/logo.ico">
</head>
<body style="display: flex;min-height: 100vh;flex-direction: column;">
	<nav class="light-blue lighten-1" role="navigation">
		<div class="nav-wrapper center" style="margin-left:5%;"><a id="logo-container" href="index.php">Locate My Child</a>
			<ul class="right">
				<li>
					<?php 
						//session_start(); 
						//echo a single entry from the array
						//echo $_SESSION['uid'], '<br>', $_SESSION['isChild'];		//Gets the session variables uid(username) and isChild(Y for child, N for parent).
						$username = $_SESSION['uid'];								//Puts the username and isChild(Y/N) cookie data into a variable. 
						$isChild = $_SESSION['isChild'];							
						echo 'Welcome ', $username, '&nbsp&nbsp';
						//echo 'Parent? ', $isChild, '.';
					?>
				</li>
			</ul>

			<ul id="nav-mobile" class="side-nav left">																			<!-- Menu on the top left of the screen. -->
				<img src="resources/images/map_icon.png" alt="" class="responsive-img valign profile-image-login">
				<li id='home'><a href="?p=home">Home</a></li>
				<li id='route_history'><a href="?p=route_history">Route History</a></li>
				<li id='send_warning'><a href="?p=send_warning">Send Warning</a></li>
				<li id='get_directions'><a href="?p=get_directions">Get Directions</a></li>
				<li id='check_in_option'><a href="?p=check_in">Check-In</a></li>
				<li id='send_sos_option'><a href="?p=send_sos">Send SOS</a></li>
				<li id='directions_home_option'><a href="?p=directions_home">Directions To Parent</a></li>
				<li id='safe_place_option'><a href="?p=safe_place">Nearest Safe Place</a></li>
				<li id='delete_child'><a href="?p=delete_child">Delete Child</a></li>
				<li id='about'><a href="?p=about">About</a></li>
				<li id=logout><a href="?p=logout">Logout</a></li>
			</ul>
			<a href="#" data-activates="nav-mobile" class="button-collapse show-on-large"><i class="material-icons">menu</i></a>
		</div>
	</nav>
	<div class="section no-pad-bot" id="index-banner" style="flex: 1 0 auto;">
		<div class="container">
			<script>
				function getPosition(){	
					navigator.geolocation.getCurrentPosition(saveLocation,fail);									//Uses Google Maps Geolocation to get the current position and pass it to the saveLocation function if successful, otherwise call the fail function.
					//alert("Getting Position!!!");										//DEBUG statement
				}
				function saveLocation(position) {
					var myLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);		//Gets the latitude and longitude of the user's device
					// alert("Saving Location!!!");										//DEBUG statement
					console.log('Latitude: ', position.coords.latitude);				//DEBUG statement
					console.log('Longitude: ', position.coords.longitude);			//DEBUG statement
					<?php 							//Statement to insert the latitude and longitude into the database.
						require_once("db/lmc_db.php");		//DB connect file

						$id_query = "SELECT id FROM users WHERE username = '".$username."'";		//Get the user's id for the insert

						if ($result = dbq($id_query)) {
							/* fetch object array */
							while ($row = $result->fetch_row()) {
								//printf ("%s", $row[0]);
								$user_id = $row[0];
							}
							/* free result set */

							$result->close();
						}
						//echo "console.log('User ID: ', $user_id);";					//DEBUG Statement
					?>
				    var user_id = <?php echo json_encode("$user_id"); ?>; 					//Passes the php variable holding the user currently logged in's ID to a javascript variable for the database insert of the location.

					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {					
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							//document.getElementById("txtHint").innerHTML = xhttp.responseText;
							//console.log("Response: ", xhttp.responseText);				//DEBUG Statement
						}
					}
				    xhttp.open("GET", "controller/store_location.php?user_id=" + user_id + "&" +"latitude=" + position.coords.latitude + "&" +"longitude=" + position.coords.longitude, true);		//Sends the current user's id and coordinates to the store location php file.
				    xhttp.send();
				}
				window.onload = function () {
					getPosition(); //Make sure the function fires as soon as the page is loaded
				}
				window.setInterval(function(){									//Call the positioning function on page load and every 10 minutes(6000000 miliseconds) afterwards.
					getPosition();
				}, 600000);
				function fail(){												//If the geolocation has failed then output this error message
					alert('Please enable your geolocation settings and internet.');
				}
			</script>
			<?php 
				$message = check_messages($user_id);					//Checks for messages pending for the user logged in.
				if($message != ""){
					// echo $message;				//DEBUG Statement
					$replacement = '\n';
					$materialize_message = str_replace('<br>', $replacement, $message);
					echo "<script>Materialize.toast('".$message."', 10000,'',function(){alert('".$materialize_message."')});</script>";			//Displays the messages(if present) in a toast and afterwards an alert box, ensuring that the user has seen the message.
				}

				switch (isset($_GET['p']) ? $_GET['p'] : 'Error!') {			//Depending on which parameter(?p=) is passed, display the appropriate page.
					case "home":							//Homepage
						include("view/home.php");
						break;

					case "delete_child":					
						include("view/delete_child.php");
						break;

					case "check_in":					
						include("view/check_in.php");
						break;	

					case "route_history":					
						include("view/route_history.php");
						break;	

					case "route_history_map":					
						include("view/route_history_map.php");
						break;	

					case "send_warning":					
						include("view/send_warning.php");
						break;		

					case "send_sos":					
						include("view/send_sos.php");
						break;	

					case "get_directions":					
						include("view/get_directions.php");
						break;	

					case "directions_home":					
						include("view/directions_home.php");
						break;	

					case "safe_place":					
						include("view/safe_place.php");
						break;
						
					case "about":					
						include("view/about.php");
						break;		
						
					case "logout":						//Logs user out, clears session
						session_destroy();
						echo "<script>window.location = 'view/login_page.html'</script>";
						break;	
						
					default:							//Defaults the page to the home page. If anything not in this switch statement is added then the home page will be loaded.
						//echo "<script>window.location = 'index.php?p=home'</script>";
						include("view/home.php");
				}

				$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			?>
		</div>
	</div>
	<footer class="page-footer orange">
		<div class="footer-copyright">
			<div class="container">
			©<a class="orange-text text-lighten-3" href="index.php"> TiMai</a> 2016
			</div>
		</div>
	</footer>

	<script>
		(function($){
			$(function(){
				$('.button-collapse').sideNav();
			}); // end of document ready
		})(jQuery); // end of jQuery name space
	</script>
	<script>
		var isChild = <?php echo json_encode("$isChild"); ?>;			//Gets the $isChild param from php and puts it into an isChild variable in javascript.
		
		//console.log(isChild);											//DEBUG statement
		if(isChild == 'Y'){																//If a child is logged in then hide parent options
			document.getElementById('delete_child').style.display = 'none';	
			document.getElementById('route_history').style.display = 'none';	
			document.getElementById('send_warning').style.display = 'none';	
			document.getElementById('get_directions').style.display = 'none';	

		}else if(isChild == 'N'){														//If a parent is logged in then hide child options
			document.getElementById('check_in_option').style.display = 'none';
			document.getElementById('send_sos_option').style.display = 'none';
			document.getElementById('directions_home_option').style.display = 'none';	
			document.getElementById('safe_place_option').style.display = 'none';	
		}
	</script>
	<script>
		setInterval(function() {			//Checking for messages every 5 seconds.
			<?php
				$message = '';
				$message = check_messages($user_id);
				if($message != ""){
					// echo $message;				//DEBUG Statement
					$replacement = '\n';
					$materialize_message = str_replace('<br>', $replacement, $message);
					echo "Materialize.toast('".$message."', 10000,'',function(){alert('".$materialize_message."')});";	
				}
			?>
		}, 5000);			
	</script>
	</body>
</html>
