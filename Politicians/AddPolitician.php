<?php

session_start();
include ("../DatabaseConnections/Connection.php");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Add Politician</title>
	
	<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="../css/template.css" type="text/css"/>
	<link rel="stylesheet" href ="../it_is_css.css" type="text/css"/>
	
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
		
			<div id="contactUs_container">
			<h1>Add Politician</h1>

				<form action="AddPoliticianImage.php" method="post" id="addPoliticianForm" class="formular">
				<!--
				Title: <select name="ddlTitle" class="validate[required]">
							  <option value=""> Title </option>
							  <option value="Mr."> Mr. </option>
							  <option value="Ms."> Ms. </option>
							  <option value="Mrs."> Mrs. </option>
							  <option value="Dr."> Dr. </option>
							  <option value="Rev."> Rev. </option>
						</select><br/>
				-->		 
				
				Title: 
				<?php  
					$sql="SELECT * FROM Titles ORDER BY Title ASC";
					$res=mysqli_query($con, $sql);
						
					echo "<select name='ddlTitle' class='validate[required]'>";
					echo "<option value='Select' selected='selected'> Title </option>";
							
					while ($row=mysqli_fetch_array($res))
					{
						echo "<option value=\"{$row['TitleId']}\">{$row['Title']}</option>";
					}
						
					echo "</select>";
				?>
				<br/>
				
				First Name: 
				<input type="text" name="txtFirstName" class="validate[required, custom[onlyLetterSp]] text-input"/><br/>
				
				Last Name: 
				<input type="text" name="txtLastName" class="validate[required, custom[onlyLetterSp]] text-input"/><br/>
				
				Gender:  
				<select name="ddlGender" class="validate[required]">
					  <option value=""> Gender </option>
					  <option value="Male"> Male </option>
					  <option value="Female"> Female </option>
				 </select>
				 <br/>
						 
				DOB: <input type="text" name="txtDOB" class="jdpicker" /><br/>
				
				Is this a Minister?:
				<select name="ddlMinister" onchange="IsMinister(this.value)" class="validate[required]">
					<option value=""> Minister? </option>
					<option value="Yes"> Yes </option>
					<option value="No"> No </option>
				</select><br/>
						 			 
						 			 
				<div id="Minister"></div><br/>		 			 
				
				<!--		 			 
				Role: <select name="ddlRole" class="validate[required]">
							  			<option value=""> Role </option>
							  			<option value="Member of Parliament"> Member of Parliament </option>
							  			<option value="Councillor"> Councillor </option>
						 			 </select><br/>
				-->			 			 
							
				Role:	
				<?php	  
					$sql="SELECT * FROM Roles";
					$res=mysqli_query($con, $sql);
						
					echo "<select name='ddlRole' class='validate[required]'>";
					echo "<option value='Select' selected='selected'> Role </option>";
							
					while ($row=mysqli_fetch_array($res))
					{
						echo "<option value=\"{$row['RoleId']}\">{$row['Role']}</option>";
					}
						
					echo "</select>";
				?>
				<br/>
					 			 
				Party Affiliation: 
				<?php
					$sql="SELECT * FROM PoliticalParties ORDER BY PartyName ASC";
					$res=mysqli_query($con, $sql);
									
					echo "<select name='ddlParty' class='validate[required]'>";
					echo "<option value='Select' selected='selected'>Select Political Party</option>";
										
					while ($row=mysqli_fetch_array($res))
					{
						echo "<option value=\"{$row['PartyId']}\">{$row['PartyName']}</option>";
					}
				
					echo "</select>";
				?>
				<br/>
				
				<input type="submit" name="btnAddMP" value="Next" />
			</form>
		</div>	
		</div>
		<?php
			include('../header_footer/footer.html');
		?>
	</body>

</html>
