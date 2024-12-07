<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
</head>

<body>

<?php
include ("../DatabaseConnections/Connection.php");

if($_GET['q'] == 'Yes')
{
	echo "Is this the Prime Minister?: ";
							echo "<select name='ddlPrimeMinister'>";
					  			echo "<option value=''> Minister? </option>";
					  			echo "<option value='Yes'> Yes </option>";
					  			echo "<option value='No'> No </option>";
				 			 echo "</select>" . "<br/>";
				 			 
				 			 
	echo "Portfolio: "; 
	
					$sql="SELECT * FROM Portfolios ORDER BY Portfolio ASC";
					$result=mysqli_query($con, $sql);
			
					echo "<select name='ddlPortfolio'>";
					echo "<option value= '' selected='selected'>Select Portfolio</option>";
					while($row=mysqli_fetch_array($result))
					{
						echo "<option value = \"{$row['PortfolioId']}\">{$row['Portfolio']}</option>";
					}
					
					echo "</select>" . "<br>";


}

		
		
	
			 
?>


</body>

</html>

