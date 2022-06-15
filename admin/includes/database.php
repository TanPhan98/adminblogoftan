<?php  
class database{
	private $dns = "mysql:host=localhost;dbname=blog";
	private $username = "root";
	private $password = "";
	private $conn;

	public function connect(){
		$this->conn = null;
		try{
			$this->conn = new PDO($this->dns,$this->username,$this->password); 
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		}catch(PDOException $e){
			echo "Connection failed: ".$e->getMessage();
		}

		return $this->conn;
	}

}
?>