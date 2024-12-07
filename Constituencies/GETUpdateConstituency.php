<?php
	
	include("../DatabaseConnections/Connection.php");
	
	if($_GET['str'] == 'Yes')
	{
		
		$RegionId = $_GET['region'];
		$ParishId = $_GET['parish'];
				
		$sql = "SELECT ConstituencyId FROM Constituencies WHERE RegionId = '$RegionId' AND ParishId = '$ParishId'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
				
				
		$ConstituencyId = $row['ConstituencyId'];
		
		echo "<form action = '../DatabaseConnections/ConstituencyConnections.php' method = 'post' >";
			
			echo "<input type='hidden' name='hiddenConstituencyId' value=$ConstituencyId >";
			echo "Date Outgoing Politician was removed from Office" . "<br>";
			echo "<input type='text' name='txtDateRemoved' class='jdpicker'>" . "<br>" . "<br>";
				
			echo "Select the New Member of Parlaiment" . "<br>";	
						
			$sql="SELECT * FROM Politicians WHERE RoleId = '1' ORDER BY FirstName ASC"; 
			$result =mysql_query($sql); 
	
			echo "<select name='ddlMP' class='validate[required]'>";
			echo "<option value='' selected='selected'>Select MP</option>";
			while ($row=mysql_fetch_array($result)) 
			{ 
				$Name = $row['FirstName'] . " " . $row['LastName'];
				echo "<option value=\"{$row['PoliticianId']}\">{$Name}</option>"; 
			} 
	
			echo "</select>";
			echo "<br>" . "<br>";			
			
			echo "Date Elected into Office" . "<br>";
			echo "<input type='text' name='txtMPDateElected' class='jdpicker' />" . "<br>" . "<br>";

			
			echo "How many counsellors does this constituency have?" . "<br>"; 
			echo "<select name='ddlCouncillorCount' onchange='ShowCouncillor(this.value)' class='validate[required]'>";
				echo "<option value=''> Number </option>";
				echo "<option value='1'> 1 </option>";
			    echo "<option value='2'> 2 </option>";
			    echo "<option value='3'> 3 </option>";
			    echo "<option value='4'> 4 </option>";
			    echo "<option value='5'> 5 </option>";
			echo "</select>" . "<br/>";
	
			echo "<br>";
			echo "<div id='Councillor'></div>";
			echo "<br>";
			//echo "<br>";
			echo "<input type = 'submit' name='btnUpdateConstituency' value = 'Update Constituency'>";
		echo "</form>";	
	}
?>