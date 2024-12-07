<?php

	include ("../DatabaseConnections/Connection.php");
	
	$q = $_GET['q'];

	echo "<label for='lblRegion'>Region: </label>";
				
  //xmlhttp.open("GET","../Constituencies/GETConstituency.php?str",true);
	$sql= "SELECT Constituencies.RegionId, Regions.Region FROM Constituencies 
		  INNER JOIN Regions ON Constituencies.RegionId = Regions.RegionId
		  WHERE ParishId = '$q'";
		  
	$res=mysqli_query($con, $sql);
	
	echo "<select name='ddlRegion' onchange='ShowConstituency()'>";
	echo "<option value='Select' selected='selected'>Select Region Question</option>";
	while ($row=mysqli_fetch_array($res))
	{
		echo "<option value=\"{$row['RegionId']}\">{$row['Region']}</option>";
	}	
	
		echo "</select>";
				
	echo "<br>";
	echo "<div id='Constituency' style='padding-top:5%; padding-bottom:5%;'></div>";


?>