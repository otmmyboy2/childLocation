<?php session_start();						//Backend used for logging in the user.
	require_once("../db/lmc_db.php");		//DB connect file
	require("../resources/password_compat-master/lib/password.php");		
	if(empty($_POST)){														//Checks if the login form submitted is blank and if so will return the user to the login page and display a message informing the user what has gone wrong. Because this is done server-side it helps to prevent XSS(cross site scripting).
		echo '<script language="javascript">';
		echo 'setTimeout(function(){alert("Please enter in data for both the Username and Password fields.")}, 1);';
		echo '</script>';
		echo "<script>window.location = '../view/login_page.html'</script>";	//Returns the user to the login page they came from.
	}
	else{
		$username = $_POST['username'];
		$password = $_POST['password'];			
	}
	//echo $username, "<br>", $password, '<br>';							//DEBUG Statement
	/*$mysqli = new mysqli('localhost', 'root', 'root', 'LMC');		//Use this to check if you can connect to your db.
	if ($mysqli->connect_error) {
	    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}*/

	if(empty($username || $password)){
		echo '<script language="javascript">';
		echo 'setTimeout(function(){alert("Please enter in data for both the Username and Password fields.")}, 1);';
		echo '</script>';
		echo "<script>window.history.back()</script>";
	}
	else{
		$hash = "SELECT password FROM users WHERE username = '".$username."'";
		
		if ($result = dbq($hash)) {
			/* fetch object array */
			while ($row = $result->fetch_row()) {
				//printf ("%s", $row[0]);
				$hash = $row[0];
			}
			/* free result set */

			$result->close();
		}
		//echo '<br>', $hash, '<br>', 'Pwd: ', $password, '<br>';					//DEBUG Statement
		//echo 'K: ' , password_verify($password, $hash);					//DEBUG Statement

		if (password_verify($password, $hash)) {		
			$sql = "SELECT username, password FROM users WHERE username = '".$username."' AND password = '".$hash."'";
			
			$result = dbqn($sql);
			if($result > 0)					//If the user's login credentials are valid.
			{
				$isChild = "SELECT * FROM users WHERE username = '".$username."' AND parent_code = '0'";	
			

				$child_id = dbqn($isChild);


				//echo 'Is a Child: ', $child_id, "<br>";					//DEBUG statement
				//$child_id = 0;											//Remove child_id undeclared error if parent is logging in.
				if($child_id > 0){										//If the child_id is greater than 0 then the user logging in is a child. Otherwise the user logging in is a parent.
					$isChild = 'Y';
				}
				else{
					$isChild = 'N';
				}

				$_SESSION['uid'] = $username;										//Created cookies for the username of the user logged in and whether the user is a child. isChild = 'Y' for a child, 'N' for a parent.
				$_SESSION['isChild'] = $isChild;
				echo '<script language="javascript">';
				//echo 'setTimeout(function(){alert("Valid Login.")}, 1);';					//DEBUG statement
				echo '</script>';
				echo "<script>window.location = '../index.php'</script>";
			}
			else{
				echo '<script language="javascript">';
				echo 'setTimeout(function(){alert("Invalid Login.")}, 1);';
				echo '</script>';
				echo "<script>window.location = '../view/login_page.html'</script>";
			}
		} else {
			echo '<script language="javascript">';
			echo 'setTimeout(function(){alert("Invalid Login.")}, 1);';						
			echo '</script>';
			echo "<script>window.location = '../view/login_page.html'</script>";
		}
	}
?>



