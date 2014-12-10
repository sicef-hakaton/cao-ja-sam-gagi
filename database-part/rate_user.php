<?php

// array for JSON response
$response = array();

// check for required fields
if (
		isset($_GET['teacher_id']) && isset($_GET['value'])
   ) 
{
    
    $teacher_id= $_GET['teacher_id'];
    $value = $_GET['value'];

    // include db connect class
    require_once dirname(__FILE__) . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();
	if($value == 1)
	 $result = mysql_query(" UPDATE users SET vote_up = vote_up + 1 WHERE id = '$teacher_id' ");
	else if($value == -1)
	 $result = mysql_query(" UPDATE users SET vote_down = vote_down + 1 WHERE id = '$teacher_id' ");
	else
	{
		// success
		$response["success"] = 0;
		$response["message"] = "Something went wrong";

		// echoing JSON response
		echo json_encode($response);
		die();
	}
	
    // success
    $response["success"] = 1;
    $response["message"] = "Success";

    // echoing JSON response
    echo json_encode($response);
} 
else 
{
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>