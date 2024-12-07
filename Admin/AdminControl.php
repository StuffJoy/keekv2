<?php

	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>

	<title>Admin Control Panel</title>
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
			<div style ="padding:20px">
			<?php
				echo "<h1>Welcome " . $_SESSION['AdminUserName'] . "</h1><br>";
				echo "What would you like to do?<br/>"
			?>	
			
			<a href="../Admin/AdminEmail.php">Create New Admin</a>
			<br />
			<a href="../Politicians/AddPolitician.php">Add a new Politician</a>
			<br />
			<a href="../Constituencies/AddConstituency.php">Add a new Constituency</a>
			<br />
			<a href="../Bills/AddBill.php">Add a new Bill</a>
			<br />
			<a href="../Bills/BillMeetings.php">Update Bill</a>
			<br />
			<a href="../Bills/AddAct.php">Add Act</a>			
			<br />
			<a href="http://openspending.org/">Upload a New Dataset</a>
			<br />
			<a href="AdminLogout.php">Log Out</a>
			</div>		
			
			</div>
		</div>
	
	<?php
		include('../header_footer/footer.html');
	?>
	
</body>

</html>
