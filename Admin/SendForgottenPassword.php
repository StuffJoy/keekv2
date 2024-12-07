<?php

	session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
		<link rel="stylesheet" href ="../it_is_css.css" type="text/css"/>
		<title>Password Sent</title>
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
		   					echo "Control Panel";
		   		 			echo "</a>";
						}
					?>	
					</li>
				</ul>
			</div>
		</div>
					
		<div id="header_container"></div>
					
		<div id="bar_container">.</div>

		<div id="contactUs_container" style="padding-left: 40px; padding-bottom:40px;">

		<?php
		 	include ("../DatabaseConnections/Connection.php"); 
			session_start();
		
		 
		    require("../phpmailer/class.phpmailer.php");
		    $mail = new PHPMailer();
		
		    // ---------- adjust these lines ---------------------------------------
		    $mail->Username = "egovernance2013@gmail.com"; // your GMail user name
		    $mail->Password = "thisisthepassword";
		    $mail->AddAddress($_SESSION['SendForgottenEmail']); // recipients email
		    $mail->FromName = "Major Project"; // readable name
		
		    $mail->Subject = "E-Governance Password Reset";
		    $mail->Body    = "Your password has been reset to 'monkeymuffins'. Please change your password after Login..."; 
		    //-----------------------------------------------------------------------
		
		    $mail->Host = "ssl://smtp.gmail.com"; // GMail
		    $mail->Port = 465;
		    $mail->IsSMTP(); // use SMTP
		    $mail->SMTPAuth = true; // turn on SMTP authentication
		    $mail->From = $mail->Username;
		    
		    echo "<div id='message_container'>";
		    echo "<div id='message'>";
		    
		    if(!$mail->Send())
		        echo "Mailer Error: " . $mail->ErrorInfo;
		    else
		    {
		        echo "Message has been sent" . "<br>";
		        
		        $Email = $_SESSION['SendForgottenEmail'];
		        $tempPassword = 'monkeymuffins';
		        $tempPassword = md5($tempPassword);
		        
		        $sql = "UPDATE Admins SET hashedPassword = '$tempPassword' WHERE Email = '$Email'";
				if (!mysql_query($sql,$con))
				{
				  	die('Admins Update table Error: ' . mysql_error());
				}
			
				unset($_SESSION['SendForgottenEmail']);
		        
		       	echo "Page will redirect in 3..2..1";
				header("refresh:3;url=../Admin/AdminLogin.php");
			}
			echo "</div>";
			echo "</div>";
		?>
		</div>
		</div>
		<?php
			include('../header_footer/footer.html');
		?>
	</body>
</html>

