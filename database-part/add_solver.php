<?php

// array for JSON response
$response = array();

// check for required fields
if (
		isset($_GET['solver_id']) && isset($_GET['problem_id'])
   ) 
{
    
	$solver_id = $_GET['solver_id'];
	$problem_id = $_GET['problem_id'];
	
    // include db connect class
    require_once dirname(__FILE__) . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // mysql inserting a new row
    $result = mysql_query("INSERT INTO solvers(solver_id, problem_id) 
	VALUES('$solver_id', '$problem_id')");

    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Success";

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