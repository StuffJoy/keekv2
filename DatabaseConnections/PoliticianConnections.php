<?php


	session_start();
	
	include ("Connection.php"); 
	include("../Function.php"); 
	
	
	//------------------Insert Politcian---------------------
	
	if(isset($_POST['btnAddPolitician']) || isset($_POST['btnSkipImage']))
	{	
		do
		{
			//Function NewId generates 12 character unique key
			$PoliticianId = NewId(12);
			
			//Sql query to check if generated PoliticianId is available
			$sql = "SELECT * FROM Politicians WHERE PoliticianId = '$PoliticianId'";
			$result = mysqli_query($con,$sql);
			
			// Mysql_num_row is counting table row
			$count=mysqli_num_rows($result);
			
			//Ensures PoliticianId is unique before inserting Values
			if ($count == 0)
			{	
	
		
				if (isset($_POST['btnSkipImage']) || isset($_POST['btnAddPolitician']))
				{
				
					if(isset($_POST['btnSkipImage']))
					{
						if($_SESSION['ddlGender'] == 'Male')  
							$Location = "images/PoliticianImages/DefaultMale.png";
						else
							$Location = "images/PoliticianImages/DefaultFemale.jpg";
												
					}
					else
					{
					
						$extension = Extension($_FILES['PoliticianImage']);
						$filename = $PoliticianId.$extension;
						move_uploaded_file($_FILES["PoliticianImage"]["tmp_name"],"C:/Users/OWNER/Dropbox/University/Year 4/Major Project/Application/Images/PoliticianImages/" . $filename);
					
						$Location = "/images/PoliticianImages/" . $filename;
					}
	
				}
				
				
				$Title = mysqli_real_escape_string($con,$_SESSION['ddlTitle']);			
				$FirstName = mysqli_real_escape_string($con,$_SESSION['txtFirstName']);
				$LastName = mysqli_real_escape_string($con,$_SESSION['txtLastName']);
				$Gender = mysqli_real_escape_string($con,$_SESSION['ddlGender']);
				$DOB = mysqli_real_escape_string($con,$_SESSION['txtDOB']);
				$Role = mysqli_real_escape_string($con,$_SESSION['ddlRole']);
				$Minister = mysqli_real_escape_string($con,$_SESSION['ddlMinister']);
				$PartyAffiliation = mysqli_real_escape_string($con,$_SESSION['ddlParty']);
				
				
				
				$sql = "INSERT INTO Politicians VALUES ('$PoliticianId','$Title','$FirstName','$LastName','$Gender','$DOB','$Role','$Minister','$PartyAffiliation','$Location')";
				if (!mysqli_query($con,$sql))
				{
				  	die('Politicians table Error: ' . mysqli_error($con));
				}
				
				
				if(isset($_SESSION['ddlPrimeMinister']) && isset($_SESSION['ddlPortfolio']))
				{
					$PrimeMinister = mysqli_real_escape_string($con,$_SESSION['ddlPrimeMinister']);
					$Portfolio = mysqli_real_escape_string($con,$_SESSION['ddlPortfolio']);
					
					
					$sql = "INSERT INTO Ministers VALUES ('$PoliticianId','$Portfolio','$PrimeMinister')";
					if (!mysqli_query($con,$sql))
					{
					  	die('Minister table Error: ' . mysqli_error($con));
					}
	
				
				}
				
			}
		}
		while($count!=0); //do condition runs until unique NewId is generated
		header("refresh:0;url=../Admin/AdminControl.php");
	}
	
	/*
	//------------------Politician Profile -----------
	if(isset($_GET['id']))
	{
		$PoliticianId = $_GET['id'];
		$sql = "SELECT * FROM Politicians LEFT JOIN Ministers ON Politicians.PoliticianId=Ministers.MinisterId WHERE Politicians.PoliticianId = '$PoliticianId'";
		$result = mysqli_query($con,$sql);
		$row = mysql_fetch_array($result);
		
		$_SESSION['Title'] = $row['Title'];
		$_SESSION['FirstName'] = $row['FirstName'];
		$_SESSION['LastName'] = $row['LastName'];
		$_SESSION['Gender'] = $row['Gender'];
		$_SESSION['DOB'] = $row['DOB'];
		$_SESSION['Role'] = $row['Role'];
		$_SESSION['Image'] = $row['ImageLocation'];
		
		$sql = "SELECT PartyName FROM PoliticalParties WHERE PartyId = '$row[PartyAffiliation]'";
		$result = mysqli_query($con,$sql);
		$row = mysql_fetch_array($result);
		
		$_SESSION['PartyAffiliation'] = $row['PartyName'];
		
		
		$Minister = $row['Minister']; 
		
		if($Mnister == 'Yes')
		{
		
			$sql = "SELECT * FROM Ministers INNER JOIN Portfolios ON Ministers.PortfolioId=Portfolios.PortfolioId WHERE Ministers.MinisterId = '$PoliticianId'";
			$result = mysqli_query($con,$sql);
			$row = mysql_fetch_array($result);
	
			$_SESSION['PrimeMinister'] = $row['PrimeMinister'];
			$_SESSION['Portfolio'] = $row['Portfolio'];		
		}
		
		
		
	}	
	*/
	//---------------Update Politician Profile --------------------------
	if(isset($_POST['btnUpdatePolitician']))
	{
		$PoliticianId = $_POST['hiddenPoliticianId'];
		$TitleId = $_POST['ddlTitle'];			
		$FirstName = mysqli_real_escape_string($con,$_POST['txtFirstName']);
		$LastName = mysqli_real_escape_string($con,$_POST['txtLastName']);
		$Gender = mysqli_real_escape_string($con,$_POST['ddlGender']);
		
		if(isset($_POST['txtDOB']))
			$DOB = mysqli_real_escape_string($con,$_POST['txtDOB']);
		else
			$DOB = NULL;
			
		$Role = $_POST['ddlRole'];
		
		if(isset($_POST['ddlMinister']))
			$Minister = mysqli_real_escape_string($con,$_POST['ddlMinister']);
		
		$PartyAffiliation = mysqli_real_escape_string($con,$_POST['ddlParty']);
		
	/*	
		
		echo "PoliticianId -> " . $PoliticianId . "<br>";
		echo "TitleId -> " . $TitleId = $_POST['ddlTitle'] . "<br>";			
		echo "FirstName -> " . $FirstName . "<br>";
		echo "LastName -> " . $LastName . "<br>";
		echo "Gender -> " . $Gender . "<br>";
		
		if(isset($_POST['txtDOB']))
			echo "DOB -> " . $DOB . "<br>";
		else
			echo "DOB -> " . $DOB . "<br>";
			
		echo "Role -> " . $Role . "<br>";
		
		if(isset($_POST['ddlMinister']))
			echo "Minister -> " . $Minister . "<br>";
		
		echo "PartyAffiliation -> " . $PartyAffiliation . "<br>";
	
	*/	
		
		$sql = "UPDATE Politicians
				SET TitleId = '$TitleId', FirstName = '$FirstName', LastName = '$LastName', Gender = '$Gender', DOB = '$DOB', RoleId = '$Role', PartyId = '$PartyAffiliation'
				WHERE PoliticianId = '$PoliticianId';";
	
		if (!mysqli_query($con,$sql))
		{
		  	die('Update Politicians Table Error: ' . mysqli_error($con));
		}
	
		if(isset($_POST['ddlPrimeMinister']) && ($_POST['ddlPortfolio']))
		{
			$PrimeMinister = $_POST['ddlPrimeMinister'];
			$Portfolio = $_POST['ddlPortfolio'];
			
			$sql = "SELECT * FROM Ministers WHERE MinisterId = '$PoliticianId'"; //checks if this politician is a minister in the db
			$result = mysqli_query($con,$sql);
			
			$count = mysqli_num_rows($result);
			
			
			if($count == 0) //if no records are found, then an insert has to be done to insert the new minister's data
			{
				
				$sql = "UPDATE Politicians
				SET Minister = 'Yes' 
				WHERE PoliticianId = '$PoliticianId'";
				
				if (!mysqli_query($con,$sql))
				{
				  	die('Update Insert Politician Minister table Error: ' . mysqli_error($con));
				}
	
				$sql = "INSERT INTO Ministers VALUES ('$PoliticianId','$Portfolio','$PrimeMinister')";
				if (!mysqli_query($con,$sql))
				{
				  	die('Update Insert Minister table Error: ' . mysqli_error($con));
				}
	
			}
			else //if a record is are found, the record is updated
			{		
				$sql = "UPDATE Ministers 
				SET PortfolioId = $Portfolio, PrimeMinister = '$PrimeMinister'
				WHERE MinisterId = '$PoliticianId'";
			
				if (!mysqli_query($con,$sql))
				{
				  	die('Error Update: ' . mysqli_error($con));
				}
				
				
			}
		}
	
		header("refresh:0;url=../Politicians/PoliticianProfile.php?id=" . $PoliticianId);
	}
	
	//Insert Politician CDF data
	
	if(isset($_POST['btnAddCDF']))
	{
		$PoliticianId = $_POST['ddlPoliticianId'];
		$Year = mysqli_real_escape_string($con,$_POST['txtYearDate']);
		$EmbeddedURL = mysqli_real_escape_string($con,$_POST['txtEmbedURL']);
		
		$sql = "INSERT INTO PoliticianCDF(PoliticianId,OpenSpendingLink,SpendingDate) VALUES ('$PoliticianId','$EmbeddedURL','$Year')";
		if (!mysqli_query($con,$sql))
		{
		  	die('Error Update: ' . mysqli_error($con));
		}
		
		header("refresh:0;url=../Politicians/PoliticianProfile.php?id=" . $PoliticianId);
	}
	



?>