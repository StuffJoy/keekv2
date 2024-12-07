<?php 

session_start();
include ("../DatabaseConnections/Connection.php"); 

$_SESSION['ddlRegion'] = $_POST['ddlRegion'];
$_SESSION['ddlParish'] = $_POST['ddlParish'];
if(isset($_POST['txtDescription']))
	$_SESSION['txtDescription'] = $_POST['txtDescription'];
else
	$_SESSION['txtDescription'] = NULL;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<title>Add Constituency Office</title>
		
		<script type="text/javascript" src="../js/jdpicker/jquery-1.3.2.min.js"></script> 
		<script type ="text/javascript" src="../js/jdpicker/jquery.js"></script>
		<script type ="text/javascript" src="../js/jdpicker/jquery.jdpicker.js"></script>
		
		<link rel="stylesheet" href="../js/jdpicker/jdpicker.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css"/>
		<link rel="stylesheet" href="../css/template.css" type="text/css"/>
		<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
		
		<script src="../js/jquery-1.8.2.min.js" type="text/javascript" ></script>
		<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8" ></script>
		<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8" ></script>
		
		<script>
			jQuery(document).ready(function(){
				// binds form submission and fields to the validation engine
				jQuery("#addConstituency").validationEngine('attach');
			});
	  	</script>
	</head>
	
	<body>
		<div id="parent_container">
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
				<div id="contactUs_container" style="padding-left:40px;">
					<h1>Add Constituency Office</h1>
					<form action="AddConstituencyRep.php" method="post" id="addConstituency" class="formular" >
						Address Line 1: 
						<input type="text" name="txtAddressLine1" class="validate[required, onlyLetterNumberSp]"/>
						
						Address Line 2: 
						<input type="text" name="txtAddressLine2" class="validate[onlyLetterNumberSp]"/>
						
						Town: 
						<input type="text" name="txtTown" class="validate[required, onlyLetterNumberSp]" />
					
						Contact Number: 
						<input type="text" name="txtContactNumber" class="validate[required, custom[phoneCustom]]"/>
						
						Email: 
						<input type="email" name="txtEmail" class="validate[required, custom[email]] text-input"/>
						<br/><br/><input type="submit" name="btnAddConstituencyOffice" value="Next" />
					</form>
				</div>
			</div>
		</div>
		<?php
			include('../header_footer/footer.html');
		?>	
	</body>

</html>
