<?php

	session_start();

?>

<html>
	<head>
		<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
		<title>Edit Constituency</title>
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
					<li><a href="../Constituencies/SearchConstituency">Constituencies</a></li>
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
			<h1>Update Constituency</h1><br/>
			Please enter the constituency you would like to update:<br/><br/> 
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
					<input type = "text" name = "box">
					<input type = "submit" name = "btnUpdate" value = "Update">
				</form>
			</div>
		</div>	
		<div id="footer_container">
			Copyright (c) 2013
		</div>


	</body>
</html>

<?php
	
	include ("../DatabaseConnections/Connection.php"); 
	
	if (isset($_POST['btnUpdate']))
	{
		$name = $_POST['box'];
		
		echo "$name Updated";
		$sql = "Select * from constituencies;";
	
	}

?>