<?php


	session_start();

	//------------------Load Politician Profile -----------
	if(isset($_GET['id']))
	{
	
		include ("../DatabaseConnections/Connection.php"); 
	
		$PoliticianId = $_GET['id'];
		
		//sql to pull politician data
		$sql = "SELECT * FROM Politicians 
		LEFT JOIN Ministers ON Politicians.PoliticianId=Ministers.MinisterId 
		LEFT JOIN Titles ON Politicians.TitleId = Titles.TitleId 
		LEFT JOIN Roles ON Politicians.RoleId = Roles.RoleId
		LEFT JOIN PoliticalParties ON Politicians.PartyId = PoliticalParties.PartyId 
		WHERE Politicians.PoliticianId = '$PoliticianId'";
		
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($result);
		
		$Title = $row['Title'];
		$FirstName = $row['FirstName'];
		$LastName = $row['LastName'];
		$Gender = $row['Gender'];
		if (isset($row['DOB']))
		{
			$DOB = $row['DOB'];
			$DOB = date('Y-m-d', strtotime($DOB));
		}
		else 
			$DOB = "---";			
		$Role = $row['Role'];
		$Image = $row['ImageLocation'];
		$Minister = $row['Minister'];
		$PartyAffiliation = $row['PartyName'];
		 
		
		if($Minister == 'Yes')
		{
		
			$sql = "SELECT * FROM Ministers INNER JOIN Portfolios ON Ministers.PortfolioId=Portfolios.PortfolioId WHERE Ministers.MinisterId = '$PoliticianId'";
			$result = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($result);
	
			$PrimeMinister = $row['PrimeMinister'];
			$Portfolio = $row['Portfolio'];		
		}		
		
	}	


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
		
		<title>Profile</title>
		
		<script>
		
			function ShowMore(str)
			{
				var politicianid;
				politicianid = "<?php echo $PoliticianId; ?>";
				if (str.length==0)
				  { 
				  document.getElementById("PoliticianMore").innerHTML="";
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
				    document.getElementById("PoliticianMore").innerHTML=xmlhttp.responseText;
				    }
				  }
				xmlhttp.open("GET","GETPoliticianMore.php?q="+str+"&politicianid="+politicianid,true);			
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
			<div id="contactUs_container" style="padding-left:40px; padding-bottom:40px; overflow:auto;">
				<h1>Politician Profile</h1>
				<div id="image">
					<img src="../<?php echo $Image; ?>" alt="meh" height="400" width="300"/>
				</div>
				
				<div id="profile_info">
					<div id="first_half">
						<div style="margin-left:62%;">	
						<?php
							
							if(isset($_SESSION['AdminUserName']))
							{
								echo "<a href='UpdatePoliticianProfile.php?id=$PoliticianId'>Edit?</a>" . " ";
								echo "<a href='AddPoliticianCDF.php?id=$PoliticianId'>Add CDF Data?</a>";

							}
						?>
						</div>
				
						<!--<div></div>-->
						<div class="left">	
							Name:<br/>
							Gender:<br/>
							DOB:<br/>
							Role:<br/>
							Party:<br/>
						</div>
						 	
						<div>
							<?php echo $Title . " " . $FirstName . " " . $LastName; ?><br/>
							<?php echo $Gender; ?> <br/>
					 	    <?php echo $DOB; ?><br/>
							<?php echo $Role; ?><br/>
							<?php echo $PartyAffiliation; ?> <br/>
						</div>
						
						<?php 
							if($Minister == 'Yes')
							{
								echo "<b>" . "Minister: " . "</b>" . $Portfolio . "<br>";
							}
							
							if($Role == 'Member of Parliament')
							{
								
								echo "<br/><b>Member of Parlaiment History</b>";
								
								$sql = "SELECT ConstituencyMPs.ConstituencyId, ConstituencyMPs.MpId, ConstituencyMPs.DateElected,ConstituencyMPs.DateRemoved,Regions.Region,Parishes.Parish 
								FROM ConstituencyMPs 
								LEFT JOIN Constituencies on ConstituencyMPs.ConstituencyId=Constituencies.ConstituencyId 
								INNER JOIN regions on Constituencies.RegionId=Regions.RegionId 
								INNER JOIN Parishes on Constituencies.parishId = parishes.ParishId 
								WHERE ConstituencyMPs.MpId = '$PoliticianId' AND ConstituencyMPs.DateRemoved IS NULL";
								
								$result = mysqli_query($con, $sql);
								$count = mysqli_num_rows($result);
								$row = mysqli_fetch_array($result);
								
								$ConstituencyName = $row['Region'] . " " . $row['Parish'];
								$ConstituencyId = $row['ConstituencyId'];
								$DateElected = $row['DateElected'];
								$DateElected = date('F j, Y', strtotime($DateElected));
								
								
								if(isset($row['DateRemoved']))
								{
									$DateRemoved = $row['DateRemoved'];
									$DateRemoved = date('F j, Y', strtotime($DateRemoved));
								}
								else
								{
									$DateRemoved = "---";
								}
								
								
								echo "<br>" . "Member of Parliament for " . '<a href="../Constituencies/GETConstituency.php?id=' . $ConstituencyId .'">' . $ConstituencyName . "</a>" . ", " . $DateElected . " to " . $DateRemoved;    
								echo "<br>";
								$DateElected = date('Y-m-d', strtotime($DateElected));
								if($DateRemoved == "---")
								{
									$DateRemoved = date("Y-m-d");
								}
	
								$VotePeriodSQL = "SELECT Bills.BillName, BillVotes.PoliticianVoted, Acts.ActLocation FROM BillVotes
										INNER JOIN BillMeetings ON BillVotes.BillCycle = BillMeetings.BillCycle
										INNER JOIN Bills ON BillMeetings.BillId = Bills.BillId
										LEFT JOIN Acts ON Bills.BillId = Acts.ActId
										WHERE BillVotes.PoliticianId = '$PoliticianId' AND BillMeetings.MeetingDate BETWEEN '$DateElected' AND '$DateRemoved'";
										
								$VotePeriodResult = mysqli_query($con, $VotePeriodSQL);
								$VotePeriodCount = mysqli_num_rows($VotePeriodResult);
								echo "<br/>";
								if($VotePeriodCount > 0)
								{
									echo "<table>";
									echo "<tr>";
										echo "<th>" . "Bill Name" . "</th>";
										echo "<th>" . "Vote" . "</th>";
										echo "<th>" . "Act Location" . "</th>";
									echo "</tr>";
									while($VotePeriodRow = mysqli_fetch_array($VotePeriodResult))
									{
										$BillName = $VotePeriodRow['BillName'];
										$Vote = $VotePeriodRow['PoliticianVoted'];
										$Location = $VotePeriodRow['ActLocation'];
										
										echo "<tr>";
											echo "<td>" . $BillName . "</td>";
											echo "<td>" . $Vote . "</td>";
											echo "<td>" . '<a href="http://' . $Location .'" target="_blank">' . $Location . "</a>" . "</td>";
										echo "</tr>";
									}
									echo "</table>";
									
								}		
							
							}
						
						?>
						
						<?php
						
							if($Role == 'Councillor')
							{
								
								echo "<br>" . "<br>" . "Councillor History";
								
								$sql = "SELECT ConstituencyCouncillors.ConstituencyId, ConstituencyCouncillors.CouncillorId, ConstituencyCouncillors.DateElected,ConstituencyCouncillors.DateRemoved,Regions.Region,Parishes.Parish 
								FROM ConstituencyCouncillors
								LEFT JOIN Constituencies on ConstituencyCouncillors.ConstituencyId=Constituencies.ConstituencyId 
								INNER JOIN regions on Constituencies.RegionId=Regions.RegionId 
								INNER JOIN Parishes on Constituencies.parishId = parishes.ParishId WHERE ConstituencyCouncillors.MpId = '$PoliticianId'";
								
								$result = mysqli_query($con, $sql);
								$count = mysqli_num_rows($result);
								
								while($row = mysqli_fetch_array($result))
								{
									$Region = $row['Region'];
									$Parish = $row['Parish'];
									$DateElected = $row['DateElected'];
									$DateElected = date('F j, Y', strtotime($DateElected));
									
									if(isset($row['DateRemoved']))
									{
										$DateRemoved = $row['DateRemoved'];
										$DateRemoved = date('F j, Y', strtotime($DateRemoved));
									}
									else
									{
										$DateRemoved = "---";
									}
									
									echo "<br>" . "Councillor for " . $Region . " " . $Parish . ", " . $DateElected . " to " . $DateRemoved;    
								}
							
							}	
					
						?>
						
				<?php
					if($Role != "Senator")
					{
				?>		
					
					<div style="margin-top:10%;">
						What More Would you like to See?  <br />
						<select name="ddlCDF" onchange="ShowMore(this.value)">
							<option value=""> Show? </option>
							<option value="CDF"> CDF Data </option>
							<option value="Vote"> Full Voting History </option>
						</select><br/>
					
					</div>
			
				<?php
				}
				?>
					
					
				</div>
				</div>
				
				<div style="margin-top: 25%;">				
						
		
				</div>
				<div id="PoliticianMore"></div>
						<!--
						<iframe width='700' height='400' src='http://openspending.org/mayor_s_proposed_policy_budget_fy2013-15/embed?widget=treemap&state=%7B%22drilldowns%22%3A%5B%22fund%22%2C%22department%22%2C%22unit%22%5D%2C%22year%22%3A2013%2C%22cuts%22%3A%7B%7D%7D&width=700&height=400' frameborder='0'></iframe>			
						-->
						       <!--<?php
									
									if(isset($_SESSION['AdminUserName']))
									{
										echo "<a href='UpdatePoliticianProfile.php?id=$PoliticianId'>Edit?</a>" . " ";
										echo "<a href='AddPoliticianCDF.php?id=$PoliticianId'>Add CDF Data?</a>";
		
									}
								
						?>-->
					
				
				</div>
			
		</div>
		<?php
			include('../header_footer/footer.html')
		?>	
	</body>

</html>
