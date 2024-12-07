
<?php

	session_start();

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

	<title>Contact</title>
	
	<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="../css/template.css" type="text/css"/>
	<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
	
	<script src="../js/jquery-1.8.2.min.js" type="text/javascript" ></script>
	<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8" ></script>
	<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8" ></script>
	
	<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#ContactUsForm").validationEngine();
		});
  	</script>
</head>

<body>
	<div id="parent_container">
		<div id="websiteTitle_container" style="padding-bottom:11px;">
			<div id="logo_container">
				<!---<img src="Images/logo.png" alt="Keek"/>-->
				<div style="margin-left: -1%; padding-top:9%;">
						keeping everyone, everywhere, knowledgeable
					</div>
			</div>
					
			<div id="login_container" style="margin-top: -4%;">
				<?php
   					if(isset($_SESSION['AdminUserName']))
	   				{
	   		 			echo "<a href='../Admin/AdminLogout.php'>";
	   					echo "Log Out";
	   		 			echo "</a>";
	   				 }
	   		 		else
	   				{
	   					echo "<a href='../Admin/AdminLogin.php'>";
	   		 			echo "Log In";
	   		 			echo "</a>";
	   		 		}
   			 	?>

			</div>
		</div>
				
		<div id="navbar_container">		.
			<div id="navlinks_container">
				<ul>
					<li><a href="../default.php">Home</a></li>
					<li><a href="../Politicians/SearchPolitician.php">Politicians</a></li>
					<li><a href="../Constituencies/SearchConstituency.php">Constituencies</a></li>
					<li><a href="../Bills/ViewActs.php">Bills/Acts</a></li>
					<li><a href="ContactUs.php">Contact</a></li>
					<li>
					<?php
	   					if(isset($_SESSION['AdminUserName']))
		   				{
		   		 			echo "<a href='../Admin/AdminControl.php'>";
				   			echo "Control Panel";
				   			echo "</a>";
						}
					?>	
					</li>
				</ul>
			</div>
		</div>
					
		<div id="header_container"></div>
					
		<div id="bar_container">.</div>
			<div id="contactUs_container">
				<div style="margin-left: 5%;">
					<form action="SendContactUsEmail.php" method="post" id="ContactUsForm">
						<h1>Contact Us</h1><br/>
						
						<label for="lblFullName">Full Name:</label>
						<input type="text" name="txtFullName" class="validate[required, custom[onlyLetterSp]] text-input"/><br/>
						
						<label for="lblEmail">Email:</label>
						<input type="text" name="txtEmail" class="validate[required, custom[email]] text-input" /><br />
						
						<label for="lblSybject">Subject:</label>
						<input type="text" name="txtSubject" class="validate[required]" /><br />
						
						<label for="lblMessage">Message:</label> <br /> 
						<textarea name="txtEmailBody" style="width: 230px; height: 140px" class="validate[required]"></textarea><br />
						<br />
				
						<input type="submit" name="btnContact" value="Submit" style="margin-left: 8%;"/>
					
					</form>
				</div>
			</div>
		</div>
	

	<?php
		include("../header_footer/footer.html");
	?>
	
	
</body>

</html>
