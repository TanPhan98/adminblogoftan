<?php  
class database{
	private $dns = "mysql:host=bwsmc7iunmi6rxbcac75-mysql.services.clever-cloud.com;dbname=bwsmc7iunmi6rxbcac75";
	private $username = "ug6prs968jfluxoq";
	private $password = "r0qSagbxdaC0sQ6eHVJt";
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