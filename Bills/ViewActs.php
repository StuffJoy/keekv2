<?php
include ("../DatabaseConnections/Connection.php");


	session_start();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
		<title>View Acts</title>
		
		
		<script>
			function ShowAct(str)
			{
			if (str.length==0)
			  { 
			  document.getElementById("ActInfo").innerHTML="";
			  return;
			  }
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    document.getElementById("ActInfo").innerHTML=xmlhttp.responseText;
			    }
			  }
			xmlhttp.open("GET","GETAct.php?q="+str,true);
			xmlhttp.send();
			}		
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

		<div id="contactUs_container" style="padding-left:40px; padding-bottom:40px;">	
			Select the Bill You would Like to View:<br/>
				<?php
				
					$sql = "SELECT Acts.ActId, Bills.BillName FROM Acts 
					INNER JOIN Bills ON Acts.ActId = Bills.BillId";
					$results = mysqli_query($con,$sql);
					
					echo "<select name='ddlActs' onchange='ShowAct(this.value)' class='validate[required]'>";
					echo "<option value='Select' selected='selected'> Acts </option>";
							
					while ($row=mysqli_fetch_array($results))
					{
						echo "<option value=\"{$row['ActId']}\">{$row['BillName']}</option>";
					}
						
					echo "</select>";
				
				?>
				<div id="ActInfo"></div>
			</div>
	</div>	
	<?php
		include('../header_footer/footer.html');
	?>
	</body>
	
	
	
	

</html>
