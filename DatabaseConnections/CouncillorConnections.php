<?php

session_start();

include ("Connection.php"); 
include("../Function.php"); 


//-------------- Insert Councillor -------------
if(isset($_POST['btnAddCouncillor']))
{
	do
	{
		//Function NewId generates 12 character unique key
		$CouncillorId = NewId(12);
		
		//Sql query to check if generated AdminId is available
		$sql = "SELECT * FROM Councillors WHERE CouncillorId = '$CouncillorId'";
		$result = mysqli_query($con,$sql);
		
		// Mysql_num_row is counting table row
		$count=mysqli_num_rows($result);
		
		//Ensures ConstituencyId is unique before inserting Values
		if ($count == 0)
		{	

			$FirstName = $_POST['txtFirstName'];
			$FirstName = mysqli_real_escape_string($con, $FirstName);
			
			$LastName = $_POST['txtLastName'];
			$LastName = mysqli_real_escape_string($con, $LastName);

			$sql = "INSERT INTO Councillors VALUES ('$CouncillorId','$FirstName','$LastName')";
			if (!mysqli_query($con,$sql))
			{
			  	die('Councillor Table Error: ' . mysqli_error($con));
			}
		}
	}
	while ($count!=0);
	//$_SESSION['CouncilResult'] = 'Success';
	header("refresh:0;url=../Councillors/AddCouncillor.php?x=success");
}


?>