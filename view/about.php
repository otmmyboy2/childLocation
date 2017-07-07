<?php 																				//This php section will fetch the parent code for the parent currently logged in.
	require_once("db/lmc_db.php");		//DB connect file		
	$id_query = "SELECT id FROM users WHERE username = '".$username."'";//getting ID of whom ever is logged in

	if ($result = dbq($id_query)) {
		/* fetch object array */
		while ($row = $result->fetch_row()) {
			//printf ("%s", $row[0]);
			$user_id = $row[0];
		}
		/* free result set */
		$result->close();
	}

	$parent_code_query = "SELECT parent_code FROM users WHERE username = '".$username."'";//getting parent code of that parent

	if ($result = dbq($parent_code_query)) {
		/* fetch object array */
		while ($row = $result->fetch_row()) {
			//printf ("%s", $row[0]);
			$parent_code = $row[0];
		}
		/* free result set */
		$result->close();
	}
?>
<div id="children_list" class="row center">
	<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
	<h3 class="header center orange-text" id='main_title'>About</h3>
	

	<ul class="collapsible" data-collapsible="accordion">
	    <li>
	    	<div class="collapsible-header"><i class="material-icons">announcement</i>Purpose of this application</div>
	    	<div class="collapsible-body"><p>To allow a parent to track the GPS location of their children’s mobile device and provide a history of the child's past locations. 
	    	<br>This application is intended to be a tool to help a parent to have a greater oversight of their children’s movements and whereabouts.</p></div>
	    </li>
	    <li id="parent_code_row">
	        <div class="collapsible-header"><i class="material-icons">supervisor_account</i>Parent Code</div>
	        <div class="collapsible-body">
	        	<h4>
					<?php echo $parent_code; ?>
				</h4>
			</div>
	    </li>
	    <li>
	      <div class="collapsible-header"><i class="material-icons">stars</i>Main Features</div>
	      <div class="collapsible-body"><p align="left">Features of this application are:<br>
	      1: The parent will have the ability to see their children's current location.<br>
	      2: The parent will be able to track their child's locations for a specific time peiod within the last week.<br>
	      3: The parent will be able to send a warning messages to their children.<br>
	      4: The child will be able to send the parent an SOS(urgent) message.<br>
	      5: The child will be able to access the directions to their parent from their current location.<br>
	      6: The child will be able to get diecrtions to the nearest safe place(Garda(police) station, Hospital) in case of an emergency.</p></div>
	    </li>
	    <li>
	      <div class="collapsible-header"><i class="material-icons">spellcheck</i>Frequently Asked Questions</div>
	      <div class="collapsible-body"><p> 
	      <b>Q1: How do I register my child?</b><br>
	      Answer: Get the "Parent Code" as explained below. Log out of the app, click the "Register" link. 
	      Fill out the registration form for the child. <br>
	      Click the register as child option. <br>
	      Enter the "Parent Code" in the field displayed.<br><br>
	       
	      <b>Q2: What is the "Parent Code"?</b><br>
	      Answer: In the "About" page click the "Parent Code". This will show you a unique four digit code assigned to you.<br>
	      This code will link you to your child.<br><br>
	       
	      <b>Q3: What do I need to make this app work?</b><br>
	      Answer: For the Android application your mobile phone must have Android version 4.3.1(Jellybean) or later.<br>
	      For the website you must have an up to date browser(Chrome, Firefox). <br>
	      You must also, on both the application and the website enable location tracking(GPS and mobile internet/WiFi on mobile devices).<br><br>
	       
	      <b>Q4: Do I need my mobile phone to track my child?</b><br>
	      Answer: No, you can simply use the website to track your child(ren).<br><br>
	       
	      <b>Q5: My child has not moved location for a while now and I am concerned. <br>
	      How can I communicate my concern to my child?</b><br>
	      Answer: Click the "Send Warning" menu option, select the child you wish to message, and the message contents.<br>
	      Then click the submit button. This will send your child the message you have specified.
	      
	      </p></div>
	    </li>
	    <li>
	      <div class="collapsible-header"><i class="material-icons">android</i>Android App Download</div>
	      <div class="collapsible-body"><p>Click <a href="resources/LMC.apk">here</a> to download the Android application.</p></div>
	    </li>
	    <li>
	        <div class="collapsible-header"><i class="material-icons">report_problem</i>Disclaimer</div>
	      <div class="collapsible-body"><p>The Author of this site/application is neither a parent nor a social worker 
	      and is in no way repsonsible for how you utilize this site/application. 
	      <br>You alone are responsible for your child's protection, safety and well-being. <br>
	      This site/application is meant only as a tool and is not a replacement for responsible parenting.</p></div>
	    </li>
	</ul>

	<script>
		var isChild = <?php echo json_encode("$isChild"); ?>;			//Gets the $isChild param from php and puts it into an isChild variable in javascript.
			
		if(isChild == 'Y'){												//If the user is a child then do not display the parent code.
			document.getElementById('parent_code_row').style.display = 'none';
		}
	</script>	
</div>	