<!DOCTYPE html>
<html>


	
	<head>
	<title>About The Data</title>
	<?php
		include("includes/head-tag.php");
	?>
	
	</head>
	
	

	<body  onload="currentSlide(1)">
	
	<body>
		<div class = "bold-header">
		<div class="topnav" id="myTopnav">
		  <a href="/final/">Home</a>
		  <a href="/final/about" class="active">About the Experiments</a>
		  <a href="/final/contact">Contact Me</a>
		  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
			<i class="fa fa-bars"></i>
		  </a>
		</div>
			<h1>Microsoft Hololens 2 Research</h1>
		</div>
		<br>
		

		<!--<div class = "text">
			<p>
				Welcome to the About Page! Here I will try (and maybe fail) to eloquently explain one of the experiments I performed, the data I got out of that experiment, and what that data represents.
				 I am currently working on another experiment that would fit well here, so I will add that in the coming weeks when it is completed.
			</p>
		</div>-->
			
			<h2 class="image-header">Completed Experiments</h2>
			
			<p class="text">
				In this experiment, I created multiple different Google Cloud Platform (GCP) servers around the globe, all running CentOS 8 as the operating system. From these GCP instances, they all ran the same basic TCP server program,
				 which would receive a wide variety of message sizes, starting at 2^18 bytes (roughly 262 kilobytes), and down to 2^9 bytes (512 bytes). The messages would be sent from the client (the Hololens), 
				 to the server, and back to the client to calculate the total Round-Trip-Time. This process would be repeated 100 times for each message size, and the average was logged and charted into the graph.
				 In doing this experiment, it was found that the average RTT skyrockets exponentially as the client and server get further and further apart, rather than linearly as expected. 
				 After continued testing, it was determined that this is due to TCP's Three-Way-Handshake, 
				 which bloated the data significantly. The tests were then redone, this time factoring out the Three-Way-Handshake to gather more data. At this point in time, I am working on a UDP server and client that will gather 
				 the same performance metrics, and the data will be compared to determine whether TCP or UDP will be a better choice moving forward.
			</p>
		
		
		<?php
			include("includes/data-slideshow.php");
		?>
		
		<h2 class="image-header">Future Experiments</h2>
		<p class="text">
			There are a few different tests I currently have planned that I will gradually chip away at over the next few months, most of which are designed 
			with the intention of gathering baseline data that can be used to help steer which direction the project moves in the future. The first would be create a UDP version of the TCP experiment that I outlined above, 
			which would allow us to compare and decide (or at least have a good idea of) which network protocol would be the most appropriate to implement moving forward. This so far has proven to be more complex than a few 
			simple changes in the code, but I hope to have it completed in the near future, at which point I will add it to the completed experiments. Another planned series of experiments will be to optimize how much time the 
			Hololens must spend at the application layer of the network to process information that is being transmitted. This will involve measuring a the default buffer size and potentially designing future experimental 
			applications to override the buffer size to a size that would allow for more efficient data transfers, and finding the right middle-ground of allocating enough extra memory to make a difference, but not too much 
			that the whole device is slowed down.
		</p>
		<!--
		<h2 class="image-header">Calculated Round-Trip-Time (RTT) With TCP Three Way Handshake Included</h2>
			<p class="data-text">
				Shown below is the data from the initial test, which included the RTT for the TCP Three-Way-Handshake. Evident in the data is the incredible spike between
				 262144 Bytes and 131072 Bytes for Tokyo, Sydney, Hong Kong, and Mumbai.
			</p>
	
		<img class ="data-image" src="img/GCPTestData.jpg"
		width="1250px" height="600px"/>
		
		<h2 class="image-header">Calculated Round-Trip-Time (RTT) With TCP Three Way Handshake Excluded</h2>
		<p class="data-text">
				Shown below is the updated data once the Three-Way-Handshake was removed from the data pool. As seen in the data,
				the removal of these few datapoints made the relationship in the data much more linear than before.
			</p>
		<img class="data-image" src="img/UpdatedData.jpg"
		width="1250" height="600"/>
		-->
		
		
	</body>
</html>