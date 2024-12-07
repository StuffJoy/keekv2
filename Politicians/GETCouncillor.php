<?php

	include ("../DatabaseConnections/Connection.php");

	$count = $_GET['q']; //Variable passed to indicate how many controls page should create
	
	for($x=0; $x<$count; $x++) //Loop to create multiple controls
	{			
		$sql = "SELECT * FROM Politicians WHERE RoleId = '2'";
		$result = mysqli_query($con, $sql);
		
		
		echo "<select name='ddlCouncillor[$x]'>"; //Control name created as an aaray to store multiple values
		echo "<option value= '' selected='selected'>Select Councillor</option>";
		while($row=mysqli_fetch_array($result))
		{
			$Name = $row['FirstName'] . " " . $row['LastName']; //Politician's First and Last Name concatenated to before being displayed
			echo "<option value = \"{$row['PoliticianId']}\">{$Name}</option>";
		}
		
		echo "</select>" . "<br>";
		echo "";
		echo "Date Elected into Power: <input type='date' name='txtCouncillorDateElected[$x]' class='jdpicker' />" . "<br>";
		//echo "Date Removed from Power: <input type='date' name='txtCouncillorDateRemoved[$x]' />" . "<br>";
		echo "<br>";

	}
			 
?>

