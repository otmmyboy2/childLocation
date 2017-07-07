<div id="check_in" class="row center">			<!-- Page that will allow the user to manually check in, which will save their location manually, rather than automatically, which happens with no input from the user. -->
	<form method='POST' action='' id=''>
		<img src="resources/images/logo.png" alt="" class="responsive-img valign profile-image-login">
		<h4>Check In</h4>
		<div class="container center">
			<img src="resources/images/checkin.jpg" style="width:40%;height:40%;" class="responsive-img valign ">
		</div>
		<div class="container center" style="padding-left:33%;">
			<div class="col s6 m6 l6 center" onClick="checkIn();">
				<a><input type="submit" value="Submit" class="btn waves-effect waves-light center col s12" style="width:100%;"></a>
			</div>
		</div>
	</form>
</div>

<script>
function checkIn() {
	alert('You have checked in.');
	window.location = './index.php';
}
</script>