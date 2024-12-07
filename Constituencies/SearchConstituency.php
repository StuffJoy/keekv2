<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include ("../DatabaseConnections/Connection.php"); 	

	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Search Constituency</title>
	<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
	

	
	<!--
	AJAX script to pull data from GetCouncillor.php
	-->
	<script type="text/javascript">
		var parish, region,select;
		
		function ShowConstituency()
		{
			
			parish = document.querySelector("[name='ddlParish']");
			if(parish.selectedIndex==0){
				document.getElementById("Constituency").innerHTML="Please select a parish";
					return false;
			}
			parish=parish.options[parish.selectedIndex].value;
			
			region= document.querySelector("[name='ddlRegion']");
			if(region.selectedIndex==0){
				document.getElementById("Constituency").innerHTML="Please select a region";
				return false;
			}
			region=region.options[region.selectedIndex].value;
			
		
			
			str = "parish="+parish+"&region="+region;
				console.log(str);
			if (str.length==0)
			  { 
			  document.getElementById("Constituency").innerHTML="";
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
			    document.getElementById("Constituency").innerHTML=xmlhttp.responseText;
			    }
			  }
	
			xmlhttp.open("GET","../Constituencies/GETConstituency.php?region="+region+"&parish="+parish,true);
			xmlhttp.send();
		}
		
			</script>
	
	
	
	<script>
		
		function ShowControl(str)
		{
			if (str.length==0)
			  { 
			  document.getElementById("RegionControl").innerHTML="";
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
			    document.getElementById("RegionControl").innerHTML=xmlhttp.responseText;
			    }
			  }
			xmlhttp.open("GET","GETConstituencyControl.php?q="+str,true);
			xmlhttp.send();
			}
	</script>


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



<script type="text/javascript">
		
		function ShowUpdateControl(str)
		{
	
				
			parish = document.querySelector("[name='ddlParish']");
			if(parish.selectedIndex==0){
				document.getElementById("Constituency").innerHTML="Please select a parish";
					return false;
			}
			parish=parish.options[parish.selectedIndex].value;
			
			region= document.querySelector("[name='ddlRegion']");
			if(region.selectedIndex==0){
				document.getElementById("Constituency").innerHTML="Please select a region";
				return false;
			}
			region=region.options[region.selectedIndex].value;
			
		
			if (str.length==0)
			  { 
			  document.getElementById("Updater").innerHTML="";
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
			    document.getElementById("Updater").innerHTML=xmlhttp.responseText;
			    }
			  }
	
			xmlhttp.open("GET","../Constituencies/GETUpdateConstituency.php?region="+region+"&parish="+parish+"&str="+str,true);
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
						<li><a href="SearchConstituency.php">Constituencies</a></li>
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
	
			<div id="contactUs_container" style="padding-bottom:40px; overflow:auto;">
			<!--<div id="search_constituency_container">-->
				<div class="left2">	
				<h1>Search Constituency</h1>
					
								
					Please Select Your Parish to get started... 
					<br />
					<br />
					<label for="lblParish" style="width:20%;">Parish:</label>
					<?php
				
						$sql="SELECT * FROM Parishes Order by Parish ASC"; 
						$result =mysqli_query($con, $sql); 
				
						echo "<select name='ddlParish' onchange='ShowControl(this.value)' >";
						echo "<option value='' selected='selected'>Select Parish</option>";
						while ($row=mysqli_fetch_array($result)) 
						{ 
							echo "<option value=\"{$row['ParishId']}\">{$row['Parish']}</option>"; 
						} 
					
						echo "</select>";
						
						
					?>
					<div id="RegionControl" ></div>
					
				</div>
										
				<div style="margin-left:50%;">
					<?php
						if(isset($_SESSION['AdminUserName']))
						{
							echo "<h1>Update Constituency? </h1>";
							/*echo "<table style='border-style:none;'>";
								echo "<tr>";
									echo "<td>" . "Yes&nbsp " . "</td>";
									echo "<td>" . "No" . "</td>";
								echo "</tr>";*/
	
								/*echo "<tr>";*/
									echo /*"<td>" .*/ "<input type ='radio' onchange='ShowUpdateControl(this.value)' name='radiochoice' value = 'Yes'> Yes"; //. "</td>";
									echo /*"<td>" .*/ "<input type ='radio' onchange='ShowUpdateControl(this.value)' name='radiochoice' value = 'No'>No "; //. "</td>";
								echo "</tr>";
	
							
						}
					?>
					<div id="Updater"> </div>
				</div>
			</div>
		</div>
		<?php
			include('../header_footer/footer.html');
		?>
	</body>

</html>
