<?php 

//session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function NEWID($length)
{
	$charactr = "ABCDEFGHIJ0123456789";
	
	$size = strlen ($charactr);
	$str = null;
	for($i = 0; $i < $length; $i++)
	{
		$str .= $charactr[rand(0,$size - 1)];
	}
	
	return $str;
}
		

		
		
		
function Extension ($Image)
{	
	if ((($Image["type"] == "image/gif")
	|| ($Image["type"] == "image/jpeg")
	|| ($Image["type"] == "image/png")
	|| ($Image["type"] == "image/pjpeg"))
	&& ($Image["size"] < 2000000))
	//&& in_array($extension, $allowedExts))
	{
	if ($Image["error"] > 0)
	{
		echo "Return Code: " . $Image["error"] . "<br />";
	}
	else
	{
		$filename = $Image['name'];
		$extension = "";
		
		$x = strlen($filename);
		
		$extension .= $filename[$x-3];
		$extension .= $filename[$x-2];
		$extension .= $filename[$x-1];
		
		//echo $extension;
		
		//$_SESSION['ImageName'] = $_SESSION['AdminId'];
			
					
		//$filename = $_SESSION['ImageName'].".".$extension;
	}
	}
	
	else
	{
		echo "Invalid file";
	}
	
	return $extension;
}	
		



function AgeCalculator($dob)
{
	$today = date("Y-m-d");
	
	$diff = abs(strtotime($today) - strtotime($dob));
	
	$age = floor ($diff/(365*60*60*24));
	
	return $age;
}	



	
		
?>
	
