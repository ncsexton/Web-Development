<!DOCTYPE html>
<html>
	<head>
	<title>404</title>
	<?php
		include("includes/head-tag.php");
	?>
	
	</head>
	

	
	<body onload="determineActive('404')">
		<div class = "bold-header">
			<h1>Oh no, a 404 page, and the links are gone!</h1>
		</div>
		<br>
		
		
		
		<p class="data-text">
			"Don't worry, I can help you find your way out! Just click the button below me, in the bottom left corner of the screen!"
		</p>

		<img class="contact-image" src="img/ellie_christmas.jpg"
		width="800" height="1000"/>
		
		<header>
		<div class="topnav" id="myTopnav" style="display: none">
			  <a href="/final/">Home</a>
			  <a href="/final/about">About the Experiments</a>
			  <a href="/final/contact">Contact Me</a>
			  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
				<i class="fa fa-bars"></i>
				</a>
		</div>
		</header>
		<br>
		
		<button type="button" onclick="document.getElementById('myTopnav').style.display='block'">Click here!</button>
		
	</body>
	
	
</html>