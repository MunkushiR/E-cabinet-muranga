<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where personal_number = '".$personal_number."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where personal_number = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:main.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", personal_number = '$personal_number' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	
	function save_password(){
		extract($_POST);
		$data .= ", personal_number = '$personal_number' ";
		$data .= ", password = '$password' ";
		if(empty($personal_number)){
			$save = $this->db->query("INSERT INTO register set ".$data);
		}else{
			$save = $this->db->query("UPDATE register set ".$data." where personal_number = ".$personal_number);
		}
		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
			}
			return 1;
		}
	}
	function save_meeting(){
		$conn = $this->db;
		
		// Escape and sanitize POST data
		$type = $conn->real_escape_string($_POST['type']);
		$title = $conn->real_escape_string($_POST['title']);
		$date = $conn->real_escape_string($_POST['date']);
		$time = $conn->real_escape_string($_POST['time']);
		$present_members = $conn->real_escape_string($_POST['present_members']);
		$agenda = $conn->real_escape_string($_POST['agenda']);
		$absent = $conn->real_escape_string($_POST['absent']);
		$attendees = $conn->real_escape_string($_POST['attendees']);
		$content = $conn->real_escape_string($_POST['content']);
		$signed_by = $conn->real_escape_string($_POST['signed_by']);
		$id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : '';
		
		// Prepare the data string for the SQL query
		$data = "type='$type', ";
		$data .= "title='$title', ";
		$data .= "date='$date', ";
		$data .= "time='$time', ";
		$data .= "present_members='$present_members', ";
		$data .= "agenda='$agenda', ";
		$data .= "absent='$absent', ";
		$data .= "attendees='$attendees', ";
		$data .= "content='$content', ";
		$data .= "signed_by='$signed_by'";
		
		// Handle file upload if exists
		if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
			$fileTmpPath = $_FILES['file']['tmp_name'];
			$fileName = $conn->real_escape_string($_FILES['file']['name']);
			$destinationPath = 'downloads/' . basename($fileName);
			
			// Attempt to move the uploaded file to the destination directory
			if (move_uploaded_file($fileTmpPath, $destinationPath)) {
				$data .= ", file='$destinationPath'";
			} else {
				error_log("Failed to move uploaded file to $destinationPath");
				echo json_encode(['status' => 0, 'message' => 'Failed to move uploaded file']);
				return;
			}
		} else if (isset($_FILES['file']) && $_FILES['file']['error'] != UPLOAD_ERR_NO_FILE) {
			error_log("File upload error: " . $_FILES['file']['error']);
			echo json_encode(['status' => 0, 'message' => 'File upload error']);
			return;
		}
		
		// Determine if the operation is an insert or update
		if (empty($id)) {
			$query = "INSERT INTO meetings SET $data";
		} else {
			$query = "UPDATE meetings SET $data WHERE id = $id";
		}
	
		// Execute the query
		if ($conn->query($query)) {
			echo json_encode(['status' => 1, 'message' => 'Meeting successfully saved']);
		} else {
			error_log("Database Query Error: " . $conn->error);
			echo json_encode(['status' => 0, 'message' => 'An error occurred while saving data']);
		}
	}
	
	
	function delete_meeting(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM meetings where id = ".$id);
		if($delete)
			return 1;
	}
	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_employee(){
		// Extract POST variables
		extract($_POST);
	
		// Check if the ID is set
		$id = isset($id) ? intval($id) : null;
	
		// Prepare the SQL statement
		if (empty($id)) {
			// Insert query
			$query = "INSERT INTO employees (firstname, lastname, personal_number, position, work_email, phonenumber, national_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$stmt = $this->db->prepare($query);
			if ($stmt === false) {
				error_log("Failed to prepare the SQL statement: " . $this->db->error);
				return 0;
			}
			$stmt->bind_param('sssssss', $firstname, $lastname, $personal_number, $position, $work_email, $phonenumber, $national_id);
		} else {
			// Update query
			$query = "UPDATE employees SET firstname = ?, lastname = ?, personal_number = ?, position = ?, work_email = ?, phonenumber = ?, national_id = ? WHERE id = ?";
			$stmt = $this->db->prepare($query);
			if ($stmt === false) {
				error_log("Failed to prepare the SQL statement: " . $this->db->error);
				return 0;
			}
			$stmt->bind_param('sssssssi', $firstname, $lastname, $personal_number, $position, $work_email, $phonenumber, $national_id, $id);
		}
	
		// Execute the query
		$result = $stmt->execute();
		if ($result) {
			$stmt->close();
			return 1;
		} else {
			error_log("Failed to execute the SQL statement: " . $stmt->error);
			$stmt->close();
			return 0;
		}
	}
	
	function delete_employee(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM employees where id = ".$id);
		if($delete)
			return 1;
	}
	function save_minutes() {
		// Ensure POST variables are defined
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$date = isset($_POST['date']) ? $_POST['date'] : '';
		$location = isset($_POST['location']) ? $_POST['location'] : '';
		$time = isset($_POST['time']) ? $_POST['time'] : '';
		$attendees = isset($_POST['attendees']) ? $_POST['attendees'] : [];
		$agenda = isset($_POST['agenda']) ? $_POST['agenda'] : ''; // New agenda field
		$id = isset($_POST['id']) ? $_POST['id'] : null;
	
		// Sanitize and prepare each field for the query
		$type = $this->db->real_escape_string($type);
		$date = $this->db->real_escape_string($date);
		$location = $this->db->real_escape_string($location);
		$time = $this->db->real_escape_string($time);
		$agenda = $this->db->real_escape_string($agenda); // Sanitize agenda field
	
		// Process attendees: Convert array to a comma-separated string
		if (is_array($attendees)) {
			$attendees = array_map([$this->db, 'real_escape_string'], $attendees);
			$attendees = implode(', ', $attendees);
		} else {
			$attendees = ''; // Default to an empty string if no attendees
		}
	
		// Construct the data string for the query
		$data = "type = '$type', date = '$date', location = '$location', time = '$time', attendees = '$attendees', agenda = '$agenda'"; // Include agenda field
	
		// Handle file upload if exists
		if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
			$fileTmpPath = $_FILES['file']['tmp_name'];
			$fileName = $this->db->real_escape_string($_FILES['file']['name']);
			$destinationPath = 'downloads/' . $fileName;
	
			// Attempt to move the uploaded file to the destination directory
			if (move_uploaded_file($fileTmpPath, $destinationPath)) {
				$data .= ", file='$destinationPath'";
			} else {
				error_log("Failed to move uploaded file to $destinationPath");
				return 0;
			}
		} else if (isset($_FILES['file']) && $_FILES['file']['error'] != UPLOAD_ERR_NO_FILE) {
			error_log("File upload error: " . $_FILES['file']['error']);
			return 0;
		}
	
		// Determine if the operation is an insert or update
		if (empty($id)) {
			$query = "INSERT INTO minutes SET $data";
		} else {
			$id = $this->db->real_escape_string($id);
			$query = "UPDATE minutes SET $data WHERE id = $id";
		}
	
		// Execute the query
		if ($this->db->query($query)) {
			return 1;
		} else {
			error_log("Database Query Error: " . $this->db->error);
			return 0;
		}
	}
	
	
	function delete_minutes(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM minutes where id = ".$id);
		if($delete)
			return 1;
	}
	
	
	function save_department(){
		extract($_POST);
		$data =" name='$name' ";
		

		if(empty($id)){
			$save = $this->db->query("INSERT INTO department set ".$data);
		}else{
			$save = $this->db->query("UPDATE department set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_department(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM department where id = ".$id);
		if($delete)
			return 1;
	}
	
	function save_departmental(){
		extract($_POST);
		$data =" name='$name' ";
		

		if(empty($id)){
			$save = $this->db->query("INSERT INTO departmental set ".$data);
		}else{
			$save = $this->db->query("UPDATE departmental set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_departmental(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM departmental where id = ".$id);
		if($delete)
			return 1;
	}
	function save_cabinets(){
		extract($_POST);
		$data =" name='$name' ";
		

		if(empty($id)){
			$save = $this->db->query("INSERT INTO cabinets set ".$data);
		}else{
			$save = $this->db->query("UPDATE cabinets set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_cabinets(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM cabinets where id = ".$id);
		if($delete)
			return 1;
	}
	function save_employee_attendance(){
		extract($_POST);
		
		foreach($employee_id as $k =>$v){
			$datetime_log[$k] =date("Y-m-d H:i",strtotime($datetime_log[$k]));
			$data =" employee_id='$employee_id[$k]' ";
			$data .=", log_type = '$log_type[$k]' ";
			$data .=", datetime_log = '$datetime_log[$k]' ";
			$save[] = $this->db->query("INSERT INTO attendance set ".$data);
		}

		if(isset($save))
			return 1;
	}
	function delete_employee_attendance(){
		extract($_POST);
		$date = explode('_',$id);
		$dt = date("Y-m-d",strtotime($date[1]));
 
		$delete = $this->db->query("DELETE FROM attendance where employee_id = '".$date[0]."' and date(datetime_log) ='$dt' ");
		if($delete)
			return 1;
	}
	function delete_employee_attendance_single(){
		extract($_POST);
		
 
		$delete = $this->db->query("DELETE FROM attendance where id = $id ");
		if($delete)
			return 1;
	}
	function remove_attendance(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM attendance where id = ".$id);
		if($delete)
			return 1;
	}
	function save_position(){
		extract($_POST);
		$data =" name='$name' ";
		$data .=", department_id = '$department_id' ";
		

		if(empty($id)){
			$save = $this->db->query("INSERT INTO position set ".$data);
		}else{
			$save = $this->db->query("UPDATE position set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	
		}
	
	