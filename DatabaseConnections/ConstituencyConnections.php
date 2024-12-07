<?php 

session_start();

include ("Connection.php"); 
include("../Function.php"); 


//-----------------Add Constituency------------

if(isset($_POST['btnAddConstituency'])) //COndition to check which button was click
{
	do 
	{
		//Function NewId generates 12 character unique key
		$ConstituencyId = NewId(12);
		
		//Sql query to check if generated AdminId is available
		$sql = "SELECT * FROM Constituencies WHERE ConstituencyId = '$ConstituencyId'";
		$result = mysqli_query($con,$sql);
		
		// Mysql_num_row is counting table row
		$count=mysqli_num_rows($result);
		
		//Ensures ConstituencyId is unique before inserting Values
		if ($count == 0)
		{	
		
			//Saves session variables to local
		
			$Region = mysqli_real_escape_string($con,$_SESSION['ddlRegion']);
			$Parish = mysqli_real_escape_string($con,$_SESSION['ddlParish']);
			
			$Description= mysql_real_escape_string ($_SESSION['txtDescription']);
			
			//DB Insert
			$sql = "INSERT INTO Constituencies Values ('$ConstituencyId','$Region','$Parish', '$Description')";
			if (!mysqli_query($con,$sql))
			{
			  	die('Constituency Table Error: ' . mysqli_error($con));
			}
			
			if(isset($_POST['ddlMP'])) 
			{
				$MPId = mysqli_real_escape_string($con,$_POST['ddlMP']);
				$MPDateElected = mysqli_real_escape_string($con,$_POST['txtMPDateElected']);
				//$MPDateRemoved = mysqli_real_escape_string($con,$_POST['txtMPDateRemoved']);
				
				$sql = "INSERT INTO ConstituencyMPs(ConstituencyId,MpId,DateElected) Values ('$ConstituencyId','$MPId','$MPDateElected')";
				if (!mysqli_query($con,$sql))
				{
				  	die('ConstituencyMP Table Error: ' . mysqli_error($con));
				}
				
			}
			
			
			if(isset($_POST['ddlCouncillorCount']))
			{
				//Saves SESSION Arrays to local variables
				$arrayCouncillorId = $_POST['ddlCouncillor'];					
				$arrayCouncillorDateElected = $_POST['txtCouncillorDateElected'];
				//$arrayCouncillorDateRemoved = $_POST['txtCouncillorDateRemoved'];
	
				$CouncillorCount = $_POST['ddlCouncillorCount']; //Variable showing how many Councillors were chosen 
				for ($x=0;$x<$CouncillorCount;$x++)
				{
					//Variables in array are stored to each variable on each pass
					
					$CouncillorId = $arrayCouncillorId[$x];
					$CouncillorDateElected = $arrayCouncillorDateElected [$x];
					//$CouncillorDateRemoved = $arrayCouncillorDateRemoved [$x];
					
					$sql = "INSERT INTO ConstituencyCouncillors(ConstituencyId,CouncillorId,DateElected) VALUES ('$ConstituencyId','$CouncillorId','$CouncillorDateElected')";
					if (!mysqli_query($con,$sql))
					{
					  	die('ConstituencyCouncillors Table Error: ' . $x . ' ' . mysqli_error($con));
					}
					
				}
			
			}
			
			
			$AddressLine1 = mysqli_real_escape_string($con,$_SESSION['txtAddressLine1']);
			$AddressLine2 = mysqli_real_escape_string($con,$_SESSION['txtAddressLine2']);
			$Town = mysqli_real_escape_string($con,$_SESSION['txtTown']);
			$Parish = $_SESSION['ddlParish'];
			$ContactNumber = mysqli_real_escape_string($con,$_SESSION['txtContactNumber']);
			$Email = mysqli_real_escape_string($con, $_SESSION['txtEmail']);
		
						
			$sql = "INSERT INTO ConstituencyContacts VALUES ('$ConstituencyId','$AddressLine1','$AddressLine2','$Town','$Parish','$ContactNumber','$Email')";
			if (!mysqli_query($con,$sql))
			{
			  	die('ConstituencyContact table Error: ' . mysqli_error($con));
			}
		
		header("refresh:0;url=../Admin/AdminControl.php");	
		
		}
	}
	while($count!=0); //do condition runs until UNIQUE NewId is generated

}
	//--------------- Update Constituency ------------------------------
	if(isset($_POST['btnUpdateConstituency']))
	{
		$MPId = mysqli_real_escape_string($con,$_POST['ddlMP']);
		$MPDateElected = mysqli_real_escape_string($con,$_POST['txtMPDateElected']);
		//echo $MPId . "<br>";
		
		$sql = "SELECT * FROM ConstituencyMps WHERE MPId = '$MPId' AND DateRemoved IS NULL";
		$result = mysqli_query($con,$sql);
		$count = mysqli_num_rows($result);
		//echo $count;
		if($count == 0)
		{
			$ConstituencyId = $_POST['hiddenConstituencyId'];
			$DateRemoved = $_POST['txtDateRemoved'];
			
			$sql = "UPDATE ConstituencyMps SET DateRemoved = '$DateRemoved' 
					WHERE ConstituencyId = '$ConstituencyId' AND DateRemoved IS NULL";
			if (!mysqli_query($con,$sql))
			{
			  	die('Update ConstituencyMps table Error: ' . mysqli_error($con));
			}
	
			
			if(isset($_POST['ddlMP'])) 
			{
				//$MPDateRemoved = mysqli_real_escape_string($con,$_POST['txtMPDateRemoved']);
				
				$sql = "INSERT INTO ConstituencyMPs(ConstituencyId,MpId,DateElected) Values ('$ConstituencyId','$MPId','$MPDateElected')";
				if (!mysqli_query($con,$sql))
				{
				  	die('ConstituencyMP Table Error: ' . mysqli_error($con));
				}
					
			}
			
			if(isset($_POST['ddlCouncillorCount']))
			{
				//Saves SESSION Arrays to local variables
				$arrayCouncillorId = $_POST['ddlCouncillor'];					
				$arrayCouncillorDateElected = $_POST['txtCouncillorDateElected'];
				//$arrayCouncillorDateRemoved = $_POST['txtCouncillorDateRemoved'];
	
				$CouncillorCount = $_POST['ddlCouncillorCount']; //Variable showing how many Councillors were chosen 
				for ($x=0;$x<$CouncillorCount;$x++)
				{
					//Variables in array are stored to each variable on each pass
					
					$CouncillorId = $arrayCouncillorId[$x];
					$CouncillorDateElected = $arrayCouncillorDateElected [$x];
					//$CouncillorDateRemoved = $arrayCouncillorDateRemoved [$x];
					
					$sql = "INSERT INTO ConstituencyCouncillors(ConstituencyId,CouncillorId,DateElected) VALUES ('$ConstituencyId','$CouncillorId','$CouncillorDateElected')";
					if (!mysqli_query($con,$sql))
					{
					  	die('ConstituencyCouncillors Table Error: ' . $x . ' ' . mysqli_error($con));
					}
					
				}
			
			}
			
				
			
			header("refresh:0;url=../Constituencies/GETConstituency.php?id=" . $ConstituencyId);
		
		}
		else
		{
			echo "Error! This Member of Parliament is already assigned to a Constituency." . "<br>" . "You will be routed in 3....2.....1";
			header("refresh:5;url=../Constituencies/SearchConstituency.php");
		}		
	}
?>