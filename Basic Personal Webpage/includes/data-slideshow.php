<!-- Slideshow container -->
<div class="slideshow-container">

  <!-- Full-width images with number and caption text -->
  <div class="mySlides fade">
    <div class="numbertext">1 / 2</div>
    <img class="data-image" src="img/GCPTestData.jpg" style="width:100%">
    <div class="caption">
	This is the data from the initial test, which included the RTT for the TCP Three-Way-Handshake. Evident in the data is the incredible spike between
	 262144 Bytes and 131072 Bytes for Tokyo, Sydney, Hong Kong, and Mumbai.</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">2 / 2</div>
    <img class="data-image" src="img/UpdatedData.jpg" style="width:100%">
    <div class="caption">
	Here is the updated data once the Three-Way-Handshake was removed from the data pool. As seen in the data,
	 the removal of these few datapoints made the relationship in the data much more linear than before.
	</div>
  </div>

 <!-- <div class="mySlides fade">
    <div class="numbertext">3 / 3</div>
    <img src="img/meandellie.jpg" style="width:100%">
    <div class="caption">Caption Three</div>
  </div>-->

  <!-- Next and previous buttons -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span>
  <span class="dot" onclick="currentSlide(2)"></span>
  <!--<span class="dot" onclick="currentSlide(3)"></span>-->
</div>