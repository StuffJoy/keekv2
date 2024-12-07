<?php

	include ("../DatabaseConnections/Connection.php");

	session_start();


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Add Act</title>

	<!-- Java Script and CSS to enable Calender -->


	<script type="text/javascript" src="../js/jdpicker/jquery-1.3.2.min.js"></script> 
	<script type ="text/javascript" src="../js/jdpicker/jquery.jdpicker.js"></script>
	<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
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
	
		<div id="contactUs_container">
		<h1>Add Act</h1>
		<form action="../DatabaseConnections/BillConnections.php" method="post">
		
			Select the Bill You would Like to View:
			<?php
			
				$sql = "SELECT Bills.* FROM Bills
						LEFT JOIN Acts ON Bills.BillId = Acts.ActId
						WHERE Acts.ActId IS NULL;";
						
				$results = mysql_query($sql);
				
				echo "<select name='ddlAct'>";
				echo "<option value='Select' selected='selected'> Bills </option>";
						
				while ($row=mysql_fetch_array($results))
				{
					echo "<option value=\"{$row['BillId']}\">{$row['BillName']}</option>";
				}
					
				echo "</select>";
			
			?>
			
			<br />
			<br />
			
			Date of Assent: <input type="text" class="jdpicker" name="txtAssentDate" /><br />
			Date of Act: <input type="text" class="jdpicker" name="txtActDate" /><br />
			Location:<br/> <input type="text" name="txtActLocation" /><br />
		
			<input type="submit" name="btnCreateAct" value="Create Act" />
		</form>
	</div>
	</div>
	<?php
		include('../header_footer/footer.html');
	?>
</body>

</html>
