<?php  
class category{
	private $conn;
	private $table = "blog_category";

	//Blog Categories Properties
	public $n_category_id;
	public $v_category_title;
	public $v_category_meta_title;
	public $v_category_path;
	public $d_date_created;
	public $d_time_created;

	public function __construct($db){
		$this->conn = $db;
	}

	public function read(){
		$sql = "SELECT * FROM $this->table";

		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		return $stmt;
	}

	//Read one record
	public function read_single(){
		$sql = "SELECT * FROM $this->table WHERE n_category_id = :get_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_id',$this->n_category_id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//Set Properties
		$this->n_category_id = $row['n_category_id'];
		$this->v_category_title = $row['v_category_title'];
		$this->v_category_meta_title = $row['v_category_meta_title'];
		$this->v_category_path = $row['v_category_path'];
		$this->d_date_created = $row['d_date_created'];
		$this->d_time_created = $row['v_date_created'];
	}

	public function create(){
		//Create query
		$query = "INSERT INTO $this->table
		          SET v_category_title = :category_title,
		          	  v_category_meta_title = :category_meta_title,
		          	  v_category_path = :category_path,
		          	  d_date_created = :date_created,
		          	  d_time_created = :time_created";		
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->v_category_title = htmlspecialchars(strip_tags($this->v_category_title));
		$this->v_category_meta_title = htmlspecialchars(strip_tags($this->v_category_meta_title));
		$this->v_category_path = htmlspecialchars(strip_tags($this->v_category_path));

		//Bind data
		$stmt->bindParam(':category_title',$this->v_category_title);
		$stmt->bindParam(':category_meta_title',$this->v_category_meta_title);
		$stmt->bindParam(':category_path',$this->v_category_path);
		$stmt->bindParam(':date_created',$this->d_date_created);
		$stmt->bindParam(':time_created',$this->d_time_created);

		//Execute query
		if($stmt->execute()){
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;
	}

	//Update category
	public function update(){
		//Create query
		$query = "UPDATE $this->table
		          SET v_category_title = :category_title,
		          	  v_category_meta_title = :category_meta_title,
		          	  v_category_path = :category_path,
		          	  d_date_created = :date_created,
		          	  d_time_created = :time_created
		          WHERE 
		          	  n_category_id = :get_id";
		//Prepare statement
		$stmt = $this->conn->prepare($query);
		//Clean data
		$this->v_category_title = htmlspecialchars(strip_tags($this->v_category_title));
		$this->v_category_meta_title = htmlspecialchars(strip_tags($this->v_category_meta_title));
		$this->v_category_path = htmlspecialchars(strip_tags($this->v_category_path));
		//Bind data
		$stmt->bindParam(':get_id',$this->n_category_id);
		$stmt->bindParam(':category_title',$this->v_category_title);
		$stmt->bindParam(':category_meta_title',$this->v_category_meta_title);
		$stmt->bindParam(':category_path',$this->v_category_path);
		$stmt->bindParam(':date_created',$this->d_date_created);
		$stmt->bindParam(':time_created',$this->d_time_created);
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
		          WHERE n_category_id = :get_id";
		
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->n_category_id = htmlspecialchars(strip_tags($this->n_category_id));

		//Bind data
		$stmt->bindParam(':get_id',$this->n_category_id);

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