<?php  

	$con = mysqli_connect("localhost","admin","password", "keek"); //handles Database Connection
	
	
	if (!$con) // Validates Database Connection
	{
		die('Could not connect: ' . $mysqli -> connect_error);
	}
	
	$db = mysqli_select_db($con,"keek"); //Selects the database we will be using,may not be necessary anymore due to mysqli

?> 