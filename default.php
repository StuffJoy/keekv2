<?php

	session_start();
	echo md5("Newuser1");

?>


<html>
	<head>
		<link href="it_is_css.css" rel="stylesheet" type="text/css" >
		<title>Home</title>
	</head>
	
	<body>
	<div id="parent_container">
	<?php
		include("header_footer/header.php");
	?>
		
		<div id="info_container" style="padding-bottom:40px;">
			<div id="about_container">
				<h1>Our Aim</h1>
				<p> To provide the Jamaican public with a more transparent view of
					the activities and expense of their political representatives
					which will move Jamaica forward in e-governance.
				</p>
			</div>
			
			<div id="right_sidebar">
				<h2>Contact Us</h2>
				<p>For further information about this system 
				please send your emails to the following address:</p> <br/>
				<i>egovernance2013@gmail.com</i> or go <a href="../Contact/ContactUs.php">here</a><br ><br/>
				Thank You for your time.				
			</div>
			<div id="news_widget">
				<h1>Latest News</h1>
				<script type="text/javascript" src="http://app.feed.informer.com/digest3/FWPJ9KTWXG.js"></script>
					<noscript>
						<a href="http://app.feed.informer.com/digest3/FWPJ9KTWXG.html">Click for &quot;Latest News&quot;.</a>
						Powered by <a href="http://feed.informer.com/">RSS Feed Informer</a>
					</noscript>
			</div>
		</div>
	</div>
		
	<?php
		include("header_footer/footer.html");
	?>
	</body>
</html>