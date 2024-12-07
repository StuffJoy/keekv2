<?php

session_start();
include ("../DatabaseConnections/Connection.php"); 


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	
	<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="../css/template.css" type="text/css"/>
	<link rel="stylesheet" href ="../it_is_css.css" type="text/css"/>
	
	<title>Add Constituency</title>
	
	<script src="../js/jquery-1.8.2.min.js" type="text/javascript" ></script>
	<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8" ></script>
	<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8" ></script>
	
	<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#addConstituencyForm").validationEngine('attach', { bindMethod:"live" });
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
			<div id="contactUs_container" style="padding-bottom:40px; padding-left:40px;">
			<h1>Add Constituency</h1>
						<form action="AddConstituencyOffice.php" method="post" id="addConstituencyForm" style="width: 40%;" class="formular">
						
							<!--<label for="lblRegion" style="width:19%;">-->Region:<!--</label>-->
							<?php		  
								$sql="SELECT * FROM Regions";
								$res=mysql_query($sql, $con);
									
								echo "<select name='ddlRegion' class='validate[required]'>";
								echo "<option value='' selected='selected'>Select Region Question</option>";
								while ($row=mysql_fetch_array($res))
								{
									echo "<option value=\"{$row['RegionId']}\">{$row['Region']}</option>";
								}
						
								echo "</select>";
							?>
							<br/>
									
							Parish:
							<?php
						
								$sql="SELECT * FROM Parishes Order by Parish ASC"; 
								$result =mysql_query($sql); 
						
								echo "<select name='ddlParish' class='validate[required]'>";
								echo "<option value='' selected='selected'>Select Parish</option>";
								while ($row=mysql_fetch_array($result)) 
								{ 
									echo "<option value=\"{$row['ParishId']}\">{$row['Parish']}</option>"; 
								} 
								
								echo "</select>";
							?>
							<br/>
									
							Description:
							<textarea name="txtDescription" style="width: 230px; height: 140px"></textarea><br/>
						
							<input type="submit" name="btnAddConstituency" value="Next"/>
						</form>
				</div>
			</div>
			<?php
				include('../header_footer/footer.html');
		    ?>
	</body>

</html>
