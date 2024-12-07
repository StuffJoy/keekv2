<?php
	
	session_start();
	include("../DatabaseConnections/Connection.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<link href="../it_is_css.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="../css/template.css" type="text/css"/>
	<title>Add CDF</title>
	
	<!-- Java Script and CSS to enable Calender -->
	<script type="text/javascript" src="../js/jdpicker/jquery-1.3.2.min.js"></script> 
	<script type ="text/javascript" src="../js/jdpicker/jquery.jdpicker.js"></script>
	<link rel="stylesheet" href="../js/jdpicker/jdpicker.css" type="text/css" media="screen" />

	
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
	
		<div id="contactUs_container" style="padding-left:40px; padding-bottom:40px;">
			<h1>Add CDF for Politician</h1>

			<form action="../DatabaseConnections/PoliticianConnections.php" method="post" class="formular">
				
				<?php
					
					if(isset($_GET['id']))
					{
						$PoliticianId = $_GET['id'];
					}
					else
					{
						$PoliticianId = "empty";
					}
					 
					$sql="SELECT FirstName, LastName, PoliticianId FROM Politicians ORDER BY FirstName ASC";
					$res=mysqli_query($con, $sql);
						
					echo "<select name='ddlPoliticianId' class='validate[required]'>";
					echo "<option value='Select' selected='selected'> Select Politician </option>";
							
					while ($row=mysqli_fetch_array($res))
					{
						$FullName = $row['FirstName'] . " " . $row['LastName'];
						if($row['PoliticianId'] == $PoliticianId)
						{
							echo "<option selected='selected' value=\"{$row['PoliticianId']}\">{$FullName}</option>";
						}
						else
						{	
							echo "<option value=\"{$row['PoliticianId']}\">{$FullName}</option>";
						}
					}
						
					echo "</select>";
					
				?>
				<br />
				
				Embedded Url: <input type="text" name="txtEmbedURL" /> <br />
				Year: <input type="text" name="txtYearDate" class="jdpicker" />
				
				<input type="submit" name="btnAddCDF" value="Update" />
			</form>
		</div>
	</div>
	<?php
		include('../header_footer/footer.html');
	?>
</body>

</html>
