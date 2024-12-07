<?php
	session_start();
	include ("../DatabaseConnections/Connection.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>	
	<title>Bill Votes</title>

	<script src="../js/jquery-1.8.2.min.js" type="text/javascript" ></script>
	
	<script type="text/javascript">
		function DisableVotes() {
		    $('.PoliticianVotes').each(function(){
		        $(this).attr('disabled', 'disabled');
		    });
		}
	</script>
	
	<script type="text/javascript">
		function EnableVotes() {
		    $('.PoliticianVotes').each(function(){
		        $(this).removeAttr('disabled');
		    });
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

		<div id="contactUs_container" style="padding-left:40px; padding-bottom:40px; padding-top:40px;">


		<form action="../DatabaseConnections/BillConnections.php" method="post">
		<table>
				<tr>
					<th style="text-align:center"> Use Individual Votes </th>
					<th style="text-align:center"> Undetermined </th>
				</tr>
				<tr class="no_hover">
					<td align="center"> <input type="radio" onclick="EnableVotes()" name="RadioVoteChoice" value="Individual" checked="checked" /> </td> 
					<td align="center"> <input type="radio" onclick="DisableVotes()" name="RadioVoteChoice" value="Undetermined" /> </td> 
				</tr>
			</table>
			
			<br/>
			<br/>
		
			
			Please Select How each Member of Parliament Voted on This Bill:<br/><br/>
			
			<?php
			
				$BillId = $_POST['ddlBill'];			
				$_SESSION['ddlBill'] = $BillId;
				
				$_SESSION['txtMeetingDate'] = $_POST['txtMeetingDate'];			
				$arrayPoliticians = $_POST['CheckPoliticians'];
				$_SESSION['RadioPoliticians'] = $_POST['CheckPoliticians'];
	 
				/*
				$sql = "SELECT Politicians.FirstName, Politicians.LastName, BillVotes.PoliticianId FROM BillVotes INNER JOIN Politicians ON BillVotes.PoliticianId = Politicians.PoliticianId
				LEFT JOIN BillMeetings ON BillVotes.BillCycle = BillMeetings.BillCycle 
				WHERE BillMeetings.BillCycle = (select BillCycle from billmeetings where billid = '$BillId' ORDER BY MeetingDate DESC LIMIT 1)
				ORDER BY Politicians.FirstName ASC";
				
				$results = mysql_query($sql);
				*/
				echo "<table id='votes'>"; // Create table
				$count = 0;
				//while($row = mysql_fetch_array($results))
				foreach($arrayPoliticians as $MpId)
				{
					$sql = "SELECT FirstName, LastName FROM Politicians WHERE PoliticianId = '$MpId'";
					$results = mysql_query($sql);
					$row = mysql_fetch_array($results);
					
					$FullName = $row['FirstName'] . " " . $row['LastName'];
					//$MpId = $row['PoliticianId'];
					
	 				$count++;
					if($count == 7) //Sets amounts of columns needed
					{
						echo "<tr style='border-right:solid thin #CDC9A5;'>";
					}	
						//Code to display check boxes with Politician names
						echo "<td align='center' style='border-right:solid thin #CDC9A5;'>" . '<a href="../Politicians/PoliticianProfile.php?id=' . $MpId .'">' . $FullName . "</a>" . "";
						/*echo "<table>";
						echo "<tr style='border-top:none;'>";
							echo "<td style='padding-left:3%; padding-right:3%;'>Yae</td>";
							echo "<td style='padding-left:5%;'>Nae</td>";
						echo "</tr>";
						
						echo "<tr style='border-top:none;'>";
							
							echo "<td  style='padding-left:3%; padding-right:3%;'>" . "<input type='radio' name='$MpId' class='PoliticianVotes' value='Yae'>" . "</td>"; 
							echo "<td  style='padding-left:3%;'>" . "<input type='radio' name='$MpId' class='PoliticianVotes' value='Nae'>" . "</td>";
						echo "</tr>";
							
						echo "</table>";*/
						echo "<br/><input type='radio' name='$MpId' class='PoliticianVotes' value='Yae'> Yea "; 
						echo "<input type='radio' name='$MpId' class='PoliticianVotes' value='Nae'> Nae";
					if($count == 7)
					{
						//echo "</tr>";
						$count = 1;
					}			
				}
			echo "</table>";
	
				
				
			?>
			<br />
			
			<input type="submit" name="btnBillVotes" value="Submit" />
		</form>
	</div>
	</div>
	<?php
		include('../header_footer/footer.html');
	?>
</body>

</html>
