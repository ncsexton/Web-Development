<?php  class ContactModel  
{  
	protected $conn; //attribute
	
	function __construct($host,$uname,$pass,$db)  
	{  
		$this->servername = $host;  
		$this->username = $uname;  
		$this->password =  $pass;  
		$this->dbname = $db;  
	}  
		//function to open the database
		
		public function openDb()  
		{  
			$this->conn = mysqli_connect($this->servername, $this->username,
			$this->password, $this->dbname);
			if (mysqli_connect_errno()) 
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
				exit();
			}
		}  
		
	//function to close the database
	public function closeDb()  
	{   
		mysqli_close($this->conn);
	}  

	public function saveContactMessage($firstname, $lastname, $email, $message)  
	{    
		$this->openDb();  
		$query = "INSERT INTO tbl_contact (FirstName, LastName, Email, Message)                       
		VALUES ('".$firstname."', '".$lastname."', '".$email."', '".$message."')";
		
		echo $query."<br>";
		if (mysqli_query($this->conn, $query)) 
		{
			//echo "New record created successfully";
		} 
		else {
			echo "Error: " . $query . "<br>" . mysqli_error($this->conn);
			}
		$this->closeDb();   
	} 

}  

?>