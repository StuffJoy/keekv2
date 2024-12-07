<?php

	include("../DatabaseConnections/Connection.php");
	$PoliticianId = $_GET['politicianid'];	
	if($_GET['q'] == 'CDF')
	{	
		echo "<br/>";
		$sql = "SELECT * FROM PoliticianCDF WHERE PoliticianId = '$PoliticianId' ORDER BY SpendingDate DESC";
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($result);
		$count = mysqli_num_rows($result);
		
		if($count > 0)
			$EmbeddedUrl = $row['OpenSpendingLink'];
		else
			$EmbeddedUrl = "No CDF data has been uploaded";
		
		echo $EmbeddedUrl;
	}
	elseif ($_GET['q'] == "Vote")
	{
												
		echo "<br/>" . "<br/>" . "<b>Member of Parlaiment History</b>";
		
		$sql = "SELECT ConstituencyMPs.ConstituencyId, ConstituencyMPs.MpId, ConstituencyMPs.DateElected,ConstituencyMPs.DateRemoved,Regions.Region,Parishes.Parish 
		FROM ConstituencyMPs 
		LEFT JOIN Constituencies on ConstituencyMPs.ConstituencyId=Constituencies.ConstituencyId 
		INNER JOIN Regions on Constituencies.RegionId=Regions.RegionId 
		INNER JOIN Parishes on Constituencies.parishId = Parishes.ParishId 
		WHERE ConstituencyMPs.MpId = '$PoliticianId' ORDER BY DateElected ASC";
		
		$result = mysqli_query($con, $sql);
		$count = mysqli_num_rows($result);
		
		while($row = mysqli_fetch_array($result))
		{
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
			
			
			echo "<br/>Member of Parliament for " . '<a href="../Constituencies/GETConstituency.php?id=' . $ConstituencyId .'">' . $ConstituencyName . "</a>" . ", " . $DateElected . " to " . $DateRemoved;    
			$DateElected = date('Y-m-d', strtotime($DateElected));
			if($DateRemoved == "---")
			{
				$DateRemoved = date("Y-m-d");
			}
			else
				$DateRemoved = date('Y-m-d', strtotime($DateRemoved));

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
				echo "</tr>" . "<br>";
				while($VotePeriodRow = mysqli_fetch_array($VotePeriodResult))
				{
					$BillName = $VotePeriodRow['BillName'];
					$Vote = $VotePeriodRow['PoliticianVoted'];
					$Location = $VotePeriodRow['ActLocation'];
					
					echo "<tr>";
						echo "<td>" . $BillName . "</td>";
						echo "<td>" . $Vote . "</td>";
						echo "<td>" . '<a href="http://' . $Location .'" target="_blank">' . "Click Here to View Act" . "</a>" . "</td>";
					echo "</tr>";
				}
				echo "</table>";
				
			}
		}								
		
	}


?>