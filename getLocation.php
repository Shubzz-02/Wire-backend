<?php
$response = array();
include 'db/db_connect.php';
include 'function.php';

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON,TRUE);	

if(isset($input['username']) && isset($input['full_name']) && isset($input['key'])){
	$username = $input['username'];
	$full_name = $input['full_name'];
	$key	  = $input['key'];
	$query	  = "SELECT tracking.Longitude, tracking.Latitude FROM member, tracking WHERE member.username = ? AND tracking.uq_key = ? AND member.full_name = ? AND tracking.user_id = member.user_id";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("sss",$username,$key,$full_name);
		$stmt->execute();
		$stmt->bind_result($latitude,$longitude);
		//echo $latitude." ".$longitude;
		if($stmt->fetch()){
			$response["Latitude"] = $latitude;
            $response["Longitude"] = $longitude;
            $response["status"] = 0;
            $response["message"] = "Details";
		}else{
			$response["status"] = 1;
            $response["message"] = "Invalid username and full_name combination or Invalid Key";
        }
        $stmt->close();
	}
}else{
	$response["status"] = 2;
    $response["message"] = "Missing mandatory parameters";
}
echo json_encode($response);
?>
