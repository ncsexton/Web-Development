/*function determineActive(pageLoaded) 
{
		var y = document.getElementById("page-title");
		var x;
		y.innerHTML = "Got Here";
		/*if(pageLoaded === "alphabetical")
		{
			y.innerHTML = "Alphabetical Listing of Tennessee State Parks";
			x = document.getElementById("alphabetical");
			if(x.className === "alphabetical") {
			x.className += " active";
			}
			else {
			x.className = "alphabetical";
			}
		}
		else if(pageLoaded === "regional")
		{
		y.innerHTML = "Regional Listing of Tennessee State Parks";
		x = document.getElementById("regional");
		if(x.className === "regional") {
		x.className += " active";
		}
		else 
		{
		x.className = "regional";
		}*/
	/*
	
	if(pageLoaded === "about")
	{
		y.innerHTML = "About The Experiments";
		x = document.getElementById("about");
		if(x.className === "about") {
		x.className += " active";
		}
		else {
		x.className = "about";
		}
	}
	else if(pageLoaded === "contact")
	{
		y.innerHTML = "Contact Nathan";
		x = document.getElementById("contact");
		if(x.className === "contact") {
		x.className += " active";
		}
		else {
		x.className = "contact";
		}
	}
	else if(pageLoaded === "home")
	{
		y.innerHTML = "Nathan's Hololens 2 Summer Research";
		x = document.getElementById("home");
		if(x.className === "home") {
		x.className += " active";
		}
		else {
		x.className = "home";
		}
	}
}

*/

window.onload = function(){
// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    modalImg.alt = this.alt;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

}

var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}

function imageLink(){
	
var imgLink = document.getElementById('homeImgLink');
imgLink.onclick = function() {
	window.location.href='/final/about';
}
}

/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}