<?php

include ("../DatabaseConnections/Connection.php"); 
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Create New Admin</title>
	
	<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="../css/template.css" type="text/css"/>
	<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
	
	<script src="../js/jquery-1.8.2.min.js" type="text/javascript" ></script>
	<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8" ></script>
	<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8" ></script>
	
	<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#createAdminForm").validationEngine();
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
   					if(isset($_SESSION['txtUserName']))
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
	
		<div id="contactUs_container" style="padding:20px;">
			<h1>Create New Administrator</h1>
			<form action="AdminContact.php" name="CreateAdmin" method="post" id="createAdminForm" class="formular">
				Enter Preferred Username: <input name="txtUserName" type="text" id="username" maxlength="15" class="validate[required, minSize[5], maxSize[15]] text-input" /><br/>
				Enter User Email Address: <input type="email" name="txtEmail" id="email" maxlength="50" class="validate[required, custom[email], custom[gmailOnly]] text-input" /> <br/>
		
				Enter Password: 
				<input type="password" name="txtPassword" id="password" class="validate[required, minSize[6] text-input"/><br/>
				
				Re-Enter Password: 
				<input type="password" name="txtRePassword" id="repassword" class="validate[required, equals[password] text-input"/><br/><br/>
		
				Please Select Security Question: 
				<?php
					$sql="SELECT * FROM SecurityQuestions";
					$res=mysql_query($sql, $con);
				
					echo "<select name='ddlSecurityQuestion' class='validate[required]'>";
					echo "<option value='' selected='selected'>Select Security Question</option>";
					while ($row=mysql_fetch_array($res))
					{
						echo "<option value=\"{$row['QuestionId']}\">{$row['Question']}</option>";
					}
					
					echo "</select>";
				?>
				<br/>
										
				Security Answer: <input type="text" name="txtSecurityAnswer" class="validate[required]"/><br/>
		
		
				<input type="submit" name="btnCreateAdmin" value="Next" />
			</form>
		</div>
	</div>
	<?php
		include('../header_footer/footer.html');
	?>
	
</body>
</html>
