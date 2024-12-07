<?php

	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<link rel="stylesheet" href="../css/template.css" type="text/css"/>
		<link rel="stylesheet" href ="../it_is_css.css" type="text/css"/>

		<title>Find a Politician</title>
		
		<link rel="stylesheet" href ="../it_is_css.css" type="text/css"/>
		
		
		<script>
		
			function ShowPoliticianList(str)
			{
			if (str.length==0)
			  { 
			  document.getElementById("PoliticianList").innerHTML="";
			  return;
			  }
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    document.getElementById("PoliticianList").innerHTML=xmlhttp.responseText;
			    }
			  }
			xmlhttp.open("GET","GETPoliticianList.php?q="+str,true);
			xmlhttp.send();
			}		</script>

		
		
		
		<script>
		
			function ShowPolitician(str)
			{
				if (str.length==0)
				  { 
				  document.getElementById("txtHint").innerHTML="";
				  return;
				  }
				if (window.XMLHttpRequest)
				  {// code for IE7+, Firefox, Chrome, Opera, Safari
				  xmlhttp=new XMLHttpRequest();
				  }
				xmlhttp.onreadystatechange=function()
				  {
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				    {
				    document.getElementById("Politician").innerHTML=xmlhttp.responseText;
				    }
				  }
				xmlhttp.open("GET","GETPolitician.php?q="+str,true);
				xmlhttp.send();
				}
		</script>
	
	</head>
	
	<body>
		<div id="parent_container">
		<div id="websiteTitle_container" style="padding-bottom:11px;">
			<div id="logo_container">
				<!---<img src="Images/logo.png" alt="Keek"/>-->
				<div style="margin-left: -1%; padding-top:9%;">
						keeping everyone, everywhere, knowledgeable
					</div>
			</div>
					
			<div id="login_container" style="margin-top: -4%;">
				<?php
   					if(isset($_SESSION['AdminUserName']))
	   				{
	   		 			echo "<a href='../Admin/AdminLogout.php'>";
	   					echo "Log Out";
	   		 			echo "</a>";
	   				 }
	   		 		else
	   				{
	   					echo "<a href='../Admin/AdminLogin.php'>";
	   		 			echo "Log In";
	   		 			echo "</a>";
	   		 		}
   			 	?>

			</div>
		</div>
				
		<div id="navbar_container">		.
			<div id="navlinks_container">
				<ul>
					<li><a href="../default.php">Home</a></li>
					<li><a href="../Politicians/SearchPolitician.php">Politicians</a></li>
					<li><a href="../Constituencies/SearchConstituency.php">Constituencies</a></li>
					<li><a href="../Bills/ViewActs.php">Bills/Acts</a></li>
					<li><a href="../Contact/ContactUs.php">Contact</a></li>
					<li>
					<?php
	   					if(isset($_SESSION['AdminUserName']))
		   				{
		   		 			echo "<a href='../Admin/AdminControl.php'>";
		   					echo "Log Out";
		   		 			echo "</a>";
						}
					?>	
					</li>
				</ul>
			</div>
		</div>
					
		<!--<div id="header_container"></div>
					
		<div id="bar_container">.</div>-->
		<?php
		
			include ("../DatabaseConnections/Connection.php");
			
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
			LEFT JOIN Portfolios ON Ministers.PortfolioId = Portfolios.PortfolioId  
			LEFT JOIN Roles ON Politicians.RoleId = Roles.RoleId
			LEFT JOIN PoliticalParties ON Politicians.PartyId = PoliticalParties.PartyId
			LEFT JOIN ConstituencyMPs ON Politicians.PoliticianId=ConstituencyMPs.MpId 
			LEFT JOIN Constituencies on ConstituencyMPs.ConstituencyId=Constituencies.ConstituencyId 
			LEFT JOIN Regions on Constituencies.RegionId=Regions.RegionId 
			LEFT JOIN Parishes on Constituencies.parishId = Parishes.ParishId 
			WHERE ConstituencyMPs.DateRemoved IS NULL OR Politicians.RoleId = '4' ORDER BY FirstName ASC limit $offset,$limit"; 
			
			/*$sql = "SELECT * FROM Politicians 
			LEFT JOIN Ministers ON Politicians.PoliticianId=Ministers.MinisterId
			LEFT JOIN Portfolios ON Ministers.PortfolioId = Portfolios.PortfolioId  
			LEFT JOIN Roles ON Politicians.RoleId = Roles.RoleId
			LEFT JOIN PoliticalParties ON Politicians.PartyId = PoliticalParties.PartyId
			ORDER BY FirstName ASC limit $offset,$limit";*/
			
			$results = mysqli_query($con, $sql);		
			
			$Countsql = "SELECT * FROM Politicians 
			LEFT JOIN Ministers ON Politicians.PoliticianId=Ministers.MinisterId 
			LEFT JOIN Roles ON Politicians.RoleId = Roles.RoleId
			LEFT JOIN PoliticalParties ON Politicians.PartyId = PoliticalParties.PartyId";
			
			$CountResults = mysqli_query($con, $Countsql);
					
			$numrows = mysqli_num_rows($CountResults);
			
			
	
			
		?>
		<div id="contactUs_container" style="overflow:auto;">
		<h1>Search for a Politician</h1>
			<div style="margin-bottom:3%; padding:20px;">
		
				<form class="formular">			
					Politician Name: <input type="text" name="PoliticianSearch" onkeyup="ShowPolitician(this.value)" />
					<br/>
					Suggestions: <br/><span id="Politician"></span>
					
					
					<!--
						Show Politician List?:	<select name="ddlShowPoliticianList" onchange="ShowPoliticianList(this.value)" >
		  											<option value=""> Show List? </option>
		  											<option value="Yes"> Yes </option>
		  											<option value="No"> No </option>
		  										</select><br/>
		  				<div id="PoliticianList"></div><br/>
					-->
				</form>
		</div>
			
			
							
		
		<div style="padding:20px;">
		<?php
			
			echo "<table border = '1'>
				<thead>
				<tr>
					<th scope='col'>Name</th>
					<th scope='col'>Gender</th>
					<th scope='col'>Role</th>
					<th scope='col'>Minister</th>
					<th scope='col'>Party Affiliation</th>
					<th scope='col'>Constituency</th>";
					
					if(isset($_SESSION['txtUserName']))
					{	
						echo "<th scope='col'>Action</th>";
					}
				echo "</tr></thead>";
				
				
				while($row = mysqli_fetch_array($results))
				{
					
					/* $ConstituencySQL = "SELECT * FROM ConstituencyMPs 
										LEFT JOIN Constituencies on ConstituencyMPs.ConstituencyId=Constituencies.ConstituencyId 
										INNER JOIN regions on Constituencies.RegionId=Regions.RegionId 
										INNER JOIN Parishes on Constituencies.parishId = parishes.ParishId 
										WHERE MPId = '$row[PoliticianId]' ORDER BY DateElected ASC limit 1";
					
					$ConstituencyResults = mysql_query($ConstituencySQL);
					$ConstituencyRow = mysql_fetch_array($ConstituencyResults);
					*/
					$FullName = $row['FirstName'] . " " . $row['LastName'];
					$ConstituencyName = $row['Region'] . " " . $row['Parish']; 				
					if ($row['Minister'] == 'Yes') 
						$Minister = $row['Portfolio']; 
					else 
						$Minister = $row['Minister'];
	
	 
					echo "<tr>";
						echo "<td>" . '<a href="PoliticianProfile.php?id=' . $row['PoliticianId'] .'">' . $FullName . "</a>" . "</td>";
						echo "<td>" . $row['Gender'] . "</td>";
						echo "<td>" . $row['Role'] . "</td>";
						echo "<td>" . $Minister . "</td>";
						echo "<td>" . $row['PartyName'] . "</td>";
						echo "<td>" . '<a href="../Constituencies/GETConstituency.php?id=' . $row['ConstituencyId'] .'">' . $ConstituencyName . "</a>" . "</td>";
						if(isset($_SESSION['txtUserName']))
						{
							echo "<td>" . '<a href="UpdatePoliticianProfile.php?id=' . $row['PoliticianId'] .'">' . "Edit?" . "</a>" . "</td>";
						}
					echo "</tr>";
				}
			echo "</table><br/>";
		
		
		if ($offset>1) 
		{ // bypass PREV link if offset is 0 
	    	$prevoffset=$offset-20; 
	    	print "<a href=\"SearchPolitician.php?offset=$prevoffset\">PREV</a> &nbsp; \n"; 
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
		    print "<a href=\"SearchPolitician.php?offset=$newoffset\">$i</a> &nbsp; \n"; 
		} 
		
		// check to see if last page 
		if (!(($offset/$limit)==$pages) && $pages!=1) { 
		    // not last page so give NEXT link 
		    $newoffset=$offset+$limit; 
		    print "<a href=\"SearchPolitician.php?offset=$newoffset\">NEXT</a><p>\n"; 
		} 
	
	
		
		
		?>
		</div>
		</div>	
		
