<?php  
session_start();  
require_once('../final/Config.php');
require_once('Model/contactModel.php');
class Controller  
{  
	function __construct()   
	{  //make config file object  
		$this->con = new Config(); 
		
		$this->contactdb = new ContactModel ($this->con->servername, $this->con->username,
			$this->con->password, $this->con->dbname);
	}  
	
	public function handleRequest()   
	{  
		/*Get the user's request$_SERVER[‘REQUEST_URI’]is an Apache web-server variable that 
		retrieves this web page’s path (after the domain or sub-domain name).*/
		$request = $_SERVER['REQUEST_URI'];
		/*__DIR__ is an Apache constant that retrieves the full directoryof this current PHP file.  
		For this file, it is:/home/pf9voxkvcy23/public_html/acrockett/five/Controller
		
		str_replace is a PHP string function to replace one occuranceof a subscring (“/Controller”) 
		with a string (NULL) in a given string ($route)*/
		
		$route = __DIR__;
		$route = str_replace("/Controller",NULL,$route);
		
		//Route the user to the correct view (template)
		switch ($request)               
		{  
			/* In the first case below, remember that the subdirectory
			variable was defined in the Config class and currentlyis just /five/.  
			So the first case is if the request that came to the web server is for /five/, 
			which meansthe home page is being requested.*/
			case $this->con->subdirectory:
			//the . (dot) in the code below concatenates two strings
			require $route . '/views/home.php';
			break; 
			
			/* if the request is /five/alphabetical/ then route to the Views folder and access the alphabetical.php template.*/        
			/*case $this->con->subdirectory.'alphabetical':  
			require $route . '/views/alphabetical.php'; 
			break;  */
			
			/*case $this->con->subdirectory.'regional': 
			require $route . '/views/regional.php';
			break;  */
			
			case $this->con->subdirectory.'about' :  
			require $route . '/views/about.php';
			break;  
			
			case $this->con->subdirectory.'contact' :  
				$this->contact($route);
			break;                 
			
			/*case $this->con->subdirectory.'norris_dam_state_park' :  
			require $route . '/views/park-detail/norris_dam_state_park.php';
			break; */
			
			/*The default case only executes if there were no previouscase matches.  
			This means we have a “page not found”error and should show the 404.php template.  
			For example,If the user typed http://acrockett.aprilcrockett.net/five/whatever,then the 
			default statement would execute and the 404 page would display.*/
			
			default:  
				http_response_code(404);
				require $route . '/views/404.php';
				break;             
				
			}  
		} 
		
		public function contact($route)
		{
			if($_SERVER['REQUEST_METHOD'] == "POST")
			{
				$firstName = preg_replace("#[^\w]#", "", $_POST['firstName']);
				$lastName = preg_replace("#[^\w]#", "", $_POST['lastName']);
				$email = $_POST['email'];
				$message = $_POST['message'];
				
				$this->contactdb->saveContactMessage($firstName, $lastName, $email, $message);
				
				require $route . '/views/confirmation.php';
			}
			else
			{
				require $route . '/views/contact.php';
			}
		}
	}
?>