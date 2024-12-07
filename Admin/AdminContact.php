<?php

	include ("../DatabaseConnections/Connection.php"); 

	session_start();

	//Send data collected form last page to session variables
	if(isset($_POST['txtUserName']))
	$_SESSION['txtUserName'] = $_POST['txtUserName'];
	
	if(isset($_POST['txtPassword']))
	$_SESSION['txtPassword'] = $_POST['txtPassword'];
	
	if(isset($_POST['txtEmail']))
	$_SESSION['txtEmail'] = $_POST['txtEmail'];
	
	if(isset($_POST['ddlSecurityQuestion']))
	$_SESSION['ddlSecurityQuestion'] = $_POST['ddlSecurityQuestion'];
	
	if(isset($_POST['txtSecurityAnswer']))
	$_SESSION['txtSecurityAnswer'] = $_POST['txtSecurityAnswer'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<script type="text/javascript" src="../js/jdpicker/jquery-1.3.2.min.js"></script> 
	<script type ="text/javascript" src="../js/jdpicker/jquery.js"></script>
	<script type ="text/javascript" src="../js/jdpicker/jquery.jdpicker.js"></script>
	
	<link rel="stylesheet" href="../js/jdpicker/jdpicker.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="../css/template.css" type="text/css"/>
	<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
	
	<title>Create Admin</title>
	
	<script src="../js/jquery-1.8.2.min.js" type="text/javascript" ></script>
	<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8" ></script>
	<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8" ></script>
	
	<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#adminContactForm").validationEngine('attach');
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
	
		<div id="contactUs_container">
		<div style="padding:20px;">
		<h1>Create New Administrator</h1>
			<form action="../DatabaseConnections/AdminConnections.php" method="post" id="adminContactForm" class="formular">
				First Name:
				<input type="text" name="txtFirstName" size="10" class="validate[required, custom[onlyLetterSp]] text-input" /><br/>
				
				Last Name:
				<input type="text" name="txtLastName" size="10" class="validate[required, custom[onlyLetterSp]] text-input"/><br/>
				
				Gender:
				<select name="ddlGender" class="validate[required]">
					  <option value=""> Gender </option>
					  <option value="Male"> Male </option>
					  <option value="Female"> Female </option>
				 </select><br/>
						 
				DOB: 
				<input type="text" name="txtDOB" class="jdpicker" /><br/>	
		
				Address Line 1: 
				<input type="text" name="txtAddressLine1" class="validate[required]"/><br/>
				
				Address Line 2:
				<input type="text" name="txtAddressLine2"/><br/>
				
				Town: 
				<input type="text" name="txtTown" class="validate[required, custom[onlyLetterSp]]"/><br/>
				
				Parish:
				<?php
		
					$sql="SELECT * FROM Parishes Order by Parish ASC"; 
					$result =mysql_query($sql, $con); 
		
					echo "<select name='ddlParish' class='validate[required]'>";
					echo "<option value='' selected='selected'>Select Parish</option>";
					while ($row=mysql_fetch_array($result)) 
					{ 
						echo "<option value=\"{$row['ParishId']}\">{$row['Parish']}</option>"; 
					} 
					
					echo "</select>";
				?><br/>
		
				Contact Number: 
				<input type="text" name="txtContactNumber" class="validate[required, custom[phoneCustom]]"/><br/>
		
				<input type="submit" name="btnCreateAdmin" value="Create Admin" />
			</form>
		</div>
		</div>
	</div>
	<?php
		 include("../header_footer/footer.html");
	?>
</body>

</html>
