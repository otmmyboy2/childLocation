<?php
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

	$result = dbqn($sql);
	//echo "<script>console.log('Insert Result: ', $result);</script>";					//DEBUG Statement

?>