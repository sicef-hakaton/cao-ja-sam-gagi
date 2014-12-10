<?php

// array for JSON response
$response = array();

// check for required fields
if (
		isset($_GET['begin_time']) && isset($_GET['duration']) && isset($_GET['teacher_id']) &&
		isset($_GET['cost']) && isset($_GET['max_users']) && isset($_GET['description'])
   ) 
{
    
    $cur_unix = strtotime(date('Y-m-d H:i:s'));
	$begin_time = $_GET['begin_time'];
	$duration = $_GET['duration'];
	$teacher_id = $_GET['teacher_id'];
	$cost = $_GET['cost'];
	$max_users = $_GET['max_users'];
	$description = $_GET['description'];
	
    // include db connect class
    require_once dirname(__FILE__) . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

	if($cur_unix > $begin_time)
	{
		// invalid values
		$response["success"] = 0;
		$response["message"] = "It can't start before now.";

		// echoing JSON response
		echo json_encode($response);
		
		die();
	}
	
    // mysql inserting a new rowase
        $response["success"] = 1;
        $response["message"] = "Success";
    $result = mysql_query("INSERT INTO lectures(begin_time, duration, teacher_id, cost, max_users, description) 
	VALUES('$begin_time', '$duration', '$teacher_id', '$cost', '$max_users', '$description')");

    if ($result) {
        // successfully inserted into datab

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
        
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>