<?php

	session_start();

	include ("Connection.php"); 
	include("../Function.php"); 

	
	// --------------- Insert Bill ----------------
	if(isset($_POST['btnAddBill']))
	{
		//$BillId = 
		$BillName = mysqli_real_escape_string($con, $_POST['txtBillName']);
		
		if(isset($_POST['txtIntroducedBy']))
			$IntroducedBy = mysqli_real_escape_string($con, $_POST['txtIntroducedBy']);
		else
			$IntroducedBy = NULL;
			
		$BillDate = mysqli_real_escape_string($con, $_POST['txtBillDate']);
		$BillDescription = mysqli_real_escape_string($con, $_POST['txtBillDescription']);
	
		$sql = "INSERT INTO Bills (BillName,IntroducedBy,FirstIntroduced,Details) VALUES ('$BillName','$IntroducedBy','$BillDate','$BillDescription')";
		if (!mysqli_query($con,$sql))
		{
		  	die('Bills table Error: ' . mysqli_error($con));
		}
		
		header("refresh:0;url=../Admin/AdminControl.php");


	}
	
	//------------------ Add Bill Meeting ----------------
	
	if(isset($_POST['btnBillVotes']))
	{		
		do
		{
			$BillCycle = NewId(12);
			
			$sql = "SELECT * FROM BillMeetings WHERE BillCycle = '$BillCycle'";
			$results = mysqli_query($con,$sql);
			
			$count = mysqli_num_rows($results);
			
			
			if($count == 0)
			{
				
				
				$BillId = $_SESSION['ddlBill'];
				$arrayPoliticians = $_SESSION['RadioPoliticians'];
				$MeetingDate = $_SESSION['txtMeetingDate'];
								
				$sql = "SELECT * FROM BillMeetings WHERE BillId = '$BillId'";
				$results = mysqli_query($con,$sql);
				$BillCount = mysqli_num_rows($results);
				$BillCount++;
				
				$sql = "INSERT INTO BillMeetings (BillCycle, BillId, BillCount, MeetingDate) VALUES ('$BillCycle','$BillId','$BillCount','$MeetingDate')";
				if (!mysqli_query($con,$sql))
				{
				  	die('BillMeetings table Error: ' . mysqli_error($con));
				}
		 		
		 		$RadioVoteChoice = $_POST['RadioVoteChoice'];	
		 		
		 		if($RadioVoteChoice == "Undetermined")
					$PoliticianVoted = $RadioVoteChoice;
					
 
				foreach ($arrayPoliticians as $PoliticianId)
				{	
					
					if($RadioVoteChoice == 'Individual')
						$PoliticianVoted = $_POST[$PoliticianId];
					
					$sql = "INSERT INTO BillVotes (BillCycle, PoliticianId, PoliticianVoted) VALUES ('$BillCycle','$PoliticianId','$PoliticianVoted')";
					if (!mysqli_query($con,$sql))
					{
					  	die('BillVotes table Error: ' . mysqli_error($con));
					}
		
				}
				
				header("refresh:0;url=../Admin/AdminControl.php");

				
			}
		} while ($count!=0);
		
	}
	
	//-------------------------Add Act ------------------
	if(isset($_POST['btnCreateAct']))
	{
		$ActId = $_POST['ddlAct'];
		$AssentDate = $_POST['txtAssentDate'];
		$ActDate = $_POST['txtActDate'];
		$ActLocation = mysqli_real_escape_string($con, $_POST['txtActLocation']);
		
		$sql = "INSERT INTO Acts (ActId,DateofAssent,DateofAct,ActLocation) VALUES ('$ActId','$AssentDate','$ActDate','$ActLocation')";
		if (!mysqli_query($con,$sql))
		{
		  	die('BillVotes table Error: ' . mysqli_error($con));
		}
		header("refresh:0;url=../Admin/AdminControl.php");
	}
	


?>