<?php 										//Stores the location of the currently logged in user.
	require_once("../db/lmc_db.php");		//DB connect file
	
	$user_id = $_REQUEST["user_id"];
	$latitude = $_REQUEST["latitude"];
	$longitude = $_REQUEST["longitude"];

	$sql = "SELECT * FROM location WHERE creator_id = '".$user_id."'";	

	$exists = dbqn($sql);

	if($exists > 0){			
	    $sql = "UPDATE location SET creator_id = '".$user_id."', latitude = '".$latitude."', longitude = '".$longitude."'  WHERE creator_id = '".$user_id."'";
	}
	else
	{
	   	$sql = "INSERT INTO location(creator_id, latitude, longitude) VALUES ('".$user_id."','".$latitude."','".$longitude."')";
	}	
	
	$route_history = "INSERT INTO location_history(creator_id, latitude, longitude, date, time) VALUES ('".$user_id."','".$latitude."','".$longitude."', curdate(), SUBSTRING(SUBTIME( curtime( ) , '02:00:00' ), 1, 5))"; //subtract 2 hours to account for server local time
	$old_route_delete = "DELETE FROM location_history WHERE utc < DATE_SUB(NOW(), INTERVAL 7 DAY)";
	$result = dbqn($sql);
	$result2 = dbqn($route_history);
	$result3 = dbq($old_route_delete);
	//echo "<script>console.log('Insert Result: ', $result);</script>";					//DEBUG Statement

?>