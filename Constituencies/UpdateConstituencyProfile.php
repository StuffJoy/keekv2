<?php

	session_start();
	include ("../DatabaseConnections/Connection.php");


	//------------------Load Constituency Profile -----------
	if(isset($_GET['id']))
	{
	
		include ("../DatabaseConnections/Connection.php"); 
	
		$ConstituencyId = $_GET['id'];
		
		$sql = "SELECT * FROM Constituencies
		INNER JOIN ConstitituencyMps ON Constituencies.ConstituencyId=ConstituencyMps.ConstituencyId
		LEFT JOIN Politicians ON ConstituencyMps.MPId = Politicians.Politician.Id
		WHERE Constituencies.ConstituencyId = '$ConstituencyId'";
		
		
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
		$ConstituencyDescription = $row['ConstituencyDescription'];
		$PoliticianName = $row['FirstName']." ". $row['LastName'];
	
	}	


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
			jQuery("#addPoliticianForm").validationEngine('attach', { bindMethod:"live" });
		});
  	</script>

	<!-- Java Script and CSS to enable Calender -->
	
	
	<script type="text/javascript" src="../js/jdpicker/jquery-1.3.2.min.js"></script> 
	<script type ="text/javascript" src="../js/jdpicker/jquery.jdpicker.js"></script>
	<link rel="stylesheet" href="../js/jdpicker/jdpicker.css" type="text/css" media="screen" />


	<script>
		
		function IsMinister(str)
		{
			if (str.length==0)
			  { 
			  document.getElementById("Minister").innerHTML="";
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
			    document.getElementById("Minister").innerHTML=xmlhttp.responseText;
			    }
			  }
			xmlhttp.open("GET","GETMinister.php?q="+str,true);
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
		<div id="contactUs_container" style="padding-left:40px;padding-bottom:40px;">
			<h1>Update Profile</h1>
			<form action="../DatabaseConnections/ConstituencyConnections.php" method="post" id="updateConstituencyForm" class="formular">
			
			Constituency Name: <?php
					  
						$sql="SELECT * FROM Constituencies ORDER by ConstituencyDescription ASC";
						$res=mysql_query($sql);
					
						echo "<select name='ddlConstituency' class='validate[required]'>";
						echo "<option value='Select' selected='selected'> Constituency Name </option>";
						
						while ($row=mysql_fetch_array($res))
						{
						
							if($row['ConstituencyDescription'] == $ConstituencyDescription)
							{
								echo "<option selected='selected' value=\"{$row['ConstituencyDescription']}\">{$row['ConstituencyDescription']}</option>";
							}
							else
							{
								echo "<option value=\"{$row['ConstituencyId']}\">{$row['ConstituencyDescription']}</option>";
							}
						}
					
						echo "</select>";
					?><br />
			
			
			Politician Name: <?php
					  
						$sql="SELECT * FROM Politicians ORDER by FirstName ASC";
						$res=mysql_query($sql);
					
						echo "<select name='ddlPolitician' class='validate[required]'>";
						echo "<option value='Select' selected='selected'> Politician Name </option>";
						
						while ($row=mysql_fetch_array($res))
						{
						
							if($row['FirstName'] AND $row['LastName']== $PoliticianName)
							{
								echo "<option selected=\"selected\" value=". $row['FirstName']." ". $row['LastName'].">".$row['FirstName'] ." ".$row['LastName']."</option>";
							}
							else
							{
								echo "<option value=". $row['PoliticianId'].">".$row['FirstName']. " ". $row['LastName']."</option>";
							}
						}
					
						echo "</select>";
					?><br />
			
			
					Date Elected: <input type="text" name="DateElected" class="jdpicker" value="<?php if(isset($DateElected)) { $DateElected = date('F j, Y', strtotime($DateElected)); echo $DateElected;} ?>" /><br/>
		
			
			
			<input type="submit" name="btnUpdateConstituency" value="Update" />
		</form>
		</div>
	</div>
	<?php
	 include('../header_footer/footer.html');
	?>

</body>

</html>