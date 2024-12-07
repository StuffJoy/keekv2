<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="../css/template.css" type="text/css"/>
	<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
	
	<script src="../js/jquery-1.8.2.min.js" type="text/javascript" ></script>
	<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8" ></script>
	<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8" ></script>
	
	<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#loginForm").validationEngine('attach', {binded: false});
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
					
			<div id="login_container">
				<?php
					session_start();
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
					<li><a href="../Contact/ContactUs.php">Contact</a></li>
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
					
		<!--<div id="header_container"></div>
					
		<div id="bar_container">.</div>-->

	
		<?php
			
			if(isset($_SESSION['LoginStatus'])) //Variable passed to check state of login process
				if($_SESSION['LoginStatus'] == "Unsuccessful")
				{
					echo "Incorrect Email or Password" . "<br>" . "Please Try Again...";
					//unset($_SESSION['LoginStatus']);
				}
		
		?>
		<div id="contactUs_container">
			<!--<div id="login_container">-->
				<h1>Log In</h1>
				<form action="../DatabaseConnections/AdminConnections.php" method="post" id="loginForm" class="formular">
				
	
					Please Enter Your Email: <input name="txtAdminEmail" type="text" class="validate[required, custom[email], custom[gmailOnly]] text-input" />
					Password: <input type="password" name="txtPassword"  class="validate[required] text-input"/>
						
					<input type="submit" name="btnAdminLogin" value="Sign In" />
					<a href="../Admin/ForgotPassword.php">Forgot Your Password?</a>
				</form>
			<!--</div>	-->
		</div>	
		</div>
		<?php
				include("../header_footer/footer.html");
		?>
		
</body>

</html>
