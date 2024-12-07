
<?php

	include ("../DatabaseConnections/Connection.php");
	session_start();
	
	//Values are checked then stored in SESSION Variables
	
	if(isset($_POST['txtAddressLine1']))
		$_SESSION['txtAddressLine1'] = $_POST['txtAddressLine1'];
	
	if(isset($_POST['txtAddressLine2']))
		$_SESSION['txtAddressLine2'] = $_POST['txtAddressLine2'];
	
	if(isset($_POST['txtTown']))
		$_SESSION['txtTown'] = $_POST['txtTown'];
	
	if(isset($_POST['txtContactNumber']))
		$_SESSION['txtContactNumber'] = $_POST['txtContactNumber'];
	
	if(isset($_POST['txtEmail']))
		$_SESSION['txtEmail'] = $_POST['txtEmail'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<title>Add Constituency Representative</title>
	
		<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css"/>
		<link rel="stylesheet" href="../css/template.css" type="text/css"/>
		<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
		
		<script src="../js/jquery-1.8.2.min.js" type="text/javascript" ></script>
		<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8" ></script>
		<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8" ></script>
		
		<script>
			jQuery(document).ready(function(){
				// binds form submission and fields to the validation engine
				jQuery("#addConstituencyRep").validationEngine('attach', { bindMethod:"live", promptPosition : "centerRight" });
			});
	  	</script>
	  	
	  	
	  	<!-- Java Script and CSS to enable Calender -->
	
	
		<script type="text/javascript" src="../js/jdpicker/jquery-1.3.2.min.js"></script> 
		<script type ="text/javascript" src="../js/jdpicker/jquery.jdpicker.js"></script>
		<link rel="stylesheet" href="../js/jdpicker/jdpicker.css" type="text/css" media="screen" />
	
	  	
		<!--
		AJAX script to pull data from GetCouncillor.php
		-->
		<script type="application/x-javascript">
			
			function ShowCouncillor(str)
			{
				if (str.length==0)
				  { 
				  document.getElementById("Councillor").innerHTML="";
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
				    document.getElementById("Councillor").innerHTML=xmlhttp.responseText;
				    }
				  }
		
				xmlhttp.open("GET","../Politicians/GETCouncillor.php?q="+str,true);
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
			<div id="contactUs_container" style="padding-bottom:40px; padding-left:40px;">	
				<h1>Add Constituency Representative</h1>	
				<form action="../DatabaseConnections/ConstituencyConnections.php" method="post" id="addConstituencyRep" class="formular">
						
					Member of Parliament: 
					<?php
						
						$sql="SELECT * FROM Politicians WHERE RoleId = '1'"; 
						$result =mysql_query($sql); 
			
						echo "<select name='ddlMP' class='validate[required]'>";
						echo "<option value='' selected='selected'>Select MP</option>";
						while ($row=mysql_fetch_array($result)) 
						{ 
							$Name = $row['FirstName'] . " " . $row['LastName'];
							echo "<option value=\"{$row['PoliticianId']}\">{$Name}</option>"; 
						} 
				
						echo "</select>";
					?>
					<br/>
										
					Date Elected into Power: <input type="text" name="txtMPDateElected" class="jdpicker" /><br />
					
					<!--
					
					Date Removed from Power: <input type="text" name="txtMPDateRemoved" class="jdpicker" /><br />
					
					-->
					
					How many counsellors does this constituency have? 
					<select name="ddlCouncillorCount" onchange="ShowCouncillor(this.value)" class="validate[required]">
						<option value=""> Number </option>
						<option value="1"> 1 </option>
					    <option value="2"> 2 </option>
					    <option value="3"> 3 </option>
					    <option value="4"> 4 </option>
					    <option value="5"> 5 </option>
					</select><br/>
					
					<div id="Councillor"></div>		
					<input type="submit" name="btnAddConstituency" value="Next" />
				</form>
			</div>
		</div>
		<?php
			include('../header_footer/footer.html');
		?>
		
	</body>

</html>
