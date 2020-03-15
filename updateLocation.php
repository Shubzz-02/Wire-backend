<?php
$response = array();
include 'db/db_connect.php';
include 'functions.php';
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON,TRUE);
if(isset($input['username']) && isset($input['full_name']) && isset($input['key']) && isset($input['Latitude']) && isset($input['Longitude'])){
	$username = $input['username'];
	$full_name = $input['full_name'];
	$key = $input['key'];
	$latitude = $input['Latitude'];
	$Longitude = $input['Longitude'];
	$updatequery = "UPDATE member, tracking SET tracking.Latitude = ?, tracking.Longitude = ? WHERE member.username= ? and tracking.uq_key= ? and member.full_name= ? and tracking.user_id = member.user_id";
	if($stmt = $con->prepare($updatequery)){
		$stmt->bind_param("sssss",$latitude,$Longitude,$username,$key,$full_name);
		$stmt->execute();
		$response["status"] = 0;
		$response["message"] = "successful";
	}
	$stmt->close();
}else{
	$response["status"] = 2;
	$response["message"] = "Missing mandatory parameters";
}
echo json_encode($response);
?>
