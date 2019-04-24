<?php 
$host='localhost';
$user='root';
$pass="";
$db='vuejsdb';

$conn = new mysqli($host,$user,$pass,$db);

if ($conn -> connect_error) {
	die("connect error");
}
$res= array('error' =>false);

$action="read";


if (isset($_GET['action'])) {
	$action = $_GET['action'];
}

if ($action=="read") {
	$result=$conn->query("SELECT * FROM `userstable`");
	$users=array();
	while ($row = $result->fetch_assoc()) {
		array_push($users, $row);
	}

	$res['users'] =$users;
}
// Create form

if ($action == "create") {

		$fistname = $_POST['fistname'];
		$lastname = $_POST['lastname'];
		$username = $_POST['username'];

	
	$result = $conn->query("INSERT INTO userstable( fistname, lastname, username) VALUES ('$fistname','$lastname','$username')");


	if ($result) {
		$res['message']="user added successfully";
	}
	else{
		$res['error']=true;
		$res['message']="user not added successfully";
	}

	// $res['users'] =$users;
}
// end of create form

// update form

if ($action == "update") {
		$usersTable_id = $_POST['usersTable_id'];
		$fistname = $_POST['fistname'];
		$lastname = $_POST['lastname'];
		$username = $_POST['username'];
	
	$result = $conn->query("UPDATE userstable SET fistname ='$fistname',lastname ='$lastname',username= '$username' WHERE usersTable_id ='$usersTable_id' ");


	if ($result) {
		$res['message']="user updated successfully";
	}
	else{
		$res['error']=true;
		$res['error']="user not updated successfully";
	}	
}

// end of update form

if ($action == "delete") {
		$usersTable_id = $_POST['usersTable_id'];

	$result = $conn->query("DELETE FROM `userstable` WHERE usersTable_id ='$usersTable_id' ");


	if ($result) {
		$res['message']="user deleted successfully";
	}
	else{
		$res['error']=true;
		$res['message']="user not deleted successfully";
	}
	 // $res['users'] =$users;
}

$conn ->close();
header("content-type:application/json");
echo json_encode($res);
die();
?>