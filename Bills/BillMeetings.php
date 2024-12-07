<?php

	include ("../DatabaseConnections/Connection.php");


	session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Bill Meetings</title>
		
	<!--        Script by hscripts.com          -->
	<!--        copyright of HIOX INDIA         -->
	<!-- Free javascripts @ http://www.hscripts.com -->
	<script type="text/javascript">
	checked=false;
	function checkedAll (frm1) {
		var aa= document.getElementById('UpdateBill');
		 if (checked == false)
	          {
	           checked = true
	          }
	        else
	          {
	          checked = false
	          }
		for (var i =0; i < aa.elements.length; i++) 
		{
		 aa.elements[i].checked = checked;
		}
	      }
	</script>
	<!-- Script by hscripts.com -->

	<!-- Java Script and CSS to enable Calender -->
	<script type="text/javascript" src="../js/jdpicker/jquery-1.3.2.min.js"></script> 
	<script type ="text/javascript" src="../js/jdpicker/jquery.jdpicker.js"></script>
	<link rel="stylesheet" href="../js/jdpicker/jdpicker.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>	

		<!-- Java Script and CSS to enable valdation -->
	<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css"/>
	
	<script src="../js/jquery-1.8.2.min.js" type="text/javascript" ></script>
	<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8" ></script>
	<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8" ></script>
	
	<script>
		jQuery(document).ready(function(){
			jQuery("#UpdateBill").validationEngine('attach', { bindMethod:"live"});
		});
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
					<li><a href="../Constituency/SearchConstituency.php">Constituencies</a></li>
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

		<form action="BillVotes.php" id="UpdateBill" method="post" class="formular">
	
			<h1>Select the Bill You would like to Update</h1> <br /><br/>
			<?php
				
				$sql = "SELECT Bills.* FROM Bills
						LEFT JOIN Acts ON Bills.BillId = Acts.ActId
						WHERE Acts.ActId IS NULL;";
				$results = mysql_query($sql);
				
				echo "<select name='ddlBill' class='validate[required]'>";
				echo "<option value='' selected='selected'> Bills </option>";
							
				while ($row=mysql_fetch_array($results))
				{
					echo "<option value=\"{$row['BillId']}\">{$row['BillName']}</option>";
				}
						
				echo "</select>";
				
			?>
			<br />
			<br />
			Members Present:<br/>
			<input type='checkbox' name='checkall' onclick='checkedAll(UpdateBill);'/>Check All 
			
			<?php
			
	
				$sql = "SELECT * FROM Politicians WHERE RoleId = '1' OR '3' ORDER BY FirstName ASC";
				$results = mysql_query($sql); 
				
				
				echo "<table id='Bills'>"; // Create table
				$count = 0;
				while($row = mysql_fetch_array($results))
				{
					$FullName = $row['FirstName'] . " " . $row['LastName'];
					$MpId = $row['PoliticianId'];
					
	 				$count++;
					if($count == 6) //Sets amounts of columns needed
					{
						echo "<tr>";
					}	
						//Code to display check boxes with Politician names
						echo "<td>" . "<input type='checkbox' class='chk_boxes1' name='CheckPoliticians[]' value='$MpId'>" . '<a href="../Politicians/PoliticianProfile.php?id=' . $row['PoliticianId'] .'">' . $FullName . "</a>" . "</td>";
					
					if($count == 6)
					{
						//echo "</tr>";
						$count = 1;
					}			
				}
			echo "</table>";
			
			
		
		//echo "<input type='checkbox'  name ='check all'  />" . "check all";
				
			?>
		<br />
		
		<br />
		
		Date of Meeting: <input type="text" class="jdpicker" name="txtMeetingDate" /> <br />
		
		<input type="submit" name="btnMpPresent" value="Finish" />	
	</form>
	</div>
	</div>
	<?php
		include('../header_footer/footer.html');
	?>
	
</body>

</html>
