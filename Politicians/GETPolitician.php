<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Untitled 1</title>
	<style>
		ul
		{
			list-style-type:none;
			margin-left: -10%;
		}
		
		a
		{
			text-decoration:none;
			color: #7A2805;
		}
		
		a:hover
		{
			font-weight:bold;
		}
	</style>
</head>

<body>
<?php
	// Fill up array with names
	
	include ("../DatabaseConnections/Connection.php"); 
	
	
	$sql = "SELECT PoliticianId,FirstName,LastName from Politicians";
	$result = mysqli_query($con, $sql);
	
	while($row = mysqli_fetch_array($result))
	{
		$UserArray[]= $row['LastName'] . ", " . $row['FirstName'];
		$PoliticianId[] = $row['PoliticianId']; 
	}
	
	//get the q parameter from URL
	$q=$_GET["q"];
	
	//lookup all hints from array if length of q>0
	if (strlen($q) > 0)
	  {
	  $hint="";
	  for($i=0; $i<count($UserArray); $i++)
	    {
	    if (strtolower($q)==strtolower(substr($UserArray[$i],0,strlen($q))))
	      {
	      if ($hint=="")
	        {
	        	//$hint=$UserArray[$i];
	        	$hint = "<ul><li><a href='PoliticianProfile.php?id=$PoliticianId[$i]'>$UserArray[$i]</a>";
	        }
	      else
	        {
	        	//$hint=$hint." , ".$UserArray[$i];
	        	$hint = $hint. "<li>" . "<a href='PoliticianProfile.php?id=$PoliticianId[$i]'>$UserArray[$i]</a></li>";
	        }
	      }
	    }
	    echo "</ul>";
	  }
	
	// Set output to "no suggestion" if no hint were found
	// or to the correct values

	
	if ($hint == "")
	  {
	  	$response="no suggestion";
	  }
	else
	  {
	  	$response=$hint;
	  }
	
	//output the response
	echo $response;
	
	
	//echo "<a href='SearchProfile.php?id=' . $hint>hint</a>";
?>
</body>

</html>