<!--
	<table width="400" border="0" cellspacing="1" cellpadding="0" align="center"> 
		<tr>
			<td>
				<table width="400" border="1" cellspacing="0" cellpadding="3">
					<tr>
						<td colspan="11"><strong><center>Politions</center></strong> </td>
					</tr>
					
					<tr>
						<td align="center"><strong>First Name</strong></td>
						<td align="center"><strong>Last Name</strong></td>
						<td align="center"><strong>Gender</strong></td>
						<td align="center"><strong>Role</strong></td>
						<td align="center"><strong>Minister</strong></td>
						<td align="center"><strong>Party Affiliation</strong></td>
						<td align="center"><strong>Update</strong></td>
					</tr>
					
					<?php
						while($rows=mysqli_fetch_array($results)){
					?>
					
					<tr>
						<td><?php echo $rows['FirstName']; ?></td>
						<td><?php echo $rows['LastName']; ?></td>
						<td><?php echo $rows['Gender']; ?></td>
						<td><?php echo $rows['Role']; ?></td>
						<td><?php echo $rows['Minister']; ?></td>
						<td><?php echo $rows['PartyAffiliation']; ?></td>
						
						<td align="center"><a href="Politician_Update.php?id=<?php echo $rows['PoliticianId']; ?>">Update</a></td>
					</tr>
					
					<?php
						}
					?>
					
				</table>
			</td>
		</tr>
	</table>
	
	<?php
	mysqli_close($con);
	?>

		
		
-->		
		
		
		
		
		</div>
		
		<?php	
			include('../header_footer/footer.html');
		?>
	</body>

</html>
