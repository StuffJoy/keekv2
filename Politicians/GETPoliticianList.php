<?php
	/*include('../header.php');*/
	include ("../DatabaseConnections/Connection.php");
	
	if(isset($_GET['q']))
		$ShowList = $_GET['q'];
	else
		$ShowList = 'Yes';
	
	if($ShowList == "Yes")
	{
		$limit = 20;
		
		if(isset($_GET['offset']))
		{
			
			$offset = $_GET['offset'];
			
		}
		
		if(empty($offset))
		{
			$offset = 1;
		}
		
		$sql = "SELECT * FROM Politicians 
		LEFT JOIN Ministers ON Politicians.PoliticianId=Ministers.MinisterId 
		LEFT JOIN Roles ON Politicians.RoleId = Roles.RoleId
		LEFT JOIN PoliticalParties ON Politicians.PartyId = PoliticalParties.PartyId
		ORDER BY FirstName ASC limit $offset,$limit";
		
		$results = mysqli_query($con, $sql);		
		
		$Countsql = "SELECT * FROM Politicians 
		LEFT JOIN Ministers ON Politicians.PoliticianId=Ministers.MinisterId 
		LEFT JOIN Roles ON Politicians.RoleId = Roles.RoleId
		LEFT JOIN PoliticalParties ON Politicians.PartyId = PoliticalParties.PartyId";
		
		$CountResults = mysqli_query($con, $Countsql);
				
		$numrows = mysqli_num_rows($CountResults);
		
		
		echo "<table border = '1'>
			<tr>
				<th>Name</th>
				<th>Gender</th>
				<th>Role</th>
				<th>Minister</th>
				<th>Party Affiliation</th>
				<th>Action</th>
			</tr>";
			
			while($row = mysqli_fetch_array($results))
			{
				$FullName = $row['FirstName'] . " " . $row['LastName']; 
				echo "<tr>";
					echo "<td>" . '<a href="PoliticianProfile.php?id=' . $row['PoliticianId'] .'">' . $FullName . "</a>" . "</td>";
					echo "<td>" . $row['Gender'] . "</td>";
					echo "<td>" . $row['Role'] . "</td>";
					echo "<td>" . $row['Minister'] . "</td>";
					echo "<td>" . $row['PartyName'] . "</td>";
					
					echo "<td>" . '<a href="PoliticianProfile.php?id=' . $row['PoliticianId'] .'">' . $FullName . "</a>" . "</td>";
				echo "</tr>";
			}
		echo "</table>";
		
		
		if ($offset>1) 
		{ // bypass PREV link if offset is 0 
	    	$prevoffset=$offset-20; 
	    	print "<a href=\"GETPoliticianList.php?offset=$prevoffset\">PREV</a> &nbsp; \n"; 
		}
		
			// calculate number of pages needing links 
		$pages=intval($numrows/$limit); 
	
		// $pages now contains int of pages needed unless there is a remainder from division 
		if ($numrows%$limit) { 
		    // has remainder so add one page 
		    $pages++; 
		} 
		
		for ($i=1;$i<=$pages;$i++) { // loop thru 
		    $newoffset=$limit*($i-1); 
		    print "<a href=\"GETPoliticianList.php?offset=$newoffset\">$i</a> &nbsp; \n"; 
		} 
		
		// check to see if last page 
		if (!(($offset/$limit)==$pages) && $pages!=1) { 
		    // not last page so give NEXT link 
		    $newoffset=$offset+$limit; 
		    print "<a href=\"GETPoliticianList.php?offset=$newoffset\">NEXT</a><p>\n"; 
		} 
	}


	
	
?>