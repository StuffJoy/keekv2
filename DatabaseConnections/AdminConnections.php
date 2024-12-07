<?php

session_start();

include ("Connection.php"); 
include("../Function.php"); 


//---------------Add Admin------------------

if (isset($_POST['btnCreateAdmin']))
{
	do
	{
		//Function NewId generates 12 character unique key
		$AdminId = NewId(12);
		
		//Sql query to check if generated AdminId is available
		$sql = "SELECT * FROM Admins WHERE AdminId = '$AdminId'";
		$result = mysqli_query($con,$sql);
		
		// Mysql_num_row is counting table row
		$count=mysqli_num_rows($result);
		
		//Ensures AdminId is unique before inserting Values
		if ($count == 0)
		{	
			$password = mysqli_real_escape_string($con, $_SESSION['txtPassword']);
			$UserName = mysqli_real_escape_string($con, $_SESSION['txtUserName']);
			$SecurityAnswer = mysqli_real_escape_string($con, $_SESSION['txtSecurityAnswer']);
			$hashedSecurityAnswer = md5($SecurityAnswer);
			$Email = mysqli_real_escape_string($con, $_SESSION['txtEmail']);
			$SecurityQuestion = $_SESSION['ddlSecurityQuestion'];
			$hashpassword = md5($password);
			
			$sql = "INSERT INTO Admins Values ('$AdminId','$UserName','$hashpassword', '$SecurityQuestion','$hashedSecurityAnswer','$Email')";
			if (!mysqli_query($con,$sql))
			{
			  	die('Admin Table Error: ' . mysqli_error($con));
			}
			
			
			$FirstName = mysqli_real_escape_string($con, $_POST['txtFirstName']);
			$LastName = mysqli_real_escape_string($con, $_POST['txtLastName']);
			$Gender = mysqli_real_escape_string($con, $_POST['ddlGender']);
			$DOB = mysqli_real_escape_string($con, $_POST['txtDOB']);
			
			
			$sql = "INSERT INTO Administrators VALUES ('$AdminId','$FirstName','$LastName','$Gender','$DOB')";
			if (!mysqli_query($con,$sql))
			{
			  	die('Administrator table Error: ' . mysqli_error($con));
			}
			
			
			$AddressLine1 = mysqli_real_escape_string($con, $_POST['txtAddressLine1']);
			$AddressLine2 = mysqli_real_escape_string($con, $_POST['txtAddressLine2']);
			$Town = mysqli_real_escape_string($con, $_POST['txtTown']);
			$Parish = $_POST['ddlParish'];
			$ContactNumber = mysqli_real_escape_string($con, $_POST['txtContactNumber']);
			
			$sql = "INSERT INTO AdminContacts VALUES ('$AdminId','$AddressLine1','$AddressLine2','$Town','$Parish','$ContactNumber')";
			if (!mysqli_query($con,$sql))
			{
			  	die('Admin Contact table Error: ' . mysqli_error($con));
			}

			
		}
	}
	while($count!=0); //do condition runs until unique NewId is generated
	
	header("refresh:0;url=../Admin/AdminLogin.php");
		
} 


//---------------Admin Login------------------

