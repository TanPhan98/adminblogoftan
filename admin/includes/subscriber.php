<?php  
class subscribe{

	//DB Stuff
	private $conn;
	private $table = "blog_subscriber";

	//Blog Subscriber Properties
	public $n_sub_id;
	public $v_sub_email;
	public $d_date_created;
	public $d_time_created;
	public $f_sub_status;
		
	//Constructor with DB
	public function __construct($db){
		$this->conn = $db;
	}

	//Read multi records
	public function read(){
		$sql = "SELECT * FROM $this->table";

		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		return $stmt;
	}

	//Read one record
	public function read_single(){
		$sql = "SELECT * FROM $this->table 
				WHERE n_sub_id = :get_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_id',$this->n_sub_id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//Set Properties
		$this->n_sub_id = $row['n_sub_id'];
		$this->v_sub_email = $row['v_sub_email'];
		$this->d_date_created = $row['d_date_created'];
		$this->d_time_created = $row['d_time_created'];
		$this->f_sub_status = $row['f_sub_status'];
		
	}

	//Create Subscriber
	public function create(){
		//Create query
		$query = "INSERT INTO $this->table
		          SET v_sub_email = :email,
		          	  d_date_created = :date_create,
		          	  d_time_created = :time_create,
		          	  f_sub_status = :sub_status";

		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->v_sub_email = htmlspecialchars(strip_tags($this->v_sub_email));
		
		//Bind data
		$stmt->bindParam(':email',$this->v_sub_email);
		$stmt->bindParam(':date_create',$this->d_date_created);
		$stmt->bindParam(':time_create',$this->d_time_created);
		$stmt->bindParam(':sub_status',$this->f_sub_status);


				
		//Execute query
		if($stmt->execute()){
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;
	}

	//Delete category
	public function delete(){

		//Create query
		$query = "DELETE FROM $this->table
		          WHERE n_sub_id = :get_id";
		
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->n_sub_id = htmlspecialchars(strip_tags($this->n_sub_id));

		//Bind data
		$stmt->bindParam(':get_id',$this->n_sub_id);

		//Execute query
		if($stmt->execute()){
			return true;
		}

		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;

	}
}
?>

