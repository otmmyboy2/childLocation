<?php session_start();						//Registers the user who has filled out the form.
	require_once("../db/lmc_db.php");		//DB connect file

	if(empty($_POST)){

		echo '<script language="javascript">';
		echo 'setTimeout(function(){alert("ERROR: Please enter in data for both the Username and Password fields.")}, 1);';
		echo '</script>';
		echo "<script>window.history.back();</script>";
	}
	else{
		$register_form[0] = $_POST['username'];				//Username of registrant
		$register_form[1] = $_POST['email'];				//Email of registrant
		$register_form[2] = $_POST['address'];				//Address of registrant
		$register_form[3] = $_POST['password'];				//Password of registrant
		$register_form[4] = $_POST['password_again'];		//Confirmation of password of registrant
		$isChild = $_POST['isChild'];						//Y for child, N for parent
		$code = $_POST['code'];								//Parent code(only populated if user registering is a child)
		$go = 'Y';											//This is Y by default meaning that unless an error is encountered in the code(when it will be set to N) then the insert statements at the end will run. If this is set to N as the result of an error then the insert statements cannot run.

		foreach ($register_form as $value) {					//Loops through the array and checks that no values in it are empty.
			if(empty($value)){
				echo '<script language="javascript">';
				echo 'setTimeout(function(){alert("ERROR: Please enter data into all of the fields.")}, 1);';
				echo '</script>';
				echo "<script>window.history.back();</script>";
				$go = 'N';
			}
			else{												//DEBUG Statement
			    //echo $value , "<br>";
			}
		}

		if($isChild == 'Y' && empty($code) ){				//if the child radio button is checked but the code is empty then display an informative error message
			echo '<script language="javascript">';
			echo 'setTimeout(function(){alert("ERROR: Please enter your parent\'s code. This will be found in your parent\'s app "About" menu option.")}, 1);';
			echo '</script>';
			echo "<script>window.history.back();</script>";
			$go = 'N';
		}elseif($isChild == 'Y'){			//If the child radio button is checked and the parent code is not empty then lookup the users table for the parent code to ensure it exists.
			$parent_code_sql = "SELECT id FROM users WHERE parent_code = '".$code."'";
			

			if ($result = dbq($parent_code_sql)) {
			/* fetch object array */
				while ($row = $result->fetch_row()) {
					//printf ("%s", $row[0]);
					$parent_id = $row[0];
				}
				/* free result set */

				$result->close();
			}
			//echo 'Parent ID: ', $parent_id, "<br>";;								//DEBUG statement

			if(empty($parent_id)){
				echo '<script language="javascript">';
				echo 'setTimeout(function(){alert("ERROR: Please enter in a valid parent code.")}, 1);';
				echo '</script>';
				echo "<script>window.history.back();</script>";
				$go = 'N';
			}
			$code = '0';
		}elseif ($isChild == 'N'){			//Otherwise the parent radio button was checked and we need to generate an id for the parent.
			$code = mt_rand(1000,9999);
			//echo $code;										//DEBUG statement
		}else{								
			echo '<script language="javascript">';
			echo 'setTimeout(function(){alert("ERROR: Please enter data into all of the fields.")}, 1);';
			echo '</script>';
			echo "<script>window.history.back();</script>";
			$go = 'N';
		}
	}

		if(strlen($register_form[3]) < 6){					//Validation to ensure that the password is at least 6 characters in length.
			echo '<script language="javascript">';
			echo 'setTimeout(function(){alert("ERROR: The password must be at least 6 characters in length.")}, 1);';
			echo '</script>';
			echo "<script>window.history.back();</script>";
			$go = 'N';
		}
		if($register_form[3] != $register_form[4]){			//Checks if the password and password confirmation fields are the same.
			echo '<script language="javascript">';
			echo 'setTimeout(function(){alert("ERROR: The password and password confirm fields do not match.")}, 1);';
			echo '</script>';
			echo "<script>window.history.back();</script>";
			$go = 'N';
		}

	

	$uniqueness_checker = "SELECT * from users where username = '".$register_form[0]."'";
	$unique = dbqn($uniqueness_checker);
	//echo $unique;							//DEBUG Statement
	if($unique > 0){
		echo '<script language="javascript">';		
		echo 'setTimeout(function(){alert("ERROR: Invalid registration!")}, 1);';
		echo '</script>';
		echo "<script>window.history.back();</script>";	
		$go = 'N';
	}elseif($go != 'N'){
				/**
		 * We just want to hash our password using the current DEFAULT algorithm.
		 * This is presently BCRYPT, and will produce a 60 character result.
		 *
		 * Beware that DEFAULT may change over time, so you would want to prepare
		 * By allowing your storage to expand past 60 characters (255 would be good)
		 */
		$password = password_hash($register_form[3], PASSWORD_BCRYPT);
		//echo '<br>', $password, '<br>';							//DEBUG Statement
		
		$sql = "INSERT INTO users(username, email, address, password, parent_code) 
		VALUES ('".$register_form[0]."','".$register_form[1]."','".$register_form[2]."','".$password."','".$code."')";

		$result2 = dbq($sql);

		$user_id = "SELECT id FROM users WHERE username = '".$register_form[0]."'";
		
		if ($result2 = dbq($user_id)) {
			/* fetch object array */
			while ($row = $result2->fetch_row()) {
				//printf ("%s", $row[0]);
				$user_id = $row[0];
			}
			/* free result set */

			$result2->close();
		}
		
		$sql2 = "INSERT INTO location(creator_id, latitude, longitude) VALUES ('".$user_id."','51.884146','-8.531648')";

		$result2 = dbq($sql2);		

		echo $result2;							//DEBUG Statement
		if($result2 == 0)
		{
			echo '<script language="javascript">';
			echo 'setTimeout(function(){alert("Invalid registration, please try again")}, 1);';
			echo '</script>';		
			echo "<script>window.history.back();</script>";
		}
		else{
			echo '<script language="javascript">';		
			//echo 'setTimeout(function(){alert("User registered!")}, 1);';
			echo '</script>';
			echo "<script>window.location = '../view/login_page.html'</script>";
		}
		if($isChild == 'Y'){
			//code for: 1. select id from users where parent code = parent code. 2. Insert into family table(parent_id, child id) values parent id and child id.
			$child_code_sql = "SELECT id FROM users WHERE username = '".$register_form[0]."'";
			

			if ($result = dbq($child_code_sql)) {
			/* fetch object array */
				while ($row = $result->fetch_row()) {
					//printf ("%s", $row[0]);
					$child_id = $row[0];
				}
				/* free result set */

				$result->close();
			}
			//echo 'Parent ID: ', $parent_id, "<br>";							//DEBUG statement
			//echo 'Child ID: ', $child_id, "<br>";								//DEBUG statement

			$sql = "INSERT INTO family(parent_id, child_id) VALUES ('".$parent_id."','".$child_id."')";

			$family_insert = dbq($sql);
			//echo $family_insert;							//DEBUG Statement
			if($family_insert == 0)
			{
				echo '<script language="javascript">';
				echo 'setTimeout(function(){alert("Invalid registration, please try again")}, 1);';
				echo '</script>';		
				echo "<script>window.history.back();</script>";
			}
		}
		if($result == 0)
		{
			echo '<script language="javascript">';
			echo 'setTimeout(function(){alert("Invalid registration, please try again")}, 1);';
			echo '</script>';		
			echo "<script>wwindow.history.back();</script>";
		}
		else{
			echo '<script language="javascript">';		
			echo 'setTimeout(function(){alert("User registered!")}, 1);';
			echo '</script>';
			echo "<script>window.location = '../view/login_page.html'</script>";
		}
	}
	else{
		echo '<script language="javascript">';
		echo 'setTimeout(function(){alert("Invalid registration, please try again")}, 1);';
		echo '</script>';		
		echo "<script>wwindow.history.back();</script>";
	}
?>



