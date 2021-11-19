<?php
/*
Config.php Contains the Config file. 
After Module 6, this file will contain database connection information too.
*/

class Config {
	function __construct() {
		$this->subdirectory ="/final/";
		
		$this->servername = "localhost";
		$this->username = "ncsexton42";
		$this->password = "csc3100_6c";
		$this->dbname = "db_ncsexton42";
		}
	}
?>