<?php

	



	include ("../DatabaseConnections/Connection.php");
	
	//Get[id] is populated when the request to view this comes from other pages than the constituency search page
	
	if(isset($_GET['region']) && isset($_GET['parish']) || isset($_GET['id'])) //Condition checks what page request is being sent from
	{
		if(!isset($_GET['id'])) 
		{
			$RegionId = $_GET['region'];
			$ParishId = $_GET['parish'];
			
			$sql = "SELECT ConstituencyId FROM Constituencies WHERE RegionId = '$RegionId' AND ParishId = '$ParishId'";
			$result = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($result);
			
			
			$ConstituencyId = $row['ConstituencyId'];
		}
		else
		{
			session_start();
			?>
			
			
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			
			<head>
				<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
				<title>Search Constituency</title>
				<link rel="stylesheet" href="../it_is_css.css" type="text/css"/>
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

			
			<?php

			$ConstituencyId = $_GET['id'];
			
			$sql = "SELECT * FROM Constituencies 
			LEFT JOIN Parishes ON Constituencies.ParishId = Parishes.ParishId
			LEFT JOIN Regions ON Constituencies.RegionId = Regions.RegionId
			WHERE ConstituencyId = '$ConstituencyId'";
			
			$results = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($results);
			
			$Parish = $row['Parish'];
			$Region = $row['Region'];
			
			echo "<br>" . "<h2>" . $Region . " " . $Parish . "</h2>" . "<br>";
			
		}
				
		$MpSQL = "SELECT ConstituencyMPs.DateElected, ConstituencyMPs.DateRemoved, Politicians.PoliticianId, Titles.Title, Politicians.FirstName,Politicians.LastName
					FROM Constituencies 
					INNER JOIN ConstituencyMPs ON Constituencies.ConstituencyId=ConstituencyMPs.ConstituencyId
					LEFT JOIN Politicians ON ConstituencyMPs.MpId=Politicians.PoliticianId
					INNER JOIN Titles on Politicians.TitleId=Titles.TitleId
					WHERE Constituencies.ConstituencyId='$ConstituencyId'";
			
		$CouncillorSQL = "SELECT Constituencies.ConstituencyId, ConstituencyCouncillors.CouncillorId, ConstituencyCouncillors.DateElected, ConstituencyCouncillors.DateRemoved, Politicians.PoliticianId, Titles.Title, Politicians.FirstName,Politicians.LastName
							FROM Constituencies 
							INNER JOIN ConstituencyCouncillors ON Constituencies.ConstituencyId=ConstituencyCouncillors.ConstituencyId
							LEFT JOIN Politicians ON ConstituencyCouncillors.COuncillorId=Politicians.PoliticianId 
							INNER JOIN Titles on Politicians.TitleId=Titles.TitleId
							WHERE Constituencies.ConstituencyId='$ConstituencyId'";

	
		$Mpresult = mysqli_query($con, $MpSQL);
		//$count = mysql_num_rows($Mpresult);
		echo "<h2>Member of Parliament History</h2> ";	
		while($row = mysqli_fetch_array($Mpresult))
		{
			$MpTitle = $row['Title'];
			$MpFirstName = $row['FirstName'];
			$MpLastName = $row['LastName'];
			$MpDateElected = $row['DateElected'];
			$MpDateElected = date('F j, Y', strtotime($MpDateElected));
			
			
			if(isset($row['DateRemoved']))
			{
				$MpDateRemoved = $row['DateRemoved'];
				$MpDateRemoved = date('F j, Y', strtotime($MpDateRemoved));
			}
			else
			{
				$MpDateRemoved = "---";
			}
			
			$FullName = $MpFirstName . " " . $MpLastName;
			echo '<a href="../Politicians/PoliticianProfile.php?id=' . $row['PoliticianId'] .'">' . $FullName . "</a>" . ", " . $MpDateElected . " to " . $MpDateRemoved . "<br>";    
		}
	
		$CouncillorResult = mysqli_query($con, $CouncillorSQL);
		echo "<br>" . "<br>";
		echo "<h2>Councillor History</h2> " . "<br>";	
		
		while($row = mysqli_fetch_array($CouncillorResult))
		{
			$CouncillorTitle = $row['Title'];
			$CouncillorFirstName = $row['FirstName'];
			$CouncillorLastName = $row['LastName'];
			$CouncillorDateElected = $row['DateElected'];
			$CouncillorDateElected = date('F j, Y', strtotime($CouncillorDateElected));
			
			
			if(isset($row['DateRemoved']))
			{
				$CouncillorDateRemoved = $row['DateRemoved'];
				$CouncillorDateRemoved = date('F j, Y', strtotime($CouncillorDateRemoved));
			}
			else
			{
				$CouncillorDateRemoved = "---";
			}
			
			
			$FullName = $MpFirstName . " " . $MpLastName;
			echo '<a href="../Politicians/PoliticianProfile.php?id=' . $row['PoliticianId'] .'">' . $FullName . "</a>" . ", " . $MpDateElected . " to " . $MpDateRemoved . "<br>";    
			
			
			
		}
		?>
		</div>
		</div>
		
		</body>
		</html>	
<?php
include('../header_footer/footer.html');	
}
?>