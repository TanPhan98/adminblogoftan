<?php  
class blog{
	public $conn;
	private $table = "blog_post";

	//Blog Categories Properties
	public $n_blog_post_id;
	public $n_category_id;
	public $v_post_title;
	public $v_post_meta_title;
	public $v_post_path;
	public $v_post_summary;
	public $v_post_content;
	public $v_main_image_url;
	public $v_alt_image_url;
	public $n_blog_post_views;
	public $n_home_page_place;
	public $f_post_status;
	public $d_date_created;
	public $d_time_created;
	public $d_date_updated;
	public $d_time_updated;


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
		$sql = "SELECT * FROM $this->table WHERE n_blog_post_id = :get_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_id',$this->n_blog_post_id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//Set Properties
		$this->n_blog_post_id = $row['n_blog_post_id'];
		$this->n_category_id = $row['n_category_id'];
		$this->v_post_title = $row['v_post_title'];
		$this->v_post_meta_title = $row['v_post_meta_title'];
		$this->v_post_path = $row['v_post_path'];
		$this->v_post_summary = $row['v_post_summary'];
		$this->v_post_content = $row['v_post_content'];
		$this->v_main_image_url = $row['v_main_image_url'];
		$this->v_alt_image_url = $row['v_alt_image_url'];
		$this->n_blog_post_views = $row['n_blog_post_views'];
		$this->n_home_page_place = $row['n_home_page_place'];
		$this->f_post_status = $row['f_post_status'];
		$this->d_date_created = $row['d_date_created'];
		$this->d_time_created = $row['d_time_created'];
		$this->d_date_updated = $row['d_date_updated'];
		$this->d_time_updated = $row['d_time_updated'];
	}
	//create
		public function create(){
		//Create query
		$query = "INSERT INTO $this->table
		          SET 
		          	  v_post_title = :post_title,
		          	  v_post_meta_title = :post_meta_title,
		          	  n_category_id = :category_id,
		          	  v_main_image_url = :main_image,
		          	  v_alt_image_url = :alt_image,
		          	  v_post_summary = :post_summary,
		          	  v_post_content = :post_content,
		          	  v_post_path = :post_path,
		          	  n_home_page_place = :home_page_place,
		          	  n_blog_post_views = :blog_post_views,
		          	  f_post_status = :blog_post_status,
		          	  d_date_created = :date_created,
		          	  d_time_created = :time_created";		
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->v_post_title = htmlspecialchars(strip_tags($this->v_post_title));
		$this->v_post_meta_title = htmlspecialchars(strip_tags($this->v_post_meta_title));
		$this->v_post_path = htmlspecialchars(strip_tags($this->v_post_path));
		$this->v_post_summary = htmlspecialchars(strip_tags($this->v_post_summary));
		$this->v_post_content = htmlspecialchars(strip_tags($this->v_post_content));

		//Bind data
		$stmt->bindParam(':post_title',$this->v_post_title);
		$stmt->bindParam(':post_meta_title',$this->v_post_meta_title);
		$stmt->bindParam(':category_id',$this->n_category_id);
		$stmt->bindParam(':main_image',$this->v_main_image_url);
		$stmt->bindParam(':alt_image',$this->v_alt_image_url);
		$stmt->bindParam(':post_summary',$this->v_post_summary);
		$stmt->bindParam(':post_content',$this->v_post_content);
		$stmt->bindParam(':post_path',$this->v_post_path);
		$stmt->bindParam(':home_page_place',$this->n_home_page_place);
		$stmt->bindParam(':blog_post_views',$this->n_blog_post_views);
		$stmt->bindParam(':blog_post_status',$this->f_post_status);		
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

	//update
	public function update(){
		//Create query
		$sql = "UPDATE $this->table
		          SET n_category_id = :category_id,
		          	  v_post_title = :blog_title,
		          	  v_post_meta_title = :blog_meta_title,
		          	  v_post_path = :blog_path,
		          	  v_post_summary = :post_summary,
		          	  v_post_content = :post_content,
		          	  v_main_image_url = :main_image_url,
		          	  v_alt_image_url = :alt_image_url,
		          	  n_blog_post_views = :blog_post_views,
		          	  n_home_page_place = :home_page_place,
		          	  f_post_status = :post_status,
		          	  d_date_created = :date_created,
		          	  d_time_created = :time_created,
		          	  d_date_updated = :date_updated,
		          	  d_time_updated = :time_updated
		          WHERE n_blog_post_id = :get_blog_post_id ";

		$stmt = $this->conn->prepare($sql);

		//Clean data
		$this->v_post_title = htmlspecialchars(strip_tags($this->v_post_title));
		$this->v_post_meta_title = htmlspecialchars(strip_tags($this->v_post_meta_title));
		$this->v_post_path = htmlspecialchars(strip_tags($this->v_post_path));
		$this->v_post_summary = htmlspecialchars(strip_tags($this->v_post_summary));
		$this->v_post_content = htmlspecialchars(strip_tags($this->v_post_content));
		$this->v_main_image_url = htmlspecialchars(strip_tags($this->v_main_image_url));
		$this->v_alt_image_url = htmlspecialchars(strip_tags($this->v_alt_image_url));

		$stmt->bindParam(':get_blog_post_id',$this->n_blog_post_id);
		$stmt->bindParam(':category_id',$this->n_category_id);
		$stmt->bindParam(':blog_title',$this->v_post_title);
		$stmt->bindParam(':blog_meta_title',$this->v_post_meta_title);
		$stmt->bindParam(':blog_path',$this->v_post_path);
		$stmt->bindParam(':post_summary',$this->v_post_summary);
		$stmt->bindParam(':post_content',$this->v_post_content);
		$stmt->bindParam(':main_image_url',$this->v_main_image_url);
		$stmt->bindParam(':alt_image_url',$this->v_alt_image_url);
		$stmt->bindParam(':blog_post_views',$this->n_blog_post_views);
		$stmt->bindParam(':home_page_place',$this->n_home_page_place);
		$stmt->bindParam(':post_status',$this->f_post_status);
		$stmt->bindParam(':date_created',$this->d_date_created);
		$stmt->bindParam(':time_created',$this->d_time_created);
		$stmt->bindParam(':date_updated',$this->d_date_updated);
		$stmt->bindParam(':time_updated',$this->d_time_updated);

		if ($stmt->execute()) {
			return true;
		}
		printf("Error: %s. \n", $stmt->error);
		return false;
	}


	//Delete
	public function delete(){

		//Create query
		$query = "DELETE FROM $this->table
		          WHERE n_blog_post_id = :get_blog_post_id";
		
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->n_blog_post_id = htmlspecialchars(strip_tags($this->n_blog_post_id));

		//Bind data
		$stmt->bindParam(':get_blog_post_id',$this->n_blog_post_id);

		//Execute query
		if($stmt->execute()){
			return true;
		}

		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;

	}
	public function last_id(){
		return $this->conn->lastInsertId();
	}
}

?>