if (isset($_POST['btnAdminLogin']))
{
	
	
	
	$Email = $_POST['txtAdminEmail'];
	$password = $_POST['txtPassword'];
	
	//$password = mysql_real_escape_string ($password);
	
	$hashpassword = md5($password);
	
	$Email = mysqli_real_escape_string($con, $Email);
	
	$sql = "SELECT * FROM Admins";
	$result = mysqli_query($con,$sql);
	
	// Mysql_num_row is counting table row
	$countAdmins = mysqli_num_rows($result);
		
	if($countAdmins == 0)
	{	
		header("refresh:0;url=../Admin/CreateAdmin.php");
	}
	else
	{
	
		$sql = "SELECT * FROM AdminLogs WHERE Email = '$Email' AND hashpassword = '$hashpassword' AND Used = 'NO'";
		$result = mysqli_query($con,$sql);
		
		// Mysql_num_row is counting table row
		$countAdminLog=mysqli_num_rows($result);
		
		if($countAdminLog == 1)
		{
			//$row = mysql_fetch_array($result);
		
			//if($row['Used'] == 'YES')
			//{
			//	$_SESSION['LoginStatus'] = 'Registered';
			//	header("refresh:0;url=../Admin/AdminLogin.php");
			//}
			//else
			//{	
				$_SESSION['AdminLogEmail'] = $Email;
				header("refresh:0;url=../Admin/CreateAdmin.php");
			//}
		}
		
		else
		{
	
			$sql = "SELECT * FROM Admins WHERE Email = '$Email' AND hashedpassword = '$hashpassword'";
			$result = mysqli_query($con,$sql);
			
			// Mysql_num_row is counting table row
			$count=mysqli_num_rows($result);
	
	 		if($count == 1)
			{
				$row = mysqli_fetch_array($result);
				
				$_SESSION['AdminId'] = $row['AdminId'];
				$_SESSION['AdminUserName'] = $row['UserName'];
				$_SESSION['AdminEmail'] = $row['Email'];
				
				$sql = "SELECT * FROM Administrators WHERE AdminId = '$_SESSION[AdminId]'";
				$result = mysqli_query($con,$sql);
				$row=mysqli_fetch_array($result);
				
				$_SESSION['AdminFirstName'] = $row['FirstName'];
				$_SESSION['AdminLastName'] = $row['LastName'];
				$_SESSION['AdminGender'] = $row['Gender'];
				$_SESSION['AdminDOB'] = $row['DOB'];
				
				$_SESSION['LoginStatus'] = "Success";
				header("refresh:0;url=../Admin/AdminControl.php"); 
				
			}
			else
			{
				$_SESSION['LoginStatus'] = "Unsuccessful";
				header("refresh:0;url=../Admin/AdminLogin.php"); 	
			}
		}
	}
		
}


//------------Admin New Log-----------------------
if(isset($_GET['q']))
{
	$AdminId = $_SESSION['AdminId'];
	$Email = $_GET['q'];
	$hashedpassword = md5("monkeymuffins");
	$Used = "NO";
	$today = date("Y-m-d H:i:s");
	
	$sql = "INSERT INTO AdminLogs VALUES ('$AdminId', '$Email', '$hashedpassword', '$Used', '$today')";        
	if (!mysqli_query($con,$sql))
	{
	  	die('AdminLog table Error: ' . mysqli_error($con));
	}
	
	header("refresh:0;url=../Admin/AdminControl.php");

	
}
        
//----------------------New Admin Login -------------------
if(isset($_SESSION['AdminLogEmail']) && isset($_POST['btnCreateAdmin']))
{
	$Email = mysqli_real_escape_string($con, $_SESSION['AdminLogEmail']);
	
	$sql = "UPDATE AdminLogs SET Used = 'YES' WHERE Email = '$Email'";
	if (!mysqli_query($con,$sql))
	{
	  	die('AdminLog Update table Error: ' . mysqli_error($con));
	}
	
	unset($_SESSION['AdminLogEmail']);
}   

//--------------------Forgot Password-----------------------
if(isset($_POST['btnPasswordReset']))
{

	$SecurityQuestion = mysqli_real_escape_string($con, $_POST['ddlSecurityQuestion']);
	$SecurityAnswer = mysqli_real_escape_string($con, $_POST['txtSecurityAnswer']);
	$SecurityAnswer = md5($SecurityAnswer);
	$Email = mysqli_real_escape_string($con, $_POST['txtEmail']);
	
	$sql = "SELECT * FROM Admins WHERE QuestionId = '$SecurityQuestion' AND hashedSecurityAns = '$SecurityAnswer' AND Email = '$Email'";
	$result = mysqli_query($con,$sql);
			
	// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);
	
	if($count == 1)
	{
		$_SESSION['SendForgottenEmail'] = $Email;
		header("refresh:0;url=../Admin/SendForgottenPassword.php");
	}
	else
	{
		header("refresh:0;url=../Admin/AdminLogin.php");
	}

}









?>