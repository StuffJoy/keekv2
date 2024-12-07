<div id="websiteTitle_container">
	<div id="logo_container">
		<!---<img src="Images/logo.png" alt="Keek"/>-->
	  		<div style="margin-left: -1%; padding-top:9%;">
				keeping everyone, everywhere, knowledgeable
			</div>
	</div>
				
	<div id="login_container">
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
			<li><a href="default.php">Home</a></li>
			<li><a href="Politicians/SearchPolitician.php">Politicians</a></li>
			<li><a href="Constituencies/SearchConstituency.php">Constituencies</a></li>
			<li><a href="Bills/ViewActs.php">Bills/Acts</a></li>
			<li><a href="Contact/ContactUs.php">Contact</a></li>
			<li>
				<?php
	   				if(isset($_SESSION['AdminUserName']))
		   			{
		   		   		echo "<a href='Admin/AdminControl.php'>";
	   					echo "Control Panel";
	   		 			echo "</a>";
					}
				?>	
			</li>
		</ul>
		<br/>
	</div>
</div>
			
<div id="header_container"></div>
			
<div id="bar_container">.</div>

