<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<?php
			include("includes/head-tag.php");
		?>
	</head>
	

	
	<body>
		<body>
		<div class = "bold-header">
		<?php
			include("includes/navbar.php");
		?>
			<h1>Microsoft Hololens 2 Research</h1>
		</div>
		<br>
		
		<h2 class="image-header">Low-Latency for Augmented Reality Interactive Systems</h2>
		
		<div  class = "text">
			<p>
				Hello and welcome to my home page! Here on this website I will be showcasing some of the data I have gathered from my networking research 
				that I have been participating in. This research is focused on the communications between two AR/VR devices, specifically the Microsoft HoloLens 2.
				The AR/VR community generally agrees that the optimal latency range for communications should be between 10ms and 50ms. However, this is difficult to 
				achieve using current network and cloud computing technologies. The long-term objective of this research is to eplore an edge-cloud hybrid model of communication 
				with data potentially cached near the individual users in an attempt to overcome the current latency problems. Right now in the short term, I am working with 
				other students at Colorado State University to stress-test the networking capacities of the Microsoft HoloLens 2, and lay the groundwork for the project moving forward.
				
				
			</p>
			
			<p>
				By navigating to the "About the Experiments" page, you can see an example of some of the data I have collected and graphed so far with my completed experiments,
				 as well as a working roadmap for what experiments I will be looking into in the future. The "Contact Me" page is where you can learn a little bit more about me, 
				 as well as the best ways to reach me. 
			</p>
			
			<p>
				Pictured below is a Microsoft Hololens 2, the main hardware that I have been / will be experimenting with over the course of this research. Softwares used include Visual Studio 2019, 
				Google Cloud Platform, Digital Ocean, and Virtual Machines running the CentOS 8 Operating System.
			</p>
		</div>
		
		<div>
			
			<img id="homeImgLink" class="home-image" src="img/hololens.jpg" onclick="imageLink()" width="800" height="500"/>
			
			
		</div>
	</body>
</html>