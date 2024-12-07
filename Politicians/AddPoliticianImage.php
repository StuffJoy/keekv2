<?php

	session_start();
	
	if(isset($_POST['ddlTitle']))
		$_SESSION['ddlTitle'] = $_POST['ddlTitle'];
	
	if(isset($_POST['txtFirstName']))	
		$_SESSION['txtFirstName'] = $_POST['txtFirstName'];
		
	if(isset($_POST['txtLastName']))	
		$_SESSION['txtLastName'] = $_POST['txtLastName'];
	
	if(isset($_POST['ddlGender']))
		$_SESSION['ddlGender'] = $_POST['ddlGender'];
	
	if(isset($_POST['txtDOB']))
		$_SESSION['txtDOB'] = $_POST['txtDOB'];
	
	if(isset($_POST['ddlMinister']))
		$_SESSION['ddlMinister'] = $_POST['ddlMinister'];
	
	if(isset($_POST['ddlPrimeMinister']))
		$_SESSION['ddlPrimeMinister'] = $_POST['ddlPrimeMinister'];
	
	if(isset($_POST['ddlPortfolio']))
		$_SESSION['ddlPortfolio'] = $_POST['ddlPortfolio'];
	
	if(isset($_POST['txtFirstName']))
		$_SESSION['ddlRole'] = $_POST['ddlRole'];
	
	if(isset($_POST['txtFirstName']))
		$_SESSION['ddlMinister'] = $_POST['ddlMinister'];
	
	if(isset($_POST['txtFirstName']))
		$_SESSION['ddlParty'] = $_POST['ddlParty'];
		 

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	
	<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="../css/template.css" type="text/css"/>
	<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>

	<script src="../js/jquery-1.8.2.min.js" type="text/javascript" ></script>
	<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8" ></script>
	<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8" ></script>
	
	<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#addPoliticianImage").validationEngine('attach', { promptPosition: "centerRight" } );
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
		
		<div id="contactUs_container" style="padding-left:40px; padding-right:40px;">
		<h1>Add Politician Image</h1>
			<form action="../DatabaseConnections/PoliticianConnections.php" method="post" id="addPoliticianImage" class="formular" enctype="multipart/form-data" >
		
				File Name: <input class="validate[required] text-input" style="border-style:none;" type="file" id="file" name="PoliticianImage" />
				
				<br/><br/>
		
				<input type="submit" name="btnAddPolitician" value="Add with Image" />
				<input type="submit" name="btnSkipImage" value="Add without Image" id="skipbutton" class="submit validate-skip" />
			</form>	
		</div>
	</div>
	<?php
		include('../header_footer/footer.html');
	?>
</body>

</html>
