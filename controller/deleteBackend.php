 <?php 											//Deletes the user passes in.
 	require_once("../db/lmc_db.php");			//DB connect file
	require_once("../model/common.php");		//Common functionality file

	if(empty($_POST)){														//Checks if the login form submitted is blank and if so will return the user to the login page and display a message informing the user what has gone wrong. Because this is done server-side it helps to prevent XSS(cross site scripting).
		// echo '<script language="javascript">';
		// echo 'setTimeout(function(){alert("Please enter in data for both the Username and Password fields.")}, 1);';
		// echo '</script>';
		// echo "<script>window.location = '../view/login_page.html'</script>";	//Returns the user to the login page they came from.
	}
	else{
		$delete_id = $_POST['delete_id'];

		$result = delete_user($delete_id);
		echo "<script>window.location = '../index.php'</script>";
	}
?>