<?php
	
	$BillId = $_GET['q'];
	if($BillId > 0)
	{
		session_start();
		include ("../DatabaseConnections/Connection.php"); 
		
		
		
		$sql = "SELECT * FROM Bills
		INNER JOIN Acts ON Bills.BillId = Acts.ActId
		WHERE BillId = '$BillId'";
		
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($result);
		
		$ActName = $row['BillName'];
		$IntroducedBy = $row['IntroducedBy'];
		$FirstIntroduced = $row['FirstIntroduced'];
		$AssentDate = $row['DateofAssent'];
		$ActDate = $row['DateofAct'];
		
		$AssentDate = date('F j, Y', strtotime($AssentDate));
		$ActDate = date('F j, Y', strtotime($ActDate));
		$FirstIntroduced = date('F j, Y', strtotime($FirstIntroduced));
	
		$ActLocation = $row['ActLocation'];
		$BillDescription = $row['Details'];	
		
		
		$sqlVotes = "SELECT BillVotes.PoliticianId, Politicians.FirstName, Politicians.LastName, BillVotes.PoliticianVoted FROM BillMeetings
		INNER JOIN BillVotes ON BillMeetings.BillCycle = BillVotes.BillCycle
		INNER JOIN Politicians ON BillVotes.PoliticianId = Politicians.PoliticianId
		WHERE BillMeetings.BillId = '$BillId' AND BillMeetings.BillCycle = (SELECT BillMeetings.BillCycle FROM BillMeetings
		INNER JOIN BillVotes ON BillMeetings.BillCycle = BillVotes.BillCycle
		WHERE BillMeetings.BillId = '$BillId' ORDER BY MeetingDate DESC limit 1) ORDER BY Politicians.FirstName ASC";
		
		
		$resultVotes = mysqli_query ($con, $sqlVotes);
		/*echo "<div class='left2' style='margin-right:25%;'>";*/
		echo "<h1> Act Details </h1>";
		echo "<div class='left'>";
		echo "Act Name: <br/>"; //. $ActName . "<br>";
		echo "Introduced By: <br/>"; //. $IntroducedBy . "<br>";
		echo "Date Introduced: <br/>"; //. $FirstIntroduced . "<br>";
		echo "Date of Assent: <br/>"; //. $AssentDate ."<br>";
		echo "Date of Act: <br/>"; //. $ActDate ."<br>";
		echo "Act Location: <br/>"; //. $ActLocation ."<br>";
		echo "Description: <br/>"; //. $BillDescription . "<br>";  
		
		
		echo "</div>";
		
		echo "<div style='margin-right:30%; overflow:auto;''>";
		echo $ActName ."<br/>";
		echo $IntroducedBy ."<br/>";
		echo $FirstIntroduced ."<br/>";
		echo $AssentDate ."<br/>";
		echo $ActDate ."<br/>";
		echo '<a href="http://' . $ActLocation .'" target="_blank">' . "Click Here to View Act" . "</a>" . "<br>";
		echo $BillDescription ."<br/>"; 
		echo "</div>";
		
		/*echo "</div>";*/
		
		
		echo "<br/><br/>";
		
		echo "<div>";
		echo "<h1> Politician's Votes on the Act </h1>" . "<br/>";
		echo "<table id='votes' style='width:100%;'>"; // Create table
			$count = 0;
			while($row = mysqli_fetch_array($resultVotes))
			{
				$FullName = $row['FirstName'] . " " . $row['LastName'];
				$MpId = $row['PoliticianId'];
				
				$count++;
				if($count == 4) //Sets amounts of columns needed
				{
					echo "<tr>";
				}	
					//Code to display check boxes with Politician names
					echo "<td style='text-align:center;  border-right:dashed thin #CDC9A5;'>" . '<a href="../Politicians/PoliticianProfile.php?id=' . $row['PoliticianId'] .'">' . $FullName . "</a>" . " - " . $row['PoliticianVoted'] . "</td>";
					//echo "<td>" .  . "<td>";
				
				if($count == 4)
				{
					//echo "</tr>";
					$count = 1;
				}			
			}
		echo "</table>";
		echo "<div>";
	
		
		
}	
	
	
	
	
	

?>

